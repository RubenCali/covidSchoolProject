<?php

namespace Website\Controllers;

/**
 * Class HomeController
 *
 * Deze handelt de logica van de homepage af
 * Haalt gegevens uit de "model" laag van de website (de gegevens)
 * Geeft de gegevens aan de "view" laag (HTML template) om weer te geven
 *
 */
class WebsiteController
{



	public function registerHandle()
	{
		$errors = [];

		$email		= filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
		$password	=trim($_POST['password']);

		if ( $email === false ) {
			$errors['email'] = 'There is no email';
		}

		if (strlen($password) < 6 ){
			$errors['password'] = 'no valid password (min 6 characters)';
		}	

		if (count($errors) === 0){
			$connection = dbConnect();
			$sql = "SELECT * FROM `users` WHERE `email` = :email";
			$statement = $connection->prepare($sql);
			$statement->execute( ['email' => $email]);
		
		if ($statement->rowCount() === 0){
			$sql = "INSERT INTO `users` (`email`, `password`) VALUES (:email, :password)";
			$statement = $connection->prepare($sql);
			$safe_password = password_hash($password, PASSWORD_DEFAULT);
			$params	= [
				'email' => $email,
				'password' => $safe_password
			];
			$statement->execute($params);
			$doneUrl = url('login');
			redirect($doneUrl);
		}
	}
		else{
			$errors['email'] = 'this account already exists';
		}

		$template_engine = get_template_engine();
		echo $template_engine->render('registration', ['errors' => $errors]);
	}

	public function loginHandle()
	{
		$result = validateRegistrationData($_POST);

		if(userNotRegistered($result ['data']['email'] ) ) {
			$result['errors']['email'] ='This user does not exsist';
		} else{
			$user = getUserByEmail($result['data']['email']);

			if(password_verify($result['data']['password'], $user['password'])){

				loginUser($user);

				redirect(url('geinlogdepagina'));

			}else{
				$result['errors']['password'] ='Password not true';
			}
		}

		$template_engine = get_template_engine();
		echo $template_engine->render('login', ['errors' => $result['errors']]);
	}

	public function login()
	{
		$template_engine = get_template_engine();
		echo $template_engine->render('login');
	}

	public function register()
	{
		$template_engine = get_template_engine();
		echo $template_engine->render('registration');
	}
	
	public function geinlogdepagina()
	{
		loginCheck();
		$sports = getAllSports();

		$template_engine = get_template_engine();
		echo $template_engine->render('geinlogdepagina', ['sports' => $sports]);
	}
	public function naarLogin(){
		redirect(url('login'));
	}
	public function logout()
	{ 
		logoutUser();		 
		redirect(url('login'));
	}
	public function settings() {
		loginCheck();
		$user = getUserById($_SESSION['user_id']);

		$template_engine = get_template_engine();
		echo $template_engine->render('settings',['user' => $user]);
		
	}
	public function schema($sport_id)
	{
		loginCheck();
		$schemaCondition = getSportSchema($sport_id, 'condition');
		$schemaStrength = getSportSchema($sport_id, 'strength');
		$sport = getSport($sport_id);
		$template_engine = get_template_engine();
		echo $template_engine->render('schema', ['condition' => $schemaCondition, 'strength' => $schemaStrength, 'sport' => $sport]);
		
	}
	public function search(){

		$sports = searchSports($_POST['search']);

		$template_engine = get_template_engine();
		echo $template_engine->render('geinlogdepagina', ['sports' => $sports]);
	}
	public function passwordForgottenForm(){

		$errors = [];
		$mail_sent = false;

		if( request()->getMethod() === 'post'){
			$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
			if($email ===false){
				$errors['email'] = 'Not a valid email';
			}
			if( count($errors) === 0) {
				$user = getUserByEmail($email);
				if ( $user === false){
					$errors['email'] = 'not exsisting account';
				}
			}
			if(count($errors) === 0){
				sendPasswordResetEmail($email);
				$mail_sent = true;
			}
		}

		$template_engine = get_template_engine();
		echo $template_engine->render('password_forgotten', [ 'errors' => $errors, 'mail_sent' => $mail_sent]);
	}
	public function passwordResetForm($reset_code){

		$errors =[];
			$user = getUserByResetCode($reset_code);
			if( $user === false){
				echo "Not a valid code";
				exit;
			}
			if( request()->getMethod() === 'post'){

				$password = $_POST['password'];
				$password_confirm = $_POST['password_confirm'];

				if(strlen($password) < 6){
					$errors['password'] = 'Password needs at least 6 characters';
				}
				if(count($errors) === 0){
					if( $password !== $password_confirm) {
						$errors['password'] = 'the passwords are not the same';
					}
				}
				if(count($errors) === 0){

					$result = updatePassword($user['id'], $password);
					if($result === true){
						redirect(url('login'));
					}else{
						$errors['password'] = 'Something went wrong with saving the password try again';
					}
				}
			}
		$template_engine = get_template_engine();
		echo $template_engine->render('reset_form', [ 'errors' => $errors, 'reset_code' => $reset_code]);
	}
	

}
// $result = validateRegistrationData( $_POST);
// if( userNotRegistered( $result['data']['email'])) {
// 	$result['errors']['email'] = 'Deze gebruiker is niet bekend';
// } else{
// 	$user = getUserByEmail( $result['data']['email']);
// }
// if(password_verify($result['data']['password'], $user['password'])) 