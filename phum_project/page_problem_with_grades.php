<?php 

    session_start();

    require('back_end/server.php');
    require('back_end/funtion.php');

    if(!isset($_SESSION['id'])){
        header("Location: index.php");
        session_destroy();
        exit();
    }

    $id =$_SESSION['id'];
    $ID_personnel =$_SESSION['ID_personnel'] ?? '';
    $name =$_SESSION['name'] ?? '';
    $email =$_SESSION['email'] ?? '';
    $level =$_SESSION['level'] ?? 1;

    ///// ดึงข้อมูลเกรดที่มีปัญหาทั้งหมดของนักศึกษานี้
    $sql = "SELECT * FROM grad WHERE `id_student` = '$id'";
    $resule_student = mysqli_query($conn, $sql);$count_data = $resule_student ? mysqli_num_rows($resule_student) : 0;

    ///// ดึงข้อมูลอาจารย์ทั้งหมดไว้สำหรับเลือก
    $sql_professor = "SELECT * FROM user_professor";
    $data_professor = mysqli_query($conn, $sql_professor);$count_professor = $data_professor ? mysqli_num_rows($data_professor) : 0;
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>CS BRU - ผลการเรียนมีปัญหา</title>
    <link rel="shortcut icon" href="img/LOGO-bru.png">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Cyber / Dark Glass Theme Styling -->
    <style>
        body.sb-nav-fixed.theme-dark {
            background-color: #0f172a;
            color: #f8fafc;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
        }

        .sb-topnav.bg-dark-glass {
            background: rgba(15, 23, 42, 0.95) !important;
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

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

        /* สไตล์ปุ่มแก้ไขข้อมูลสไตล์ Cyber (ตรงตามรูปภาพ) */
        .btn-outline-cyber {
            color: #38bdf8;
            border: 1px solid #0284c7;
            background: rgba(14, 165, 233, 0.12);
            border-radius: 10px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-outline-cyber:hover {
            background: #0284c7;
            color: #ffffff;
            box-shadow: 0 0 15px rgba(56, 189, 248, 0.4);
            transform: translateY(-1px);
        }

        /* ระบบสลับโหมดการแสดงผลในตาราง (CSS Mode Toggling) */
        .table-view-mode .edit-mode {
            display: none !important;
        }
        .table-view-mode .view-mode {
            display: inline-block !important;
        }

        .table-edit-mode .view-mode {
            display: none !important;
        }
        .table-edit-mode .edit-mode {
            display: inline-block !important;
        }

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

        <!-- Main Content Area -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4 py-3">
                    
                    <h1 class="mt-2 fw-bold text-white"><i class="fa-solid fa-triangle-exclamation text-warning me-2"></i>ผลการเรียนมีปัญหา</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item text-secondary">โปรไฟล์</li>
                        <li class="breadcrumb-item active text-info">รายการวิชาติด I / F</li>
                    </ol>

                    <!-- Table Container -->
                    <div class="card card-dark mb-4">
                        <div class="card-header card-header-dark py-3 d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-table me-2"></i> รายการผลการเรียนมีปัญหา</span>
                            <span class="badge bg-danger bg-opacity-20 text-danger px-3 py-2 rounded-pill"><?php echo $count_data; ?> รายวิชา</span>
                        </div>

                        <div class="card-body">
                            <form id="editGradeForm" action="back_end/edit_problem_with_grades.php" method="POST">
                                <table id="datatablesSimple" class="table table-dark-custom align-middle table-view-mode">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>ชื่อนักศึกษา</th>
                                            <th>ชื่อรายวิชา</th>
                                            <th>อาจารย์ผู้รับผิดชอบ</th>
                                            <th>เกรด</th>
                                            <th class="text-center">จัดการ</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php 
                                            if($resule_student &&$count_data > 0){
                                                for($i = 0; $i < $count_data; $i++){ 
                                                    $row = mysqli_fetch_assoc($resule_student); 
                                        ?>
                                            <tr>
                                                <td><?php echo $i + 1; ?></td>
                                                <td class="fw-medium text-white"><?php echo show_name_student_form_id($row['id_student']); ?></td>
                                                
                                                <!-- รายวิชา -->
                                                <td>
                                                    <span class="view-mode text-info"><?php echo coures_d($row['id_course'])['name'] ?? '-'; ?></span>
                                                    <div class="edit-mode">
                                                        <input name="id_grad[]" type="hidden" value="<?php echo $row['id']; ?>" disabled>
                                                        <select class="form-select form-select-dark" required name="coures[]" disabled>
                                                            <option value="">-- เลือกรายวิชา --</option>
                                                            <?php select_coures_form($row['id_course']); ?>
                                                        </select>
                                                    </div>
                                                </td>

                                                <!-- อาจารย์ผู้รับผิดชอบ -->
                                                <td>
                                                    <span class="view-mode"><?php echo show_name_professor_form_id($row['id_professor']); ?></span>
                                                    <div class="edit-mode">
                                                        <select class="form-select form-select-dark" name="id_professor[]" disabled>
                                                            <?php select_professor($row['id_professor']); ?>
                                                        </select>
                                                    </div>
                                                </td>

                                                <!-- เกรด -->
                                                <td>
                                                    <span class="view-mode badge <?php echo ($row['grad'] == 'F') ? 'bg-danger' : 'bg-warning text-dark'; ?> px-3 py-1 rounded-pill fw-bold">
                                                        <?php echo htmlspecialchars($row['grad']); ?>
                                                    </span>
                                                    <div class="edit-mode">
                                                        <select class="form-select form-select-dark" required name="grad[]" disabled>
                                                            <option value="">-- เกรด --</option>
                                                            <?php select_grad($row['grad']); ?>
                                                        </select>
                                                    </div>
                                                </td>

                                                <!-- จัดการ (ปุ่มลบ) -->
                                                <td class="text-center">
                                                    <span class="view-mode text-secondary">-</span>
                                                    <div class="edit-mode">
                                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete(<?php echo $row['id']; ?>)">
                                                            <i class="fa-solid fa-trash me-1"></i> ลบ
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php 
                                                } 
                                            } 
                                        ?>
                                    </tbody>
                                </table>

                                <!-- Action Toolbar -->
                                <div class="d-flex align-items-center justify-content-between mt-3 pt-3 border-top border-secondary border-opacity-25">
                                    <div>
                                        <button type="button" id="openform_1" onclick="openForm()" class="btn btn-outline-warning btn-sm me-2">
                                            <i class="fa-solid fa-plus me-1"></i> เพิ่มผลการเรียนมีปัญหา
                                        </button>
                                        <button type="button" id="openform_2" onclick="closeForm()" class="btn btn-secondary btn-sm" style="display:none;">
                                            <i class="fa-solid fa-xmark me-1"></i> ซ่อนฟอร์มเพิ่ม
                                        </button>
                                    </div>

                                    <div>
                                        <!-- ปุ่มแก้ไขข้อมูลตามแบบในรูปภาพ -->
                                        <button type="button" id="openForm_grad" onclick="openForm_grad()" class="btn btn-outline-cyber">
                                            <i class="fa-solid fa-pen-to-square me-2"></i>แก้ไขข้อมูล
                                        </button>
                                        <button type="button" id="closeForm_grad" onclick="closeForm_grad()" class="btn btn-secondary btn-sm me-2" style="display:none;">
                                            <i class="fa-solid fa-xmark me-1"></i> ยกเลิก
                                        </button>
                                        <button type="submit" id="save" class="btn btn-success btn-sm" style="display:none;">
                                            <i class="fa-solid fa-floppy-disk me-1"></i> บันทึกการแก้ไข
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Panel เพิ่มเกรดมีปัญหา (Form View) -->
                    <div class="row" id="form_add_panel" style="display:none;">
                        <div class="col-lg-6 mb-4">
                            <div class="card card-dark">
                                <div class="card-header card-header-dark py-3">
                                    <i class="fa-solid fa-folder-plus me-2"></i> เพิ่มรายการเกรดที่มีปัญหาใหม่
                                </div>
                                <div class="card-body">
                                    <form action="back_end/add_problem_with_grades.php" method="POST">
                                        <div class="mb-3">
                                            <label class="form-label small text-secondary">เลือกรายวิชา <span class="text-danger">*</span></label>
                                            <select class="form-select form-select-dark" required name="coures">
                                                <option value="">-- เลือกรายวิชา --</option>
                                                <?php select_coures(); ?>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small text-secondary">เกรดที่ได้รับ <span class="text-danger">*</span></label>
                                            <select class="form-select form-select-dark" required name="gender">
                                                <option value="">-- เลือกเกรด --</option>
                                                <option value="I">I (Incomplete)</option>
                                                <option value="F">F (Fail)</option>
                                            </select>
                                        </div>

                                        <div class="text-end mt-4">
                                            <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk me-1"></i> บันทึกเกรดมีปัญหา</button>
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
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@5.0.3" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        // Toggle Panel เพิ่มเกรด
        function openForm() {
            document.getElementById("openform_1").style.display = "none";
            document.getElementById("openform_2").style.display = "inline-block";
            document.getElementById("form_add_panel").style.display = "flex";
        }

        function closeForm() {
            document.getElementById("openform_1").style.display = "inline-block";
            document.getElementById("openform_2").style.display = "none";
            document.getElementById("form_add_panel").style.display = "none";
        }

        // ฟังก์ชันสลับโหมดแก้ไขข้อมูล (รองรับ DataTables 100%)
        function openForm_grad() {
            const table = document.getElementById("datatablesSimple");
            table.classList.remove("table-view-mode");
            table.classList.add("table-edit-mode");

            // เปิดการทำงานอินพุตแก้ไขทั้งหมด
            document.querySelectorAll('#editGradeForm .edit-mode select, #editGradeForm .edit-mode input').forEach(el => {
                el.removeAttribute('disabled');
            });

            document.getElementById("openForm_grad").style.display = "none";
            document.getElementById("closeForm_grad").style.display = "inline-block";
            document.getElementById("save").style.display = "inline-block";
        }

        function closeForm_grad() {
            const table = document.getElementById("datatablesSimple");
            table.classList.remove("table-edit-mode");
            table.classList.add("table-view-mode");

            // ปิดการทำงานอินพุตเพื่อไม่ให้กระทบต่อ Form Validation
            document.querySelectorAll('#editGradeForm .edit-mode select, #editGradeForm .edit-mode input').forEach(el => {
                el.setAttribute('disabled', 'true');
            });

            document.getElementById("openForm_grad").style.display = "inline-block";
            document.getElementById("closeForm_grad").style.display = "none";
            document.getElementById("save").style.display = "none";
        }

        // ยืนยันการลบรายการวิชาติด I/F ด้วย SweetAlert2
        function confirmDelete(id) {
            Swal.fire({
                title: 'ยืนยันการลบรายการ?',
                text: "คุณต้องการลบรายวิชานี้ออกจากรายการเกรดมีปัญหาหรือไม่",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'ลบรายการ',
                cancelButtonText: 'ยกเลิก',
                customClass: { popup: 'swal2-popup-dark' }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'back_end/delete_problem_with_grades.php?id=' + id;
                }
            });
        }

        function JSalert() {
            Swal.fire({
                icon: 'success',
                title: 'อัปเดตสำเร็จ!',
                text: 'เนื้อหาของคุณได้รับการอัปเดตเรียบร้อยแล้ว',
                confirmButtonColor: '#059669',
                customClass: { popup: 'swal2-popup-dark' }
            });
        }
    </script>

    <?php
        // Helper Functions
        function select_grad($grad){
            if($grad == "I"){
                echo "<option selected value='I'>I</option>";
                echo "<option value='F'>F</option>";
            } else if($grad == "F"){
                echo "<option value='I'>I</option>";
                echo "<option selected value='F'>F</option>";
            } else {
                echo "<option value='I'>I</option>";
                echo "<option value='F'>F</option>";
            }
        }

        function select_professor($id_professor){
            global $conn;
            if(!$conn) {
                require('back_end/server.php');
            }

            $sql_professor = "SELECT * FROM user_professor ORDER BY name ASC";
            $data_professor = mysqli_query($conn,$sql_professor);

            if($id_professor == NULL or $id_professor == '' or$id_professor == 'NULL'){
                echo "<option selected value='NULL'>-- ไม่ระบุอาจารย์ --</option>";
            } else {
                echo "<option value='NULL'>-- ไม่ระบุอาจารย์ --</option>";
            }

            if($data_professor && mysqli_num_rows($data_professor) > 0){
                while($row_professor = mysqli_fetch_assoc($data_professor)){$p_id = $row_professor['id'];$p_name = show_name_professor_form_id($p_id);$selected = ($id_professor ==$p_id) ? "selected" : "";
                    echo "<option value='$p_id' $selected>$p_name</option>";
                }
            }
        }
    ?>

</body>

</html>