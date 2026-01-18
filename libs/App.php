<?php require "config/config.php"; ?>
<?php


    Class App {
        protected $db_host = DB_HOST;
        protected $db_name = DB_NAME;
        protected $db_user = DB_USER;
        protected $db_pass = DB_PASS;

        public $link;

        public function __construct() {
            // Constructor code here
        }

        // Other methods here
    }