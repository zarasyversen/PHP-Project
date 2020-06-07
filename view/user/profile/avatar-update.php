<?php
$userId = $user->getId();
$hasAvatar = $user->getUserAvatar();
$pageTitle = 'Update Avatar';
include(BASE . '/view/page/header.php');?>
<div class="wrapper page-2column">
  <header class="page-header">
    <h1>Update Avatar</h1>
  </header>
  <?php include(BASE . '/view/session/message.php'); ?>
  <aside class="page-sidebar">
    <h2>Current Avatar</h2>
    <img src="<?php echo $hasAvatar;?>"/>
  </aside>
  <main class="page-main">
    <h2>Update your Avatar</h2>
    <form class="form" action="/profile/<?php echo $userId;?>/avatar/create" method="post" enctype="multipart/form-data">
      <div class="form__group">
        <label for="avatar">Upload New Avatar:</label>
        <input type="file" class="form__input file" name="file" id="avatar">
      </div>
      <button type="submit" class="btn btn--primary" name="submit">Upload</button>
    </form>
    <button type="button" class="btn btn--primary delete js-delete-avatar">Delete Avatar</button>
    <a href="/profile/<?php echo $userId;?>">Cancel</a>
  </main>
</div>
<script>
  var deleteAction = document.querySelector('.js-delete-avatar');

  function deleteAvatar() {
    var confirmed = confirm('Are you sure you want to delete your avatar?');

    if(confirmed){
      window.location.href = "/profile/<?php echo $userId;?>/avatar/delete";
    } 
  }

  deleteAction.addEventListener('click', deleteAvatar);
</script>
