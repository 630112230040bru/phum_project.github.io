<?php 

    session_start();

    require('back_end/server.php');
    require('back_end/funtion.php');

    $id_appointment = $_GET['id_appointment'];

    /////ดึงข้อ การนัดหมาย
    $sql = "SELECT * FROM appointment WHERE id = '$id_appointment'";
    $resule_appointment = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($resule_appointment);

    $id = $_SESSION['id'];
    $level = $_SESSION['level'];

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

                        <div class="col-lg-7" id="form_2">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">การนัดหมาย</h3>
                                </div>
                                <div class="card-body">
                                    <form action="back_end/edit_appointment.php?id_appointment=<?php echo $id_appointment ?>" method="POST">

                                        <div class="form-floating mb-3">
                                            <input class="form-control" readonly required type="text"
                                                value="<?php echo show_name_student_form_id($row['id_student']) ?>" placeholder="n" />
                                            <label for="inputEmail">นักศึกษา</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="input_professor" readonly required value="<?php echo show_name_professor_form_id($row['id_professor']) ?>"
                                                type="text" placeholder="n" />
                                            <label for="inputEmail">อาจารย์</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="" required type="text" name="name" value="<?php echo $row['name'] ?>"
                                                placeholder="n" />
                                            <label for="inputEmail">ชื่อการนัดหมาย</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" required id="myEmail" type="datetime-local" value="<?php echo $row['date_time'] ?>"
                                                name="date_time" maxlength="22" placeholder="n" value="@bru.ac.th" />
                                            <label for="inputEmail">วันที่ และ เวลา</label>
                                        </div>

                                        <div class="form-floating">
                                            <textarea <?php if($level != 1){ echo "readonly" ;} ?>
                                                 class="form-control" name="details_student" 
                                                placeholder="Leave a comment here" id="floatingTextarea2"
                                                style="height: 100px"><?php echo $row['details_student'] ?></textarea>
                                            <label for="floatingTextarea2">ความคิดเห็นนักศึกษา</label>
                                        </div>

                                        <div class="form-floating mt-4">
                                            <textarea class="form-control" <?php if($level != 2){ echo "readonly" ;} ?> name="details_professor" 
                                                placeholder="Leave a comment here" id="floatingTextarea2"
                                                style="height: 100px"><?php echo $row['details_professor'] ?></textarea>
                                            <label for="floatingTextarea2">ความคิดเห็นอาจารย์</label>
                                        </div>

                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <input class="btn btn-primary btn-block" type="submit"
                                                    value="แก้ไขการนัดหมาย">
                                                <!-- <button class="btn btn-primary btn-block" onclick="myFunction()">ลงทะเบียน</button> -->
                                            </div>

                                        </div>
                                    </form>
                                </div>

                                <?php 
                                        if($level == 1){
                                            echo "<div class='card-footer text-center py-3'>
                                            <div class='small'><a href='page_appointment_student.php'>กลับหน้านัดหมาย</a></div>
                                            </div>";
                                        }
                                        if($level == 2){
                                            echo "<div class='card-footer text-center py-3'>
                                            <div class='small'><a href='page_appointment_professor.php'>กลับหน้านัดหมาย</a></div>
                                            </div>";
                                        }
                                ?>

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
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@5.0.3" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>

</body>

</html>