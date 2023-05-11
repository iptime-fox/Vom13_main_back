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
    public function _construct($db){
      $this->conn = $db;
    }

    // id 중복 확인 함수
    public function check_id(){}

    // 회원정보 입력 함수
    public function insert_user(){}

    // 로그인 함수
    public function login(){}

    // 로그아웃 함수
    public function logout(){}
  }

?>