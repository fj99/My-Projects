<!doctype html>
<html lang="en">

<head>
  <title>Graphics Portal</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- <link rel="stylesheet" href="style/portal.css"> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>

<style>
  <?php
  include 'style/styling.php';
  ?>
</style>
<?php
$self = $_SERVER['PHP_SELF'];
$_SESSION['redirect_url'] = $_SERVER['PHP_SELF'];

if (isset($_GET['status'])) {
  $status = $_GET['status'];
} else {
  $status = 'Incomplete';
}

if (isset($_GET['email'])) {
  $email = $_GET['email'];
} else {
  $email = 'none';
}
?>

<body>
  <section class="ftco-section">
    <!-- <br> -->
    <div style="margin:10px 0 0 10px">

      Status Filter <br>
      <a href="?status=Incomplete">Incomplete |</a>
      <a href="?status=Denied">Denied |</a>
      <a href="?status=Complete">Complete</a>
      <br>
      Pages<br>
      <?php
      for ($pageNumber = 1; $pageNumber <= 10; $pageNumber += 1) {
        echo ("<a href='?page=$pageNumber&status=$status'>$pageNumber</a> | ");
      }
      ?>
      <br>
      Designer Filter <br>
      <?php
      foreach ($designers->getResult() as $row) {
        $name =  $row->name;
        echo "<a href='?designer=$name&status=Complete'> $name |</a>";
      }
      ?>
      <a href="?designer=Unassigned&status=Complete">Unassigned</a>

    </div>
    <?php
    echo "<div style=\"font-weight:bold;margin:7px 0 7px 10px;width:160px;text-align:center;background-color:#FF3333;color:black\">Red = Denied</div>\n";
    echo "<div style=\"font-weight:bold;margin:7px 0 7px 10px;width:160px;text-align:center;background-color:#0099FF;color:black\">Blue = Incomplete</div>\n";
    echo "<div style=\"font-weight:bold;margin:7px 0 7px 10px;width:160px;text-align:center;background-color:#339966;color:black\">Green = Completed</div>\n";
    ?>

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 text-center mb-5">
          <h2 class="heading-section">Graphic Portal</h2>
        </div>
      </div>
      <h4 class="text-center mb-4" onclick="myFunction('card')">Graphics request</h4>
      <div id="Head" class="table-wrap fixTableHead">
        <table class="table">
          <thead class="thead-primary">
            <tr>
              <th>View</th>
              <th onmouseover="mouseOver(1)" onmouseout="mouseOut(1)" onclick="Sort('id')">
                <p class="popuptext" id="myPopup1">Sort by Clicking</p>
                ID
              </th>
              <th onmouseover="mouseOver(2)" onmouseout="mouseOut(2)" onclick="Sort('first_name')">
                <p class="popuptext" id="myPopup2">Sort by Clicking</p>
                First Name
              </th>
              <th onmouseover="mouseOver(3)" onmouseout="mouseOut(3)" onclick="Sort('last_name')">
                <p class="popuptext" id="myPopup3">Sort by Clicking</p>
                Last Name
              </th>
              <th onmouseover="mouseOver(4)" onmouseout="mouseOut(4)" onclick="Sort('user')">
                <p class="popuptext" id="myPopup4">Sort by Clicking</p>
                User
              </th>
              <th onmouseover="mouseOver(5)" onmouseout="mouseOut(5)" onclick="Sort('date')">
                <p class="popuptext" id="myPopup5">Sort by Clicking</p>
                Date Submitted
              </th>
              <th onmouseover="mouseOver(6)" onmouseout="mouseOut(6)" onclick="Sort('requested_completion_date')">
                <p class="popuptext" id="myPopup6">Sort by Clicking</p>
                Deadline
              </th>
              <th onmouseover="mouseOver(7)" onmouseout="mouseOut(7)" onclick="Sort('completed_date')">
                <p class="popuptext" id="myPopup7">Sort by Clicking</p>
                Date Completed
              </th>
              <th onmouseover="mouseOver(8)" onmouseout="mouseOut(8)" onclick="Sort('assigned_to')">
                <p class="popuptext" id="myPopup8">Sort by Clicking</p>
                Assigned To
              </th>
              <th onmouseover="mouseOver(9)" onmouseout="mouseOut(9)" onclick="Sort('req_status')">
                <p class="popuptext" id="myPopup9">Sort by Clicking</p>
                Request Status
              </th>
              <th onmouseover="mouseOver(10)" onmouseout="mouseOut(10)" onclick="Sort('complete')">
                <p class="popuptext" id="myPopup10">Sort by Clicking</p>
                Completed
              </th>
            </tr>
          </thead>

          <tbody id="card">
            <?php
            $counter = 0;
            $sec_counter = 100;
            foreach ($graphics->getResult() as $row) {
              $counter += 1;
              $sec_counter += 1;
              $id = $row->id;
              $gid = "G" . $id;
              $fname = $row->first_name;
              $lname = $row->last_name;
              $user = $row->user;
              $date = $row->date;
              $deadline = $row->requested_completion_date;
              $comp_date = $row->completed_date;
              $assigned_to = $row->assigned_to;
              $comment = $row->comments;
              $req_status = $row->req_status;
              $complete = $row->complete;
              $reason = $row->reason;

              echo "<tr id=$gid>";
              echo "<td><a href='Gview/$id?status=$status' target='_blank'>Click Here</a></td>";
              echo "<td>$id</td>";
              echo "<td>$fname</td>";
              echo "<td>$lname</td>";
              echo "<td>$user</td>";
              echo "<td>$date</td>";
              echo "<td>$deadline</td>";
              echo "<td>$comp_date</td>";
            ?>

              <!-- Assigned to form -->
              <td>
                <form action="assignedTo" method="post">
                  <select name="assigned_to">
                    <option value="default">--Select A Designer--</option>
                    <?php
                    foreach ($designers->getResult() as $row) {
                      $name =  $row->name;
                      $option = "<option name='$name' value='$name'";
                      if ($assigned_to == $name) {
                        $option .= "selected='selected'";
                      }
                      $option .= ">$name </option>";
                      echo $option;
                    }
                    ?>
                  </select>
                  <input type="hidden" VALUE="<?php echo $id; ?>" NAME="id" />
                  <input type="hidden" VALUE="<?php echo $status; ?>" NAME="status" />
                  <input type="submit" VALUE="Submit">
                </form>
              </td>

              <!-- Request status form -->
              <td>
                <form action="requestStatus" method="post">
                  <label for="comment">Comments</label>
                  <br>
                  <textarea name="comment" id="comment" cols="10" rows="4"><?php echo ($comment) ?></textarea>
                  <br>
                  <select name="req_status">
                    <option value="default">--Select--</option>
                    <option name="Missing Details" value="Missing Details" <?php if ($req_status == 'Missing Details') echo "selected=\"selected\""; ?>>Missing Details </option>
                    <option name="Awaiting Response" value="Awaiting Response" <?php if ($req_status == 'Awaiting Response') echo "selected=\"selected\""; ?>>Awaiting Response </option>
                    <option name="In Progress" value="In Progress" <?php if ($req_status == 'In Progress') echo "selected=\"selected\""; ?>>In Progress </option>
                    <option name="Ready to Print" value="Ready to Print" <?php if ($req_status == 'Ready to Print') echo "selected=\"selected\""; ?>>Ready to Print </option>
                  </select>
                  <input type="hidden" VALUE="<?php echo $id; ?>" NAME="id" />
                  <input type="hidden" VALUE="<?php echo $status; ?>" NAME="status" />
                  <input type=SUBMIT VALUE="Submit">
                </form>
              </td>

              <!-- Completed form -->
              <td>
                <form action="Completed" method="post">
                  <select name="complete" id=<?php echo $counter; ?>>
                    <option value="default">--Select--</option>
                    <option name="Yes" value="Yes" <?php if ($complete == 'Yes') echo "selected=\"selected\""; ?>>Yes </option>
                    <option name="Denied" value="Denied" <?php if ($complete == 'Denied') echo "selected=\"selected\""; ?>>Denied </option>
                  </select>
                  <div id=<?php echo $sec_counter; ?> style="visibility: hidden;">
                    <label for="reason">Enter the reason for denying request:</label>
                    <textarea name="reason" id="reason" cols="10" rows="4"><?php echo ($reason) ?></textarea>
                  </div>
                  <input type="hidden" VALUE="<?php echo $id; ?>" NAME="id" />
                  <input type="hidden" VALUE="<?php echo $status; ?>" NAME="status" />
                  <?php
                  if ($assigned_to != "default" and $assigned_to != " ") {
                    echo ('<input type=SUBMIT VALUE="Submit" onclick="emailAlert($email)" />');
                    // <input type=SUBMIT VALUE="Submit" onclick="emailAlert(<? php echo $email ? >)" /> 
                  }
                  ?>
                </form>

                <script>
                  var el<?php echo $counter ?> = document.getElementById(<?php echo $counter ?>);

                  var box<?php echo $sec_counter ?> = document.getElementById(<?php echo $sec_counter ?>);
                  // const box = document.getElementById('reason');
                  var status = "<?php print($status) ?>";
                  if (status == "Denied") {
                    box<?php echo $sec_counter ?>.style.visibility = 'visible';
                  }

                  function emailAlert(email) {
                    if (email) {
                      alert("Email sent successfully.");
                    } else {
                      alert("Email failed to send.");
                    }
                  }
                  el<?php echo $counter ?>.addEventListener('change', function handleChange(event) {
                    if (event.target.value == 'Denied') {
                      box<?php echo $sec_counter ?>.style.visibility = 'visible';
                    } else {
                      box<?php echo $sec_counter ?>.style.visibility = 'hidden';
                    }
                  });
                </script>
              </td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
      <div>
        <br><br><br>Pages<br>
        <?php
        for ($pageNumber = 1; $pageNumber <= 10; $pageNumber += 1) {
          echo ("<a href='?page=$pageNumber&status=$status'>$pageNumber</a> | ");
        }
        ?>
      </div>
      <div>
        <h4 class="text-center mb-4" onclick="myFunction('form')">Printing Request</h4>
        <div class="table-wrap fixTableHead">
          <table class="table">
            <thead class="thead-primary">
              <tr>
                <th>View</th>
                <th onmouseover="mouseOver(20)" onmouseout="mouseOut(20)" onclick="Sort('id')">
                  <p class="popuptext" id="myPopup20">Sort by Clicking</p>
                  ID
                </th>
                <th onmouseover="mouseOver(21)" onmouseout="mouseOut(21)" onclick="Sort('first_name')">
                  <p class="popuptext" id="myPopup21">Sort by Clicking</p>
                  First Name
                </th>
                <th onmouseover="mouseOver(22)" onmouseout="mouseOut(22)" onclick="Sort('last_name')">
                  <p class="popuptext" id="myPopup22">Sort by Clicking</p>
                  Last Name
                </th>
                <th onmouseover="mouseOver(23)" onmouseout="mouseOut(23)" onclick="Sort('user')">
                  <p class="popuptext" id="myPopup23">Sort by Clicking</p>
                  User
                </th>
                <th onmouseover="mouseOver(24)" onmouseout="mouseOut(24)" onclick="Sort('date')">
                  <p class="popuptext" id="myPopup24">Sort by Clicking</p>
                  Date Submitted
                </th>
                <th onmouseover="mouseOver(25)" onmouseout="mouseOut(25)" onclick="Sort('requested_deadline')">
                  <p class="popuptext" id="myPopup25">Sort by Clicking</p>
                  Deadline
                </th>
                <th onmouseover="mouseOver(26)" onmouseout="mouseOut(26)" onclick="Sort('completion_date')">
                  <p class="popuptext" id="myPopup26">Sort by Clicking</p>
                  Date Completed
                </th>
                <th onmouseover="mouseOver(27)" onmouseout="mouseOut(27)" onclick="Sort('assigned_to')">
                  <p class="popuptext" id="myPopup27">Sort by Clicking</p>
                  Assigned To
                </th>
                <th onmouseover="mouseOver(28)" onmouseout="mouseOut(28)" onclick="Sort('request_status')">
                  <p class="popuptext" id="myPopup28">Sort by Clicking</p>
                  Request Status
                </th>
                <th onmouseover="mouseOver(29)" onmouseout="mouseOut(29)" onclick="Sort('completed_accepted_or_denied')">
                  <p class="popuptext" id="myPopup29">Sort by Clicking</p>
                  Completed
                </th>
              </tr>
            </thead>

            <tbody id="form">
              <?php
              foreach ($printing->getResult() as $row2) {
                $id = $row2->id;
                $pid = "P" . $id;
                $fname = $row2->first_name;
                $lname = $row2->last_name;
                $user = $row2->user;
                $date = $row2->date;
                $deadline = $row2->requested_completion_date;
                //$deadline = $row2->requested_deadline; //originally was $deadline = $row2->requested_completion_date;
                $comp_date = $row2->completed_date;
                $assigned_to = $row2->assigned_to;
                $comment = $row2->comments;
                $req_status = $row2->req_status;
                $complete = $row2->complete;
                // $reason = $row2->reason; 
                // $comp_status = $row2->completed_accepted_or_denied;

                echo "<tr id=$pid>";
                echo "<td><a href='Pview/$id?status=$status' target='_blank'>Click Here</a></td>";
                // echo "<td><a href='Pview/$id?status=$status'>Click Here</a></td>";
                echo "<td>$id</td>";
                echo "<td>$fname</td>";
                echo "<td>$lname</td>";
                echo "<td>$user</td>";
                echo "<td>$date</td>";
                echo "<td>$deadline</td>";
                echo "<td>$comp_date</td>";
                // echo "<td>$assigned_to</td>";
                // echo "<td>$req_status</td>";
                // echo "<td>$comp_status";
                // echo "</tr>";
              ?>

                <!-- Assigned to -->
                <td>
                  <form action="P_assignedTo" method="post">
                    <select name="assigned_to">
                      <option value="default">--Select A Designer--</option>
                      <?php
                      foreach ($designers->getResult() as $row2) {
                        $name =  $row2->name;
                        $option = "<option name='$name' value='$name'";
                        if ($assigned_to == $name) {
                          $option .= "selected='selected'";
                        }
                        $option .= ">$name </option>";
                        echo $option;
                      }
                      ?>
                    </select>

                    <input type="hidden" VALUE="<?php echo $id; ?>" NAME="id" />
                    <input type="hidden" VALUE="<?php echo $status; ?>" NAME="status" />
                    <input type="submit" VALUE="Submit">
                  </form>
                </td>

                <!-- Request status -->
                <td>
                  <form action="P_requestStatus" method="post">
                    <label for="comment">Comments</label>
                    <br>
                    <textarea name="comment" id="comment" cols="10" rows="4"><?php echo ($comment) ?></textarea>
                    <br>
                    <select name="req_status">
                      <option value="default">--Select--</option>
                      <option name="Missing Details" value="Missing Details" <?php if ($req_status == 'Missing Details') echo "selected=\"selected\""; ?>>Missing Details </option>
                      <option name="Awaiting Response" value="Awaiting Response" <?php if ($req_status == 'Awaiting Response') echo "selected=\"selected\""; ?>>Awaiting Response </option>
                      <option name="In Progress" value="In Progress" <?php if ($req_status == 'In Progress') echo "selected=\"selected\""; ?>>In Progress </option>
                      <option name="Ready to Print" value="Ready to Print" <?php if ($req_status == 'Ready to Print') echo "selected=\"selected\""; ?>>Ready to Print </option>
                    </select>
                    <input type="hidden" VALUE="<?php echo $id; ?>" NAME="id" />
                    <input type="hidden" VALUE="<?php echo $status; ?>" NAME="status" />
                    <input type=SUBMIT VALUE="Submit">
                  </form>
                </td>

                <!-- Completed -->
                <td>
                  <form action="P_Completed" method="post">
                    <select name="complete" id=<?php echo $counter; ?>>
                      <option value="default">--Select--</option>
                      <option name="Yes" value="Yes" <?php if ($complete == 'Yes') echo "selected=\"selected\""; ?>>Yes </option>
                      <option name="Denied" value="Denied" <?php if ($complete == 'Denied') echo "selected=\"selected\""; ?>>Denied </option>
                    </select>
                    <!-- <div id=<php echo $sec_counter; ?> style="visibility: hidden;">
                    <label for="reason">Enter the reason for denying request:</label>
                    <textarea name="reason" id="reason" cols="10" rows="4"><php echo($reason) ?></textarea>
                  </div> -->
                    <input type="hidden" VALUE="<?php echo $id; ?>" NAME="id" />
                    <input type="hidden" VALUE="<?php echo $status; ?>" NAME="status" />
                    <?php
                    if ($assigned_to != "default" and $assigned_to != " ") {
                      echo ('<input type=SUBMIT VALUE="Submit" onclick="emailAlert($email)" />');
                    }
                    ?>
                  </form>
                </td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
        <br><br><br>Pages<br>
        <?php
        for ($pageNumber = 1; $pageNumber <= 10; $pageNumber += 1) {
          echo ("<a href='?page=$pageNumber&status=$status'>$pageNumber</a> | ");
        }
        ?>
      </div>
  </section>
  <br> <br> <br> <br>

  <script>
    function mouseOver(x) {
      var input = "myPopup" + x;
      // alert(input);
      var popup = document.getElementById(input);
      popup.classList.toggle("show");
      // popup.style.visibility = "none";
    }

    function mouseOut(x) {
      var input = "myPopup" + x;
      var popup = document.getElementById(input);
      // popup.style.visibility = "hidden";
      popup.classList.toggle("show");
    }

    function myFunction(x) {
      var tbody = document.getElementById(x);
      var pdiv = document.getElementById("Head");
      // var menu = document.getElementById("menu");
      if (tbody.style.display == 'none') {
        tbody.style.display = '';
        pdiv.style.maxHeight = '50em%';
        // menu.innerHTML = "^";
      } else {
        tbody.style.display = 'none';
        pdiv.style.height = 'auto';
        // menu.innerHTML = "v";
      }
    }

    function Sort(x) {
      var url = location.href.substring(location.href.lastIndexOf('/') + 1).replace(/#\w\d{1,}/, "");
      var end = url.lastIndexOf("sort");
      if (end == -1) {
        end = url.length;
      }
      var check = "";
      if (url.includes("ASC")) {
        check = "ASC";
      } else if (url.includes("DESC")) {
        check = "DESC";
      }
      url = url.slice(0, end);
      var last = url.charAt(end - 1);
      if (!url.includes("?")) {
        url = url.concat("?");
      } else if (last != '&') {
        url = url.concat("&");
      }
      if (check == "ASC") {
        var sort = url + "sort=DESC&order=" + x;
      } else if (check == "DESC") {
        var sort = url + "sort=ASC&order=" + x;
      } else {
        var sort = url + "sort=ASC&order=" + x;
      }
      // alert(status);
      window.open(sort, "_self");
    }
  </script>

  <!-- <script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script> -->

</body>

</html>