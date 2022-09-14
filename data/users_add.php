<?php

$users = [];

$user["user1"] = [
	"password" => md5( "password1" ),
	"email" => "uuser@example.com",
	"name" => "User Number1",
];

$user["user2"] = [
	"password" => md5( "password2" ),
	"email" => "uuser2@example.com",
	"name" => "User Number2",
];

$user["user3"] = [
	"password" => md5( "password3" ),
	"email" => "uuser3@example.com",
	"name" => "User Number3",
];

$user_JSON = json_encode( $user );

file_put_contents( "./users.json" , $user_JSON );

?>