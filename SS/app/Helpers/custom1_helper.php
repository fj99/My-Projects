<?php
// How to use helper
// helper("custom1_helper");
// echo FunctionName();

if (!function_exists('open_div')) {
  function open_div()
  {
    return '<div class="attention_div" >' . '<div class="attention_div" >' . '<br>';
  }
}

if (!function_exists('info_div')) {
  function info_div()
  {
    return '<div class="info_top">' . '<div class="inner_info_top">';
  }
}

if (!function_exists('attentionDiv')) {
  function attentionDiv()
  {
    return '<div class="attention_div">' . '<div class="attention_div"> <br>';
  }
}

if (!function_exists('close_div')) {
  function close_div()
  {
    return '<br>' . '<br>' . '</div></div>';
  }
}

if (!function_exists('debug')) {
  function debug($db)
  {
    $query = $db->getLastQuery();
    $last = (string)$query;
    return $last;
  }
}

if (!function_exists('br')) {
  function br($x)
  {
    $break = "";
    for ($i = 0; $i < $x; $i++) {
      $break .= "<br>";
    }
    return $break;
  }
}

if (!function_exists('CheckNorth')) {
  function CheckNorth($id)
  {
    if ($id == 6 || $id == 10 || $id == 11) {
      $hall = ['6', '10', '11'];
    } else {
      $hall = $id;
    }
    return $hall;
  }
}
