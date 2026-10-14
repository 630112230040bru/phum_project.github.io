<?php 

    session_start();

    require('back_end/server.php');
    require('back_end/funtion.php');

    if(!isset($_SESSION['id'])){
        Header("Location:index.php");
        session_destroy();
    }

    $id = $_SESSION['id'];
    UPDATE_grad($id);
    $ID_personnel = $_SESSION['ID_personnel'];
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $level = $_SESSION['level'];

    /////ดึงข้อมูลเรา
    $sql = "SELECT * FROM user_student WHERE id = '$id' ";
    $resule_student = mysqli_query($conn,$sql);
    $row_me = mysqli_fetch_assoc($resule_student);

    /////ดึงข้อมูลเกรดที่มีปัญหา
    $sql = "SELECT * FROM grad WHERE id_student = '$id' ";
    $resule_grad = mysqli_query($conn,$sql);
    $problem_grad = mysqli_num_rows($resule_grad);

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>CS BRU - โปรไฟล์ส่วนตัวนักศึกษา</title>
    <link rel="shortcut icon" href="img/LOGO-bru.png">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
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

        /* Dark Cards & Profile */
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

        .profile-img-glow {
            border: 3px solid #38bdf8;
            box-shadow: 0 0 20px rgba(56, 189, 248, 0.4);
            object-fit: cover;
        }

        /* Dark Form Controls */
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

        /* Progress Bar Neon */
        .progress-dark {
            background-color: rgba(15, 23, 42, 0.8);
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .progress-bar-glow {
            background: linear-gradient(90deg, #0284c7 0%, #38bdf8 100%);
            box-shadow: 0 0 10px rgba(56, 189, 248, 0.5);
        }

        /* Action Buttons */
        .btn-eye-glow {
            color: #38bdf8;
            padding: 2px 8px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .btn-eye-glow:hover {
            color: #ffffff;
            background: rgba(56, 189, 248, 0.2);
            box-shadow: 0 0 8px rgba(56, 189, 248, 0.4);
        }

        .btn-save-glow {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            border: 1px solid rgba(16, 185, 129, 0.4);
            color: #ffffff;
            border-radius: 8px;
            padding: 6px 16px;
            transition: all 0.2s ease;
        }

        .btn-save-glow:hover {
            background: linear-gradient(135deg, #047857 0%, #059669 100%);
            color: #ffffff;
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.4);
        }

        .btn-cancel-dark {
            background: rgba(100, 116, 139, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #cbd5e1;
            border-radius: 8px;
            padding: 6px 16px;
            transition: all 0.2s ease;
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
                    
                    <h1 class="mt-2 fw-bold text-white"><i class="fa-solid fa-user-graduate me-2 text-info"></i>โปรไฟล์ส่วนตัวนักศึกษา</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item text-secondary">นักศึกษา</li>
                        <li class="breadcrumb-item active text-info">ข้อมูลโปรไฟล์ส่วนตัว</li>
                    </ol>

                    <div class="row g-4">
                        
                        <!-- ฝั่งซ้าย: รูปโปรไฟล์ & ข้อมูลการติดต่อ (col-lg-4) -->
                        <div class="col-lg-4">
                            
                            <!-- Profile Card -->
                            <div class="card card-dark p-3 text-center mb-4">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <?php if( file_exists("img/$id.jpg") ){ ?>
                                            <img src="img/<?php echo $id ?>.jpg" class="rounded-circle profile-img-glow" width="140" height="140" alt="Student Profile">
                                        <?php }else{ ?>
                                            <img src="img/free_profile.png" alt="Profile" class="rounded-circle profile-img-glow" width="140" height="140">
                                        <?php } ?>
                                    </div>
                                    <h4 class="fw-bold text-white mb-1"><?php echo htmlspecialchars($row_me['f_name']." ".$row_me['l_name']); ?></h4>
                                    <p class="text-info fw-semibold mb-1"><i class="fa-solid fa-id-badge me-1"></i> รหัสประจำตัว: <?php echo htmlspecialchars($row_me['ID_student']); ?></p>
                                    <span class="badge bg-secondary bg-opacity-50 text-light px-3 py-2 rounded-pill">ชั้นปีที่ <?php echo htmlspecialchars($row_me['year']); ?></span>
                                </div>
                            </div>

                            <!-- Email Info Card -->
                            <div class="card card-dark p-3 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="p-3 bg-info bg-opacity-10 rounded-circle me-3">
                                        <i class="fa-solid fa-envelope text-info fs-4"></i>
                                    </div>
                                    <div>
                                        <small class="text-secondary d-block">ที่อยู่ Email</small>
                                        <span class="fw-medium text-white"><?php echo htmlspecialchars($row_me['email']); ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Problem Status Card -->
                            <div class="card card-dark p-3">
                                <div class="d-flex align-items-center">
                                    <div class="p-3 <?php echo ($problem_grad > 0) ? 'bg-danger bg-opacity-20' : 'bg-success bg-opacity-10'; ?> rounded-circle me-3">
                                        <i class="fa-solid fa-triangle-exclamation <?php echo ($problem_grad > 0) ? 'text-danger' : 'text-success'; ?> fs-4"></i>
                                    </div>
                                    <div>
                                        <small class="text-secondary d-block">ผลการเรียนที่มีปัญหา</small>
                                        <span class="fw-bold fs-5 <?php echo ($problem_grad > 0) ? 'text-danger' : 'text-success'; ?>"><?php echo $problem_grad; ?> รายการ</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- ฝั่งขวา: สรุปเกรดเฉลี่ย & ผลการเรียนรายเทอม (col-lg-8) -->
                        <div class="col-lg-8">
                            
                            <!-- GPAX & Criteria Overview Card -->
                            <div class="card card-dark p-4 mb-4">
                                <div class="row align-items-center text-center text-md-start">
                                    <div class="col-md-6 mb-3 mb-md-0 border-end border-secondary border-opacity-25">
                                        <small class="text-secondary uppercase fw-semibold d-block mb-1">เกรดเฉลี่ยรวม (GPAX)</small>
                                        <h2 class="fw-bold text-info mb-0 display-5" id="grad"><?php echo show_grad($row_me['id']); ?></h2>
                                    </div>
                                    <div class="col-md-6 ps-md-4">
                                        <small class="text-secondary uppercase fw-semibold d-block mb-1">เกรดเฉลี่ยอยู่ในเกณฑ์</small>
                                        <h3 class="fw-bold mb-0" id="criterion">-</h3>
                                    </div>
                                </div>
                            </div>

                            <!-- ดูข้อมูลเกรด (View Mode) -->
                            <div class="row g-3 mb-4" id="show_grad">
                                
                                <!-- ปี 1 - 2 -->
                                <div class="col-md-6">
                                    <div class="card card-dark h-100">
                                        <div class="card-header card-header-dark py-3">
                                            <i class="fa-solid fa-chart-line me-2"></i> เกรดเฉลี่ยรายเทอม (ปี 1 - 2)
                                        </div>
                                        <div class="card-body">
                                            
                                            <!-- ปี 1 เทอม 1 -->
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between align-items-center small mb-1">
                                                    <span>ปี 1 เทอม 1 <span class="text-info fw-bold ms-1">(<?php echo htmlspecialchars($row_me['grade_1_1']); ?>)</span></span>
                                                    <a href="edit_grad.php?term=1&user_id=<?= $id ?>" class="btn-eye-glow" title="ดูรายละเอียดเกรด">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                                <div class="progress progress-dark" style="height: 6px;">
                                                    <div class="progress-bar progress-bar-glow" id="show_grade_1_1" role="progressbar"></div>
                                                </div>
                                            </div>

                                            <!-- ปี 1 เทอม 2 -->
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between align-items-center small mb-1">
                                                    <span>ปี 1 เทอม 2 <span class="text-info fw-bold ms-1">(<?php echo htmlspecialchars($row_me['grade_1_2']); ?>)</span></span>
                                                    <a href="edit_grad.php?term=2&user_id=<?= $id ?>" class="btn-eye-glow" title="ดูรายละเอียดเกรด">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                                <div class="progress progress-dark" style="height: 6px;">
                                                    <div class="progress-bar progress-bar-glow" id="show_grade_1_2" role="progressbar"></div>
                                                </div>
                                            </div>

                                            <!-- ปี 2 เทอม 1 -->
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between align-items-center small mb-1">
                                                    <span>ปี 2 เทอม 1 <span class="text-info fw-bold ms-1">(<?php echo htmlspecialchars($row_me['grade_2_1']); ?>)</span></span>
                                                    <a href="edit_grad.php?term=3&user_id=<?= $id ?>" class="btn-eye-glow" title="ดูรายละเอียดเกรด">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                                <div class="progress progress-dark" style="height: 6px;">
                                                    <div class="progress-bar progress-bar-glow" id="show_grade_2_1" role="progressbar"></div>
                                                </div>
                                            </div>

                                            <!-- ปี 2 เทอม 2 -->
                                            <div>
                                                <div class="d-flex justify-content-between align-items-center small mb-1">
                                                    <span>ปี 2 เทอม 2 <span class="text-info fw-bold ms-1">(<?php echo htmlspecialchars($row_me['grade_2_2']); ?>)</span></span>
                                                    <a href="edit_grad.php?term=4&user_id=<?= $id ?>" class="btn-eye-glow" title="ดูรายละเอียดเกรด">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                                <div class="progress progress-dark" style="height: 6px;">
                                                    <div class="progress-bar progress-bar-glow" id="show_grade_2_2" role="progressbar"></div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- ปี 3 - 4 -->
                                <div class="col-md-6">
                                    <div class="card card-dark h-100">
                                        <div class="card-header card-header-dark py-3">
                                            <i class="fa-solid fa-chart-line me-2"></i> เกรดเฉลี่ยรายเทอม (ปี 3 - 4)
                                        </div>
                                        <div class="card-body">
                                            
                                            <!-- ปี 3 เทอม 1 -->
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between align-items-center small mb-1">
                                                    <span>ปี 3 เทอม 1 <span class="text-info fw-bold ms-1">(<?php echo htmlspecialchars($row_me['grade_3_1']); ?>)</span></span>
                                                    <a href="edit_grad.php?term=5&user_id=<?= $id ?>" class="btn-eye-glow" title="ดูรายละเอียดเกรด">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                                <div class="progress progress-dark" style="height: 6px;">
                                                    <div class="progress-bar progress-bar-glow" id="show_grade_3_1" role="progressbar"></div>
                                                </div>
                                            </div>

                                            <!-- ปี 3 เทอม 2 -->
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between align-items-center small mb-1">
                                                    <span>ปี 3 เทอม 2 <span class="text-info fw-bold ms-1">(<?php echo htmlspecialchars($row_me['grade_3_2']); ?>)</span></span>
                                                    <a href="edit_grad.php?term=6&user_id=<?= $id ?>" class="btn-eye-glow" title="ดูรายละเอียดเกรด">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                                <div class="progress progress-dark" style="height: 6px;">
                                                    <div class="progress-bar progress-bar-glow" id="show_grade_3_2" role="progressbar"></div>
                                                </div>
                                            </div>

                                            <!-- ปี 4 เทอม 1 -->
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between align-items-center small mb-1">
                                                    <span>ปี 4 เทอม 1 <span class="text-info fw-bold ms-1">(<?php echo htmlspecialchars($row_me['grade_4_1']); ?>)</span></span>
                                                    <a href="edit_grad.php?term=7&user_id=<?= $id ?>" class="btn-eye-glow" title="ดูรายละเอียดเกรด">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                                <div class="progress progress-dark" style="height: 6px;">
                                                    <div class="progress-bar progress-bar-glow" id="show_grade_4_1" role="progressbar"></div>
                                                </div>
                                            </div>

                                            <!-- ปี 4 เทอม 2 -->
                                            <div>
                                                <div class="d-flex justify-content-between align-items-center small mb-1">
                                                    <span>ปี 4 เทอม 2 <span class="text-info fw-bold ms-1">(<?php echo htmlspecialchars($row_me['grade_4_2']); ?>)</span></span>
                                                    <a href="edit_grad.php?term=8&user_id=<?= $id ?>" class="btn-eye-glow" title="ดูรายละเอียดเกรด">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                                <div class="progress progress-dark" style="height: 6px;">
                                                    <div class="progress-bar progress-bar-glow" id="show_grade_4_2" role="progressbar"></div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- แก้ไขข้อมูลเกรด (Edit Mode - Hidden Default) -->
                            <form action="back_end/edit_grad.php" method="POST">
                                <div class="row g-3 mb-4" id="myForm_edit">
                                    <div class="col-md-6">
                                        <div class="card card-dark h-100">
                                            <div class="card-header card-header-dark py-3">
                                                <i class="fa-solid fa-pen-to-square me-2"></i> แก้ไขเกรด (ปี 1 - 2)
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label small text-secondary">ปี 1 เทอม 1</label>
                                                    <input id="grade_1_1" class="form-control form-control-dark" name="grade_1_1" type="number" max="4" min="0" step="0.01" value="<?php echo htmlspecialchars($row_me['grade_1_1']); ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small text-secondary">ปี 1 เทอม 2</label>
                                                    <input id="grade_1_2" class="form-control form-control-dark" name="grade_1_2" type="number" max="4.00" min="0" step="0.01" value="<?php echo htmlspecialchars($row_me['grade_1_2']); ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small text-secondary">ปี 2 เทอม 1</label>
                                                    <input id="grade_2_1" class="form-control form-control-dark" name="grade_2_1" type="number" max="4.00" min="0" step="0.01" value="<?php echo htmlspecialchars($row_me['grade_2_1']); ?>">
                                                </div>
                                                <div>
                                                    <label class="form-label small text-secondary">ปี 2 เทอม 2</label>
                                                    <input id="grade_2_2" class="form-control form-control-dark" name="grade_2_2" type="number" max="4.00" min="0" step="0.01" value="<?php echo htmlspecialchars($row_me['grade_2_2']); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card card-dark h-100">
                                            <div class="card-header card-header-dark py-3">
                                                <i class="fa-solid fa-pen-to-square me-2"></i> แก้ไขเกรด (ปี 3 - 4)
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label small text-secondary">ปี 3 เทอม 1</label>
                                                    <input id="grade_3_1" class="form-control form-control-dark" name="grade_3_1" type="number" max="4.00" min="0" step="0.01" value="<?php echo htmlspecialchars($row_me['grade_3_1']); ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small text-secondary">ปี 3 เทอม 2</label>
                                                    <input id="grade_3_2" class="form-control form-control-dark" name="grade_3_2" type="number" max="4.00" min="0" step="0.01" value="<?php echo htmlspecialchars($row_me['grade_3_2']); ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small text-secondary">ปี 4 เทอม 1</label>
                                                    <input id="grade_4_1" class="form-control form-control-dark" name="grade_4_1" type="number" max="4.00" min="0" step="0.01" value="<?php echo htmlspecialchars($row_me['grade_4_1']); ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small text-secondary">ปี 4 เทอม 2</label>
                                                    <input id="grade_4_2" class="form-control form-control-dark" name="grade_4_2" type="number" max="4.00" min="0" step="0.01" value="<?php echo htmlspecialchars($row_me['grade_4_2']); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-3 text-end">
                                        <button class="btn btn-save-glow me-2" type="submit"><i class="fa-solid fa-floppy-disk me-1"></i> ยืนยันบันทึกเกรด</button>
                                        <button class="btn btn-cancel-dark" type="button" onclick="closeForm()"><i class="fa-solid fa-xmark me-1"></i> ยกเลิก</button>
                                    </div>
                                </div>
                            </form>

                            <!-- Charts Section -->
                            <div class="row g-3">
                                <div class="col-xl-6">
                                    <div class="card card-dark">
                                        <div class="card-header card-header-dark py-3">
                                            <i class="fas fa-chart-area me-2"></i> แผนภูมิพื้นที่เปรียบเทียบเกรด
                                        </div>
                                        <div class="card-body">
                                            <canvas id="myAreaChart" width="100%" height="50"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="card card-dark">
                                        <div class="card-header card-header-dark py-3">
                                            <i class="fas fa-chart-bar me-2"></i> แผนภูมิแท่งเปรียบเทียบเกรด
                                        </div>
                                        <div class="card-body">
                                            <canvas id="myBarChart" width="100%" height="50"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </main>
        </div>
    </div>

    <!-- Script Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@5.0.3" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>

    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="assets/demo/chart-pie-demo.js"></script>
    <script src="assets/demo/chart-area-demo.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        // Toggle Form Functions
        var myForm_edit = document.getElementById("myForm_edit");
        var show_grad = document.getElementById("show_grad");

        if (myForm_edit) {
            myForm_edit.hidden = true;
        }

        function openForm() {
            if (show_grad && myForm_edit) {
                show_grad.hidden = true;
                myForm_edit.hidden = false;
            }
        }

        function closeForm() {
            if (show_grad && myForm_edit) {
                show_grad.hidden = false;
                myForm_edit.hidden = true;
            }
        }

        // Calculate Progress Bars Width dynamically based on values
        var grade_1_1 = parseFloat(document.getElementById("grade_1_1")?.value || 0);
        var grade_1_2 = parseFloat(document.getElementById("grade_1_2")?.value || 0);
        var grade_2_1 = parseFloat(document.getElementById("grade_2_1")?.value || 0);
        var grade_2_2 = parseFloat(document.getElementById("grade_2_2")?.value || 0);
        var grade_3_1 = parseFloat(document.getElementById("grade_3_1")?.value || 0);
        var grade_3_2 = parseFloat(document.getElementById("grade_3_2")?.value || 0);
        var grade_4_1 = parseFloat(document.getElementById("grade_4_1")?.value || 0);
        var grade_4_2 = parseFloat(document.getElementById("grade_4_2")?.value || 0);

        if (document.getElementById("show_grade_1_1")) document.getElementById("show_grade_1_1").style.width = (grade_1_1 / 4) * 100 + "%";
        if (document.getElementById("show_grade_1_2")) document.getElementById("show_grade_1_2").style.width = (grade_1_2 / 4) * 100 + "%";
        if (document.getElementById("show_grade_2_1")) document.getElementById("show_grade_2_1").style.width = (grade_2_1 / 4) * 100 + "%";
        if (document.getElementById("show_grade_2_2")) document.getElementById("show_grade_2_2").style.width = (grade_2_2 / 4) * 100 + "%";
        if (document.getElementById("show_grade_3_1")) document.getElementById("show_grade_3_1").style.width = (grade_3_1 / 4) * 100 + "%";
        if (document.getElementById("show_grade_3_2")) document.getElementById("show_grade_3_2").style.width = (grade_3_2 / 4) * 100 + "%";
        if (document.getElementById("show_grade_4_1")) document.getElementById("show_grade_4_1").style.width = (grade_4_1 / 4) * 100 + "%";
        if (document.getElementById("show_grade_4_2")) document.getElementById("show_grade_4_2").style.width = (grade_4_2 / 4) * 100 + "%";

        // Academic Criteria Evaluator & Glowing Colors
        let gradVal = parseFloat(document.getElementById("grad")?.innerHTML || 0);
        let criterionElem = document.getElementById("criterion");

        if (criterionElem) {
            if (gradVal < 2.00) {
                criterionElem.innerHTML = "เสี่ยง";
                criterionElem.style.color = "#f43f5e"; // Neon Red
            } else if (gradVal < 2.50) {
                criterionElem.innerHTML = "น้อย";
                criterionElem.style.color = "#fb923c"; // Neon Orange
            } else if (gradVal < 3.00) {
                criterionElem.innerHTML = "ปานกลาง";
                criterionElem.style.color = "#facc15"; // Neon Yellow
            } else if (gradVal < 3.50) {
                criterionElem.innerHTML = "ดี";
                criterionElem.style.color = "#34d399"; // Neon Green
            } else {
                criterionElem.innerHTML = "ดีมาก";
                criterionElem.style.color = "#38bdf8"; // Neon Cyan
            }
        }

        // Alert
        function JSalert() {
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: 'เนื้อหาของคุณได้รับการอัปเดตแล้ว',
                confirmButtonColor: '#059669',
                customClass: {
                    popup: 'swal2-popup-dark'
                }
            });
        }
    </script>

</body>

</html>