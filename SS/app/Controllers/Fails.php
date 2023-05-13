<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Failed;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Fails extends BaseController
{
  public function index() //* /showFailed
  {
    helper('html');
    helper('form');
    $session = session();
    $session->set('last_viewed', 'failed');
    echo view("template/header");
    echo view("template/searchBar");
    echo view("failed/failed");
    echo view("template/jsFunctions");
    echo view("template/footer");
  }

  public function regular()
  {
    helper('html');
    helper('form');
    $mod = new Failed();
    $data['query'] = $mod->regular();
    echo view("template/header");
    echo view("template/searchBar");
    echo view("failed/regular", $data);
    echo view("template/jsFunctions");
    echo view("template/footer");
  }

  public function overnight()
  {
    helper('html');
    helper('form');
    $mod = new Failed();
    $data['query'] = $mod->overnight();
    echo view("template/header");
    echo view("template/searchBar");
    echo view("failed/overnight", $data);
    echo view("template/jsFunctions");
    echo view("template/footer");
  }

  public function updateFailed()
  {
    $mod = new Failed();
    $reg = $mod->updateRegularFailed();
    $nig = $mod->updateOvernightFailed();
  }

  public function sendFailedEmails()
  {
    $mod = new Failed();
    $mod->emailFails();
  }
}
