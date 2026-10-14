<?php

    session_start();
    require("server.php");

    $id_appointment = $_GET['id_appointment'];
    $level = $_SESSION['level'];

    $sql = "UPDATE appointment SET `level` = '2'
    WHERE id = '$id_appointment'";
    $Data_qurey = mysqli_query($conn , $sql);

    
    $_SESSION['succeed'] = "1";

    if($level == 1){
        Header("location:../page_appointment_student.php");
    }
    if($level == 2){
        Header("location:../page_appointment_professor.php");
    }

?>