<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\student_model;
use App\Models\Others;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Clock extends BaseController
{
  public function index() //* /clock
  {
    helper('html');
    helper('form');
    $session = session();
    if ($session->has('fname')) {
      $data['query'] = [
        'id' => $session->get('id'),
        'fname' => $session->get('fname'),
        'lname' => $session->get('lname'),
        'img' => $session->get('img'),
      ];
    } elseif ($session->has('data')) {
      $data['data'] = $session->get('data');
    } else {
      $data[''] = '';
    }
    $session->set('last_viewed', 'timeclock');
    echo view("template/header");
    echo view("template/searchBar");
    echo view("clock/clockHome", $data);
    echo view("template/jsFunctions");
    echo view("template/footer");
  }

  public function clockIn()
  {
    helper('html');
    $input = [
      'id' => $_POST['staffId'],
      'fname' => $_POST['first_name'],
      'lname' => $_POST['last_name'],
    ];
    $mod = new student_model();
    $data = $mod->clockCheck($input);
    $session = session();
    $session->setFlashdata('data', $data);
    return redirect()->to('/clock');
  }

  public function staff()
  {
    helper('html');
    $id = $_POST['staffId'];
    $mod = new student_model();
    $query = $mod->GetSearchSelectedStudent($id);
    $session = session();
    if ($query) {
      $session->setFlashdata('id', $query->BANNER_ID);
      $session->setFlashdata('fname', $query->FIRST_NAME);
      $session->setFlashdata('lname', $query->LAST_NAME);
      $session->setFlashdata('img', $query->IMAGE);
    } else {
      $data = "" . img('images/error.png') . "<br />Error occurred!";
      $session->setFlashdata('data', $data);
    }
    return redirect()->to('/clock');
  }
}
