<?php if($level == 1){ ?>
<li><a class="dropdown-item" href="edit_user_profile.php">แก้ไขข้อมูลผู้ใช้</a></li>
<?php } ?>

<?php if($level == 2){ ?>
<li><a class="dropdown-item" href="edit_user_professor.php">แก้ไขข้อมูลผู้ใช้</a></li>
<?php } ?>

<?php if($level != 3){ ?>
    <li><a class="dropdown-item" href="edit_password.php">แก้ไขรหัสผ่าน</a></li>
<li>
    <hr class="dropdown-divider" />
</li>
<?php } ?>


<li><a class="dropdown-item" href="index.php">ออกจากระบบ</a></li>
