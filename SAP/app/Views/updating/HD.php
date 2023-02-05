<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HD</title>
</head>

<body>
  <div class="container">
    <div class="welcome_header">
    </div>
    <div class="staff_portal_information">
    </div>
    <h2>View all Hall Directors</h2>
    <div class="container_one_row">
      <div class="notification_containers">
        <table class="app_table">
          <tr>
            <th>Id</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Username</th>
            <th>Hall</th>
            <th>Remove</th>
          </tr>
          <?php
          $i = 1;
          $x = 20;
          foreach ($search->getResult() as $row) {
            date_default_timezone_set('America/New_York');
          ?>
            <tr>
              <td>
                <form method="Post" action="updateSearch">
                  <input type="text" name="id" value="<?php echo $row->id ?>" hidden>
                  <input type="Submit" class="searchID" name="submit" id="submit<?php echo $i ?>" value="<?php echo $row->id ?>" hidden>
                  <label for="submit<?php echo $i ?>" class="searchID"><?php echo $row->id ?></label>
                </form>
              </td>
              <td><?php echo $row->first_name ?></td>
              <td><?php echo $row->last_name ?></td>
              <td><?php echo $row->username ?></td>
              <td>
                <?php echo $row->hall_name ?>
              </td>
              <td>
                <form method="POST" action="RemoveHD">
                  <input type="text" name="id" value="<?php echo $row->id ?>" hidden>
                  <input type="Submit" class="searchID" name="submit" id="submit<?php echo $x ?>" value="<?php echo $row->id ?>" hidden>
                  <label for="submit<?php echo $x ?>" class="searchID">Remove HD</label>
                </form>
              </td>
            </tr>
          <?php
            $i++;
            $x++;
          }
          ?>
        </table>
      </div>
    </div>
  </div>
</body>

</html>