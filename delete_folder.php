<?php
  require_once('includes/load.php');

  $folderToDelete = find_by_id('tasks_folders',(int)$_GET['id']);
  
  if(!$folderToDelete) {
    $session->msg("d","Error: Invalid ID.");
    redirect('tasks_folders.php');
  } else {
    $delete_id = delete_by_id('tasks_folders',(int)$folderToDelete['id']);
  
    if($delete_id){
      $session->msg("s","Folder deleted.");
      redirect('tasks_folders.php');
    } else {
      $session->msg("d","Delete failed.");
      redirect('tasks_folders.php');
    } 
  }
?>