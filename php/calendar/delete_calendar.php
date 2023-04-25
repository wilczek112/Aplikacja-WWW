<?php
require_once('../connect.php');

$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);

if(!isset($_GET['id'])){
    echo "<script> alert('Undefined Schedule ID.'); location.replace('./') </script>";
    $polaczenie->close();
    exit;
}

$delete = $polaczenie->query("DELETE FROM `calendar` where id = '{$_GET['id']}'");

if($delete){
    echo "<script> alert('Event has deleted successfully.'); location.replace('./') </script>";
}else{
    echo "<pre>";
    echo "An Error occured.<br>";
    echo "Error: ".$polaczenie->error."<br>";
    echo "SQL: ".$sql."<br>";
    echo "</pre>";
}
header('Location: slave_page.php');
$polaczenie->close();
?>
