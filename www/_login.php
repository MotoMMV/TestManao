<?php
//Вставляю заголовок
$HTML = str_replace( '<!--title-->' , "Вход" , $HTML );


$login = '';
$password = '';
$User = [];


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


if( $login && $password )
{
	$password_hash = md5( $password );

	//файл с данными о пользователях можно вынести за пределы web папки проекта, чтобы обезопасить от несанкционированного доступа по http/https, можно также использовать .htaccess директивы для этого
	$users_json = file_get_contents( $path_to_users_data );

	$users_array = json_decode( $users_json , true );

	if( $users_array[$login]['password'] == $password_hash )
	{
		$User = $users_array[$login];
		$User['login'] = $login;
	} else {
		$HTML = str_replace( '<!--ErrorMessage-->' , "<p class='red'>Неверный логин / пароль</p><br>" , $HTML );
	}

}


if( !$User['name'] )
{
	$HTML = str_replace( "<!--Authorization request--><!--" , "<!--Authorization request-->" , $HTML );
	$HTML = str_replace( "--><!--Authorization request-->" , "<!--Authorization request-->" , $HTML );
} else {
	$HTML = str_replace( '<!--Welcome message--><!--' , "<!--Welcome message-->" , $HTML );
	$HTML = str_replace( '--><!--Welcome message-->' , "<!--Welcome message-->" , $HTML );
	$HTML = str_replace( '%UserName%' , $User['name'] , $HTML );
	
	$Action = <<<EOF
<script>
LogIn( '$User[login]' , '$User[password]' , '$User[name]' );
</script>
EOF;

	$HTML = str_replace( '<!--LOG IN OUT ACTION-->' , $Action , $HTML );
}


?>