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
  public static function getPost(int $postId) : Post {

    $connection = Helper\Connection::getConnection();
    $sql = "SELECT * FROM posts WHERE id = " . (int) $postId;

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

    // This is creating a new instance of this exception
    throw new \Exceptions\NotFound("Post $postId does not exist");
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

          $posts[] = $post;
        }

        return $posts;
      }

    }

    return [];
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
        } 

      }

    }

    return [];

  }

  /**
   * Edit Post
   */
  public static function edit(int $postId, $title, $message) {

    $connection = Helper\Connection::getConnection();

    //
    // Not escaping strings
    //
    $sql = "UPDATE posts 
            SET title = '$title', 
                message = '$message',
                updated_at = now()
            WHERE id =" . (int) $postId;

    if (mysqli_query($connection, $sql)) {
      return true;
    } 

    return false;
  } 

  /**
   * Delete Post
   */
  public static function delete(int $postId)  {

    $connection = Helper\Connection::getConnection();
    $sql = "DELETE FROM posts WHERE id =" . $postId;

    if ($result = mysqli_query($connection, $sql)) {
      return true; 
    } 

    return false;
  }

  /**
   * Save Post
   */
  public static function save($post) {

    $connection = Helper\Connection::getConnection();
    $sql = "INSERT INTO posts (user_id, title, message) VALUES (?, ?, ?)";

    if ($statement = mysqli_prepare($connection, $sql)) {

      // Bind variables to prepared statement
      mysqli_stmt_bind_param($statement, "iss", $param_userid, $param_title, $param_message);

      // Set params
      $param_userid = $post->getUserId();
      $param_title = $post->getTitle();
      $param_message = $post->getMessage();

      // Attempt to execute statement 
      if (mysqli_stmt_execute($statement)) {
        return true;
      }

      // Close statement
      mysqli_stmt_close($statement);
    }

    throw new \Exceptions\NotSaved("Unable to save post");
  }

}
