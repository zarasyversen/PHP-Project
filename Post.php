<?php 

/**
 * Post Class
 * Only Get & Set 
 */
class Post {

  private $title;
  private $message;
  private $createdDate;
  private $userId;
  private $postId;
  private $updatedDate;

  public function setTitle($new_title) { 
      $this->title = $new_title;  
  }
 
  public function getTitle() {
      return $this->title;
  }

  public function setMessage($new_message) { 
      $this->message = $new_message;  
  }
 
  public function getMessage() {
      return $this->message;
  }

  public function setCreatedDate($new_date) { 
      $this->createdDate = $new_date;  
  }
 
  public function getCreatedDate() {
      return $this->createdDate;
  }

  public function setUpdatedDate($new_date) { 
      $this->updatedDate = $new_date;  
  }
 
  public function getUpdatedDate() {
      return $this->updatedDate;
  }

  public function setUserId($new_user_id) { 
      $this->userId = $new_user_id;  
  }
 
  public function getUserId() {
      return $this->userId;
  }

  public function setPostId($new_post_id) { 
      $this->postId = $new_post_id;  
  }
 
  public function getPostId() {
      return $this->postId;
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

  public function isEditable() {

    $activeUser = Helper\Session::getActiveUser();
      
    // Check if user has posted the post
    if ($activeUser->getId() === $this->getUserId()) {
      return true;
    }

    // Check if active user is admin
    if ($activeUser->getIsAdmin()) {
      return true;
    }

    throw new \Exceptions\NoPermission("Not allowed to edit post");
  }


}
