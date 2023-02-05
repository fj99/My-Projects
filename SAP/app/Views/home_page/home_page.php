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
          foreach ($notifications->getResult() as $row) {
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
      <form method="POST" action="advancedSearch">
        <input type="text" name="id" placeholder="ID">
        <input type="text" name="username" placeholder="user name">
        <br><br><select name="job_title">
          <option value="">
            Job Drop Down
          </option>
          <option value="7">
            Operations Assistant Intern
          </option>
          <option value="8">
            LLC Intern
          </option>
          <option value="9">
            Programming Intern
          </option>
          <option value="10">
            Computer Programmer
          </option>
          <option value="11">
            Straight Line Hall Director
          </option>
          <option value="12">
            Upperclass Hall Director
          </option>
          <option value="13">
            Graphic Designer
          </option>
          <option value="14">
            University Assistant
          </option>
          <option value="15">
            Grad Intern
          </option>
          <option value="16">
            Residence Life Assistant
          </option>
          <option value="19">
            Resident Advisor
          </option>
          <option value="20">
            Hall Council
          </option>
          <option value="21">
            Residence Hall Association
          </option>
          <option value="22">
            Programming Assistant
          </option>
          <option value="23">
            Desk Attendant
          </option>
          <option value="24">
            Marketing Specialist
          </option>
          <option value="26">
            Operations Assistant
          </option>
          <option value="25">
            Fails
          </option>
        </select>
        <br><br><select id="staff_portal_hall" name="staff_portal_hall">
          <option value="">
            Halls Drop Down
          </option>
          <option value=1>
            Brownell
          </option>
          <option value=2>
            Chase
          </option>
          <option value=3>
            Farnham
          </option>
          <option value=4>
            Hickerson
          </option>
          <option value=5>
            Neff
          </option>
          <option value=6>
            North
          </option>
          <option value=7>
            Schwartz
          </option>
          <option value=8>
            West
          </option>
          <option value=9>
            Wilkinson
          </option>
          <option value=10>
            North Campus Midrise
          </option>
          <option value=11>
            North Campus Townhouses
          </option>
        </select>
        <br><br><select name="active">
          <option value="1">Active</option>
          <option value="0">In-Active</option>
          <option value="">Both</option>
        </select>
        <br><br>
        <input type="Submit" name="submit">
      </form>
    </div>
  </div>
</div>