<?php 

session_start();

require('server.php');
require('funtion.php');

// 1. ตรวจสอบการล็อกอิน
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    session_destroy();
    exit();
}

$id =$_SESSION['id'];
$level =$_SESSION['level'] ?? 1;

// 2. ตรวจสอบการส่งข้อมูลแบบ POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $old_password = isset($_POST['password']) ? mysqli_real_escape_string($conn,$_POST['password']) : '';
    $new_password_1 = isset($_POST['new_password_1']) ? mysqli_real_escape_string($conn,$_POST['new_password_1']) : '';
    $new_password_2 = isset($_POST['new_password_2']) ? mysqli_real_escape_string($conn,$_POST['new_password_2']) : '';

    // ตรวจสอบข้อมูลสกัดกั้นค่าว่าง
    if (empty($old_password) or empty($new_password_1) or empty($new_password_2)) {$_SESSION['error'] = "กรุณากรอกข้อมูลให้ครบทุกช่อง";
        header("Location: ../edit_password.php");
        exit();
    }

    // 3. ตรวจสอบว่ารหัสผ่านใหม่ตรงกันหรือไม่
    if ($new_password_1 !== $new_password_2) {$_SESSION['error'] = "รหัสผ่านใหม่ไม่ตรงกัน";
        header("Location: ../edit_password.php");
        exit();
    }

    // 4. เลือกตารางตาม Level
    $table = ($level == 1) ? "user_student" : "user_professor";

    // 5. ดึงข้อมูลผู้ใช้
    $sql_check = "SELECT * FROM `$table` WHERE `id` = '$id'";
    $result = mysqli_query($conn,$sql_check);

    if ($result and mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $pass_column = isset($row['password']) ? 'password' : (isset($row['pass']) ? 'pass' : 'password');$db_password = $row[$pass_column];

        // 6. ตรวจสอบรหัสผ่านเดิม (ใช้ if / elseif แยกเช็คเพื่อหลีกเลี่ยงเครื่องหมาย pipe)
        $is_old_pass_valid = false;

        if ($old_password === $db_password) {$is_old_pass_valid = true;
        } elseif (md5($old_password) === $db_password) {$is_old_pass_valid = true;
        } elseif (password_verify($old_password, $db_password)) {$is_old_pass_valid = true;
        }

        if ($is_old_pass_valid) {
            
            $new_password_encoded = md5($new_password_1);

            $sql_update = "UPDATE `$table` SET `$pass_column` = '$new_password_encoded' WHERE `id` = '$id'";
            $query_update = mysqli_query($conn,$sql_update);

            if ($query_update) {$_SESSION['succeed'] = "เปลี่ยนรหัสผ่านเรียบร้อยแล้ว";
                header("Location: ../edit_password.php");
                exit();
            } else {
                $_SESSION['error'] = "เกิดข้อผิดพลาดทางระบบ ไม่สามารถอัปเดตรหัสผ่านได้";
                header("Location: ../edit_password.php");
                exit();
            }

        } else {
            $_SESSION['error'] = "รหัสผ่านเดิมไม่ถูกต้อง";
            header("Location: ../edit_password.php");
            exit();
        }

    } else {
        $_SESSION['error'] = "ไม่พบข้อมูลผู้ใช้ในระบบ";
        header("Location: ../edit_password.php");
        exit();
    }

} else {
    header("Location: ../edit_password.php");
    exit();
}

?>