<?php
  require_once('includes/load.php');
  $page_title = 'Edit Task';

  $task = find_by_id('tasks',(int)$_GET['id']);
  $all_folders = find_all('tasks_folders');

  if(!$task) {
    $session->msg("d","Missing task id.");
    redirect('tasks.php');
  }

  if(isset($_POST['task_name_change'])) {
    $new_name = $db->escape($_POST['task_name']);
    $new_folder = $db->escape($_POST['task_folder']);

    if (!ctype_space($new_name) && !empty($new_name)) {
      $edit_task = edit_task_by_id('tasks',(int)$task['id'], $new_name, $new_folder);

      if($edit_task){
        $session->msg("s","Task edited.");
        redirect('tasks.php');
      } else {
        $session->msg("d","Error.");
        redirect('tasks.php');
      }  
    } else {
      $session->msg("d", "Please enter more than a blank space.");
      redirect('edit_task.php?id='.$task["id"],false);
    }
  }

  include_once('layouts/header.php'); 
?>

<div class="row">
   <div class="col-md-12">
     <?php echo display_msg($msg); ?>
   </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
     <div class="panel-heading">
       <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Editing task (ID <?php echo $task['id'];?>)</span> 
      </strong>
     </div>

      <div class="panel-body">
        <form method="post" action="edit_task.php?id=<?php echo (int)$task['id'];?>">
          <div class="form-group col-xs-6 mr-2 ">
            <label for="task_name" class="control-label">Task name:</label>
            <input type="text" class="form-control" name="task_name" placeholder="Task name" maxlength="255" required autocomplete="off" value="<?php echo $task['task_name'];?>" oninvalid="this.setCustomValidity('Complete this field')" oninput="this.setCustomValidity('')">
          </div>
          <div class="form-group col-xs-6 mr-2 ">
            <label for="task_folder" class="control-label">Task Folder:</label>
            <select class="form-control" name="task_folder" id="task_folder">
              <option value="" disabled selected>Select a folder</option>
              <?php foreach ($all_folders as $folder): ?>
                <option value="<?php echo (int) $folder['id']?>">
                  <?php echo $folder['folder_name'];?></option>
              <?php endforeach; ?>
            </select>
            <script>
              var val = "<?php echo $task['folder_id'] ?>";
              if (val !== "") {
                  document.getElementById("task_folder").value = Number(val);
              }
            </script>
          </div>
          <br>
          <div class="form-group col-xs-12 text-right">
            <a class="btn btn-primary" href="tasks.php" role=button>Cancel</a>
            <button type="submit" name="task_name_change" class="btn btn-danger">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>