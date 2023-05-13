<!doctype html>
<html lang="en">

<head>
  <title>OA Portal</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- <link rel="stylesheet" href="style/portal.css"> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>

<style>
  <?php include 'styles/styling.php'?>
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
    <!-- <div class="row justify-content-center">
      <div class="col-md-6 text-center mb-5">
        <h1 class="heading-section">OA Portal</h1>
      </div> -->
    <div style="margin:10px 0 0 10px">

      <h1 class="heading-section">OA Portal</h1>

      Status Filter <br>
      <a href="?status=Denied">Denied |</a>
      <a href="?status=Incomplete">Incomplete |</a>
      <a href="?status=Student Unavailable">Student Unavailable |</a>
      <a href="?status=no response">no response |</a>
      <a href="?status=see comments">see comments |</a>
      <a href="?status=delivered">delivered |</a>
      <a href="?status=Complete">Complete |</a>
      <br>
      Priority Filter <br>
      <a href="?priority=vital">vital |</a>
      <a href="?priority=very_high">very high |</a>
      <a href="?priority=high">high |</a>
      <a href="?priority=medium">medium |</a>
      <a href="?priority=low">low |</a>
      <a href="?priority=very_low">very low |</a>
      <br>
      OA Filter <br>
      <?php
      foreach ($oas->getResult() as $row) {
        $name =  $row->name;
        echo "<a href='?designer=$name'> $name |</a>";
      }
      ?>
      <a href="?designer=Unassigned">Unassigned</a>
      <br>
      Requested Completion Date Filter <br>
      <a href="?closest=true">Closest |</a>
      <a href="?farthest=true">Farthest |</a>
      <br>
      Pages<br>
      <?php
      for ($pageNumber = 1; $pageNumber <= 10; $pageNumber+=1) {
        echo("<a href='?page=$pageNumber&status=$status'>$pageNumber</a> | ");
      }
      ?>
    </div>
    <?php
    echo "<div style=\"font-weight:bold;margin:7px 0 7px 10px;width:160px;text-align:center;background-color:#FF3333;color:black\">Red = Denied</div>\n";
    echo "<div style=\"font-weight:bold;margin:7px 0 7px 10px;width:160px;text-align:center;background-color:#0099FF;color:black\">Blue = Incomplete</div>\n";
    echo "<div style=\"font-weight:bold;margin:7px 0 7px 10px;width:160px;text-align:center;background-color:#339966;color:black\">Green = Completed</div>\n";
    ?>

    <div class="container">
      
      <h4 class="text-center mb-4" onclick="myFunction('card')">OA Request</h4>
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
              <th onmouseover="mouseOver(4)" onmouseout="mouseOut(4)" onclick="Sort('date')">
                <p class="popuptext" id="myPopup4">Sort by Clicking</p>
                Date Submitted
              </th>
              <th onmouseover="mouseOver(5)" onmouseout="mouseOut(5)" onclick="Sort('requested_completion_date')">
                <p class="popuptext" id="myPopup5">Sort by Clicking</p>
                Deadline
              </th>
              <th onmouseover="mouseOver(6)" onmouseout="mouseOut(6)" onclick="Sort('priority')">
                <p class="popuptext" id="myPopup6">Sort by Clicking</p>
                Priority
              </th>
              <th onmouseover="mouseOver(7)" onmouseout="mouseOut(7)" onclick="Sort('assigned_to')">
                <p class="popuptext" id="myPopup7">Sort by Clicking</p>
                Assigned To
              </th>
              <th onmouseover="mouseOver(8)" onmouseout="mouseOut(8)" onclick="Sort('status')">
                <p class="popuptext" id="myPopup8">Sort by Clicking</p>
                Status
              </th>              
            </tr>
          </thead>
          
          <tbody id="card">
            <?php
            $counter = 0;
            $sec_counter = 100;
            $session = session();
            foreach ($requests->getResult() as $row) {
              $counter += 1;
              $sec_counter += 1;
              $id = $row->id;
              $fname = $row->first_name;
              $lname = $row->last_name;
              $date = $row->date;
              $deadline = $row->requested_completion_date;
              $priority = $row->priority;
              $assigned_to = $row->assigned_to;
              $comment = $row->comments;
              $status = $row->status;

              echo "<tr id=$counter>";              
              echo "<td><a href='view/$id?status=$status&num=$counter' target='_blank'>Click Here</a></td>";
              echo "<td>$id</td>";
              echo "<td>$fname</td>";
              echo "<td>$lname</td>";
              echo "<td>$date</td>";
              echo "<td>$deadline</td>";
              echo "<td>$priority</td>";
            ?>
              <td>
                <form action="assignedTo" method="post">
                  <select name="assigned_to">
                    <option value="default">--Select A Designer--</option>                    
                    <?php
                    foreach ($oas->getResult() as $row) {
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

              <td>
                <form action="requestStatus" method="post">
                  <label for="comment">Comments</label>
                  <br>
                  <textarea name="comment" id="comment" cols="10" rows="4"><?php echo($comment) ?></textarea>
                  <br>
                  <select name="req_status">
                    <option value="default">--Select--</option>
                    <option name="Student Unavailable" value="Student Unavailable" <?php if ($status == 'Student Unavailable') echo "selected=\"selected\""; ?>>Student Unavailable </option>
                    <option name="Complete" value="Complete" <?php if ($status == 'Complete') echo "selected=\"selected\""; ?>>Complete </option>
                    <option name="Denied" value="Denied" <?php if ($status == 'Denied') echo "selected=\"selected\""; ?>>Denied </option>
                    <option name="no response" value="no response" <?php if ($status == 'no response') echo "selected=\"selected\""; ?>>no response </option>
                    <option name="delivered" value="delivered" <?php if ($status == 'delivered') echo "selected=\"selected\""; ?>>delivered </option>
                    <option name="see comments" value="see comments" <?php if ($status == 'see comments') echo "selected=\"selected\""; ?>>see comments </option>                    
                  </select>
                  <input type="hidden" VALUE="<?php echo $id; ?>" NAME="id" />
                  <input type="hidden" VALUE="<?php echo $status; ?>" NAME="status" />
                  <?php
                  if ($assigned_to != "default" and $assigned_to != " ") {
                    echo ('<input type=SUBMIT VALUE="Submit">');
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
      <div>
        <br><br><br>Pages<br>
      <?php
        for ($pageNumber = 1; $pageNumber <= 10; $pageNumber+=1) {
          echo("<a href='?page=$pageNumber&status=$status'>$pageNumber</a> | ");
        }
      ?>
      </div>      
    </div>
  </section>
  <br> <br> <br> <br>

  <script type="text/javascript">
    function mouseOver(x) {
      var input = "myPopup"+x;
      // alert(input);
      var popup = document.getElementById(input);
      popup.classList.toggle("show");
      // popup.style.visibility = "none";
    }

    function mouseOut(x) {
      var input = "myPopup"+x;
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
      var url = location.href.substring(location.href.lastIndexOf('/') + 1);
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
      if (!url.includes("?")){
        url = url.concat("?");
      }else if (last != '&') {
        url = url.concat("&");
      }
      if (check == "ASC") {
        var sort = url + "sort=DESC&order=" + x;
      } else if (check == "DESC") {
        var sort = url + "sort=ASC&order=" + x;
      } else {
        var sort = url + "sort=ASC&order=" + x;
      }
      // alert(sort);
      window.open(sort, "_self");
    }        

    var time = new Date().getTime();
    $(document.body).bind("mousemove keypress", function(e) {
      time = new Date().getTime();
    });

    function refresh() {
      if (new Date().getTime() - time >= 60000)
        window.location.reload(true);
      else
        setTimeout(refresh, 50000);
    }

    setTimeout(refresh, 50000);
  </script>
</body>

</html>