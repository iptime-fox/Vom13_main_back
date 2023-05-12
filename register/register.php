<?php

  class Register{ 
    // 클래스 이름은 대문자로 시작하는것이 관례다.
    // 클래스 내부의 변수를 프로퍼티라 하고, 함수를 메서드라 한다.
    private $conn;
    private $table = 'bx_user';
    // private은 클래스 생성자로 접근해야 한다.

    public $id;
    public $name;
    public $email;
    public $pwd;
    public $lvl;
    // public은 외부 접근을 허용한다.

    // 생성자 : class가 실행되면 가장 먼저 실행되는 함수
    public function __construct($db){
      $this->conn = $db;
    }

    // id 중복 확인 함수
    public function check_id(){
      $sql = " SELECT * FROM ".$this->table." WHERE user_id=:id";
      $stmt = $this->conn->prepare($sql);

      $this->id = htmlspecialchars($this->id);
      $stmt->bindParam(":id", $this->id);
      $stmt->execute();

      return $stmt->rowCount() ? true : false;
    }

    // 회원정보 입력 함수
    public function insert_user(){
      // referrenc : https://wickedmagica.tistory.com/16
      $sql = "INSERT INTO ".$this->table." SET user_id=:id, user_name=:name, user_email=:email, user_pwd=:pwd, user_lvl=:lvl";
      $stmt = $this->conn->prepare($sql);

      $this->id     = htmlspecialchars($this->id);
      $this->name   = htmlspecialchars($this->name);
      $this->email  = htmlspecialchars($this->email);
      // 비밀번호 암호화 : https://www.codingfactory.net/11707
      $this->pwd    = htmlspecialchars($this->pwd);
      $this->pwd    = password_hash ( $this->pwd , PASSWORD_DEFAULT);
      $this->lvl    = 9;

      $stmt->bindParam(":id",     $this->id);
      $stmt->bindParam(":name",   $this->name);
      $stmt->bindParam(":email",  $this->email);
      $stmt->bindParam(":pwd",    $this->pwd);
      $stmt->bindParam(":lvl",    $this->lvl);
      
      
      return $stmt->execute() ? true : false;
      // if($stmt->execute()){
      //   return true;
      // } else {
      //   return false;
      // }

    }

    // 로그인 함수
    public function login(){}

    // 로그아웃 함수
    public function logout(){}
  }

?>