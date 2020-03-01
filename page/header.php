<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $pageTitle ? $pageTitle : 'PHP Project';?></title>
    <link rel="stylesheet" href="/assets/main.css">
</head>
<body>
  <header class="main-header">
    <?php if(!isset($public_access)) :?>
      <?php include(BASE . '/page/navigation.php');?>
    <?php endif; ?>
  </header>