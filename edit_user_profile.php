<?php 

    session_start();

    require('back_end/server.php');
    require('back_end/funtion.php');

    if(!isset($_SESSION['id'])){
        Header("Location:index.php");
        session_destroy();
    }

    $id = $_SESSION['id'];
    $ID_personnel = $_SESSION['ID_personnel'];
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $level = $_SESSION['level'];

    $sql = "SELECT * FROM user_student WHERE id = '$id' ";
    $resule_student = mysqli_query($conn,$sql);
    $row_me = mysqli_fetch_assoc($resule_student);

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>CS BRU - แก้ไขข้อมูลส่วนตัวนักศึกษา</title>
    <link rel="shortcut icon" href="img/LOGO-bru.png">
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Cyber / Dark Glass Custom Theme Styling -->
    <style>
        body.theme-dark {
            background: #0f172a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
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

        .form-select-dark option {
            background-color: #1e293b;
            color: #f8fafc;
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

        .logo-header {
            max-width: 150px;
            height: auto;
        }

        .file-upload-box {
            background: rgba(15, 23, 42, 0.5);
            border: 1px dashed rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 15px;
        }
    </style>
</head>

<body class="theme-dark" onload="select(<?php echo $row_me['gender'] ?>,<?php echo $row_me['year'] ?>)">

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-7">

                <?php if(isset( $_SESSION['error[]'] )){ ?>
                    <?php error_show( $_SESSION['error[]']); ?>
                <?php }?>

                <div class="card card-dark p-3 p-md-4">
                    
                    <div class="text-center pt-2 pb-3">
                        <img src="img/cs_bru_logo.png" alt="CS BRU Logo" class="logo-header img-fluid mb-3">
                        <h3 class="fw-bold text-white mb-1">แก้ไขข้อมูลส่วนตัว</h3>
                        <p class="text-secondary small">นักศึกษา CS BRU</p>
                    </div>

                    <div class="card-body pt-0">
                        <form action="back_end/edit_user_profile.php" method="POST" enctype="multipart/form-data">

                            <!-- เลือกรูปภาพประจำตัว -->
                            <div class="file-upload-box mb-3">
                                <label for="formFile" class="form-label text-info fw-semibold mb-2">
                                    <i class="fa-solid fa-image me-1"></i> เลือกรูปภาพประจำตัว <span class="text-secondary small fw-normal">(ขนาดภาพ 150x150)</span>
                                </label>
                                <input class="form-control form-control-dark" type="file" id="formFile" name="file">
                            </div>

                            <!-- รหัสนักศึกษา -->
                            <div class="form-floating mb-3">
                                <input class="form-control form-control-dark" id="inputStudentId" required type="text" name="ID_student" 
                                    maxlength="12" value="<?php echo htmlspecialchars($row_me['ID_student']); ?>"
                                    placeholder="รหัสนักศึกษา 12 หลัก" />
                                <label for="inputStudentId"><i class="fa-solid fa-id-card me-1"></i> รหัสนักศึกษา 12 หลัก</label>
                            </div>

                            <!-- ชื่อ - นามสกุล -->
                            <div class="row mb-3 g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control form-control-dark" id="inputFirstName" required name="f_name"
                                            type="text" placeholder="ชื่อ" value="<?php echo htmlspecialchars($row_me['f_name']); ?>" />
                                        <label for="inputFirstName"><i class="fa-solid fa-user me-1"></i> ชื่อ (ไม่ต้องใส่คำนำหน้า)</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control form-control-dark" id="inputLastName" required name="l_name"
                                            type="text" placeholder="นามสกุล" value="<?php echo htmlspecialchars($row_me['l_name']); ?>" />
                                        <label for="inputLastName"><i class="fa-solid fa-user me-1"></i> นามสกุล</label>
                                    </div>
                                </div>
                            </div>

                            <!-- เพศ & ชั้นปี -->
                            <div class="row mb-3 g-3">
                                <div class="col-md-6">
                                    <select class="form-select form-select-dark py-3 px-3" id="gender" required name="gender">
                                        <option value="">เพศ</option>
                                        <option value="1">ชาย</option>
                                        <option value="2">หญิง</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <select class="form-select form-select-dark py-3 px-3" id="year" required name="year">
                                        <option value="" selected>ชั้นปีที่</option>
                                        <option value="1">ปี 1</option>
                                        <option value="2">ปี 2</option>
                                        <option value="3">ปี 3</option>
                                        <option value="4">ปี 4</option>
                                        <option value="5">มากกว่า 4 ปี</option>
                                    </select>
                                </div>
                            </div>

                            <!-- อีเมล BRU (Readonly) -->
                            <div class="form-floating mb-4">
                                <input class="form-control form-control-dark" required id="myEmail" type="email" name="email" maxlength="22" readonly
                                    placeholder="อีเมล" value="<?php echo htmlspecialchars($row_me['email']); ?>"/>
                                <label for="myEmail"><i class="fa-solid fa-envelope me-1"></i> ที่อยู่ Email BRU</label>
                            </div>

                            <!-- ปุ่มบันทึก -->
                            <div class="d-grid gap-2">
                                <button class="btn btn-glow py-3 fs-6" type="submit">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> แก้ไขข้อมูล
                                </button>
                            </div>

                        </form>
                    </div>

                    <div class="card-footer bg-transparent border-top-0 text-center pt-2 pb-3">
                        <a href="page_main.php" class="text-decoration-none small text-info fw-bold">
                            <i class="fa-solid fa-arrow-left me-1"></i> กลับไปหน้าโปรไฟล์ของฉัน
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>

    <script type="text/javascript">
        function select(gender, year){
            if(gender == 1){
                document.getElementById("gender").value = "1";
            } else if(gender == 2) {
                document.getElementById("gender").value = "2";
            }

            if(year == 1){
                document.getElementById("year").value = "1";
            } else if(year == 2){
                document.getElementById("year").value = "2";
            } else if(year == 3){
                document.getElementById("year").value = "3";
            } else if(year == 4){
                document.getElementById("year").value = "4";
            } else if(year > 4){
                document.getElementById("year").value = "5";
            }
        }
    </script>

</body>

</html>