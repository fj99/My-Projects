<?php
helper("custom1_helper");
echo info_div();
br(2);
?>

<table width='80%' style="text-align:center;">
  <tr>
    <td>
      <?php //echo view("clock/staffFinder"); 
      ?>
      <?php
      echo form_open('/staff');
      ?>
      <table>
        <br>
        <tr>
          <td>Staff ID</td>
          <td><input type="number" name="staffId" placeholder="Enter Staff ID" onClick="this.select();" autocomplete="off" required /></td>
          <td></td>
          <td><input type="submit" class="button" value="Look up" /></td>
        </tr>
      </table>
      <?php
      echo form_close();
      ?>
    </td>
  </tr>

  <?php
  if (isset($data)) {
    br(2);
    echo attentionDiv();
    echo $data;
    echo close_div();
  }
  echo form_open('/clockIn');
  ?>
  <tr>
    <td><?php //$this->load->view('clock/staffInfo');
        if (isset($query)) { //If query exists
          br(10);
          $mime = null;
          $image = "data:" . $mime . ";base64," . base64_encode($query['img']);
        ?>

        <table>
          <tr>
            <td style="vertical-align: top;">

              <table>
                <tr>
                  <td>Staff ID</td>
                  <td><input value="<?php echo $query['id']; ?>" type="text" name="staffId" placeholder="" onClick="this.select();" readonly /></td>
                </tr>

                <tr>
                  <td>First name</td>
                  <td><input value="<?php echo $query['fname']; ?>" type="text" name="first_name" placeholder="" readonly /></td>

                </tr>
                <tr>
                  <td>Last name</td>
                  <td><input value="<?php echo $query['lname']; ?>" type="text" name="last_name" placeholder="" readonly /></td>
                </tr>
              </table>
            </td style="vertical-align: middle;">
            <td><?php echo '<img class = "id_img" src="data:image/jpeg;base64,' . base64_encode($query['img']) . '"/>'; ?></td>
            <!-- <td><?php '<img src="' . img('clock_image') . '" size="250" height="250" alt="" />'; ?></td> -->
          </tr>
        </table>
      <?php
        } //end if query exsists
      ?>
    </td>
  </tr>
</table>

<?php
if (isset($query)) {
  echo br(2); ?>
  <p width="100%" style="text-align:right;">
    <input class="button_guest" type="submit" value="Clock In/Out" />
  </p>
<?php } //end of isset query
echo form_close();
echo close_div();
?>