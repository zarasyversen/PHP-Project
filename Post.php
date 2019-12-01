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
  public function __construct($postId) {
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
  private function getPost($postId){

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
            $this->setUserId((int)$row['user_id']);
            $this->setPostId((int)$row['id']);

            return $this;
          }

        }

      }

    } 

    return false;
  }

}