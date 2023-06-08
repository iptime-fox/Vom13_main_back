<?php

  session_start();
  if(isset($_SESSION['userid'])){
    $userid = $_SESSION['userid'];
    $useridx = $_SESSION['useridx'];
    $userlvl = $_SESSION['userlvl'];
  } else {
    $userid = "guest";
    $useridx = -1;
    $userlvl = -1;

  }

  if($_SESSION['cart']){
    $cart_count = count($_SESSION['cart']);
  } else{
    $cart_count = 0;
  }

  echo json_encode(array('userid' => $userid, 'useridx' => $useridx, 'userlvl' => $userlvl, 'cartcount' => $cart_count));

?>