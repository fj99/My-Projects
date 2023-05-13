<?php

namespace App\Controllers;

use App\Controller\Home;

use App\Models\Others;
use CodeIgniter\Controller;
use App\Models\package_model;
use App\Models\Logging;
use App\Models\student_model;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Package extends BaseController
{
  public function index()
  {
    helper('form');
    helper('html');
    $session = session();
    $session->set('last_viewed', 'package');
    $first = [];
    $last = [];
    $data = [
      'first' => $first,
      'last' => $last,
    ];
    echo view("template/header");
    echo view("template/searchBar");
    echo view("Package/searchStudent", $data);
    echo view("template/jsFunctions");
    echo view("template/footer");
  }

  public function searchStudent()
  {
    helper('form');
    helper('html');
    $input = [
      'fname' => $_POST['first'],
      'lname' => $_POST['last'],
    ];
    $mod = new student_model();
    $data['query'] = $mod->searchStudent($input);
    echo view("template/header");
    echo view("template/searchBar");
    echo view("Package/selectFoundStudent", $data);
    echo view("template/jsFunctions");
    echo view("template/footer");
  }

  public function viewPackageLogOnly()
  {
    helper("custom1_helper");
    helper('form');
    helper('html');
    $mod = new logging();
    $data['query'] = $mod->log('package', false);
    echo view("template/header");
    echo view("template/searchBar");
    echo view("Package/packageLog", $data);
    echo view("template/jsFunctions");
    echo view("template/footer");
  }

  public function GetSearchSelectedStudent()
  {
    helper('form');
    helper('html');
    $id = $_GET['id'];
    $mod = new student_model();
    $data['query'] = $mod->GetSearchSelectedStudent($id);
    echo view("template/header");
    echo view("template/searchBar");
    echo view("Package/registerPackage", $data);
    echo view("template/jsFunctions");
    echo view("template/footer");
  }

  public function registerPackage()
  {
    helper('form');
    helper('html');
    $mod = new Others();
    $input1 = [
      'hallid' => $mod->hallABVToid($_POST['hallname']),
      'hostfirstname' => $_POST['hostfirstname'],
      'hostlastname' => $_POST['hostlastname'],
      'hostemail' => $_POST['email'],
      'hostroom' => $_POST['hostroom'],
      'tracking_num' => $_POST['tracking_num'],
      'carrier' => $_POST['carrier'],
      'staff_id' => $_POST['staff_id'],
    ];
    $input2 = [
      'hall' => $_POST['hallname'],
      'name' => '' . $_POST['hostfirstname'] . $_POST['hostlastname'],
      'hostemail' => $_POST['email'],
      'tracking_num' => $_POST['tracking_num'],
      'carrier' => $_POST['carrier'],
    ];
    $mod = new Logging();
    $query = $mod->add_entry($input1, 'package');
    if ($query) { // packages was added      
      $query = $mod->emailPackageHasBeenAdded($input2);
      if ($query) { // email has been sent
        return redirect()->to('/viewPackageLogOnly');
      } else {
        return redirect()->to('/error', 'package has been added but email has failed');
      }
    } else { // error
      return redirect()->to('/error', 'package could not be added');
    }
  }

  public function checkOutPackage()
  {
    $id = $_GET['id'];
    $mod = new Logging();
    $query = $mod->checkOut_entry($id, 'package');
    if ($query > 0) {
      return redirect()->to('/viewPackageLogOnly');
    } else {
      return redirect()->to('/error');
    }
  }
}
