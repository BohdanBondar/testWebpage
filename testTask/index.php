<?php 
   include_once 'controllers/php/setting.php';
   header('Content-Type: text/html; charset=utf-8');
   session_start();
   
   $Connect = mysqli_connect(HOST, USER, PASSWORD, DB); 
   if (!$Connect) echo "Not connect to database"; 
   
   mysqli_query($Connect, "SET NAMES 'utf8';");
   mysqli_query($Connect, "SET CHARACTER SET 'utf8';");
   mysqli_query($Connect, "SET SESSION collation_connection = 'utf8_general_ci';");
   
   if ($_COOKIE['UserDateFull'])
   {
       header("Location: controllers/php/login.php");
   }
   $arrDateBirth  = explode("-", $_SESSION['dateBirth']);
   
   ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="test work">
    <meta name="author" content="Bondar B.G.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="style.css">
    <script src="js/script.js"></script>
    <title>Test task</title>
</head>

<body>
    <?php
                             
        if( $_SESSION['typeLog'] == 'regitration'){
            echo '
            <style>
            #form-registration{
            display: block;
            }

            #form-login{
            display: none;
            }
            </style>';
        }else{
            echo '
            <style>
            #form-registration{
            display: none;
            }

            #form-login{
            display: block;
            }    
            </style>';
        }
    
    ?>
        <div id="content" align="center">
            <div id="log-form">
                <div id="message-verification" class="transition" onmouseover="closewindowopen(1)" onmouseout="closewindowopen(2)">
                    <p id="message-body"></p>
                </div>

                <div class="form" id="logup">
                    <div id="form-registration">
                        <div id="form-header" align="center">
                            <h1 id="type-form">REgistration</h1>
                        </div>
                        <form action="controllers/php/registration.php" name="logup" method="POST" accept-charset="utf-8">
                            <label for="input-type-input-email">E-mail *</label>
                            <input type="email" name="email" placeholder="Email" class="form-input-type1" id="input-type-input-email" autocomplete="email" maxlength="90" <?php if($_SESSION[ 'email']) echo 'value="'.$_SESSION['email ']. '"'; ?> onkeyup="this.style.backgroundColor
                            = 'rgb(241, 241, 241)'" minlength="5" tabindex="1" required>
                            <label for="input-type-input-login">Login *</label>
                            <input type="text" name="login" placeholder="Login" class="form-input-type1" id="input-type-input-login" autocomplete="nickname" maxlength="30" <?php if($_SESSION[ 'login']) echo 'value="'.$_SESSION['login']. '"'; ?> onkeyup="this.style.backgroundColor
                            = 'rgb(241, 241, 241)'" minlength="3" tabindex="2" required>
                            <label for="input-type-input-name">Real full name *</label>
                            <input type="text" name="name" placeholder="Real name" class="form-input-type1" id="input-type-input-name" autocomplete="name" maxlength="90" <?php if($_SESSION[ 'name']) echo 'value="'.$_SESSION['name']. '"'; ?> onkeyup="this.style.backgroundColor
                            = 'rgb(241, 241, 241)'" minlength="3" tabindex="3" required>
                            <label for="input-type-input-password">Create a password *</label>
                            <input type="password" name="pass" placeholder="Password" class="form-input-type1" id="input-type-input-password" maxlength="90" minlength="5" tabindex="4" onkeydown="if (event.keyCode == 32) {return false;}" onkeyup=" this.style.backgroundColor = 'rgb(241, 241, 241)'; checkPassword()"
                                required>
                            <div class="form-input-date">
                                <label for="input-type-input-date-day">Select date of birth *</label>
                                <input type="number" name="birthday" class="form-input-type2" id="input-type-input-date-day" autocomplete="bday-day" max="31" min="1" value="
																	<?php if($_SESSION['dateBirth']) echo $arrDateBirth[2]; ?>" tabindex="5" required>
                                <input type="number" name="birthmonth" class="form-input-type2" id="input-type-input-date-month" autocomplete="bday-month" max="12" min="1" value="
																		<?php if($_SESSION['dateBirth']) echo $arrDateBirth[1]; ?>" tabindex="6" required>
                                <input type="number" name="birthyear" class="form-input-type2" id="input-type-input-date-year" autocomplete="bday-year" max="2018" min="1919" tabindex="7" value="
																			<?php if($_SESSION['dateBirth']) echo $arrDateBirth[0]; ?>" required>
                            </div>
                            <label for="input-type-select">Choose the country *</label>
                            <select name="country" tabindex="8" id="input-type-select" required>
                                <option value="" disabled>Make a chooise</option>
								    <?php
                                        //Получаем из базы данных список стран
                                        $Result = mysqli_query($Connect, "SELECT * FROM `apps_countries` ORDER BY `apps_countries`.`id` ASC");

                                        //Записываем результат в асоциативный массив и перебираем в цикле

                                        while ($Row = mysqli_fetch_assoc($Result))
                                        {   
                                            if ( $_SESSION['country'] === $Row['id'] ){
                                                echo  ' 
                                                <option selected value="'.$Row['id'].'">'.$Row['country_name'].'</option>';
                                            }else{
                                                echo  ' 
                                                <option value="'.$Row['id'].'">'.$Row['country_name'].'</option>';
                                            }   
                                        }
                                
                                    ?>
    				    	</select>
                            <div class="form-input-type3" align="left">
                                <input type="checkbox" name="confirm" id="input-type-checkbox" class="form-input-type-checkbox" value="checked" required>
                                <label for="input-type-checkbox">I agree to the terms of use.</label>
                            </div>
                            <div class="btn-and-to" align="left">
                                <button type="submit" class="btn-submit transition" name="sendin" onclick="dataverification(event) " value="sendUser">Finish</button>
                                <div class="add-info" align="right">
                                    <a class="btn-check-log transition" onclick="toLogin()">Вы уже зарегистрированы?</a>
                                </div>
                            </div>
                            <br>
                            <?php
                                if(isset($_SESSION['error'] ) & !empty($_SESSION['error']) )
                                {
                                    echo '<script> message("'.$_SESSION['error'].'");</script>';
                                    unset($_SESSION['error']);
                                }
                            
                            ?>
                        </form>
                    </div>
                    <div id="form-login">
                        <div id="form-header" align="center">
                            <h1 id="type-form">Log-In</h1>
                        </div>
                        <form action="controllers/php/login.php" name="Login" method="POST" accept-charset="utf-8">
                            <label for="input-type-first">Enter E-mail or Login *</label>
                            <input type="text" name="first" placeholder="Email or login" class="form-input-type1" id="input-type-first" <?php if($_SESSION[ 'login-first']) echo 'value=" '.$_SESSION[ 'login-first ']. ' "'; ?> autocomplete="email" maxlength="90"
                            onkeyup="this.style.backgroundColor='rgb(241, 241, 241)'" minlength="2" tabindex="1" required>
                            <label for="input-type-password">Enter password *</label>
                            <input type="password" name="pass" placeholder="Password" class="form-input-type1" id="input-type-password" <?php if($_SESSION[ 'passwordLogin']) echo 'value=" '.$_SESSION[ 'passwordLogin ']. ' "'; ?> maxlength="90" minlength="5"
                            tabindex="4" onkeydown="if (event.keyCode==3 2) {return false;}" required>
                            <div class="form-input-type3" align="left">
                                <input type="checkbox" name="rememberMe" id="input-type-checkbox-remember" class="form-input-type-checkbox" value="remember">
                                <label for="input-type-checkbox-remember">Remember me</label>
                            </div>
                            <div class="btn-and-to" align="left ">
                                <button type="submit" class="btn-submit transition" name="sendin" onclick="dataverificationlogin(event)" value="login">Login</button>
                                <span class="add-info" align="right ">
                                    <a class="btn-check-log transition" onclick="toRegistration()">You have account?</a>
								</span>
                            </div>
                            <br>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>