<?php

    session_start();

    require('server.php');
    require('funtion.php');

    $id = $_SESSION['id'];

    $id = $_GET['id'];
    $term = $_GET['term'];

    $id_grad = $_POST['id_grad'];
    $gender = $_POST['gender'];

    echo "<pre>";
    print_r($id_grad);
    echo "</pre>";

    echo "<pre>";
    print_r($gender);
    echo "</pre>";

    for($i = 0 ; $i < count($gender) ; $i++){


        echo $sql_qurey = "UPDATE mini_grad SET `grad` = '$gender[$i]' WHERE id = '$id_grad[$i]'";

        mysqli_query($conn,$sql_qurey);

    }

    $_SESSION['succeed'] = "1";
    Header("location:../edit_grad.php?term=$term&user_id=$id");

?>