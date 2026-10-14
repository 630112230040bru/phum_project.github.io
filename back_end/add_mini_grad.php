<?php

    session_start();
    require('funtion.php');

    require('server.php');

    $id = $_GET['id'];
    $term = $_GET['term'];

    $id_coures = mysqli_real_escape_string($conn,$_POST['id_coures']);

    echo $sql_qurey = "INSERT INTO mini_grad(`id_student`,`id_course`,`year`)
    VALUES('$id','$id_coures','$term')";

    $resule = mysqli_query($conn,$sql_qurey);

    $_SESSION['succeed'] = "1";
    Header("location:../edit_grad.php?term=$term&user_id=$id");

?>