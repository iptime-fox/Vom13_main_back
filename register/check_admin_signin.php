<?php

  session_start();
  $msg = [];
  if(!isset($_SESSION['userid']) && isset($_SESSION['userlvl']) != 1){
    $msg = ['acs_code' => 0];
  } else {
    $msg = ['acs_code' => 1];
  }

  echo json_encode($msg);

  


?>
