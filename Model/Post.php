<?php 

namespace Model;

use Helper\Session;
use Helper\Markdown;
use Repository\UserRepository;

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
  private $author;

  // public $visible = [
  //   'id',
  //   'name',
  //   'avatar' => 'getUserAvatar',
  //   'is_admin',
  //   'created_at'
  // ];

  /**
   * Title
   */
  public function setTitle($new_title)
  { 
    $this->title = $new_title;  
  }
 
  public function getTitle()
  {
    return $this->title;
  }

  /**
   * Message
   */
  public function setMessage($new_message)
  { 
    $this->message = $new_message;  
  }
 
  public function getMessage()
  {
    return $this->message;
  }

  /**
   * Created Date
   */
  public function setCreatedDate($new_date)
  { 
    $this->createdDate = $new_date;  
  }
 
  public function getCreatedDate()
  {
    return $this->createdDate;
  }

  /**
   * Updated Date
   */
  public function setUpdatedDate($new_date)
  { 
    $this->updatedDate = $new_date;  
  }
 
  public function getUpdatedDate()
  {
    return $this->updatedDate;
  }

  /**
   * User Id
   */
  public function setUserId($new_user_id)
  { 
    $this->userId = $new_user_id;  
  }
 
  public function getUserId()
  {
    return $this->userId;
  }

  /**
   * Post Id
   */
  public function setPostId($new_post_id)
  { 
      $this->postId = $new_post_id;  
  }
 
  public function getPostId()
  {
      return $this->postId;
  }
  
  /**
   * Get Post Date
   */
  public function getDate()
  {
    $date = $this->getUpdatedDate() ? $this->getUpdatedDate() : $this->getCreatedDate();
    return date($date);
  }

  /**
   * Format Date
   */
  public function getFormattedDate($date)
  {
    return date_format(new \DateTime($date), 'g:ia \o\n l jS F Y');
  }

  /**
   * Set Date Label
   */
  public function getDateLabel()
  {
    if ($this->getUpdatedDate()) {
      return 'Updated';
    }

    return 'Posted';
  }

  /**
   * Get formatted Markdown
   */
  public function getFormattedContent()
  {
    return Markdown::render($this->getMessage());
  }

  /**
   * Check if post is editable by user
   */
  public function isEditable()
  {
    $activeUser = Session::getActiveUser();
      
    // Check if user has posted the post
    if ($activeUser->getId() === $this->getUserId()) {
      return true;
    }

    // Check if active user is admin
    if ($activeUser->getIsAdmin()) {
      return true;
    }

    throw new \Exceptions\NoPermission("Sorry, you are not allowed to edit that post.");
  }
 
  /**
   * Get Post Author
   */
  public function getAuthor()
  {
    if (!$this->author) {
      $this->author = UserRepository::getUserById($this->getUserId());
    }

    return $this->author;
  }

  /**
   * Check if Current User can edit post
   */
  public function canUserEdit()
  {
    try {
      return $this->isEditable();
    } catch (\Exceptions\NoPermission $e) {
      return false; 
    }
  }
}
