<?php 
    require_once '../controllers/php/setting.php';
    header('Content-Type: text/html; charset=utf-8');
    session_start();


    $Connect = mysqli_connect(HOST, USER, PASSWORD, DB); 
    if (!$Connect) echo "Not connect to database"; 
    $data = array();

    mysqli_query($Connect, "SET NAMES 'utf8';");
    mysqli_query($Connect, "SET CHARACTER SET 'utf8';");
    mysqli_query($Connect, "SET SESSION collation_connection = 'utf8_general_ci';");
        
   
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="test work">
    <meta name="author" content="Bondar B.G.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../style.css">
    <script src="../js/script.js"></script>
    <title>Account</title>
</head>

<body>



    <div id="content" align="center">
        <div id="log-form" style="margin-top: 10vh;">
            <div class="headerUserInfo">
               <h1>About user</h1>
           </div>
            <hr class="long">

            <?php 
                echo'<p class="userInfo">
                            Email: '.$_SESSION['email'].'
                        </p>
                        <hr  class="short">
                        <p class="userInfo">
                            Name: '. $_SESSION['name'].'
                        </p>
                        <hr class="short">';
//    print_r( unserialize($_COOKIE['UserDateFull']));
    ?>
            <form action="../controllers/php/logout.php" method="get" name="logout" accept-charset="utf-8">
                <button type="submit" class="btn-submit" name="logoutFromAccount">LogOut</button>
            </form>
        </div>
    </div>

</body>

</html>
