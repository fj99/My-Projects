<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\Card_model;

class Home extends Controller
{
    public function show_errors()
    {
        #region show-errors
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        #endregion 
    }

    public function index()
    {
        Home::show_errors();

        return view('home');
    }

    public function card_form()
    {
        Home::show_errors();
        helper("form");

        $form = [
            'class' => "requires-validation",
            'novalidate' => '',
        ];

        $request_date = [
            "name" => "request_date",
            "class" => "form-control",
            "type" => "date",
            'required' => true,
        ];

        $data = [
            'form' => $form,
            'request_date' => $request_date,
        ];

        $mod = new Card_model();
        $data['card_numbers'] = $mod->ShowCards();
        return view("temp_card", $data);
    }

    public function view_cards()
    {
        Home::show_errors();
        Home::un_active();

        $mod = new Card_model();
        $data['form_data'] = $mod->ShowAll();
        $data['card_data'] = $mod->All_Cards();

        return view("Card_view", $data);
    }

    public function card_return()
    {
        Home::show_errors();

        $mod = new Card_model();
        $data['card_numbers'] = $mod->Cards_taken();
        return view("return_card", $data);
    }

    public function enter_cards()
    {
        Home::show_errors();

        helper('form');
        return view('card_form');
    }

    public function card_read()
    {
        Home::show_errors();

        helper('form');
        return view('card_form_read');
    }

    public function returning_card()
    {
        Home::show_errors();

        $all = [
            'id' => $_POST['card'],
        ];
        $mod = new Card_model();
        $result['result'] = $mod->return_card($all);
        return view("Form_submitted");
    }

    public function insert_card()
    {
        Home::show_errors();

        $data['number'] = $_POST['card_number'];
        $data['access'] = $_POST['access'];

        $all = [
            'card_number' => $data['number'],
            'access_number' => $data['access'],
            'active' => '0',
        ];

        $mod = new Card_model();
        $result['result'] = $mod->insert_card($all);
        if ($result) {
            return view("Form_submitted");
        } else {
            return view("Form_failed");
        }
    }

    public function insert_card_read()
    {
        Home::show_errors();

        $card_info = $_POST['card_number'];
        // Card info: %B6032777900513116^ACCESS CARD/000009097 ^?
        // Find the position of the first "^" character
        $pos = strpos($card_info, '^');

        // Extract the first piece up to the "^" character
        $access = substr($card_info, 1, $pos - 2);
        $access = substr($access, 7, -1);

        // Find the position of the second "/" character
        $pos2 = strpos($card_info, '/', $pos);

        // Extract the second piece between the "/" character and the "^" character
        $number = substr($card_info, $pos2 + 1, -3);
        $number = ltrim($number, '0');

        // echo $access; // Output: 79005131 
        // echo '<br>';
        // echo $number; // Output: 9097

        $input = [
            'card_number' => $number,
            'access_number' => $access,
            'active' => '0',
        ];

        $mod = new Card_model();
        $result = $mod->insert_card($input);
        if ($result) {
            return view("Form_submitted");
        } else {
            return view("Form_failed");
        }
    }

    public function insert_temp()
    {
        Home::show_errors();

        $data['user'] = $_POST['user'];
        $data['card'] = $_POST['card'];
        $data['request'] = $_POST['request_date'];
        $data['reason'] = $_POST['reason'];
        $data['admin'] = $_POST['admin'];
        $data['date'] = date('Y-m-d');

        $all = [
            'user' => $data['user'],
            'card_id' => $data['card'],
            'submission_date' => $data['date'],
            'requested_date' => $data['request'],
            'reason_for_card' => $data['reason'],
            'administrator' => $data['admin'],
        ];

        $mod = new Card_model();
        $result['result'] = $mod->insert_temp_card($all, $data['card']);

        return view("Form_submitted");
    }

    public function un_active()
    {
        // for now this function is being run every time u look at view 
        // but it needs to be run everyday regardless of the page
        $mod = new Card_model();
        $mod->update_card();
        return;
    }

    public function test()
    {
        Home::show_errors();

        echo view("Form_failed");
    }
}
