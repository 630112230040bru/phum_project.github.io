<?php 

    session_start();

    require('back_end/server.php');
    require('back_end/funtion.php');

    $id = $_SESSION['id'];

    $sql = "SELECT * FROM user_student";
    $resule_student = mysqli_query($conn,$sql);
    $count_data = mysqli_num_rows($resule_student);

    $level = $_SESSION['level'];

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>CS BRU - นัดหมายนักศึกษา</title>
    <link rel="shortcut icon" href="img/LOGO-bru.png">
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@5.0.3/dist/style.css" rel="stylesheet" />

    <!-- Cyber / Dark Glass Custom Theme Styling -->
    <style>
        body.theme-dark {
            background: #0f172a;
            min-height: 100vh;
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

        .form-control-dark[readonly] {
            background-color: rgba(15, 23, 42, 0.4) !important;
            color: #94a3b8 !important;
            border-color: rgba(255, 255, 255, 0.05) !important;
        }

        .form-floating > label {
            color: #94a3b8;
        }

        .form-floating > .form-control-dark:focus ~ label,
        .form-floating > .form-control-dark:not(:placeholder-shown) ~ label {
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

        .btn-action-glow {
            background: rgba(14, 165, 233, 0.15);
            border: 1px solid rgba(56, 189, 248, 0.4);
            color: #38bdf8;
            border-radius: 8px;
            padding: 6px 14px;
            transition: all 0.2s ease;
        }

        .btn-action-glow:hover {
            background: #0284c7;
            color: #ffffff;
            box-shadow: 0 0 12px rgba(56, 189, 248, 0.4);
        }

        .logo-header {
            max-width: 150px;
            height: auto;
        }

        /* Styling DataTables for Dark Theme */
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
    </style>
</head>

<body class="theme-dark">

    <div class="container py-4">
        <div class="text-center mb-4">
            <img src="img/cs_bru_logo.png" alt="CS BRU Logo" class="logo-header img-fluid">
        </div>

        <div class="row justify-content-center">

            <!-- ส่วนที่ 1: ตารางรายชื่อนักศึกษา -->
            <div class="col-12 col-lg-10" id="form_1">
                <div class="card card-dark p-3 p-md-4">
                    
                    <div class="text-center pt-2 pb-3">
                        <h3 class="fw-bold text-white mb-1"><i class="fa-solid fa-triangle-exclamation text-warning me-2"></i> นัดหมายนักศึกษาที่ผลการเรียนมีปัญหา</h3>
                        <p class="text-secondary small">เลือกรายชื่อนักศึกษาจากรายการด้านล่างเพื่อทำการสร้างใบนัดหมาย</p>
                    </div>

                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table id="datatablesSimple" class="table">
                                <thead>
                                    <tr>
                                        <th><i class="fa fa-filter me-1"></i> ลำดับ</th>
                                        <th><i class="fa fa-filter me-1"></i> รหัสนักศึกษา</th>
                                        <th><i class="fa fa-filter me-1"></i> ชื่อนักศึกษา</th>
                                        <th><i class="fa fa-filter me-1"></i> ชั้นปี</th>
                                        <th class="text-center"><i class="fa-solid fa-gear me-1"></i> เพิ่มเติม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for($i = 0 ; $i < $count_data ; $i++){ $row = mysqli_fetch_assoc($resule_student); ?>
                                        <tr>
                                            <td><?php echo $i + 1 ?></td>
                                            <td><span class="badge bg-dark border border-secondary text-info"><?php echo htmlspecialchars($row['ID_student']) ?></span></td>
                                            <td id="professor" class="fw-semibold"><?php echo htmlspecialchars($row['f_name']." ".$row['l_name']) ?></td>
                                            <td>ชั้นปีที่ <?php echo htmlspecialchars($row['year']) ?></td>
                                            <td class="text-center"> 
                                                <button class="btn btn-action-glow btn-sm" onclick="select(<?php echo $i ?>,<?php echo $row['id'] ?>)">
                                                    <i class="fa-solid fa-calendar-plus me-1"></i> ขอนัดหมาย
                                                </button> 
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <?php if($level == 1){ ?>
                        <div class="card-footer bg-transparent border-top-0 text-center pt-2 pb-2">
                            <a href="page_appointment_student.php" class="text-decoration-none small text-info fw-bold">
                                <i class="fa-solid fa-arrow-left me-1"></i> กลับหน้านัดหมาย
                            </a>
                        </div>
                    <?php } ?>
                    
                    <?php if($level == 2){ ?>
                        <div class="card-footer bg-transparent border-top-0 text-center pt-2 pb-2">
                            <a href="page_appointment_professor.php" class="text-decoration-none small text-info fw-bold">
                                <i class="fa-solid fa-arrow-left me-1"></i> กลับหน้านัดหมาย
                            </a>
                        </div>
                    <?php } ?>

                </div>
            </div>

            <!-- ส่วนที่ 2: ฟอร์มสร้างใบนัดหมาย (ซ่อนอยู่เป็นค่าเริ่มต้น) -->
            <div class="col-12 col-lg-7" id="form_2">
                <div class="card card-dark p-3 p-md-4">
                    
                    <div class="text-center pt-2 pb-3">
                        <h3 class="fw-bold text-white mb-1"><i class="fa-solid fa-calendar-check text-info me-2"></i> ขอนัดหมายนักศึกษา</h3>
                        <p class="text-secondary small">ระบุรายละเอียดและเวลานัดหมาย</p>
                    </div>

                    <div class="card-body pt-0">
                        <form action="back_end/add_appointment_professor.php" method="POST">

                            <!-- นักศึกษาที่เลือก -->
                            <div class="form-floating mb-3">
                                <input class="form-control form-control-dark" id="input_professor" readonly required type="text" placeholder="นักศึกษา" />
                                <label for="input_professor"><i class="fa-solid fa-user-graduate me-1"></i> นักศึกษา</label>
                            </div>

                            <!-- อาจารย์ผู้เสนอการนัดหมาย -->
                            <div class="form-floating mb-3">
                                <input class="form-control form-control-dark" readonly required type="text" value="<?php echo htmlspecialchars(show_name_professor_form_id($id)) ?>" placeholder="อาจารย์" />
                                <label><i class="fa-solid fa-user-tie me-1"></i> อาจารย์</label>
                            </div>

                            <!-- ID นักศึกษา (Hidden Input) -->
                            <input class="form-control" id="input_professor2" hidden readonly required type="text" name="id_student" />

                            <!-- หัวข้อ / ชื่อการนัดหมาย -->
                            <div class="form-floating mb-3">
                                <input class="form-control form-control-dark" id="inputAppointmentTitle" required type="text" name="name" placeholder="ชื่อการนัดหมาย" />
                                <label for="inputAppointmentTitle"><i class="fa-solid fa-heading me-1"></i> ชื่อการนัดหมาย</label>
                            </div>

                            <!-- วันที่และเวลา -->
                            <div class="form-floating mb-3">
                                <input class="form-control form-control-dark" required id="inputDateTime" type="datetime-local" name="date_time" />
                                <label for="inputDateTime"><i class="fa-solid fa-clock me-1"></i> วันที่และเวลา</label>
                            </div>

                            <!-- ความคิดเห็นนักศึกษา -->
                            <div class="form-floating mb-3">
                                <textarea class="form-control form-control-dark" readonly name="details_student" placeholder="ความคิดเห็นนักศึกษา" id="textareaStudent" style="height: 100px"></textarea>
                                <label for="textareaStudent"><i class="fa-solid fa-comment-dots me-1"></i> ความคิดเห็นนักศึกษา</label>
                            </div>

                            <!-- ความคิดเห็นอาจารย์ -->
                            <div class="form-floating mb-4">
                                <textarea class="form-control form-control-dark" name="details_professor" placeholder="ความคิดเห็นอาจารย์" id="textareaProfessor" style="height: 100px"></textarea>
                                <label for="textareaProfessor"><i class="fa-solid fa-comment-medical me-1"></i> ความคิดเห็นอาจารย์</label>
                            </div>

                            <!-- ปุ่มส่งข้อมูล -->
                            <div class="d-grid gap-2">
                                <button class="btn btn-glow py-3 fs-6" type="submit">
                                    <i class="fa-solid fa-paper-plane me-1"></i> ยืนยันการนัดหมาย
                                </button>
                                <button class="btn btn-outline-secondary text-secondary border-0 mt-1" type="button" onclick="cancelSelect()">
                                    <i class="fa-solid fa-xmark me-1"></i> ยกเลิก / เลือกรายชื่อใหม่
                                </button>
                            </div>

                        </form>
                    </div>

                    <?php if($level == 1){ ?>
                        <div class="card-footer bg-transparent border-top-0 text-center pt-2 pb-2">
                            <a href="page_appointment_student.php" class="text-decoration-none small text-info fw-bold">
                                <i class="fa-solid fa-arrow-left me-1"></i> กลับหน้านัดหมาย
                            </a>
                        </div>
                    <?php } ?>

                    <?php if($level == 2){ ?>
                        <div class="card-footer bg-transparent border-top-0 text-center pt-2 pb-2">
                            <a href="page_appointment_professor.php" class="text-decoration-none small text-info fw-bold">
                                <i class="fa-solid fa-arrow-left me-1"></i> กลับหน้านัดหมาย
                            </a>
                        </div>
                    <?php } ?>

                </div>
            </div>

        </div>
    </div>

    <!-- Script Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@5.0.3" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>

    <!-- Form Switcher Script -->
    <script type="text/javascript">
        let form_1 = document.getElementById("form_1");
        let form_2 = document.getElementById("form_2"); 
        
        form_2.hidden = true;

        function select(selectIndex, studentId){
            let professorList = document.querySelectorAll("#professor");
            let input_professor = document.getElementById("input_professor");
            let input_professor2 = document.getElementById("input_professor2");
            
            input_professor.value = professorList[selectIndex].innerText.trim();
            input_professor2.value = studentId;
            
            form_1.hidden = true;
            form_2.hidden = false;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function cancelSelect() {
            form_1.hidden = false;
            form_2.hidden = true;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>

</body>

</html>