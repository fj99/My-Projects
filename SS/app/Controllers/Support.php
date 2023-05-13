<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Others;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Support extends BaseController
{
  public function index() //* /support
  {
    helper('html');
    helper('form');
    $session = session();
    $session->set('last_viewed', 'support');
    echo view("template/header");
    echo view("template/searchBar");
    echo view("support/contact");
    echo view("template/jsFunctions");
    echo view("template/footer");
  }

  public function getSupport()
  {
    helper('html');
    $input = [
      'staff' => $_POST['staff'],
      'subject' => $_POST['subject'],
      'hall' => $_POST['hall'],
      'msg' => $_POST['message'],
    ];
    $mod = new Others();
    $mod->SendSupportMsg($input);

    return redirect()->to('/support');
  }
}
