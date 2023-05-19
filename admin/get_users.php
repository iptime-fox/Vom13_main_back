<?php

  header('Access_Control-Allow-Origin: *'); // 크로스 오리진 허용
  header('Content-Type: application/json');  // 데이터 형식 json

  include $_SERVER["DOCUMENT_ROOT"].'/connect/db_conn.php';
  include $_SERVER["DOCUMENT_ROOT"].'/baexang_back/admin/admin.php';

  $msg = [];

  $get_users = new Admin($db);

  $stmt = $get_users->get_users();

  // $user_arr = [];
  // $user_num = $stmt->rowCount();

  // if($user_num > 0){
  //   while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  //     extract($row);
  //     $user_info = [
  //       'user_idx'  => $row['user_idx'],
  //       'user_id'   => $row['user_id'],
  //       'user_name' => $row['user_name'],
  //       'user_lvl'  => $row['user_lvl']
  //     ];
  //     array_push($user_arr, $user_info);
  //   }
  
  //   $msg = $user_arr;
  // } else {
  //   $msg = ['msg' => '회원이 존재하지 않습니다.'];
  // }

  
  // echo json_encode($msg);
  // echo $stmt->rowCount();

?>