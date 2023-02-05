<div class="container">
  <div class="welcome_header">
  </div>
  <div class="staff_portal_information">

  </div>
  <div class="container_one_row">
    <div class="container_first_content">
      <h2>Manually Deactivate</h2>
      <form method="POST" action="manualDeactivateEmployees">
        <table class="app_table">
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Job Title</th>
            <th>Hall</th>
            <th>Active</th>
          </tr>
          <tr>
            <td><?php echo $validation['id'] ?></td>
            <td><?php echo $validation['username'] ?></td>
            <td><?php echo $validation['first_name'] ?></td>
            <td><?php echo $validation['last_name'] ?></td>
            <td><?php echo $validation['job_title'] ?></td>
            <td><?php echo $validation['hall'] ?></td>

            <?php
            if ($validation['active'] == 1) {
            ?>
              <td>
              <?php
              echo "Yes";
            } else {
              ?>
              <td style="background-color: yellow;">
              <?php
              echo "No";
            }
              ?>

              </td>
          </tr>
        </table>
        <br>
        <p style="background-color: yellow; width: fit-content; margin: auto;">Confirm that these are the correct people to deactivate</p>
        <br>
        <input type="number" name="id" value="<?php echo $validation['id'] ?>" hidden>
        <input type="text" name="username" value="<?php echo $validation['username'] ?>" hidden>
        <input type="text" name="first_name" value="<?php echo $validation['first_name'] ?>" hidden>
        <input type="text" name="job_title" value="<?php echo $validation['job_title'] ?>" hidden>
        <input type="submit" name="Submit">
      </form>
    </div>
  </div>
</div>/* Validating the user's ID. If the user's ID is valid, it will return a failure
page. If the user's ID is invalid, it will return a confirmation page. */