<?php

    session_start();

    // NULL = ค่าว่าง

    require('server.php');

    $error = array();

    $ID_student = mysqli_real_escape_string($conn,$_POST['ID_student']);
    $f_name = mysqli_real_escape_string($conn,$_POST['f_name']);
    $l_name = mysqli_real_escape_string($conn,$_POST['l_name']);
    $gender = mysqli_real_escape_string($conn,$_POST['gender']);
    $year = mysqli_real_escape_string($conn,$_POST['year']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password_1 = mysqli_real_escape_string($conn,$_POST['password_1']);
    $password_2 = mysqli_real_escape_string($conn,$_POST['password_2']);

    if( empty( $ID_student ) ){
        array_push($error , "ไม่ได้กรอกเลข นศ.");
    }
    if( empty( $f_name ) ){
        array_push($error , "ไม่ได้กรอกเลข ชื่อ");
    }
    if( empty( $l_name ) ){
        array_push($error , "ไม่ได้กรอกเลข นามสกุล");
    }
    if( empty( $gender ) ){
        array_push($error , "ไม่ได้กรอกเลข เพศ");
    }
    if( empty( $year ) ){
        array_push($error , "ไม่ได้กรอกเลข year");
    }
    if( empty( $email ) ){
        array_push($error , "ไม่ได้กรอกเลข email");
    }
    if( empty( $password_1 ) ){
        array_push($error , "ไม่ได้กรอกเลข password_1");
    }
    if( empty( $password_2 ) ){
        array_push($error , "ไม่ได้กรอกเลข password_2");
    }
    if( $password_1 != $password_2  ){
        array_push($error , "password ไม่ตรงกัน");
    }

    $sql_qurey = "INSERT INTO user_student(`ID_student`,`f_name`,`l_name`,`gender`,`year`,`email`,`password`)
                                    VALUES('$ID_student','$f_name','$l_name','$gender','$year','$email','$password')";

    ////// query หา email ซ้ำ /////
    $sql = "SELECT * FROM user_student WHERE email = '$email'" ;
    $query = mysqli_query($conn , $sql);

    // if($password_1 != $password_2){
    //     array_push($error , "password ไม่ตรงกัน");
    // }
    if( mysqli_num_rows($query) ){
        array_push($error , "มี email อยู่แล้ว");
    }

    if(count($error) == 0){

        $password = md5($password_1);

        $sql_qurey = "INSERT INTO user_student(`ID_student`,`f_name`,`l_name`,`gender`,`year`,`email`,`password`)
        VALUES('$ID_student','$f_name','$l_name','$gender','$year','$email','$password')";

        $resule = mysqli_query($conn,$sql_qurey);

        Header("location:../index.php");

    }else{

        $_SESSION['error[]'] = $error;
        Header("location:../register.php");

    }

?>