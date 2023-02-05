<div class="container">
  <div class="welcome_header">
  </div>
  <div class="staff_portal_information">

  </div>
  <div class="container_first_content">
    <h2>Notifications</h2>
    <table class="app_table">
      <tr>
        <th>Request</th>
        <th>Affect</th>
        <th>Comments</th>
        <th>Submit Date</th>
        <th>Assigned to</th>
        <th>affected username</th>
        <th>affected ID</th>
        <th>Completed</th>
      </tr>
      <?php
      foreach ($notifications->getResult() as $row) {
        date_default_timezone_set('America/New_York');
        $date = date("m/d/Y", strtotime($row->submit_date))
      ?>
        <form method="POST" action="closeNotification">
          <tr>
            <input type="text" name="id" value=<?php echo $row->notification_id ?> hidden>
            <td><?php echo $row->request_type ?></td>
            <td><?php echo $row->affects ?></td>
            <td><?php echo $row->comments ?></td>
            <td><?php echo $date ?></td>
            <td>
              <select name="user">
                <?php
                foreach ($users->getResult() as $row) {
                ?>
                  <option value=<?php echo $row->username ?>><?php echo $row->first_name ?></option>
                <?php
                }
                ?>
              </select>
            </td>
            <td><input type="text" name="affected_username" required></td>
            <td><input type="number" name="affected_id" required></td>
            <td><input type="submit" name="Submit"></td>
          </tr>
        </form>
      <?php
      }
      ?>
    </table>
    <br>
  </div>
</div>