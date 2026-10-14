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