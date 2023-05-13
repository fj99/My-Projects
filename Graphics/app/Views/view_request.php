<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Request</title>
</head>
<?php
$row = $graphics->getRowArray();
$err_msg = "N/A";
// var_dump($row);

if (isset($row["id"])) {
  $id = $row["id"];
} else {
  $id = "Row doesn't exist";
}

if (isset($row["event_title"])) {
  $event_title = $row["event_title"];
  $table = "G";
} else {
  $event_title = "Row doesn't exist";
  $table = "P";
}

if (isset($row["event_date"])) {
  $event_date = $row["event_date"];
} else {
  $event_date = "Row doesn't exist";
}

if (isset($row["event_start_time"])) {
  $event_start_time = $row["event_start_time"];
} else {
  $event_start_time = "Row doesn't exist";
}

if (isset($row["event_end_time"])) {
  $event_end_time = $row["event_end_time"];
} else {
  $event_end_time = "Row doesn't exist";
}
?>

<body>
  <div style="margin:10px 0 0 20px">
    <!-- <a href="../#">Back</a> -->
    <?php
    $session = session();
    // echo "<a href=\"" . $_SESSION['redirect_url'] . "?status=" . $_GET['status'] . "#" . $table . $id . "\">Back</a>";
    echo "<a href=\"" . $session->get('redirect_url') . "?status=" . $_GET['status'] . "#" . $table . $id . "\">Back</a>";
    ?>
    <br>
    <table cellpadding=2px>
      <tr>
        <td>
          <?php
          echo "<p> <b> ID </b>  <br /> " . ($id) . "  </p>";
          ?>
        </td>
        <td>
          <?php
          echo "<p> <b> First Name </b>  <br /> " . (($row["first_name"] != "") ? $row["first_name"] : $err_msg) . "  </p>";
          ?>
        </td>
        <td>
          <?php
          echo "<p> <b> Last Name </b>  <br /> " . (($row["last_name"] != "") ? $row["last_name"] : $err_msg) . "  </p>";
          ?>
        </td>
        <td>
          <?php
          echo "<p> <b> User </b>  <br /> " . (($row["user"] != "") ? $row["user"] : $err_msg) . "  </p>";
          $in = "" . (($row["user"] != "") ? $row["user"] : $err_msg) . "";
          echo '<input type="hidden" value="' . $in . '" id="myInput">';
          ?>
          <button onclick="myFunction()">Copy text</button>
        </td>
        <td>
          <?php
          echo "<p> <b> Primary Contact </b>  <br /> " . (($row["contact_primary"] != "") ? $row["contact_primary"] : $err_msg) . "  </p>";
          ?>
        </td>
      </tr>
      <tr>
        <td>
          <?php
          echo "<p> <b> Event Title </b>  <br /> " . ($event_title) . "  </p>";
          ?>
        </td>
        <td>
          <?php
          echo "<p> <b> Event Date </b>  <br /> " . ($event_date) . "  </p>";
          ?>
        </td>
        <td>
          <?php
          echo "<p> <b> Location </b>  <br /> " . (($row["location"] != "") ? $row["location"] : $err_msg) . "  </p>";
          ?>
        </td>

        <td>
          <?php
          echo "<p> <b> Event Start Time </b>  <br /> " . ($event_start_time) . "  </p>";
          ?>
        </td>
        <td>
          <?php
          echo "<p> <b> Event End Time </b>  <br /> " . ($event_end_time) . "  </p>";
          ?>
        </td>
      </tr>
      <tr>
        <td>
          <?php
          echo "<p> <b> Television Request </b>  <br /> " . (($row["television_request"] != "") ? $row["television_request"] : $err_msg) . "  </p>";
          ?>
        </td>
        <td>
          <?php
          echo "<p> <b> Requested Completion Date </b>  <br /> " . (($row["requested_completion_date"] != "") ? $row["requested_completion_date"] : $err_msg) . "  </p>";
          ?>
        </td>
      </tr>
      <tr>
        <td colspan="5">
          <?php
          echo "<p> <b> Description </b>  <br /> " . (($row["description"] != "") ? $row["description"] : $err_msg) . "  </p>";
          ?>
        </td>
      </tr>
      <tr>
        <td>
          <?php
          echo "<p> <b> Poster Custom Width </b>  <br /> " . (($row["posters_custom_width"] != "") ? $row["posters_custom_width"] : $err_msg) . "  </p>";
          ?>
        </td>
        <td>
          <?php
          echo "<p> <b> Poster Custom Tall </b>  <br /> " . (($row["posters_custom_tall"] != "") ? $row["posters_custom_tall"] : $err_msg) . "  </p>";
          ?>
        </td>
      <tr>
        <td>

          <?php
          echo "<p> <b> Amount Needed (Flyers) </b>  <br /> " . (($row["amount_needed_flyers"] != "") ? $row["amount_needed_flyers"] : $err_msg) . "  </p>";
          ?>
        </td>
        <td>
          <?php
          echo "<p> <b> Flyer Orienation </b>  <br /> " . (($row["flyers_orientation"] != "") ? $row["flyers_orientation"] : $err_msg) . "  </p>";
          ?>
        </td>
        <td>
          <?php
          echo "<p> <b> Amount Requested </b>  <br /> " . (($row["amount_requested"] != "") ? $row["amount_requested"] : $err_msg) . "  </p>";
          ?>
        </td>
      </tr>
      <tr>
        <td>

          <?php
          echo "<p> <b> Date Submitted </b>  <br /> " . (($row["date"] != "") ? $row["date"] : $err_msg) . "  </p>";
          ?>
        </td>
      </tr>
    </table>
    <?php
    echo "<b>View Attachment (If you get 'Forbidden' message, there was no attachment with the request)  </b>";
    echo "<br><br>";
    if ($row["file_name"] != "") {
      $img = base64_encode($row['image']);
      echo '<a href="#" src = "data:image;base64,' . base64_encode($row['image']) . '" download>Download</a>';
    ?>
      <script>
        var img = "<?php $img ?>"
        var a = document.createElement("a"); //Create <a>
        a.href = "data:image/;base64," + img; //Image Base64 Goes here
        a.download = "Image.png"; //File name Here
        a.click(); //Downloaded file
      </script>
    <?php
      echo ($row["file_name"]);
      echo "<br><br>";
      echo '<img src="data:image/;base64,' . base64_encode($row['image']) . '"/>';
      echo "<br><br>";
    } else {
      echo "Forbidden";
    }
    ?>

    <br />

  </div>
</body>
<script>
  function downloadBase64File(contentType, base64Data, fileName) {
    const linkSource = `data:${contentType};base64,${base64Data}`;
    const downloadLink = document.createElement("a");
    downloadLink.href = linkSource;
    downloadLink.download = fileName;
    downloadLink.click();
  }
</script>

</html>