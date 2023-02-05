<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="<?php echo base_url('assets/styles.css'); ?>" />
</head>

<body>
  <div class="container">
    <?php
    if ($validation['id'] == '') {
    ?>
      <h3 style="color: black;">No id or username was entered</h3>
    <?php
    }
    ?>
    <?php
    if ($validation['id'] != '') {
    ?>
      <h3 style="color: black;">Employee with the id or username <?php echo $validation['id'] ?> was not found </h3>

    <?php
    }
    ?>
    <br>
  </div>
</body>

</html>