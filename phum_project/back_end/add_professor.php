<?php

    session_start();

    require('server.php');

    $error = array();

    $f_name = mysqli_real_escape_string($conn,$_POST['f_name']);
    $l_name = mysqli_real_escape_string($conn,$_POST['l_name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password_1 = mysqli_real_escape_string($conn,$_POST['password_1']);
    $password_2 = mysqli_real_escape_string($conn,$_POST['password_2']);

    ////// query หา email ซ้ำ /////
    $sql = "SELECT * FROM user_professor WHERE email = '$email'" ;
    $query = mysqli_query($conn , $sql);

    if($password_1 != $password_2){
        array_push($error , "password ไม่ตรงกัน");
    }
    if(mysqli_num_rows($query)){
        array_push($error , "มี email อยู่แล้ว");
    }

    if(count($error) == 0){

        $password = md5($password_1);

        $sql_qurey = "INSERT INTO user_professor(`f_name`,`l_name`,`email`,`password`)
        VALUES('$f_name','$l_name','$email','$password')";

        $resule = mysqli_query($conn,$sql_qurey);

        $_SESSION['succeed'] = "1";

        Header("location:../page_data_professor.php");

    }else{

        $_SESSION['error[]'] = $error;
        Header("location:../add_professor.php");
    }

?>