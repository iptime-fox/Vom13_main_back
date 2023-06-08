<?php

  session_start();
  $msg = [];

  if(isset($_SESSION['cart'])){
    $msg = $_SESSION['cart'];

  } else {
    $msg = ['msg' => '장바구니에 상품이 없습니다.'];
  }

  echo json_encode($msg);

?>