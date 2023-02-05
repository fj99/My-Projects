<?php

namespace App\Models;

use CodeIgniter\Model;

class Notifications_model extends Model
{
  protected $notification = 'notifications';
  protected $staff = 'staff';
  protected $db;

  public function getNotifications()
  {
    $db = $this->db;
    $not = $this->notification;
    $builder = $db->table($not);
    $builder->select('*');
    $builder->where('status', 0);
    $query = $builder->get();
    $num = $builder->countAllResults();
    $db->close();
    return $query;
  }

  public function getClosedNotifications()
  {
    $db = $this->db;
    $not = $this->notification;
    $builder = $db->table($not);
    $builder->select('*');
    $builder->where('status', 1);
    $query = $builder->get();
    $num = $builder->countAllResults();
    $db->close();
    return $query;
  }

  public function getProgrammers()
  {
    $db = $this->db;
    $staff = $this->staff;
    $builder = $db->table($staff);
    $builder->select('*');
    $builder->where('job_id', '10');
    $builder->where('active', '1');
    $query = $builder->get();
    $db->close();
    return $query;
  }

  public function addNotification($input)
  {
    $db = $this->db;
    $not = $this->notification;
    $builder = $db->table($not);
    $today = date('y-m-d h:i:s');
    $data = [
      "submitter_username" => $input["user"],
      "request_type" => $input["request"],
      "affects" => $input["affect"],
      "comments" => $input["comments"],
      "submit_date" => $today,
    ];
    $query = $builder->insert($data);
    $db->close();
    return $query;
  }

  public function closeNotification($input)
  {
    $db = $this->db;
    $not = $this->notification;
    $builder = $db->table($not);
    $today = date('y-m-d h:i:s');
    $id = $input["id"];
    $data = [
      "programmer" => $input["user"],
      "affected_username" => $input["affected_username"],
      "affected_id" => $input["affected_id"],
      "complete_date" => $today,
      "status" => 1,
    ];

    $query = $builder->where("notification_id", $id);
    $query = $builder->update($data);
    $db->close();
    return $query;
  }
}
