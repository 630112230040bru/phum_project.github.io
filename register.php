<?php 
session_start();

require('back_end/server.php');
require('back_end/funtion.php');
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>CS BRU - ลงทะเบียนนักศึกษา</title>
    <link rel="shortcut icon" href="img/LOGO-bru.png">
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Cyber / Dark Glass Custom Theme Styling -->
    <style>
        body.theme-dark {
            background: #0f172a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f8fafc;
            padding: 30px 0;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
        }

        .card-dark {
            background: rgba(30, 41, 59, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .form-control-dark, .form-select-dark {
            background-color: rgba(15, 23, 42, 0.7) !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            color: #f8fafc !important;
            border-radius: 10px;
        }

        .form-control-dark:focus, .form-select-dark:focus {
            border-color: #38bdf8 !important;
            box-shadow: 0 0 0 0.25rem rgba(56, 189, 248, 0.25) !important;
            background-color: rgba(15, 23, 42, 0.9) !important;
        }

        .form-floating > label {
            color: #94a3b8;
        }

        .form-floating > .form-control-dark:focus ~ label,
        .form-floating > .form-control-dark:not(:placeholder-shown) ~ label {
            color: #38bdf8;
        }

        .form-select-dark option {
            background-color: #1e293b;
            color: #f8fafc;
        }

        .btn-glow {
            background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%);
            color: #ffffff;
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 10px;
            box-shadow: 0 4px 14px 0 rgba(14, 165, 233, 0.39);
            transition: all 0.3s ease;
        }

        .btn-glow:hover {
            color: #ffffff;
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px 0 rgba(14, 165, 233, 0.5);
        }

        .logo-header {
            max-width: 150px;
            height: auto;
        }
    </style>
</head>

<body class="theme-dark">

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-7">

                <?php
                    if( isset( $_SESSION['error[]'] ) ){
                        $error = $_SESSION['error[]'];
                        $count = count($error);
                        for($i = 0 ; $i < $count ; $i++){
                            echo "<div class='alert alert-danger bg-danger text-white border-0 shadow-sm rounded-3 mb-3' role='alert'>
                                    <i class='fa-solid fa-triangle-exclamation me-2'></i> " . htmlspecialchars($error[$i]) . "
                                  </div>";
                        }
                    }
                ?>

                <div class="card card-dark p-3 p-md-4">
                    
                    <div class="text-center pt-2 pb-3">
                        <img src="img/cs_bru_logo.png" alt="CS BRU Logo" class="logo-header img-fluid mb-3">
                        <h3 class="fw-bold text-white mb-1">ลงทะเบียนนักศึกษา</h3>
                        <p class="text-secondary small">สาขาวิชาวิทยาการคอมพิวเตอร์ BRU</p>
                    </div>

                    <div class="card-body pt-0">
                        <form action="back_end/register.php" method="POST">

                            <!-- รหัสนักศึกษา -->
                            <div class="form-floating mb-3">
                                <input class="form-control form-control-dark" id="inputStudentId" type="text" name="ID_student" 
                                    minlength="12" placeholder="รหัสนักศึกษา 12 หลัก" required />
                                <label for="inputStudentId"><i class="fa-solid fa-id-card me-1"></i> รหัสนักศึกษา 12 หลัก</label>
                            </div>

                            <!-- ชื่อ - นามสกุล -->
                            <div class="row mb-3 g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control form-control-dark" id="inputFirstName" name="f_name"
                                            type="text" placeholder="ชื่อ" required />
                                        <label for="inputFirstName"><i class="fa-solid fa-user me-1"></i> ชื่อ (ไม่ต้องใส่คำนำหน้า)</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control form-control-dark" id="inputLastName" name="l_name"
                                            type="text" placeholder="นามสกุล" required />
                                        <label for="inputLastName"><i class="fa-solid fa-user me-1"></i> นามสกุล</label>
                                    </div>
                                </div>
                            </div>

                            <!-- เพศ & ชั้นปี -->
                            <div class="row mb-3 g-3">
                                <div class="col-md-6">
                                    <select class="form-select form-select-dark py-3 px-3" name="gender" required>
                                        <option value="" selected disabled>-- เลือกเพศ --</option>
                                        <option value="1">ชาย</option>
                                        <option value="2">หญิง</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <select class="form-select form-select-dark py-3 px-3" name="year" required>
                                        <option value="" selected disabled>-- เลือกชั้นปี --</option>
                                        <option value="1">ปี 1</option>
                                        <option value="2">ปี 2</option>
                                        <option value="3">ปี 3</option>
                                        <option value="4">ปี 4</option>
                                        <option value="5">มากกว่า 4 ปี</option>
                                    </select>
                                </div>
                            </div>

                            <!-- อีเมล -->
                            <div class="form-floating mb-3">
                                <input class="form-control form-control-dark" id="myEmail" type="email" name="email" maxlength="22"
                                    placeholder="อีเมล" value="@bru.ac.th" required />
                                <label for="myEmail"><i class="fa-solid fa-envelope me-1"></i> ที่อยู่ Email BRU</label>
                            </div>

                            <!-- รหัสผ่าน & ยืนยันรหัสผ่าน -->
                            <div class="row mb-3 g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control form-control-dark" id="inputPassword" type="password" minlength="8"
                                            name="password_1" placeholder="รหัสผ่าน" required />
                                        <label for="inputPassword"><i class="fa-solid fa-key me-1"></i> รหัสผ่าน (อย่างน้อย 8 ตัว)</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control form-control-dark" id="inputPasswordConfirm" minlength="8"
                                            name="password_2" type="password" placeholder="ยืนยันรหัสผ่าน" required />
                                        <label for="inputPasswordConfirm"><i class="fa-solid fa-shield-halved me-1"></i> ยืนยันรหัสผ่าน</label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- ปุ่มลงทะเบียน -->
                            <div class="d-grid gap-2 mt-4">
                                <button class="btn btn-glow py-3 fs-6" type="submit">
                                    <i class="fa-solid fa-user-plus me-1"></i> ลงทะเบียน
                                </button>
                            </div>

                        </form>
                    </div>

                    <div class="card-footer bg-transparent border-top-0 text-center pt-2 pb-3">
                        <a href="index.php" class="text-decoration-none small text-info fw-bold">
                            <i class="fa-solid fa-right-to-bracket me-1"></i> มีบัญชีผู้ใช้อยู่แล้ว? เข้าสู่ระบบ
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <?php session_destroy(); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>

</body>

</html>