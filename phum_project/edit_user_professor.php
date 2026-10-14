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

    $sql = "SELECT * FROM user_professor WHERE id = '$id' ";
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

<body class="bg-info" >
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
            <img src="img/cs_bru_logo.png" alt="" width="25%" height="">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">

                            <?php if(isset( $_SESSION['error[]'] )){ ?>
                                <?php error_show( $_SESSION['error[]']); ?>
                            <?php }?>

                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">แก้ไขข้อมูลส่วนตัว</h3>
                                </div>
                                <div class="card-body">
                                    <form action="back_end/edit_user_professor.php" method="POST"
                                    enctype="multipart/form-data" >

                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">เลือกรูปภาพประจำตัว (ขนาดภาพ 150x150)</label>
                                            <input class="form-control" type="file" name="file">
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputFirstName" required name="f_name"
                                                        type="text" placeholder="Enter your first name" value="<?php echo $row_me['f_name'] ?>" />
                                                    <label for="inputFirstName">ชื่อ (ไม่ต้องใส่คํานําหน้า)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="inputLastName" required name="l_name"
                                                        type="text" placeholder="Enter your last name" value="<?php echo $row_me['l_name'] ?>" />
                                                    <label for="inputLastName">นามสกุล</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" required id="myEmail" type="email" name="email" maxlength="22" readonly
                                                placeholder="n" value="<?php echo $row_me['email'] ?>"/>
                                            <label for="inputEmail">ที่อยู่ Email bru</label>
                                        </div>
                                        
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <input class="btn btn-primary btn-block" type="submit"
                                                    value="แก้ไขข้อมูล">
                                                <!-- <button class="btn btn-primary btn-block" onclick="myFunction()">ลงทะเบียน</button> -->
                                            </div>
                                            
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="page_main_professor.php">กลับไปหน้าโปรไฟล์ของฉัน</a></div>
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

</body>

</html>