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

    /////ดึงข้อมูล นศ. ทั้งหมด
    $sql = "SELECT * FROM user_student ORDER BY ID_student ASC ";
    $resule_student = mysqli_query($conn,$sql);
    $count_data = mysqli_num_rows($resule_student);
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>CS BRU - ข้อมูลนักศึกษา</title>
    <link rel="shortcut icon" href="img/LOGO-bru.png">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

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

        /* Dark Cards */
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

        /* Risk Status Cards Glow */
        .card-stat-risk {
            background: rgba(225, 29, 72, 0.15) !important;
            border: 1px solid rgba(244, 63, 94, 0.3) !important;
            border-radius: 14px;
        }

        .card-stat-low {
            background: rgba(234, 88, 12, 0.15) !important;
            border: 1px solid rgba(251, 146, 60, 0.3) !important;
            border-radius: 14px;
        }

        .card-stat-medium {
            background: rgba(217, 119, 6, 0.15) !important;
            border: 1px solid rgba(251, 191, 36, 0.3) !important;
            border-radius: 14px;
        }

        .card-stat-good {
            background: rgba(16, 185, 129, 0.15) !important;
            border: 1px solid rgba(52, 211, 153, 0.3) !important;
            border-radius: 14px;
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
                    <h1 class="mt-2 fw-bold text-white"><i class="fa-solid fa-users me-2 text-info"></i>ข้อมูลนักศึกษา</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item text-secondary">ผู้ใช้</li>
                        <li class="breadcrumb-item active text-info">ข้อมูลนักศึกษา</li>
                    </ol>

                    <!-- Risk Criteria Summary Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stat-risk p-3">
                                <div class="card-body p-0">
                                    <h5 id="show_num_grad" class="fw-bold text-danger m-0">อยู่ในเกณฑ์เสี่ยง 0 คน</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stat-low p-3">
                                <div class="card-body p-0">
                                    <h5 id="show_num_grad" class="fw-bold text-warning m-0">อยู่ในเกณฑ์น้อย 0 คน</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stat-medium p-3">
                                <div class="card-body p-0">
                                    <h5 id="show_num_grad" class="fw-bold text-info m-0">อยู่ในเกณฑ์ปานกลาง 0 คน</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stat-good p-3">
                                <div class="card-body p-0">
                                    <h5 id="show_num_grad" class="fw-bold text-success m-0">อยู่ในเกณฑ์ ดี-ดีมาก 0 คน</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Student Datatable Card -->
                    <div class="card card-dark mb-4">
                        <div class="card-header card-header-dark py-3">
                            <i class="fas fa-table me-2"></i> ข้อมูลนักศึกษาทั้งหมด
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatablesSimple" class="table">
                                    <thead>
                                        <tr>
                                            <th><i class="fa fa-filter me-1"></i> ลำดับ</th>
                                            <th><i class="fa fa-filter me-1"></i> รหัสนักศึกษา</th>
                                            <th><i class="fa fa-filter me-1"></i> ชื่อ-นามสกุล</th>
                                            <th><i class="fa fa-filter me-1"></i> ชั้นปี</th>
                                            <th><i class="fa fa-filter me-1"></i> เกรดเฉลี่ยรวม</th>
                                            <th><i class="fa fa-filter me-1"></i> อยู่ในเกณฑ์</th>
                                            <th class="text-center"><i class="fa-solid fa-gear me-1"></i> เพิ่มเติม</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php for($i = 0 ; $i < $count_data ; $i++){ $row = mysqli_fetch_assoc($resule_student); ?>
                                            <tr>
                                                <td><?php echo $i + 1 ?></td>
                                                <td class="fw-semibold text-info"><?php echo htmlspecialchars($row['ID_student']) ?></td>
                                                <td class="fw-medium text-white"><?php echo htmlspecialchars($row['f_name']." ".$row['l_name']) ?></td>
                                                <td><?php echo show_year( $row['year'] ) ?></td>
                                                <td id="grad"><?php echo show_grad( $row['id'] ) ?></td>
                                                <td id="criterion"></td>
                                                <td class="text-center">
                                                    <a href="page_profile_student.php?id=<?php echo $row['id'] ?>">
                                                        <button class="btn btn-view-glow btn-sm">
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

                    <!-- Charts Section -->
                    <div class="row g-4 mb-4">
                        <div class="col-lg-6">
                            <div class="card card-dark">
                                <div class="card-header card-header-dark py-3">
                                    <i class="fas fa-chart-bar me-2"></i> กราฟแสดงสัดส่วนเกรดของนักศึกษาทั้งหมด
                                </div>
                                <div class="card-body">
                                    <canvas id="myAreaChart" width="100%" height="50"></canvas>
                                </div>
                                <div class="card-footer bg-transparent border-top-0 small text-secondary">
                                    <i class="fa-solid fa-clock me-1"></i> อัปเดตล่าสุดเมื่อ <?php echo date("H:i:s"); ?> น.
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card card-dark">
                                <div class="card-header card-header-dark py-3">
                                    <i class="fas fa-chart-pie me-2"></i> กราฟแสดงสัดส่วนเกรดของนักศึกษาทั้งหมด
                                </div>
                                <div class="card-body">
                                    <canvas id="myPieChart" width="100%" height="50"></canvas>
                                </div>
                                <div class="card-footer bg-transparent border-top-0 small text-secondary">
                                    <i class="fa-solid fa-clock me-1"></i> อัปเดตล่าสุดเมื่อ <?php echo date("H:i:s"); ?> น.
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

    <!-- Custom Script for Grade calculation & Graph rendering -->
    <script src="js/scripts_Q.js"></script>

    <!-- SweetAlert Notification -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        function JSalert() {
            swal("สำเร็จ!", "เนื้อหาของคุณได้รับการอัปเดตแล้ว!", "success");
        }
    </script>

</body>

</html>