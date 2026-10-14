<?php 

session_start();

require('back_end/server.php');
require('back_end/funtion.php');
require('class/user_student.php');

if(!isset($_SESSION['id'])){
    Header("Location:index.php");
    session_destroy();
}

$level =$_SESSION['level'];

if($level != 3){
    $id =$_SESSION['id'];
    $ID_personnel =$_SESSION['ID_personnel'];
    $name =$_SESSION['name'];
    $email =$_SESSION['email'];
}else{
    $id =$_SESSION['id'];
}

$sql = "SELECT * FROM course" ;
$query = mysqli_query($conn ,$sql);

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>CS BRU - ข้อมูลรายวิชา</title>
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

        /* Dark Cards & Modals */
        .card-dark, .modal-content-dark {
            background: rgba(30, 41, 59, 0.9) !important;
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
            color: #f8fafc;
        }

        .card-header-dark, .modal-header-dark {
            background: rgba(15, 23, 42, 0.6);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            color: #38bdf8;
            font-weight: 600;
        }

        /* Form Control Dark */
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

        .form-select-dark option {
            background-color: #1e293b;
            color: #f8fafc;
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

        /* Buttons Glow Effects */
        .btn-glow-success {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-weight: 600;
            border-radius: 10px;
            box-shadow: 0 4px 14px 0 rgba(16, 185, 129, 0.35);
            transition: all 0.3s ease;
        }

        .btn-glow-success:hover {
            color: #ffffff;
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px 0 rgba(16, 185, 129, 0.5);
        }

        .btn-action-edit {
            background: rgba(56, 189, 248, 0.15);
            border: 1px solid rgba(56, 189, 248, 0.4);
            color: #38bdf8;
            border-radius: 8px;
            padding: 5px 12px;
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
            padding: 5px 12px;
            transition: all 0.2s ease;
        }

        .btn-action-del:hover {
            background: #e11d48;
            color: #ffffff;
            box-shadow: 0 0 12px rgba(244, 63, 94, 0.4);
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
                    <h1 class="mt-2 fw-bold text-white"><i class="fa-solid fa-book-open me-2 text-info"></i>ข้อมูลรายวิชา</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item text-secondary">จัดการข้อมูล</li>
                        <li class="breadcrumb-item active text-info">ข้อมูลรายวิชา</li>
                    </ol>

                    <div class="card card-dark mb-4">
                        <div class="card-header card-header-dark py-3 d-flex align-items-center justify-content-between">
                            <div>
                                <i class="fas fa-table me-2"></i> รายการรายวิชาทั้งหมด
                            </div>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-glow-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fa-solid fa-plus me-1"></i> เพิ่มข้อมูลรายวิชา
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatablesSimple" class="table">
                                    <thead>
                                        <tr>
                                            <th><i class="fa fa-filter me-1"></i> ลำดับ</th>
                                            <th><i class="fa fa-filter me-1"></i> ชื่อรายวิชา</th>
                                            <th><i class="fa fa-filter me-1"></i> อาจารย์ผู้สอน</th>
                                            <th class="text-center"><i class="fa-solid fa-gear me-1"></i> ตัวเลือก</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $i=1; while($data = mysqli_fetch_assoc($query)){ ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td class="fw-semibold text-white"><?php echo htmlspecialchars($data['name']); ?></td>
                                                <td><span class="text-info"><?php echo htmlspecialchars(show_name_professor_form_id($data['id_professor'])); ?></span></td>
                                                <td class="text-center">
                                                    <a class="btn btn-action-edit me-1 text-decoration-none" href="edit_course.php?id=<?= $data['id'] ?>">
                                                        <i class="fa-solid fa-pen-to-square me-1"></i> แก้ไข
                                                    </a>
                                                    <button class="btn btn-action-del" onclick="confirmDelete(<?= $data['id'] ?>, '<?= addslashes(htmlspecialchars($data['name'])) ?>')">
                                                        <i class="fa-solid fa-trash-can me-1"></i> ลบ
                                                    </button> 
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Modal เพิ่มข้อมูลรายวิชา -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content modal-content-dark">
                                <div class="modal-header modal-header-dark">
                                    <h5 class="modal-title fw-bold" id="exampleModalLabel"><i class="fa-solid fa-square-plus text-info me-2"></i> เพิ่มข้อมูลรายวิชา</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <form action="back_end/add_course.php" method="POST">
                                    <div class="modal-body py-4">
                                        <!-- ชื่อรายวิชา -->
                                        <div class="form-floating mb-3">
                                            <input required type="text" name="name" id="modalCourseName" class="form-control form-control-dark" placeholder="ชื่อรายวิชา">
                                            <label for="modalCourseName"><i class="fa-solid fa-book me-1"></i> ชื่อรายวิชา</label>
                                        </div>

                                        <!-- อาจารย์ผู้สอน -->
                                        <div>
                                            <label class="form-label text-info fw-semibold mb-2 small"><i class="fa-solid fa-chalkboard-user me-1"></i> อาจารย์ผู้สอน</label>
                                            <select required class="form-select form-select-dark py-3 px-3" name="id_professor" aria-label="อาจารย์ผู้สอน">
                                                <option value="" selected>เลือกอาจารย์ผู้สอน</option>
                                                <?php select_name_professor(); ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="modal-footer border-top-0 pt-0">
                                        <button type="button" class="btn btn-outline-secondary text-secondary border-0" data-bs-dismiss="modal">ยกเลิก</button>
                                        <button type="submit" class="btn btn-glow-success"><i class="fa-solid fa-floppy-disk me-1"></i> บันทึกข้อมูล</button>
                                    </div>
                                </form>
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

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        // แจ้งเตือนเมื่ออัปเดตสำเร็จ
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

        // ยืนยันการลบข้อมูลรายวิชา
        function confirmDelete(courseId, courseName) {
            Swal.fire({
                title: 'ยืนยันการลบรายวิชา?',
                html: `<span class="text-light">คุณต้องการลบรายวิชา <b>"${courseName}"</b> ใช่หรือไม่?</span>`,
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
                    window.location.href = `back_end/del_course.php?id=${courseId}`;
                }
            });
        }
    </script>

</body>

</html>