<?php

  class Comment{
    private $conn;
    private $table = 'bx_cmt';

    public $cmt_u_idx;  
    public $cmt_pr_ID;    
    public $cmt_cont;
    public $cmt_star;
    public $cmt_reg;

    public function __construct($db){
      $this->conn = $db;
    }

    public function insert_comment(){
      $sql = "INSERT INTO ".$this->table." SET 	bx_cmt_u_idx=:cmt_u_idx, 	bx_cmt_pr_ID=:cmt_pr_ID, bx_cmt_cont=:cmt_cont, bx_cmt_star=:cmt_star, bx_cmt_reg=:cmt_reg";      

      $stmt = $this->conn->prepare($sql);

      $this->cmt_u_idx  = htmlspecialchars($this->cmt_u_idx); 
      $this->cmt_pr_ID  = htmlspecialchars($this->cmt_pr_ID);   
      $this->cmt_cont   = htmlspecialchars($this->cmt_cont);
      $this->cmt_star   = htmlspecialchars($this->cmt_star);
      $this->cmt_reg    = date("Y-m-d H:i:s");

      $stmt->bindParam(':cmt_u_idx',  $this->cmt_u_idx);
      $stmt->bindParam(':cmt_pr_ID',  $this->cmt_pr_ID );
      $stmt->bindParam(':cmt_cont',   $this->cmt_cont);
      $stmt->bindParam(':cmt_star',   $this->cmt_star);
      $stmt->bindParam(':cmt_reg',    $this->cmt_reg);

      return $stmt->execute() ? true : false;
    }
  }

?>