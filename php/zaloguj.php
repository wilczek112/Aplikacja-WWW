<?php

    session_start();

    if((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
    {
        header('Location: index.php');
        exit();
    }

    require_once "connect.php";

    $polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);

    if($polaczenie->connect_errno!=0)
    {
        echo "Error: ".$polaczenie->connect_errno/*." Opis: ".$polaczenie->connect_error*/;
    }
    else
    {
        $login = $_POST['login'];
        $haslo = $_POST['haslo'];

        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        $haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");

        if($rezultat = @$polaczenie->query(sprintf("SELECT * FROM użytkownicy WHERE login='%s' AND password='%s'",
        mysqli_real_escape_string($polaczenie,$login),
        mysqli_real_escape_string($polaczenie,$haslo))))
        {
            $ilu_userow = $rezultat->num_rows;
            if ($ilu_userow>0)
            {
                $_SESSION['zalogowany'] = true;

                $wiersz = $rezultat->fetch_assoc();
                $_SESSION['id'] = $wiersz['id'];
                $_SESSION['login'] = $wiersz['login'];
                $_SESSION['user_type'] = $wiersz['user_type'];

                unset($_SESSION['blad']);
                $rezultat->free_result();
                header('Location: main_page.php');
            }
            elseif ($$ilu_userow==0) header('Location: rejestracja.php');
            else{
                $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło :(</span>';
                header('Location: index.php');
            }
        }
        echo"Działa!";
        $polaczenie->close();
    }


?>