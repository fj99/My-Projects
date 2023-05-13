<?php

namespace App\Models;

use CodeIgniter\Model;

class Graphics extends Model
{
  protected $graphics = 'graphic_request';
  protected $designers = 'Graphic_designers';
  protected $printing = 'printing_request';
  protected $attachmentP = 'printing_request_attachments';
  protected $attachmentG = 'graphic_request_attachments';
  protected $db;

  public function Designers()
  {
    $db = $this->db;
    $designers = $this->designers;
    $builder = $db->table($designers);
    $builder->where("active", 1);
    $query = $builder->get();
    $db->close();
    return $query;
  }

  public function GraphicsView($id)
  {
    $db = $this->db;
    $graphics = $this->graphics;
    $builder = $db->table($graphics);
    $builder->select('graphic_request.id, first_name, last_name, user, contact_primary, event_title, event_date, location, event_start_time, event_end_time, television_request, requested_completion_date, graphic_request.description, posters_custom_width, posters_custom_tall, amount_needed_flyers, flyers_orientation, amount_requested, graphic_request.date, file_name, image');
    $builder->join('graphic_request_attachments', 'graphic_request.id = graphic_request_attachments.request_id', 'left');
    $builder->where("graphic_request.id", $id);
    $query = $builder->get();
    $db->close();

    // echo $db->getLastQuery();

    return $query;
  }

  public function PrintsView($id)
  {
    $db = $this->db;
    $print = $this->printing;
    $builder = $db->table($print);
    $builder->select('printing_request.id, first_name, last_name, user, contact_primary, location, television_request, requested_completion_date, printing_request.description, posters_custom_width, posters_custom_tall, amount_needed_flyers, flyers_orientation, amount_requested, printing_request.date, file_name, image');
    $builder->join('printing_request_attachments', 'printing_request.id = printing_request_attachments.request_id', 'left');
    $builder->where("printing_request.id", $id);
    $query = $builder->get();
    $db->close();

    // echo $db->getLastQuery();

    return $query;
  }

  public function GetGraphics($page, $order, $designer, $status, $sort)
  {
    $db = $this->db;
    $graphics = $this->graphics;
    $builder = $db->table($graphics);
    if ($order != '') {
      $builder->orderBy($order . " " . $sort);
    } else {
      $builder->orderBy("id", "DESC");
    }
    if ($status == "Complete") {
      $builder->where("complete", "Yes");
    } elseif ($status == "Denied") {
      $builder->where("complete", "Denied");
    } else {
      $builder->where("complete !=", "Yes");
      $builder->where("complete !=", "Denied");
    }
    if ($designer != '') {
      $builder->where("assigned_to", $designer);
    }

    $offset = ($page - 1) * 50;
    $builder->limit(50, $offset);
    $query = $builder->get();
    $db->close();
    // echo $db->getLastQuery();
    return $query;
  }

  public function GetPrints($page, $order, $designer, $status, $sort)
  {
    $db = $this->db;
    $table = $this->printing;
    $builder = $db->table($table);
    if ($order != '') {
      $builder->orderBy($order . " " . $sort);
    } else {
      $builder->orderBy("id", "DESC");
    }
    if ($status == "Complete") {
      $builder->where("complete", "Yes");
    } elseif ($status == "Denied") {
      $builder->where("complete", "Denied");
    } else {
      $builder->where("complete !=", "Yes");
      $builder->where("complete !=", "Denied");
    }
    if ($designer != '') {
      $builder->where("assigned_to", $designer);
    }

    $offset = ($page - 1) * 50;
    $builder->limit(50, $offset);
    $query = $builder->get();
    $db->close();
    // echo $db->getLastQuery();
    return $query;
  }

  public function Change($data, $input, $table)
  {
    $db = $this->db;

    $n_table = $this->$table;
    //builder is a necessary variable to be able to write queries using framework support
    $builder = $db->table($n_table);
    //$column is built taking the input data passed from the controller and assigning it to the proper column($input)
    $column = $data[$input];

    $builder->set($input, $column);
    $builder->where("id", $data["id"]);
    //$query variable needs to be created so that the function has something to return
    $query = $builder->update();
    $db->close();
    return $query;
  }

  public function TwoChanges($data, $input, $s_input, $table)
  {
    $db = $this->db;
    $n_table = $this->$table;
    $builder = $db->table($n_table);
    $column = $data[$input];
    $builder->set($input, $column);
    $s_column = $data[$s_input];
    $builder->set($s_input, $s_column);
    $builder->where("id", $data["id"]);
    $query = $builder->update();
    $db->close();
    return $query;
  }

  public function Send_emails($data, $table)
  {

    $db = $this->db;
    $n_table = $this->$table;
    $builder = $db->table($n_table);
    $builder->select();
    $builder->where("id", $data["id"]);
    $query = $builder->get();
    $row = $query->getRow();
    $event_title = $row->event_title;
    $user = $row->user;
    $designer = $row->assigned_to;

    $email = \Config\Services::email();

    $email->setFrom('Reslife@southernct.edu', 'Reslife');
    // $email->setTo($user); //* Production
    $email->setTo('fernandezf2@southernct.edu'); //* Test
    // $email->setTo('hauserm3@southernct.edu'); //* Test
    // $email->setCC('dahlmand1@southernct.edu'); //* Production

    if ($data['complete'] == "Denied") {
      $subject = "Your Graphics Request has been Denied";
      $message = "Your Graphics Request pertaining to " . $event_title . " with ID Number - " . $data["id"] . " - has been denied by " . $designer . ". Because " . $data["reason"] . " .Please reach out to Diana Dahlmand at dahlmand1@southernct.edu";
    } elseif ($data['complete'] == "Yes") {
      $subject = "Your Graphics Request has been completed";
      $message = "Your Graphics Request pertaining to " . $event_title . " with ID Number - " . $data["id"] . " - has been completed by " . $designer . ".  Please stop by Residence Life to pick up your completed request.  ";
    }
    $email->setSubject($subject);
    $email->setMessage($message);
    return $email->send();
  }

  public function printingRequestFormNew($input)
  {
    $data = [
      'first_name' => $input['first'],
      'last_name' => $input['last'],
      'user' => $input['email'],
      'contact_primary' => $input['phone'],
      'location' => $input['building'],
      'requested_completion_date' => $input['date'],
      'television_request' => $input['tvs'],
      'posters_custom_width' => $input['pWidth'],
      'posters_custom_tall' => $input['pHeight'],
      'amount_needed_posters_custom' => $input['pAmount'],
      'flyers_orientation' => $input['fOrientation'],
      'amount_needed_flyers' => $input['fAmount'],
      'description' => $input['description'],
      'date' => date("y-m-d H:i:s"),
    ];

    $db = $this->db; //how to connect to default database
    $table = $this->printing;
    $builder = $db->table($table);
    $query0 = $builder->insert($data);

    $builder->selectMax('id');
    $query1 = $builder->get();
    foreach ($query1->getResult() as $row) {
      $request_id = $row->id;
    }

    $img = $input['file']['tmp_name'];
    $image = (file_get_contents($img));

    $file = [
      'request_id' => $request_id,
      'file_name' => $input['file']['name'],
      'description' => $input['description'],
      'date' => date("y-m-d H:i:s"),
      'image' => $image,
    ];

    $table = $this->attachmentP;
    $builder = $db->table($table);
    $query2 = $builder->insert($file);
    $db->close();

    $count = 0;
    $query0 ? $count++ : $count += 0;
    $query2 ? $count++ : $count += 0;

    return $count == 2;
  }

  public function graphicsRequestFormNew($input)
  {
    $data = [
      'first_name' => $input['first'],
      'last_name' => $input['last'],
      'user' => $input['email'],
      'contact_primary' => $input['phone'],
      'event_title' => $input['title'],
      'event_date' => $input['eventDate'],
      'location' => $input['building'],
      'event_start_time' => $input['startHour'] . ':' . $input['startMinute'] . $input['startAMPM'],
      'event_end_time' => $input['endHour'] . ':' . $input['endMinute'] . $input['endAMPM'],
      'type' => $input['allDay'],
      'television_request' => $input['tvs'],
      'requested_completion_date' => $input['requestDate'],
      'posters_custom_width' => $input['pWidth'],
      'posters_custom_tall' => $input['pHeight'],
      'amount_needed_posters_custom' => $input['pAmount'],
      'flyers_orientation' => $input['fOrientation'],
      'amount_needed_flyers' => $input['fAmount'],
      'description' => $input['description'],
      'date' => date("y-m-d H:i:s"),
    ];

    $db = $this->db;
    $table = $this->graphics;
    $builder = $db->table($table);
    $query0 = $builder->insert($data);

    $builder->selectMax('id');
    $query1 = $builder->get();
    foreach ($query1->getResult() as $row) {
      $request_id = $row->id;
    }

    $file = [
      'request_id' => $request_id,
      'file_name' => $input['file']['name'],
      'description' => $input['description'],
      'date' => date("y-m-d H:i:s"),
      'image' => $input['file']['tmp_name'],
    ];

    $table = $this->attachmentG;
    $builder = $db->table($table);
    $query2 = $builder->insert($file);
    $db->close();

    $count = 0;
    $query0 ? $count++ : $count += 0;
    $query2 ? $count++ : $count += 0;

    return $count;
  }
}
