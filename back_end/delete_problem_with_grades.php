<?php

    session_start();
    require("server.php");

    echo $id = $_GET['id'];
    $level = $_SESSION['level'];

    $sql = "DELETE FROM grad WHERE id = '$id'";
    $Data_qurey = mysqli_query($conn , $sql);

    $_SESSION['succeed'] = "1";

    if($level == 1){
        Header("location:../page_problem_with_grades.php");
    }
    if($level == 2){
        Header("location:../page_main_professor.php");
    }

?>