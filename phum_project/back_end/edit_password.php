<?php

    session_start();

    require('server.php');

    $id = $_SESSION['id'];
    $level = $_SESSION['level'];

    $password = md5(mysqli_real_escape_string($conn,$_POST['password']));
    $new_password_1 = mysqli_real_escape_string($conn,$_POST['new_password_1']);
    $new_password_2 = mysqli_real_escape_string($conn,$_POST['new_password_2']);

    if($level == 1){
        if($password == $row_me['password']){

            $sql = "SELECT * FROM user_student WHERE id = '$id' ";
            $resule_student = mysqli_query($conn,$sql);
            $row_me = mysqli_fetch_assoc($resule_student);

            $new_password_1 = md5($new_password_1);
            $sql_qurey = "UPDATE user_student SET `password` = '$new_password_1' WHERE id = '$id'";
            $query = mysqli_query($conn , $sql_qurey);
    
            $_SESSION['succeed'] = "1";
            Header("location:../page_main.php");
        
        }else{
            $_SESSION['error'] = "1";
            Header("location:../edit_password.php");
        }
    }

    if($level == 2){

        $sql = "SELECT * FROM user_professor WHERE id = '$id' ";
        $resule_student = mysqli_query($conn,$sql);
        $row_me = mysqli_fetch_assoc($resule_student);

        if($password == $row_me['password']){

            $new_password_1 = md5($new_password_1);
            $sql_qurey = "UPDATE user_professor SET `password` = '$new_password_1' WHERE id = '$id'";
            $query = mysqli_query($conn , $sql_qurey);
    
            $_SESSION['succeed'] = "1";
            Header("location:../page_main_professor.php");
        
        }else{
            $_SESSION['error'] = "1";
            Header("location:../edit_password.php");
        }
    }

?>