<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\service_model;
use App\Models\Logging;
use App\Models\Others;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Service extends BaseController
{
  public function index()
  {
    helper('form');
    helper('html');
    $session = session();
    $session->set('last_viewed', 'service');
    echo view('template/header');
    echo view('template/searchBar');
    echo view('Service/service');
    echo view("template/jsFunctions");
    echo view('template/footer');
  }

  public function serviceLog()
  {
    helper('form');
    helper('html');
    $mod = new Logging();
    $data['query'] = $mod->log('service', false);
    echo view('template/header');
    echo view('template/searchBar');
    echo view('Service/serviceLog', $data);
    echo view("template/jsFunctions");
    echo view('template/footer');
  }

  public function ServiceIn()
  {
    $session = session();
    $guest_hall = $session->get("guest_hall");
    $mod = new Others();
    $guest_hall = $mod->hallABVToid($guest_hall);
    $input = [
      'hallid' => $guest_hall,
      'hostid' => $_POST['guest_Id'],
      'hostfirstname' => $_POST['guest_first_name'],
      'hostlastname' => $_POST['guest_last_name'],
      'hostroom' => $_POST['room'],
      'workorder' => $_POST['work_order'],
      'idtype' => $_POST['guest_id_type'],
      'service' => $_POST['service'],
      'staff_id' => $_POST['staff'],
    ];
    $mod = new Logging();
    $query = $mod->add_entry($input, 'service');
    if ($query > 0) {
      // Signed in
      echo view('template/success');
      return redirect()->to('/service');
    } else {
      // failed
      echo view('template/failed');
      return redirect()->to('/service');
    }
  }

  public function SignOutService()
  {
    $id = $_GET['id'];
    $mod = new Logging();
    $query = $mod->checkOut_entry($id, 'service');
    if ($query > 0) {
      return redirect()->to('/serviceLog');
    } else {
      return redirect()->to('/error');
    }
  }
}
