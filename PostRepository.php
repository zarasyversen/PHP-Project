<?php 

/**
 * PostRepository Class
 * DB Queries to create Post 
 */
class PostRepository {

  /**
   * Get Single Post
   * Returns Object {}
   */
  public function getPost($postId){

    if (is_numeric($postId)) {

      $connection = Helper\Connection::getConnection();
      $sql = "SELECT * FROM posts WHERE id =" . mysqli_real_escape_string($connection, $postId);

      if ($result = mysqli_query($connection, $sql)) {

        if (mysqli_num_rows($result) > 0) {

          while ($row = mysqli_fetch_array($result)) {

            $post = new Post(); 
            $post->setTitle($row['title']);
            $post->setMessage($row['message']);
            $post->setCreatedDate($row['created_at']);
            $post->setUpdatedDate($row['updated_at']);
            $post->setUserId((int)$row['user_id']);
            $post->setPostId((int)$row['id']);

            return $post;
          }

        }

      }

    } 

    return false;
  }

  /**
   * Get All Posts 
   * Returns Array []
   */
  public function getAllPosts() {

    $query = "SELECT * FROM posts ORDER BY created_at DESC";
    $connection = Helper\Connection::getConnection();

    if ($result = mysqli_query($connection, $query)) {
 
      if (mysqli_num_rows($result) > 0) {

        $posts = [];

        while ($row = mysqli_fetch_array($result)) {

          $post = new Post(); 
          $post->setTitle($row['title']);
          $post->setMessage($row['message']);
          $post->setCreatedDate($row['created_at']);
          $post->setUpdatedDate($row['updated_at']);
          $post->setUserId((int)$row['user_id']);
          $post->setPostId((int)$row['id']);

          array_push($posts, $post);
        }

        return $posts;

      } else {
        return false;
      }

    }

  }

  /**
   * Get All Posts from specific User
   * Returns Array []
   */
  public function getAllUserPosts($userId) {

    if (is_numeric($userId)) {

      $connection = Helper\Connection::getConnection();
      $sql = "SELECT * FROM posts WHERE user_id =" . mysqli_real_escape_string($connection, $userId). " ORDER BY created_at DESC";

      if ($result = mysqli_query($connection, $sql)) {

        if (mysqli_num_rows($result) > 0) {

          $posts = [];

          while ($row = mysqli_fetch_array($result)) {

            $post = new Post(); 
            $post->setTitle($row['title']);
            $post->setMessage($row['message']);
            $post->setCreatedDate($row['created_at']);
            $post->setUpdatedDate($row['updated_at']);
            $post->setUserId((int)$row['user_id']);
            $post->setPostId((int)$row['id']);

            array_push($posts, $post);
          }

          return $posts;
        } else {
          return false;
        }

      }

    }

  }

}
