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

    public function get_comment(){
      // bx_cmt.* : bx_cmt에 있는 데이터 전체
      // SELECT bx_cmt.*, bx_user.user_id : bx_cmt 데이터 전체와 bx_user의 user_id 검색
      // FROM bx_cmt : left 테이블 bx_cmt
      // JOIN bx_user : join 테이블 bx_user
      // ON bx_cmt.bx_cmt_u_idx = bx_user.user_idx : join 기준은 bx_cmt_u_idx와 user_idx
      // WHERE bx_cmt_pr_ID = 477096 : 검색 필터링
      // ORDER BY bx_cmt.bx_cmt_reg DESC : 나열 조건 역순

      // bx_cmt 테이블 전체 데이터와 bx_user 테이블의 아이디를 조회한다.(두 개 테이블 데이터를 동시 조회하기 위해서는 테이블간 join이 필요하다.)
      // join 참조 : https://pearlluck.tistory.com/46
      // 조회된 데이터는 파라미터의 상품 데이터에 한정한다.
      // 조회 결과는 시간의 역순, 즉 최신순으로 나열한다.
      $sql = "SELECT bx_cmt.*, bx_user.user_id FROM ".$this->table." JOIN bx_user on bx_cmt.bx_cmt_u_idx = bx_user.user_idx WHERE bx_cmt_pr_ID = ".$this->cmt_pr_ID." ORDER BY bx_cmt.bx_cmt_reg DESC";
      $stmt = $this->conn->prepare($sql);

      $sql_avg = "SELECT AVG(bx_cmt_star) as AVG FROM ".$this->table. " WHERE bx_cmt_pr_ID = ".$this->cmt_pr_ID;
      $stmt_avg = $this->conn->prepare($sql_avg);
      
      $stmt_avg->execute();
      $stmt->execute();

      // Fetch the average value from the executed statement
      $averageResult = $stmt_avg->fetch(PDO::FETCH_ASSOC);
      $averageValue = $averageResult['AVG'];

      // Create an array or an object to hold the values
      $result = [
        'stmt' => $stmt,
        'stmt_avg' => $averageValue
      ];

      return $result;



    }

    public function update_comment(){
      
    }
  }

?>