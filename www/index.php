<?php
//Я подключаю файл настроек, где будут инициализироваться разные переменные, которые я буду использовать в коде.
require 'settings.php';


//Вычленяю какую страницу запрашивает пользователь. Поскольку я делаю сайт с одной точкой входа (index.php) мне нужно принимать в качестве параметра имя запрашиваемой страницы.
if( $_REQUEST['path'] ){
	$requested_page = $_REQUEST['path'];
}else{
	$requested_page = '';
}

//это защитная обработка входящих данных, чтобы пользователь не передал в ней вредный код. Я обрезаю строку до 12 символов
$requested_page = trim( $requested_page );
$requested_page = substr( $requested_page , 0 , 12 );

//Если нет в запросе страницы или она не найдены будет использована страница по умолчанию
if( !$requested_page || !file_exists( "_{$requested_page}.html" ) ) $requested_page = "index";

//Подключаю запрашиваемую страницу
$HTML = file_get_contents( "_{$requested_page}.html" );

//Паршу список подключаемых в странице модулей
$modules = explode( "<!--module:" , $HTML );
$size = sizeof( $modules );
for( $i = 1 ; $i < $size ; $i+=2 )
{
	list( $module , $data ) = explode( "-->" , $modules[$i] , 2 );

//Если есть файл модуля, вставляю в код запрашиваемой страницы
	if( !file_exists( "__{$module}.html" ) ) continue;
	$code = file_get_contents( "__{$module}.html" );
	
	$HTML = str_replace( "<!--module:$module--><!--module:$module-->" , $code , $HTML );

//Если есть php код для модуля, исполняю его	
	if( file_exists( "__{$module}.php" ) ) require "__{$module}.php";
}

//Если есть php код для страницы, исполняю его	
if( file_exists( "_{$requested_page}.php" ) ) require( "_{$requested_page}.php" );


//Вывожу итоговый контент пользователю
echo $HTML;

?>

