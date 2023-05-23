<?php

  header('Access_Control-Allow-Origin: *'); // 크로스 오리진 허용
  header('Content-Type: application/json');  // 데이터 형식 json
  header('Access-Control-Allow-Methods: DELETE'); // 허용 메서드
  header('Access-Control-Allow-Headers: Access_Control-Allow_headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-Width');

  include $_SERVER["DOCUMENT_ROOT"].'/connect/db_conn.php';
  include $_SERVER["DOCUMENT_ROOT"].'/baexang_back/admin/admin.php';

  $msg = [];

  $delete_user = new Admin($db);

  $delete_path = explode('/', $_SERVER['REQUEST_URI']);
  $delete_idx = $update_path[4];

  $delete_user->idx = $delete_idx;

  // return $stmt->execute() ? true : false;

  if($delete_user->delete_user()){
    $msg = ['삭제가 완료되었습니다.'];
  } else {
    $msg = ['삭제에 실패했습니다.'];
  }

  echo json_encode($msg);
?>