<?php 

session_start();

require('back_end/server.php');
require('back_end/funtion.php');

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

<body class="bg-info">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
            <img src="img/cs_bru_logo.png" alt="" width="25%" height="">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">

                        <!-- <?php if(isset( $_SESSION['error[]'] )){ ?>
                                <?php error_show( $_SESSION['error[]']); ?>
                            <?php }?> -->

                            <?php
                            
                                if( isset( $_SESSION['error[]'] ) ){

                                    $error = $_SESSION['error[]'];

                                    $count = count($error);

                                    for($i = 0 ; $i <= $count - 1 ;$i++){
                                        echo "<div class='alert alert-danger' role='alert'>
                                                $error[$i]
                                            </div>" ;
                                            
                                        echo "<br>";
                                    }

                                }

                            ?>

                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">ลงทะเบียนนักศึกษา</h3>
                                </div>
                                <div class="card-body">
                                    <form action="back_end/register.php" method="POST">

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" type="text" name="ID_student" 
                                            minlength="12"
                                                placeholder="name@example.com" />
                                            <label for="inputEmail">รหัสนักศึกษ 12 หลัก</label>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputFirstName" name="f_name"
                                                        type="text" placeholder="Enter your first name" />
                                                    <label for="inputFirstName">ชื่อ (ไม่ต้องใส่คํานําหน้า)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="inputLastName" name="l_name"
                                                        type="text" placeholder="Enter your last name" />
                                                    <label for="inputLastName">นามสกุล</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                            <div class="mb-3">
                                                <select class="form-select" aria-label="Default select example"
                                                    name="gender">
                                                    <option value="" selected>เพศ</option>
                                                    <option value="1">ชาย</option>
                                                    <option value="2">หญิง</option>
                                                </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3 ">
                                                    <select class="form-select" aria-label="Default select example"
                                                        name="year">
                                                        <option value="" selected >ชั้นปีที่</option>
                                                        <option value="1">ปี 1</option>
                                                        <option value="2">ปี 2</option>
                                                        <option value="3">ปี 3</option>
                                                        <option value="4">ปี 4</option>
                                                        <option value="5">มากกว่า 4 ปี</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="myEmail" type="email" name="email" maxlength="22"
                                                placeholder="n" value="@bru.ac.th"/>
                                            <label for="inputEmail">ที่อยู่ Email bru</label>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputPassword" type="password" minlength="8"
                                                        name="password_1" placeholder="Create a password" />
                                                    <label for="inputPassword">รหัสผ่าน (อย่างน้อย 8 ตัว)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputPasswordConfirm" minlength="8"
                                                        name="password_2" type="password"
                                                        placeholder="Confirm password" />
                                                    <label for="inputPasswordConfirm">ยืนยันรหัสผ่าน</label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <input class="btn btn-primary btn-block" type="submit"
                                                    value="ลงทะเบียน">
                                                <!-- <button class="btn btn-primary btn-block" onclick="myFunction()">ลงทะเบียน</button> -->
                                            </div>
                                            
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="index.php">มีบัญชีผู้ใช้อยู่แล้ว</a></div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </main>
        </div>

    </div>

    <br><br><br>

    <?php session_destroy();?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js">

    </script>

</body>

</html>