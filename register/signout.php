<?php

  header('Access_Control-Allow-Origin: *'); // 크로스 오리진 허용
  header('Content-Type: application/json');  // 데이터 형식 json
  header('Access-Control-Allow-Methods: POST'); // 허용 메서드
  header('Access-Control-Allow-Headers: Access_Control-Allow_headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-Width');

  include $_SERVER["DOCUMENT_ROOT"].'/baexang_back/register/register.php';

  $signout = new Register($db); // $db는 클래스의 constructor이므로 쓰지 않더라도 작성

  // echo $signout->logout(); // 세션 있으면 1, 없으면 빈값
  // exit;

  if($signout->logout()){
    session_destroy();
    echo json_encode(array('userid' => "guest"));
  };

?>