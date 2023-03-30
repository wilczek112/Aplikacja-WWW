<?php
    session_start();

    if(!isset($_SESSION['udanarejestracja']))
    {
        header('Location: main_page.php');
        exit();
    }
    else
    {
        unset($_SESSION['udanarejestracja']);
    }
    if(isset($_SESSION['fr_login'])) unset($_SESSION['fr_login']);
    if(isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
    if(isset($_SESSION['fr_haslo1'])) unset($_SESSION['fr_haslo1']);
    if(isset($_SESSION['fr_haslo2'])) unset($_SESSION['fr_haslo2']);
    if(isset($_SESSION['fr_regulamin'])) unset($_SESSION['fr_regulamin']);

    if(isset($_SESSION['e_login'])) unset($_SESSION['e_login']);
    if(isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
    if(isset($_SESSION['e_haslo'])) unset($_SESSION['e_haslo']);
    if(isset($_SESSION['e_regulamin'])) unset($_SESSION['e_regulamin']);
    if(isset($_SESSION['e_captcha'])) unset($_SESSION['e_captcha']);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lubie placki</title>
    <link rel="stylesheet" type="text/css" href="../styles/style_others.css">
</head>
<body>
    <h1 id="titlecss">Dzięki za wspólną podróż</h1>
    <br>
    <br>
    <br>
    <br>
    <div style="text-align: center">
    <a style="font-size: 80px; color: deepskyblue" href="index.php">Zaloguj się :)</a>
    </div>
</body>
</html>