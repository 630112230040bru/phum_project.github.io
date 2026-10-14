<?php 

    session_start();

    require('back_end/server.php');
    require('back_end/funtion.php');

    /////ดึงข้อมูล อาจารย์ ทั้งหมด
    $sql = "SELECT * FROM user_professor";
    $resule_student = mysqli_query($conn,$sql);
    $count_data = mysqli_num_rows($resule_student);

    $id = $_SESSION['id'];

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>CS BRU - เพิ่มข้อมูลอาจารย์</title>
    <link rel="shortcut icon" href="img/LOGO-bru.png">
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Cyber / Dark Glass Custom Theme Styling -->
    <style>
        body.theme-dark {
            background: #0f172a;
            min-height: 100vh;
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

        .form-control-dark {
            background-color: rgba(15, 23, 42, 0.7) !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            color: #f8fafc !important;
            border-radius: 10px;
        }

        .form-control-dark:focus {
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

        .toggle-password-btn {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            z-index: 10;
        }

        .toggle-password-btn:hover {
            color: #38bdf8;
        }

        /* SweetAlert2 Custom Dark Theme */
        .swal2-popup-dark {
            background: #1e293b !important;
            color: #f8fafc !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 16px !important;
        }
        .swal2-title-dark {
            color: #f43f5e !important;
        }
    </style>
</head>

<body class="theme-dark">

    <div class="container py-4">
        
        <!-- Logo หัวเรื่อง -->
        <div class="text-center mb-4">
            <img src="img/cs_bru_logo.png" alt="CS BRU Logo" class="logo-header img-fluid">
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-lg-7" id="form_2">

                <!-- แสดงข้อผิดพลาด Session (ถ้ามี) -->
                <?php if(isset($_SESSION['error[]'])){ ?>
                    <div class="mb-3">
                        <?php 
                            error_show($_SESSION['error[]']);
                            unset($_SESSION['error[]']);
                        ?>
                    </div>
                <?php } ?>

                <div class="card card-dark p-3 p-md-4">
                    
                    <div class="text-center pt-2 pb-3">
                        <h3 class="fw-bold text-white mb-1"><i class="fa-solid fa-user-plus text-info me-2"></i> เพิ่มข้อมูลอาจารย์</h3>
                        <p class="text-secondary small">กรอกรายละเอียดเพื่อสร้างบัญชีสำหรับอาจารย์ใหม่</p>
                    </div>

                    <div class="card-body pt-0">
                        <form id="addProfessorForm" action="back_end/add_professor.php" method="POST" onsubmit="return validatePasswordMatch(event)">

                            <!-- ชื่อ - นามสกุล -->
                            <div class="row mb-3 g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control form-control-dark" id="inputFirstName" required name="f_name"
                                            type="text" placeholder="ชื่อ" />
                                        <label for="inputFirstName"><i class="fa-solid fa-user me-1"></i> ชื่อ</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control form-control-dark" id="inputLastName" required name="l_name"
                                            type="text" placeholder="นามสกุล" />
                                        <label for="inputLastName"><i class="fa-solid fa-user me-1"></i> นามสกุล</label>
                                    </div>
                                </div>
                            </div>

                            <!-- อีเมล -->
                            <div class="form-floating mb-3">
                                <input class="form-control form-control-dark" id="inputEmail" required type="email" name="email"
                                    placeholder="email@bru.ac.th" />
                                <label for="inputEmail"><i class="fa-solid fa-envelope me-1"></i> อีเมล (email)</label>
                            </div>

                            <!-- รหัสผ่าน & ยืนยันรหัสผ่าน -->
                            <div class="row mb-4 g-3">
                                <div class="col-md-6">
                                    <div class="position-relative">
                                        <div class="form-floating">
                                            <input class="form-control form-control-dark pe-5" id="inputPassword1" required name="password_1" minlength="8"
                                                type="password" placeholder="รหัสผ่าน" />
                                            <label for="inputPassword1"><i class="fa-solid fa-lock me-1"></i> รหัสผ่าน (อย่างน้อย 8 ตัว)</label>
                                        </div>
                                        <button type="button" class="toggle-password-btn" onclick="togglePassword('inputPassword1', 'eyeIcon1')">
                                            <i class="fa-solid fa-eye" id="eyeIcon1"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative">
                                        <div class="form-floating">
                                            <input class="form-control form-control-dark pe-5" id="inputPassword2" required name="password_2" minlength="8"
                                                type="password" placeholder="ยืนยันรหัสผ่าน" />
                                            <label for="inputPassword2"><i class="fa-solid fa-shield-halved me-1"></i> ยืนยันรหัสผ่าน</label>
                                        </div>
                                        <button type="button" class="toggle-password-btn" onclick="togglePassword('inputPassword2', 'eyeIcon2')">
                                            <i class="fa-solid fa-eye" id="eyeIcon2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- ปุ่มส่งข้อมูล -->
                            <div class="d-grid gap-2">
                                <button class="btn btn-glow py-3 fs-6" type="submit">
                                    <i class="fa-solid fa-plus me-1"></i> เพิ่มข้อมูลอาจารย์
                                </button>
                            </div>

                        </form>
                    </div>

                    <div class="card-footer bg-transparent border-top-0 text-center pt-2 pb-2">
                        <a href="page_data_professor.php" class="text-decoration-none small text-info fw-bold">
                            <i class="fa-solid fa-arrow-left me-1"></i> กลับหน้าเดิม
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Script Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@5.0.3" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        // ฟังก์ชันเปิด/ปิดแสดงตัวอักษรรหัสผ่าน
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }

        // ตรวจสอบการป้อนรหัสผ่านให้ตรงกันก่อน Submit
        function validatePasswordMatch(event) {
            const p1 = document.getElementById('inputPassword1').value;
            const p2 = document.getElementById('inputPassword2').value;

            if (p1 !== p2) {
                event.preventDefault(); // ระงับการส่งฟอร์ม
                Swal.fire({
                    icon: 'error',
                    title: 'รหัสผ่านไม่ตรงกัน',
                    text: 'กรุณากรอกรหัสผ่านและยืนยันรหัสผ่านให้ตรงกัน',
                    confirmButtonColor: '#0284c7',
                    customClass: {
                        popup: 'swal2-popup-dark',
                        title: 'swal2-title-dark'
                    }
                });
                return false;
            }
            return true;
        }
    </script>

</body>

</html>