<?php

  header('Access_Control-Allow-Origin: *'); // 크로스 오리진 허용
  header('Content-Type: application/json');  // 데이터 형식 json

  include $_SERVER["DOCUMENT_ROOT"].'/connect/db_conn.php';
  include $_SERVER["DOCUMENT_ROOT"].'/baexang_back/product/product.php';

  $msg = [];

  $get_products = new Product($db);


  if(!isset($_GET['cate'])){
    $msg = ['msg' => '작품 카테고리는 필수 입력 쿼리 입니다.'];
  } else {
    $get_products->cate = $_GET['cate'];
    $get_products->sort = $_GET['sort'];

    if(isset($_GET['limit'])){
      $get_products->limit = " LIMIT ".$_GET['limit'];
    } else {
      $get_products->limit = '';
    }

    if(isset($_GET['pr_ID'])){
      $get_products->pr_ID = " WHERE bx_ID=".$_GET['pr_ID'];
    } else {
      $get_products->pr_ID = '';
    }
    $stmt = $get_products->get_products();
    $item_num = $stmt->rowCount();
    $pr_arr = [];

    if($item_num == 0){
      $msg = ['msg' => '조회 결과가 없습니다.'];
    } else {
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $pr_info = [
          'pr_img'    => $row['bx_img'],
          'pr_ttl'    => $row['bx_ttl'],
          'pr_wt_en'  => $row['bx_wt_en'],
          'pr_wt_kr'  => $row['bx_wt_kr'],
          'pr_pri'    => $row['bx_pri'],
          'pr_desc'   => $row['bx_desc'],
          'pr_reg'    => $row['bx_reg'],
          'pr_ID'     => $row['bx_ID'],
          'pr_hit'    => $row['bx_hit']
        ];
        array_push($pr_arr, $pr_info);
      }
      $msg = $pr_arr;
    }
  }

  
  echo json_encode($msg);


?>
