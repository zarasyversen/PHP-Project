<?php

try {
 $postEditable = $post->isEditable();
} catch (\Exceptions\NoPermission $e) {
 $postEditable = false; 
}

$user = Repository\UserRepository::getUser($post->getUserId());

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
        <a title="<?php echo $user->getName(); ?> Profile" 
          href="/profile/<?php echo $post->getUserId(); ?>">
          <?php echo $user->getName(); ?></a>.
        <?php if ($postEditable) :?>
          <a href="/post/<?php echo $post->getPostId(); ?>/edit">Edit</a>
        <?php endif;?>
      </p>
    </footer>
  </article>
</li>