<?php
    session_start();

    if(isset($_POST['email']))
    {
        $wszystko_OK=true;
        $login = $_POST['login'];
        if((strlen($login)<3) || (strlen($login)>32))
        {
            $wszystko_OK=false;
            $_SESSION['e_login']="Login musi zawierać zaiwerać od 3 do 32 znaków!";
        }
        if(ctype_alnum($login)==false){
            $wszystko_OK=false;
            $_SESSION['e_login']="Nick może się składać tylko z liter i cyfr (bez polskich znaków)";
        }
        $email=$_POST['email'];
        $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
        if((filter_var($emailB, FILTER_SANITIZE_EMAIL)==false) || ($emailB!=$email))
        {
            $wszystko_OK=false;
            $_SESSION['e_email']="Błędny adres email!";
        }

        if($wszystko_OK==true)
        {
            echo "Udana walidacja!"; exit();
        }
    }

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REJESTRACJA</title>
    <link rel="stylesheet" type="text/css" href="../styles/style_others.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
</head>
<body>
<h1 id="titlecss">REJESTRACJA</h1>
<br>
<br>
<form method="post">
    <?php
    if(isset($_SESSION['e_email']))
    {
        echo '<div class="error">'.$_SESSION['e_email'].'</div>';
        unset($_SESSION['e_email']);
    }
    ?>
    E-mail:<br/><input type="text" name="email" /> <br/>
    <?php
        if(isset($_SESSION['e_login']))
        {
            echo '<div class="error">'.$_SESSION['e_login'].'</div>';
            unset($_SESSION['e_login']);
        }
    ?>
    Login:<br/><input type="text" name="login" /> <br/>
    Hasło:<br/><input type="password" name="haslo" /> <br/>
    Powtórz hasło:<br /><input type="password" name="haslo2" /> <br/>
    <label>
    <input type="checkbox" name="regulamin"/> Lubie placki! <br/>
    </label> <br/>
    <div class="cf-turnstile" data-sitekey="0x4AAAAAAADkMf2geqNHK9Kq"></div><br/>
    <div class="g-recaptcha" data-sitekey="6Le2xjwlAAAAAGbAapmhOCMeaDVWk35sdDNHL4uQ"></div><br/>
    <input type="submit" value="Zarejestruj się"/>
</form>
<br>
<?php
if(isset($_SESSION['blad']))
    echo $_SESSION['blad'];
?>
<br>
<br>
</body>
</html>
