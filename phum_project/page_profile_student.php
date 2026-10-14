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

    $id_friend = mysqli_real_escape_string($conn,$_GET['id']);

    /////ดึงข้อมูลคนที่เราเข้ามาดู
    $sql = "SELECT * FROM user_student WHERE id = '$id_friend' ";
    $resule_student = mysqli_query($conn,$sql);
    $row_me = mysqli_fetch_assoc($resule_student);

    $id_student = $row_me['id'];
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
</head>

<body class="sb-nav-fixed" <?php if( isset($_SESSION['succeed']) ){ echo "onload=JSalert()"; unset($_SESSION['succeed']); } ?>>
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
                                            
                                            <?php if( file_exists("img/$id_student.jpg") ){  ?>
                                            <img src="img/<?php echo $id_student ?>.jpg" height="150" class="rounded-circle"
                                                width="150">
                                            <?php }else{  ?>

                                            <img src="img/free_profile.png" alt="Admin" class="rounded-circle"
                                                width="150">

                                            <?php }  ?>

                                            <div class="mt-3">
                                                <h4><?php echo $row_me['f_name']." ".$row_me['l_name'] ?></h4>
                                                <p class="text-secondary mb-1"> รหัสประจำตัว
                                                    <?php echo $row_me['ID_student'] ?></p>
                                                <p class="text-muted font-size-sm">
                                                    <?php echo show_year( $row_me['year'] ) ?></p>
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
                                                class="fa fa-envelope"></i>ผลการเรียนที่มีปัญหา</button></h6>
                                        <span class="text-secondary">0</span>
                                    </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">เกรดเฉลี่ยรวม</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <p class="mb-0" id="grad"> <?php echo show_grad($row_me['id']) ?> </p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">เกรดเฉลี่ยอยู่ในเกณฑ์</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <p class="mb-0" id="criterion"> </p>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>

                                <!-- ดูข้อมูลเกรด -->
                                <div class="row gutters-sm" id="show_grad" >
                                    <div class="col-sm-6 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h6 class="d-flex align-items-center mb-3"><i
                                                        class="material-icons text-info mr-2"></i> เกรดเฉลี่ยรวม ปี 1-2
                                                </h6>
                                                <small><?php echo $row_me['grade_1_1'] ?> &nbsp ปี 1 เทอม 1</small>
                                                <div class="progress mb-3" style="height: 5px" >
                                                    <div  class="progress-bar bg-primary" role="progressbar"
                                                        style="width: 80%" aria-valuenow="80" aria-valuemin="0" 
                                                        aria-valuemax="100" id="show_grade_1_1"></div>
                                                </div>
                                                <small><?php echo $row_me['grade_1_2'] ?> &nbsp ปี 1 เทอม 2</small>
                                                <div class="progress mb-3" style="height: 5px">
                                                    <div class="progress-bar bg-primary" role="progressbar" id="show_grade_1_2"
                                                        style="width: 72%" aria-valuenow="72" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                                <small><?php echo $row_me['grade_2_1'] ?> &nbsp ปี 2 เทอม 1</small>
                                                <div class="progress mb-3" style="height: 5px">
                                                    <div class="progress-bar bg-primary" role="progressbar" id="show_grade_2_1"
                                                        style="width: 89%" aria-valuenow="89" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                                <small><?php echo $row_me['grade_2_2'] ?> &nbsp ปี 2 เทอม 2</small>
                                                <div class="progress mb-3" style="height: 5px">
                                                    <div class="progress-bar bg-primary" role="progressbar" id="show_grade_2_2"
                                                        style="width: 55%" aria-valuenow="55" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                                <!-- <button onclick="openForm()" class="btn btn-info">แก้ไขเกรด</button> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h6 class="d-flex align-items-center mb-3"><i
                                                        class="material-icons text-info mr-2"></i>เกรดเฉลี่ยรวม ปี 3-4
                                                </h6>
                                                <small><?php echo $row_me['grade_3_1'] ?> &nbsp ปี 3 เทอม 1</small>
                                                <div class="progress mb-3" style="height: 5px">
                                                    <div class="progress-bar bg-primary" role="progressbar" id="show_grade_3_1"
                                                        style="width: 80%" aria-valuenow="80" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                                <small><?php echo $row_me['grade_3_2'] ?> &nbsp ปี 3 เทอม 2</small>
                                                <div class="progress mb-3" style="height: 5px">
                                                    <div class="progress-bar bg-primary" role="progressbar" id="show_grade_3_2"
                                                        style="width: 72%" aria-valuenow="72" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                                <small><?php echo $row_me['grade_4_1'] ?> &nbsp ปี 4 เทอม 1</small>
                                                <div class="progress mb-3" style="height: 5px">
                                                    <div class="progress-bar bg-primary" role="progressbar" id="show_grade_4_1"
                                                        style="width: 89%" aria-valuenow="89" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                                <small><?php echo $row_me['grade_4_2'] ?> &nbsp ปี 4 เทอม 2</small>
                                                <div class="progress mb-3" style="height: 5px">
                                                    <div class="progress-bar bg-primary" role="progressbar" id="show_grade_4_2"
                                                        style="width: 55%" aria-valuenow="55" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- แก้ไขข้อมูลเกรด -->
                            <form action="back_end/edit_grad.php" method="POST">
                                <div class="row gutters-sm" id="myForm_edit">

                                    <div class="col-sm-6 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h6 class="d-flex align-items-center mb-3"><i
                                                        class="material-icons text-info mr-2"></i> เกรดเฉลี่ยรวม ปี
                                                    1-2</h6>
                                                <small>ปี 1 เทอม 1</small>
                                                <div class=" mb-3">
                                                    <input id="grade_1_1" class="form-control" name="grade_1_1" type="number" max="4" min="0" step="0.01"
                                                    value="<?php echo $row_me['grade_1_1'] ?>" >
                                                    
                                                </div>
                                                <small>ปี 1 เทอม 2</small>
                                                <div class=" mb-3">
                                                    <input id="grade_1_2" class="form-control" name="grade_1_2" type="number" max="4.00" min="0" step="0.01"
                                                    value="<?php echo $row_me['grade_1_2'] ?>" >
                                                </div>
                                                <small>ปี 2 เทอม 1</small>
                                                <div class=" mb-3">
                                                    <input id="grade_2_1" class="form-control" name="grade_2_1" type="number" max="4.00" min="0" step="0.01"
                                                    value="<?php echo $row_me['grade_2_1'] ?>" >
                                                </div>
                                                <small>ปี 2 เทอม 2</small>
                                                <div class=" mb-3">
                                                    <input id="grade_2_2" class="form-control" name="grade_2_2" type="number" max="4.00" min="0" step="0.01"
                                                    value="<?php echo $row_me['grade_2_2'] ?>" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h6 class="d-flex align-items-center mb-3"><i
                                                        class="material-icons text-info mr-2"></i>เกรดเฉลี่ยรวม ปี
                                                    3-4</h6>
                                                <small>ปี 3 เทอม 1</small>
                                                <div class=" mb-3">
                                                    <input id="grade_3_1" class="form-control" name="grade_3_1" type="number" max="4.00" min="0" step="0.01"
                                                    value="<?php echo $row_me['grade_3_1'] ?>" >
                                                </div>
                                                <small>ปี 3 เทอม 2</small>
                                                <div class=" mb-3">
                                                    <input id="grade_3_2" class="form-control" name="grade_3_2" type="number" max="4.00" min="0" step="0.01"
                                                    value="<?php echo $row_me['grade_3_2'] ?>" >
                                                </div>
                                                <small>ปี 4 เทอม 1</small>
                                                <div class=" mb-3">
                                                    <input id="grade_4_1" class="form-control" name="grade_4_1" type="number" max="4.00" min="0" step="0.01"
                                                    value="<?php echo $row_me['grade_4_1'] ?>" >
                                                </div>
                                                <small>ปี 4 เทอม 2</small>
                                                <div class=" mb-3">
                                                    <input id="grade_4_2" class="form-control" name="grade_4_2" type="number" max="4.00" min="0" step="0.01"
                                                    value="<?php echo $row_me['grade_4_2'] ?>" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <!-- <input class="btn btn-warning" type="submit" value="แก้ไขข้อมูลเกรด"> -->
                                        <!-- <button class="btn btn-danger" type="button" onclick="closeForm()">ยกเลิก</button> -->
                                    </div>

                                </div>
                            </form>
                            
                            </div>

                            <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        แผนภูมิพื้นที่เปรียบเทียบเกรด
                                    </div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        แผนภูมิแท่งเปรียบเทียบเกรด
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                </div>
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
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="assets/demo/chart-pie-demo.js"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/datatables-demo.js"></script>
    <!-- จบกราฟ -->

    <!-- แสดงแจ้งเตือน -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script type="text/javascript">
        var myForm_edit = document.getElementById("myForm_edit");
        var show_grad = document.getElementById("show_grad");

        myForm_edit.hidden = true;

        function openForm() {
            show_grad.hidden = true;
            myForm_edit.hidden = false;
        }

        function closeForm() {
            show_grad.hidden = false;
            myForm_edit.hidden = true;
        }
    </script>

    <script type="text/javascript">

        var grade_1_1 = document.getElementById("grade_1_1").value;
        var grade_1_2 = document.getElementById("grade_1_2").value;
        var grade_2_1 = document.getElementById("grade_2_1").value;
        var grade_2_2 = document.getElementById("grade_2_2").value;
        var grade_3_1 = document.getElementById("grade_3_1").value;
        var grade_3_2 = document.getElementById("grade_3_2").value;
        var grade_4_1 = document.getElementById("grade_4_1").value;
        var grade_4_2 = document.getElementById("grade_4_2").value;

        document.getElementById("show_grade_1_1").style.width = (grade_1_1/4)*100 + "%";
        document.getElementById("show_grade_1_2").style.width = (grade_1_2/4)*100 + "%";
        document.getElementById("show_grade_2_1").style.width = (grade_2_1/4)*100 + "%";
        document.getElementById("show_grade_2_2").style.width = (grade_2_2/4)*100 + "%";
        document.getElementById("show_grade_3_1").style.width = (grade_3_1/4)*100 + "%";
        document.getElementById("show_grade_3_2").style.width = (grade_3_2/4)*100 + "%";
        document.getElementById("show_grade_4_1").style.width = (grade_4_1/4)*100 + "%";
        document.getElementById("show_grade_4_2").style.width = (grade_4_2/4)*100 + "%";

        
    </script>

    <script type="text/javascript">
        let grad = document.getElementById("grad").innerHTML;
        let criterion = document.getElementById("criterion");

        if (grad < 2.00) {
            criterion.innerHTML = "เสี่ยง"
            criterion.style.color = "#ff0000"

        } else if (grad < 2.50) {
            criterion.innerHTML = "น้อย"
            criterion.style.color = "#8B0000"

        } else if (grad < 3) {
            criterion.innerHTML = "ปานกลาง"
            criterion.style.color = "#FF7F50"
        } else if (grad < 3.50) {
            criterion.innerHTML = "ดี"
            criterion.style.color = "#006400"
        } else {
            criterion.innerHTML = "ดีมาก"
            criterion.style.color = "#006400"
        }
    </script>

    <script type="text/javascript">
        function JSalert() {
            swal("สำเร็จ!", "เนื้อหาของคุณอัพเดทแล้ว!", "success");
        }

        console.log('ssssssssssssssssssssssssssssssssss');

        var data = document.getElementById("SOURCE").value;
        // console.log(data);
        data.hidden = false;

    </script>

</body>

</html>
