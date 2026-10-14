<?php

session_start();

require('server.php');

$id = $_SESSION['id'];

$id_couse = $_GET['id'];
$id_professor = mysqli_real_escape_string($conn,$_POST['id_professor']);
$name = mysqli_real_escape_string($conn,$_POST['name']);

echo $sql_qurey = "UPDATE course SET `id_professor` = '$id_professor' , `name` = '$name'
WHERE id = '$id_couse'";

$resule = mysqli_query($conn,$sql_qurey);

$_SESSION['succeed'] = "1";
Header("location:../page_course.php");

?>