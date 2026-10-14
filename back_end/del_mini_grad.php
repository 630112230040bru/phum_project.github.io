<?php

    session_start();
    require("server.php");

    $id = $_GET['id'];
    $id_me = $_GET['id_me'];
    $term = $_GET['term'];

    $sql = "DELETE FROM mini_grad WHERE id = '$id'";
    $Data_qurey = mysqli_query($conn , $sql);

    
    $_SESSION['succeed'] = "1";
    Header("location:../edit_grad.php?term=$term&user_id=$id_me");
?>