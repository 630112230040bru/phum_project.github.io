<?php
    session_start();
    require('server.php');
    require('funtion.php');
    
    $id = $_SESSION['id'];
    
    $header = "ระบบประเมินวิเคราะห์ผลการเรียนนักศึกษา";
    //$id_student = $_POST['id_student'];
    $id_professor = $_POST['id_professor'];
    $name = $_POST['name'];
    $date_time = $_POST['date_time'];
    $details_student = $_POST['details_student'];
    $details_professor = $_POST['details_professor'];
    
    $message = $header .
        "\n" . "ชื่อนักศึกษา: " . show_name_student_form_id( $id) .
        "\n" . "ชื่ออาจารย์: " . show_name_professor_form_id( $id_professor ) .
        "\n" . "ชื่อการนัดหมาย: " . $name .
        "\n" . "วันที่และเวลา: " . $date_time .
        "\n" . "ความคิดเห็นของนักศึกษา: " . $details_student .
        "\n" . "ความคิดเห็นของอาจารย์: " . $details_professor;
    
        
           
        sendlinemesg();
            
        sendEmail($message);  // เพิ่มการแจ้งเตือนทางอีเมล
        header('Content-Type: text/html; charset=utf8');
        $res = notify_message($message);

    
    
    function sendlinemesg() {
        define('LINE_API', "https://notify-api.line.me/api/notify");
        define('LINE_TOKEN', "CHnb3EOdLuuqc6YtBieq3iS0pdbGEGvdeH9IiQelI4F");
    
        function notify_message($message) {
            $queryData = array('message' => $message);
            $queryData = http_build_query($queryData, '', '&');
            $headerOptions = array(
                'http' => array(
                    'method' => 'POST',
                    'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
                        . "Authorization: Bearer " . LINE_TOKEN . "\r\n"
                        . "Content-Length: " . strlen($queryData) . "\r\n",
                    'content' => $queryData
                )
            );
            $context = stream_context_create($headerOptions);
            $result = file_get_contents(LINE_API, FALSE, $context);
            $res = json_decode($result);
            return $res;
        }
    }
    
    function sendEmail($message) {
        $to = "630112230040@bru.ac.th"; // แก้ไขเป็นที่อยู่อีเมลของคุณ
        $subject = "การแจ้งเตือนการนัดหมาย";
        $headers = "630112230040@bru.ac.th"; // แก้ไขเป็นที่อยู่อีเมลของคุณ
    
        mail($to, $subject, $message, $headers);
    }

    $id_student = mysqli_real_escape_string($conn,$_POST['id_student']);
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $date_time = mysqli_real_escape_string($conn,$_POST['date_time']);
    $details_student = mysqli_real_escape_string($conn,$_POST['details_student']);
    $details_professor = mysqli_real_escape_string($conn,$_POST['details_professor']);

    echo $sql_qurey = "INSERT INTO appointment(`name`, `id_student`,`id_professor`,`details_student`,`details_professor`,`date_time`,`level`)
    VALUES('$name','$id_student','$id','$details_student','$details_professor','$date_time','2')";

    $resule = mysqli_query($conn,$sql_qurey);

    $_SESSION['succeed'] = "1";
    Header("location:../page_appointment_professor.php");

?>

<?php

    // session_start();

    // require('server.php');

    // $id = $_SESSION['id'];

    // $id_student = mysqli_real_escape_string($conn,$_POST['id_student']);
    // $name = mysqli_real_escape_string($conn,$_POST['name']);
    // $date_time = mysqli_real_escape_string($conn,$_POST['date_time']);
    // $details_student = mysqli_real_escape_string($conn,$_POST['details_student']);
    // $details_professor = mysqli_real_escape_string($conn,$_POST['details_professor']);

    // echo $sql_qurey = "INSERT INTO appointment(`name`, `id_student`,`id_professor`,`details_student`,`details_professor`,`date_time`,`level`)
    // VALUES('$name','$id_student','$id','$details_student','$details_professor','$date_time','2')";

    // $resule = mysqli_query($conn,$sql_qurey);

    // $_SESSION['succeed'] = "1";
    // Header("location:../page_appointment_professor.php");

?>