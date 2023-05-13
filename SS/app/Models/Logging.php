<?php

namespace App\Models;

use CodeIgniter\Model;

class Logging extends Model
{
  //?       table = 'real table name';
  protected $log = 'log_test';
  protected $service = 'service';
  protected $package = 'log_package';
  protected $equip = 'log_equipment';
  protected $key = 'key_signout';

  public function log($table, $check)
  {
    $session = session();
    $hallid = $session->get("hallid");
    $host_id = $session->student_id;
    $db = $this->db;
    $table = $this->$table;
    $builder = $db->table($table);
    $builder->where('logouttime IS NULL', NULL, FALSE);
    if ($check) {
      $builder->where('hostid', $host_id);
    }
    if (is_array($hallid)) {
      $builder->whereIn('hallid', $hallid);
    } else {
      $builder->where('hallid', $hallid);
    }
    if ($table == 'key') {
      $builder->orderBy('signouttime', 'DESC');
    } else {
      $builder->orderBy('logintime', 'DESC');
    }
    $query = $builder->get();
    return $query->getResult();
  }

  public function add_entry($data, $table)
  {
    $db = $this->db;
    $table = $this->$table;
    $builder = $db->table($table);
    $builder->insert($data);
    $query = $builder->get();
    if ($query) {
      return $db->affectedRows();
    } else {
      return 0;
    }
  }

  public function checkOut_entry($id, $table)
  {
    $db = $this->db;
    $table = $this->$table;
    $builder = $db->table($table);
    $builder->where('id', $id);
    $builder->set('logouttime', 'NOW()', FALSE);
    $query = $builder->update();
    if ($query) {
      return $db->affectedRows();
    } else {
      return 0;
    }
  }

  public function emailPackageHasBeenAdded($data)
  {
    $email = \Config\Services::email();

    $email->setFrom('reslife@southernct.edu', 'ResLife');
    $email->setTo($data['hostemail']);
    // $email->setCC($hd_email);
    $msg = view('Package/email_package_checkin', $data);
    $email->setSubject('Package Checked In');
    $email->setMessage($msg);

    return $email->send();
  }
}
