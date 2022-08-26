<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\Card_model;

class Home extends Controller
{
    public function index()
    {
        #region show-errors
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        #endregion 

        return view('home');
    }

    public function card_form()
    {
        #region show errors
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        #endregion

        $mod = new Card_model();
        $data['card_numbers'] = $mod->ShowCards();
        return view("temp_card", $data);
    }

    public function view_cards()
    {
        #region show errors
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        #endregion

        Home::un_active();

        $mod = new Card_model();
        $data['form_data'] = $mod->ShowAll();

        return view("Card_view", $data);
    }

    public function enter_cards()
    {
        #region show errors
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        #endregion

        helper('form');
        return view('card_form');
    }

    public function insert_card()
    {
        #region show errors
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        #endregion

        $data['number'] = $_POST['card_number'];
        $data['access'] = $_POST['access'];

        $all = [
            'card_number' => $data['number'],
            'access_number' => $data['access'],
            'active' => '0',
        ];

        $mod = new Card_model();
        $result['result'] = $mod->insert_card($all);

        return view("Form_submitted");
    }

    public function insert_temp()
    {
        #region show errors
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        #endregion

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
        #region show errors
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        #endregion
        helper('html');

        // return redirect()->route('view_cards');
        // return Home::view_cards();
        // $this->load->helper('html');
        // Home::un_active();

        // $mod = new Card_model();
        // $data['form_data'] = $mod->ShowAll();

        /* A view that I am trying to get to work. */
        return view("Form_submitted");
    }
}
