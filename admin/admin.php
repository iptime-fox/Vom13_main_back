<?php

  class Admin{
    private $conn;
    private $table = 'bx_user';

    public $lvl;
    public $token;

    public function __construct($db){
      $this->conn = $db;
    }

    public function get_users(){
      session_start();
      $idx = 0;
      $token = '';

      if(!isset($_SESSION['usertoken'])){
        $token = '';
      } else {
        $token = $_SESSION['usertoken'];
      }

      if($_SESSION['userlvl'] != 1){
        $lvl = 0;
      } else {
        $lvl = 1;
      }

      if($token == '' && $lvl == 0){
        return false;
      } else {
        $sql = "SELECT * FROM ". $this->table ." WHERE user_lvl=:lvl AND user_token=:token";
        $stmt = $this->conn->prepare($sql);


        $this->lvl = htmlspecialchars(strip_tags($lvl));
        $this->token = htmlspecialchars(strip_tags($token));


        // echo $this->token;
        // echo '------';
        // echo $this->lvl;
        // exit;


        $stmt->bindParam(":lvl", $this->lvl);
        $stmt->bindParam(":token", $this->token);
        $stmt->execute();


        // print_r($stmt->execute());
        $num = $stmt->rowCount();


        if($num == ''){
          return false;
        } else {
          $sql1 = "SELECT * FROM ". $this->table ." WHERE user_lvl != 1 ORDER BY user_idx DESC"; 
          $stmt1 = $this->conn->prepare($sql1);
          $stmt1->execute();

          return $stmt1;
        }
      }

    }
  }

?>