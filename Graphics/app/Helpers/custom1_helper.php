<?php

if(!function_exists('TVs')){
  function TVs($var){
    if($var == 'true'){
      $tvs = [
        'name' => 'tvs',
        'id'   => 'tvs',
        'value' => 'no',
        'checked'=> $var,
        'style'=> 'margin:10px',
      ];
        
    }else{

      $tvs = [
        'name' => 'tvs',
        'id'   => 'tvs',
        'value' => 'yes',
        'checked'=> $var,
        'style'=> 'margin:10px',
      ];
    }
    
    return $tvs;
  }
}

if(!function_exists('allDay')){
  function allDay($var){
    if($var == 'true'){
      $allDay = [
        'name' => 'allDay',
        'id'   => 'allDay',
        'value' => 'no',
        'checked'=> $var,
        'style'=> 'margin:10px',
      ];
        
    }else{

      $allDay = [
        'name' => 'allDay',
        'id'   => 'allDay',
        'value' => 'yes',
        'checked'=> $var,
        'style'=> 'margin:10px',
      ];
    }
    
    return $allDay;
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
