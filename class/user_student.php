<?php

    require_once('config.php');

    class user_student extends Config {
        
        function __CALL( $name , $select ){

            if($name == "show_data"){
    
                $count = count($select);
    
                if($count == 1 AND $select[0] == "*"){

                    $sql = "SELECT * FROM user_student ORDER BY id DESC";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute();
                    // $result = $stmt->fetchAll();
                    return $stmt;

                }
                else
                {

                    $data_query = "";

                    for($i = 0 ; $i < $select ; $i++){

                        $data_query += $select[$i] . ",";

                    }

                    $data_query = substr($data_query, 0, -1);

                    $sql = "SELECT $data_query FROM user_student ORDER BY id DESC";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute();
                    // $result = $stmt->fetchAll();
                    return $stmt;

                }

            }
    
        }

    }

?>