<?php

  class Product{
    private $conn;
    private $table = 'bx_user';

    public $pr_img;  
    public $pr_ttl;    
    public $pr_wt_en;
    public $pr_wt_kr;
    public $pr_pri;
    public $pr_desc;
    public $pr_type;

    public function __construct($db){
      $this->conn = $db;
    }

    public function insert_prodect(){
      return true;
    }




  }


?>