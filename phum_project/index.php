<?php session_start();
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
    <link rel="shortcut icon" href="img/LOGO-bru.png">
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-info" <?php if( isset($_SESSION['error']) ){ echo "onload=JSalert()"; unset($_SESSION['error']); } ?>>
    <img style="width: 40%;" src="img/cs_bru_logo.png" class="img-fluid" alt="">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">

                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">เข้าสู่ระบบ</h3>
                                </div>
                                <div class="card-body">
                                    <form action="back_end/login.php" method="POST">
                                        
                                        <div class="form-floating mb-3">
                                            <input class="form-control" required id="inputEmail" type="email"
                                                placeholder="name@example.com" name="email" />
                                            <label for="inputEmail">email</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" required id="inputPassword" type="password"
                                                placeholder="Password" name="password" />
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" id="inputRememberPassword" type="checkbox"
                                                value="" />
                                            <label class="form-check-label" for="inputRememberPassword">จำฉันไว้</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href=""></a>
                                            <input class="btn btn-primary" type="submit" value="Login">
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <a href="register.php">ลงทะเบียนนักศึกษา5555555</a>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </main>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script type="text/javascript">
        function JSalert() {
            swal("เข้าสู่ระบบไม่สำเร็จ...", "กรุณาตรวจสอบชื่อผู้ใช้และรหัสผ่านอีกครั้ง", "error");
        }
    </script>
    
</body>

<?php  session_destroy(); ?>

</html>