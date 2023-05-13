<div class="container">
  <div class="welcome_header">
  </div>
  <div class="staff_portal_information">
  </div>
  <div class="container_home_row">
    <div class="container_first_left">
      <?php
      $counter = $notifications->getNumRows();
      if ($counter != 0) {
      ?>
        <h2>Notifications</h2>
        <table class="app_table">
          <tr>
            <!-- <th>ID</th> -->
            <th>Affects</th>
            <th>Request Type</th>
            <th>Submit Date</th>
          </tr>
          <?php
          $i = 1;
          foreach ($notifications->getResult() as $row) 
          {
            date_default_timezone_set('America/New_York');
            $date = date("m/d/Y", strtotime($row->submit_date))
          ?>
            <tr>
              <!-- <td><?php echo $row->notification_id ?></td> -->
              <td><?php echo $row->affects ?></td>
              <td><?php echo $row->request_type ?></td>
              <td><?php echo $date ?></td>
            </tr>
          <?php
            $i++;
          }
          } else {
          ?>
          <h2>No Notifications</h2>
          <?php
          }
          ?>
        </table>
    </div>

    <div class="container_first_right">
      <h2>Advanced Search</h2>
      <?php
        echo form_open("advancedSearch");        
        echo form_input($id);
        echo form_input($user);
        echo "<br> <br>";
        echo form_dropdown($job_title[0], $job_title[1]);
        echo "<br> <br>";
        echo form_dropdown($halls[0], $halls[1], 'id="staff_portal_hall"');
        echo "<br> <br>";
        echo form_dropdown($active[0],$active[1]);
        echo "<br> <br>";
        echo form_submit("submit","submit");
        echo form_close();
      ?>
    </div>
  </div>
</div>