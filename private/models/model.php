<?php
// Model functions
// In dit bestand zet je ALLE functions die iets met data of de database doen

// Model functions
// In dit bestand zet je ALLE functions die iets met data of de database doen

function getUsers() {
    $connection = dbConnect();
    $sql = "SELECT * FROM `users`";
    $statement = $connection->query( $sql );

    return $statement->fetchAll();
}

function getUserByEmail($email) {
    $connection = dbConnect();
    $sql = "SELECT * FROM `users` WHERE `email` = :email";
    $statement = $connection->prepare( $sql );
    
    $statement->execute( ['email' => $email]);

    if ( $statement->rowCount() === 1){
        return $statement->fetch();
    }

    return false;
}
function getAllSports() {
	$connection = dbConnect();
	$sql        = "SELECT * FROM `sports`";
	$statement  = $connection->query( $sql );
	return $statement->fetchAll();
 }
 function getSportSchema($sport_id, $soort){
    $connection = dbConnect();
    $sql        = "SELECT * FROM `schema` WHERE `sport_id` = :sport_id AND `soort` = :soort ORDER BY `volgorde` ASC";
    $statement  = $connection->prepare( $sql );
    $param = [
        'sport_id' => $sport_id,
        'soort' => $soort
    ];
    $statement->execute($param);
	return $statement->fetchAll();
 }
 function getSport($sport_id){
    $connection = dbConnect();
    $sql        = "SELECT * FROM sports WHERE id = :sport_id";
    $statement  = $connection->prepare( $sql );
    $param = [
        'sport_id' => $sport_id,
    ];
    $statement->execute($param);
    return $statement->fetch();  // Alleen de eerste rij ophalen
 }
 function searchSports($search){
    $sql = "SELECT * FROM `sports` WHERE `titel` LIKE :search";
    $connection = dbConnect();
    $statement = $connection->prepare( $sql );
    $params = [
        'search' => '%' . $search . '%'
    ];
    $statement->execute($params);

    return $statement->fetchAll();

 }
 function getUserById($user_id) {
    $connection = dbConnect();
    $sql = "SELECT * FROM `users` WHERE `id` = :id";
    $statement = $connection->prepare( $sql );
    
    $statement->execute( ['id' => $user_id]);

    if ( $statement->rowCount() === 1){
        return $statement->fetch();
    }

    return false;
}
function getUserByResetCode($reset_code) {
    $connection = dbConnect();
    $sql = "SELECT * FROM `users` WHERE `password_reset` = :code";
    $statement = $connection->prepare( $sql );
    
    $statement->execute( ['code' => $reset_code]);

    if ( $statement->rowCount() === 1){
        return $statement->fetch();
    }

    return false;
}
function updatePassword( $user_id, $new_password ) {
	$safe_new_password = password_hash($new_password, PASSWORD_DEFAULT);
	$sql = "UPDATE `users` SET `password` = :password, `password_reset` = NULL WHERE `id` = :id";
	$connection = dbConnect();
	$statement = $connection->prepare($sql);
	$params = [
		'password' => $safe_new_password,
		'id' => $user_id
	];

	return $statement->execute($params);
}