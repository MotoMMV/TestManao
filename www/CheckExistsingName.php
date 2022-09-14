<?php
header('Access-Control-Allow-Origin: *'); 
header("Content-Type: application/json; charset=UTF-8"); 

require 'settings.php';

$data_JSON = file_get_contents("php://input");
$data = json_decode( $data_JSON , true );

$Users_JSON = file_get_contents( $path_to_users_data );
$Users = json_decode( $Users_JSON , true );

//file_put_contents( 'test.txt' , $data_JSON );

$Answer = false;

/*
echo"<pre>";
var_dump( $Users );
echo"</pre>";
*/


if( $Users[$data['login']] )
{
	$Answer = true;
}

echo json_encode( $Answer );
?>