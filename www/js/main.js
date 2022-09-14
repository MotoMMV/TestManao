
//регулярное выражение для проверки чтобы начало пароля были не цифры
const beginWithoutDigit = /^\D.*$/

//регулярное выражение для проверки чтобы в пароле не было специальных символов
const withoutSpecialChars = /^[^-() /]*$/

//регулярное выражение для проверки чтобы в пароле были буквы в малом регистре
const containsSmallLetters = /^.*[a-z]+.*$/

//регулярное выражение для проверки чтобы в пароле были буквы в большом регистре
const containsBigLetters = /^.*[A-Z]+.*$/

//регулярное выражение для проверки длины 6 символов
const checkLength6 = /^.{6,}$/

//регулярное выражение для проверки валидности электронной почты
const checkEmail = /\S+@\S+\.\S+/g;            

//регулярное выражение для проверки длины 2 и более символов
const checkLength2 = /[A-Za-z]{2,}/


function SubmitFormRegistration()
{
	var FormError = 0;
	
	var login = registration_login.value;
	var password = registration_password.value;
	var password_confirm = registration_password_confirm.value;
	var email = registration_email.value;
	var name = registration_name.value;

	signup_login.value = login;
	signup_email.value = email;
	signup_name.value = name;
	signup_password.value = password;
	signup_password_confirm.value = password_confirm;

	const data = new FormData( signup_form );
//	console.log( data );

	const formJSON = Object.fromEntries(data.entries());
//	console.log( formJSON );

//Если будет мультиселект, то добавим это в объект
//formJSON.fieldname = data.getAll( 'fieldname' );

	fetch( 'CheckExistsingName.php' , {
		method: "POST",
		cache: 'no-cache',
		headers: {
			'Accept': 'application/json',
			'Content-Type': 'application/json;charset=utf-8'
		},
		body: JSON.stringify( formJSON )
	})
	.then( function( response ) {
		if( response.status !== 200 )
		{
			alert( "Проблемы с получением данных о доступности логина для регистрации!" )
			FormError = 1;
			return;
		}

		response.json().then( function( answer ){
			if( answer )
			{
				alert( 'Такой логин уже зарегистрирован, пожалуйста, попробуйте иной' );
				FormError = 2;
				return false;
			}
		});
	});


	if( !checkLength6.test( login ) )
	{
		alert( 'Логин должен содержать не менее 6 символов');
		FormError = 3;
	}

	if( !checkLength6.test( password ) )
	{
		alert( 'Пароль должен содержать более 6 символов' );
		FormError = 4;
	}
	
	if( !withoutSpecialChars.test( password ) )
	{
		alert( 'Пароль не может содержать спецсимволы' );
		FormError = 5;
	}

	if( password != password_confirm )
	{
		alert( 'Пароль и подтверждение пароля должны совпадать' );
		FormError = 6;
	}

// проверка адреса электронной почты
	if( !checkEmail.test( email ) )
	{
		alert('Электронная почта недействительна');
		FormError = 7;
	}

	if( !checkLength2.test( name ) )
	{
		alert( 'Name должен содержать не менее 2 символов');
		FormError = 3;
	}


	if( FormError == 0 )
	{
		signup_form.submit();
	}

};

