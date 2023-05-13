<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View OA Request</title>
</head>
<body>

<h1>View OA Request</h1>

<br /><br />
<div style="margin:10px 0 0 20px">
  <?php	
    $session = session();    
    $idAnchor = $session->get('idAnchor'); 
    $row = $requests->getRowArray();
    $err_msg = "N/A";
    $num = $_GET['num'] -1;
    // echo "<a href=\"" . $session->get('redirect_url') . "?status=". $_GET['status'] ."#" . $idAnchor-1 . "\">Back</a>";
    echo "<a href=\"" . $session->get('redirect_url') . "?status=". $_GET['status'] ."#". $num ."\">Back</a>";
  ?>

  <table cellpadding = 2px>
    <tr>
      <td> 
        <?php    
          echo "<p> <b> ID </b>  <br /> ".(($row["id"] != "") ? $row["id"] : $err_msg) ."  </p>";
        ?>
      </td>
      <td>
        <?php         
          echo "<p> <b> First Name </b>  <br /> ".(($row["first_name"] != "") ? $row["first_name"] : $err_msg) ."  </ p>"; 
        ?>
      </td>
      <td>
        <?php 
          echo "<p> <b> Last Name </b>  <br /> ".(($row["last_name"] != "") ? $row["last_name"] : $err_msg) ."  </p>";
        ?>
      </td>
      <td>
        <?php
          echo "<p> <b> User </b>  <br /> ".(($row["user"] != "") ? $row["user"] : $err_msg) ."  </p>";
        ?>
      </td>
    </tr>
    <tr>
      <td>
        <?php 
          echo "<p> <b> Location </b>  <br /> ".(($row["location"] != "") ? $row["location"] : $err_msg) ."  </p>";
        ?>
      </td>
      <td>
        <?php
          echo "<p> <b> Room </b>  <br /> ".(($row["room"] != "") ? ($row["room"]) : $err_msg) ."  </p>";
        ?>
      </td>           
      <td>
        <?php      
          echo "<p> <b> Priority </b>  <br /> ".(($row["priority"] != "") ? ($row["priority"]) : $err_msg) ."  </p>";
        ?>
      </td>        
      <td>
        <?php      
          echo "<p> <b> Type </b>  <br /> ".(($row["type"] != "") ? ($row["type"]) : $err_msg) ."  </p>";
        ?>
      </td>
    </tr>
    <tr>
      <td>
        <?php
          echo "<p> <b> Resident Availability </b>  <br /> ".(($row["residentAvailability"] != "") ? $row["residentAvailability"] : $err_msg) ."  </p>";
        ?>
      </td>
      <td>
        <?php   
          echo "<p> <b> Requested Completion Date </b>  <br /> ".(($row["requested_completion_date"] != "") ? $row["requested_completion_date"] : $err_msg) ."  </p>";
        ?>
      </td>          
      <td>
        <?php echo "<p><b>Assigned To: </b><br/>" . (($row["assigned_to"] != "") ? $row["assigned_to"] : $err_msg) . "</p>";?>  
      </td>
    </tr>
    <tr>
      <td colspan = "5">
        <?php   
          echo "<p> <b> Description </b>  <br /> ".(($row["description"] != "") ? $row["description"] : $err_msg) ."  </p>";
        ?> 
      </td>
    </tr>
    <tr>
      <td>   
        <?php   
          echo "<p> <b> Date Submitted </b>  <br /> ".(($row["date"] != "") ? $row["date"] : $err_msg) ."  </p>";
        ?>
      </td>        
      <td>
        <?php  
          echo "<p> <b> Status </b>  <br /> ".(($row["status"] != "") ? $row["status"] : $err_msg) ."  </p>";
        ?>
      </td>
      
    </tr>
    </table>  
      
    <br /> 
    <?php  
      echo "<a href=\"" . $_SESSION['redirect_url'] . "?status=". $status ."\">Back</a>";               
    ?>
</div>
</body>
</html>