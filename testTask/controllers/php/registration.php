<?php
require_once 'setting.php';

header('Content-Type: text/html; charset=utf-8');
session_start();
$_SESSION['typeLog'] = 'regitration';
$_SESSION['error'];
$Connect = mysqli_connect(HOST, USER, PASSWORD, DB); //Подключаемся к базе данных

if (!$Connect) echo "Not connect to database";
mysqli_query($Connect, "SET NAMES 'utf8';");
mysqli_query($Connect, "SET CHARACTER SET 'utf8';");
mysqli_query($Connect, "SET SESSION collation_connection = 'utf8_general_ci';");
$email = htmlspecialchars($_POST['email']);
$login = htmlspecialchars($_POST['login']);
$name = htmlspecialchars($_POST['name']);
$pass = htmlspecialchars($_POST['pass']);
$birthday = htmlspecialchars($_POST['birthyear'] . "-" . $_POST['birthmonth'] . "-" . $_POST['birthday']);
$country = htmlspecialchars($_POST['country']);
$_SESSION['email'] = $email;
$_SESSION['login'] = $login;
$_SESSION['name'] = $name;
$_SESSION['pass'] = $pass;
$_SESSION['dateBirth'] = $birthday;
$_SESSION['country'] = $country;

function clean($value = "")
	{
	$value = trim($value);
	$value = stripslashes($value);
	$value = strip_tags($value);
	$value = htmlspecialchars($value);
	return $value;
	}

function check_length($value = "", $min, $max)
	{
	$result = (mb_strlen($value) < $min || mb_strlen($value) > $max);
	return !$result;
	}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
	$email = clean($email);
	$name = clean($name);
	$login = clean($login);
	$pass = clean($pass);
	$birthday = clean($birthday);
	$country = clean($country);
	if (!empty($email) && !empty($name) && !empty($login) && !empty($pass) && !empty($birthday))
		{
		$email_validate = filter_var($email, FILTER_VALIDATE_EMAIL);
		if (check_length($name, 2, 50) && check_length($email, 2, 50) && check_length($login, 2, 100) && check_length($pass, 2, 100) && $email_validate)
			{
			$UNIXTimestamp = (mysqli_fetch_array(mysqli_query($Connect, "SELECT unix_timestamp(now())"))) [0]; //Получаем UNIX Timestamp
			if ($_POST['confirm'] == "checked" and $_POST['sendin'] = "sendUser")
				{
				$emailCheck = mysqli_query($Connect, "SELECT email FROM users_all WHERE email = '$email'"); //Получаем всех пользователей с таким же Email
				$loginCheck = mysqli_query($Connect, "SELECT login FROM users_all WHERE login = '$login'"); //Получаем всех пользователей с таким же Логином
				if ($emailCheck & (mysqli_fetch_array($emailCheck)) [0] == '')
					{ //Проверка на существование пользователя с таким же Email
					if ($loginCheck & (mysqli_fetch_array($loginCheck)) [0] == '')
						{ //Проверка на существование пользователя с таким же логином
						$adduser = mysqli_query($Connect, "INSERT INTO users_all (email, login, name, password, datebirth, country_id, confirm, UNIX_timestamp  ) VALUES ('$email', '$login', '$name', '$pass', '$birthday', '$country', true,'$UNIXTimestamp')");
						if (!$adduser)
							{
							$_SESSION['error'] = 'Не удалось создать запрос!';
							header("Location: " . $_SERVER['HTTP_REFERER']);
							}
						  else
							{
							$_SESSION['ckeckReg'] = true;
							header("Location: ../../view/userpage.php");
							}
						}
					  else
						{
						$_SESSION['error'] = "Пользователь с таким логином уже существует.";
						header("Location: " . $_SERVER['HTTP_REFERER']);
						}
					}
				  else
					{
					$_SESSION['error'] = "Пользователь с таким Email уже существует.";
					header("Location: " . $_SERVER['HTTP_REFERER']);
					}
				}
			}
		  else
			{
			$_SESSION['error'] = 'Введенные данные некорректные!';
              header("Location: " . $_SERVER['HTTP_REFERER']);
			}
		}
	  else
		{
		$_SESSION['error'] = "Заполните пустые поля";
          header("Location: " . $_SERVER['HTTP_REFERER']);
		}
	}
  else
	{
	header("Location: " . $_SERVER['HTTP_REFERER']);
	}

?>