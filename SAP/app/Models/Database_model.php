<?php

namespace App\Models;

use CodeIgniter\Model;

class Database_model extends Model
{
  protected $table1 = 'notifications';
  protected $table2 = 'user';

  public function getNotifications()
  {
    $db = $this->db;
    $table1 = $this->table1;

    $builder = $db->table($table1);
    $builder->select('*');
    $builder->where('status', 0);
    $query = $builder->get();
    $num = $builder->countAllResults();


    $db->close();

    return $query;
  }

  // public function getSearchedUserData_CI3()
  // {
  //   $search_query = $this->input->post("search_query");
  //   $type = intval($search_query);
  //   $this->db->select('*');
  //   if ($type != 0) {
  //     $this->db->where("id = '" . $type . "'");
  //   } else {
  //     $this->db->where("user = '" . $search_query . "'");
  //   }
  //   $data = $this->db->get('auth_dev_test');
  //   return $data;
  // }

  public function getSearchedUserData($search_query)
  {
    $db = $this->db;
    $table2 = $this->table2;
    $type = intval($search_query);

    $builder = $db->table($table2);
    $builder->select('*');
    if ($type != 0) {
      $builder->where("id", $type);
    } else {
      $builder->where("user", $search_query);
    }
    $data = $builder->get();
    return $data;
  }
}
