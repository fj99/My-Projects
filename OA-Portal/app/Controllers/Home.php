<?php

namespace App\Controllers;

use Config\Services;

use App\Models\OA;

#region show-errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
#endregion 
class Home extends BaseController
{

    // public function Check()
    // {
    //     $mod = new OA();
    //     $result = $mod->verify();
    //     return $result;
    // }

    public function index()
    {
        if (isset($_GET['designer'])) {
            $designer = $_GET['designer'];
            if ($designer == "Unassigned") {
                $designer = '';
            }
        } else {
            $designer = '';
        }
        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
        } else {
            $sort = '';
        }
        if (isset($_GET['order'])) {
            $order = $_GET['order'];
        } else {
            $order = '';
        }
        if (isset($_GET['priority'])) {
            $priority = $_GET['priority'];
        } else {
            $priority = '';
        }
        if (isset($_GET['status'])) {
            $status = $_GET['status'];
            if ($status == "Incomplete") {
                $status = '';
            }
        } else {
            $status = '';
        }
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = '1';
        }
        if (isset($_GET['email'])) {
            $email = $_GET['email'];
        } else {
            $email = '';
        }
        if (isset($_GET['closest'])) {
            $closest = $_GET['closest'];
        } else {
            $closest = '';
        }
        if (isset($_GET['farthest'])) {
            $farthest = $_GET['farthest'];
        } else {
            $farthest = '';
        }

        $mod = new OA();
        $data['requests'] = $mod->GetRequest($page, $order, $designer, $status, $sort, $priority, $closest, $farthest);
        $data['oas'] = $mod->GetOAs();
        $data['status'] = $status;
        return view("portal", $data);
    }

    public function assignedTo()
    {
        $input = [
            "id" => $_POST['id'],
            "assigned_to" => $_POST['assigned_to'],
            "status" => "oas",
        ];

        $mod = new OA();
        $requests = $mod->Change($input, "assigned_to");
        if ($_POST['assigned_to'] != "default") {
            $data['email'] = $mod->Send_emails($input);
        }
        $status = $_POST['status'];
        if ($requests == 1) {
            if (isset($data['email'])) {
                return redirect()->to('/home?status=' . $status . '&email=true');
            }
            return redirect()->to('/home?status=' . $status . '&email=false');
        } else {
            return redirect()->to('/error');
        }
    }

    public function requestStatus()
    {
        $input = [
            "id" => $_POST['id'],
            "comments" => $_POST['comment'],
            "status" => $_POST['req_status'],
        ];

        $mod = new OA();
        $requests = $mod->TwoChanges($input, "status", "comments");
        $email = $mod->Send_emails($input);
        $status = $_POST['status'];
        if ($requests == 1) {
            if ($email == 1) {
                return redirect()->to('/home?status=' . $status . '&email=true');
            }
            return redirect()->to('/home?status=' . $status . '&email=false');
        } else {
            return redirect()->to('/error');
        }
    }

    public function view($id)
    {
        $uri = service('uri');
        $input = $uri->getSegments();
        $input = $input[1];
        // echo($id);
        // echo($input);
        helper('html');

        $mod = new OA();
        $data['requests'] = $mod->View($input);
        // $data['requests'] = $mod->View($id);
        if (isset($_GET['status'])) {
            $status = $_GET['status'];
        } else {
            $status = '';
        }
        $data['status'] = $status;
        return view("view_request", $data);
    }



    public function form()
    {

        $validation = \Config\Services::validation();
        $rules = $validation->getRuleGroup('oa_request_form');

        helper('form');
        helper('html');

        $session = session();
        $mod = new OA();
        $buildings = $mod->buildings();

        $buildingAbv = [];
        $buildingName = [];

        foreach ($buildings->getResult() as $row) {
            array_push($buildingAbv, $row->hall_abv);
            array_push($buildingName, $row->hall_name);
        }

        $formDropDown = array(
            [
                'label' => 'Building: ',
            ],
            [
                'name' => 'formDropDown',
                'value' => set_value('formDropDown', $postData['formDropDown'] ?? ''),
            ],
            [
                'set' => 'Set Building',
            ],
        );

        foreach (array_combine($buildingAbv, $buildingName) as $b1 => $b2) {
            $formDropDown[2][$b1] = $b2;
        }

        $first_name = [
            [
                'name' => 'first_name',
                'value' => set_value('first_name', $postData['first_name'] ?? ''),
                'placeholder' => 'First name',
                'size' => 40,
            ],
            [
                'label' => 'First Name: ',
            ],
        ];

        $last_name = [
            [
                'name' => 'last_name',
                'value' => set_value('last_name', $postData['last_name'] ?? ''),
                'placeholder' => 'Last name',
                'size' => 40,
            ],
            [
                'label' => 'Last Name: ',
            ],
        ];

        $room = [
            [
                'name' => 'room',
                'value' => set_value('room', $postData['room'] ?? ''),
                'placeholder' => '###',
                'size' => 5,
            ],
            [
                'label' => 'Room: ',
            ],
        ];

        $requestType = [
            [
                'name' => 'requestType',
                'value' => 'Deliver Tables/Chairs',
                'radio' => false,
                'style' => 'margin:10px',
            ],
            [
                'name' => 'requestType',
                'value' => 'Painting',
                'radio' => false,
                'style' => 'margin:10px',
            ],
            [
                'name' => 'requestType',
                'value' => 'Recreational Equipment Concerns',
                'radio' => false,
                'style' => 'margin:10px',
            ],
            [
                'name' => 'requestType',
                'value' => 'Furniture Concerns',
                'radio' => false,
                'style' => 'margin:10px',
            ],
            [
                'name' => 'requestType',
                'value' => 'Other Moving Requests',
                'radio' => false,
                'style' => 'margin:10px',
            ],
            [
                'name' => 'requestType',
                'value' => 'Other',
                'radio' => false,
                'style' => 'margin:10px',
            ],
            [
                '1' => 'Deliver Tables/Chairs',
                '2' => 'Painting',
                '3' => 'Recreational Equipment Concerns',
                '4' => 'Furniture Concerns',
                '5' => 'Other Moving Requests',
                '6' => 'Other',
                'title' => '<u><b> Request Type </b></u>',
            ],
        ];

        $requestPriority = [
            [
                'name' => 'requestPriority',
                'value' => 'VITAL',
                'radio' => false,
                'style' => 'margin:10px',
            ],
            [
                'name' => 'requestPriority',
                'value' => 'Very High',
                'radio' => false,
                'style' => 'margin:10px',
            ],
            [
                'name' => 'requestPriority',
                'value' => 'High',
                'radio' => false,
                'style' => 'margin:10px',
            ],
            [
                'name' => 'requestPriority',
                'value' => 'Medium',
                'radio' => false,
                'style' => 'margin:10px',
            ],
            [
                'name' => 'requestPriority',
                'value' => 'Low',
                'radio' => false,
                'style' => 'margin:10px',
            ],
            [
                'name' => 'requestPriority',
                'value' => 'Very Low',
                'radio' => false,
                'style' => 'margin:10px',
            ],
            [
                'title' => '<u><b> Request Priority </b></u>',
                '1' => 'VITAL <i>(emergency level - use rarely)</i>',
                '2' => 'Very High',
                '3' => 'High',
                '4' => 'Medium',
                '5' => 'Low',
                '6' => 'Very Low',
            ],


        ];

        $datePicker = [
            [
                'name' => 'datePicker',
                'value' => set_value('datePicker', $postData['datePicker'] ?? ''),
                'id' => 'datePicker',
                'placeholder' => 'Select Date',
            ],
            [
                'label' => 'Requested Completion Date: ',
            ],
        ];

        $residentAvailability = [
            [
                'name' => 'residentAvailability',
                'value' => set_value('residentAvailability', $postData['residentAvailability'] ?? ''),
                'placeholder' => 'Type Here',
                'style' => 'width:30%',
            ],
            [
                'label' => 'Resident Availability',
            ],
        ];


        $descriptionRequest = [
            [
                'name' => 'descriptionRequest',
                'value' => set_value('descriptionRequest', $postData['descriptionRequest'] ?? ''),
                'placeholder' => 'Type Here',
                'style' => 'width:30%',
            ],
            [
                'label' => 'Description Request',
            ],
        ];

        $submit_button = [
            'name' => 'submit_button',
            'value' => 'Submit',
            'type' => 'submit',
            'content' => 'Submit',
        ];

        $reset_button = [
            'name' => 'reset_button',
            'value' => 'Reset',
            'type' => 'reset',
            'content' => 'Reset',
        ];

        $data = [
            'formDropDown' => $formDropDown,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'room' => $room,
            'requestType' => $requestType,
            'requestPriority' => $requestPriority,
            'datePicker' => $datePicker,
            'residentAvailability' => $residentAvailability,
            'descriptionRequest' => $descriptionRequest,
            'submit_button' => $submit_button,
            'reset_button' => $reset_button,
        ];

        if (!$this->validate($rules) && $this->request->getMethod() === 'post') {
            $data["validation"] = $validation;
            return view("oa_request_form", $data);
        }

        if ($this->request->getMethod() === 'get') {
            return view("oa_request_form", $data);
        }

        if ($this->validate($rules) && $this->request->getMethod() === 'post') {
            $input = [
                // 'first_name' => 'Test',
                // 'last_name' => 'Test',
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'location' => $_POST['formDropDown'],
                'room' => $_POST['room'],
                'type' => $_POST['requestType'],
                'priority' => $_POST['requestPriority'],
                'requested_completion_date' => $_POST['datePicker'],
                'residentAvailability' => $_POST['residentAvailability'],
                'description' => $_POST['descriptionRequest'],
                'date' => date("Y-m-d", strtotime("now")),
            ];
            $query = $mod->verify($input);
            if ($query) {
                return view("oa_rf_success");
            } else {
                $message = '&#9888; Your request was not processed properly, please contact the RESlife computer programming department';
                $data["message"] = $message;
            }
        }
        return view("oa_request_form", $data);
    }

    public function error()
    {
        return view("error");
    }
}
