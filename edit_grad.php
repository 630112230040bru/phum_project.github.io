<?php 

session_start();

    require('back_end/server.php');
    require('back_end/funtion.php');
    require('class/user_student.php');

    if(!isset($_SESSION['id'])){
        Header("Location:index.php");
        session_destroy();
        exit();
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

    $id = $_GET['user_id'];
    $term = $_GET['term'];

    $sql = "SELECT BB.name , BB.id_professor , AA.id_student , AA.year , AA.grad , AA.id FROM mini_grad AS AA
    INNER JOIN course AS BB ON AA.id_course = BB.id
    WHERE AA.id_student = '$id' AND AA.year = '$term'";
    $resule_student = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>CS BRU - รายละเอียดเกรดรายวิชา</title>
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

        .card-dark {
            background: rgba(30, 41, 59, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
        }

        .card-header-dark {
            background: rgba(15, 23, 42, 0.6);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            color: #38bdf8;
            font-weight: 600;
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

        .form-select-dark {
            background-color: rgba(15, 23, 42, 0.7) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            color: #f8fafc !important;
            border-radius: 8px;
        }

        .form-select-dark:focus {
            border-color: #38bdf8 !important;
            box-shadow: 0 0 0 0.25rem rgba(56, 189, 248, 0.25) !important;
        }

        /* Modal Dark Glass Styling */
        .modal-content-dark {
            background-color: #1e293b;
            color: #f8fafc;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .modal-header-dark {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modal-footer-dark {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-glow-warning {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 14px 0 rgba(217, 119, 6, 0.39);
            transition: all 0.3s ease;
        }

        .btn-glow-warning:hover {
            color: #ffffff;
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px 0 rgba(217, 119, 6, 0.5);
        }

        .swal2-popup-dark {
            background: #1e293b !important;
            color: #f8fafc !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 16px !important;
        }
    </style>
</head>

<body class="theme-dark py-4" <?php if( isset($_SESSION['succeed']) ){ echo "onload=JSalert()"; unset($_SESSION['succeed']); } ?>>

    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="text-center mb-3">
                    <img src="img/cs_bru_logo.png" alt="CS BRU Logo" style="max-width: 180px; height: auto;">
                </div>
                
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">

                            <div class="card card-dark shadow-lg mt-3">
                                
                                <div class="card-header card-header-dark py-3 rounded-top-4 text-center fs-5">
                                    <i class="fa-solid fa-graduation-cap me-2"></i>จัดการเกรด <?php check_year( $_GET['term'] ) ?>
                                </div>

                                <div class="card-body p-4">

                                    <div class="d-flex justify-content-end mb-3">
                                        <button type="button" class="btn btn-glow-warning px-3 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <i class="fa-solid fa-plus me-1"></i> เพิ่มข้อมูลรายวิชา
                                        </button>
                                    </div>

                                    <div class="card card-dark mb-2">
                                        <div class="card-header card-header-dark py-2">
                                            <i class="fas fa-table me-1"></i> ข้อมูลเกรด <?php check_year( $_GET['term'] ) ?>
                                        </div>

                                        <div class="card-body">
                                            <form action="back_end/edit_mini_grad.php?id=<?= $id ?>&term=<?= $term ?>" method="POST">
                                                <table id="datatablesSimple" class="table table-dark-custom align-middle">
                                                    <thead>
                                                        <tr>
                                                            <th><i class="fa fa-filter"></i> ลำดับ</th>
                                                            <th><i class="fa fa-filter"></i> รายวิชา</th>
                                                            <th><i class="fa fa-filter"></i> ผลการเรียน</th>
                                                            <th><i class="fa fa-filter"></i> อาจารย์ผู้สอน</th>
                                                            <th><i class="fa fa-filter"></i> ปี</th>
                                                            <th class="text-center"><i class="fa fa-filter"></i> จัดการ</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php $i = 1; while($data = mysqli_fetch_assoc($resule_student)){ ?>
                                                        <tr>
                                                            <td><?= $i++ ?></td>
                                                            <td class="fw-semibold text-info"><?= htmlspecialchars($data['name']) ?></td>
                                                            <td>
                                                                <input name="id_grad[]" type="hidden" value="<?php echo $data['id'] ?>">
                                                                <select class="form-select form-select-dark" required aria-label="Default select example" name="gender[]">
                                                                    <option value="">-- เกรด --</option>
                                                                    <?php show_grad_mini($data['grad']) ?>
                                                                </select>
                                                            </td>
                                                            <td><?= show_name_professor_form_id( $data['id_professor'] ) ?></td>
                                                            <td><?= check_year( $data['year'] ) ?></td>
                                                            <td class="text-center">
                                                                <a href="back_end/del_mini_grad.php?id=<?= $data['id'] ?>&id_me=<?= $id ?>&term=<?= $term ?>" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                                                    <i class="fa-solid fa-trash me-1"></i> ลบ
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>

                                                <div class="text-end mt-3">
                                                    <button type="submit" class="btn btn-success px-4 py-2">
                                                        <i class="fa-solid fa-floppy-disk me-1"></i> บันทึกข้อมูล
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>

                                <div class="card-footer bg-transparent border-top border-secondary border-opacity-25 text-center py-3">
                                    <a href="page_main.php" class="text-decoration-none small text-info fw-semibold">
                                        <i class="fa-solid fa-arrow-left me-1"></i> กลับไปหน้าเดิม
                                    </a>
                                </div>

                            </div>

                            <!-- Modal เพิ่มข้อมูลรายวิชา -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content modal-content-dark">
                                        
                                        <div class="modal-header modal-header-dark">
                                            <h5 class="modal-title fw-bold text-info" id="exampleModalLabel">
                                                <i class="fa-solid fa-book-medical me-2"></i>เพิ่มข้อมูลรายวิชา
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <form action="back_end/add_mini_grad.php?id=<?= $id ?>&term=<?= $term ?>" method="POST">
                                            <div class="modal-body py-4">
                                                <label class="form-label small text-secondary">เลือกรายวิชา <span class="text-danger">*</span></label>
                                                <select required class="form-select form-select-dark" name="id_coures" aria-label="Default select example">
                                                    <option value="" selected>-- เลือกรายวิชา --</option>
                                                    <?php select_coures() ?>
                                                </select>
                                            </div>

                                            <div class="modal-footer modal-footer-dark">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                                <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk me-1"></i> บันทึกข้อมูล</button>
                                            </div>
                                        </form>

                                    </div>
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
        function JSalert() {
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: 'เนื้อหาของคุณได้รับการอัปเดตเรียบร้อยแล้ว',
                confirmButtonColor: '#059669',
                customClass: { popup: 'swal2-popup-dark' }
            });
        }
    </script>

</body>

</html>