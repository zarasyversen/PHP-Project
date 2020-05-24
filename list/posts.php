<?php if ($postList): ?>
    <ul>
      <?php foreach ($postList as $post): ?>
        <?php include(BASE .'/list/post.php');?>
      <?php endforeach; ?>
    </ul>
<?php else : ?>
    <p>Sorry, no posts available yet. </p>
<?php endif; ?>
