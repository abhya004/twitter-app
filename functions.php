<?php

    session_start();
    $link = mysqli_connect("localhost","root","","twitter");
    if(mysqli_connect_errno()){

      print_r(mysqli_connect_error());
      exit();
    }


// if ($_GET['function'] == "logout") {
//
//   session_unset();
// }

 ?>
