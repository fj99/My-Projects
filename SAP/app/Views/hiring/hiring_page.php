<div class="container">
  <div class="welcome_header">
  </div>
  <div class="staff_portal_information">

  </div>
  <div class="container_first_row">
    <div class="container_first_content">
      <h2>Manually Hire</h2>
      <form method="POST" action="manualHireEmployees">
        <table class="app_table">
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Hall</th>
            <th>Job</th>
            <th>Submit</th>

          </tr>
          <tr>
            <td><input type="number" name="id" required></td>
            <td><input type="text" name="username" required></td>
            <td><input type="text" name="first_name" required></td>
            <td><input type="text" name="last_name" required></td>
            <td>
              <select id="staff_portal_hall" name="staff_portal_hall" required onchange="setHall()">
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
            </td>
            <td>
              <select name="job" required>
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
              </select>
            </td>
            <input type="number" name="program_portal_hall" value=7 hidden required>
            <td><input type="submit" name="Submit"></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
  <!-- 
  <div class="container_second_row">
    <div class="container_second_content">
      <h2>This is not working:</h2>
      <h2>Upload Hire</h2>
      <?php //echo form_open_multipart('Administrator/uploadHiring'); 
      ?>

      <form method="POST" enctype="multipart/form-data" action="uploadHiring">
        <input type="file" name="userfile" id="file" class="inputfile" onchange="fileName()" />
        <label id="filelabel" for="file">Choose a file</label>
        <input type="text" id="filename" name="filename" hidden>
        <br><br>
        <input type="submit" value="Submit">
      </form>
      <br><Br>
      <form method="POST" action="downloadTemplate">
        <input type="submit" value="Download Template Excel File">
      </form>
    </div>
  </div>
  -->
  <script type="text/javascript">
    function fileName() {
      var filelabel = document.getElementById('filelabel');
      var file = document.getElementById('file');
      var filename = document.getElementById('filename');
      var e = file.value.toString().split('fakepath').pop();
      e = e.slice(1)
      if (e != "") {
        filelabel.innerHTML = e;
        filename.value = e;
      } else {
        filelabel.innerHTML = 'Choose a File';
        filename.value = e;
      }

    }
  </script>
</div>