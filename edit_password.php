<?php 

    session_start();

    require('back_end/server.php');
    require('back_end/funtion.php');

    if(!isset($_SESSION['id'])){
        header("Location: index.php");
        session_destroy();
        exit();
    }

    $id = $_SESSION['id'];
    $ID_personnel = $_SESSION['ID_personnel'] ?? '';
    $name = $_SESSION['name'] ?? '';
    $email = $_SESSION['email'] ?? '';
    $level = $_SESSION['level'] ?? 1;

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>CS BRU - แก้ไขรหัสผ่าน</title>
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

        /* ป้องกันแถบสี Autofill ของเบราว์เซอร์ */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-text-fill-color: #f8fafc !important;
            -webkit-box-shadow: 0 0 0px 1000px #0f172a inset !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        .form-floating > label {
            color: #94a3b8;
        }

        .form-floating > .form-control-dark:focus ~ label,
        .form-floating > .form-control-dark:not(:placeholder-shown) ~ label {
            color: #38bdf8;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #94a3b8;
            z-index: 10;
        }

        .toggle-password:hover {
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

        .swal2-popup-dark {
            background: #1e293b !important;
            color: #f8fafc !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 16px !important;
        }
    </style>
</head>

<body class="theme-dark">

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-7">

                <div class="card card-dark p-3 p-md-4">
                    
                    <div class="text-center pt-2 pb-3">
                        <img src="img/cs_bru_logo.png" alt="CS BRU Logo" class="logo-header img-fluid mb-3">
                        <h3 class="fw-bold text-white mb-1">แก้ไขรหัสผ่าน</h3>
                        <p class="text-secondary small">ระบบจัดการรหัสผ่าน CS BRU</p>
                    </div>

                    <div class="card-body pt-0">
                        <form action="back_end/edit_password.php" method="POST" onsubmit="return validateForm()">

                            <!-- ช่องระบุบัญชีซ่อนเพื่อความถูกต้องของ Password Manager -->
                            <input type="text" name="username" value="<?php echo htmlspecialchars($email); ?>" autocomplete="username" hidden>

                            <!-- รหัสผ่านเดิม -->
                            <div class="form-floating mb-3 position-relative">
                                <input class="form-control form-control-dark pe-5" id="inputOldPassword" required type="password" name="password" 
                                    minlength="6" placeholder="รหัสผ่านเดิม" autocomplete="current-password" />
                                <label for="inputOldPassword"><i class="fa-solid fa-lock me-1"></i> รหัสผ่านเดิม</label>
                                <i class="fa-solid fa-eye toggle-password" onclick="togglePass('inputOldPassword', this)"></i>
                            </div>

                            <!-- รหัสผ่านใหม่ & ยืนยันรหัสผ่าน -->
                            <div class="row mb-3 g-3">
                                <div class="col-md-6">
                                    <div class="form-floating position-relative">
                                        <input class="form-control form-control-dark pe-5" id="inputNewPassword1" required name="new_password_1" minlength="6" 
                                            type="password" placeholder="รหัสผ่านใหม่" autocomplete="new-password" />
                                        <label for="inputNewPassword1"><i class="fa-solid fa-key me-1"></i> รหัสผ่านใหม่</label>
                                        <i class="fa-solid fa-eye toggle-password" onclick="togglePass('inputNewPassword1', this)"></i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating position-relative">
                                        <input class="form-control form-control-dark pe-5" id="inputNewPassword2" required name="new_password_2" minlength="6" 
                                            type="password" placeholder="ยืนยันรหัสผ่าน" autocomplete="new-password" />
                                        <label for="inputNewPassword2"><i class="fa-solid fa-shield-halved me-1"></i> ยืนยันรหัสผ่าน</label>
                                        <i class="fa-solid fa-eye toggle-password" onclick="togglePass('inputNewPassword2', this)"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- ปุ่มส่งข้อมูล -->
                            <div class="d-grid gap-2 mt-4">
                                <button class="btn btn-glow py-3 fs-6" type="submit">
                                    <i class="fa-solid fa-key me-1"></i> แก้ไขรหัสผ่าน
                                </button>
                            </div>

                        </form>
                    </div>

                    <div class="card-footer bg-transparent border-top-0 text-center pt-2 pb-3">
                        <a href="page_main.php" class="text-decoration-none small text-info fw-bold">
                            <i class="fa-solid fa-arrow-left me-1"></i> กลับไปหน้าโปรไฟล์ของฉัน
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        function togglePass(inputId, icon) {
            const input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        function validateForm() {
            const pass1 = document.getElementById("inputNewPassword1").value;
            const pass2 = document.getElementById("inputNewPassword2").value;

            if (pass1 !== pass2) {
                Swal.fire({
                    icon: 'error',
                    title: 'รหัสผ่านใหม่ไม่ตรงกัน',
                    text: 'กรุณาตรวจสอบการยืนยันรหัสผ่านใหม่อีกครั้ง',
                    confirmButtonColor: '#0284c7',
                    customClass: { popup: 'swal2-popup-dark' }
                });
                return false;
            }
            return true;
        }
    </script>

    <?php if(isset($_SESSION['error'])){ ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'ไม่สามารถเปลี่ยนรหัสผ่านได้',
                text: '<?php echo $_SESSION['error']; ?>',
                confirmButtonColor: '#e11d48',
                customClass: { popup: 'swal2-popup-dark' }
            });
        </script>
    <?php unset($_SESSION['error']); } ?>

    <?php if(isset($_SESSION['succeed'])){ ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: '<?php echo $_SESSION['succeed']; ?>',
                confirmButtonColor: '#059669',
                customClass: { popup: 'swal2-popup-dark' }
            });
        </script>
    <?php unset($_SESSION['succeed']); } ?>

</body>

</html>