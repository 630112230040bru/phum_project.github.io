<?php

session_start();

// ดึงไฟล์เชื่อมต่อฐานข้อมูล
require('server.php');
require('funtion.php');

// 1. ตรวจสอบการล็อกอิน
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    session_destroy();
    exit();
}

$student_id =$_SESSION['id'];
$level =$_SESSION['level'] ?? 1;

// 2. ตรวจสอบว่ามีการส่ง id รายการที่จะลบมาหรือไม่
if (isset($_GET['id']) and !empty($_GET['id'])) {

    $id = mysqli_real_escape_string($conn,$_GET['id']);

    // 3. ตรวจสอบสิทธิ์ (ถ้านักศึกษาทั่วไป ให้ลบได้เฉพาะรายการของตัวเอง)
    if ($level == 1) {$sql_delete = "DELETE FROM `grad` WHERE `id` = '$id' AND `id_student` = '$student_id'";
    } else {
        // อาจารย์หรือ Admin ลบรายการได้ทั้งหมด
        $sql_delete = "DELETE FROM `grad` WHERE `id` = '$id'";
    }

    $query_delete = mysqli_query($conn,$sql_delete);

    if ($query_delete and mysqli_affected_rows($conn) > 0) {$_SESSION['succeed'] = "ลบรายการผลการเรียนที่มีปัญหาเรียบร้อยแล้ว";
    } else {
        $_SESSION['error'] = "เกิดข้อผิดพลาด ไม่สามารถลบข้อมูลได้ หรือไม่พบรายการนี้";
    }

} else {
    $_SESSION['error'] = "ไม่พบรหัสรายการที่ต้องการลบ";
}

// Redirect กลับไปยังหน้าเดิม
$redirect_url =$_SERVER['HTTP_REFERER'] ?? '../page_problem_with_grades.php';
header("Location: $redirect_url");
exit();

?>