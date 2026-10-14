<?php

  
session_start();
require('back_end/server.php');
require('back_end/funtion.php');

header("Content-type:application/json; charset=UTF-8");          
header("Cache-Control: no-store, no-cache, must-revalidate");         
header("Cache-Control: post-check=0, pre-check=0", false);   

  $id = $_SESSION['id'];
  $level = $_SESSION['level'];

  if($level == 1){

      /////ดึงข้อมูลเรา นศ.
      $sql = "SELECT * FROM appointment WHERE id_student = '$id' ";
      $resule_appointment = mysqli_query($conn,$sql);
      $count_appointment = mysqli_num_rows($resule_appointment);

  }
  if($level == 2){
      $sql = "SELECT * FROM appointment WHERE id_professor = '$id' ";
      $resule_appointment = mysqli_query($conn,$sql);
      $count_appointment = mysqli_num_rows($resule_appointment);
  }


?>
 [
  <?php for($i = 0 ; $i < $count_appointment ; $i++){ $row = mysqli_fetch_assoc($resule_appointment);  ?>
    {
    "title": "<?php echo $row['name'] ?>",
    "start": "<?php echo $row['date_time'] ?>",

    <?php if($row['level'] == 2 ){ ?>
    "color":"#006600"
    <?php }else{ ?>
      "color":"#FFCC00"
    <?php } ?>
    }

  <?php if($i != $count_appointment - 1){ echo ",";} ?>

  <?php } ?>
]