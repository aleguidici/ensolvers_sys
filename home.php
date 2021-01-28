<?php
  $page_title = 'Home Page';
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { 
    redirect('index.php', false);
  }

  include_once('layouts/header.php'); 
?>

<h2><b>Excercise.PDF</b></h2>

<div class="row">
  <div class="col-auto">
    <?php echo display_msg($msg); ?>
  </div>
  <div class="col-md-12">
    <div>
      <button id="pdf" class="btn btn-primary">  View &nbsp; <i class="glyphicon glyphicon-new-window" aria-hidden="true"></i></button>

      <script>
        $('#pdf').click(function(){
          window.open("uploads/Ensolvers - Interview implementation excercise.pdf");
        });
      </script>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
