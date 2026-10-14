<?php

    session_start();

    require('server.php');

    $id = $_SESSION['id'];
    $level = $_SESSION['level'];

    $id_appointment = $_GET['id_appointment'];
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $date_time = mysqli_real_escape_string($conn,$_POST['date_time']);
    $details_student = mysqli_real_escape_string($conn,$_POST['details_student']);
    $details_professor = mysqli_real_escape_string($conn,$_POST['details_professor']);

    $sql_qurey = "UPDATE appointment SET `name` = '$name' , `date_time` = '$date_time' , `details_student` = '$details_student' 
    , `details_professor` = '$details_professor' 
    WHERE id = '$id_appointment'";

    $resule = mysqli_query($conn,$sql_qurey);

    $_SESSION['succeed'] = "1";

    if($level == 1){
        Header("location:../page_appointment_student.php");
    }
    if($level == 2){
        Header("location:../page_appointment_professor.php");
    }

?>