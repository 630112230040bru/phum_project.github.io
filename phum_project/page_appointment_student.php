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

    if($level != 1){
        Header("Location:index.php");
        session_destroy();
    }

    /////ดึงข้อมูลเรา
    $sql = "SELECT * FROM appointment WHERE id_student = '$id' ";
    $resule_appointment = mysqli_query($conn,$sql);
    $count_appointment = mysqli_num_rows($resule_appointment);

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
                    aria-expanded="false"> <?php echo $name ?> <i class="fas fa-user fa-fw"></i></a>
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
                <div class="container-fluid px-4">
                    <h1 class="mt-4">นัดหมาย</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">นัดหมาย</li>
                        <li class="breadcrumb-item active">นัดหมาย</li>
                    </ol>

                    <div >
                        <div id='calendar'></div>
                    </div>

                    <a class=" mb-4 mt-2 btn btn-success" href="add_appointment_student.php">ขอนัดหมายอาจารย์ที่ผลการเรียนมีปัญหา</a>
                    <br>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            ข้อมูลการนัดหมาย
                        </div>

                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th> <i class="fa fa-filter"></i> ลำดับ</th>
                                        <th> <i class="fa fa-filter"></i> ชื่อการนัดหมาย</th>
                                        <th> <i class="fa fa-filter"></i> ชื่อนักศึกษา</th>
                                        <th> <i class="fa fa-filter"></i> อาจารย์ผู้นัดหมาย</th>
                                        <th> <i class="fa fa-filter"></i> วันที่และเวลา</th>
                                        <th> เพิ่มเติม </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php for($i=0;$i < $count_appointment ; $i++){ $row_appointment = mysqli_fetch_assoc($resule_appointment); ?>

                                        <tr <?php if($row_appointment['level'] == 1){ echo "class='bg-warning'" ;} ?>  >
                                            <td><?php echo $i + 1 ?></td>
                                            <td><?php echo $row_appointment['name'] ?></td>
                                            <td><?php echo show_name_student_form_id($row_appointment['id_student']) ?></td>
                                            <td><?php echo show_name_professor_form_id($row_appointment['id_professor']) ?></td>
                                            <td><?php echo DateThai($row_appointment['date_time']) ?></td>
                                            <?php if($row_appointment['level'] == 1){ echo "<td> รอดำเนินการ </td>" ;}else{ ?>
                                            <td>
                                                <a class="btn btn-info" href="edit_appointment.php?id_appointment=<?php echo $row_appointment['id'] ?>">แก้ไข</a>
                                                <a class="btn btn-danger" href="back_end/delete_appointment.php?id_appointment=<?php echo $row_appointment['id'] ?>">ลบ</a>
                                            </td>
                                            <?php } ?>
                                        </tr>

                                    <?php } ?>

                                </tbody>
                            </table>
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

    <!-- ปติทิน -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="js/fullcalendar-2.1.1/lib/moment.min.js"></script>
    <script type="text/javascript" src="js/fullcalendar-2.1.1/fullcalendar.min.js"></script>
    <script type="text/javascript" src="js/fullcalendar-2.1.1/lang/th.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <link rel="stylesheet" href="js/fullcalendar-2.1.1/fullcalendar.min.css">

    <!-- กราฟ -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <!-- <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="assets/demo/chart-pie-demo.js"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/datatables-demo.js"></script> -->
    <!-- จบกราฟ -->

    <!-- <script type="text/javascript">
        
        var criterion = document.getElementById("criterion");                                

        if(criterion.innerHTML == "ดี"){
            console.log("11");
        }

    </script> -->

    <!-- แสดงแจ้งเตือน -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script type="text/javascript">
        function JSalert() {
            swal("สำเร็จ!", "เนื้อหาของคุณอัพเดทแล้ว!", "success");
        }
    </script>

</body>

</html>