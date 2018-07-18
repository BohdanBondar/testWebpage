<?php
    session_start();
    $cookie_expire = time() - 99400; 
    setcookie('UserDateFull', serialize(unserialize($_COOKIE['UserDateFull'])), $cookie_expire,  "/" );
    header("Location: ../../index.php");        
    session_destroy();

?>
