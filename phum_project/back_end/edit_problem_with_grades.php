<?php

    session_start();

    require('server.php');
    require('funtion.php');

    $id = $_SESSION['id'];

    $id_grad = $_POST['id_grad'];
    $gender = $_POST['gender'];
    $coures = $_POST['coures'];

    echo "<pre>";
    print_r($coures);
    echo "</pre>";

    for($i = 0 ; $i < count($coures) ; $i++){


        $id_professor = coures_d($coures[$i])['id_professor'];


        echo $sql_qurey = "UPDATE grad SET `id_student` = '$id' , `id_course` = '$coures[$i]' ,  `id_professor` = $id_professor
        ,`grad` = '$gender[$i]' WHERE id = '$id_grad[$i]'";

        mysqli_query($conn,$sql_qurey);

    }

    $_SESSION['succeed'] = "1";
    Header("location:../page_problem_with_grades.php");

?>