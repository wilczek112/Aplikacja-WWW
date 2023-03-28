<?php
    session_start();

    if(!isset($_SESSION['zalogowany']))
    {
        header('Location: index.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>STRONA W BUDOWIE</title>
        <link rel="stylesheet" type="text/css" href="../styles/style_main.css">
    </head>
    <body>
    <h1 id="titlecss">
        <?php
        echo "Zalogowano: ".$_SESSION['login']." z uprawnieniami: ".$_SESSION['user_type'];
        ?>
        </h1>
        <?php
            echo '<a style="float: right; font-size: 25px" href="logout.php">Wyloguj się!</a>';
        ?>
        <br>
        <br>
        <h3 class="first">Elementy na stronie:</h3>
        <ol class="second">
            <li><a href="../pages/timer.html">stoper</a></li>
            <li>lista</li>
            <li>tabela</li>
            <li>formularz</li>
        </ol>
        <br>
        <br>
        <br>
        <br>
        <table id="tabela">
            <th>Imie</th>
            <th>Nazwisko</th>
            <th>Pomysł</th>
        <tr>
            <td>Oskar</td>
            <td>Wilk</td>
            <td>Sklep internetowy</td>
        </tr>
        <tr>
            <td>Marcel</td>
            <td>Andrzejczak</td>
            <td>Serwis informacyjny</td>
        </tr>
        <tr>
            <td>Jakub</td>
            <td>Walczak</td>
            <td>Kolorowanki dla dzieci</td>
        </tr>
        </table>
        <br>
        <br>
        <form action="" method="get">
            <p>
                <input type="text" name="imie" placeholder="Wpisz imie">
            </p>
            <p>
                <input type="text" name="nazwisko" placeholder="Wpisz nazwisko">

            </p>
            <p>
                <input type="text" name="pomysl" placeholder="Popozycja charakteru strony">
            </p>
            <input type="submit" value="Wyślij">
        </form>

    </body>
</html>