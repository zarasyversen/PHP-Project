<?php 
echo 'posts here';


function getPosts($connection) {
   // Prepare select statement 
  $query = "SELECT * FROM posts";
  // Nothing happens if I change posts table to non existent table

  if($result = mysqli_query($connection, $query)){
    // Check if the table has rows 
    if(mysqli_num_rows($result) > 0){

      $posts = [];
      while($row = mysqli_fetch_array($result)) {

        // Create an array with keys and the post information 
        $post = [
          'id' => $row['id'], 
          'username' => $row['username'], 
          'title' => $row['title'], 
          'message' => $row['message']
        ];

        // Add each post to posts 
        array_push($posts, $post);
      }

      return $posts;

    } else {
      return false;
    }
  }
}
?>
<pre>
<?php var_dump(getPosts($connection)); ?>
</pre>