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

    /////ดึงข้อมูลเกรดที่มีปัญหาทั้งหมด
    $sql = "SELECT * FROM grad WHERE `id_student` = $id";
    $resule_student = mysqli_query($conn,$sql);
    $count_data = mysqli_num_rows($resule_student);

    /////ดึงข้อมูลอาจารย์ทั้งหมดมาให้เลือก
    $sql_professor = "SELECT * FROM user_professor";
    $data_professor = mysqli_query($conn,$sql_professor);
    $count_professor = mysqli_num_rows($data_professor);
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>CS BRU - ผลการเรียนที่มีปัญหา</title>
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

        /* Dark Form Controls */
        .form-control-dark, .form-select-dark {
            background-color: rgba(15, 23, 42, 0.7) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            color: #f8fafc !important;
            border-radius: 8px;
        }

        .form-control-dark:focus, .form-select-dark:focus {
            border-color: #38bdf8 !important;
            box-shadow: 0 0 0 0.25rem rgba(56, 189, 248, 0.25) !important;
        }

        /* Custom Action Buttons */
        .btn-add-glow {
            background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
            border: 1px solid rgba(245, 158, 11, 0.4);
            color: #ffffff;
            border-radius: 8px;
            padding: 6px 16px;
            transition: all 0.2s ease;
        }

        .btn-add-glow:hover {
            background: linear-gradient(135deg, #b45309 0%, #d97706 100%);
            color: #ffffff;
            box-shadow: 0 0 15px rgba(245, 158, 11, 0.4);
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

        .btn-action-edit {
            background: rgba(56, 189, 248, 0.15);
            border: 1px solid rgba(56, 189, 248, 0.4);
            color: #38bdf8;
            border-radius: 8px;
            padding: 6px 16px;
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
                    
                    <h1 class="mt-2 fw-bold text-white"><i class="fa-solid fa-triangle-exclamation me-2 text-warning"></i>ผลการเรียนที่มีปัญหา</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item text-secondary">โปรไฟล์</li>
                        <li class="breadcrumb-item active text-info">ผลการเรียนที่มีปัญหา</li>
                    </ol>

                    <!-- Table Card -->
                    <div class="card card-dark mb-4">
                        <div class="card-header card-header-dark py-3">
                            <i class="fas fa-table me-2"></i> รายการผลการเรียนที่มีปัญหา (I / F)
                        </div>

                        <div class="card-body">
                            <form action="back_end/edit_problem_with_grades.php" method="POST">
                                <div class="table-responsive">
                                    <table id="datatablesSimple" class="table">
                                        <thead>
                                            <tr>
                                                <th><i class="fa fa-filter me-1"></i> ลำดับ</th>
                                                <th><i class="fa fa-filter me-1"></i> ชื่อนักศึกษา</th>
                                                <th><i class="fa fa-filter me-1"></i> ชื่อรายวิชา</th>
                                                <th><i class="fa fa-filter me-1"></i> อาจารย์ผู้รับผิดชอบ</th>
                                                <th><i class="fa fa-filter me-1"></i> เกรด</th>
                                                <th class="text-center"><i class="fa-solid fa-gear me-1"></i> ตัวเลือก</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php for($i = 0 ; $i < $count_data ; $i++){ $row = mysqli_fetch_assoc($resule_student); ?>

                                                <!-- Row View Mode -->
                                                <tr id="show_grad" class="show_grad_row">
                                                    <td><?php echo $i + 1; ?></td>
                                                    <td class="fw-medium text-white"><?php echo htmlspecialchars(show_name_student_form_id($row['id_student'])); ?></td>
                                                    <td class="text-info"><?php echo htmlspecialchars(coures_d($row['id_course'])['name']); ?></td>
                                                    <td class="text-light"><?php echo htmlspecialchars(show_name_professor_form_id($row['id_professor'])); ?></td>
                                                    <td>
                                                        <?php if($row['grad'] == 'I'){ ?>
                                                            <span class="badge bg-warning text-dark px-3 py-2"><i class="fa-solid fa-triangle-exclamation me-1"></i> I</span>
                                                        <?php } else { ?>
                                                            <span class="badge bg-danger text-white px-3 py-2"><i class="fa-solid fa-circle-exclamation me-1"></i> F</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="text-center">-</td>
                                                </tr>

                                                <!-- Row Edit Mode -->
                                                <tr id="edit_grad" class="edit_grad_row">
                                                    <td><?php echo $i + 1; ?></td>
                                                    <td class="fw-medium text-white"><?php echo htmlspecialchars(show_name_student_form_id($row['id_student'])); ?></td>
                                                    <td>
                                                        <input name="id_grad[]" type="text" value="<?php echo $row['id']; ?>" hidden>
                                                        <select class="form-select form-select-dark" required name="coures[]">
                                                            <option value="">-- เลือกรายวิชา --</option>
                                                            <?php select_coures_form($row['id_course']); ?>
                                                        </select>
                                                    </td>
                                                    <td class="text-secondary small">ตามระบบกำหนด</td>
                                                    <td>
                                                        <select class="form-select form-select-dark" required name="gender[]">
                                                            <option value="">-- เกรด --</option>
                                                            <?php select_grad($row['grad']); ?>
                                                        </select>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-action-del btn-sm" onclick="confirmDeleteProblem(<?php echo $row['id']; ?>)" title="ลบรายการนี้">
                                                            <i class="fa-solid fa-trash-can me-1"></i> ลบ
                                                        </button>
                                                    </td>
                                                </tr>

                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Action Buttons Toolbar 
                                <div class="d-flex flex-wrap align-items-center gap-2 mt-3 pt-3 border-top border-secondary border-opacity-25">
                                    <input id="save" class="btn btn-save-glow" type="submit" value="บันทึกการแก้ไข">
                                    <button class="btn btn-action-edit" id="openForm_grad" type="button" onclick="openForm_grad()">
                                        <i class="fa-solid fa-pen-to-square me-1"></i>
                                    </button>-->
                                    <button class="btn btn-cancel-dark" id="closeForm_grad" type="button" onclick="closeForm_grad()">
                                        <i class="fa-solid fa-xmark me-1"></i> ยกเลิก
                                    </button>
                                    <button id="openform_1" type="button" onclick="openForm()" class="btn btn-add-glow">
                                        <i class="fa-solid fa-plus me-1"></i> เพิ่มผลการเรียนมีปัญหา
                                    </button>
                                    <button id="openform_2" type="button" onclick="closeForm()" class="btn btn-cancel-dark">
                                        <i class="fa-solid fa-xmark me-1"></i> ยกเลิกการเพิ่ม
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Add Problematic Grade Form Card (Hidden Default) -->
                    <div class="row" id="form">
                        <div class="col-lg-6 mb-4">
                            <div class="card card-dark">
                                <div class="card-header card-header-dark py-3">
                                    <i class="fa-solid fa-plus-circle me-2"></i> เพิ่มผลการเรียนที่มีปัญหา
                                </div>
                                <div class="card-body">
                                    <form action="back_end/add_problem_with_grades.php" method="POST">
                                        <div class="row g-3">
                                            <div class="col-md-7">
                                                <label class="form-label small text-secondary">เลือกรายวิชา</label>
                                                <select class="form-select form-select-dark" required name="coures">
                                                    <option value="">-- เลือกรายวิชา --</option>
                                                    <?php select_coures(); ?>
                                                </select>
                                            </div>

                                            <div class="col-md-5">
                                                <label class="form-label small text-secondary">เลือกเกรดที่ติดปัญหา</label>
                                                <select class="form-select form-select-dark" required name="gender">
                                                    <option value="">-- เกรด --</option>
                                                    <option value="I">I (Incomplete)</option>
                                                    <option value="F">F (Fail)</option>
                                                </select>
                                            </div>

                                            <div class="col-12 text-end mt-4">
                                                <button type="submit" class="btn btn-save-glow">
                                                    <i class="fa-solid fa-floppy-disk me-1"></i> บันทึกข้อมูล
                                                </button>
                                            </div>
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

    <!-- Script Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@5.0.3" crossorigin="anonymous"></script>

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

        // DOM Elements
        let openform_1 = document.getElementById("openform_1");
        let openform_2 = document.getElementById("openform_2");
        let form = document.getElementById("form");

        if (openform_2) openform_2.hidden = true;
        if (form) form.hidden = true;

        function openForm() {
            if (openform_1) openform_1.hidden = true;
            if (openform_2) openform_2.hidden = false;
            if (form) form.hidden = false;
        }

        function closeForm() {
            if (openform_1) openform_1.hidden = false;
            if (openform_2) openform_2.hidden = true;
            if (form) form.hidden = true;
        }

        let open_grad = document.getElementById("openForm_grad");
        let close_grad = document.getElementById("closeForm_grad");
        let save = document.getElementById("save");

        // Hide Edit Rows by default
        let edit_grad_elements = document.querySelectorAll("#edit_grad");
        for(var i = 0; i < edit_grad_elements.length; i++){
            edit_grad_elements[i].hidden = true;
        }
        if (close_grad) close_grad.hidden = true;
        if (save) save.hidden = true;

        function openForm_grad() {
            let show_grad = document.querySelectorAll("#show_grad");
            let edit_grad = document.querySelectorAll("#edit_grad");

            if (close_grad) close_grad.hidden = false;
            if (open_grad) open_grad.hidden = true;
            if (save) save.hidden = false;

            for(var i = 0; i < show_grad.length; i++){
                show_grad[i].hidden = true;
            }

            for(var i = 0; i < edit_grad.length; i++){
                edit_grad[i].hidden = false;
            }
        }

        function closeForm_grad() {
            let show_grad = document.querySelectorAll("#show_grad");
            let edit_grad = document.querySelectorAll("#edit_grad");

            if (close_grad) close_grad.hidden = true;
            if (open_grad) open_grad.hidden = false;
            if (save) save.hidden = true;

            for(var i = 0; i < show_grad.length; i++){
                show_grad[i].hidden = false;
            }

            for(var i = 0; i < edit_grad.length; i++){
                edit_grad[i].hidden = true;
            }
        }

        // SweetAlert แจ้งเตือนเมื่ออัปเดตสำเร็จ
        function JSalert() {
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: 'อัปเดตข้อมูลผลการเรียนเรียบร้อยแล้ว',
                confirmButtonColor: '#059669',
                customClass: {
                    popup: 'swal2-popup-dark'
                }
            });
        }

        // Confirm Delete Grade Item
        function confirmDeleteProblem(id) {
            Swal.fire({
                title: 'ยืนยันการลบรายวิชาติดปัญหา?',
                text: "รายการนี้จะถูกลบออกจากระบบทันที",
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
                    window.location.href = `back_end/delete_problem_with_grades.php?id=${id}`;
                }
            });
        }
    </script>

    <?php

        function select_grad($grad){

            if($grad == "I"){
                echo "<option selected value='I'>I</option>";
                echo "<option value='F'>F</option>";
            }
            if($grad == "F"){
                echo "<option value='I'>I</option>";
                echo "<option selected value='F'>F</option>";
            }

        }

        function select_professor($id_professor){

            require('back_end/server.php');

            /////ดึงข้อมูลอาจารย์ทั้งหมดมาให้เลือก
            $sql_professor = "SELECT * FROM user_professor";
            $data_professor = mysqli_query($conn,$sql_professor);
            $count_professor = mysqli_num_rows($data_professor);

            for($i = 0; $i < $count_professor ; $i++){ $row_professor = mysqli_fetch_assoc($data_professor);

                $id =$row_professor['id'];
                $name = show_name_professor_form_id($id);

                if($id_professor == NULL){
                    echo "<option selected value='NULL'>ไม่ระบุ</option>";
                }
                else if($id_professor == "$id"){
                    echo "<option selected value='$id'>$name</option>";
                }
                else{
                    echo "<option value='$id'>$name</option>";
                }
            }

        }

    ?>




</body>

</html>