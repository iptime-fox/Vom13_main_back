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

      $sql = "INSERT INTO ".$this->table." SET bx_img=:pr_img, bx_ttl=:pr_ttl, bx_wt_en=:pr_wt_en, bx_wt_kr=:pr_wt_kr, bx_pri=:pr_pri, bx_desc=:pr_desc, bx_reg =:pr_reg, bx_ID=:pr_ID";

      $stmt = $this->conn->prepare($sql);

      $this->pr_img   = htmlspecialchars(strip_tags($this->pr_img));
      $this->pr_ttl   = htmlspecialchars(strip_tags($this->pr_ttl));
      $this->pr_wt_en = htmlspecialchars(strip_tags($this->pr_wt_en));
      $this->pr_wt_kr = htmlspecialchars(strip_tags($this->pr_wt_kr));
      $this->pr_pri   = htmlspecialchars(strip_tags($this->pr_pri));
      $this->pr_desc  = nl2br($this->pr_desc);
      $this->pr_reg   = date("Y-m-d H:i:s"); // 년월일 시간분초
      $this->pr_ID    = mt_rand(1, 1000000); // 1 1백만 사이 랜덤 숫자

      $stmt->bindParam(':pr_img',   $this->pr_img);
      $stmt->bindParam(':pr_ttl',   $this->pr_ttl );
      $stmt->bindParam(':pr_wt_en', $this->pr_wt_en);
      $stmt->bindParam(':pr_wt_kr', $this->pr_wt_kr);
      $stmt->bindParam(':pr_pri',   $this->pr_pri);
      $stmt->bindParam(':pr_desc',  $this->pr_desc);
      $stmt->bindParam(':pr_reg',   $this->pr_reg);
      $stmt->bindParam(':pr_ID',    $this->pr_ID);

      $result = $stmt->execute();

      return $result ? true : false;
    }




  }


?>