
<?php if($level != 3){ ?>

    <?php if($level == 1){ ?>

        <div class="sb-sidenav-menu-heading">โปรไฟล์</div>
        <a class="nav-link" href="page_main.php">
            <div class="sb-nav-link-icon"><i class="fas fa-user fa-fw"></i></div>
            โปรไฟล์ของฉัน
        </a>
        <a class="nav-link" href="page_problem_with_grades.php">
            <div class="sb-nav-link-icon"><i class="fas fa-user fa-fw"></i></div>
            ผลการเรียนมีปัญหา
        </a>

    <?php } ?>

    <?php if($level == 2){ ?>

        <div class="sb-sidenav-menu-heading">โปรไฟล์</div>
        <a class="nav-link" href="page_main_professor.php">
            <div class="sb-nav-link-icon"><i class="fas fa-user fa-fw"></i></div>
            โปรไฟล์ของฉัน
        </a>
        <!-- <a class="nav-link" href="page_problem_with_grades.php">
            <div class="sb-nav-link-icon"><i class="fas fa-user fa-fw"></i></div>
            ผลการเรียนมีปัญหา
        </a> -->

        <div class="sb-sidenav-menu-heading">ผู้ใช้</div>
        <a class="nav-link" href="page_data_student.php">
            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></i></div>
            ข้อมูลนักศึกษา
        </a>

        <a class="nav-link" href="page_data_professor.php">
            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
            ข้อมูลอาจารย์
        </a>

    <?php } ?>


    <?php if($level == 1){ ?>

    <div class="sb-sidenav-menu-heading">นัดหมาย</div>
        <a class="nav-link" href="page_appointment_student.php">
            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
            นัดหมาย
        </a>
    <?php } ?>

    <?php if($level == 2){ ?>

        <div class="sb-sidenav-menu-heading">นัดหมาย</div>

        <a class="nav-link" href="page_appointment_professor.php">
            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
            นัดหมาย
        </a>
    <?php } ?>

<?php } else{ ?>


    <div class="sb-sidenav-menu-heading">ผู้ใช้</div>
    <a class="nav-link" href="page_data_student.php">
        <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></i></div>
        ข้อมูลนักศึกษา
    </a>

    <a class="nav-link" href="page_data_professor.php">
        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
        ข้อมูลอาจารย์
    </a>

    <a class="nav-link" href="page_course.php">
        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
        เพิ่มรายวิชา
    </a>

<?php } ?>