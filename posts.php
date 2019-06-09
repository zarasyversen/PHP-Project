<?php 
function getPosts($connection) {
  
   // Prepare select statement 
  $query = "SELECT * FROM posts ORDER BY created_at DESC";

  if($result = mysqli_query($connection, $query)){
    // Check if the table has rows 
    if(mysqli_num_rows($result) > 0){

      $posts = [];

      while($row = mysqli_fetch_array($result)) {

        // Create a post array with keys and the post info
        $post = [
          'id' => $row['id'], 
          'username' => $row['username'], 
          'title' => $row['title'], 
          'message' => $row['message'],
          'created' => $row['created_at'],
          'updated' => $row['updated_at']
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
require_once("functions.php");
?>
<?php if($posts = getPosts($connection)): ?>
  <section class="posts">
    <h2>Posts</h2>
      <ul>
      <?php foreach($posts as $post):?>
        <li>
          <article class="post">
            <header class="post__header">
              <h2 class="post__title"><?php echo $post['title']; ?></h2>
            </header>
            <p class="post__message"><?php echo $post['message']; ?></p>
            <footer class="post__footer">
              <p class="post__details">
                <?php if($post['updated']):?>
                    Updated on
                  <?php else: ?>
                    Posted on
                <?php endif;?>
                <?php $date = date($post['updated']) ? date($post['updated']) : date($post['created']);?>
                <time datetime="<?php echo $date; ?>">
                  <?php echo date_format(new DateTime($date), 'g:ia \o\n l jS F Y'); ?>
                </time>
                by <?php echo $post['username']; ?>.
                <?php if(canEditPost($connection, $post['id'])) :?>
                  <a href="edit.php?id=<?php echo $post['id']; ?>">Edit</a>
                <?php endif;?>
            </p>
            </footer>
          </article>
        </li>
      <?php endforeach; ?>
    </ul>
  </section>
<?php else : ?>
   <section class="posts">
    <h2>Posts</h2>
    <p>Sorry, no posts available yet. </p>
  </section>
<?php endif; ?>
