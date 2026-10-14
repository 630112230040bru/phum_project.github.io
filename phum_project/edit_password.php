<?php 

    session_start();

    require('back_end/server.php');
    require('back_end/funtion.php');

    if(!isset($_SESSION['id'])){
        Header("Location:index.php");
        session_destroy();
    }

    $id = $_SESSION['id'];
    $ID_personnel = $_SESSION['ID_personnel'];
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $level = $_SESSION['level'];

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>CS BRU - เปลี่ยนรหัสผ่าน</title>
    <link rel="shortcut icon" href="img/LOGO-bru.png">
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Cyber / Dark Glass Custom Theme Styling -->
    <style>
        body.sb-nav-fixed.theme-dark {
            background-color: #0f172a;
            color: #f8fafc;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            min-height: 100vh;
        }

        /* Top Navbar */
        .sb-topnav.bg-dark-glass {
            background: rgba(15, 23, 42, 0.95) !important;
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Sidebar Navigation */
        .sb-sidenav-dark-glass {
            background: rgba(30, 41, 59, 0.9) !important;
            backdrop-filter: blur(12px);
            border-right: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sb-sidenav-dark-glass .sb-sidenav-menu .nav-link {
            color: #94a3b8;
            border-radius: 8px;
            margin: 2px 10px;
            transition: all 0.2s ease;
        }

        .sb-sidenav-dark-glass .sb-sidenav-menu .nav-link:hover,
        .sb-sidenav-dark-glass .sb-sidenav-menu .nav-link.active {
            color: #38bdf8;
            background: rgba(56, 189, 248, 0.12);
        }

        /* Dark Glass Card */
        .card-dark {
            background: rgba(30, 41, 59, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
        }

        .card-header-dark {
            background: rgba(15, 23, 42, 0.6);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            color: #38bdf8;
            font-weight: 600;
            border-top-left-radius: 16px !important;
            border-top-right-radius: 16px !important;
        }

        /* Dark Form Controls & Input Group */
        .form-control-dark {
            background-color: rgba(15, 23, 42, 0.7) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            color: #f8fafc !important;
            border-radius: 8px;
        }

        .form-control-dark:focus {
            border-color: #38bdf8 !important;
            box-shadow: 0 0 0 0.25rem rgba(56, 189, 248, 0.25) !important;
        }

        .input-group-text-dark {
            background-color: rgba(15, 23, 42, 0.8) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            color: #94a3b8 !important;
            cursor: pointer;
            border-top-right-radius: 8px !important;
            border-bottom-right-radius: 8px !important;
        }

        .input-group-text-dark:hover {
            color: #38bdf8 !important;
        }

        /* Custom Action Buttons */
        .btn-save-glow {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            border: 1px solid rgba(16, 185, 129, 0.4);
            color: #ffffff;
            border-radius: 8px;
            padding: 10px 24px;
            font-weight: 600;
            transition: all 0.2s ease;
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.3);
        }

        .btn-save-glow:hover {
            background: linear-gradient(135deg, #047857 0%, #059669 100%);
            color: #ffffff;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.5);
        }

        .btn-cancel-dark {
            background: rgba(100, 116, 139, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #cbd5e1;
            border-radius: 8px;
            padding: 10px 24px;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-cancel-dark:hover {
            background: rgba(100, 116, 139, 0.4);
            color: #ffffff;
        }

        /* Dropdown Menu Dark Theme */
        .dropdown-menu-dark-custom {
            background: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
        }

        .dropdown-menu-dark-custom .dropdown-item {
            color: #f8fafc;
        }

        .dropdown-menu-dark-custom .dropdown-item:hover {
            background: rgba(56, 189, 248, 0.15);
            color: #38bdf8;
        }

        /* SweetAlert2 Custom Dark */
        .swal2-popup-dark {
            background: #1e293b !important;
            color: #f8fafc !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 16px !important;
        }
    </style>
</head>

<body class="sb-nav-fixed theme-dark" <?php if( isset($_SESSION['succeed']) ){ echo "onload=JSalert()"; unset($_SESSION['succeed']); } ?>>

    <!-- Top Navbar -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark-glass">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3 fw-bold text-info" href="#"><i class="fa-solid fa-graduation-cap me-2"></i>CS BRU</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 text-light" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search Placeholder -->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></form>
        <!-- Navbar Profile Dropdown -->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-light" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo htmlspecialchars($name); ?> <i class="fas fa-user fa-fw text-info ms-1"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark-custom" aria-labelledby="navbarDropdown">
                    <?php require('link_drop_box.php'); ?>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">

        <!-- Sidebar Left Nav -->
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark-glass" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav pt-3">
                        <?php require('link.php'); ?>
                    </div>
                </div>
                <div class="sb-sidenav-footer bg-transparent border-top border-secondary p-3 text-center">
                    <img src="img/cs_bru_logo.png" width="80%" alt="CS BRU Logo">
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4 py-3">
                    
                    <h1 class="mt-2 fw-bold text-white"><i class="fa-solid fa-key me-2 text-info"></i>เปลี่ยนรหัสผ่าน</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item text-secondary">บัญชีผู้ใช้</li>
                        <li class="breadcrumb-item active text-info">เปลี่ยนรหัสผ่านบัญชี</li>
                    </ol>

                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-8">
                            
                            <!-- Card Form -->
                            <div class="card card-dark my-3">
                                <div class="card-header card-header-dark py-3">
                                    <i class="fa-solid fa-shield-halved me-2"></i> กำหนดรหัสผ่านใหม่555555555
                                </div>
                                
                                <div class="card-body p-4">
                                    <form action="back_end/edit_password.php" method="POST" onsubmit="return validatePasswordForm()">
                                        
                                        <!-- รหัสผ่านปัจจุบัน -->
                                        <div class="mb-3">
                                            <label class="form-label small text-secondary fw-semibold">รหัสผ่านปัจจุบัน <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="password" name="old_password" id="old_password" class="form-control form-control-dark" required placeholder="ป้อนรหัสผ่านเดิมของคุณ">
                                                <span class="input-group-text input-group-text-dark" onclick="togglePasswordVisibility('old_password', 'icon_old')">
                                                    <i class="fa-solid fa-eye" id="icon_old"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <hr class="border-secondary border-opacity-25 my-4">

                                        <!-- รหัสผ่านใหม่ -->
                                        <div class="mb-3">
                                            <label class="form-label small text-secondary fw-semibold">รหัสผ่านใหม่ <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="password" name="new_password" id="new_password" class="form-control form-control-dark" minlength="6" required placeholder="ป้อนรหัสผ่านใหม่ (อย่างน้อย 6 ตัวอักษร)">
                                                <span class="input-group-text input-group-text-dark" onclick="togglePasswordVisibility('new_password', 'icon_new')">
                                                    <i class="fa-solid fa-eye" id="icon_new"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <!-- ยืนยันรหัสผ่านใหม่ -->
                                        <div class="mb-4">
                                            <label class="form-label small text-secondary fw-semibold">ยืนยันรหัสผ่านใหม่ <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="password" name="confirm_password" id="confirm_password" class="form-control form-control-dark" minlength="6" required placeholder="ป้อนรหัสผ่านใหม่อีกครั้ง">
                                                <span class="input-group-text input-group-text-dark" onclick="togglePasswordVisibility('confirm_password', 'icon_confirm')">
                                                    <i class="fa-solid fa-eye" id="icon_confirm"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Advice Box -->
                                        <div class="p-3 bg-info bg-opacity-10 rounded-3 mb-4 border border-info border-opacity-20">
                                            <div class="d-flex align-items-start">
                                                <i class="fa-solid fa-circle-info text-info me-2 mt-1"></i>
                                                <div class="small text-secondary">
                                                    รหัสผ่านใหม่ควรมีความยาวอย่างน้อย 8 ตัวอักษร และผสมผสานตัวอักษรภาษาอังกฤษกับตัวเลขเพื่อความปลอดภัย
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Buttons -->
                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                            <a href="profile.php" class="btn btn-cancel-dark">
                                                <i class="fa-solid fa-xmark me-1"></i> ยกเลิก
                                            </a>
                                            <button type="submit" class="btn btn-save-glow">
                                                <i class="fa-solid fa-floppy-disk me-1"></i> บันทึกรหัสผ่านใหม่
                                            </button>
                                        </div>

                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        // Toggle Show/Hide Password
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
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

        // Validate New Password Matching
        function validatePasswordForm() {
            const newPassword = document.getElementById("new_password").value;
            const confirmPassword = document.getElementById("confirm_password").value;

            if (newPassword !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'รหัสผ่านไม่ตรงกัน!',
                    text: 'กรุณาตรวจสอบและป้อนรหัสผ่านใหม่ให้ตรงกันทั้งสองช่อง',
                    confirmButtonColor: '#e11d48',
                    customClass: {
                        popup: 'swal2-popup-dark'
                    }
                });
                return false;
            }
            return true;
        }

        // Alert on Success
        function JSalert() {
            Swal.fire({
                icon: 'success',
                title: 'เปลี่ยนรหัสผ่านสำเร็จ!',
                text: 'รหัสผ่านใหม่ของคุณได้รับการอัปเดตแล้ว',
                confirmButtonColor: '#059669',
                customClass: {
                    popup: 'swal2-popup-dark'
                }
            });
        }
    </script>

</body>

</html>