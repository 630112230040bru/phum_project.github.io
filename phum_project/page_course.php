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

    $sql = "SELECT * FROM course" ;
    $query = mysqli_query($conn , $sql);

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
                    aria-expanded="false"> <?php if($level != 3){ echo $name ; } ?> <i
                        class="fas fa-user fa-fw"></i></a>
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
                    <h1 class="mt-4">ข้อมูลรายวิชา</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">ข้อมูลรายวิชา</li>
                        <li class="breadcrumb-item active">ข้อมูลรายวิชา</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            ข้อมูลรายวิชา
                        </div>

                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th> <i class="fa fa-filter"></i> ลำดับ</th>
                                        <th> <i class="fa fa-filter"></i> ชื่อรายวิชา</th>
                                        <th> <i class="fa fa-filter"></i> อาจารย์ที่สอน</th>
                                        <!-- <th> <i class="fa fa-filter"></i> เกรดเฉลี่ยรวม</th>
                                        <th> <i class="fa fa-filter"></i> อยู่ในเกณฑ์</th> -->
                                        <th> เพิ่มเติม </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i=1; while($data = mysqli_fetch_assoc($query)){  ?>

                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $data['name'] ?></td>
                                            <td><?php echo show_name_professor_form_id($data['id_professor'])  ?></td>
                                            <td>
                                                <a class="btn btn-info" href="edit_course.php?id=<?= $data['id'] ?>">แก้ไข</a>
                                                <a class="btn btn-danger" href="back_end/del_course.php?id=<?= $data['id'] ?>">ลบ</a> 
                                            </td>
                                        </tr>

                                    <?php } ?>

                                </tbody>
                            </table>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                เพิ่มข้อมูลรายวิชา
                            </button>

                        </div>

                        <div class="modal fade" id="exampleModal" tabindex="0" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลรายวิชา</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <form action="back_end/add_course.php" method="POST">

                                        <div class="modal-body">
                                            <div class="mb-3">

                                                <label class="form-label">ชื่อรายวิชา</label>
                                                <input required type="text" name="name" class="form-control">
                                            </div>

                                            <select required class="form-select" name="id_professor" aria-label="Default select example">
                                                <option value="" selected>อาจารย์ผู้สอน</option>
                                                <?php select_name_professor() ?>
                                            </select>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">ปิด</button>
                                            <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
                                        </div>

                                    </form>
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
    <!-- <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="assets/demo/chart-pie-demo.js"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/datatables-demo.js"></script> -->
    <!-- จบกราฟ -->

    <script src="js/scripts_Q.js"></script>

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

<?php



?>