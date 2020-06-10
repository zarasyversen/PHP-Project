<?php 

namespace Repository;

use Model\Post;
use Helper\DB;

/**
 * PostRepository Class
 * DB Queries to create Post 
 */
class PostRepository {

  const TABLE_NAME = 'posts';
  const ASC_ORDER = 'ASC';
  const DESC_ORDER = 'DESC';

  /**
   * Get Single Post
   * Returns Object {}
   */
  public static function getPost(int $postId) : Post
  {
    $returnedPost = DB::selectFirst('*', self::TABLE_NAME, ['id' => $postId]);

    if ($returnedPost) {
      $post = new Post();
      $post->setTitle($returnedPost['title']);
      $post->setMessage($returnedPost['message']);
      $post->setCreatedDate($returnedPost['created_at']);
      $post->setUpdatedDate($returnedPost['updated_at']);
      $post->setUserId((int)$returnedPost['user_id']);
      $post->setPostId((int)$returnedPost['id']);

      return $post;
    }

    throw new \Exceptions\NotFound("Sorry, that post does not exist.");
  }

  /**
   * Get Post Collection
   * Returns Array []
   */
  private static function getPosts($where = null)
  {
    $posts = [];
    $returnedPosts = DB::select('*', self::TABLE_NAME, $where, 'created_at', self::DESC_ORDER);

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
   * Get All Posts 
   * Returns Array []
   */
  public static function getAllPosts()
  {
    return self::getPosts();
  }

  /**
   * Get All Posts from specific User
   * Returns Array []
   */
  public static function getAllUserPosts(int $userId)
  {
    return self::getPosts(['user_id' => $userId]);
  }

  /**
   * Edit Post
   */
  public static function edit(int $postId, $title, $message)
  {
    $set = [
      'title' => $title,
      'message' => $message,
      'updated_at' => date('Y-m-d H:i:s')
    ];

    if (DB::update(self::TABLE_NAME, $set, ['id', $postId])) {
      return true;
    }

    return false;
  } 

  /**
   * Delete Post
   */
  public static function delete(int $postId)
  {
    if (DB::delete(self::TABLE_NAME, ['id', $postId])) {
      return true;
    }
    
    return false;
  }

  /**
   * Save Post
   */
  public static function save($post)
  {
    $insert = [
      'user_id' => $post->getUserId(),
      'title' => $post->getTitle(),
      'message' => $post->getMessage()
    ];

    if (DB::insert(self::TABLE_NAME, $insert)) {
      return true;
    }

    throw new \Exceptions\NotSaved("Unable to save your post");
  }
}
