<?php

$data_users = file_get_contents( "users.json" );
$users = json_decode( $data_users , true );

echo"<pre>";var_dump($users);echo"</pre>";

?>