<?php

    session_start();
    require('funtion.php');

    require('server.php');

    $id = $_SESSION['id'];

    // $name = mysqli_real_escape_string($conn,$_POST['name']);
    $gender = mysqli_real_escape_string($conn,$_POST['gender']);
    $coures = mysqli_real_escape_string($conn,$_POST['coures']);

    $data = coures_d($coures);

    echo $sql_qurey = "INSERT INTO grad(`id_student`,`id_professor`,`grad`,`id_course`)
    VALUES('$id','{$data['id_professor']}','$gender','$coures')";

    $resule = mysqli_query($conn,$sql_qurey);

    $_SESSION['succeed'] = "1";
    Header("location:../page_problem_with_grades.php");

?>