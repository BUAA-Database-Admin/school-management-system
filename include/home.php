<!DOCTYPE html>
<html lang="zh-cn">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>School Management System</title>

  <!-- Bootstrap -->
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet">

  <link href="/assets/css/font-awesome.min.css" rel="stylesheet">
  <link href="/assets/css/home.css" rel="stylesheet">
  <link href="/include/alert.html" rel="import">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
  <nav class="navbar navbar-fixed-top navbar-dark bg-inverse">
    <h1 class="navbar-brand mb-0">School Management System</h1>
    <ul class="nav navbar-nav nav-pills">
      <li class="nav-item">
        <a class="nav-link active" data-toggle="pill" href="#home">Home</a>
      </li>
<?php
if (isset($_SESSION['admin'])) {
    $role = strtolower($admin->role) . 'admin';
    $user = User::newInstance(array('id' => $admin->user_id));
} else {
    $user->joinContact();
    $class = $user->role;
    $role = strtolower($class);
    $user = new $class($user);
}
include __DIR__ . "/navbar-{$role}.html";
?>
      <li class="nav-item float-xs-right">
        <a class="btn btn-outline-success" href="/index.php?logout">Sign Out</a>
      </li>
      <li class="nav-item float-xs-right">
        <span class="navbar-text text-white"><?php echo $user->name; ?></span>
      </li>
    </ul>
  </nav>
  <div class="container tab-content">
    <div class="tab-pane fade in active" id="home">
      <h1 class="title">Welcome to School Management System!</h1>
    </div>
<?php include __DIR__ . "/tabpane-{$role}.php"; ?>
  </div>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="/assets/js/jquery-3.1.1.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="/assets/js/bootstrap.min.js"></script>
  <script src="/assets/js/md5.min.js"></script>
  <script src="/assets/js/home.js"></script>
  <script src="/assets/js/<?php echo isset($_SESSION['admin']) ? 'admin' : 'user'; ?>.js"></script>
<?php
if (is_null($_SESSION['admin'])) {
    echo <<<HTML
  <script src="/assets/js/{$role}.js"></script>
HTML;
}
?>
</body>

</html>
