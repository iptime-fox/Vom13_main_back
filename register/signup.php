<?php

  header('Access_Control-Allow-Origin: *'); // 크로스 오리진 허용
  header('Content-Type: application/json');  // 데이터 형식 json
  header('Access-Control-Allow-Methods: POST'); // 허용 메서드
  header('Access-Control-Allow-Headers: Access_Control-Allow_headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-Width');

  include $_SERVER["DOCUMENT_ROOT"].'/connect/db_conn.php';
  include $_SERVER["DOCUMENT_ROOT"].'/baexang_back/register/register.php';

  $msg = [];

  $signup = new Register($db);

  $data = json_decode(file_get_contents('php://input')); // input을 통해 들어온 데이터 파일을 생성후 json으로 디코딩
  // print_r($data);
  // echo $data->user_id;
  // exit;

  // 실제 들어온 데이터를 class에 있는 프로퍼티에 대입해준다.
  $signup->id     = $data->user_id;
  $signup->name   = $data->user_name;
  $signup->email  = $data->user_email;
  $signup->pwd    = $data->user_pwd;

  if($signup->check_id()){
    $msg = ['msg'=> '이미 존재하는 아이디 입니다.'];
  } else{
    if($signup->insert_user()){
      $msg = ['msg' => '회원가입이 되었습니다', 'status' => true];
    }else{
      $msg = ['msg' => '회원가입에 실패했습니다.', 'status' => false];
    };
  }


  echo json_encode($msg);
  

?>