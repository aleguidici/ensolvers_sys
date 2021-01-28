<?php
  $errors = array();

  // Remove html characters
  function remove_junk($str){
    $str = nl2br($str);
    $str = htmlspecialchars(strip_tags($str, ENT_QUOTES));
    return $str;
  }
  
  // Uppercase first character
  function first_character($str){
    $val = str_replace('-'," ",$str);
    $val = ucfirst($val);
    return $val;
  }

  // Check input fields not empty
  function validate_fields($var){
    global $errors;
    foreach ($var as $field) {
      $val = remove_junk($_POST[$field]);
      if(isset($val) && $val==''){
        $errors = $field ." cannot be empty.";
        return $errors;
      }
    }
  }

  // Display Session Message
  function display_msg($msg ='') {
    $output = array();
    if(!empty($msg)) {
      foreach ($msg as $key => $value) {
        $output  = "<div class=\"alert alert-{$key}\">";
        $output .= "<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>";
        $output .= remove_junk(first_character($value));
        $output .= "</div>";
      }
      return $output;
    } else {
      return "" ;
    }
  }

  // Function for redirect
  function redirect($url, $permanent = false) {
    if (headers_sent() === false) {
      header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }
    exit();
  }
?>
