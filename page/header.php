<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $pageTitle ? $pageTitle : 'PHP Project';?></title>
    <link rel="stylesheet" href="/assets/main.css">
</head>
<body>
   <?php if (Helper\Session::isLoggedIn()) :?>
    <header class="main-header">
        <?php include(BASE . '/page/navigation.php');?>
    </header>
  <?php endif; ?>