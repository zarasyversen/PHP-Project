<li>
  <article class="post">
    <header class="post__header">
      <h2 class="post__title"><?php echo $post->getTitle(); ?></h2>
    </header>
    <div class="post__message">
      <?php echo $post->getFormattedContent() ?>
    </div>
    <footer class="post__footer">
      <p class="post__details">
        <?php echo $post->getDateLabel();?>
        <time datetime="<?php echo $post->getDate() ?>">
          <?php echo $post->getFormattedDate($post->getDate()); ?>
        </time>
        by 
        <a title="<?php echo $post->getUserName($post->getUserId()); ?> Profile" 
          href="/profile/<?php echo $post->getUserId(); ?>">
          <?php echo $post->getUserName($post->getUserId()); ?></a>.
        <?php if ($post->canUserEdit()) :?>
          <a href="/post/<?php echo $post->getPostId(); ?>/edit">Edit</a>
        <?php endif;?>
      </p>
    </footer>
  </article>
</li>