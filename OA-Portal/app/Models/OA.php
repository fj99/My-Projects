<?php

namespace App\Models;

use CodeIgniter\Model;

class OA extends Model
{
  protected $oa = 'oa_request';
  protected $oas = 'OAs';
  protected $staff = 'staff';
  protected $hd = 'hall_directors';
  protected $db;
  protected $halls = 'halls';

  public function GetRequest($page, $order, $designer, $status, $sort, $priority, $closest, $farthest)
  {
    $db = $this->db;
    $oa = $this->oa;
    $builder = $db->table($oa);
    if ($order != '') {
      $builder->orderBy($order . " " . $sort);
    } else {
      $builder->orderBy("id", "DESC");
    }

    if ($status != '') {
      $builder->where("Status", $status);
    } elseif ($designer == '') {
      $builder->where("assigned_to", $designer);
      $builder->orWhere("assigned_to", "default");
    } elseif ($designer != '') {
      $builder->where("assigned_to", $designer);
    } elseif ($priority != '') {
      $builder->where("priority", $priority);
    } elseif ($closest) {
      $builder->where("Status !=", "Complete");
      $builder->where("Status !=", "Denied");
      $builder->where("requested_completion_date >", date("Y-m-d", strtotime("now")));
      $builder->orderBy("requested_completion_date", "ASC");
    } elseif ($farthest) {
      $builder->where("Status !=", "Complete");
      $builder->where("Status !=", "Denied");
      $builder->where("requested_completion_date >", date("Y-m-d", strtotime("now")));
      $builder->orderBy("requested_completion_date", "DESC");

      // incomplete
    } else {
      $builder->where("Status !=", "Complete");
      $builder->where("Status !=", "Denied");
    }

    $offset = ($page - 1) * 50;
    $builder->limit(50, $offset);
    $query = $builder->get();
    $db->close();
    // echo $db->getLastQuery();
    return $query;
  }

  public function GetOAs()
  {
    $db = $this->db;
    $oas = $this->oas;
    $builder = $db->table($oas);
    $builder->where("active", 1);
    $query = $builder->get();
    $db->close();
    return $query;
  }

  public function Change($data, $input)
  {
    $db = $this->db;
    $table = $this->oa;
    $builder = $db->table($table);
    $column = $data[$input];
    $builder->set($input, $column);
    $builder->where("id", $data["id"]);
    $query = $builder->update();
    $db->close();
    return $query;
  }

  public function TwoChanges($data, $input, $s_input)
  {
    $db = $this->db;
    $table = $this->oa;
    $builder = $db->table($table);
    $column = $data[$input];
    $builder->set($input, $column);
    $s_column = $data[$s_input];
    $builder->set($s_input, $s_column);
    $builder->where("id", $data["id"]);
    $query = $builder->update();
    $db->close();
    return $query;
  }

  public function Send_emails($data)
  {
    $db = $this->db;
    $table = $this->oa;
    $builder = $db->table($table);
    $builder->select();
    $builder->where("id", $data["id"]);
    $query = $builder->get();
    $row = $query->getRow();
    $comment = $row->comments;
    $user = $row->user;
    $oa = $row->assigned_to;
    $hall = $row->location;
    $id = $data["id"];
    // $event_title = $row->title;

    $email = \Config\Services::email();
    $to = 'fernandezf2@southernct.edu'; //* Test
    $cc = '';
    // $to = $user; //* Production

    if ($data['status'] == "Denied") {
      $subject = "Your OA Request has been denied";
      $message = "Your OA Request numbered - " . $id . " - has been denied by " . $oa . ".  The request you submitted was unusable.  Please contact Marvin Wilson at wilsonm1@southernct.edu for clarification.";
    } elseif ($data['status'] == "Student Unavailable") {
      $subject = "Your OA Request cannot be completed";
      $message = "Your OA Request pertaining to $event_title with ID Number - " . $id . " - is not able to be completed by " . $oa . ". The student who made the request was unavailable at the time designated. Please contact the student who made the request to get a new frame of availability. WHO DO THEY CONTACT WITH THIS?";
    } elseif ($data['status'] == "oas") {
      $table = $this->oas;
      $builder = $db->table($table);
      $builder->select();
      $builder->where("name", $oa);
      $query2 = $builder->get();
      $row2 = $query2->getRow();
      $username = $row2->username;
      $subject = "You have been assigned a new OA Request";
      // This link is to send them directly to the view
      $link = 'https://dev-pubweb06.scsu.southernct.edu/playground/felix/SCSU-Work/OA-Portal/public/index.php/view/';
      $message = "Hello, You have been assigned an OA Request.  Click on the link below to access the request  ----  "  .  $link .  $id;
      $to = 'fernandezf2@southernct.edu, fernandezf2@southernct.edu'; //* Test
      // $email->setTo($username."@southernct.edu"); //* Production

    } elseif ($data['status'] == "no response") {
      //! Todo: Build this email response
      $subject = "This is a test";
      $message = "Testing";
    } elseif ($data['status'] == "delivered") {
      //! Todo: Build this email response
      $subject = "This is a test";
      $message = "Testing";
    } elseif ($data['status'] == "see comments") {
      //! Todo: Build this email response
      $subject = "This is a test";
      $message = "Testing";
    } elseif ($data['status'] == "Complete") {
      $subject = "Your OA Request has been completed";
      $message = "Your OA Request with ID Number - " . $id . " - has been completed, by " . $oa . " and these are the comments: " . $comment;
      // send an email to hall director
      if ($hall != "other") {
        // if $hall is not an integer you must do a join with halls table where hall_name else:
        $table = $this->hd;
        $builder = $db->table($table);
        $builder->select('email');
        $builder->where("hall_id", $hall);
        $query3 = $builder->get();
        $row3 = $query3->getRow();
        echo $db->getLastQuery();

        $hd_mail = $row3->email;

        $email->setFrom('Reslife@southernct.edu', 'Reslife');
        $email->setTo($hd_mail);
        $email->setSubject("An OA Request has been completed");
        $email->setMessage("The OA Request with ID Number - " . $id);
        $email->send();
      }
      // add people from staff table to the emails
      $table = $this->staff;
      $builder = $db->table($table);
      $builder->select('username');
      $builder->where("oa_requests", 1);
      $query4 = $builder->get();
      foreach ($query4->getResult() as $row) {
        $email = $row->username;
        $cc .= "," . $email;
      }
    }

    $email = \Config\Services::email();
    $email->setFrom('Reslife@southernct.edu', 'Reslife');
    $email->setTo($to);
    $email->setCC($cc); //* Production
    $email->setSubject($subject);
    $email->setMessage($message);
    $db->close();
    return $email->send();
  }

  public function View($id)
  {
    $db = $this->db;
    $table = $this->oa;
    $builder = $db->table($table);
    $builder->select();
    $builder->where("id", $id);
    $query = $builder->get();
    $db->close();
    return $query;
  }

  public function buildings()
  {
    // Create your query builder, which opens a connection, and include the table you want
    $builder = $this->db->table($this->halls);
    // Build the query, in this case we want to SELECT * from halls, so this works.
    $builder->get();
    // Create Query variable for return
    $query = $builder->get();
    // Close DB
    $this->db->close();
    // return your query
    return $query;
  }

  public function verify($data)
  {
    $db = $this->db;
    $table = $this->oa;
    $builder = $db->table($table);
    $query = $builder->insert($data);
    if ($db->affectedRows() == 1) {
      $query = true;
    } else {
      $query = false;
    }
    return $query;

    # code...
  }
}
