<?php 
echo 'posts here';

 // Prepare select statement 
    $query = "SELECT * FROM posts";

    if($result = mysqli_query($connection, $query)){

      // Attempt to execute the prepared statement
      if(mysqli_num_rows($result) > 0){


        while($row = mysqli_fetch_array($result)){
          echo $row['title'] . '</BR>';
          echo $row['message'] . '</BR>';
          echo $row['created_at'] . '</BR>';
          echo $row['username'] . '</BR>';
        }
      
      } else {
        echo "NO POSTS";
      }
    }

