<?php 

    session_start();

    require('back_end/server.php');
    require('back_end/funtion.php');

    if(!isset($_SESSION['id'])){
        Header("Location:index.php");
        session_destroy();
    }

    $id =$_SESSION['id'];
    $ID_personnel =$_SESSION['ID_personnel'];
    $name =$_SESSION['name'];
    $email =$_SESSION['email'];
    $level =$_SESSION['level'];

    if($level != 1){
        Header("Location:index.php");
        session_destroy();
    }

    /////ดึงข้อมูลนัดหมายของนักศึกษา
    $sql = "SELECT * FROM appointment WHERE id_student = '$id' ";
    $resule_appointment = mysqli_query($conn,$sql);
    $count_appointment = mysqli_num_rows($resule_appointment);

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>CS BRU - นัดหมายอาจารย์</title>
    <link rel="shortcut icon" href="img/LOGO-bru.png">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- FullCalendar CSS -->
    <link rel="stylesheet" href="js/fullcalendar-2.1.1/fullcalendar.min.css">

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

        /* Custom Action Buttons */
        .btn-add-glow {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            border: 1px solid rgba(16, 185, 129, 0.4);
            color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.3);
            transition: all 0.2s ease;
        }

        .btn-add-glow:hover {
            background: linear-gradient(135deg, #047857 0%, #059669 100%);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.5);
            color: #ffffff;
        }

        .btn-action-edit {
            background: rgba(56, 189, 248, 0.15);
            border: 1px solid rgba(56, 189, 248, 0.4);
            color: #38bdf8;
            border-radius: 8px;
            padding: 4px 10px;
            transition: all 0.2s ease;
        }

        .btn-action-edit:hover {
            background: #0284c7;
            color: #ffffff;
            box-shadow: 0 0 12px rgba(56, 189, 248, 0.4);
        }

        .btn-action-del {
            background: rgba(244, 63, 94, 0.15);
            border: 1px solid rgba(244, 63, 94, 0.4);
            color: #fb7185;
            border-radius: 8px;
            padding: 4px 10px;
            transition: all 0.2s ease;
        }

        .btn-action-del:hover {
            background: #e11d48;
            color: #ffffff;
            box-shadow: 0 0 12px rgba(244, 63, 94, 0.4);
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

        .tr-pending {
            background-color: rgba(245, 158, 11, 0.12) !important;
            border-left: 3px solid #f59e0b !important;
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

        /* FullCalendar Dark Theme Overrides */
        #calendar-card {
            background: rgba(30, 41, 59, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 20px;
            color: #f8fafc;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
        }

        .fc-header-title h2 {
            color: #38bdf8 !important;
            font-size: 1.25rem !important;
            font-weight: 600;
        }

        .fc-button {
            background: rgba(15, 23, 42, 0.8) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            color: #f8fafc !important;
            text-shadow: none !important;
            box-shadow: none !important;
            border-radius: 6px !important;
            padding: 4px 10px !important;
        }

        .fc-state-active, .fc-button:hover {
            background: #0284c7 !important;
            color: #ffffff !important;
            border-color: #38bdf8 !important;
        }

        .fc-widget-header {
            background: rgba(15, 23, 42, 0.6) !important;
            color: #38bdf8 !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            padding: 8px 0 !important;
        }

        .fc-widget-content {
            border-color: rgba(255, 255, 255, 0.08) !important;
        }

        .fc-day-number {
            color: #cbd5e1 !important;
            padding: 4px 8px !important;
        }

        .fc-other-month .fc-day-number {
            color: #475569 !important;
        }

        .fc-event {
            background: #0284c7 !important;
            border: 1px solid #38bdf8 !important;
            color: #ffffff !important;
            border-radius: 6px !important;
            padding: 2px 6px !important;
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
                    
                    <div class="d-flex align-items-center justify-content-between my-2">
                        <div>
                            <h1 class="fw-bold text-white mb-1"><i class="fa-solid fa-calendar-days me-2 text-info"></i>การนัดหมายอาจารย์</h1>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item text-secondary">นักศึกษา</li>
                                <li class="breadcrumb-item active text-info">ตารางและการขอนัดหมาย</li>
                            </ol>
                        </div>
                        <a class="btn btn-add-glow px-3 py-2 fw-semibold" href="add_appointment_student.php">
                            <i class="fa-solid fa-plus me-1"></i> ขอนัดหมายอาจารย์ (กรณีติด I / F)
                        </a>
                    </div>

                    <!-- Calendar Component -->
                    <div class="mb-4 mt-3">
                        <div id="calendar-card">
                            <div id='calendar'></div>
                        </div>
                    </div>

                    <!-- Table Component -->
                    <div class="card card-dark mb-4">
                        <div class="card-header card-header-dark py-3">
                            <i class="fas fa-table me-2"></i> ข้อมูลรายการนัดหมายทั้งหมด
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatablesSimple" class="table">
                                    <thead>
                                        <tr>
                                            <th><i class="fa fa-filter me-1"></i> ลำดับ</th>
                                            <th><i class="fa fa-filter me-1"></i> หัวข้อการนัดหมาย</th>
                                            <th><i class="fa fa-filter me-1"></i> ชื่อนักศึกษา</th>
                                            <th><i class="fa fa-filter me-1"></i> อาจารย์ผู้นัดหมาย</th>
                                            <th><i class="fa fa-filter me-1"></i> วันที่และเวลา</th>
                                            <th class="text-center"><i class="fa-solid fa-gear me-1"></i> สถานะ / ตัวเลือก</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php for($i=0; $i < $count_appointment ; $i++){ $row_appointment = mysqli_fetch_assoc($resule_appointment); ?>

                                            <tr <?php if($row_appointment['level'] == 1){ echo "class='tr-pending'" ;} ?>>
                                                <td><?php echo $i + 1; ?></td>
                                                <td class="fw-medium text-white"><?php echo htmlspecialchars($row_appointment['name']); ?></td>
                                                <td><?php echo htmlspecialchars(show_name_student_form_id($row_appointment['id_student'])); ?></td>
                                                <td class="text-info"><?php echo htmlspecialchars(show_name_professor_form_id($row_appointment['id_professor'])); ?></td>
                                                <td class="text-light"><?php echo DateThai($row_appointment['date_time']); ?></td>
                                                
                                                <td class="text-center">
                                                    <?php if($row_appointment['level'] == 1){ ?>
                                                        <span class="badge bg-warning text-dark px-3 py-2">
                                                            <i class="fa-solid fa-clock me-1"></i> รอดำเนินการ
                                                        </span>
                                                    <?php } else { ?>
                                                        <a href="edit_appointment.php?id_appointment=<?php echo $row_appointment['id']; ?>" class="text-decoration-none me-1">
                                                            <button class="btn btn-action-edit btn-sm" title="แก้ไขการนัดหมาย">
                                                                <i class="fa-solid fa-pen-to-square"></i> แก้ไข
                                                            </button>
                                                        </a>
                                                        <button class="btn btn-action-del btn-sm" onclick="confirmDelete(<?php echo $row_appointment['id']; ?>)" title="ยกเลิก/ลบการนัดหมาย">
                                                            <i class="fa-solid fa-trash-can"></i> ลบ
                                                        </button>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <!-- Core Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@5.0.3" crossorigin="anonymous"></script>

    <!-- FullCalendar JS Dependencies -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="js/fullcalendar-2.1.1/lib/moment.min.js"></script>
    <script type="text/javascript" src="js/fullcalendar-2.1.1/fullcalendar.min.js"></script>
    <script type="text/javascript" src="js/fullcalendar-2.1.1/lang/th.js"></script>
    <script type="text/javascript" src="script.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        // Initialize DataTables
        window.addEventListener('DOMContentLoaded', event => {
            const datatablesSimple = document.getElementById('datatablesSimple');
            if (datatablesSimple) {
                new simpleDatatables.DataTable(datatablesSimple);
            }
        });

        // SweetAlert แจ้งเตือนเมื่ออัปเดตสำเร็จ
        function JSalert() {
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: 'การดำเนินรายการของคุณเสร็จสมบูรณ์',
                confirmButtonColor: '#059669',
                customClass: {
                    popup: 'swal2-popup-dark'
                }
            });
        }

        // ยืนยันการลบรายการนัดหมาย
        function confirmDelete(id) {
            Swal.fire({
                title: 'ยืนยันการลบการนัดหมาย?',
                text: "รายการนัดหมายนี้จะถูกลบออกจากระบบทันที",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="fa-solid fa-trash-can me-1"></i> ยืนยันการลบ',
                cancelButtonText: 'ยกเลิก',
                customClass: {
                    popup: 'swal2-popup-dark'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `back_end/delete_appointment.php?id_appointment=${id}`;
                }
            });
        }
    </script>

</body>

</html>