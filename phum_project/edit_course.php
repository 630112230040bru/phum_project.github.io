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
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>CS BRU</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="img/LOGO-bru.png">
</head>

<body class="bg-info" <?php if( isset($_SESSION['error']) ){ echo "onload=JSalert()"; unset($_SESSION['error']); } ?>>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <img src="img/cs_bru_logo.png" alt="" width="25%" height="">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">

                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">แก้ไขรหัสผ่าน</h3>
                                </div>
                                <div class="card-body">
                                    <form action="back_end/edit_course.php?id=<?= $row_me['id'] ?>" method="POST">

                                        <div class="mb-3">

                                            <label class="form-label">ชื่อรายวิชา</label>
                                            <input required type="text" name="name" value="<?= $row_me['name'] ?>" class="form-control">
                                        </div>

                                        <select required class="form-select" name="id_professor"
                                            aria-label="Default select example">
                                            <option  value="" selected>อาจารย์ผู้สอน</option>
                                            <?php select_name_professor_edit($row_me['id_professor']) ?>
                                        </select>

                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <input class="btn btn-primary btn-block" type="submit"
                                                    value="แก้ไข">
                                                <!-- <button class="btn btn-primary btn-block" onclick="myFunction()">ลงทะเบียน</button> -->
                                            </div>

                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="page_course.php">กลับไปหน้าเดิม</a></div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </main>
        </div>

    </div>

    <br><br><br>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js"></script>

    <!-- แสดงแจ้งเตือน -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script type="text/javascript">
        function JSalert() {
            swal("แก้ไขรหัสผ่านไม่สำเร็จ", "รหัสผ่านไม่ตรงกัน", "error");
        }
    </script>

</body>

</html>