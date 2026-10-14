<?php 

    session_start();

    require('back_end/server.php');
    require('back_end/funtion.php');

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

    $id_professor = mysqli_real_escape_string($conn,$_GET['id']);

    /////ดึงข้อมูลเรา
    $sql = "SELECT * FROM user_professor WHERE id = '$id_professor' ";
    $resule_student = mysqli_query($conn,$sql);
    $row_me = mysqli_fetch_assoc($resule_student);

    /////ดึงข้อมูล I
    $sql = "SELECT * FROM user_student INNER JOIN grad 
    ON grad.id_student = user_student.id WHERE id_professor = '$id_professor' AND grad = 'I'";
    $resule_I = mysqli_query($conn,$sql);
    $count_I = mysqli_num_rows($resule_I);

    /////ดึงข้อมูล F
    $sql = "SELECT * FROM user_student INNER JOIN grad 
    ON grad.id_student = user_student.id WHERE id_professor = '$id_professor' AND grad = 'F'";
    $resule_F = mysqli_query($conn,$sql);
    $count_F = mysqli_num_rows($resule_F);
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
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

    <style>
    a {
        text-decoration: none;
    }
    </style>

</head>

<body class="sb-nav-fixed"
    <?php if( isset($_SESSION['succeed']) ){ echo "onload=JSalert()"; unset($_SESSION['succeed']); } ?>>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="#">CS BRU</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <!-- <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button> -->
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"> <?php if($level != 3){ echo $name ; } ?> <i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <?php require('link_drop_box.php'); ?>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">

        <!-- เริ่ม ปุ่มด้านซ้าย -->

        <div id="layoutSidenav_nav">

            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">

                        <?php require('link.php'); ?>

                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <img src="img/cs_bru_logo.png" width="100%" alt="">
                </div>
            </nav>
        </div>

        <!-- จบ ปุ่มด้านซ้าย -->

        <div id="layoutSidenav_content">
            <main>
                <div class="container">
                    <div class="main-body">
                        <!-- /Breadcrumb -->
                        <div class="row gutters-sm mt-3">
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column align-items-center text-center">
                                        <?php if( file_exists("img_professor/$id_professor.jpg") ){  ?>
                                            <img src="img_professor/<?php echo $id_professor ?>.jpg" height="150" class="rounded-circle"
                                            width="150">
                                        <?php }else{  ?>

                                            <img src="img/free_profile.png" alt="Admin" class="rounded-circle" width="150">

                                        <?php }  ?>
                                            <div class="mt-3">
                                                <h4>อาจารย์ <?php echo $row_me['f_name']." ".$row_me['l_name'] ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-3">
                                    <ul class="list-group list-group-flush">
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0"><i style="font-size:20px;color:red;"
                                                    class="fa fa-envelope"></i> ที่อยู่ email</button></h6>
                                            <span class="text-secondary"><?php echo $row_me['email']?></span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card mt-3">
                                    <ul class="list-group list-group-flush">
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0"><i style="font-size:20px;color:red;"
                                                    class="fa fa-exclamation-triangle"></i>ผลการเรียนที่มีปัญหา I</button></h6>
                                            <span class="text-secondary"><?php echo $count_I ?></span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card mt-3">
                                    <ul class="list-group list-group-flush">
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0"><i style="font-size:20px;color:red;"
                                                    class="fa fa-exclamation-triangle"></i>ผลการเรียนที่มีปัญหา F</button></h6>
                                            <span class="text-secondary"><?php echo $count_F ?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-table me-1"></i>
                                        นักศึกษาที่ติด I
                                    </div>

                                    <div class="card-body">
                                        <table id="datatablesSimple">
                                            <thead>
                                                <tr>
                                                    <th> <i class="fa fa-filter"></i> ลำดับ</th>
                                                    <th> <i class="fa fa-filter"></i> ชื่อ</th>
                                                    <th> <i class="fa fa-filter"></i> ชื่อรายวิชา</th>
                                                    <th> <i class="fa fa-filter"></i> ชั้นปี</th>
                                                    <th> <i class="fa fa-filter"></i> email</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                
                                            <?php for($i = 0 ; $i < $count_I ; $i++){ $row_I = mysqli_fetch_assoc($resule_I); ?>

                                                <tr>

                                                <td><?php echo $i+1 ?></td>
                                                <td><?php echo show_name_student_form_id($row_I['id_student']) ?></td>
                                                <td><?php echo $row_I['name'] ?></td>
                                                <td>ปี <?php echo $row_I['year'] ?></td>
                                                <td><?php echo $row_I['email'] ?></td>

                                                </tr>
                                            <?php } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            นักศึกษาที่ติด F
                        </div>

                        <div class="card-body">
                            <table id="datatablesSimpl2">
                                <thead>
                                    <tr>
                                        <th> <i class="fa fa-filter"></i> ลำดับ</th>
                                        <th> <i class="fa fa-filter"></i> ชื่อ</th>
                                        <th> <i class="fa fa-filter"></i> ชื่อรายวิชา</th>
                                        <th> <i class="fa fa-filter"></i> ชั้นปี</th>
                                        <th> <i class="fa fa-filter"></i> email</th>
                                    </tr>
                                </thead>         
                                    <?php for($i = 0 ; $i < $count_F ; $i++){ $row_F = mysqli_fetch_assoc($resule_F); ?>

                                        <tr>
                                            <td><?php echo $i+1 ?></td>
                                            <td><?php echo show_name_student_form_id($row_F['id_student']) ?></td>
                                            <td><?php echo $row_F['name'] ?></td>
                                            <td>ปี <?php echo $row_F['year'] ?></td>
                                            <td><?php echo $row_F['email'] ?></td>
                                        </tr>
                                    <?php } ?>

                                <tbody>
                                    

                                </tbody>
                            </table>
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
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@5.0.3" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>


    <!-- กราฟ -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <!-- จบกราฟ -->

    <!-- แสดงแจ้งเตือน -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script type="text/javascript">
        function JSalert() {
            swal("สำเร็จ!", "เนื้อหาของคุณอัพเดทแล้ว!", "success");
        }
    </script>

</body>

</html>