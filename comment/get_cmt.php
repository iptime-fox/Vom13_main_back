<?php

  header('Access_Control-Allow-Origin: *');
  header('Content-Type: application/json'); 

  include $_SERVER["DOCUMENT_ROOT"].'/connect/db_conn.php';
  include $_SERVER["DOCUMENT_ROOT"].'/baexang_back/comment/cmt.php';

  $msg = [];

  $get_comment = new Comment($db);

  if(!isset($_GET['cmt_pr_ID'])){
    $msg = ['msg' => '작품 번호는 필수 입력 쿼리입니다.'];
  } else {
    $get_comment->cmt_pr_ID = $_GET['cmt_pr_ID'];
    $result = $get_comment->get_comment();

    $cmt_num = $result['stmt']->rowCount();
    $cmt_arr = [];
    $star_avg = $result['stmt_avg'];

    session_start();
    if(isset($_SESSION['useridx'])){
      $useridx = $_SESSION['useridx'];
    } else {
      $useridx = "-1";
    }
    
    if($cmt_num == 0){
      $msg = ['msg' => '작품평이 없습니다.'];
    } else {
      while($row = $result['stmt']->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $cmt_info = [
          'bx_cmt_idx'   => $row['bx_cmt_idx'],
          'bx_cmt_u_idx' => $row['bx_cmt_u_idx'],
          'bx_cmt_pr_ID' => $row['bx_cmt_pr_ID'],
          'bx_cmt_cont'  => $row['bx_cmt_cont'],
          'bx_cmt_star'  => $row['bx_cmt_star'],
          'bx_cmt_reg'   => $row['bx_cmt_reg'],
          'user_id'      => $row['user_id'],
        ];
        array_push($cmt_arr, $cmt_info);
      }
      $msg = ['cmt_lists' => $cmt_arr, "star_avg" => $star_avg, "useridx" => $useridx];
    }
 
 
 
  }


  echo json_encode($msg);

?>