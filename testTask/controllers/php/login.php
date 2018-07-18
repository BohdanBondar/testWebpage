<?php 
    require_once 'setting.php';
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    $_SESSION['typeLog'] = 'login';
    $_SESSION['error'];
    $Connect = mysqli_connect(HOST, USER, PASSWORD, DB);  //Подключаемся к базе данных
    if (!$Connect) echo "Not connect to database"; 

    mysqli_query($Connect, "SET NAMES 'utf8';");
    mysqli_query($Connect, "SET CHARACTER SET 'utf8';");
    mysqli_query($Connect, "SET SESSION collation_connection = 'utf8_general_ci';");

     if($_COOKIE['UserDateFull']){
        $UserDate = unserialize($_COOKIE['UserDateFull']);
     }

    if (!empty($UserDate['email'])){
        $first = $UserDate['email'];
        $pass = $UserDate['password'];
         
     }else{
         
    $first = htmlspecialchars($_POST['first']);
    $pass = htmlspecialchars($_POST['pass']);
     }

$checkOnEmail = explode("@", $first, -1 );    

    $type =  empty($checkOnEmail) ? 'login' : 'email'; //Присваеваем $type email если $first это Email или же присваеваем login

    if ( $_POST['sendin'] == "login" || $_COOKIE['UserDateFull']){
        
 $getUsers = mysqli_query($Connect, "SELECT email, name, password FROM users_all WHERE $type = '$first' AND password = '$pass'");//Получаем всех пользователей с таким же Email
        if($getUsers){
            
            $userses = mysqli_fetch_assoc($getUsers);
            $_SESSION['email'] = $userses['email'];
            $_SESSION['name'] = $userses['name'];
            
              if($_POST['rememberMe'] == 'remember'){
                  
                  $cookie_expire = time() + 14400; 
                  setcookie('UserDateFull', serialize($userses), $cookie_expire,  "/" );
                  
//                  $cookie = unserialize($_COOKIE['UserDateFull']);
//                  print_r($cookie);
            }else{
                  
                  
              }
            $_SESSION['ckeckReg'] = true;
            header("Location: ../../view/userpage.php");        
        }else {
        }
    }

?>
