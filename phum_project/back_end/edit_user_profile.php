<?php

    session_start();

    require('server.php');

    if(!isset($_SESSION['id'])){
        Header("Location:index.php");
        session_destroy();
    }

    $id = $_SESSION['id'];

    $ID_student = mysqli_real_escape_string($conn,$_POST['ID_student']);
    $f_name = mysqli_real_escape_string($conn,$_POST['f_name']);
    $l_name = mysqli_real_escape_string($conn,$_POST['l_name']);
    $gender = mysqli_real_escape_string($conn,$_POST['gender']);
    $year = mysqli_real_escape_string($conn,$_POST['year']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);

    ////// query หา email ซ้ำ /////
    $sql_qurey = "UPDATE user_student SET `ID_student` = '$ID_student' , `f_name` = '$f_name' , `l_name` = '$l_name' 
    , `gender` = '$gender' ,`year` = '$year' ,`email` = '$email' WHERE id = '$id'";
    $query = mysqli_query($conn , $sql_qurey);

    if( $_FILES['file'] != NULL ){ //จะแก้ไข file jpg เมื่อมีการอัพโหลดเข้ามา

        ///////////////////////อัพโหลด file pdf///////////////////////
        $name_file = "$id.jpg";                                     // ตั่งชื่อ file
        $tmp_name =  $_FILES['file']['tmp_name'];                   // รับค่า file
        $locate_img ="../img/";                                     // เลือกตำแหน่งเก็บ file
        move_uploaded_file($tmp_name,$locate_img.$name_file);       // ทำการนำ file ไปเก็บในระบบ
        //////////////////////////////////////////////////////////////

    }

    $_SESSION['succeed'] = "1";
    Header("location:../page_main.php");


?>