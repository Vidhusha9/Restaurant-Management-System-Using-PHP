<?php


    Class App {
        protected $db_host = DB_HOST;
        protected $db_name = DB_NAME;
        protected $db_user = DB_USER;
        protected $db_pass = DB_PASS;

        public $link;

        public function __construct() {
            // Constructor code here
            $this->connect();
        }

        // Other methods here
        public function connect() {
            $this->link = new PDO("mysql:host=".$this->db_host.";dbname=".$this->db_name. "", $this->db_user, $this->db_pass);

            if ($this->link) {
                die("Database connection success.");
        }
        }

        //select all rows
        public function selectAll($query) {
            $rows = $this->link->query($query);
            $rows->execute();

            $allRows = $rows->fetchAll(PDO::FETCH_OBJ);

            if ($allRows) {
                return $allRows;
            } else {
                return false;
            }
        }

        //select one row
        public function selectOne($query) {
            $row = $this->link->query($query);
            $row->execute();

            $singleRow = $row->fetch(PDO::FETCH_OBJ);
            if ($singleRow) {
                return $singleRow;
            } else {
                return false;
            }
        }

        //insert query
        public function insert($query, $arr, $path) {
            
            if ($this->validat($arr == "empty")) {
                echo "<script>alert('Fields must not be empty');</script>";
            } else {
                $insert_record = $this->link->prepare($query);
                $insert_record->execute($arr);

                header("Location: ".$path."");
            }
        }

        //update query
        public function update($query, $arr, $path) {
            
            if ($this->validat($arr == "empty")) {
                echo "<script>alert('Fields must not be empty');</script>";
            } else {
                $update_record = $this->link->prepare($query);
                $update_record->execute($arr);

                header("Location: ".$path."");
            }
        }

        //delete query
        public function delete($query, $path) {
            
            if ($this->validat($arr == "empty")) {
                echo "<script>alert('Fields must not be empty');</script>";
            } else {
                $delete_record = $this->link->prepare($query);
                $delete_record->execute();

                header("Location: ".$path."");
            }
        }

        public function validat($arr){
            if (in_array('', $arr)) {
                echo "empty";
        }
        }

        public function register($query, $arr, $path) {
            
            if ($this->validat($arr != "empty")) {
                echo "<script>alert('Fields must not be empty');</script>";
            } else {
                $register_user = $this->link->prepare($query);
                $register_user->execute($arr);

                header("Location: ".$path."");
            }
        }

        public function login($query, $data, $path) {
            
            //email
            $login_user = $this->link->query($query);
            $login_user->execute();

            $fetch = $login_user->fetch(PDO::FETCH_OBJ);

            if($login_user->rowCount() > 0){
                if (password_verify($data['password'], $fetch['password'])) {
                    header("Location: ".$path."");
                } else {
                    echo "<script>alert('Password not matched');</script>";
                }
            } else {
                echo "<script>alert('Email not registered');</script>";
            }
        }

        //starting session
        public function start_session(){
            session_start();
        } 

        //validating session
        public function validate_session() {
            if (!isset($_SESSION['user'])) {
                header("Location: " . APPURL . "");
            }
        }

    }

