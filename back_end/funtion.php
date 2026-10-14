<?php

    function error_show($error){ //แสดง error
            
        $count = count($error);

        for($i = 0 ; $i < $count ; $i++){
            echo "<div class='alert alert-danger mt-2' role='alert'>
                $error[$i]
            </div>";
        }

    }

    function show_grad($id){ //

        require('back_end/server.php');

        $sql = "SELECT * FROM user_student WHERE id = '$id' ";
        $resule_student = mysqli_query($conn,$sql);
        $row_me = mysqli_fetch_assoc($resule_student);

        $i = 1;
        $i2 = 1;
        $grad_all = 0;
        $grad_turm = 0;

        while($i <= 4){

            $name_grad = "grade_".$i."_".$i2;

            if($row_me[$name_grad] != NULL AND $row_me[$name_grad] != 0){
                $grad_all += $row_me[$name_grad];
                $grad_turm++;
            }

            if($i2 == 2){
                $i2 = 1;
                $i++;
            }
            else{
                $i2++;
            }

        }

        if($grad_turm != 0){
            $grad_all = $grad_all/$grad_turm;
        }
        else{
            $grad_all = 0;
        }

        return number_format($grad_all, 2, '.', ''); 

    }

    function UPDATE_grad($id_user){

        include('server.php');

        for($i = 1 ;$i <= 8 ; $i++){

            $sql = "SELECT * FROM mini_grad WHERE year = '$i' AND id_student = '$id_user'";
            $resule_student = mysqli_query($conn,$sql);
            $sum = 0;

            while($data = mysqli_fetch_assoc($resule_student)){

                $grad = 0;

                if($data['grad'] == 'A'){ $grad = 4; }
                if($data['grad'] == 'B+'){ $grad = 3.5; }
                if($data['grad'] == 'B'){ $grad = 3; }
                if($data['grad'] == 'C+'){ $grad = 2.5; }
                if($data['grad'] == 'C'){ $grad = 2; }
                if($data['grad'] == 'D+'){ $grad = 1.5; }
                if($data['grad'] == 'D'){ $grad = 1; }

                $sum += $grad;

            }

            if($sum != 0){
                $real_grad = $sum / mysqli_num_rows($resule_student);
            }
            else{
                $real_grad = 0;
            }
            
            if($i == 1){$graed_team = 'grade_1_1';}
            if($i == 2){$graed_team = 'grade_1_2';}
            if($i == 3){$graed_team = 'grade_2_1';}
            if($i == 4){$graed_team = 'grade_2_2';}
            if($i == 5){$graed_team = 'grade_3_1';}
            if($i == 6){$graed_team = 'grade_3_2';}
            if($i == 7){$graed_team = 'grade_4_1';}
            if($i == 8){$graed_team = 'grade_4_2';}

            $sql_qurey = "UPDATE user_student SET `$graed_team` = '$real_grad' WHERE id = '$id_user' ";
            mysqli_query($conn , $sql_qurey);

        }

    }

    function show_name_professor_form_id($id){ //แสดงชื่ออาจารย์จาก id

        error_reporting(0);
        ini_set('display_errors', 0);

        include('../back_end/server.php');
        include('back_end/server.php');

        if($id != NULL){
            $sql = "SELECT * FROM user_professor WHERE `id` = $id ";
            $resule_professor = mysqli_query($conn,$sql);
            $row_me = mysqli_fetch_assoc($resule_professor);
    
            $name = $row_me['f_name']." ".$row_me['l_name'];
    
            return $name; 
        }
        else{
            return "ไม่ได้ระบุ";
        }


    }

    function show_year($year){ //แสดงชื่ออาจารย์จาก id

        if($year >= 5){
            return "มากว่า 4 ปี";
        }
        else{
            return "ปี ".$year;
        }


    }

    function show_name_student_form_id($id){ //แสดงชื่อ นศ. จาก id

        error_reporting(0);
        ini_set('display_errors', 0);

        include('../back_end/server.php');
        include('back_end/server.php');

        $sql = "SELECT * FROM user_student WHERE `id` = $id ";
        $resule_professor = mysqli_query($conn,$sql);
        $row_me = mysqli_fetch_assoc($resule_professor);

        $name = $row_me['f_name']." ".$row_me['l_name'];

        return $name; 

    }

    function coures_d($id){

        error_reporting(0);
        ini_set('display_errors', 0);

        include('../back_end/server.php');
        include('back_end/server.php');

        $sql = "SELECT * FROM course WHERE id = $id";
        $resule_professor = mysqli_query($conn,$sql);

        $data = mysqli_fetch_assoc($resule_professor);

        return $data;

    }

    function show_grad_mini($grad){

        if($grad == 'A'){
            echo " <option selected value='A'>A</option> ";
        }
        else{
            echo " <option  value='A'>A</option> ";
        }
        if($grad == 'B+'){
            echo " <option selected value='B+'>B+</option> ";
        }
        else{
            echo " <option value='B+'>B+</option> ";
        }
        if($grad == 'B'){
            echo " <option selected value='B'>B</option> ";
        }
        else{
            echo " <option value='B'>B</option> ";
        }
        if($grad == 'C+'){
            echo " <option selected value='C+'>C+</option> ";
        }
        else{
            echo " <option value='C+'>C+</option> ";
        }
        if($grad == 'C'){
            echo " <option selected value='C'>C</option> ";
        }
        else{
            echo " <option value='C'>C</option> ";
        }
        if($grad == 'D+'){
            echo " <option selected value='D+'>D+</option> ";
        }
        else{
            echo " <option value='D+'>D+</option> ";
        }
        if($grad == 'D'){
            echo " <option selected value='D'>D</option> ";
        }
        else{
            echo " <option value='D'>D</option> ";
        }

    }



    function select_coures(){

        require('back_end/server.php');

        $sql = "SELECT * FROM course";
        $resule_professor = mysqli_query($conn,$sql);

        while($data = mysqli_fetch_assoc($resule_professor)){

            echo " <option value='{$data['id']}'>{$data['name']}</option> ";

        }

    }

    function select_coures_form($id){

        require('back_end/server.php');

        $sql = "SELECT * FROM course";
        $resule_professor = mysqli_query($conn,$sql);

        while($data = mysqli_fetch_assoc($resule_professor)){

            if($id == $data['id']){

                echo " <option selected value='{$data['id']}'>{$data['name']}</option> ";

            }else{

                echo " <option value='{$data['id']}'>{$data['name']}</option> ";

            }

        }

    }

    function select_name_professor(){

        require('back_end/server.php');

        $sql = "SELECT * FROM user_professor";
        $resule_professor = mysqli_query($conn,$sql);

        while($data = mysqli_fetch_assoc($resule_professor)){

            echo " <option value='{$data['id']}'>{$data['f_name']} {$data['l_name']}</option> ";

        }

    }

    function select_name_professor_edit($id){

        require('back_end/server.php');

        $sql = "SELECT * FROM user_professor";
        $resule_professor = mysqli_query($conn,$sql);

        while($data = mysqli_fetch_assoc($resule_professor)){

            if( $data['id'] == $id){
                echo " <option selected value='{$data['id']}'>{$data['f_name']} {$data['l_name']}</option> ";
            }else{
                echo " <option value='{$data['id']}'>{$data['f_name']} {$data['l_name']}</option> ";
            }
            

        }

    }

    function check_year($year_status){

        if($year_status == 1){
            echo "ปี 1 เทอม 1";
        }
        if($year_status == 2){
            echo "ปี 1 เทอม 2";
        }
        if($year_status == 3){
            echo "ปี 2 เทอม 1";
        }
        if($year_status == 4){
            echo "ปี 2 เทอม 2";
        }
        if($year_status == 5){
            echo "ปี 3 เทอม 1";
        }
        if($year_status == 6){
            echo "ปี 3 เทอม 2";
        }
        if($year_status == 7){
            echo "ปี 4 เทอม 1";
        }
        if($year_status == 8){
            echo "ปี 4 เทอม 2";
        }

    }

    function DateThai($strDate) //แปลงวันที่เวลาเป็นไทย
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
	}

?>