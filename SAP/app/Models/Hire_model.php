<?php

namespace App\Models;

use CodeIgniter\Model;

class Hire_Model extends Model
{
  protected $staff_table = 'staff';
  protected $users_table = 'users';
  protected $auth_table = 'auth';
  protected $jobs_table = 'jobs';

  public function manuallyHireUsers($input)
  {
    $result = $this->jobSwitch($input);
    return $result;
  }
  public function jobSwitch($admin_inputs)
  {
    $db = $this->db;
    $id = $admin_inputs["id"];
    $fname = $admin_inputs["first_name"];
    $lname = $admin_inputs["last_name"];
    $username = $admin_inputs["username"];
    $hall = $admin_inputs["hall"];
    $job = $admin_inputs["job_id"];
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
    //* staff
    $staff_builder->where("id", $id);
    //* users
    $users_builder->where("id", $id);
    //* auth 
    $auth_builder->where('id', $id);
    //* count results 
    $num_staff = $staff_builder->countAllResults();
    $num_users = $users_builder->countAllResults();
    $num_auth = $auth_builder->countAllResults();
    $result = false;
    if ($num_staff != 0) {
      echo "staff";
      return $result;
    }
    if ($num_users != 0) {
      echo "users";
      return $result;
    }
    if ($num_auth != 0) {
      echo "auth";
      return $result;
    }
    //* get job properties
    $jobs_builder->select('*');
    $jobs_builder->where("job_id", $job);
    $job_query = $jobs_builder->get();
    $job_row = $job_query->getRow();
    if ($job_row->reports != null) {
      $reports = explode(",", $job_row->reports);
    } else {
      $reports = [];
    }
    $program = 0;
    $farnham = 0;
    $schwartz = 0;
    $conn = 0;
    $tech = 0;
    $oa = 0;
    $van = 0;
    $comcast = 0;
    $maintenance = 0;

    foreach ($reports as $value) {
      if ($value == "program_report") {
        $program = 1;
      }
      if ($value == "farnham_report") {
        $farnham = 1;
      }
      if ($value == "schwartz_report") {
        $schwartz = 1;
      }
      if ($value == "conn_report") {
        $conn = 1;
      }
      if ($value == "tech_requests") {
        $tech = 1;
      }
      if ($value == "oa_requests") {
        $oa = 1;
      }
      if ($value == "van_requests") {
        $van = 1;
      }
      if ($value == "comcast_requests") {
        $comcast = 1;
      }
      if ($value == "maintenance_requests") {
        $maintenance = 1;
      }
    }
    if ($job == 10) {
      $admin = 2;
    } else {
      $admin = 0;
    }
    // staff table
    $data = [
      "id" => $id,
      "job_id" => $job,
      "username" => $username,
      "first_name" => $fname,
      "last_name" => $lname,
      "program_report" => $program,
      "farnham_report" => $farnham,
      "schwartz_report" => $schwartz,
      "conn_report" => $conn,
      "tech_requests" => $tech,
      "oa_requests" => $oa,
      "van_requests" => $van,
      "comcast_requests" => $comcast,
      "maintenance_requests" => $maintenance,
      "hall_id" => $hall,
      "active" => 1,
      "admin" => $admin
    ];
    $result = $staff_builder->insert($data);
    // users table
    $salt_pass = $this->setSaltAndPass($admin_inputs);
    $password = hash('sha256', $salt_pass[1] . $salt_pass[0]);
    $data = [
      "id" => $id,
      "username" => $username,
      "hashpass" => $password,
      "fname" =>  $fname,
      "lname" => $lname,
      "hall" => $hall,
      "role" => $job_row->program_portal_role,
      "taste" => $salt_pass[0],
      "active" => 1,
    ];
    $result = $users_builder->insert($data);
    // auth table
    $today = date("Y-m-d");
    $data = [
      "id" => $id,
      "name_first" => $fname,
      "name_last" => $lname,
      "user" => $username,
      "hallid" => $hall,
      "job" => $job,
      "auth_level" => $job_row->auth_level,
      "form_access" => $job_row->form_access,
      "programming_level" => $job_row->programming_level,
      "date" => $today,
      "active" => 1,
      "permissions" => $job_row->permissions
    ];
    // $result = $result && $auth_builder->insert($data);
    $result = $auth_builder->insert($data);
    $db->close();

    return $result;
  }
  //set user salt upon registration
  public function setSaltAndPass($admin_inputs)
  {
    $data = 'ABCDEFGHIJKLOMOPQRSTUVWXYZabcdefghijklomnpqrstuvwxyz1234567890';
    switch ($admin_inputs['id'] % 11) {
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
}
