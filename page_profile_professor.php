<?php 

    session_start();

    require('back_end/server.php');
    require('back_end/funtion.php');

    if(!isset($_SESSION['id'])){
        Header("Location:index.php");
        session_destroy();
    }

    $level = $_SESSION['level'];

    if($level != 3){
        $id = $_SESSION['id'];
        $ID_personnel = $_SESSION['ID_personnel'];
        $name = $_SESSION['name'];
        $email = $_SESSION['email'];
    }else{
        $id = $_SESSION['id'];
    }

    $id_professor = mysqli_real_escape_string($conn,$_GET['id']);

    /////ดึงข้อมูลอาจารย์
    $sql = "SELECT * FROM user_professor WHERE id = '$id_professor' ";
    $resule_student = mysqli_query($conn,$sql);
    $row_me = mysqli_fetch_assoc($resule_student);

    /////ดึงข้อมูลนักศึกษาที่ติด I
    $sql = "SELECT * FROM user_student INNER JOIN grad 
    ON grad.id_student = user_student.id WHERE id_professor = '$id_professor' AND grad = 'I'";
    $resule_I = mysqli_query($conn,$sql);
    $count_I = mysqli_num_rows($resule_I);

    /////ดึงข้อมูลนักศึกษาที่ติด F
    $sql = "SELECT * FROM user_student INNER JOIN grad 
    ON grad.id_student = user_student.id WHERE id_professor = '$id_professor' AND grad = 'F'";
    $resule_F = mysqli_query($conn,$sql);
    $count_F = mysqli_num_rows($resule_F);
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>CS BRU - โปรไฟล์อาจารย์</title>
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

        /* Stat Glow Cards */
        .card-stat-i {
            background: rgba(245, 158, 11, 0.12) !important;
            border: 1px solid rgba(245, 158, 11, 0.3) !important;
            border-radius: 12px;
        }

        .card-stat-f {
            background: rgba(239, 68, 68, 0.12) !important;
            border: 1px solid rgba(239, 68, 68, 0.3) !important;
            border-radius: 12px;
        }

        /* Datatables Styling */
        .dataTable-table {
            color: #f8fafc !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
        }

        .dataTable-table > thead > tr > th {
            border-bottom: 2px solid rgba(255, 255, 255, 0.12) !important;
            color: #38bdf8 !important;
            background: rgba(15, 23, 42, 0.6);
        }

        .dataTable-table > tbody > tr > td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
            vertical-align: middle;
        }

        .dataTable-input, .dataTable-selector {
            background-color: rgba(15, 23, 42, 0.7) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            color: #f8fafc !important;
            border-radius: 8px !important;
            padding: 6px 12px !important;
        }

        .dataTable-pagination a {
            color: #94a3b8 !important;
            background: rgba(15, 23, 42, 0.6) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 6px !important;
            margin: 0 2px;
        }

        .dataTable-pagination .active a,
        .dataTable-pagination a:hover {
            background: #0284c7 !important;
            color: #ffffff !important;
            border-color: #38bdf8 !important;
        }

        .dataTable-info {
            color: #94a3b8 !important;
        }

        /* Action Buttons */
        .btn-view-glow {
            background: rgba(56, 189, 248, 0.15);
            border: 1px solid rgba(56, 189, 248, 0.4);
            color: #38bdf8;
            border-radius: 8px;
            padding: 4px 10px;
            transition: all 0.2s ease;
        }

        .btn-view-glow:hover {
            background: #0284c7;
            color: #ffffff;
            box-shadow: 0 0 12px rgba(56, 189, 248, 0.4);
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
                    <?php if($level != 3){ echo htmlspecialchars($name); } ?> <i class="fas fa-user fa-fw text-info ms-1"></i>
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
                    
                    <h1 class="mt-2 fw-bold text-white"><i class="fa-solid fa-user-tie me-2 text-info"></i>โปรไฟล์อาจารย์ & ผลการเรียนที่มีปัญหา</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item text-secondary">อาจารย์ผู้สอน</li>
                        <li class="breadcrumb-item active text-info">ข้อมูลโปรไฟล์</li>
                    </ol>

                    <div class="row g-4">
                        
                        <!-- ฝั่งซ้าย: ข้อมูลอาจารย์ & สถิติผลการเรียนที่มีปัญหา (col-lg-4) -->
                        <div class="col-lg-4">
                            
                            <!-- Profile Card -->
                            <div class="card card-dark p-3 text-center mb-4">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <?php if( file_exists("img_professor/$id_professor.jpg") ){ ?>
                                            <img src="img_professor/<?php echo $id_professor ?>.jpg" class="rounded-circle profile-img-glow" width="140" height="140" alt="Professor Profile">
                                        <?php }else{ ?>
                                            <img src="img/free_profile.png" alt="Profile" class="rounded-circle profile-img-glow" width="140" height="140">
                                        <?php } ?>
                                    </div>
                                    <h4 class="fw-bold text-white mb-1">อาจารย์ <?php echo htmlspecialchars($row_me['f_name']." ".$row_me['l_name']); ?></h4>
                                    <p class="text-info small mb-0"><i class="fa-solid fa-envelope me-1"></i> <?php echo htmlspecialchars($row_me['email']); ?></p>
                                </div>
                            </div>

                            <!-- Stat Card: Grade I -->
                            <div class="card card-dark card-stat-i p-3 mb-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="p-3 bg-warning bg-opacity-20 rounded-circle me-3">
                                            <i class="fa-solid fa-triangle-exclamation text-warning fs-3"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-secondary mb-1">ผลการเรียนติดปัญหา (I)</h6>
                                            <h3 class="fw-bold text-warning mb-0"><?php echo $count_I; ?> คน</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Stat Card: Grade F -->
                            <div class="card card-dark card-stat-f p-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="p-3 bg-danger bg-opacity-20 rounded-circle me-3">
                                            <i class="fa-solid fa-circle-exclamation text-danger fs-3"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-secondary mb-1">ผลการเรียนติดปัญหา (F)</h6>
                                            <h3 class="fw-bold text-danger mb-0"><?php echo $count_F; ?> คน</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- ฝั่งขวา: ตารางแสดงรายชื่อนักศึกษาที่ติด I และ F (col-lg-8) -->
                        <div class="col-lg-8">
                            
                            <!-- ตารางติด I -->
                            <div class="card card-dark mb-4">
                                <div class="card-header card-header-dark py-3">
                                    <i class="fa-solid fa-triangle-exclamation text-warning me-2"></i> รายชื่อนักศึกษาที่ติด I
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="datatablesSimple" class="table">
                                            <thead>
                                                <tr>
                                                    <th><i class="fa fa-filter me-1"></i> ลำดับ</th>
                                                    <th><i class="fa fa-filter me-1"></i> ชื่อ-นามสกุล</th>
                                                    <th><i class="fa fa-filter me-1"></i> ชื่อรายวิชา</th>
                                                    <th><i class="fa fa-filter me-1"></i> ชั้นปี</th>
                                                    <th><i class="fa fa-filter me-1"></i> อีเมล</th>
                                                    <th class="text-center"><i class="fa-solid fa-gear me-1"></i> โปรไฟล์</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php for($i = 0 ; $i < $count_I ; $i++){ $row_I = mysqli_fetch_assoc($resule_I); ?>
                                                    <tr>
                                                        <td><?php echo $i + 1; ?></td>
                                                        <td class="fw-medium text-white"><?php echo htmlspecialchars(show_name_student_form_id($row_I['id_student'])); ?></td>
                                                        <td class="text-info"><?php echo htmlspecialchars($row_I['name']); ?></td>
                                                        <td>ปี <?php echo htmlspecialchars($row_I['year']); ?></td>
                                                        <td class="small text-secondary"><?php echo htmlspecialchars($row_I['email']); ?></td>
                                                        <td class="text-center">
                                                            <a href="page_profile_student.php?id=<?php echo $row_I['id_student']; ?>" class="text-decoration-none">
                                                                <button class="btn btn-view-glow btn-sm" title="ดูโปรไฟล์นักศึกษา">
                                                                    <i class="fa fa-eye me-1"></i> ดูโปรไฟล์
                                                                </button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- ตารางติด F -->
                            <div class="card card-dark mb-4">
                                <div class="card-header card-header-dark py-3">
                                    <i class="fa-solid fa-circle-exclamation text-danger me-2"></i> รายชื่อนักศึกษาที่ติด F
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="datatablesSimple2" class="table">
                                            <thead>
                                                <tr>
                                                    <th><i class="fa fa-filter me-1"></i> ลำดับ</th>
                                                    <th><i class="fa fa-filter me-1"></i> ชื่อ-นามสกุล</th>
                                                    <th><i class="fa fa-filter me-1"></i> ชื่อรายวิชา</th>
                                                    <th><i class="fa fa-filter me-1"></i> ชั้นปี</th>
                                                    <th><i class="fa fa-filter me-1"></i> อีเมล</th>
                                                    <th class="text-center"><i class="fa-solid fa-gear me-1"></i> โปรไฟล์</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php for($i = 0 ; $i < $count_F ; $i++){ $row_F = mysqli_fetch_assoc($resule_F); ?>
                                                    <tr>
                                                        <td><?php echo $i + 1; ?></td>
                                                        <td class="fw-medium text-white"><?php echo htmlspecialchars(show_name_student_form_id($row_F['id_student'])); ?></td>
                                                        <td class="text-info"><?php echo htmlspecialchars($row_F['name']); ?></td>
                                                        <td>ปี <?php echo htmlspecialchars($row_F['year']); ?></td>
                                                        <td class="small text-secondary"><?php echo htmlspecialchars($row_F['email']); ?></td>
                                                        <td class="text-center">
                                                            <a href="page_profile_student.php?id=<?php echo $row_F['id_student']; ?>" class="text-decoration-none">
                                                                <button class="btn btn-view-glow btn-sm" title="ดูโปรไฟล์นักศึกษา">
                                                                    <i class="fa fa-eye me-1"></i> ดูโปรไฟล์
                                                                </button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
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

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        // Initialize DataTables ทั้งสองตาราง
        window.addEventListener('DOMContentLoaded', event => {
            const datatablesSimple = document.getElementById('datatablesSimple');
            if (datatablesSimple) {
                new simpleDatatables.DataTable(datatablesSimple);
            }
            const datatablesSimple2 = document.getElementById('datatablesSimple2');
            if (datatablesSimple2) {
                new simpleDatatables.DataTable(datatablesSimple2);
            }
        });

        // SweetAlert แจ้งเตือนเมื่ออัปเดตสำเร็จ
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