<?php

    session_start();
    $link = mysqli_connect("localhost","root","","twitter");
    if(mysqli_connect_errno()){

      print_r(mysqli_connect_error());
      exit();
    }

        if (isset($_GET['function']) == "logout") {

            session_unset();

        }
        function time_since($since) {
        $chunks = array(
            array(60 * 60 * 24 * 365 , 'year'),
            array(60 * 60 * 24 * 30 , 'month'),
            array(60 * 60 * 24 * 7, 'week'),
            array(60 * 60 * 24 , 'day'),
            array(60 * 60 , 'hour'),
            array(60 , 'min'),
            array(1 , 'sec')
        );

        for ($i = 0, $j = count($chunks); $i < $j; $i++) {
            $seconds = $chunks[$i][0];
            $name = $chunks[$i][1];
            if (($count = floor($since / $seconds)) != 0) {
                break;
            }
        }

        $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
        return $print;
    }

        function displayTweets($type){

          global $link;

          if($type == 'public'){
            $whereclause = "";
          }
          $query = "SELECT * FROM tweets ".$whereclause." ORDER BY `date` DESC LIMIT 10";

          $result = mysqli_query($link, $query);
          if (mysqli_num_rows($result)==0){
            echo "There are no tweets to display.";
          }
          else{
            while ($row = mysqli_fetch_assoc($result)) {

                  $userQuery = "SELECT * FROM users WHERE id = ".mysqli_real_escape_string($link, $row['id'])." LIMIT 1";
                  $userQueryResult = mysqli_query($link, $userQuery);
                  $user = mysqli_fetch_assoc($userQueryResult);

                  echo "<div class='tweet'><p><a href='?page=publicprofiles&userid=".$user['id']."'>".$user['email']."</a> <span class='time'>".time_since(time() - strtotime($row['date']))." ago</span>:</p>";

                  echo "<p>".$row['tweet']."</p>";
                  echo "<p>follow</p></div>";
          }
        }
      }
      function displaySearch() {

      echo '<form class="form-inline">
<div class="form-group">
  <input type="hidden" name="page" value="search">
  <input type="text" name="q" class="form-control" id="search" placeholder="Search">
</div>
<button type="submit" class="btn btn-primary">Search Tweets</button>
</form>';


  }

  function displayTweetBox() {

      if (isset($_SESSION['id']) > 0) {

          echo '<div id="tweetSuccess" class="alert alert-success">Your tweet was posted successfully.</div>
          <div id="tweetFail" class="alert alert-danger"></div>
          <div class="form">
<div class="form-group">
  <textarea class="form-control" id="tweetContent"></textarea>
</div>
<button id="postTweetButton" class="btn btn-primary">Post Tweet</button>
</div>';


      }


  }

 ?>
