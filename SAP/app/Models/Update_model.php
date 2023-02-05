<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\RawSql;

class Update_model extends Model
{
  protected $notification_table = 'notifications';
  protected $staff_table = 'staff s';
  protected $users_table = 'users';
  protected $auth_table = 'auth';
  protected $jobs_table = 'jobs';
  protected $hd_table = 'hall_directors';

  public function getNotifications()
  {
    $db = $this->db;
    $notification_table = $this->notification_table;
    $builder = $db->table($notification_table);
    $builder->select('*');
    $builder->join('jobs', 'jobs.job_id = notifications.affected_job AND notifications.notification_id = 1');
    $query = $builder->get();
    $num = $builder->countAllResults();
    $db->close();
    return $query;
  }

  public function query($data, $field, $table)
  {
    $db = $this->db;
    $builder = $db->table($table);
    $builder->select('*');
    if (is_numeric($data)) {
      $builder->where('id', $data);
    } else {
      $builder->where($field, $data);
    }
    $db->close();
    return $builder;
  }

  public function getPermissions($user, $whereParameter)
  {
    $db = $this->db;
    $table = $this->staff_table;
    $builder = $db->table($table);
    $builder->select('comcast_requests, maintenance_requests', 'program_report, farnham_report, schwartz_report, conn_report, tech_requests, oa_requests, van_requests');
    $builder->where($whereParameter, $user);
    $query = $builder->get();
    $num = $builder->countAllResults();
    if ($num > 0) {
      return $query;
    } else {
      return null;
    }
  }

  public function getUsers($id)
  {
    $db = $this->db;
    $staff_table = $this->staff_table;
    $users_table = $this->users_table;
    $auth_table = $this->auth_table;
    $jobs_table = $this->jobs_table;
    // call query function
    $staff = $this->query($id, "username", $staff_table);
    $users = $this->query($id, "username", $users_table);
    $auth = $this->query($id, "user", $auth_table);
    // count results
    $num_staff = $staff->countAllResults(false);
    $num_users = $users->countAllResults(false);
    $num_auth = $auth->countAllResults(false);
    // get queries
    $staff_query = $staff->get();
    $users_query = $users->get();
    $auth_query = $auth->get();

    if ($num_staff == 0 or $num_users == 0 or $num_auth == 0) {
      return 0;
    }
    $builder = $db->table($jobs_table);
    $builder->select('job_title');
    $row = $staff_query->getRow();
    $builder->where('job_id', $row->job_id);
    $job_query = $builder->get();
    $permissions = $this->getPermissions($id, "id");

    $user_data = array("staff_portal" => $staff_query, "program_portal" => $users_query, "staff_admin_portal" => $auth_query, "staff_portal_job" => $job_query, "permissions" => $permissions);
    return $user_data;
  }

  public function resetProgramPortalPassword($input)
  {
    $data = 'ABCDEFGHIJKLOMOPQRSTUVWXYZabcdefghijklomnpqrstuvwxyz1234567890';
    switch ($input['id'] % 11) {
      case 0:
        $salt = "penguin";
        $pass = substr(str_shuffle($data), 0, 7);
        $salt_pass = array(0 => $salt, 1 => $pass);
        break;

      case 1:
        $salt = "eagle";
        $pass = substr(str_shuffle($data), 0, 7);
        $salt_pass = array(0 => $salt, 1 => $pass);
        break;

      case 2:
        $salt = "mammoth";
        $pass = substr(str_shuffle($data), 0, 7);
        $salt_pass = array(0 => $salt, 1 => $pass);
        break;

      case 3:
        $salt = "mandrill";
        $pass = substr(str_shuffle($data), 0, 7);
        $salt_pass = array(0 => $salt, 1 => $pass);
        break;

      case 4:
        $salt = "armadillo";
        $pass = substr(str_shuffle($data), 0, 7);
        $salt_pass = array(0 => $salt, 1 => $pass);
        break;

      case 5:
        $salt = "octopus";
        $pass = substr(str_shuffle($data), 0, 7);
        $salt_pass = array(0 => $salt, 1 => $pass);
        break;

      case 6:
        $salt = "kuwanger";
        $pass = substr(str_shuffle($data), 0, 7);
        $salt_pass = array(0 => $salt, 1 => $pass);
        break;

      case 7:
        $salt = "chameleon";
        $pass = substr(str_shuffle($data), 0, 7);
        $salt_pass = array(0 => $salt, 1 => $pass);
        break;

      case 8:
        $salt = "vile";
        $pass = substr(str_shuffle($data), 0, 7);
        $salt_pass = array(0 => $salt, 1 => $pass);
        break;

      case 9:
        $salt = "velguarder";
        $pass = substr(str_shuffle($data), 0, 7);
        $salt_pass = array(0 => $salt, 1 => $pass);
        break;

      case 10:
        $salt = "sigma";
        $pass = substr(str_shuffle($data), 0, 7);
        $salt_pass = array(0 => $salt, 1 => $pass);
        break;

      default:
        $salt = "default";
        break;
    }
    return $salt_pass;
  }

  public function emailProgramPortalPassword($admin_inputs, $password)
  {
    $email = \Config\Services::email();
    date_default_timezone_set('America/New_York');
    $message = "Dear " . $admin_inputs->getRow()->fname . ",<br><br>";

    $subject = "Program Portal Password Reset";

    $message .= "Your Program Portal password has been reset. Below are your login credentials. This does not affect your staff portal password which is still your SCSU banner password.<br><br>";
    $message .= "&emsp; 1.  Username: " . $admin_inputs->getRow()->username . "<br>";
    $message .= '&emsp; 2.  Password: ' . $password . '<br><br>';
    $message .= "&emsp; 3.  Once you are logged in, click 'Account Settings' at the top of the blue navigation bar<br>";
    $message .= "&emsp; 4.  Change your password in the 'User Information' section<br>";
    $message .= "&emsp; 5.  Done!<br><br>";
    $message .= "Best Regards,<br>";
    $message .= "The Office of Residence Life";

    $email->setFrom('Reslife@southernct.edu', 'Reslife');    
    // $email->setTo('Fernandezf2@southernct.edu'); //* Testing Send    
    $email->setTo($admin_inputs->getRow()->username . "@southernct.edu"); //*Official Send
    $email->setCC("dahlmand1@southernct.edu");
    $email->setSubject($subject);
    $email->setMessage($message);

    $email->send();
  }

  public function emailJobChange($admin_inputs) {
    $email = \Config\Services::email();
    date_default_timezone_set('America/New_York');
    $message = "Dear " . $admin_inputs['first_name'] . ",<br><br>";
    $subject = "Residence Life Job Change";
    $message .= "Your job has been updated to ".$admin_inputs['job_title']. ". You may have different permissions within the staff and program portal due to the change. If this was an error, contact your supervisor<br><br>";
    $message .= "Best Regards,<br>";
    $message .= "The Office of Residence Life";

    $email->setFrom('Reslife@southernct.edu', 'Reslife');    
    // $email->setTo('Fernandezf2@southernct.edu'); //* Testing Send    
    $email->setTo($admin_inputs['username'] . "@southernct.edu"); //* Official Send
    $email->setCC("dahlmand1@southernct.edu");
    $email->setSubject($subject);
    $email->setMessage($message);

    $email->send();
}

  public function updateUser($data)
  {
    $db = $this->db;
    //* tables
    $staff_table = $this->staff_table;
    $users_table = $this->users_table;
    $auth_table = $this->auth_table;
    $jobs_table = $this->jobs_table;
    //* builders
    $staff_builder = $db->table($staff_table);
    $users_builder = $db->table($users_table);
    $auth_builder = $db->table($auth_table);
    $jobs_builder = $db->table($jobs_table);
    //* var for staff query
    $id = $data['id'];
    $username = $data['user'];
    $fname = $data['fname'];
    $lname = $data['lname'];
    $sap_job_id = $data['sap_job'];
    $program_report = $data['program_report'];
    $farnham_report = $data['farnham_report'];
    $schwartz_report = $data['schwartz_report'];
    $conn_report = $data['conn_report'];
    $tech_requests = $data['tech_requests'];
    $oa_requests = $data['oa_requests'];
    $van_requests = $data['van_requests'];
    $comcast_requests = $data['comcast_requests'];
    $maintenance_requests = $data['maintenance_requests'];
    $sap_hall = $data['sap_hall'];
    $staff_admin = $data['staff_admin'];

    $staff = [
      'job_id' => $sap_job_id,
      'program_report' => $program_report,
      'farnham_report' => $farnham_report,
      'schwartz_report' => $schwartz_report,
      'conn_report' => $conn_report,
      'tech_requests' => $tech_requests,
      'oa_requests' => $oa_requests,
      'van_requests' => $van_requests,
      'comcast_requests' => $comcast_requests,
      'maintenance_requests' => $maintenance_requests,
      'hall_id' => $sap_hall,
      'admin' => $staff_admin
    ];
    //* updating the staff tables
    $staff_builder->where('id', $id);
    $query1 = $staff_builder->update($staff);

    //*var for user query
    $users_builder->select('*');
    $admin_data = $users_builder->get();

    $program_portal_role = $data['program_portal_role'];
    $program_portal_role2 = $data['program_portal_role2'];
    $allroles = '';
    $allhalls = '';
    /* Looping through the array and concatenating the values. */
    for ($i = 1; $i < 15; $i++) {
      $num = (string) $i;
      if ($i < 10) {
        if ($data["allhalls" . $num] != NULL) {
          $allhalls .= $data["allhalls" . $num] . ",";
        }
      }
      if ($data["allroles" . $num] != NULL) {
        $allroles .= $data["allroles" . $num] . ",";
      }
    }

    $allhalls = rtrim($allhalls, ',');
    $allroles = rtrim($allroles, ',');

    if ($allhalls == '') {
      $allhalls = null;
    }
    if ($allroles == '') {
      $allroles = null;
    }

    //*check if password is gonna be reset
    if ($data["reset_pp_pass"] != 0) {
      $salt_pass = $this->resetProgramPortalPassword($data);
      $password = hash('sha256', $salt_pass[1] . $salt_pass[0]);
      //*this function needs full name and username passed in data
      $this->emailProgramPortalPassword($admin_data, $salt_pass[1]);
    } else {
      $password = $admin_data->getRow()->hashpass;
    }

    $user = [
      'hall' => $sap_hall,
      'role' => $program_portal_role,
      'role2' => $program_portal_role2,
      'allroles' => $allroles,
      'allhalls' => $allhalls,
      'hashpass' => $password
    ];

    //* updating the user tables
    $users_builder->where('id', $id);
    $query2 = $users_builder->update($user);

    //*var for auth query
    $auth_level = $data['auth_level'];
    // sap_job_id is the key to tell you what job in auth is
    $jobs_builder->where('job_id', $sap_job_id);
    $job_query = $jobs_builder->get();
    $job = $job_query->getRow()->jobs;

    $form = $data['form_access'];
    $pro = $data['programming_level'];
    $permissions = '';
    for ($i = 1; $i < 11; $i++) {
      $num = (string) $i;
      if ($data["permissions" . $num] != NULL) {
        $permissions .= $data["permissions" . $num] . ",";
      }
    }

    $data = [
      "hallid" => $sap_hall,
      "job" => $job,
      "auth_level" => $auth_level,
      "form_access" => $form,
      "programming_level" => $pro,
      "permissions" => $permissions,
    ];
    $auth_builder->where("id", $id);
    $auth_builder->update($data);

    $query3 = $auth_builder->get();

    if ($sap_job_id == "11" || $sap_job_id == "12") {
      $today = date('y-m-d h:i:s');
      $hd_table = $this->hd_table;
      $hd_builder = $db->table($hd_table);
      $hd_builder2 = $db->table($hd_table);
      $email = (string) $username . "@southernct.edu";
      $phone = "";
      switch ($sap_hall) {
        case "1":
          $phone = "6374";
        case "2":
          $phone = "6363";
        case "3":
          $phone = "5436";
        case "4":
          $phone = "6367";
        case "5":
          $phone = "6356";
        case "6":
          $phone = "6379";
        case "7":
          $phone = "6120";
        case "8":
          $phone = "9113";
        case "9":
          $phone = "6350";
      }
      $data = [
        "hall_id" => $sap_hall,
        "id" => $id,
        "email" => $email,
        "username" => $username,
        "first_name" => $fname,
        "last_name" => $lname,
        "phone_ext" => $phone,
      ];
      // $hd_builder->where("hall_id", $sap_hall);
      // $hd_builder->update($data);

      $query = $db->query("SET FOREIGN_KEY_CHECKS = 0");
      $query4 = $hd_builder->insert($data);
    }
    $db->close();
    if ($query1 && $query2 && $query3) {
      $check = true;
      $info = [
        "job_title" => $job_query->getRow()->job_title,
        "first_name" => $fname,
        "username" => $username,
      ];
      update_model::emailJobChange($info);
    }

    //? Debugging the last query
    // $query = $this->db->getLastQuery();
    // $last = (string)$query;
    // echo $last;
    $return = array($check, $id);
    return $return;
  }

  public function advancedSearch($input)
  {
    $db = $this->db;
    $staff_table = $this->staff_table;
    $staff_builder = $db->table($staff_table);
    $staff_builder2 = $db->table($staff_table);
    $staff_builder3 = $db->table($staff_table);
    $staff_builder4 = $db->table($staff_table);

    $staff_builder->select("*");

    if ($input["id"] == '') {
      $id = '';
    } else {
      $id = $input["id"];
    }
    if ($input["username"] == "") {
      $user = '';
    } else {
      $user = $input["username"];
    }
    if ($input["staff_portal_hall"] == "") {
      $hall = $staff_builder2->select("hall_id");
      $staff_builder->WhereIn("s.hall_id", $hall);
    } else {
      $hall = $input["staff_portal_hall"];
      $staff_builder->Where("s.hall_id", $hall);
    }
    if ($input["job_title"] == "") {
      $job = $staff_builder3->select("job_id");
      $staff_builder->WhereIn("s.job_id", $job);
    } else {
      $job = $input["job_title"];
      $staff_builder->Where("s.job_id", $job);
    }
    if ($input['active'] == "") {
      $active = $staff_builder4->select("active");
      $staff_builder->WhereIn("s.active", $active);
    } else {
      $active = $input['active'];
      $staff_builder->Where("s.active", $active);
    }

    $staff_builder->like("id", $id);
    $staff_builder->like("username", $user);
    $staff_builder->join("jobs", "jobs.job_id = s.job_id", "left");
    $staff_builder->join("halls", "halls.hall_id = s.hall_id", "left");
    $query = $staff_builder->get();
    $db->close();

    //? Debug 
    // $query = $this->db->getLastQuery();
    // $last = (string)$query;
    // echo $last;

    return $query;
  }

  public function HD()
  {
    $db = $this->db;
    $hd_table = $this->hd_table;
    $hd_builder = $db->table($hd_table);
    $hd_builder->select("*");
    $hd_builder->join("halls", "hall_directors.hall_id = halls.hall_id", "left");
    $query = $hd_builder->get();
    $db->close();

    return $query;
  }

  public function updateHD($id)
  {
    $db = $this->db;
    $hd_table = $this->hd_table;
    $hd_builder = $db->table($hd_table);
    $hd_builder2 = $db->table($hd_table);

    $hd_builder->select('num');
    $hd_builder->where("id", $id);
    $query = $hd_builder->get();
    $row = $query->getRow();

    $hd_builder2->where("num", $row->num);
    $query = $hd_builder2->delete();

    //? Debug
    // $query = $this->db->getLastQuery();
    // $last = (string)$query;
    // echo $last;

    $db->close();
    return $query;
  }
}
