<?php
    session_start();

    if(isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany']==true))
    {
        header('Location: main_page.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lubie placki</title>
    <link rel="stylesheet" type="text/css" href="../styles/style_others.css?v=6">
</head>
<body>
    <h1 id="titlecss">LOGOWANIE</h1>
    <br>
    <br>
    <form action="zaloguj.php" method="post">
    Login:<br /><input type="text" name="login" /> <br/>
    Hasło:<br /><input type="password" name="haslo" /> <br/> <br/>
    <input type="submit" value="Zaloguj się"/>
    </form>
    <br>
    <?php
        if(isset($_SESSION['blad']))
        echo $_SESSION['blad'];
    ?>
    <br>
    <br>
    <a style="font-size: 40px; color: deepskyblue" href="rejestracja.php">Nie masz konta?</a>
</body>
</html>