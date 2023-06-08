<?php

  header('Access_Control-Allow-Origin: *'); // 크로스 오리진 허용
  header('Content-Type: application/json');  // 데이터 형식 json
  header('Access-Control-Allow-Methods: DELETE'); // 허용 메서드
  header('Access-Control-Allow-Headers: Access_Control-Allow_headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-Width');

  $delete_ID = $_GET['pr_ID'];
  $msg = [];

  
  session_start();
  // foreach as 참조 : https://extbrain.tistory.com/24
  foreach($_SESSION['cart'] as $key => $value){
    if($value['cart_ID'] == $delete_ID){
      unset($_SESSION['cart'][$key]);

      // array_value 참조 : https://www.php.net/manual/en/function.array-values.php : 배열 순번 재배치

      $_SESSION['cart'] = array_values($_SESSION['cart']);
      $msg = ['msg' => '장바구니에서 상품이 삭제되었습니다.'];


    }
  }

  echo json_encode($msg);



?>
