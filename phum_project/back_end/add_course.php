<?php

session_start();

require('server.php');

$id = $_SESSION['id'];

$id_professor = mysqli_real_escape_string($conn,$_POST['id_professor']);
$name = mysqli_real_escape_string($conn,$_POST['name']);

echo $sql_qurey = "INSERT INTO course(`name`, `id_professor`)
VALUES('$name','$id_professor')";

$resule = mysqli_query($conn,$sql_qurey);

$_SESSION['succeed'] = "1";
Header("location:../page_course.php");

?>