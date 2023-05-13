<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Check Out Key</title>
</head>
<style>
  .centered_table {
    background-color: #fff;
    vertical-align: middle;
  }
</style>

<body>
  <?= form_open('index'); ?>
  <div class="centered_table">

    <?php

    echo form_label($studentId[1]['label']) . form_input($studentId[0]) . '<br><br>';
    echo form_label($first_name[1]['label']) . form_input($first_name[0]) . '<br><br>';
    echo form_label($last_name[1]['label']) . form_input($last_name[0]) . '<br><br>';
    echo form_label($email[1]['label']) . form_input($email[0]) . '<br><br>';
    echo form_label($hall[1]['label']) . form_input($hall[0]) . '<br><br>';
    echo form_label($room[1]['label']) . form_input($room[0]) . '<br><br>';
    echo form_label($key[1]['label']) . form_input($key[0]) . '<br><br>';
    echo form_label($staff[1]['label']) . form_input($staff[0]) . '<br><br>';
    echo form_submit($checkOut_button);

    ?>
    <?= form_close() ?>
  </div>

  <?php
  if ($session->get('student_image') and $session->get('student_image') != "clean") {
    echo '<img class = "id_img" src="data:image/jpeg;base64,' . base64_encode($session->get('student_image')) . '"/>';
  } else {
    echo '<img src="https://scsuowls.com/images/2020/1/24/logo_for_website.jpg?width=1416&height=797&mode=crop&quality=80&format=jpg" height="100px;" style="border-radius: 50%;">';
  }
  ?>


</body>

</html>