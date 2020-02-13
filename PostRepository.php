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

    $tableName = 'posts';
    $where = [
      'id' => (int)$postId
    ];
  
    $returnedPost = Helper\DB::select($tableName, $where);

    // check if post is array and is not empty
    if (is_array($returnedPost) && count($returnedPost) > 0) {

      $post = new Post();
      $post->setTitle($returnedPost[0]['title']);
      $post->setMessage($returnedPost[0]['message']);
      $post->setCreatedDate($returnedPost[0]['created_at']);
      $post->setUpdatedDate($returnedPost[0]['updated_at']);
      $post->setUserId((int)$returnedPost[0]['user_id']);
      $post->setPostId((int)$returnedPost[0]['id']);

      return $post;
    }

    // This is creating a new instance of this exception
    throw new \Exceptions\NotFound("Post $postId does not exist");
  }

  /**
   * Get All Posts 
   * Returns Array []
   */
  public function getAllPosts() {

    $posts = [];

    $tableName = 'posts';
    $where = null; 
    $order = 'created_at';
    $sort = 'desc';

    $returnedPosts = Helper\DB::select($tableName, $where, $order, $sort);

    if (is_array($returnedPosts)) {

      foreach ($returnedPosts as $row) {

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

    return [];
  }

  /**
   * Get All Posts from specific User
   * Returns Array []
   */
  public function getAllUserPosts(int $userId) {

    $posts = [];

    $tableName = 'posts';
    $where = [
      'user_id' => (int)$userId
    ]; 
    $order = 'created_at';
    $sort = 'desc';

    $returnedPosts = Helper\DB::select($tableName, $where, $order, $sort);

    if (is_array($returnedPosts)) {

      foreach ($returnedPosts as $row) {

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

    return [];

  }

  /**
   * Edit Post
   */
  public static function edit(int $postId, $title, $message) {

    $tableName = 'posts';

    $set = [
      'title' => $title,
      'message' => $message,
      'updated_at' => date('Y-m-d H:i:s')
    ];

    $where = ['id', $postId];

    if (Helper\DB::update($tableName, $set, $where)) {
      return true;
    }

    return false;
  } 

  /**
   * Delete Post
   */
  public static function delete(int $postId)  {

    $tableName = 'posts';
    $where = ['id', $postId];

    if (Helper\DB::delete($tableName, $where)) {
      return true;
    }
    
    return false;
  }

  /**
   * Save Post
   */
  public static function save($post) {

    $tableName = 'posts';
    $insert = [
      'user_id' => $post->getUserId(),
      'title' => $post->getTitle(),
      'message' => $post->getMessage()
    ];

    if (Helper\DB::insert($tableName, $insert)) {
      return true;
    }
    
    return false;

    // throw new \Exceptions\NotSaved("Unable to save post");

  }

}
