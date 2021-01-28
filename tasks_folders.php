<?php
  $page_title = 'Tasks Folders';
  require_once('includes/load.php');
  $all_tasks_folders = find_all('tasks_folders');

  if(isset($_POST['add'])){
    $name = $db->escape($_POST['new-folder']);
    if (!ctype_space($name) && !empty($name)) {
      $sql = "INSERT INTO tasks_folders (`folder_name`) VALUES ('{$name}')";
      if($db->query($sql)){
        $session->msg("s", "Folder added succesfully.");
        redirect('tasks_folders.php',false);
      } else {
        $session->msg("d", "Failed.");
        redirect('tasks_folders.php',false);
      }
    } else {
      $session->msg("d", "Please enter more than a blank space.");
      redirect('tasks_folders.php',false);
    }
  }

  include_once('layouts/header.php');
?>
   
<script type="text/javascript">
  $(document).ready(function() {
    $('#tasks_folders').DataTable();
  });
</script>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<h2><b><i class="glyphicon glyphicon-folder-open" aria-hidden="true"></i> Tasks Folders</b></h2>

<form method="post" action="tasks_folders.php">
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <input type="text" class="form-control" name="new-folder" placeholder="New folder" maxlength="100" required autocomplete="off" oninvalid="this.setCustomValidity('Complete this field')" oninput="this.setCustomValidity('')">
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group clearfix">
        <button type="submit" name="add" class="btn btn-success">Add &nbsp; <i class="glyphicon glyphicon-plus" aria-hidden="true"></i></button>
      </div>
    </div>
  </div>
</form>

<br>

<div class="table-responsive">
  <table id="tasks_folders" class="table table-striped table-bordered" style="width:100%">
    <thead>
      <tr>
        <th class="text-center" style="width: 5%;"> ID </th>
        <th class="text-center" style="width: 85%;"> Folder </th>
        <th class="text-center" style="width: 10%;"> Actions </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($all_tasks_folders as $folder):?>
        <tr>
          <td class="text-center"> <?php echo $folder['id']; ?></td>
          <td> <?php echo $folder['folder_name']; ?></td>
          <td class="text-center">
            <div class="btn-group">
              <a href="tasks.php?id=<?php echo $folder['id'];?>" class="btn btn-xs btn-warning" title="Tasks in folder" data-toggle="tooltip">
                <span class="glyphicon glyphicon-eye-open"></span>
              </a>
              <a href="edit_folder.php?id=<?php echo (int)$folder['id'];?>" class="btn btn-info btn-xs"  title="Edit folder" data-toggle="tooltip">
                <span class="glyphicon glyphicon-edit"></span>
              </a>
              <a href="delete_folder.php?id=<?php echo (int)$folder['id'];?>" class="btn btn-xs btn-danger" title="Delete folder" data-toggle="tooltip" onclick="return confirm('Are you sure you want to delete this folder? \n\nPlease note that all tasks will also be deleted')">
                <span class="glyphicon glyphicon-trash"></span>
              </a>
            </div>
          </td>
      <?php endforeach; ?>
    </tbody>
  </table>

  <script type="text/javascript">  
    $('#tasks_folders').DataTable({ "order": [ 0, "asc" ] });
  </script> 
</div>

<?php include_once('layouts/footer.php'); ?>
