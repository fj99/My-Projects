<?php

namespace App\Models;

use CodeIgniter\Model;

class Others extends Model
{
  protected $hd = 'hall_directors';
  protected $alert = 'alert';
  protected $halls = 'halls';
  protected $staff = 'staff';
  protected $db;
  protected $computer_names = 'signInComputerNames';

  public function get_hd_message()
  {
    $today_date = date('Y-m-d H:i:s');
    $db = $this->db;
    $session = session();
    $table = $this->alert;
    $builder = $db->table($table);
    // $builder->where("hallid", $session->get('hallid'));
    $hallIds = $session->get('hallid');
    if (is_array($hallIds)) {
      $builder->whereIn("hallid", $hallIds);
    } else {
      $builder->where("hallid", $hallIds);
    }
    $builder->where("enabled", "1");
    $builder->where("live_date <=", $today_date);
    $builder->where("end_date >=", $today_date);
    $or = '(hall_abv ="RS" AND enabled ="1")';
    $builder->orWhere($or);
    $builder->orderBy("hallid", "DESC");
    $query = $builder->get();

    $msg = '';
    if ($query->getNumRows() == 0) {
      return;
    } else {
      foreach ($query->getResult() as $row) {
        if ($row->hall_abv != "RS") {
          $msg .= "<h1 class='blue'>Message from your hall director</h1><br /><b>" . $row->message . "</b><br />";
        }
        if ($row->hall_abv == "RS") {
          $msg .= "<h1 class='blue'>Message from the Office of Residence Life</h1><br /><b>" . $row->message . "</b><br />";
        }
      }
      return $msg;
    }
  }

  function hallABVToid($name)
  {
    if ($name == '') {
      return 0;
    }
    if (substr($name, 0, 3) === "NCT") {
      $name = 'NCT';
    }
    $db = $this->db;
    $table = $this->halls;
    $builder = $db->table($table);
    $builder->where('hall_abv', $name);
    $query = $builder->get();
    $row = $query->getRow();
    return $row->hall_id;
  }

  function IdToHallname($id)
  {
    $db = $this->db;
    $table = $this->halls;
    $builder = $db->table($table);
    $builder->where('hall_id', $id);
    $query = $builder->get();
    $row = $query->getRow();
    return $row->hall_name;
  }

  public function SendSupportMsg($data)
  {
    $db = $this->db;
    $table = $this->staff;
    $builder = $db->table($table);
    // $builder->where('job', 'Computer Programmer');
    // $builder->orWhere('job', 'IT Coordinator');

    $builder->where('job_id', '10');
    $builder->orWhere('job_id', '4');

    $query = $builder->get();
    $num = $query->getNumRows();
    $to = '';

    foreach ($query->getResult() as $row) {
      $to .= $row->username . "@southernct.edu, ";
    }

    $email = \Config\Services::email();
    $from = 'reslife@southernct.edu';
    $email->setFrom($from, 'ResLife');
    $email->setTo($to);
    $msg = $data['msg'] . "\n\n\nStaff: " . $data['staff'] . " \nHall: " . $data['subject'] . " ";
    $headers = "From:" . $from;
    $email->setSubject($data['subject']);
    $email->setMessage($msg);

    $emailt = $email->send();
    if ($emailt) {
      return "" . img('images/success.png') . "<br />Email has been successfully sent!<br />We will look at your request as soon as possible.";
    } else {
      return "" . img('images/error.png');
    }
  }

  public function ComputerNames($name)
  {
    $db = $this->db;
    $table = $this->computer_names;
    $builder = $db->table($table);
    // $builder->select('name, hall_id, hall_name, hall_abv');
    $builder->where('name', $name);
    $builder->join('halls', 'halls.hall_id = signInComputerNames.hall_id');
    $query = $builder->get();
    return $query;
  }
}
