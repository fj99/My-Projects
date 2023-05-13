<!DOCTYPE html>
<html>

<head>
  <title>SS</title>
  <link rel="shortcut icon" href=<?php echo base_url('images/reslife_logo.png'); ?> />
  <script type="text/javascript" src=<?php echo base_url('styles/tablesorter/jquery-latest.js'); ?>></script>
  <script type="text/javascript" src=<?php echo base_url('styles/tablesorter/jquery.tablesorter.js'); ?>></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $("#mytable").tablesorter();
    });
  </script>

  <link rel="stylesheet" href=<?php echo base_url('styles/navStyles.css'); ?>>
  <link rel="stylesheet" href=<?php echo base_url('styles/style.css'); ?>>

  <style>
    body {
      /* background-image: url('<?php //echo base_url("images/reslifelogo2.png"); 
                                ?>'); */
      background-size: 146px 67px;
    }
  </style>
</head>

<body>
  <?php
  date_default_timezone_set('America/New_York');
  // if (!defined('BASEPATH')) exit('No direct script access allowed');
  // echo view('nav2');
  // <!-- this contains top navigation bar menu-->
  // Session data needs to be set or create the login functionality
  $session = session();
  $last = $session->get('last_viewed');
  $hallID = $session->get('hallid');
  ?>

  <nav>
    <ul>
      <a href="<?php echo base_url('index.php/home'); ?>">
        <li <?php if ($last == "index") echo "class='active'"; ?>>Home</li>
      </a>
      <a href="<?php echo base_url('index.php/guests'); ?>">
        <li <?php if ($last == "guests") echo "class='active'"; ?>>Guests</li>
      </a>
      <a href="<?php echo base_url('index.php/service'); ?>">
        <li <?php if ($last == "service") echo "class='active'"; ?>>Service</li>
      </a>
      <a href="<?php echo base_url('index.php/package'); ?>">
        <li <?php if ($last == "package") echo "class='active'"; ?>>Package</li>
      </a>
      <?php if ($hallID == 1 || $hallID == 3 || $hallID == 8) { ?>
        <a href="<?php echo base_url('index.php/alcohol'); ?>">
          <li <?php if ($last == "alcohol") echo "class='active'"; ?>>Alcohol</li>
        </a>
      <?php } ?>
      <a href="<?php echo base_url('index.php/Equipment'); ?>">
        <li <?php if ($last == "equipment") echo "class='active'"; ?>>Equipment</li>
      </a>
      <a href="<?php echo base_url('index.php/key'); ?>">
        <li <?php if ($last == "key") echo "class='active'"; ?>>Key Signout</li>
      </a>
      <a href="<?php echo base_url('index.php/clock'); ?>">
        <li <?php if ($last == "timeclock") echo "class='active'"; ?>>Time Clock</li>
      </a>
      <a href="<?php echo base_url('index.php/showFailed'); ?>">
        <li <?php if ($last == "failed") echo "class='active'"; ?>>Fails</li>
      </a>
      <a href="<?php echo base_url('index.php/showBannedList'); ?>">
        <li <?php if ($last == "bannedlist") echo "class='active'"; ?>>Banned List</li>
      </a>
      <a href="<?php echo base_url('index.php/support'); ?>">
        <li <?php if ($last == "support") echo "class='active'"; ?>>Support</li>
      </a>
    </ul>
  </nav>
  <br>