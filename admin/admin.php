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

      if($token == '' || $lvl == 0){
        return false;
      } else {
        $sql = "SELECT * FROM ". $this->table ." WHERE user_lvl=:lvl AND user_token=:token";
        $stmt = $this->conn->prepare($sql);
        
        $this->lvl    = $lvl;
        $this->token  = $token;

        $stmt->bindParam(":lvl",     $this->lvl);
        $stmt->bindParam(":token",   $this->token);

        echo $stmt->rowCount();


        // if(!$stmt->execute()){
        //   echo '권한 없음';
        // } else {
        //   echo '권한 있음';
        // }


      }



      // $sql = "SELECT * FROM ". $this->table ." WHERE user_lvl != 1 ORDER BY user_idx DESC";
      // $stmt = $this->conn->prepare($sql);
      // $stmt->execute();

      // return $stmt;


      
    }
  }

?>