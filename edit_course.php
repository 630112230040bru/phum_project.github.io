<?php 

session_start();

require('back_end/server.php');
require('back_end/funtion.php');
require('class/user_student.php');

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

$id = $_GET['id'];

$sql = "SELECT * FROM course WHERE id = '$id' ";
$resule_student = mysqli_query($conn,$sql);
$row_me = mysqli_fetch_assoc($resule_student);

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>CS BRU - แก้ไขข้อมูลรายวิชา</title>
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

        .form-select-dark option {
            background-color: #1e293b;
            color: #f8fafc;
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

        .logo-header {
            max-width: 150px;
            height: auto;
        }
    </style>
</head>

<body class="theme-dark" <?php if( isset($_SESSION['error']) ){ echo "onload=JSalert()"; unset($_SESSION['error']); } ?>>

    <div class="container py-4">
        
        <div class="text-center mb-4">
            <img src="img/cs_bru_logo.png" alt="CS BRU Logo" class="logo-header img-fluid">
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-lg-7">

                <div class="card card-dark p-3 p-md-4">
                    
                    <div class="text-center pt-2 pb-3">
                        <h3 class="fw-bold text-white mb-1"><i class="fa-solid fa-pen-to-square text-info me-2"></i> แก้ไขข้อมูลรายวิชา</h3>
                        <p class="text-secondary small">แก้ไขรายละเอียดวิชาและอาจารย์ผู้สอน</p>
                    </div>

                    <div class="card-body pt-0">
                        <form action="back_end/edit_course.php?id=<?= $row_me['id'] ?>" method="POST">

                            <!-- ชื่อรายวิชา -->
                            <div class="form-floating mb-3">
                                <input required type="text" name="name" id="inputCourseName" value="<?= htmlspecialchars($row_me['name']) ?>" class="form-control form-control-dark" placeholder="ชื่อรายวิชา">
                                <label for="inputCourseName"><i class="fa-solid fa-book me-1"></i> ชื่อรายวิชา</label>
                            </div>

                            <!-- อาจารย์ผู้สอน -->
                            <div class="mb-4">
                                <label class="form-label text-info fw-semibold mb-2 small"><i class="fa-solid fa-chalkboard-user me-1"></i> อาจารย์ผู้สอน</label>
                                <select required class="form-select form-select-dark py-3 px-3" name="id_professor" aria-label="อาจารย์ผู้สอน">
                                    <option value="" selected>อาจารย์ผู้สอน</option>
                                    <?php select_name_professor_edit($row_me['id_professor']) ?>
                                </select>
                            </div>

                            <!-- ปุ่มบันทึก -->
                            <div class="d-grid gap-2">
                                <button class="btn btn-glow py-3 fs-6" type="submit">
                                    <i class="fa-solid fa-floppy-disk me-1"></i> บันทึกการแก้ไข
                                </button>
                            </div>

                        </form>
                    </div>

                    <div class="card-footer bg-transparent border-top-0 text-center pt-2 pb-2">
                        <a href="page_course.php" class="text-decoration-none small text-info fw-bold">
                            <i class="fa-solid fa-arrow-left me-1"></i> กลับไปหน้าเดิม
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Script Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>

    <!-- แสดงแจ้งเตือน -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script type="text/javascript">
        function JSalert() {
            swal("แก้ไขข้อมูลรายวิชาไม่สำเร็จ", "กรุณาตรวจสอบข้อมูลอีกครั้ง", "error");
        }
    </script>

</body>

</html>