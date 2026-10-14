<?php 

    session_start();

    require('back_end/server.php');

    if( ! isset( $_SESSION['id'] ) ){

        Header("Location:index.php");

    }

    $sql = "SELECT * FROM user_student";
    $resule = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($resule);

    $row = mysqli_fetch_assoc($resule);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

</head>

<body>

    <div class="row">
        <div class="col-md-2 bg-dark">

            <a href="debug.php">หน้าหลัก</a>

        </div>

        <div class="col-md-10 ">

            <table id="datatablesSimple" class="table">

                <thead>
                    <tr>
                        <th scope="col">ลำดับ</th>
                        <th scope="col">เลขนักศึกษา</th>
                        <th scope="col">ชื่อ</th>
                        <th scope="col">email</th>
                        <th scope="col">เพิ่มเติม</th>
                    </tr>
                </thead>

                <tbody>
                    <?php for($i = 1 ; $i < $count ;$i++){ $row = mysqli_fetch_assoc($resule); ?>
                    <tr>
                        <th><?php echo $row['id'] ?></th>
                        <td><?php echo $row['ID_student'] ?></td>
                        <td><?php echo $row['f_name']." ".$row['l_name'] ?></td>
                        <td><?php echo $row['email'] ?></td>
                        <td>
                            <a class="btn btn-info" href="edit_data.php?id=<?php echo $row['id'] ?>">แก้ไข</a>
                            <a class="btn btn-danger" href="">ลบ</a>
                        </td>
                    </tr>

                    <?php } ?>
                    

                </tbody>
            </table>

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@5.0.3" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>

</body>

</html>