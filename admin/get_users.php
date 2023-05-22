<?php

  header('Access_Control-Allow-Origin: *'); // 크로스 오리진 허용
  header('Content-Type: application/json');  // 데이터 형식 json

  include $_SERVER["DOCUMENT_ROOT"].'/connect/db_conn.php';
  include $_SERVER["DOCUMENT_ROOT"].'/baexang_back/admin/admin.php';

  $msg = [];

  $get_users = new Admin($db);

  $stmt = $get_users->get_users();

  
  if(!$get_users->get_users()){
    $msg = ['msg' => '권한이 없는 사용자 입니다.'];
  } else {
    $user_arr = [];
    $user_num = $stmt->rowCount();

    if($user_num > 0){
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $user_info = [
          'user_idx'  => $row['user_idx'],
          'user_id'   => $row['user_id'],
          'user_name' => $row['user_name'],
          'user_lvl'  => $row['user_lvl']
        ];
        array_push($user_arr, $user_info);
      }
    
      $msg = $user_arr;
    } else {
      array_push($user_arr, null);
      $msg = $user_arr;
      
    }
  }
  
  echo json_encode($msg);

?>