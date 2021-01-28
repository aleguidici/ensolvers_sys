<?php
  $page_title = 'To-Do List';
  require_once('includes/load.php');
  $current_user_ok = current_user();

  if (isset($_GET['id'])) {
    $folder = find_by_id('tasks_folders',$_GET['id']);
    $all_tasks = find_tasks_by_folder($_GET['id']);
  } else {
    $all_tasks = find_all('tasks');
  }

  if(isset($_POST['add'])){
    $name = $db->escape($_POST['new-task']);
    if (!ctype_space($name) && !empty($name)) {
      $sql = "INSERT INTO tasks (`task_name`) VALUES ('{$name}')";
      if($db->query($sql)){
        $session->msg("s", "Task added succesfully.");
        redirect('tasks.php',false);
      } else {
        $session->msg("d", "Failed.");
        redirect('tasks.php',false);
      }
    } else {
      $session->msg("d", "Please enter more than a blank space.");
      redirect('tasks.php',false);
    }
  }

  include_once('layouts/header.php'); 
?>

<script type="text/javascript">
  $(document).ready(function() {
    $('#tasks').DataTable();
  });
</script>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<h2><b><i class="glyphicon glyphicon-th-list" aria-hidden="true"></i> To-Do List</b><em>
<?php 
if (isset($folder)) {
  echo ' - Folder: '.$folder['folder_name'];}
?></em></h2>

<?php if (!isset($folder)) {?> 
  <form method="post" action="tasks.php">
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <input type="text" class="form-control" name="new-task" placeholder="New task" maxlength="255" required autocomplete="off" oninvalid="this.setCustomValidity('Complete this field')" oninput="this.setCustomValidity('')">
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
<?php } ?>

<div class="table-responsive">
  <table id="tasks" class="table table-striped table-bordered" style="width:100%">
    <thead>
      <tr>
        <th class="text-center" style="width: 5%;"> ID </th>
        <th class="text-center" style="width: 70%;"> Task </th>
        <th class="text-center" style="width: 10%;"> State </th>
        <th class="text-center" style="width: 10%;"> Actions </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($all_tasks as $task):
        if (!isset($folder)) {
          $task_folder = find_by_id('tasks_folders',$task['folder_id']);
        } ?>
        <tr>
          <td class="text-center"> <?php echo $task['id']; ?></td>
          <td> <b><?php echo $task['task_name'];?> </b>
            <em><?php 
            if (!isset($folder)) {
              if ($task_folder) {
                echo ' (In folder: ';?>
                <a href="tasks.php?id=<?php echo $task['folder_id'];?>"> <?php echo $task_folder['folder_name']; ?></a>
                <?php echo ')';
              }
            } ?></em></td>
          <td class="text-center">
            <?php 
              if($task['state']) { ?>
                <input type="checkbox" class="chcktbl1" name="chcktbl1" data-id="<?php echo $task['id']; ?>" id="chcktbl1" checked>
              <?php } else { ?>
                <input type="checkbox" class="chcktbl1" name="chcktbl1" data-id="<?php echo $task['id']; ?>" id="chcktbl1">
              <?php }?>
          </td>

          <td class="text-center">
            <div class="btn-group">
              <a href="edit_task.php?id=<?php echo (int)$task['id'];?>" class="btn btn-info btn-xs"  title="Edit task" data-toggle="tooltip">
                <span class="glyphicon glyphicon-edit"></span>
              </a>
              <a href="delete_task.php?id=<?php echo (int)$task['id'];?>" class="btn btn-xs btn-danger"  title="Delete task" data-toggle="tooltip" onclick="return confirm('Are you sure you want to delete this task?')">
                <span class="glyphicon glyphicon-trash"></span>
              </a>
            </div>
          </td>
      <?php endforeach; ?>
    </tbody>
  </table>

  <script type="text/javascript">
    $('#tasks').DataTable({ "order": [ 0, "asc" ] });

    $(".chcktbl1").click(function () {  
      var taskTemp_id = $(this).attr("data-id"); 
      var stateTemp = $(this).is(':checked');
      array_p = "task_id=" + taskTemp_id + "&state=" + stateTemp;
      // console.log(array_p);
      $.ajax({  
        type: "POST",
        url: "task_state.php",  
        data: array_p,
        error: function (response) {  
          if (response != 1) {  
            alert("Error!!!!");
            // location.reload();
          }  
        }  
      });  
    });
  </script> 
</div>

<?php include_once('layouts/footer.php'); ?>
