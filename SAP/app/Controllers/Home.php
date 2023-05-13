<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\Notifications_model;
use App\Models\Database_model;
use App\Models\Update_model;
use App\Models\Hire_model;
use App\Models\Deactivate_model;

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

    public function header()
    {
        $search = [
            "name" => "id",
            "placeholder" => "Search",
            "style" => "margin-top: 10px;float: right;padding: 5px;"
        ];
        return $search;
    }

    public function index()
    {
        Home::show_errors();
        helper('html');
        helper('form');
        helper('url');
        $mod = new Notifications_model();

        $id = [
            "name" => "id",
            "placeholder" => "ID",
        ];
        $user = [
            "name" => "username",
            "placeholder" => "user name",
        ];
        $job_title = [
            ["name" => "job_title"], [
                "" => "Job Drop Down",
                "7" => "Operations Assistant Intern",
                "8" => "LLC Intern",
                "9" => "Programming Intern",
                "10" => "Computer Programmer",
                "11" => "Straight Line Hall Director",
                "12" => "Upperclass Hall Director",
                "13" => "Graphic Designer",
                "14" => "University Assistant",
                "15" => "Residence Life Assistant",
                "16" => "Residence Life Assistant",
                "19" => "Resident Advisor",
                "20" => "Hall Council",
                "21" => "Residence Hall Association",
                "22" => "Programming Assistant",
                "23" => "Desk Attendant",
                "24" => "Marketing Specialist",
                "26" => "Operations Assistant",
                "25" => "Fails",
            ]
        ];
        $halls = [
            ["name" => "staff_portal_hall"], [
                "" => "Halls Drop Down",
                "1" => "Brownell",
                "2" => "Chase",
                "3" => "Farnham",
                "4" => "Hickerson",
                "5" => "Neff",
                "6" => "North",
                "7" => "Schwartz",
                "8" => "West",
                "9" => "Wilkinson",
                "10" => "North Campus Midrise",
                "11" => "North Campus Townhouses",
            ]
        ];
        $active = [
            ["name" => "active"], [
                "1" => "Active",
                "2" => "In-Active",
                "" => "Both",
            ]
        ];

        $data = [
            "notifications" => $mod->getNotifications(),
            "header" => Home::header(),
            "id" => $id,
            "user" => $user,
            "job_title" => $job_title,
            "halls" => $halls,
            "active" => $active,
        ];

        echo view('templates/header', $data);
        echo view('home_page/home_page', $data);
        echo view('templates/javascript_functions');
        echo view('templates/footer');
    }

    public function advancedSearch()
    {
        Home::show_errors();
        helper('html');
        helper('form');

        $input = [
            "id" => $_POST["id"],
            "username" => $_POST["username"],
            "staff_portal_hall" => $_POST["staff_portal_hall"],
            "job_title" => $_POST["job_title"],
            "active" => $_POST["active"]
        ];

        $nod = new Notifications_model();
        $mod = new Update_Model();
        $data['notifications'] = $nod->getNotifications();
        $data['header'] = Home::header();
        $data['search'] = $mod->advancedSearch($input);

        if ($data['search'] == false) {
            echo view('templates/header', $data);
            echo view('templates/failure');
            echo view('templates/javascript_functions');
            echo view('templates/footer');
        } else {
            echo view('templates/header', $data);
            echo view('updating/advanced_search', $data);
            echo view('templates/javascript_functions');
            echo view('templates/footer');
        }
    }

    public function updateEmployees()
    {
        Home::show_errors();
        helper('html');
        helper('form');
        $nod = new Notifications_model();
        $data['notifications'] = $nod->getNotifications();
        $data['header'] = Home::header();

        echo view('templates/header', $data);
        echo view('updating/updating_page', $data);
        echo view('templates/javascript_functions');
        echo view('templates/footer');
    }

    public function updateSearch()
    {
        Home::show_errors();
        helper('html');
        helper('form');
        $id = $_POST['id'];
        $mod = new Notifications_model();
        $data['notifications'] = $mod->getNotifications();
        $data['header'] = Home::header();
        $mod2 = new Update_Model();
        $data['search'] = $mod2->getUsers($id);
        if ($data['search'] == 0) {
            $arr = array("id" => $id);
            $data['validation'] = $arr;
            echo view('templates/header', $data);
            echo view('updating/validation_failure', $data);
            echo view('templates/javascript_functions');
            echo view('templates/footer');
        } else {
            echo view('templates/header', $data);
            echo view('updating/update_users', $data);
            echo view('templates/javascript_functions');
            echo view('templates/footer');
        }
    }

    public function ChangeName()
    {
        Home::show_errors();
        helper('html');
        helper('form');
        $input = [
            "id"  => $_POST["id"],
            "fname" => $_POST["fname"],
            "lname" => $_POST["lname"],
            "username" => $_POST["username"],
        ];
        $mod = new Update_Model($input);
        //* Check
        $data["request"] = $mod->UpdateName($input);

        return redirect()->to('/home');
    }

    public function submitUpdate()
    {
        Home::show_errors();
        helper('html');
        helper('form');
        $nod = new Notifications_model();
        $data['notifications'] = $nod->getNotifications();
        $data['header'] = Home::header();
        $mod = new Update_Model();
        $allhalls = array();
        $allroles = array();
        $permissions = array();

        for ($i = 1; $i < 15; $i++) {
            $num = (string) $i;
            if ($i < 10) {
                if (isset($_POST['allhalls' . $num])) {
                    array_push($allhalls, $_POST['allhalls' . $num]);
                } else {
                    array_push($allhalls, null);
                }
            }
            if ($i < 11) {
                if (isset($_POST['permissions' . $num])) {
                    array_push($permissions, $_POST['permissions' . $num]);
                } else {
                    array_push($permissions, null);
                }
            }
            if (isset($_POST['allroles' . $num])) {
                array_push($allroles, $_POST['allroles' . $num]);
            } else {
                array_push($allroles, null);
            }
        }

        $input = [
            'id' => $_POST['user_id'],
            'user' => $_POST['username'],
            'fname' => $_POST['fname'],
            'lname' => $_POST['lname'],
            'sap_hall' => $_POST['sap_hall'],
            'sap_job' => $_POST['sap_job'],
            'staff_admin' => $_POST['staff_admin'],
            'auth_level' => $_POST['auth_level'],
            'form_access' => $_POST['form_access'],
            'programming_level' => $_POST['programming_level'],
            'permissions1' => $permissions[0],
            'permissions2' => $permissions[1],
            'permissions3' => $permissions[2],
            'permissions4' => $permissions[3],
            'permissions5' => $permissions[4],
            'permissions6' => $permissions[5],
            'permissions7' => $permissions[6],
            'permissions8' => $permissions[7],
            'permissions9' => $permissions[8],
            'permissions10' => $permissions[9],
            'program_portal_role' => $_POST['program_portal_role'],
            'program_portal_role2' => $_POST['program_portal_role2'],
            'reset_pp_pass' => $_POST['reset_pp_pass'],
            'allhalls1' => $allhalls[0],
            'allhalls2' => $allhalls[1],
            'allhalls3' => $allhalls[2],
            'allhalls4' => $allhalls[3],
            'allhalls5' => $allhalls[4],
            'allhalls6' => $allhalls[5],
            'allhalls7' => $allhalls[6],
            'allhalls8' => $allhalls[7],
            'allhalls9' => $allhalls[8],
            'allroles1' => $allroles[0],
            'allroles2' => $allroles[1],
            'allroles3' => $allroles[2],
            'allroles4' => $allroles[3],
            'allroles5' => $allroles[4],
            'allroles6' => $allroles[5],
            'allroles7' => $allroles[6],
            'allroles8' => $allroles[7],
            'allroles9' => $allroles[8],
            'allroles10' => $allroles[9],
            'allroles11' => $allroles[10],
            'allroles12' => $allroles[11],
            'allroles13' => $allroles[12],
            'allroles14' => $allroles[13],
            'maintenance_requests' => $_POST['maintenance_requests'],
            'comcast_requests' => $_POST['comcast_requests'],
            'inResWorkOrder' => $_POST['inResWorkOrder'],
            'program_report' => $_POST['program_report'],
            'farnham_report' => $_POST['farnham_report'],
            'schwartz_report' => $_POST['schwartz_report'],
            'conn_report' => $_POST['conn_report'],
            'tech_requests' => $_POST['tech_requests'],
            'oa_requests' => $_POST['oa_requests'],
            'inPdsAdm' => $_POST['inPdsAdm'],
            'van_requests' => $_POST['van_requests'],
            'inTutorCtr' => $_POST['inTutorCtr'],
            'resworkorder_changed' => $_POST['resworkorder_changed'],
            'reslife_pdsadm_changed' => $_POST['reslife_pdsadm_changed'],
            'tutorctr_changed' => $_POST['tutorctr_changed'],
            'reset_pp_pass' => $_POST['reset_pp_pass']
        ];

        $data['user'] = $mod->updateUser($input);
        // if (isset($data['user'])) {
        if ($data['user'][0]) {
            echo view('templates/header', $data);
            echo view('updating/update_success', $data);
            echo view('templates/javascript_functions');
            echo view('templates/footer');
        } else {
            echo view('templates/header', $data);
            echo view('templates/failure');
            echo view('templates/javascript_functions');
            echo view('templates/footer');
        }
    }

    public function hireEmployees()
    {
        Home::show_errors();
        helper('html');
        helper('form');
        $nod = new Notifications_model();
        $data['notifications'] = $nod->getNotifications();
        $data['header'] = Home::header();

        echo view('templates/header', $data);
        echo view('hiring/hiring_page', $data);
        echo view('templates/javascript_functions');
        echo view('templates/footer');
    }

    public function manualHireEmployees()
    {
        Home::show_errors();
        helper('html');
        helper('form');

        //Pump Data into an Array
        $input = [
            "id" => $_POST['id'],
            "first_name" => str_replace("'", "", $_POST['first_name']),
            "last_name" => str_replace("'", "", $_POST['last_name']),
            "username" => $_POST['username'],
            "job_id" => $_POST['job'],
            "hall" => $_POST['staff_portal_hall'],
        ];

        $nod = new Notifications_model();
        $data['notifications'] = $nod->getNotifications();
        $data['header'] = Home::header();
        $mod = new Hire_model();
        $data['hiring'] = $mod->manuallyHireUsers($input);
        if ($data['hiring'] == false) {
            echo view('templates/header', $data);
            echo view('templates/failure');
            echo view('templates/javascript_functions');
            echo view('templates/footer');
        } else {
            echo view('templates/header', $data);
            echo view('templates/success');
            echo view('templates/javascript_functions');
            echo view('templates/footer');
        }
    }
    public function deactivateEmployees()
    {
        Home::show_errors();
        helper('html');
        helper('form');
        $nod = new Notifications_model();
        $data['notifications'] = $nod->getNotifications();
        $data['header'] = Home::header();
        echo view('templates/header', $data);
        echo view('deactivating/deactivating_page', $data);
        echo view('templates/javascript_functions');
        echo view('templates/footer');
    }

    public function confirmDeactivation()
    {
        Home::show_errors();
        helper('html');
        helper('form');
        $nod = new Notifications_model();
        $data['notifications'] = $nod->getNotifications();
        $data['header'] = Home::header();

        $mod = new Deactivate_model();
        $data['validation'] = $mod->validateUser($_POST['id']);
        if (is_int($data['validation'])) {
            echo view('templates/header', $data);
            echo view('templates/failure');
            echo view('templates/javascript_functions');
            echo view('templates/footer');
        } else {
            echo view('templates/header', $data);
            echo view('deactivating/deactivating_manual_confirmation', $data);
            echo view('templates/javascript_functions');
            echo view('templates/footer');
        }
    }

    public function manualDeactivateEmployees()
    {
        Home::show_errors();
        helper('html');
        helper('form');
        $nod = new Notifications_model();
        $data['notifications'] = $nod->getNotifications();
        $data['header'] = Home::header();

        $mod = new Deactivate_model();
        $data['deactivating'] = $mod->manuallyDeactivateUsers($_POST['id']);

        if ($data['deactivating'] == True) {
            echo view('templates/header', $data);
            echo view('templates/success');
            echo view('templates/javascript_functions');
            echo view('templates/footer');
        } else {
            echo view('templates/header', $data);
            echo view('templates/failure');
            echo view('templates/javascript_functions');
            echo view('templates/footer');
        }
    }

    public function Wrong_page()
    {
        Home::show_errors();
        helper('html');
        helper('form');

        $mod = new Notifications_model();
        $data['notifications'] = $mod->getNotifications();
        $data['header'] = Home::header();
        echo view('templates/header', $data);
        echo view('templates/wrong_page', $data);
        echo view('templates/javascript_functions');
        echo view('templates/footer');
    }

    public function Hall_Director()
    {
        Home::show_errors();
        helper('html');
        helper('form');

        $nod = new Notifications_model();
        $data['notifications'] = $nod->getNotifications();
        $data['header'] = Home::header();

        $mod = new Update_Model();
        $data['search'] = $mod->HD();

        echo view('templates/header', $data);
        echo view('updating/HD', $data);
        echo view('templates/javascript_functions');
        echo view('templates/footer');
    }

    public function RemoveHD()
    {
        Home::show_errors();
        helper('html');
        helper('form');

        $nod = new Notifications_model();
        $data['notifications'] = $nod->getNotifications();
        $data['header'] = Home::header();

        $mod = new Update_Model();
        $data['search'] = $mod->updateHD($_POST['id']);
        if ($data['search']) {
            Home::Hall_Director();
        } else {
            echo view('templates/header', $data);
            echo view('templates/wrong_page', $data);
            echo view('templates/javascript_functions');
            echo view('templates/footer');
        }
    }

    public function staffPortal()
    {
        return redirect()->to('https://prd-stuaff01.southernct.edu/residencelife/reslife/portal/portal_dash.php');
    }

    public function logout()
    {
        return redirect()->to('https://prd-stuaff01.southernct.edu/myscsu/logout/index.php');
    }

    public function viewNotifications()
    {
        Home::show_errors();
        helper('html');
        helper('form');

        $nod = new Notifications_model();
        $data['notifications'] = $nod->getNotifications();
        $data['header'] = Home::header();
        $data['users'] = $nod->getProgrammers();
        echo view('templates/header', $data);
        echo view('Notifications/view_notifications', $data);
        echo view('templates/javascript_functions');
        echo view('templates/footer');
    }

    public function Notifications()
    {
        Home::show_errors();
        helper('html');
        helper('form');

        $mod = new Notifications_model();
        $data['notifications'] = $mod->getNotifications();
        $data['header'] = Home::header();
        $data['Finished_notifications'] = $mod->getClosedNotifications();
        echo view('templates/header', $data);
        echo view('Notifications/notifications', $data);
        echo view('templates/javascript_functions');
        echo view('templates/footer');
    }

    public function addNotification()
    {
        Home::show_errors();
        helper('html');
        helper('form');

        if (isset($_POST['comments'])) {
            $comments = $_POST['comments'];
        } else {
            $comments = '';
        }

        $input = [
            "user" => $_POST['user'],
            "request" => $_POST['request'],
            "affect" => $_POST['affect'],
            "comments" => $comments,
        ];

        $mod = new Notifications_model();
        $data['check'] = $mod->addNotification($input);

        $data['notifications'] = $mod->getNotifications();
        $data['header'] = Home::header();

        if ($data['check']) {
            echo view('templates/header', $data);
            echo view('templates/success');
            echo view('templates/javascript_functions');
            echo view('templates/footer');
        } else {
            echo view('templates/header', $data);
            echo view('templates/failure');
            echo view('templates/javascript_functions');
            echo view('templates/footer');
        }
    }

    public function closeNotification()
    {
        Home::show_errors();
        helper('html');
        helper('form');

        $input = [
            "id" => $_POST['id'],
            "user" => $_POST['user'],
            "affected_username" => $_POST['affected_username'],
            "affected_id" => $_POST['affected_id'],
        ];

        $mod = new Notifications_model();
        $data['check'] = $mod->closeNotification($input);
        $data['notifications'] = $mod->getNotifications();
        $data['header'] = Home::header();

        if ($data['check']) {
            echo view('templates/header', $data);
            echo view('templates/success');
            echo view('templates/javascript_functions');
            echo view('templates/footer');
        } else {
            echo view('templates/header', $data);
            echo view('templates/failure');
            echo view('templates/javascript_functions');
            echo view('templates/footer');
        }
    }

    public function test()
    {
        Home::show_errors();
        $email = \Config\Services::email();

        $email->setFrom('Reslife@southernct.edu', 'Reslife');
        $email->setTo('Fernandezf2@southernct.edu');
        // $email->setCC("dahlmand1@southernct.edu");

        $email->setSubject('Email Test');
        $mess = 'Testing the email class. <br> Yes';
        $email->setMessage($mess);

        $email->send();
        echo "yes";
    }
}
