<div class="container">
  <div class="welcome_header">
  </div>
  <div class="staff_portal_information">

  </div>
  <div class="container_first_row">
    <div class="container_first_content">
      <h2>Manually Deactivate</h2>
      <form method="POST" action="confirmDeactivation">
        <table class="app_table">
          <tr>
            <th>ID</th>
          </tr>
          <tr>
            <td><input type="number" name="id" required></td>
          </tr>
        </table>
        <br>
        <input type="submit" name="submit" value="Verify User">
        <p></p>
      </form>
    </div>
  </div>

  <!-- 
  <div class="container_second_row">
    <div class="container_second_content">
      <h2>Not working:</h2>
      <h2>Upload Deactivation</h2>

      <?php //echo form_open_multipart('Home/uploadDeactivation'); 
      ?>

      <form method="POST" enctype="multipart/form-data" action="uploadDeactivation">
        <input type="file" name="userfile" id="file" class="inputfile" onchange="fileName()" />
        <label id="filelabel" for="file">Choose a file</label>
        <input type="text" id="filename" name="filename" hidden>
        <br><br>
        <input type="submit" value="Validate Data">
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