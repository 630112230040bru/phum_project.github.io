<?php

    session_start();
    require("server.php");

    $id = $_GET['id'];

    $sql = "DELETE FROM course WHERE id = '$id'";
    $Data_qurey = mysqli_query($conn , $sql);

    $_SESSION['succeed'] = "1";

    Header("location:../page_course.php");



?>