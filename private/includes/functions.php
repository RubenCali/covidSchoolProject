<?php
// Dit bestand hoort bij de router, enb bevat nog een aantal extra functiesdie je kunt gebruiken
// Lees meer: https://github.com/skipperbent/simple-php-router#helper-functions
require_once __DIR__ . '/route_helpers.php';

// Hieronder kun je al je eigen functies toevoegen die je nodig hebt
// Maar... alle functies die gegevens ophalen uit de database horen in het Model PHP bestand

/**
 * Verbinding maken met de database
 * @return \PDO
 */
function dbConnect() {

	$config = get_config('DB');

	try {
		$dsn = 'mysql:host=' . $config['HOSTNAME'] . ';dbname=' . $config['DATABASE'] . ';charset=utf8';

		$connection = new PDO( $dsn, $config['USER'], $config['PASSWORD'] );

		$connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$connection->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );

		return $connection;

	} catch ( \PDOException $e ) {
		echo 'Fout bij maken van database verbinding: ' . $e->getMessage();
		exit;
	}

}

/**
 * Geeft de juiste URL terug: relatief aan de website root url
 * Bijvoorbeeld voor de homepage: echo url('/');
 *
 * @param $path
 *
 * @return string
 */
function site_url( $path = '' ) {
	return get_config( 'BASE_URL' ) . $path;
}
function absolute_url( $path = '' ) {
	return get_config( 'BASE_HOST' ) . $path;
}

function get_config( $name ) {
	$config = require __DIR__ . '/config.php';
	$name = strtoupper( $name );

	if ( isset( $config[ $name ] ) ) {
		return $config[$name];
	}

	throw new \InvalidArgumentException( 'Er bestaat geen instelling met de key: ' . $name );
}

/**
 * Hier maken we de template engine en vertellen de template engine waar de templates/views staan
 * @return \League\Plates\Engine
 */
function get_template_engine() {

	$templates_path = get_config( 'PRIVATE' ) . '/views';

	return new League\Plates\Engine( $templates_path );

}

function validateRegistrationData($data){

	$errors = [];

	// Checks: valideren of email echt een geldig email is
	$email      = filter_var( $data['email'], FILTER_VALIDATE_EMAIL );
	$password = trim( $data['password'] );

	if ( $email === false ) {
		$errors['email'] = 'This is no valid email';
	}

	// Checks: wachtwoord minimaal 6 tekens bevat
	if ( strlen( $password ) < 6 ) {
		$errors['password'] = 'no valid password (min 6 characters)';
	}

	// Resultaat array
	$data = [
		'email' => $data['email'],
		'password' => $password
	];

	return [
		'data' => $data,
		'errors' => $errors
	];

}
function userNotRegistered($email){

	// Checken of de gebruiker al bestaat
	$connection = dbConnect();
	$sql        = "SELECT * FROM `users` WHERE `email` = :email";
	$statement  = $connection->prepare( $sql );
	$statement->execute( [ 'email' => $email ] );

	return ($statement->rowCount() === 0);

}

function createUser($email, $password){

	$connection = dbConnect();

	//Als die er niet is, dan verder met opslaan
	$sql           = "INSERT INTO `users` (`email`, `password`) VALUES (:email, :password)";
	$statement     = $connection->prepare( $sql );
	$safe_password = password_hash( $password, PASSWORD_DEFAULT );
	$params        = [
		'email'      => $email,
		'password' => $safe_password
	];
	$statement->execute( $params );

}
function loginUser($user){
	$_SESSION['user_id'] = $user['id'];
}
function logoutUser(){
	unset($_SESSION['user_id']);
}
function isLoggedIn(){
	return !empty( $_SESSION['user_id']);
}
function loginCheck(){
	if ( ! isLoggedIn() ) {
		$login_url = url('login');
		redirect($login_url);
	}
}

/**
 * Maak de SwiftMailer aan en stet hem op de juiste manier in
 *
 * @return Swift_Mailer
 */
function getSwiftMailer() {
	$mail_config = get_config( 'MAIL' );
	$transport   = new \Swift_SmtpTransport( $mail_config['SMTP_HOST'], $mail_config['SMTP_PORT'] );
	$transport->setUsername( $mail_config['SMTP_USER'] );
	$transport->setPassword( $mail_config['SMTP_PASSWORD'] );

	$mailer = new \Swift_Mailer( $transport );

	return $mailer;
}

/**
 * Maak een Swift_Message met de opgegeven subject, afzender en ontvanger
 *
 * @param $to
 * @param $subject
 * @param $from_name
 * @param $from_email
 *
 * @return Swift_Message
 */
function createEmailMessage( $to, $subject, $from_name, $from_email ) {

	// Create a message
	$message = new \Swift_Message( $subject );
	$message->setFrom( [ $from_email => $from_email ] );
	$message->setTo( $to );

	// Send the message
	return $message;
}

/**
 *
 * @param $message \Swift_Message De Swift Message waarin de afbeelding ge-embed moet worden
 * @param $filename string Bestandsnaam van de afbeelding (wordt automatisch uit juiste folder gehaald)
 *
 * @return mixed
 */
function embedImage( $message, $filename ) {
	$image_path = get_config( 'WEBROOT' ) . '/images/email/' . $filename;
	if ( ! file_exists( $image_path ) ) {
		throw new \RuntimeException( 'Afbeelding bestaat niet: ' . $image_path );
	}

	if ( $message ) {
		$cid = $message->embed( \Swift_Image::fromPath( $image_path ) );

		return $cid;
	}

	return site_url( '/images/email/' . $filename );

}

function sendPasswordResetEmail($email){
	$reset_code = md5(uniqid(rand(), true));
	$connection = dbConnect();
	$sql = "UPDATE `users` SET `password_reset` = :code WHERE `email` = :email";
	$statement = $connection->prepare($sql);
	$params = [
		'code' => $reset_code,
		'email' => $email
	];
	$statement->execute($params);
	
	$url = url('password.reset', ['reset_code' => $reset_code]);
	$absolute_url = absolute_url($url);

	$mailer = getSwiftMailer();
	$message = createEmailMessage( $email, 'Password reset', 'StayActive website', 'joey.kuijl@outlook.com' );

	$email_text = 'Hello, confirm your password change: <a href="' . $absolute_url . '">Click Here</a>';

	$message->setBody( $email_text, 'text/html');
	$mailer->send( $message);
}