<?php

    require('server.php');
    session_start(); 

    $email = $_POST['email'];
    $password = md5( $_POST['password'] );

    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = mysqli_real_escape_string($conn,md5($_POST['password']));

    //////หา นศ.//////////////
    $sql = "SELECT * FROM user_student WHERE email = '$email' AND password = '$password'";
    $resule_student = mysqli_query($conn,$sql);

    //////หา อาจารย์//////////////
    $sql = "SELECT * FROM user_professor WHERE email = '$email' AND password = '$password'" ;
    $resule_professor = mysqli_query($conn,$sql);

    //////หา admin//////////////
    $sql = "SELECT * FROM user_admin WHERE email = '$email' AND password = '$password'";
    $resule_admin = mysqli_query($conn,$sql);

    if(mysqli_num_rows($resule_student) == 1){ //////หา นศ.

        $row = mysqli_fetch_assoc($resule_student);

        $_SESSION['id'] = $row['id'];
        $_SESSION['ID_personnel'] = $row['ID_student'];
        $_SESSION['name'] = $row['f_name']." ".$row['l_name'];
        $_SESSION['email'] = $email;
        $_SESSION['level'] = $row['level'];

        Header("Location:../page_main.php");
    }
    else if(mysqli_num_rows($resule_professor) == 1){ //////หา อาจารย์

        $row = mysqli_fetch_assoc($resule_professor);

        $_SESSION['id'] = $row['id'];
        $_SESSION['ID_personnel'] = "0";
        $_SESSION['name'] = $row['f_name']." ".$row['l_name'];
        $_SESSION['email'] = $email;
        $_SESSION['level'] = $row['level'];

        Header("Location:../page_main_professor.php");

    }else if(mysqli_num_rows($resule_admin) == 1){ //////หา admin

        $row = mysqli_fetch_assoc($resule_admin);

        $_SESSION['id'] = $row['id'];
        $_SESSION['level'] = $row['level'];

        Header("Location:../page_data_student.php");
    
    } 
    else{
        $_SESSION['error'] = "กรุณาลองอีกครั้ง";
        Header("Location:../index.php");
    }


?>