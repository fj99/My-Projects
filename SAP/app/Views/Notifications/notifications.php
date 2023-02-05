<div class="container">
  <div class="welcome_header">
  </div>
  <div class="staff_portal_information">

  </div>
  <div class="container_first_row">
    <div class="container_first_content">
      <h2>Add New notifications</h2>
      <form method="POST" action="addNotification">
        <table class="app_table">
          <tr>
            <th>Request Type</th>
            <th>Your Username</th>
            <th>Affect</th>
            <th>Comments</th>
            <th>Submit</th>
          </tr>
          <tr>
            <td>
              <select name="request">
                <option value="Hire">Hire</option>
                <option value="update">Update</option>
                <option value="Deactivate">Deactivate</option>
              </select>
            </td>
            <td><input type="text" name="user" required></td>
            <td><input type="text" name="affect" required></td>
            <td><input type="text" name="comments"></td>
            <td><input type="submit" name="Submit"></td>
          </tr>
        </table>
      </form>
      <br>
    </div>
  </div>

  <!-- Where programmers come take job -->
  <div class="container_first_content">
    <h2>Notifications</h2>
    <table class="app_table">
      <tr>
        <th>Submitter</th>
        <th>Request</th>
        <th>Affect</th>
        <th>Comments</th>
        <th>Submit Date</th>
        <th>Assigned to</th>
        <th>affected username</th>
        <th>affected ID</th>
        <th>Completed date</th>
      </tr>
      <tr>
        <?php
        foreach ($Finished_notifications->getResult() as $row) {
          date_default_timezone_set('America/New_York');
          $sub_date = date("m/d/Y", strtotime($row->submit_date));
          $com_date = date("m/d/Y", strtotime($row->complete_date));
        ?>
          <td><?php echo $row->submitter_username ?></td>
          <td><?php echo $row->request_type ?></td>
          <td><?php echo $row->affects ?></td>
          <td><?php echo $row->comments ?></td>
          <td><?php echo $sub_date ?></td>
          <td><?php echo $row->programmer ?></td>
          <td><?php echo $row->affected_username ?></td>
          <td><?php echo $row->affected_id ?></td>
          <td><?php echo $com_date ?></td>
      </tr>
    <?php
        }
    ?>
    </table>
  </div>

</div>