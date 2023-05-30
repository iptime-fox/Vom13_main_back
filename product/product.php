<?php

  class Product{
    private $conn;
    private $table;

    public $pr_img;  
    public $pr_ttl;    
    public $pr_wt_en;
    public $pr_wt_kr;
    public $pr_pri;
    public $pr_desc;
    public $pr_type;
    public $pr_reg;
    public $pr_ID;
    public $pr_hit;

    public $cate;
    public $sort;
    public $limit;

    public function __construct($db){
      $this->conn = $db;
    }

    public function insert_product(){
      // 타입에 따른 테이블 분개
      if($this->pr_type == 'picture'){
        $this->table = 'bx_pp';
      } else {
        $this->table = 'bx_dp';
      }

      $sql = "INSERT INTO ".$this->table." SET bx_img=:pr_img, bx_ttl=:pr_ttl, bx_wt_en=:pr_wt_en, bx_wt_kr=:pr_wt_kr, bx_pri=:pr_pri, bx_desc=:pr_desc, bx_reg =:pr_reg, bx_ID=:pr_ID, bx_hit=:pr_hit";

      $stmt = $this->conn->prepare($sql);

      
      $this->pr_img   = "https://hanara123.cafe24.com/baexang_front/images/".$this->table.'/'.htmlspecialchars(strip_tags($this->pr_img));

      $this->pr_ttl   = htmlspecialchars(strip_tags($this->pr_ttl));
      $this->pr_wt_en = htmlspecialchars(strip_tags($this->pr_wt_en));
      $this->pr_wt_kr = htmlspecialchars(strip_tags($this->pr_wt_kr));
      $this->pr_pri   = htmlspecialchars(strip_tags($this->pr_pri));
      $this->pr_desc  = nl2br($this->pr_desc);
      $this->pr_reg   = date("Y-m-d H:i:s"); // 년월일 시간분초
      $this->pr_ID    = mt_rand(1, 1000000); // 1 1백만 사이 랜덤 숫자
      $this->pr_hit   = 0;

      $stmt->bindParam(':pr_img',   $this->pr_img);
      $stmt->bindParam(':pr_ttl',   $this->pr_ttl );
      $stmt->bindParam(':pr_wt_en', $this->pr_wt_en);
      $stmt->bindParam(':pr_wt_kr', $this->pr_wt_kr);
      $stmt->bindParam(':pr_pri',   $this->pr_pri);
      $stmt->bindParam(':pr_desc',  $this->pr_desc);
      $stmt->bindParam(':pr_reg',   $this->pr_reg);
      $stmt->bindParam(':pr_ID',    $this->pr_ID);
      $stmt->bindParam(':pr_hit',   $this->pr_hit);

      $result = $stmt->execute();

      return $result ? true : false;
    }

    public function get_products(){
      $sql = '';
      $table = '';
    
      if($this->cate == 'all'){
        $table = "(SELECT * FROM bx_pp UNION SELECT * FROM bx_dp) AS union_table";
      } else{
        $table = "bx_".$this->cate;
      }
    
      if($this->sort =='new'){
        $orderBy = " ORDER BY bx_idx DESC";
      } else if($this->sort = 'best'){
        $orderBy = " ORDER BY bx_hit DESC";
      } else{
        $orderBy = "";
      }
    
      if(!$this->limit == ""){
        $limit = $this->limit;
      } else {
        $limit = "";
        if($this->pr_ID != "" && $this->cate != 'all'){
          $sql1 = "UPDATE ".$table." SET bx_hit=bx_hit+1".$this->pr_ID;
          $stmt1 = $this->conn->prepare($sql1);
          $stmt1->execute();
        }
      }
      
      if($this->cate == 'all'){
        $sql = "SELECT * FROM ".$table.$this->pr_ID.$orderBy.$limit;
      } else {
        $sql = "SELECT * FROM ".$table.$this->pr_ID.$orderBy.$limit;
      }

      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
    
      return $stmt;
    


      // if($this->cate == 'all'){ // 테이블이 모두 선택될때
      //   if($this->sort == 'new'){
      //     $sql = "SELECT * FROM (SELECT * FROM bx_pp UNION SELECT * FROM bx_dp) AS union_table".$this->pr_ID." ORDER BY bx_idx DESC".$this->limit;
      //   } else if($this->sort == 'best'){
      //     $sql = "SELECT * FROM (SELECT * FROM bx_pp UNION SELECT * FROM bx_dp) AS union_table".$this->pr_ID." ORDER BY bx_hit DESC".$this->limit;
      //   } else {
      //     $sql = "SELECT * FROM (SELECT * FROM bx_pp UNION SELECT * FROM bx_dp) AS union_table".$this->pr_ID.$this->limit;
      //     // 서브쿼리 : union은 컬럼명과 갯수가 같아야 한다.
      //   }
      //   // echo $sql1;
      // } else { // 지정된 테이블만 조회될때
      //   if($this->sort == 'new'){  
      //     $sql = "SELECT * FROM bx_".$this->cate.$this->pr_ID." ORDER BY bx_idx DESC".$this->limit;
      //   } else if($this->sort == 'best'){
      //     $sql = "SELECT * FROM bx_".$this->cate.$this->pr_ID." ORDER BY bx_hit DESC".$this->limit;
      //   } else {
      //     $sql = "SELECT * FROM bx_".$this->cate.$this->pr_ID.$this->limit;
      //   }

      //   if($this->limit == '' && !$this->pr_ID == ''){ // limit가 없거나, 아이디가 있을경우 조회수 증가 -> 특정 상품을 지정하여 검색될때만 조회수 증가
      //     $sql1 = "UPDATE bx_".$this->cate. " SET bx_hit=bx_hit+1".$this->pr_ID;
      //     $stmt1 = $this->conn->prepare($sql1);
      //     $stmt1->execute();
      //    }
      // }

      // $stmt = $this->conn->prepare($sql);
      // $stmt->execute();

      // return $stmt;
    }
  }

  // 상품 조회 : 테이블 종류(all, dd, dp), 상품 조회 개수(limit), 상품 고유 아이디(pr_ID), 상품 나열 순서(new, best)


?>