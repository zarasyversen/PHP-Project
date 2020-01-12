<?php

//
// How to do this?
//
try {
 $post->isEditable();
 $postEditable = true; 
} catch (\Exceptions\NoPermission $e) {
  $postEditable = false; 
}

?>
<li>
  <article class="post">
    <header class="post__header">
      <h2 class="post__title"><?php echo $post->getTitle(); ?></h2>
    </header>
    <p class="post__message"><?php echo $post->getFormattedContent() ?></p>
    <footer class="post__footer">
      <p class="post__details">
        <?php echo $post->getDateLabel();?>
        <time datetime="<?php echo $post->getDate() ?>">
          <?php echo $post->getFormattedDate($post->getDate()); ?>
        </time>
        by 
        <?php $userName = getUsername($connection, $post->getUserId()); ?>
        <a title="<?php echo $userName; ?> Profile" 
          href="/user/profile.php?id=<?php echo $post->getUserId(); ?>">
          <?php echo $userName; ?></a>.
        <?php if ($postEditable) :?>
          <a href="/user/post/edit.php?id=<?php echo $post->getPostId(); ?>">Edit</a>
        <?php endif;?>
      </p>
    </footer>
  </article>
</li>