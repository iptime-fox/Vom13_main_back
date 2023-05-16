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

  echo json_encode(array('userid' => $userid, 'useridx' => $useridx, 'userlvl' => $userlvl));

?>