<?php

    session_start();
    require('server.php');

    if(!isset($_SESSION['user_email'])){
        Header("Location:index.php");
        session_destroy();
    }

    $email = $_SESSION['user_email'];

    if($_FILES['myfile'] != NULL){

        $name_file =  $email.".pdf";
        $tmp_name =  $_FILES['myfile']['tmp_name'];
        $locate_img ="../pdf_test/";

        move_uploaded_file($tmp_name,$locate_img.$name_file);

    }

    $id_test = $_GET['id_test'];
    $id_me = $_GET['id_me'];
    $leve_test = $_GET['leve_test'];

    $sql_qurey = "INSERT INTO test(id_student,leve_test,id_test)
            VALUES('$id_me','$leve_test','$id_test')";

    mysqli_query($conn,$sql_qurey);

    $_SESSION['succeed'] = "1";

    Header("location:../home.php");

?>