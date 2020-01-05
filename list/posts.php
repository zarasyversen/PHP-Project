<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");
$posts = new PostRepository();
$postList = $posts->getAllPosts();
?>
<?php if($postList): ?>
  <section class="posts">
    <h2>Posts</h2>
    <ul>
      <?php foreach($postList as $post):?>
        <?php include(BASE .'/list/post.php');?>
      <?php endforeach; ?>
    </ul>
  </section>
<?php else : ?>
   <section class="posts">
    <h2>Posts</h2>
    <p>Sorry, no posts available yet. </p>
  </section>
<?php endif; ?>
