<div class="container">
  <div class="welcome_header">
  </div>
  <div class="staff_portal_information">
  </div>
  <h2>Advanced Search</h2>
  <div class="container_one_row">
    <div class="notification_containers">
      <table class="app_table">
        <tr>
          <th>Id</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Username</th>
          <th>Job Title</th>
          <th>Hall</th>
          <th>Active</th>
        </tr>
        <?php
        $i = 1;
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
            <td><?php echo $row->job_title ?></td>
            <td><?php echo $row->hall_name ?></td>
            <td><?php if ($row->active == 1) {
                  echo "Yes";
                } else {
                  echo "No";
                }  ?></td>
          </tr>
        <?php
          $i++;
        }
        ?>
      </table>
    </div>
  </div>
</div>