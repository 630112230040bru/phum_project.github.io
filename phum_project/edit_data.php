<?php

    require('back_end/server.php');

    echo $id = $_GET['id'];

    $sql = "SELECT * FROM user_student WHERE id = '$id' ";
    $resule_student = mysqli_query($conn,$sql);
    $row_me = mysqli_fetch_assoc($resule_student);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
                        <form action="back_end/edit_user_profile.php?id=<?php echo $id ?>" method="POST"
                                    enctype="multipart/form-data">

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" required type="text" name="ID_student" 
                                            maxlength="12" value="<?php echo $row_me['ID_student'] ?>"
                                                placeholder="name@example.com" />
                                            <label for="inputEmail">รหัสนักศึกษ 12 หลัก</label>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputFirstName" required name="f_name"
                                                        type="text" placeholder="Enter your first name" value="" />
                                                    <label for="inputFirstName">ชื่อ (ไม่ต้องใส่คํานําหน้า)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="inputLastName" required name="l_name"
                                                        type="text" placeholder="Enter your last name" value="" />
                                                    <label for="inputLastName">นามสกุล</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                            <div class="mb-3">
                                                <select class="form-select" id="gender" required aria-label="Default select example"
                                                    name="gender">
                                                    <option value="">เพศ</option>
                                                    <option value="1">ชาย</option>
                                                    <option value="2">หญิง</option>
                                                </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3 ">
                                                    <select class="form-select" id="year" required aria-label="Default select example" 
                                                        name="year">
                                                        <option value="" selected>ชั้นปีที่</option>
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
                                            <input class="form-control" required id="myEmail" type="email" name="email" maxlength="22" readonly
                                                placeholder="n" value=""/>
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
</body>
</html>