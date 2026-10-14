<?php 

    session_start();

    require('back_end/server.php');
    require('back_end/funtion.php');

    /////ดึงข้อมูลอาจารย์ทั้งหมด
    $sql = "SELECT * FROM user_professor";
    $resule_student = mysqli_query($conn,$sql);
    $count_data = mysqli_num_rows($resule_student);

    $id = $_SESSION['id'];

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>CS BRU - ขอนัดหมายอาจารย์</title>
    <link rel="shortcut icon" href="img/LOGO-bru.png">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Cyber / Dark Glass Custom Theme Styling -->
    <style>
        body.theme-dark {
            background-color: #0f172a;
            color: #f8fafc;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            min-height: 100vh;
        }

        /* Dark Glass Cards */
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

        /* Dark Form Floating Controls */
        .form-floating > .form-control-dark {
            background-color: rgba(15, 23, 42, 0.7) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            color: #f8fafc !important;
            border-radius: 10px;
        }

        .form-floating > .form-control-dark:focus {
            border-color: #38bdf8 !important;
            box-shadow: 0 0 0 0.25rem rgba(56, 189, 248, 0.25) !important;
        }

        .form-floating > label {
            color: #94a3b8 !important;
        }

        .form-floating > .form-control-dark:focus ~ label,
        .form-floating > .form-control-dark:not(:placeholder-shown) ~ label {
            color: #38bdf8 !important;
        }

        /* Custom Action Buttons */
        .btn-submit-glow {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            border: 1px solid rgba(16, 185, 129, 0.4);
            color: #ffffff;
            border-radius: 10px;
            font-weight: 600;
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.3);
            transition: all 0.2s ease;
        }

        .btn-submit-glow:hover {
            background: linear-gradient(135deg, #047857 0%, #059669 100%);
            color: #ffffff;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.5);
        }

        .btn-select-glow {
            background: rgba(56, 189, 248, 0.15);
            border: 1px solid rgba(56, 189, 248, 0.4);
            color: #38bdf8;
            border-radius: 8px;
            padding: 4px 12px;
            transition: all 0.2s ease;
        }

        .btn-select-glow:hover {
            background: #0284c7;
            color: #ffffff;
            box-shadow: 0 0 12px rgba(56, 189, 248, 0.4);
        }

        .btn-cancel-dark {
            background: rgba(100, 116, 139, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #cbd5e1;
            border-radius: 8px;
            padding: 6px 16px;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-cancel-dark:hover {
            background: rgba(100, 116, 139, 0.4);
            color: #ffffff;
        }

        /* Datatables Dark Styling */
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

<body class="theme-dark py-4">

    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    
                    <!-- CS BRU Logo Header -->
                    <div class="text-center mb-4">
                        <img src="img/cs_bru_logo.png" alt="CS BRU Logo" style="max-width: 180px; filter: drop-shadow(0 0 10px rgba(56, 189, 248, 0.3));">
                    </div>

                    <div class="row justify-content-center">

                        <!-- STEP 1: ตารางเลือกอาจารย์ -->
                        <div class="col-lg-10" id="form_1">
                            <div class="card card-dark shadow-lg border-0 my-2">
                                <div class="card-header card-header-dark text-center py-3">
                                    <h4 class="mb-0 fw-bold"><i class="fa-solid fa-user-tie me-2"></i>เลือกอาจารย์ที่จะนัดหมาย</h4>
                                </div>
                                <div class="card-body p-4">
                                    <div class="table-responsive">
                                        <table id="datatablesSimple" class="table">
                                            <thead>
                                                <tr>
                                                    <th><i class="fa fa-filter me-1"></i> ลำดับ</th>
                                                    <th><i class="fa fa-filter me-1"></i> ชื่อ-นามสกุลอาจารย์</th>
                                                    <th><i class="fa fa-filter me-1"></i> อีเมลติดต่อ</th>
                                                    <th class="text-center"><i class="fa-solid fa-gear me-1"></i> ตัวเลือก</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php for($i = 0 ; $i < $count_data ; $i++){ $row = mysqli_fetch_assoc($resule_student); ?>
                                                    <tr>
                                                        <td><?php echo $i + 1; ?></td>
                                                        <td class="fw-medium text-white professor-name"><?php echo htmlspecialchars($row['f_name']." ".$row['l_name']); ?></td>
                                                        <td class="text-info"><?php echo htmlspecialchars($row['email']); ?></td>
                                                        <td class="text-center">
                                                            <button class="btn btn-select-glow btn-sm" onclick="select(<?php echo $i; ?>, <?php echo $row['id']; ?>)">
                                                                <i class="fa-solid fa-calendar-check me-1"></i> ขอนัดหมาย
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer text-center py-3 border-top border-secondary border-opacity-25">
                                    <a href="page_appointment_student.php" class="btn btn-cancel-dark btn-sm d-inline-flex align-items-center">
                                        <i class="fa-solid fa-arrow-left me-2"></i> ย้อนกลับหน้าเดิม
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 2: ฟอร์มกรอกรายละเอียดนัดหมาย (ซ่อนเริ่มต้น) -->
                        <div class="col-lg-8" id="form_2">
                            <div class="card card-dark shadow-lg border-0 my-2">
                                <div class="card-header card-header-dark text-center py-3">
                                    <h4 class="mb-0 fw-bold"><i class="fa-solid fa-calendar-plus me-2"></i>รายละเอียดการขอนัดหมาย</h4>
                                </div>
                                <div class="card-body p-4">
                                    <form action="back_end/add_appointment_student.php" method="POST">

                                        <!-- ชื่อนักศึกษา -->
                                        <div class="form-floating mb-3">
                                            <input class="form-control form-control-dark" readonly required type="text" value="<?php echo htmlspecialchars(show_name_student_form_id($id)); ?>" placeholder="นักศึกษา" />
                                            <label><i class="fa-solid fa-user-graduate me-1"></i> นักศึกษาผู้ขอนัดหมาย</label>
                                        </div>

                                        <!-- ชื่ออาจารย์ (แสดงผล) -->
                                        <div class="form-floating mb-3">
                                            <input class="form-control form-control-dark" id="input_professor" readonly required type="text" placeholder="อาจารย์" />
                                            <label><i class="fa-solid fa-user-tie me-1"></i> อาจารย์ผู้นัดหมาย</label>
                                        </div>

                                        <!-- ID อาจารย์ ( Hidden ) -->
                                        <input id="input_professor2" required type="hidden" name="id_professor" />

                                        <!-- ชื่อการนัดหมาย -->
                                        <div class="form-floating mb-3">
                                            <input class="form-control form-control-dark" required type="text" name="name" placeholder="หัวข้อนัดหมาย" />
                                            <label><i class="fa-solid fa-pen-nib me-1"></i> หัวข้อ / ชื่อการนัดหมาย</label>
                                        </div>

                                        <!-- วันที่และเวลา -->
                                        <div class="form-floating mb-3">
                                            <input class="form-control form-control-dark" required type="datetime-local" name="date_time" />
                                            <label><i class="fa-solid fa-clock me-1"></i> วันที่และเวลาที่ต้องการนัดหมาย</label>
                                        </div>

                                        <!-- ความคิดเห็นนักศึกษา -->
                                        <div class="form-floating mb-3">
                                            <textarea class="form-control form-control-dark" name="details_student" placeholder="ความคิดเห็นนักศึกษา" id="details_student" style="height: 100px"></textarea>
                                            <label for="details_student"><i class="fa-solid fa-comment-dots me-1"></i> หมายเหตุ / ความคิดเห็นนักศึกษา</label>
                                        </div>

                                        <!-- ความคิดเห็นอาจารย์ (Readonly) -->
                                        <div class="form-floating mb-4">
                                            <textarea class="form-control form-control-dark" readonly name="details_professor" placeholder="ความคิดเห็นอาจารย์" id="details_professor" style="height: 100px"></textarea>
                                            <label for="details_professor"><i class="fa-solid fa-comment-medical me-1"></i> ความคิดเห็นอาจารย์ (สำหรับอาจารย์กรอก)</label>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="d-grid mt-4">
                                            <button class="btn btn-submit-glow py-3 fs-5" type="submit">
                                                <i class="fa-solid fa-paper-plane me-2"></i> ยืนยันการขอนัดหมาย
                                            </button>
                                        </div>

                                    </form>
                                </div>
                                <div class="card-footer text-center py-3 border-top border-secondary border-opacity-25">
                                    <button class="btn btn-cancel-dark btn-sm me-2" type="button" onclick="backToSelect()">
                                        <i class="fa-solid fa-rotate-left me-1"></i> เปลี่ยนอาจารย์
                                    </button>
                                    <a href="page_appointment_student.php" class="btn btn-cancel-dark btn-sm">
                                        <i class="fa-solid fa-xmark me-1"></i> ยกเลิก
                                    </a>
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

    <script type="text/javascript">
        // Initialize DataTables
        window.addEventListener('DOMContentLoaded', event => {
            const datatablesSimple = document.getElementById('datatablesSimple');
            if (datatablesSimple) {
                new simpleDatatables.DataTable(datatablesSimple);
            }
        });

        let form_1 = document.getElementById("form_1");
        let form_2 = document.getElementById("form_2"); 
        
        // Hide Step 2 default
        if(form_2) {
            form_2.hidden = true;
        }

        // Select Professor Function
        function select(index, id){
            let professors = document.querySelectorAll(".professor-name");
            let input_professor = document.getElementById("input_professor");
            let input_professor2 = document.getElementById("input_professor2");
            
            if(professors[index]){
                input_professor.value = professors[index].innerText;
            }
            input_professor2.value = id;
            
            form_1.hidden = true;
            form_2.hidden = false;
        }

        // Back to Professor Selection
        function backToSelect(){
            form_1.hidden = false;
            form_2.hidden = true;
        }
    </script>

</body>

</html>