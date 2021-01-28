<?php
  require_once('includes/load.php');

  $taskToDelete = find_by_id('tasks',(int)$_GET['id']);
  
  if(!$taskToDelete) {
    $session->msg("d","Error: Invalid ID.");
    redirect('tasks.php');
  } else {
    $delete_id = delete_by_id('tasks',(int)$taskToDelete['id']);
  
    if($delete_id){
        $session->msg("s","Task deleted.");
        redirect('tasks.php');
    } else {
        $session->msg("d","Delete failed.");
        redirect('tasks.php');
    }
  }
?>