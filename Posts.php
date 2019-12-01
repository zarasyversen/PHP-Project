<?php 

class Posts extends \Helper\Connection {

  public function getAllPostsId() {
    // Prepare select statement 
    $query = "SELECT * FROM posts ORDER BY created_at DESC";
    $connection = $this->getConnection();

    if ($result = mysqli_query($connection, $query)){
      // Check if the table has rows 
      if (mysqli_num_rows($result) > 0) {

        $posts = [];

        while ($row = mysqli_fetch_array($result)) {

          // Create a post array with keys and the post info
          $post = [
            'id' => $row['id']
          //   'user_id' => $row['user_id'], 
          //   'title' => $row['title'], 
          //   'message' => $row['message'],
          //   'created' => $row['created_at'],
          //   'updated' => $row['updated_at']
          ];


          // $this->setTitle($row['title']);
          // $this->setMessage($row['message']);
          // $this->setCreatedDate($row['created_at']);
          // $this->setUpdatedDate($row['updated_at']);
          // $this->setUserId((int)$row['user_id']);
          // $this->setPostId((int)$row['id']);

          // Add each post to posts 
          array_push($posts, $post);
        }

        return $posts;

      } else {
        return false;
      }
    }
  }
}