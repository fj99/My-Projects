<?php

namespace App\Models;

use CodeIgniter\Model;

class Failed extends Model
{
  protected $fail = 'failed_signouts';
  protected $log = 'log_test';
  protected $hd = 'hall_directors';
  protected $db;

  public function regular()
  {
    $session = session();
    $hallName = $session->get('hallname');
    $db = $this->db;
    $table = $this->fail;
    $builder = $db->table($table);
    $builder->where('hall_name', $hallName);
    $builder->where('overnight', '0');
    $builder->orderBy('sign_in_time', 'DESC');
    $builder->limit(25);
    $query = $builder->get();
    $result['query'] = $query->getResult();
    $result['rows'] = $query->getNumRows();
    return $result;
  }

  public function overnight()
  {
    $session = session();
    $hallName = $session->get('hallname');
    $db = $this->db;
    $table = $this->fail;
    $builder = $db->table($table);
    $builder->where('hall_name', $hallName);
    $builder->where('overnight', '1');
    $builder->orderBy('sign_in_time', 'DESC');
    $builder->limit(25);
    $query = $builder->get();
    $result['query'] = $query->getResult();
    $result['rows'] = $query->getNumRows();
    return $result;
  }

  public function emailFails()
  {
    $db = $this->db;
    $today_date = date('Y-m-d 00:00:00');
    $today = date('Y-m-d');
    $date = strtotime("-1 days");
    $date2 = strtotime("+1 days");
    $yesterday = date('Y-m-d 00:00:00', $date);
    $session = session();

    $hallid = $session->get('hallid');
    $hallName = $session->get('hallname');
    $table = $this->fail;
    $builder = $db->table($table);
    $builder->where('hall_name', $hallName);
    $builder->where('failed_date >=', $yesterday);
    $builder->where('failed_date <=', $today_date);
    $query = $builder->get();

    $builder2 = $db->table($this->hd);
    $builder2->where('hall_id', $hallid);
    $query2 = $builder2->get();
    foreach ($query2->getResult() as $row) {
      $hd_email = $row->email;
    }
    $msg = " " . $hallName . " Failed sign out list " . $today . "\n\n";
    $subject = "Fail signed out list for " . $today . " ";
    $from = "Reslife@southernct.edu";
    $headers = 'From: ' . $from . "\r\n";
    $test = "fernandezf2@southernct.edu";
    foreach ($query->getResult() as $row) {
      if ($row->overnight) {
        $type = 'OVERNIGHT';
      } else {
        $type = "REGULAR";
      }
      $temp_msg = " HOST:\t " . $row['host_first_name'] . " " . $row['host_last_name'] . " " . $row['student_id'] . "
        ROOM: " . $row['room_number'] . "
        GUEST:\t " . $row['guest_first_name'] . " " . $row['guest_last_name'] . " " . $row['guest_id'] . "
        LOGIN:\t " . date('F j, Y, g:i a', strtotime($row['sign_in_time'])) . "
        TYPE:\t " . $type . " \n\n ";
      $msg .= $temp_msg;
    }

    $email = \Config\Services::email();

    $email->setFrom($from);
    $email->setTo($hd_email);
    // $email->setCC('another@another-example.com');
    // $email->setBCC('them@their-example.com');

    $email->setSubject($subject);
    $email->setMessage($msg);

    $email->send();
  }

  public function updateRegularFailed()
  {
    $db = $this->db;
    $today_date = date('Y-m-d 00:00:00');
    $date = strtotime("-1 days");
    $yesterday = date('Y-m-d 00:00:00', $date);

    $log = $this->log;
    $builder = $db->table($log);
    $builder->where('overnight', 0);
    $builder->where('logintime >=', $yesterday);
    $builder->where('logintime <=', $today_date);
    $builder->where('logouttime IS NULL', null, false);
    $query = $builder->get();

    helper("custom1_helper");
    echo debug($db);

    if ($query->getNumRows() > 0) {
      foreach ($query->getResult() as $row) {
        $fail = $this->fail;
        $data = [
          'student_id' => $row->hostid,
          'guest_id' => $row->guestid,
          'guest_first_name' => $row->guestfirstname,
          'guest_last_name' => $row->guestlastname,
          'hall_id' => $row->hallid,
          'host_first_name' => $row->hostfirstname,
          'host_last_name' => $row->hostlastname,
          'sign_in_time' => $row->logintime,
          'room_number' => $row->hostroom,
          // 'hall_name' => $row->hallname,
          'overnight' => $row->overnight,
        ];
        $builder2 = $db->table($fail);
        $builder2->insert($data);

        echo "<br>";
        echo "<tr>";
        echo "<td>" . $row->hostid . "</td> <br>";
        echo "<td>" . $row->guestid . "</td> <br>";
        echo "<td>" . $row->guestfirstname . "</td> <br>";
        echo "<td>" . $row->guestlastname . "</td> <br>";
        echo "<td>" . $row->hallid . "</td> <br>";
        echo "<td>" . $row->hostfirstname . "</td> <br>";
        echo "<td>" . $row->hostlastname . "</td> <br>";
        echo "<td>" . $row->logintime . "</td> <br>";
        echo "<td>" . $row->hostroom . "</td> <br>";
        // echo "<td>" . $row->hallname . "</td> <br>";
        echo "<td>" . $row->overnight . "</td> <br>";
        echo "</tr> <br>";
      }
    }
  }

  public function updateOvernightFailed()
  {
    $db = $this->db;
    $today_date = date('Y-m-d 00:00:00');
    $date = strtotime("-1 days");
    $yesterday = date('Y-m-d 00:00:00', $date);

    $log = $this->log;
    $builder = $db->table($log);
    //! Overnight: 
    $builder->where('overnight', 1);
    $builder->where('logintime >=', $yesterday);
    $builder->where('logintime <=', $today_date);
    $builder->where('logouttime IS NULL', null, false);
    $query = $builder->get();

    foreach ($query->getResult() as $row) {
      $fail = $this->fail;
      $data = [
        'student_id' => $row->hostid,
        'guest_id' => $row->guest_id,
        'guest_first_name' => $row->guestfirstname,
        'guest_last_name' => $row->guestlastname,
        'hall_id' => $row->hallid,
        'host_first_name' => $row->hostfirstname,
        'host_last_name' => $row->hostlastname,
        'sign_in_time' => $row->logintime,
        'room_number' => $row->hostroom,
        'hall_name' => $row->hallname,
        'overnight' => $row->overnight,
      ];
      $builder2 = $db->table($fail);
      $builder2->insert($data);

      echo "<br>";
      echo "<tr>";
      echo "<td>" . $row->hostid . "</td> <br>";
      echo "<td>" . $row->guest_id . "</td> <br>";
      echo "<td>" . $row->guestfirstname . "</td> <br>";
      echo "<td>" . $row->guestlastname . "</td> <br>";
      echo "<td>" . $row->hallid . "</td> <br>";
      echo "<td>" . $row->hostfirstname . "</td> <br>";
      echo "<td>" . $row->hostlastname . "</td> <br>";
      echo "<td>" . $row->logintime . "</td> <br>";
      echo "<td>" . $row->hostroom . "</td> <br>";
      echo "<td>" . $row->hallname . "</td> <br>";
      echo "<td>" . $row->overnight . "</td> <br>";
      echo "</tr> <br>";
    }
  }
}
