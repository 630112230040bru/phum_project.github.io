<?php 
session_start();

require('back_end/server.php');
require('back_end/funtion.php');

if (!isset($_SESSION['id'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

$id = $_SESSION['id'];

// ดึงข้อมูลผู้ใช้งานปัจจุบัน
$sql = "SELECT * FROM user_student WHERE id = '$id'";
$result_student = mysqli_query($conn, $sql);
$row_me = mysqli_fetch_assoc($result_student);
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>CS BRU - แก้ไขข้อมูลส่วนตัว</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="img/LOGO-bru.png">
</head>

<body class="bg-info">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="text-center my-3">
                    <img src="img/cs_bru_logo.png" alt="CS BRU Logo" style="max-width: 200px;">
                </div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">

                            <?php if (isset($_SESSION['error'])): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php 
                                        echo $_SESSION['error']; 
                                        unset($_SESSION['error']);
                                    ?>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($_SESSION['success'])): ?>
                                <div class="alert alert-success" role="alert">
                                    <?php 
                                        echo $_SESSION['success']; 
                                        unset($_SESSION['success']);
                                    ?>
                                </div>
                            <?php endif; ?>

                            <div class="card shadow-lg border-0 rounded-lg mt-3 mb-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">แก้ไขข้อมูลส่วนตัว</h3>
                                </div>
                                <div class="card-body">
                                    <form action="back_end/edit_user_profile.php" method="POST" enctype="multipart/form-data">

                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">เลือกรูปภาพประจำตัว (รองรับ .jpg, .png)</label>
                                            <input class="form-control" type="file" name="file" id="formFile" accept="image/*">
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputStudentId" required type="text" name="ID_student" 
                                                maxlength="12" value="<?php echo htmlspecialchars($row_me['ID_student'] ?? ''); ?>"
                                                placeholder="รหัสนักศึกษา 12 หลัก" />
                                            <label for="inputStudentId">รหัสนักศึกษา 12 หลัก</label>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputFirstName" required name="f_name"
                                                        type="text" placeholder="ชื่อ" value="<?php echo htmlspecialchars($row_me['f_name'] ?? ''); ?>" />
                                                    <label for="inputFirstName">ชื่อ (ไม่ต้องใส่คำนำหน้า)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="inputLastName" required name="l_name"
                                                        type="text" placeholder="นามสกุล" value="<?php echo htmlspecialchars($row_me['l_name'] ?? ''); ?>" />
                                                    <label for="inputLastName">นามสกุล</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <select class="form-select" id="gender" required name="gender">
                                                        <option value="">เพศ</option>
                                                        <option value="1" <?php echo (isset($row_me['gender']) && $row_me['gender'] == 1) ? 'selected' : ''; ?>>ชาย</option>
                                                        <option value="2" <?php echo (isset($row_me['gender']) && $row_me['gender'] == 2) ? 'selected' : ''; ?>>หญิง</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <select class="form-select" id="year" required name="year">
                                                        <option value="">ชั้นปีที่</option>
                                                        <option value="1" <?php echo (isset($row_me['year']) && $row_me['year'] == 1) ? 'selected' : ''; ?>>ปี 1</option>
                                                        <option value="2" <?php echo (isset($row_me['year']) && $row_me['year'] == 2) ? 'selected' : ''; ?>>ปี 2</option>
                                                        <option value="3" <?php echo (isset($row_me['year']) && $row_me['year'] == 3) ? 'selected' : ''; ?>>ปี 3</option>
                                                        <option value="4" <?php echo (isset($row_me['year']) && $row_me['year'] == 4) ? 'selected' : ''; ?>>ปี 4</option>
                                                        <option value="5" <?php echo (isset($row_me['year']) && $row_me['year'] > 4) ? 'selected' : ''; ?>>มากกว่า 4 ปี</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" required id="myEmail" type="email" name="email" readonly
                                                value="<?php echo htmlspecialchars($row_me['email'] ?? ''); ?>"/>
                                            <label for="myEmail">ที่อยู่ Email BRU (แก้ไขไม่ได้)</label>
                                        </div>
                                        
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <button class="btn btn-primary btn-block" type="submit" name="update_profile">บันทึกการแก้ไขข้อมูล</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="page_main.php">กลับไปหน้าโปรไฟล์ของฉัน</a></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>