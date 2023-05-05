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
        $haslo1 = $_POST['haslo1'];
        $haslo2 = $_POST['haslo2'];
        if((strlen($haslo1)<8) OR (strlen($haslo1)>32))
        {
            $wszystko_OK=false;
            $_SESSION['e_haslo']="Hasło musi posaidać od 8 do 20 znaków!";
        }
        if($haslo1!=$haslo2)
        {
            $wszystko_OK=false;
            $_SESSION['e_haslo']="Hasła są różne!";
        }
        $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

        if(!isset($_POST['regulamin']))
        {
            $wszystko_OK=false;
            $_SESSION['e_regulamin']="Potwierdź, że lubisz placki!!!";
        }
        $sekret="6LeMukUlAAAAALZ3X5Ak9-T3-SHLgKWIOSToe5iL";
        $sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
        $odpowiedz = json_decode($sprawdz);
        if($odpowiedz->success==false)
        {
            $wszystko_OK=false;
            $_SESSION['e_captcha']="Czyś jest bot?";
        }

        $_SESSION['fr_login'] = $login;
        $_SESSION['fr_email'] = $email;
        $_SESSION['fr_haslo1'] = $haslo1;
        $_SESSION['fr_haslo2'] = $haslo2;
        if(isset($_POST['regulamin'])) $_SESSION['fr_regulamin'] = true;

        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
        try
        {
            $polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
            if($polaczenie->connect_errno!=0)
            {
                throw new Exception(mysqli_connect_errno());
            }
            else
            {
                $rezultat = $polaczenie->query("SELECT id FROM użytkownicy WHERE email='$email'");
                if(!$rezultat) throw new Exception($polaczenie->error);
                $ile_maili = $rezultat->num_rows;
                if($ile_maili>0)
                {
                    $wszystko_OK=false;
                    $_SESSION['e_email']='Istnieje już konto o tym mailu';
                }
                $rezultat = $polaczenie->query("SELECT id FROM użytkownicy WHERE login='$login'");
                if(!$rezultat) throw new Exception($polaczenie->error);
                $ile_login = $rezultat->num_rows;
                if($ile_login>0)
                {
                    $wszystko_OK=false;
                    $_SESSION['e_login']='Istnieje już konto o tym loginie';
                }
                if($wszystko_OK==true)
                {
                    if($polaczenie->query("INSERT INTO użytkownicy VALUES (NULL,'$email','$login', '$haslo_hash', DEFAULT)"))
                    {
                        $_SESSION['udanarejestracja']=true;
                        header('Location: witamy.php');
                    }
                    else
                    {
                        throw new Exception($polaczenie->error);
                    }
                }
                $polaczenie->close();
            }
        }
        catch(Exception $e)
        {
            echo '<span style="color:red;">Błąd serwera!</span>';
            echo '<br/>Informacja dev:'.$e;
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
    <link rel="stylesheet" type="text/css" href="../styles/style_others.css?v=6">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
<!--    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>-->
</head>
<body>
<h1 id="titlecss">REJESTRACJA</h1>
<br>
<br>
<form method="post">

    E-mail:<br/><input type="text" value="<?php
    if(isset($_SESSION['fr_email']))
    {
        echo $_SESSION['fr_email'];
        unset($_SESSION['fr_email']);
    }
    ?>" name="email" /> <br/>
    <?php
    if(isset($_SESSION['e_email']))
    {
        echo '<div class="error">'.$_SESSION['e_email'].'</div>';
        unset($_SESSION['e_email']);
    }
    ?>
    Login:<br/><input type="text" value="<?php
    if(isset($_SESSION['fr_login']))
    {
        echo $_SESSION['fr_login'];
        unset($_SESSION['fr_login']);
    }
    ?>" name="login" /> <br/>
    <?php
    if(isset($_SESSION['e_login']))
    {
        echo '<div class="error">'.$_SESSION['e_login'].'</div>';
        unset($_SESSION['e_login']);
    }
    ?>
    Hasło:<br/><input type="password" value="<?php
    if(isset($_SESSION['fr_haslo1']))
    {
        echo $_SESSION['fr_haslo1'];
        unset($_SESSION['fr_haslo1']);
    }
    ?>" name="haslo1" /> <br/>
    <?php
    if(isset($_SESSION['e_haslo']))
    {
        echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
        unset($_SESSION['e_haslo']);
    }
    ?>
    Powtórz hasło:<br /><input type="password" value="<?php
    if(isset($_SESSION['fr_haslo2']))
    {
        echo $_SESSION['fr_haslo2'];
        unset($_SESSION['fr_haslo2']);
    }
    ?>" name="haslo2" /> <br/>
    <label>
    <input type="checkbox" value="<?php
    if(isset($_SESSION['fr_regulamin']))
    {
        echo "checked";
        unset($_SESSION['fr_regulamin']);
    }
    ?>"  name="regulamin"/> Lubie placki! <br/>
        <?php
        if(isset($_SESSION['e_regulamin']))
        {
            echo '<div class="error2">'.$_SESSION['e_regulamin'].'</div>';
            unset($_SESSION['e_regulamin']);
        }
        else echo '<br/>';
        ?>
    </label>



<!--    <div class="cf-turnstile" data-sitekey="0x4AAAAAAADkMf2geqNHK9Kq"></div><br/>-->
    <div class="g-recaptcha" data-sitekey="6LeMukUlAAAAAKB70qGbLMauSuwS5HdHIoZgkGsD"></div><br/>
    <?php
    if(isset($_SESSION['e_captcha']))
    {
        echo '<div class="error">'.$_SESSION['e_captcha'].'</div>';
        unset($_SESSION['e_captcha']);
    }
    ?>
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
