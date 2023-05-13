<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Logging;
use App\Models\Others;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Equipment extends BaseController
{
  public function index()
  {
    helper('html');
    helper('form');
    $session = session();
    $data[''] = '';
    if ($session->has('data')) {
      $data['data'] = $session->get('data');
    }
    $session->set('last_viewed', 'equipment');
    echo view("template/header");
    echo view("template/searchBar");
    echo view("Equipment/CheckOutEquipment", $data);
    echo view("template/jsFunctions");
    echo view("template/footer");
  }

  public function EquipmentLog()
  {
    helper('html');
    helper('form');
    $mod = new Logging();
    $data['query'] = $mod->log('equip', false);
    echo view("template/header");
    echo view("template/searchBar");
    echo view("Equipment/log", $data);
    echo view("template/jsFunctions");
    echo view("template/footer");
  }

  public function returnEquipment()
  {
    helper('html');
    helper('form');
    $id = $_GET['id'];
    $mod = new Logging();
    $query = $mod->checkOut_entry($id, 'equip');
    if ($query) {
      return redirect()->to('/EquipmentLog');
    } else {
      return redirect()->to('/error');
    }
  }

  public function checkOutEquipment()
  {
    helper('html');
    helper('form');
    $session = session();
    $first = $_POST['first_name'];
    $last = $_POST['last_name'];
    $item = $_POST['item_type'];
    $mod = new Others();
    $input = [
      'hallid' => $mod->hallABVToid($_POST['hall']),
      'hostfirstname' => $_POST['first_name'],
      'hostlastname' => $_POST['last_name'],
      'hostroom' => $_POST['room'],
      'item' => $_POST['item_type'],
      'quantity' => $_POST['quantity'],
      'staff' => $_POST['staff'],
    ];
    $mod = new Logging();
    $query = $mod->add_entry($input, 'equip');
    if ($query) {
      $data =  " " . img('images/success.png') . "<br />" . $first . " " . $last . " has successfully checked out " . $item . " ";
    } else {
      $data = " " . img('images/attention.png') . "<br />ERROR <br />System has failed to check out " . $item . " " . $first . " " . $last . " .";
    }
    $session->setFlashdata('data', $data);
    return redirect()->to('/Equipment');
  }
}
