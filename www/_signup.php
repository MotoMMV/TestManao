<?php
//Вставляю заголовок
$HTML = str_replace( '<!--title-->' , "Регистрация" , $HTML );

$login = '';
$password = '';
$confirm_password = '';
$email = '';
$name = '';


if( $_REQUEST['login'] )
{
	//удаляем пробелы и табы с начала и конца переменной
	$login = trim( $_REQUEST['login'] );

	//обрезаем максимальную длину строки до 21 символа
	$login = substr( $login , 0 , 21 );
}

if( $_REQUEST['password'] )
{
	$password = trim( $_REQUEST['password'] );
	$password = substr( $password , 0 , 21 );
}

if( $_REQUEST['confirm_password'] )
{
	$confirm_password = trim( $_REQUEST['confirm_password'] );
	$confirm_password = substr( $confirm_password , 0 , 21 );
}

if( $_REQUEST['email'] )
{
	$email = trim( $_REQUEST['email'] );
	$email = substr( $email , 0 , 21 );

}

if( $_REQUEST['name'] )
{
	$name = trim( $_REQUEST['name'] );
	$name = substr( $name , 0 , 21 );
}


if( $login && $password && $confirm_password && $password == $confirm_password && $email && $name )
{
	$error_register = 0;

	//файл с данными о пользователях можно вынести за пределы web папки проекта, чтобы обезопасить от несанкционированного доступа по http/https, можно также использовать .htaccess директивы для этого
	$users_json = file_get_contents( $path_to_users_data );

	$users_array = json_decode( $users_json , true );

	if( $users_array[$login] )
	{
		$error_register = 1;
	}

	foreach( $users_array as $user )
	{
		if( $user['email'] == $email )
		{
			$error_register = 2;
		}
	}
		
	if( !$error_register )
	{
		$users_array[$login] = [
		"password" => md5( $password ),	
		"email" => $email,
		"name" => $name,
		];

		$users_json = json_encode( $users_array );
		file_put_contents( $path_to_users_data , $users_json );

		$HTML = str_replace( '<!--Welcome message--><!--' , "<!--Welcome message-->" , $HTML );
		$HTML = str_replace( '--><!--Welcome message-->' , "<!--Welcome message-->" , $HTML );
		$HTML = str_replace( '%UserName%' , $name , $HTML );
	} else {
		$HTML = str_replace( '<!--ErrorMessage-->' , "<p class='red'>Ошибка регистрации! Логин или email уже имеются в базе</p><br>" , $HTML );
	}

} else {
	$HTML = str_replace( '<!--Registration request--><!--' , "<!--Registration request-->" , $HTML );
	$HTML = str_replace( '--><!--Registration request-->' , "<!--Registration request-->" , $HTML );
}
?>