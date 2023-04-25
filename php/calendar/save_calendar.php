<?php

require_once('../connect.php');

$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "<script> alert('Error: No data to save.'); location.replace('./') </script>";
    $polaczenie->close();
    exit;
}

extract($_POST);
$allday = isset($allday);

if (empty($id)) {
    $sql = "INSERT INTO `calendar` (`title`,`description`,`start_date`,`end_date`) VALUES ('$title','$description','$start_date','$end_date')";
} else {
    $sql = "UPDATE `calendar` set `title` = '{$title}', `description` = '{$description}', `start_date` = '{$start_date}', `end_date` = '{$end_date}' where `id` = '{$id}'";
}

$save = $polaczenie->query($sql);

if ($save) {
    echo "<script> alert('Schedule Successfully Saved.'); location.replace('./') </script>";
} else {
    echo "<pre>";
    echo "An Error occured.<br>";
    echo "Error: " . $polaczenie->error . "<br>";
    echo "SQL: " . $sql . "<br>";
    echo "</pre>";
}
header('Location: slave_page.php');
$polaczenie->close();
?>