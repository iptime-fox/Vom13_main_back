<?php

  class Admin{
    private $conn;
    private $table = 'bx_user';

    public $lvl;
    public $token;
    public $idx;
    public $name;


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

        $stmt->bindParam(":lvl", $this->lvl);
        $stmt->bindParam(":token", $this->token);
        $stmt->execute();

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

    public function update_user(){
      $sql = "UPDATE ". $this->table ." SET user_name=:name, user_lvl=:lvl WHERE user_idx=:idx";
      $stmt = $this->conn->prepare($sql);

      $this->idx    = htmlspecialchars($this->idx);
      $this->name   = htmlspecialchars($this->name);
      $this->lvl    = htmlspecialchars($this->lvl);

      $stmt->bindParam(":idx",   $this->idx);
      $stmt->bindParam(":name",  $this->name);
      $stmt->bindParam(":lvl",   $this->lvl);
      
      if($stmt->execute()){
        return true;
      } 
    }

    public function delete_user(){
      $sql = "DELETE FROM ". $this->table ." WHERE user_idx=:idx";
      $stmt = $this->conn->prepare($sql);

      

      $this->idx = htmlspecialchars($this->idx);
      $stmt->bindParam(":idx", $this->idx);
      $stmt->execute();

      if($stmt->execute()){
        return true;
      } else{
        return false;
      }
    }


  }

?>