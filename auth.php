<?php 
  include_once('includes/load.php'); 

  $req_fields = array('username','password' );
  validate_fields($req_fields);
  $username = remove_junk($_POST['username']);
  $password = remove_junk($_POST['password']);

  if(empty($errors)) {
    $user_id = authenticate($username, $password);
    if($user_id) {
      $session->login($user_id);
      updateLastLogIn($user_id);
      redirect('home.php',false);
    } else {
      $session->msg("d", "Wrong username or password.");
      redirect('index.php',false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('index.php',false);
  }
?>
