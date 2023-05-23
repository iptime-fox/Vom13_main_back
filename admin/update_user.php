<?php

  header('Access_Control-Allow-Origin: *'); // 크로스 오리진 허용
  header('Content-Type: application/json');  // 데이터 형식 json
  header('Access-Control-Allow-Methods: PUT'); // 허용 메서드
  header('Access-Control-Allow-Headers: Access_Control-Allow_headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-Width');

  include $_SERVER["DOCUMENT_ROOT"].'/connect/db_conn.php';
  include $_SERVER["DOCUMENT_ROOT"].'/baexang_back/admin/admin.php';

  $msg = [];

  $update_user = new Admin($db);
  $data = json_decode(file_get_contents('php://input')); 

  $update_path = explode('/', $_SERVER['REQUEST_URI']);
  $update_idx = $update_path[4];

  $update_user->idx = $update_idx;
  $update_user->name = $data->user_name;
  $update_user->lvl = $data->user_lvl;

  if($update_user->update_user()){
    $msg = ['msg' => '업데이트가 완료되었습니다.'];
  } else {
    $msg = ['msg' => '업데이트에 실패했습니다.'];
  }

  echo json_encode($msg);
?>