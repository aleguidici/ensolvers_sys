<?php
  require_once('includes/load.php');

  function find_all($table) {
    global $db;
    if(tableExists($table)) {
      return find_by_sql("SELECT * FROM ".$db->escape($table));
    }
  }

  function find_by_sql($sql) {
    global $db;
    $result = $db->query($sql);
    $result_set = $db->while_loop($result);
    return $result_set;
  }

  function find_by_id($table,$id) {
    global $db;
    $id = (int)$id;
    if(tableExists($table)){
      $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE id='{$db->escape($id)}' LIMIT 1");
      if($result = $db->fetch_assoc($sql))
        return $result;
      else
        return null;
    }
  }

  function tableExists($table) {
    global $db;
    $table_exit = $db->query('SHOW TABLES FROM '.DB_NAME.' LIKE "'.$db->escape($table).'"');
    if($table_exit) {
      if($db->num_rows($table_exit) > 0)
        return true;
      else
        return false;
    }
  }

  function authenticate($username='', $password='') {
    global $db;
    $username = $db->escape($username);
    $password = $db->escape($password);
    $sql  = sprintf("SELECT id,username,password FROM users WHERE username ='%s' LIMIT 1", $username);
    $result = $db->query($sql);
    if($db->num_rows($result)){
      $user = $db->fetch_assoc($result);
      $password_request = sha1($password);
      if($password_request === $user['password'] ){
        return $user['id'];
      }
    }
    return false;
  }

  function current_user() {
    static $current_user;
    global $db;
    if(!$current_user){
      if(isset($_SESSION['user_id'])) {
        $user_id = intval($_SESSION['user_id']);
        $current_user = find_by_id('users',$user_id);
      }
    }
    return $current_user;
  }

  function updateLastLogIn($user_id) {
    global $db;
    $date = strftime("%Y-%m-%d %H:%M:%S", time());
    $sql = "UPDATE users SET last_login='{$date}' WHERE id ='{$user_id}' LIMIT 1";
    $result = $db->query($sql);
    return ($result && $db->affected_rows() === 1 ? true : false);
  }

  function edit_task_by_id($table, $task_id, $task_name, $folder_id) {
    global $db;
    if(tableExists($table)) {
      $sql = "UPDATE ".$db->escape($table);
      $sql .= " SET task_name='". $db->escape($task_name);
      if (!($folder_id == "")) { 
        $sql .= "', folder_id=". $db->escape($folder_id); 
      } else { 
        $sql .= "', folder_id= NULL "; 
      }
      $sql .= " WHERE id=". $db->escape($task_id);
      $db->query($sql);
      return ($db->affected_rows() === 1) ? true : false;
    }
  }

  function edit_folder_by_id($table,$folder_id, $folder_name) {
    global $db;
    if(tableExists($table)) {
      $sql = "UPDATE ".$db->escape($table);
      $sql .= " SET folder_name='". $db->escape($folder_name);
      $sql .= "' WHERE id=". $db->escape($folder_id);
      $db->query($sql);
      return ($db->affected_rows() === 1) ? true : false;
    }
  }

  function delete_by_id($table,$id) {
    global $db;
    if(tableExists($table)) {
      $sql = "DELETE FROM ".$db->escape($table);
      $sql .= " WHERE id=". $db->escape($id);
      $sql .= " LIMIT 1";
      $db->query($sql);
      return ($db->affected_rows() === 1) ? true : false;
    }
  }

  function find_tasks_by_folder($folder_id) {
    global $db;
    return find_by_sql("SELECT * FROM tasks WHERE folder_id = '{$db->escape($folder_id)}'");
  }
?>
