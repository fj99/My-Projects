<?php

namespace App\Controllers;

use App\Models\Logging;
use CodeIgniter\Controller;

use App\Models\Others;
use App\Models\student_model;
use App\Models\Failed;

$validation = \Config\Services::validation();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Home extends BaseController
//? Build admin mode where u can look at all halls
{
    public function index()
    {
        helper('html');
        helper('form');
        $session = session();
        $error =  $session->getFlashdata('error');
        if ($session->get('result') != false) {
            $msg = $session->get('result');
        } elseif ($session->has('msg')) {
            $msg = $session->get('msg');
        } else {
            $msg = "You must click on the tab letters to move between pages<b>" . anchor('how_to', '<b><h1>CLICK HERE FOR HELP</h1></b>') . "";
        }
        $session->set('last_viewed', 'index');
        $mod = new Others();

        $studentID = [
            'name' => "studentID",
            'value' => $session->get('student_id'),
            'onClick' => "this.select();",
            'readonly' => 'readonly',
            'required' => true,
        ];

        $fname = [
            'name' => "fname",
            'value' => utf8_encode($session->get('student_first')),
            'readonly' => 'readonly',
            'required' => true,
        ];

        $lname = [
            'name' => "lname",
            'value' => utf8_encode($session->get('student_last')),
            'readonly' => 'readonly',
            'required' => true,
        ];

        $email = [
            'name' => "email",
            'value' => utf8_encode($session->get('student_email')),
            'readonly' => 'readonly',
            'autocomplete' => 'off',
            'required' => true,
        ];

        $hall = [
            'name' => "hall",
            'value' => utf8_encode($session->get('student_hall')),
            'readonly' => 'readonly',
            'required' => true,
        ];

        $room = [
            'name' => "room",
            'value' => utf8_encode($session->get('student_room')),
            'readonly' => 'readonly',
            'pattern' => ".{2,}",
            'required' => true,
        ];

        $guest_id = [
            'name' => "guest_id",
            'value' => $session->get('guest_id'),
            'onClick' => "this.select();",
            'autocomplete' => 'off',
            'required' => true,
        ];

        $guest_fname = [
            'name' => 'guest_fname',
            'value' => utf8_encode($session->get('guest_first')),
            'onClick' => "this.select();",
            'autocomplete' => 'off',
            'required' => true,
        ];

        $guest_lname = [
            'name' => 'guest_lname',
            'value' => utf8_encode($session->get('guest_last')),
            'onClick' => "this.select();",
            'autocomplete' => 'off',
            'required' => true,
        ];

        $guest_id_type = [
            [
                'name' => 'guest_id_type',
                'id' => 'guest_id_type',
                'onchange' => "changeFunc();",
                'class' => "form-control bg-white font-weight-normal"
            ],
            [
                'hoot_loot' => 'Hoot Loot',
                'state_dmv' => 'State DMV',
                'military' => 'Military ID',
                'passport' => 'passport',
                'other' => 'Other',
            ]
        ];

        $state = [
            [
                'name' => 'state',
                'id' => 'state',
            ],
            [
                'AL' => 'Alabama',
                'AK' => 'Alaska',
                'AZ' => 'Arizona',
                'AR' => 'Arkansas',
                'CA' => 'California',
                "CO" => "Colorado",
                "CT" => "Connecticut",
                "DE" => "Delaware",
                "DC" => "District Of Columbia",
                "FL" => "Florida",
                "GA" => "Georgia",
                "HI" => "Hawaii",
                "ID" => "Idaho",
                "IL" => "Illinois",
                "IN" => "Indiana",
                "IA" => "Iowa",
                "KS" => "Kansas",
                "KY" => "Kentucky",
                "LA" => "Louisiana",
                "ME" => "Maine",
                "MD" => "Maryland",
                "MA" => "Massachusetts",
                "MI" => "Michigan",
                "MN" => "Minnesota",
                "MS" => "Mississippi",
                "MO" => "Missouri",
                "MT" => "Montana",
                "NE" => "Nebraska",
                "NV" => "Nevada",
                "NH" => "New Hampshire",
                "NJ" => "New Jersey",
                "NM" => "New Mexico",
                "NY" => "New York",
                "NC" => "North Carolina",
                "ND" => "North Dakota",
                "OH" => "Ohio",
                "OK" => "Oklahoma",
                "OR" => "Oregon",
                "PA" => "Pennsylvania",
                "PR" => "Puerto Rico",
                "RI" => "Rhode Island",
                "SC" => "South Carolina",
                "SD" => "South Dakota",
                "TN" => "Tennessee",
                "TX" => "Texas",
                "UT" => "Utah",
                "VT" => "Vermont",
                "VA" => "Virginia",
                "WA" => "Washington",
                "WV" => "West Virginia",
                "WI" => "Wisconsin",
                "WY" => "Wyoming",
            ],
            ['CT']
        ];

        $other_type_of_id = [
            'name' => 'other_type_of_id',
            'id' => 'other_type_of_id',
        ];

        $bday = [
            'name' => 'bday',
            'type' => 'date',
        ];

        $time = date('H');
        if ($time > 19 || $time < 2) {
            $overnight = [
                'name' => 'overnight',
                'value' => '1',
                'onclick' => "toggle_visibility('overnight');",
            ];
        } else {
            $overnight = [
                'name' => 'overnight',
                'value' => '1',
                'onclick' => "toggle_visibility('overnight'); toggle_visibility('failed')",
            ];
        }

        $guest_type_of_car = [
            'name' => 'guest_type_of_car',
            'autocomplete' => 'off',
        ];

        $guest_license_plate = [
            'name' => 'guest_license_plate',
            'autocomplete' => 'off',
        ];

        $data = [
            "studentID" => $studentID,
            "fname" => $fname,
            "lname" => $lname,
            "email" => $email,
            "hall" => $hall,
            "room" => $room,
            "guest_id" => $guest_id,
            "guest_fname" => $guest_fname,
            "guest_lname" => $guest_lname,
            "guest_id_type" => $guest_id_type,
            "state" => $state,
            "other_type_of_id" => $other_type_of_id,
            "bday" => $bday,
            "overnight" => $overnight,
            "guest_type_of_car" => $guest_type_of_car,
            "guest_license_plate" => $guest_license_plate,

            "hd_message" => $mod->get_hd_message(),
            "data" => $msg,
            "error" => $error,
        ];
        $hall = $session->get("hallid");
        if ($hall != "") {
            echo view("template/header");
            echo view("template/searchBar");
            echo view("Home/home", $data);
            echo view("template/jsFunctions");
            echo view("template/footer");
        } else {
            echo view("notAllowed");
        }
    }

    public function cleardata()
    {
        $session = session();
        $session->set("student_image", "clean");
        $session->set("guest_image", "clean");
        $session->set(array(
            "student_first" => "",
            "student_id" => "",
            "student_last"  => "",
            "student_email" => "",
            "student_hall"  => "",
            "student_room"  => "",
        ));
        $session->set(array(
            "guest_id" => "",
            "guest_first" => "",
            "guest_last"  => "",
            "guest_hall"  => "",
            "guest_room"  => "",
        ));
        return redirect()->to('/home');
    }

    public function getStudent()
    {
        helper('html');
        helper('form');
        $input = [
            "id" => $_POST["studentId"]
        ];
        $mod = new student_model();
        $data = $mod->getStudent($input);
        $session = session();
        if ($data) {
            $session->set('result', false);
            return redirect()->to('/home');
        } else {
            $msg = "" . img('images/attention.png') . "<br /><b><h1>The host you searched for does not live in this hall.</h1></b><br />";
            $session->set('result', $msg);
            return redirect()->to('/home');
        }
    }

    public function getVisitor()
    {
        helper('html');
        helper('form');
        $id = $_POST["studentId"];
        if ($id == '') {
            $data = false;
        } else {
            $mod = new student_model();
            $data = $mod->getVisitor($id);
        }
        $session = session();
        echo ("<br>");
        if ($data) {
            $session->set('result', false);
            return redirect()->to('/home');
        } else {
            $msg = "" . img('images/attention.png') . "<br /><b><h1>The Guest you searched for could not be found.</h1></b><br />";
            $session->set('result', $msg);
            return redirect()->to('/home');
        }
    }

    public function signIn()
    {
        helper('html');
        helper('form');
        $validation = \Config\Services::validation();
        $session = session();
        // validation from student sign in
        $validation->setRule('studentId', 'Student ID', 'required|trim', array('The Student ID is required'));
        $validation->setRule('fname', 'First Name', 'required|trim', array('required' => 'Student\'s first name is required', 'trim' => 'There should no spaces between the student\'s name'));
        $validation->setRule('lname', 'Last Name', 'required|trim', array('required' => 'Student\'s last name is required', 'trim' => 'There should be no spaces between the student\'s name'));
        $validation->setRule('email', 'Email', 'required|trim|valid_email', array('required' => 'Student\'s southern email is required', 'trim' => 'There should be no spaces between the student\'s email', 'valid_email' => 'The email entered is not a valid southern email'));
        $validation->setRule('hall', 'Hall', 'required', array('required' => 'Student\'s hall is required'));
        $validation->setRule('room', 'Room', 'required', array('required' => 'Student\'s room number is required'));
        if ($validation->run() == TRUE) { //Failed validation
            $session->setFlashdata('error', $validation);
        } else {
            echo ('valid passed <br>');
            if (isset($_POST['overnight'])) {
                $overnight = $_POST['overnight'];
            } else {
                $overnight = '0';
            }
            $input = [
                "studentID" => $_POST['studentID'],
                "fname" => $_POST['fname'],
                "lname" => $_POST['lname'],
                "email" => $_POST['email'],
                "hall" => $_POST['hall'],
                "room" => $_POST['room'],
                "guest_id" => $_POST['guest_id'],
                "guest_fname" => $_POST['guest_fname'],
                "guest_lname" => $_POST['guest_lname'],
                "guest_id_type" => $_POST['guest_id_type'],
                "state" => $_POST['state'],
                "other_type_of_id" => $_POST['other_type_of_id'],
                "bday" => $_POST['bday'],
                "overnight" => $overnight,
                "guest_type_of_car" => $_POST['guest_type_of_car'],
                "guest_license_plate" => $_POST['guest_license_plate'],
            ];
            $mod = new student_model();
            $data = $mod->SignIn($input);
            $session->setFlashdata('msg', $data);
            return redirect()->to('/home');
        }
    }

    public function showStudentGuests($var = null)
    {
        helper('html');
        helper('form');
        $mod = new Logging();
        $data['query'] = $mod->log('log', true);
        echo view("template/header");
        echo view("template/searchBar");
        echo view("Home/signOutGuest", $data);
        echo view("template/jsFunctions");
        echo view("template/footer");
    }

    public function signOut()
    {
        $id = $_GET['id'];
        $mod = new student_model();
        $query = $mod->signOut('log', $id);
        if ($query) {
            return redirect()->to('/showStudentGuests');
        } else {
            return redirect()->to('/error');
        }
    }

    public function guests()
    {
        helper('form');
        helper('html');
        $session = session();
        $session->set('last_viewed', 'guests');
        $mod = new Logging();
        $data['query'] = $mod->log('log', false);
        echo view('template/header');
        echo view('template/searchBar');
        echo view('Home/guest', $data);
        echo view("template/jsFunctions");
        echo view('template/footer');
    }

    public function showBannedList()
    {
        helper('html');
        helper('form');
        $session = session();
        $session->set('last_viewed', 'bannedlist');
        $mod = new student_model();
        $data['query'] = $mod->getBannedList();
        echo view("template/header");
        echo view("template/searchBar");
        echo view("Home/banned_list", $data);
        echo view("template/jsFunctions");
        echo view("template/footer");
    }

    public function test()
    {
        $mod = new Failed();
        $reg = $mod->updateRegularFailed();
        // $nig = $mod->updateOvernightFailed();
    }
}
