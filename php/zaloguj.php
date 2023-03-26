<?php

    session_start();

    require_once "connect.php";

    $polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);

    if($polaczenie->connect_errno!=0)
    {
        echo "Error: ".$polaczenie->connect_errno/*." Opis: ".$polaczenie->connect_error*/;
    }
    else
    {
        $login = $_POST['login'];
        $haslo = $_POST['password'];

        $sql = "SELECT * FROM użytkownicy WHERE login='$login' AND password='$haslo'";
        if($rezultat = @$polaczenie->query($sql))
        {
            $ilu_userow = $rezultat->num_rows;
            if ($ilu_userow>0)
            {
                $wiersz = $rezultat->fetch_assoc();
                $_SESSION['login'] = $wiersz['login'];
                $rezultat->free_result();

                header('Location: main_page.php');
            }
            else{

            }
        }
        echo"Działa!";
        $polaczenie->close();
    }


?>