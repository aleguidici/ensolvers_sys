<?php
  require_once('includes/load.php');

  $task_id = $_POST['task_id'];
  if ($_POST['state'] == "true")
    $state = 1;
  else
    $state = 0;

  $sql="UPDATE tasks SET state='{$state}' WHERE id = '{$task_id}'";
  echo $result=$db->query($sql);
?>