
<?php
    Class DatabaseConnector {
        //Please change the servername, username, password to connecte your database. 
        private $servername = "127.0.0.1";
        private $username = "root";
        private $password = "Zyh812625";         
        private $dbname = "data_analysis";       
        
        
        private $conn;
        
        public function getConn(){
            return $this.conn;
        }
        
        public function connectDatabase($servername, $username, $password, $dbname) {
            //Create connection
            //$this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            $this->conn = new mysqli($servername, $username, $password, $dbname);
            //$this->conn = new mysqli("127.0.0.1", "root", "Zyh812625", "data_analysis");
            if ($this->conn->connect_error) {
                echo "ERROR! Please visit later..";
            } else {     // connect successfully
                return $this->conn;
            }           
        }
        
        public function closeDatabase() {
            mysqli_close($this->conn);
        }
    }
?>
