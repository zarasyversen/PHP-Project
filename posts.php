<?php 
function getPosts($connection) {
   // Prepare select statement 
  $query = "SELECT * FROM posts";
  // Nothing happens if I change posts table to non existent table

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
          'created' => $row['created_at']
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
?>
<?php if($posts = getPosts($connection)): ?>
  <section class="posts">
    <h2>Posts</h2>
      <ul>
      <?php foreach($posts as $post):?>
        <li>
          <article>
            <header>
              <h2><?php echo $post['title']; ?></h2>
            </header>
            <p><?php echo $post['message']; ?></p>
            <footer class="footer">
              <p>Posted on
                <?php $date = date($post['created']);?>
                <time datetime="<?php echo $date; ?>">
                  <?php echo date_format(new DateTime($date), 'g:ia \o\n l jS F Y'); ?>
                </time>
                by <?php echo $post['username']; ?>.
            </p>
            </footer>
          </article>
        </li>
      <?php endforeach; ?>
    </ul>
  </section>
<?php else : ?>
  <p>Sorry, no posts available yet. </p>
<?php endif; ?>
