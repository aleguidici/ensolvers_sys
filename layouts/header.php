<?php $user = current_user(); ?>
<!DOCTYPE html>
  <html lang="en">
    <head>
      <title><?php if (!empty($page_title))
            echo remove_junk($page_title);
            elseif(!empty($user))
              echo ucfirst($user['name']);
            else echo "User";?>
      </title>

    <!-- LINKS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> 
      <link rel="stylesheet" href="libs/css/main.css"/> 
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
      <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.15.3/dist/bootstrap-table.min.css">
    
    <!-- SCRIPTS -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>   
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
      <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>  

      <style type="text/css">
        body {
            color: #404E67;
            background: #F5F7FA;
            font-family: 'Open Sans', sans-serif;
            font-size: 12px;
        }
      </style>
    </head>
 
    <body>
      <?php  if ($session->isUserLoggedIn(true)): ?>
        <header id="header">
          <div class="logo pull-left">ENSOLVERS</div>
          <div class="header-content">
            <div class="header-date pull-left">
              <strong><?php echo date("d/m/Y");?></strong>
            </div>
            <div class="pull-right clearfix">
              <ul class="info-menu list-inline">
                  <a href="logout.php">
                    <i class="glyphicon glyphicon-off"></i>
                    Salir
                  </a>
              </ul>
            </div>
          </div>
        </header>
        <div class="sidebar">
          <?php include_once('admin_menu.php');?>
        </div>
      <?php endif;?>
      <div class="page">
        <div class="container-fluid">
