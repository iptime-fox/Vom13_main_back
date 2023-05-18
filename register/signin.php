<?php

  header('Access_Control-Allow-Origin: *'); // 크로스 오리진 허용
  header('Content-Type: application/json');  // 데이터 형식 json
  header('Access-Control-Allow-Methods: POST'); // 허용 메서드
  header('Access-Control-Allow-Headers: Access_Control-Allow_headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-Width');

  include $_SERVER["DOCUMENT_ROOT"].'/connect/db_conn.php';
  include $_SERVER["DOCUMENT_ROOT"].'/baexang_back/register/register.php';

  $msg = [];

  $signin = new Register($db);

  $data = json_decode(file_get_contents('php://input')); 

  $signin->id = $data->user_id;
  $signin->pwd = $data->user_pwd;

  // exit;
  // 넘어온 데이터 : 아이디가 틀리면 0, 비밀번호가 틀리면 1, 다 맞으면 array
  if($signin->login() == 0){
    $msg = ['msg'=> '존재하지 않는 아이디 입니다.'];
  } else if ($signin->login() == 1){
    $msg = ['msg'=> '비밀번호가 틀립니다.'];
  } else{
    $login_ok = $signin->login();
    // print_r($login_ok);
    session_start(); // 세션을 생성하기 위해 반드시 선언되어야 하는 함수
    $_SESSION['useridx']    = $login_ok['user_idx'];
    $_SESSION['userid']     = $login_ok['user_id'];
    $_SESSION['userlvl']    = $login_ok['user_lvl'];
    $_SESSION['usertoken']  = $login_ok['user_token'];

    $msg = array("useridx" => $_SESSION['useridx'], "userid" => $_SESSION['userid'], "userlvl" => $_SESSION['userlvl'], "usertoken" => $_SESSION['usertoken']);
  }


  echo json_encode($msg);
  

?>