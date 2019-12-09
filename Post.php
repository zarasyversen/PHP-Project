<?php 

class Post extends \Helper\Connection {

  public $title;
  public $message;
  public $createdDate;
  public $userId;
  public $postId;
  public $updatedDate;
  public $posts = [];

  //
  // Call getPost on when instantiate
  //
  public function __construct($postId = false) {
    $this->getPost($postId);
  }

  private function setTitle($new_title) { 
      $this->title = $new_title;  
  }
 
  public function getTitle() {
      return $this->title;
  }

  private function setMessage($new_message) { 
      $this->message = $new_message;  
  }
 
  public function getMessage() {
      return $this->message;
  }

  private function setCreatedDate($new_date) { 
      $this->createdDate = $new_date;  
  }
 
  public function getCreatedDate() {
      return $this->createdDate;
  }

  private function setUpdatedDate($new_date) { 
      $this->updatedDate = $new_date;  
  }
 
  public function getUpdatedDate() {
      return $this->updatedDate;
  }

  private function setUserId($new_user_id) { 
      $this->userId = $new_user_id;  
  }
 
  public function getUserId() {
      return $this->userId;
  }

  private function setPostId($new_post_id) { 
      $this->postId = $new_post_id;  
  }
 
  public function getPostId() {
      return $this->postId;
  }
  
  //
  // Get Post to Set Properties
  //
  public function getPost($postId = false){

    if (is_numeric($postId)) {

      $connection = $this->getConnection();

      // Get Post from DB 
      $sql = "SELECT * FROM posts WHERE id =" . mysqli_real_escape_string($connection, $postId);

      if ($result = mysqli_query($connection, $sql)) {

        if (mysqli_num_rows($result) > 0) {

          while ($row = mysqli_fetch_array($result)) {

            $this->setTitle($row['title']);
            $this->setMessage($row['message']);
            $this->setCreatedDate($row['created_at']);
            $this->setUpdatedDate($row['updated_at']);
            $this->setUserId((int)$row['user_id']);
            $this->setPostId((int)$row['id']);

            // what do I do here 
            return $this;
          }

        }

      }

    } 

    return false;
  }

  public function getAllPosts() {
    // Prepare select statement 
    $query = "SELECT * FROM posts ORDER BY created_at DESC";
    $connection = $this->getConnection();

    if ($result = mysqli_query($connection, $query)){
      // Check if the table has rows 
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

          // Add each post to posts 
          array_push($posts, $post);
        }

        return $posts;

      } else {
        return false;
      }
    }
  }

  public function getAllUserPosts($userId) {
    if (is_numeric($userId)) {

      $connection = $this->getConnection();
      $sql = "SELECT * FROM posts WHERE user_id =" . mysqli_real_escape_string($connection, $userId). " ORDER BY created_at DESC";

      if ($result = mysqli_query($connection, $sql)) {

        if (mysqli_num_rows($result) > 0) {

          $posts = [];

          while($row = mysqli_fetch_array($result)) {

            $post = new Post(); 
            $post->setTitle($row['title']);
            $post->setMessage($row['message']);
            $post->setCreatedDate($row['created_at']);
            $post->setUpdatedDate($row['updated_at']);
            $post->setUserId((int)$row['user_id']);
            $post->setPostId((int)$row['id']);

            // Add each post to posts 
            array_push($posts, $post);
          }

          return $posts;
        }
      }
    }
    return false;
  } 

  public function getDate() {
    $date = $this->getUpdatedDate() ? $this->getUpdatedDate() : $this->getCreatedDate();
    return date($date);
  }

  public function getFormattedDate($date) {
    return date_format(new DateTime($date), 'g:ia \o\n l jS F Y');
  }

  public function getDateLabel() {

    if ($this->getUpdatedDate()) {
      return 'Updated';
    }

    return 'Posted';
  }

  public function getFormattedContent() {
    return Helper\Markdown::render($this->getMessage());
  }

}