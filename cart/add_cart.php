<?php

  header('Access_Control-Allow-Origin: *'); // 크로스 오리진 허용
  header('Content-Type: application/json');  // 데이터 형식 json
  header('Access-Control-Allow-Methods: POST'); // 허용 메서드
  header('Access-Control-Allow-Headers: Access_Control-Allow_headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-Width');

  $data = json_decode(file_get_contents('php://input'));

  // print_r($data->cart_ID);

  session_start();
  $msg = [];

  if(isset($_SESSION['cart'])){
    $addedItem = array_column($_SESSION['cart'], 'cart_ID');
    // 주어진 배열(첫번째 파라미터)에서 특정 컬럼(두번째 파라미터)값 반환 => https://zetawiki.com/wiki/PHP_array_column()

    if(in_array($data->cart_ID, $addedItem)){ // 첫번째 파라미터 배열에 두번째 파라미터 배열값이 있으면 true, 없으면 false
      // echo 'true';
      $msg = ['msg' => '이미 추가된 상품입니다.'];
    } else{
      // echo 'false';
      $count = count($_SESSION['cart']);
      $_SESSION['cart'][$count] = array(
        "cart_ID"     => $data->cart_ID,
        "cart_img"    => $data->cart_img,
        "cart_ttl"    => $data->cart_ttl,
        "cart_wt_kr"  => $data->cart_wt_kr,
        "cart_pri"    => $data->cart_pri,
        "cart_count"  => $data->cart_count,
        "cart_type"  => $data->cart_type,
        "cart_size"  => $data->cart_size
      );
      $msg = ['msg' => '장바구니에 상품이 추가되었습니다.'];
    }
  } else {
    // 세션이 하나도 없을 때 첫 세션 생성
    $_SESSION['cart'][0] = array(
      "cart_ID"     => $data->cart_ID,
      "cart_img"    => $data->cart_img,
      "cart_ttl"    => $data->cart_ttl,
      "cart_wt_kr"  => $data->cart_wt_kr,
      "cart_pri"    => $data->cart_pri,
      "cart_count"  => $data->cart_count,
      "cart_type"  => $data->cart_type,
      "cart_size"  => $data->cart_size
    );
    $msg = ['msg' => '장바구니에 상품이 추가되었습니다.'];
  }


  echo json_encode($msg);


?>