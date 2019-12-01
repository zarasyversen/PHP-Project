<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");
$posts = new Posts();
$postList = $posts->getAllPostsId();
?>
<?php if($postList): ?>
  <section class="posts">
    <h2>Posts</h2>
    <ul>
      <?php foreach($postList as $post):
        $post = new Post($post['id']);?>
        <li>
          <article class="post">
            <header class="post__header">
              <h2 class="post__title"><?php echo $post->getTitle(); ?></h2>
            </header>
            <p class="post__message"><?php echo Helper\Markdown::render($post->getMessage()); ?></p>
            <footer class="post__footer">
              <p class="post__details">
                <?php if($post->getUpdatedDate()):?>
                    Updated on
                  <?php else: ?>
                    Posted on
                <?php endif;?>
                <?php $date = date($post->getUpdatedDate()) ? date($post->getUpdatedDate()) : date($post->getCreatedDate());?>
                <time datetime="<?php echo $date; ?>">
                  <?php echo date_format(new DateTime($date), 'g:ia \o\n l jS F Y'); ?>
                </time>
                by 
                <?php $userName = getUsername($connection, $post->getUserId()); ?>
                <a title="<?php echo $userName; ?> Profile" 
                  href="/user/profile.php?id=<?php echo $post->getUserId(); ?>">
                  <?php echo $userName; ?></a>.
                <?php if(canEditPost($connection, $post->getPostId())) :?>
                  <a href="/user/post/edit.php?id=<?php echo $post->getPostId(); ?>">Edit</a>
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
