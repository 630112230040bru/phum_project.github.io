<?php 

    session_start();

    require('back_end/server.php');
    require('back_end/funtion.php');

    if(!isset($_SESSION['id'])){
        header("Location: index.php");
        session_destroy();
        exit();
    }

    $level = $_SESSION['level'] ?? 1;

    if($level != 3){
        $id = $_SESSION['id'];
        $ID_personnel = $_SESSION['ID_personnel'] ?? '';
        $name = $_SESSION['name'] ?? '';
        $email = $_SESSION['email'] ?? '';
    } else {
        $id = $_SESSION['id'];
    }

    ///// ดึงข้อมูลนักศึกษาทั้งหมด
    $sql = "SELECT * FROM user_student ORDER BY ID_student ASC";
    $resule_student = mysqli_query($conn, $sql);

    // ตัวแปรสำหรับนับจำนวนนักศึกษาในแต่ละเกณฑ์
    $count_risk = 0;     // เสี่ยง (< 2.00)
    $count_low = 0;      // น้อย (2.00 - 2.49)
    $count_medium = 0;   // ปานกลาง (2.50 - 2.99)
    $count_good = 0;     // ดี-ดีมาก (>= 3.00)

    // อาเรย์สำหรับเก็บข้อมูลนักศึกษาเพื่อนำไปแสดงผลในตาราง
    $students_list = array();

    if($resule_student && mysqli_num_rows($resule_student) > 0) {
        while($row = mysqli_fetch_assoc($resule_student)) {
            
            // คำนวณเกรดเฉลี่ย
            $gpax = show_grad($row['id']);
            $gpax_val = floatval($gpax);

            // จำแนกเกณฑ์เกรดเฉลี่ยและคำนวณจำนวน
            if ($gpax_val < 2.00) {
                $criterion = "เสี่ยง";
                $badge_class = "bg-danger text-white";
                $count_risk++;
            } else if ($gpax_val < 2.50) {
                $criterion = "น้อย";
                $badge_class = "bg-warning text-dark";
                $count_low++;
            } else if ($gpax_val < 3.00) {
                $criterion = "ปานกลาง";
                $badge_class = "bg-info text-dark";
                $count_medium++;
            } else {
                $criterion = "ดี - ดีมาก";
                $badge_class = "bg-success text-white";
                $count_good++;
            }

            // จัดเก็บข้อมูลลงใน Array
            $row['gpax_calculated'] = $gpax;
            $row['criterion_text'] = $criterion;
            $row['badge_class'] = $badge_class;
            $students_list[] = $row;
        }
    }
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

        /* Dark Glass Cards & Glowing Stat Cards */
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

        /* Stat Cards */
        .stat-card-risk {
            background: linear-gradient(135deg, rgba(225, 29, 72, 0.2) 0%, rgba(159, 18, 57, 0.4) 100%);
            border: 1px solid rgba(244, 63, 94, 0.3);
            border-radius: 16px;
        }

        .stat-card-low {
            background: linear-gradient(135deg, rgba(234, 88, 12, 0.2) 0%, rgba(154, 52, 18, 0.4) 100%);
            border: 1px solid rgba(251, 146, 60, 0.3);
            border-radius: 16px;
        }

        .stat-card-medium {
            background: linear-gradient(135deg, rgba(202, 138, 4, 0.2) 0%, rgba(133, 77, 14, 0.4) 100%);
            border: 1px solid rgba(250, 204, 21, 0.3);
            border-radius: 16px;
        }

        .stat-card-good {
            background: linear-gradient(135deg, rgba(5, 150, 105, 0.2) 0%, rgba(6, 78, 59, 0.4) 100%);
            border: 1px solid rgba(52, 211, 153, 0.3);
            border-radius: 16px;
        }

        /* Table Styling */
        .table-dark-custom {
            color: #f8fafc;
        }

        .table-dark-custom th {
            background-color: rgba(15, 23, 42, 0.8) !important;
            color: #38bdf8 !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        .table-dark-custom td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
            vertical-align: middle;
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
        <a class="navbar-brand ps-3 fw-bold text-info" href="#"><i class="fa-solid fa-graduation-cap me-2"></i>CS BRU</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 text-light" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></form>
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

        <!-- Sidebar Navigation Left -->
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

        <!-- Main Content Content Area -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4 py-3">
                    
                    <h1 class="mt-2 fw-bold text-white"><i class="fa-solid fa-users me-2 text-info"></i>ข้อมูลนักศึกษา</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item text-secondary">ผู้ใช้</li>
                        <li class="breadcrumb-item active text-info">ข้อมูลและเกณฑ์ผลการเรียนนักศึกษา</li>
                    </ol>

                    <!-- Summary Cards Dynamic Stats -->
                    <div class="row g-3 mb-4">
                        
                        <!-- เกณฑ์เสี่ยง -->
                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card-risk p-3 h-100">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <small class="text-white-50 text-uppercase fw-bold">เกณฑ์เสี่ยง (< 2.00)</small>
                                        <h3 class="fw-bold text-white mb-0 mt-1"><?php echo $count_risk; ?> คน</h3>
                                    </div>
                                    <div class="p-3 bg-danger bg-opacity-20 rounded-circle">
                                        <i class="fa-solid fa-triangle-exclamation text-danger fs-3"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- เกณฑ์น้อย -->
                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card-low p-3 h-100">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <small class="text-white-50 text-uppercase fw-bold">เกณฑ์น้อย (2.00 - 2.49)</small>
                                        <h3 class="fw-bold text-white mb-0 mt-1"><?php echo $count_low; ?> คน</h3>
                                    </div>
                                    <div class="p-3 bg-warning bg-opacity-20 rounded-circle">
                                        <i class="fa-solid fa-circle-exclamation text-warning fs-3"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- เกณฑ์ปานกลาง -->
                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card-medium p-3 h-100">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <small class="text-white-50 text-uppercase fw-bold">เกณฑ์ปานกลาง (2.50 - 2.99)</small>
                                        <h3 class="fw-bold text-white mb-0 mt-1"><?php echo $count_medium; ?> คน</h3>
                                    </div>
                                    <div class="p-3 bg-info bg-opacity-20 rounded-circle">
                                        <i class="fa-solid fa-chart-line text-info fs-3"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- เกณฑ์ดี - ดีมาก -->
                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card-good p-3 h-100">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <small class="text-white-50 text-uppercase fw-bold">เกณฑ์ดี - ดีมาก (>= 3.00)</small>
                                        <h3 class="fw-bold text-white mb-0 mt-1"><?php echo $count_good; ?> คน</h3>
                                    </div>
                                    <div class="p-3 bg-success bg-opacity-20 rounded-circle">
                                        <i class="fa-solid fa-award text-success fs-3"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Table Data Card -->
                    <div class="card card-dark mb-4">
                        <div class="card-header card-header-dark py-3">
                            <i class="fas fa-table me-2"></i> ข้อมูลผลการเรียนนักศึกษาทั้งหมด
                        </div>

                        <div class="card-body">
                            <table id="datatablesSimple" class="table table-dark-custom align-middle">
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>รหัสนักศึกษา</th>
                                        <th>ชื่อ - สกุล</th>
                                        <th>ชั้นปี</th>
                                        <th>เกรดเฉลี่ยรวม</th>
                                        <th>อยู่ในเกณฑ์</th>
                                        <th class="text-center">ดูเพิ่มเติม</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($students_list as $index => $student_item) { ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td class="fw-semibold text-info"><?php echo htmlspecialchars($student_item['ID_student']); ?></td>
                                            <td><?php echo htmlspecialchars($student_item['f_name']." ".$student_item['l_name']); ?></td>
                                            <td><?php echo show_year($student_item['year']); ?></td>
                                            <td class="fw-bold text-white"><?php echo $student_item['gpax_calculated']; ?></td>
                                            <td>
                                                <span class="badge <?php echo $student_item['badge_class']; ?> px-3 py-2 rounded-pill">
                                                    <?php echo $student_item['criterion_text']; ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="page_profile_student.php?id=<?php echo $student_item['id']; ?>" class="btn btn-sm btn-outline-info rounded-circle">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Visual Charts Section -->
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div class="card card-dark mb-4">
                                <div class="card-header card-header-dark py-3">
                                    <i class="fas fa-chart-bar me-2"></i> กราฟแนวโน้มเกรดเฉลี่ยรวม
                                </div>
                                <div class="card-body"><canvas id="myAreaChart" width="100%" height="50"></canvas></div>
                                <div class="card-footer bg-transparent border-top border-secondary border-opacity-25 small text-secondary">
                                    อัปเดตล่าสุดเมื่อ <?php echo date("H:i:s"); ?> น.
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card card-dark mb-4">
                                <div class="card-header card-header-dark py-3">
                                    <i class="fas fa-chart-pie me-2"></i> กราฟแสดงสัดส่วนเกรดนักศึกษาตามเกณฑ์
                                </div>
                                <div class="card-body"><canvas id="myPieChart" width="100%" height="50"></canvas></div>
                                <div class="card-footer bg-transparent border-top border-secondary border-opacity-25 small text-secondary">
                                    อัปเดตล่าสุดเมื่อ <?php echo date("H:i:s"); ?> น.
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <!-- Script Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@5.0.3" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>

    <!-- Chart.js Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts_Q.js"></script>

    <!-- SweetAlert Notification -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        function JSalert() {
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: 'เนื้อหาของคุณได้รับการอัปเดตแล้ว',
                confirmButtonColor: '#059669',
                customClass: { popup: 'swal2-popup-dark' }
            });
        }
    </script>

</body>

</html>