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
    public $token;
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
      $sql = "INSERT INTO ".$this->table." SET user_id=:id, user_name=:name, user_email=:email, user_pwd=:pwd, user_lvl=:lvl, user_token=:token";
      $stmt = $this->conn->prepare($sql);

      $this->id     = htmlspecialchars($this->id);
      $this->name   = htmlspecialchars($this->name);
      $this->email  = htmlspecialchars($this->email);
      // 비밀번호 암호화 : https://www.codingfactory.net/11707
      $this->pwd    = htmlspecialchars($this->pwd);
      $this->pwd    = password_hash ( $this->pwd , PASSWORD_DEFAULT);
      $this->lvl    = 9;
      $this->token  = sha1(time());

      $stmt->bindParam(":id",     $this->id);
      $stmt->bindParam(":name",   $this->name);
      $stmt->bindParam(":email",  $this->email);
      $stmt->bindParam(":pwd",    $this->pwd);
      $stmt->bindParam(":lvl",    $this->lvl);
      $stmt->bindParam(":token",  $this->token);
      
      
      return $stmt->execute() ? true : false;
      // if($stmt->execute()){
      //   return true;
      // } else {
      //   return false;
      // }

    }

    // 로그인 함수
    public function login(){
      /* ========= 로그인 데이터 조회 시작 ========= */
      $sql = "SELECT * FROM ".$this->table." WHERE user_id=:id";
      $stmt = $this->conn->prepare($sql);

      $stmt->bindParam(":id", $this->id);
    
      $stmt->execute();
      $result = $stmt->rowCount(); // 조회된 결과 숫자로 리턴
      /* ========= 로그인 데이터 조회 끝 ========= */
     
      /* ========= 토큰 데이터 업데이트 시작 ========= */
      $this->token = sha1(time());

      $sql1 = "UPDATE ". $this->table ." SET user_token=:token WHERE user_id=:id";
      $stmt1 = $this->conn->prepare($sql1);

      $stmt1->bindParam(":id",    $this->id);
      $stmt1->bindParam(":token", $this->token);
    
      $stmt1->execute();
      /* ========= 토큰 데이터 업데이트 끝 ========= */


      if(!$result){ // result에 값이 없다면
        return 0;
      } else{
        $row = $stmt->fetch();
        $pwd = $row['user_pwd'];
        $pwd_verify = password_verify($this->pwd, $pwd);
        if(!$pwd_verify){
          return 1;
        } else{
          return $row;
        }
      }
    }

    // 로그아웃 함수
    public function logout(){
      session_start();
      if(isset($_SESSION['userid'])){ // isset : 값의 존재 여부(boolean)
        return true;
      } else {
        return false;
      }
    }


  }

?>