<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staff Administration Portal</title>
  <!-- <link rel="stylesheet" href="assets/styles.css">
  <script src="https://kit.fontawesome.com/48c069f290.js"></script> -->
  <style>
  <?php include 'assets/styles.css'; ?>
  </style>
  <?php
  // echo link_tag('http://scsu-work/SAP/public/assets/styles.css');
  // echo link_tag('http://dev-pubweb06.scsu.southernct.edu/playground/felix/SCSU-Work/SAP/public/assets/styles.css');
  echo script_tag('https://kit.fontawesome.com/48c069f290.js');
  ?>
</head>



<body>
  <div class="topnav" id="navbar">
    <ul>
      <li><a href="home" onclick="navActiveChanger(this)">Home</a></li>
      <li><a href="hireEmployees" onclick="navActiveChanger(this)">Hire</a></li>
      <li><a href="updateEmployees" onclick="navActiveChanger(this)">Update</a></li>
      <li><a href="deactivateEmployees" onclick="navActiveChanger(this)">Deactivate</a></li>
      <li><a href="Hall_Director" onclick="navActiveChanger(this)">Hall Directors</a></li>
      <li><a href="Notifications" onclick="navActiveChanger(this)">Notifications</a></li>

      <li><a href="logout" style="float: right;" onclick="navActiveChanger(this)">Logout</a></li>
      <li><a href="returnToStaffPortal" style="float: right;" onclick="navActiveChanger(this)">Staff Portal</a></li>

      <form id="search" method="Post" action="updateSearch">
        <li><a href="javascript: submitForm()" style="float: right; " onclick="navActiveChanger(this)">Search</a></li>
        <input type="text" placeholder="Search" name="id" style="margin-top: 10px;float: right;padding: 5px;">
      </form>

      <li>
        <a href="viewNotifications" style="float: right; border-right: none;" class="notification">
          <span>
            <!-- <img src="assets/bell2.png" alt=""> -->
            <i class="fas fa-bell"></i>
          </span>
          <?php
          $counter = $notifications->getNumRows();
          ?>
          <span class="badge"><?php echo $counter; ?></span>
          <div class="dropdown-content">
            <a href="#">Link 1</a>
            <a href="#">Link 2</a>
            <a href="#">Link 3</a>
          </div>
        </a>
      </li>

    </ul>
  </div>