<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Logging;
use App\Models\Others;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Key extends BaseController
{
  public function index() //* /Key
  {
    helper('html');
    helper('form');
    $session = session();
    $session->set('last_viewed', 'key');

    $log_button = [
      [
        'name' => 'log_button',
        'value' => 'View log',
        'type' => 'submit',
        'content' => 'View log',
      ],
      [
        'label' => 'Check Out Key',
      ],
    ];

    $studentId = [
      [
        'name' => 'studentId',
        'value' => set_value('studentId', $session->get('student_id')),
        'placeholder' => '',
        'onClick' => "this.select();",
        'autocomplete' => 'off',
        'size' => 20
      ],
      [
        'label' => 'Student ID',
      ],
    ];

    $first_name = [
      [
        'name' => 'first_name',
        'value' => set_value('first_name', $session->get('student_first')),
        'placeholder' => '',
        'autocomplete' => 'off',
        'size' => 20
      ],
      [
        'label' => 'First name',
      ],
    ];

    $last_name = [
      [
        'name' => 'last_name',
        'value' => set_value('last_name', $session->get('student_last')),
        'placeholder' => '',
        'autocomplete' => 'off',
        'size' => 20
      ],
      [
        'label' => 'Last name',
      ],
    ];

    $email = [
      [
        'name' => 'email',
        'value' => set_value('email', $session->get('student_email')),
        'placeholder' => '',
        'autocomplete' => 'off',
        'size' => 20
      ],
      [
        'label' => 'E-mail',
      ],
    ];

    $hall = [
      [
        'name' => 'hall',
        'value' => set_value('hall', $session->get('student_hall')),
        'placeholder' => '',
        'autocomplete' => 'off',
        'size' => 20
      ],
      [
        'label' => 'Hall',
      ],
    ];

    $room = [
      [
        'name' => 'room',
        'value' => set_value('room', $session->get('student_room')),
        'placeholder' => '',
        'autocomplete' => 'off',
        'size' => 20
      ],
      [
        'label' => 'Room',
      ],
    ];

    $key = [
      [
        'name' => 'key',
        'placeholder' => '',
        'autocomplete' => 'off',
        'size' => 20
      ],
      [
        'label' => 'Key Number',
      ],
    ];

    $staff = [
      [
        'name' => 'staff',
        'value' => set_value('staff', $session->get('staff')),
        'placeholder' => '',
        'autocomplete' => 'off',
        'size' => 20
      ],
      [
        'label' => 'Staff',
      ],
    ];

    $checkOut_button = [
      [
        'name' => 'checkOut_button',
        'value' => 'Check Out Key',
        'type' => 'submit',
        'content' => 'Check Out Key',
      ],
    ];

    $data = [
      'studentId' => $studentId,
      'first_name' => $first_name,
      'last_name' => $last_name,
      'email' => $email,
      'hall' => $hall,
      'room' => $room,
      'key' => $key,
      'staff' => $staff,
      'log_button' => $log_button,
      'checkOut_button' => $checkOut_button,
    ];

    echo view("template/header");
    echo view("template/searchBar");
    echo view("Keys/Checkout", $data);
    echo view("template/jsFunctions");
    echo view("template/footer");
  }

  public function KeyLog()
  {
    helper('html');
    helper('form');
    $mod = new Logging();
    $data['query'] = $mod->log('key', false);
    echo view("template/header");
    echo view("template/searchBar");
    echo view("Keys/Log", $data);
    echo view("template/jsFunctions");
    echo view("template/footer");
  }

  public function returnKey()
  {
    $id = $_GET['id'];
    $mod = new Logging();
    $mod->checkOut_entry($id, 'key');
    return redirect()->to('/KeyLog');
  }

  public function checkOutKey()
  {
    $mod = new Others();
    $input = [
      'hallid' => $mod->hallABVToid($_POST['hall']),
      'hostid' => $_POST['studentId'],
      'hostfirstname' => $_POST['first_name'],
      'hostlastname' => $_POST['last_name'],
      'email' => $_POST['email'],
      'hostroom' => $_POST['room'],
      'keynum' => $_POST['key'],
      'staff' => $_POST['staff'],
    ];
    $mod = new Logging();
    $data['data'] = $mod->add_entry($input, 'key');
    return redirect()->to('/key');
  }
}
