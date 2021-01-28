<?php
  require_once('includes/load.php');
  $page_title = 'Edit Task Folder';

  $folder = find_by_id('tasks_folders',(int)$_GET['id']);

  if(!$folder){
    $session->msg("d","Missing folder id.");
    redirect('tasks_folders.php');
  }

  if(isset($_POST['folder_name_change'])){
    $new_name = $db->escape($_POST['folder_name']);

    if (!ctype_space($new_name) && !empty($new_name)) {
      $edit_folder = edit_folder_by_id('tasks_folders',(int)$folder['id'], $new_name);

      if($edit_folder){
        $session->msg("s","Folder edited.");
        redirect('tasks_folders.php');
      } else {
        $session->msg("d","Error.");
        redirect('tasks_folders.php');
      }  
    } else {
      $session->msg("d", "Please enter more than a blank space.");
      redirect('edit_folder.php?id='.$folder["id"],false);
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
          <span>Editing Folder (ID <?php echo $folder['id'];?>)</span> 
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="edit_folder.php?id=<?php echo (int)$folder['id'];?>">
          <div class="form-group col-xs-3 mr-2 ">
            <label for="folder_name" class="control-label">Folder name:</label>
            <input type="text" class="form-control" name="folder_name" placeholder="Folder name" maxlength="100" required autocomplete="off" value="<?php echo $folder['folder_name'];?>" oninvalid="this.setCustomValidity('Complete this field')" oninput="this.setCustomValidity('')">
          </div>                 
          <br>
          <div class="form-group text-right">
            <a class="btn btn-primary" href="tasks_folders.php" role=button>Cancel</a>
            <button type="submit" name="folder_name_change" class="btn btn-danger">Save</button>     
          </div>              
        </form>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>