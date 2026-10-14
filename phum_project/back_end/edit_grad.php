<?php

    session_start();

    require('server.php');

    $id = $_SESSION['id'];

    $grade_1_1 = mysqli_real_escape_string($conn,$_POST['grade_1_1']);
    $grade_1_2 = mysqli_real_escape_string($conn,$_POST['grade_1_2']);
    $grade_2_1 = mysqli_real_escape_string($conn,$_POST['grade_2_1']);
    $grade_2_2 = mysqli_real_escape_string($conn,$_POST['grade_2_2']);
    $grade_3_1 = mysqli_real_escape_string($conn,$_POST['grade_3_1']);
    $grade_3_2 = mysqli_real_escape_string($conn,$_POST['grade_3_2']);
    $grade_4_1 = mysqli_real_escape_string($conn,$_POST['grade_4_1']);
    $grade_4_2 = mysqli_real_escape_string($conn,$_POST['grade_4_2']);

    $sql_qurey = "UPDATE user_student SET `grade_1_1` = '$grade_1_1' , `grade_1_2` = '$grade_1_2' , `grade_2_1` = '$grade_2_1' 
    , `grade_2_2` = '$grade_2_2' ,`grade_3_1` = '$grade_3_1' ,`grade_3_2` = '$grade_3_2',`grade_4_1` = '$grade_4_1',`grade_4_2` = '$grade_4_2'
    WHERE id = '$id'";

    $query = mysqli_query($conn , $sql_qurey);

    $_SESSION['succeed'] = "1";
    Header("location:../page_main.php");

?>