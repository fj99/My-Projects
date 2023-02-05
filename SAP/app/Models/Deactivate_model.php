<?php

namespace App\Models;

use CodeIgniter\Model;

class Deactivate_model extends Model
{
  protected $staff_table = 'staff';
  protected $users_table = 'users';
  protected $auth_table = 'auth';
  protected $jobs_table = 'jobs';

  public function validateUser($id)
  {
    $db = $this->db;
    $staff_table = $this->staff_table;
    $staff_builder = $db->table($staff_table);
    $staff_builder->select("*");
    $staff_builder->where("id", $id);
    $staff_builder->join("jobs", "jobs.job_id = staff.job_id", "left");
    $staff_builder->join("halls", "halls.hall_id = staff.hall_id", "left");
    $query = $staff_builder->get();
    if ($query) {
      $row = $query->getRow();
      $result = [
        "id" => $row->id,
        "username" => $row->username,
        "first_name" => $row->first_name,
        "last_name" => $row->last_name,
        "job_title" => $row->job_title,
        "hall" => $row->hall_id,
        "active" => $row->active
      ];
      return $result;
    } else {
      return 0;
    }
  }

  public function manuallyDeactivateUsers($id)
  {
    $db = $this->db;
    $staff_table = $this->staff_table;
    $users_table = $this->users_table;
    $auth_table = $this->auth_table;
    $staff_builder = $db->table($staff_table);
    $users_builder = $db->table($users_table);
    $auth_builder = $db->table($auth_table);
    $update = [
      "active" => 0
    ];
    $staff_builder->where("id", $id);
    $result = $staff_builder->update($update);
    $users_builder->where("id", $id);
    $result = $users_builder->update($update);
    $auth_builder->where("id", $id);
    $result = $auth_builder->update($update);
    return $result;
  }
}
