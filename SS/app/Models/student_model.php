<?php
//? Debug query
// helper("custom1_helper");
// $debug = debug($db);
// echo $debug;

namespace App\Models;

use CodeIgniter\Model;

class student_model extends Model
{
  // Card Office DB
  protected $CardDB = 'cardOffice';
  protected $db;
  protected $table = 'ResLifeView';
  protected $log = 'log_test';
  protected $ban = 'banned_list';
  protected $clock = 'log_time_clock';

  public function getStudent($data)
  {
    $id = $data["id"];
    $session = session();
    $hall = $session->get("building_code");
    $db = \Config\Database::connect($this->CardDB);
    $table = $this->table;
    $builder = $db->table($table);
    $builder->where('BANNER_ID', $id);
    $builder->select('BANNER_ID, BUILDING, FIRST_NAME, LAST_NAME, EMAIL_ADDR, ROOM_NUM, IMAGE, prefName');
    if ($hall == "NCM" || $hall == "NCT" || $hall == "NC") {
      $where = "(BUILDING LIKE'%NCT%' ESCAPE'!' OR 'BUILDING'='NCM' )";
      $builder->where($where);
    } elseif ($session->get()) {
      $parameters = [
        "BANNER_ID" => $id,
        "BUILDING" => $hall,
      ];
      $builder->where($parameters);
    } else {
      $builder->where("BUILDING", $hall);
    }
    $query = $builder->get();
    $data = $query->getRow();
    // if a student is found then
    if (isset($data)) {
      if (isset($data->prefName)) {
        $fname = $data->prefName;
      } else {
        $fname = $data->FIRST_NAME;
      }
      $session = session();
      $session->set(array(
        "student_id" => $data->BANNER_ID,
        "student_first" => $fname,
        "student_last"  => $data->LAST_NAME,
        "student_email" => $data->EMAIL_ADDR,
        "student_hall"  => $data->BUILDING,
        "student_room"  => $data->ROOM_NUM,
        "student_image"  => $data->IMAGE,
      ));
      return $query;
    }
    return false;
  }

  public function getVisitor($id)
  {
    $session = session();
    $db = \Config\Database::connect($this->CardDB);
    $table = $this->table;
    $builder = $db->table($table);
    $builder->select('BANNER_ID, BUILDING, FIRST_NAME, LAST_NAME, EMAIL_ADDR, ROOM_NUM, IMAGE, prefName');
    $builder->where("BANNER_ID", $id);
    $query = $builder->get();

    $data = $query->getRow();
    // if a guest is found then
    if (isset($data)) {
      if (isset($data->prefName)) {
        $fname = $data->prefName;
      } else {
        $fname = $data->FIRST_NAME;
      }

      $session = session();
      $session->set(array(
        "guest_id" => $data->BANNER_ID,
        "guest_first" => $fname,
        "guest_last"  => $data->LAST_NAME,
        "guest_email" => $data->EMAIL_ADDR,
        "guest_hall"  => $data->BUILDING,
        "guest_room"  => $data->ROOM_NUM,
        "guest_image"  => $data->IMAGE,
      ));
      return $query;
    }
    return false;
  }

  public function ViewCurrentguest()
  {
    //* CI4
    $session = session();
    $today_2_am = date("Y-m-d 02:00:00", strtotime('today'));
    $yesterday_2_am = date("Y-m-d 02:00:00", strtotime('yesterday'));
    $today_noon = date("Y-m-d 12:00:00", strtotime('today'));
    $today_midnight = date('Y-m-d 00:00:01', strtotime('yesterday'));
    $hall_id = $session->get("hallid");
    $regular_fail = "";
    $regular_fail2 = "";
    $now = date("Y-m-d H:i:s");

    if (date('Y-m-d H:i:s') < $today_noon) { // if before 12pm

    }
    /* //*CI3
    $today_2_am = date("Y-m-d 02:00:00", strtotime('today'));
    $yesterday_2_am = date("Y-m-d 02:00:00", strtotime('yesterday'));
    $today_noon = date("Y-m-d 12:00:00", strtotime('today'));
    $today_midnight = date('Y-m-d 00:00:01', strtotime('yesterday'));
    $hall_id = $this->session->userdata('hallId');
    $regular_fail ="";
    $regular_fail2 ="";
    $now = date("Y-m-d H:i:s");
    if(date('Y-m-d H:i:s') < $today_noon){ // if before 12pm
      if(($now > $today_midnight) && ($now < $today_2_am)){
      $regular_fail= "(logouttime is NULL AND hallid ='".$hall_id."' AND logintime > '".$yesterday_2_am."' AND overnight='0')";
              //$this->db->where('logintime < "'.$yesterday_2_am.'"');
      }
      else
      {
        $regular_fail= "(logouttime is NULL AND hallid ='".$hall_id."' AND logintime > '".$today_2_am."' AND overnight='0')";
          // $this->db->where('logintime < "'.$today_2_am.'"');
      }

    //$string = '(logouttime is NULL AND hallid ="'.$hall_id.'"  AND logintime > "'.$today_2_am.'" AND overnight = "0") OR (logouttime is NULL AND hallid = "'.$hall_id.'" AND overnight = "1")'; 
      $string = $regular_fail.' OR (logouttime is NULL AND hallid = "'.$hall_id.'" AND logintime > "'.$yesterday_2_am.'" AND overnight = "1")';
    }
    else{//if after 12pm
      if(($now > $today_midnight) && ($now < $today_2_am)){

        $regular_fail2= "(logouttime is NULL AND hallid ='".$hall_id."' AND logintime > '".$yesterday_2_am."' AND overnight='0')";
              //$this->db->where('logintime < "'.$yesterday_2_am.'"');
      }
      else
      {
        $regular_fail2= "(logouttime is NULL AND hallid ='".$hall_id."' AND logintime > '".$today_2_am."' AND overnight='0')";
        // $this->db->where('logintime < "'.$today_2_am.'"');
      }
      $string = $regular_fail2.' OR (logouttime is NULL AND hallid = "'.$hall_id.'"  AND logintime > "'.$today_noon.'" 
        AND overnight = "1")';
    }

    $query = $this->db->select('*')->from('log_test')->where($string)->order_by('hostfirstname','ASC')->get();
    return $query->result();
  }
  */
  }

  public function CheckSignedInThisWeek($id)
  {
    $last_week = strtotime("-1 week +1 day");
    $last_week = date("Y-m-d H:i:s", $last_week);
    $db = $this->db;
    $table = $this->log;
    $builder = $db->table($table);
    $builder->where('hostid', $id);
    $builder->where('logintime >', $last_week);
    $query = $builder->get();
    $num_rows = $query->getNumRows();
    $message = "" . img('images/attention.png') . "<br />Guest is currently signed-in in this building.";
    return array('message' => $message, 'rows' => $num_rows);
  }

  public function CheckCurrentlySignedIn($column, $id)
  {
    $session = session();
    $db = $this->db;
    $table = $this->log;
    $builder = $db->table($table);
    $builder->where($column, $id);
    $builder->where('logouttime IS NULL', null, false);
    $hallid = $session->get('hallid');
    if (is_array($hallid)) {
      $builder->whereIn('hallid', $hallid);
    } else {
      $builder->where('hallid', $hallid);
    }
    $query = $builder->get();

    $num_rows = $query->getNumRows();
    if ($column == 'hostid') {
      $message = "" . img('images/attention.png') . "<br />Cannot sign in guest because guest hasn't logged out from another building ID " . $id . "";
    } else { // guest
      $message = "" . img('images/attention.png') . "<br />Guest is currently signed-in in this building.";
    }
    return array('message' => $message, 'rows' => $num_rows);
  }

  public function CheckBannedList($data)
  {
    $session = session();
    $hall = $session->get('hallid');
    $fname = str_replace("'", "", $data['guest_fname']);
    $lname = str_replace("'", "", $data['guest_lname']);
    $sid = $data['studentID'];
    $gid = $data['guest_id'];
    $db = $this->db;
    $table = $this->ban;
    $builder = $db->table($table);
    $builder->where('name_first', $fname);
    $builder->where('name_last', $lname);
    if (is_array($hall)) {
      $builder->whereIn('hallid', $hall);
    } else {
      $builder->where('hallid', $hall);
    }
    $builder->orWhere('name_first', $fname);
    $builder->where('name_last', $lname);
    $builder->where('all_halls', 1);
    $builder->orWhere('name_first', $fname);
    $builder->where('name_last', $lname);
    $builder->where('campus', 1);
    $builder->orWhere('student_id', $gid);
    $builder->orWhere('student_id', $sid);
    $builder->join('halls', 'banned_list.hallid = halls.hall_id', 'left');
    $query = $builder->get();

    $num_rows = $query->getNumRows();
    if ($query->getNumRows() > 0) {
      $row = $query->getRow();
      if ($row->campus ==  1) {
        $hall = 'Campus';
      } elseif ($row->all_halls == 1) {
        $hall = 'all halls';
      } else {
        $hall = $row->hall_name;
      }
      $halls_banned = $hall;
      $fname = $row->name_first;
      $lname = $row->name_last;
      $address = $row->DOB;
      $dob = $row->address;
      $img = array('src' => 'images/police.png', 'width' => '256', 'height' => '256', 'id' => 'police_img');
      $message = " " . img($img) . " <br /><h2 style='font-size:200%;'><u>
      " . $fname . " " . $lname . "</u> is banned from " . $halls_banned . "</h2><br /><br /><h2 style='font-size:200%;'>
      DOB: " . $dob . "<br />
      Address: " . $address . "<br /><br />
      <h2 style='font-size:200%;'>You must check with the Director on Duty by calling primary: (203) 901-5944 or secondary: (203)901-5917 to verify";
      return (array('message' => $message, 'rows' => $num_rows));
    } else {
      return array('message' => $query, 'rows' => $num_rows);
    }
  }

  public function CheckForOvernights($data)
  {
    $fname = $data['fname'];
    $lname = $data['lname'];
    $guest_id = $data['guest_id'];
    // $lastweek = date("Y-m-d 00:00:00", strtotime('monday this week'));
    $last_week = strtotime("-1 week +1 day");
    $lastweek = date("Y-m-d H:i:s", $last_week);
    $midnight = date("Y-m-d 00:00:00", strtotime('midnight'));
    $db = $this->db;
    $table = $this->log;
    $builder = $db->table($table);
    $builder->select('id, overnight');
    $builder->where('hostid', $guest_id);
    $builder->where('overnight', 1);
    $builder->where('logintime >', $midnight);
    $builder->orWhere('hostfirstname', $fname);
    $builder->where('hostlastname', $lname);
    $builder->where('overnight', 1);
    $builder->where('logintime >', $midnight);
    $query = $builder->get();

    if ($query->getNumRows() == 0) { // no overnights since midnight
      $builder = $db->table($table);
      $builder->select('id, overnight');
      $builder->where('hostid', $guest_id);
      $builder->where('overnight', 1);
      $builder->where('logintime >', $lastweek);
      $builder->orWhere('hostfirstname', $fname);
      $builder->where('hostlastname', $lname);
      $builder->where('overnight', 1);
      $builder->where('logintime >', $lastweek);
      $query = $builder->get();

      if ($query->getNumRows() > 2) { // 2 overnights
        $message = "" . img('images/attention.png') . "<br />You cannot sign in guest because guest has already been signed in overnight 2 times this week";
        return array('message' => $message, 'proceed' => 'no');
      } else {
        $message = "OK, go on";
        return array('message' => $message, 'proceed' => 'yes');
      }
    } else {
      $message = "" . img('images/attention.png') . "<br />Guest was already signed in as an overnight guest today.";
      return array('message' => $message, 'proceed' => 'no');
    }
  }

  public function SaveToDatabase($data)
  {
    $session = session();
    $db = $this->db;
    $table = $this->log;
    $parameters = [
      'hostid' => $data['studentID'],
      'guestid' => $data['guest_id'],
      'logintime' => date("Y-m-d H:i:s"),
    ];
    $builder = $db->table($table);
    $builder->where($parameters);
    $query = $builder->get();
    if ($query->getNumRows() > 0) {
      log_message('error', 'duplicate db entry detected. preventing repeat.');
      return "" . img('images/error.png') . "<br />Error already signed in guest";
    } else {
      $hall = $data['hall'];
      $mod = new Others();
      $hallid = $mod->hallABVToid($hall);
      $parameters = [
        'hallid' => $hallid,
        'logintime' => date("Y-m-d H:i:s"),
        'hostid' => $data['studentID'],
        'hostfirstname' => $data['fname'],
        'hostlastname' => $data['lname'],
        'hostroom' => $data['room'],
        'guestfirstname' => $data['guest_fname'],
        'guestlastname' => $data['guest_lname'],
        'guestid' => $data['guest_id'],
        'guestidtype' => $data['guest_id_type'],
        'state' => $data['state'],
        'other_guestidtype' => $data['other_type_of_id'],
        'overnight' => $data['overnight'],
        'birthdate' => $data['bday'],
        'license_plate' => $data['guest_license_plate'],
        'type_of_car' => $data['guest_type_of_car'],
        'email' => $data['email'],
        // 'staff_id' => $data['staff_id'],
      ];
      $builder = $db->table($table);
      $builder->insert($parameters);
      $query =  $builder->get();
      if ($query) {
        // query was successful
        return "" . img('images/success.png') . "<br />Student has successfully signed in guest";
      } else {
        return "" . img('images/error.png') . "<br />Error signing in guest";
      }
    }
  }

  public function SignIn($data)
  {
    $studentID = $data['studentID'];
    $guest_id = $data["guest_id"];
    $bday = $data['bday'];
    $bday = strtotime($bday);
    if (time() - $bday < 18 * 31536000) {
      return ("" . img('images/attention.png') . "<br /><strong>Guest is under 18. Parental consent form required for entry.</strong>");
    }
    if (time() - $bday < 16 * 31536000) {
      return ("" . img('images/attention.png') . "<br /><strong>Guest is under 16. Guest is not allowed to be signed in.</strong>");
    }

    $lookup = $this->CheckCurrentlySignedIn('guestid', $guest_id);
    if ($lookup['rows'] > 0) {
      return $lookup['message'];
    }

    $lookup = $this->CheckCurrentlySignedIn('hostid', $studentID);
    if ($lookup['rows'] < 3) {
      // host must have less than 3 guest signed in
      $lookup = $this->CheckBannedlist($data);
      if ($lookup['rows'] == 0) {
        // no one was found in the check list
        if ($data['overnight'] == 1) {
          // Guest is staying overnight
          $lookup = $this->CheckforOvernights($data);
          if ($lookup['proceed'] == "yes") {
            //data has been inserted to database
            $data = $this->SaveToDatabase($data);
            return $data;
          } else {
            //return host can't sign overnights
            return "Guest is not allowed to sign in overnight. Either guest has signed someone in as overnight today or guest has reached the limit of two overnights a week";
          }
        } else {
          //data has been inserted to database
          $data = $this->SaveToDatabase($data);
          return $data;
        }
      } else {
        // Someone is banned
        return $lookup['message'];
      }
    } else {
      // host has more than 3 guest signed in
      return $lookup['message'];
    }
  }

  public function showguestList($check)
  {
    $session = session();
    $hallid = $session->hallid;
    $host_id = $session->student_id;
    $db = $this->db;
    $table = $this->log;
    $builder = $db->table($table);
    $builder->where('logouttime is NULL', NULL, FALSE);
    // $builder->where('hallid', $hallid);
    $hallIds = $session->get('hallid');
    if (is_array($hallIds)) {
      $builder->whereIn("hallid", $hallIds);
    } else {
      $builder->where("hallid", $hallIds);
    }
    if ($check) {
      $builder->where('hostid', $host_id);
    }
    $builder->orderBy('logintime', 'DESC');
    $query = $builder->get();
    return $query->getResult();
  }

  public function signOut($tablename, $id)
  {
    $now = date('Y-m-d H:i:s');
    $now = date_create()->format('Y-m-d H:i:s');
    $db = $this->db;
    $table = $this->$tablename;
    $builder = $db->table($table);
    $builder->where('id', $id);
    $builder->set('logouttime', $now);
    $query = $builder->update();
    return $query;
  }

  public function searchStudent($data)
  {
    $db = \Config\Database::connect($this->CardDB);
    $table = $this->table;
    $builder = $db->table($table);
    $builder->where('BUILDING <>', '');
    $builder->where('BUILDING IS NOT NULL', NULL, FALSE);
    $builder->like('FIRST_NAME', $data['fname']);
    $builder->like('LAST_NAME', $data['lname']);
    $builder->orLike('prefName', $data['fname']);
    $builder->like('LAST_NAME', $data['lname']);
    $builder->orderBy('FIRST_NAME', 'ASC');
    $query = $builder->get();
    return $query->getResult();
  }

  public function GetSearchSelectedStudent($id)
  {
    $db = \Config\Database::connect($this->CardDB);
    $table = $this->table;
    $builder = $db->table($table);
    $builder->where('BANNER_ID', $id);
    $builder->orderBy('FIRST_NAME', 'ASC');
    $query = $builder->get();
    return $query->getRow();
  }

  public function getStaff($id)
  {
    $db = \Config\Database::connect($this->CardDB);
    $table = $this->table;
    $builder = $db->table($table);
    $builder->where('BANNER_ID', $id);
    $query = $builder->get();
    return $query;
  }

  public function getBannedList()
  {
    $db = $this->db;
    $table = $this->ban;
    $builder = $db->table($table);
    $builder->join('halls', 'halls.hall_id = banned_list.hallid');
    $query = $builder->get();
    return $query;
  }

  public function clockCheck($data)
  {
    $db = $this->db;
    $table = $this->clock;
    $builder = $db->table($table);
    $builder->where('logouttime is NULL', NULL, FALSE);
    $builder->where('hostid', $data['id']);
    $query = $builder->get();
    $time_in = '';

    helper("custom1_helper");
    echo debug($db);

    if ($query->getNumRows() > 0) {
      foreach ($query->getResult() as $row) {
        $time_in = $row->logouttime;
        break;
      }
    } else {
      $time_in = 'empty';
    }
    $session = session();
    $hallIds = $session->get('hallid');
    if (is_array($hallIds)) {
      $hallIds = 6;
    }
    if ($time_in == 'empty') { // insert
      $values = array(
        'hallid' => $hallIds,
        "hall_sign_out" => 0,
        'hostid' => $data['id'],
        'hostfirstname' => $data['fname'],
        'hostlastname' => $data['lname'],
      );
      $builder3 = $db->table($table);
      $builder3->set('logintime', 'NOW()', FALSE);
      $builder3->insert($values);
      return "" . img('images/success.png') . "<br />Clocked in!";
    } else { // logout
      $builder2 = $db->table($table);
      $builder2->set('hall_sign_out', $hallIds);
      $builder2->set('logouttime', 'NOW()', FALSE);
      $builder2->where('hostid', $data['id']);
      $query = $builder2->update();
      return "" . img('images/success.png') . "<br />Clocked out!";
    }
  }
}
