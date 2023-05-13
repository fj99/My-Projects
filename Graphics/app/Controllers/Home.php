<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\Graphics;

use DateTime;

use DateTimeZone;

// \Config\Services::session();

class Home extends BaseController
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
        if (isset($_GET['input'])) {
            $input = $_GET['input'];
        } else {
            $input = '';
        }
        if (isset($_GET['status'])) {
            $status = $_GET['status'];
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

        // echo $status;
        // echo "<br>";
        // echo $page;
        // echo "<br>";

        $mod = new Graphics();
        $data['graphics'] = $mod->GetGraphics($page, $order, $designer, $status, $sort);
        $data['printing'] = $mod->GetPrints($page, $order, $designer, $status, $sort);
        $data['status'] = $status;
        $data['designers'] = $mod->Designers();
        return view("portal", $data);
    }

    public function assignedTo()
    {
        Home::show_errors();

        //$input is passed from view form
        $input = [
            "id" => $_POST['id'],
            "assigned_to" => $_POST['assigned_to'],
        ];

        //create a new class object using model
        $mod = new Graphics();
        //creates array containing change function return
        $requests = $mod->Change($input, "assigned_to", "graphics");

        //'status' is also gathered from the view/form
        $status = $_POST['status'];
        //view needs to work with an array
        //this is returned to the view called "return"
        if ($requests == 1) {
            return redirect()->to('/home?status=' . $status);
        } else {
            return redirect()->to('/error');
        }
    }

    public function requestStatus()
    {
        Home::show_errors();

        $input = [
            "id" => $_POST['id'],
            "comments" => $_POST['comment'],
            "req_status" => $_POST['req_status'],
        ];

        $mod = new Graphics();
        $requests = $mod->TwoChanges($input, "req_status", "comments", "graphics");

        $status = $_POST['status'];
        if ($requests == 1) {
            return redirect()->to('/home?status=' . $status);
        } else {
            return redirect()->to('/error');
        }
    }

    public function Completed()
    {
        Home::show_errors();

        $input = [
            "id" => $_POST['id'],
            "complete" => $_POST['complete'],
            "reason" => $_POST['reason'],
        ];

        $mod = new Graphics();
        $requests = $mod->TwoChanges($input, "complete", "reason", "graphics");
        $data['email'] = $mod->Send_emails($input, "graphics");
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

    public function P_assignedTo()
    {
        Home::show_errors();

        $input = [
            "id" => $_POST['id'],
            "assigned_to" => $_POST['assigned_to'],
        ];

        $mod = new Graphics();
        $requests = $mod->Change($input, "assigned_to", "printing");
        $status = $_POST['status'];
        if ($requests == 1) {
            return redirect()->to('/home?status=' . $status);
        } else {
            return redirect()->to('/error');
        }
    }

    public function P_requestStatus()
    {
        Home::show_errors();

        $input = [
            "id" => $_POST['id'],
            "comments" => $_POST['comment'],
            "req_status" => $_POST['req_status'],
        ];

        $mod = new Graphics();
        $requests = $mod->TwoChanges($input, "req_status", "comments", "printing");
        $status = $_POST['status'];
        if ($requests == 1) {
            return redirect()->to('/home?status=' . $status);
        } else {
            return redirect()->to('/error');
        }
    }

    public function P_Completed()
    {
        Home::show_errors();

        $input = [
            "id" => $_POST['id'],
            "complete" => $_POST['complete'],
            "reason" => $_POST['reason'],
        ];

        $mod = new Graphics();
        $requests = $mod->TwoChanges($input, "complete", "reason", "printing");
        $data['email'] = $mod->Send_emails($input, "printing");
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

    public function Gview()
    {
        Home::show_errors();
        $uri = service('uri');
        $input = $uri->getSegments();
        $input = $input[1];
        // echo $input;

        $mod = new Graphics();
        $data['graphics'] = $mod->GraphicsView($input);
        $data['status'] = $_GET['status'];
        return view("view_request", $data);
    }

    public function Pview()
    {
        helper('html');
        helper('custom1_helper');
        Home::show_errors();
        $uri = service('uri');
        $input = $uri->getSegments();
        $input = $input[1];
        $mod = new Graphics();
        $data['graphics'] = $mod->PrintsView($input);
        $data['status'] = $_GET['status'];
        return view("view_request", $data);
    }


    public function getDeniedPages($p = 1)
    {
        var_dump($p);
    }

    public function error()
    {
        //! This is the function that when things go wrong it will be rerouted here
    }

    public function form_print()
    {
        Home::show_errors();
        helper('form');
        helper('html');
        helper('custom1_helper');

        $validation = \Config\Services::validation();

        $first = [
            'name' => 'first',
            'id' => 'first',
            'placeholder' => 'First',
            'value' => set_value('first'),
        ];

        $last = [
            'name' => 'last',
            'id' => 'last',
            'placeholder' => 'Last',
            'value' => set_value('last'),
        ];

        $email = [
            'name' => 'email',
            'id' => 'email',
            'placeholder' => 'Email',
            'value' => set_value('email'),
        ];

        $phone = [
            'name' => 'phone',
            'id' => 'phone',
            'placeholder' => 'Phone',
            'value' => set_value('phone'),
        ];

        $building = [
            'name' => 'building',
            'id' => 'building',
            'placeholder' => 'Building and floor',
            'value' => set_value('building'),
        ];

        $date = [
            'name' => 'date',
            'id' => 'date',
            'type' => 'date',
            'value' => set_value('date'),
        ];

        $tvsYes = TVs("false");

        $tvsNo = TVs("true");

        $pWidth = [
            'name' => 'pWidth',
            'id' => 'pWidth',
            'placeholder' => 'width',
            'size' => '5',
            'maxlength' => '3',
            'value' => set_value('pWidth'),
        ];

        $pHeight = [
            'name' => 'pHeight',
            'id' => 'pHeight',
            'placeholder' => 'height',
            'size' => '5',
            'maxlength' => '3',
            'value' => set_value('pHeight'),
        ];

        $pAmount = [
            'name' => 'pAmount',
            'id' => 'pAmount',
            'placeholder' => 'amount',
            'size' => '5',
            'maxlength' => '3',
            'value' => set_value('pAmount'),
        ];

        $fPortrait = [
            'name' => 'fOrientation',
            'id'   => 'fOrientation',
            'value' => 'portrait',
            'checked' => false,
            'style' => 'margin:10px',
        ];

        $fLandscape = [
            'name' => 'fOrientation',
            'id'   => 'fOrientation',
            'value' => 'landscape',
            'checked' => true,
            'style' => 'margin:10px',
        ];

        $fAmount = [
            'name' => 'fAmount',
            'id' => 'fAmount',
            'placeholder' => 'amount',
            'size' => '5',
            'maxlength' => '3',
            'value' => set_value('fAmount'),
        ];

        $file = [
            'name' => 'file',
            'id' => 'file',
            'onchange' => 'return filevalidation()',
        ];

        $reset = [
            'name' => 'reset',
            'id' => 'reset',
            'value' => 'Clear Form',
        ];

        $submit = [
            'name' => 'submit',
            'id' => 'submit',
            'value' => 'Submit Form',
        ];

        $description = [
            'name' => 'description',
            'id' => 'description',
            'placeholder' => 'description of request',
            'rows' => 12,
            'cols' => 75,
            'value' => set_value('description'),
        ];

        $tz = 'America/New_York';
        $timestamp = time();
        $dt = new DateTime("now", new DateTimeZone($tz));
        $dt->setTimestamp($timestamp);

        $data = [
            'first' => $first,
            'last' => $last,
            'email' => $email,
            'phone' => $phone,
            'building' => $building,
            'date' => $date,
            'tvsYes' => $tvsYes,
            'tvsNo' => $tvsNo,
            'pWidth' => $pWidth,
            'pHeight' => $pHeight,
            'pAmount' => $pAmount,
            'fPortrait' => $fPortrait,
            'fLandscape' => $fLandscape,
            'fAmount' => $fAmount,
            'description' => $description,
            'dt' => $dt,
            'file' => $file,
            'reset' => $reset,
            'submit' => $submit,
            'validation' => $validation,
        ];

        $rules = [
            'first' => [
                'label'  => 'first',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'First is required.',
                ],
            ],

            'last' => [
                'label'  => 'last',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Last is required.',
                ],
            ],

            'email' => [
                'label'  => 'email',
                'rules'  => 'required|valid_email[email]',
                'errors' => [
                    'required' => 'Email is required.',
                    'valid_email' => 'Must enter valid email.',
                ],
            ],

            'phone' => [
                'label'  => 'phone',
                'rules'  => 'required|exact_length[10]',
                'errors' => [
                    'required' => 'Phone is required.',
                ],
            ],

            'building' => [
                'label'  => 'building',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Building is required.',
                ],
            ],

            'date' => [
                'label'  => 'date',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Date is required.',
                ],
            ],

            'description' => [
                'label'  => 'description',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Description is required.',
                ],
            ],

            'file' => [
                'label' => 'file',
                'rules' => 'uploaded[file]|max_size[file,7000000]',
                'errors' => [
                    'uploaded' => 'File is required.',
                    'max_size' => 'File size cannot exceed 7MB.',
                ],
            ],
        ];

        if ($this->request->getMethod() == 'post') {
            $count = 0;
            if (empty($_POST['pAmount']) || $_POST['pAmount'] == 0) {
                $count += 1;
            }
            if (empty($_POST['fAmount']) || $_POST['fAmount'] == 0) {
                $count += 1;
            }
            if ($count == 2) {
                $more_rules = [
                    'pAmount' => [
                        'label'  => 'pAmount',
                        'rules'  => 'required|is_natural_no_zero',
                        'errors' => [
                            'required' => 'Must select at least one printing option.',
                        ],
                    ],

                    'fAmount' => [
                        'label'  => 'fAmount',
                        'rules'  => 'required|is_natural_no_zero',
                        'errors' => [
                            'required' => 'Must select at least one printing option.',
                        ],
                    ],
                ];
                $rules += $more_rules;
            }

            if ($this->validate($rules)) {
                $input = [
                    'first' => $_POST['first'],
                    'last' => $_POST['last'],
                    'email' => $_POST['email'],
                    'phone' => $_POST['phone'],
                    'building' => $_POST['building'],
                    'date' => $_POST['date'],
                    'tvs' => $_POST['tvs'],
                    'pWidth' => $_POST['pWidth'],
                    'pHeight' => $_POST['pHeight'],
                    'pAmount' => $_POST['pAmount'],
                    'fAmount' => $_POST['fAmount'],
                    'description' => $_POST['description'],
                    'file' => $_FILES['file'],
                ];

                if (empty($input['fAmount'])) {
                    $fOrientation = [
                        'fOrientation' => '',
                    ];
                    $input += $fOrientation;
                } else {
                    $fOrientation = [
                        'fOrientation' => $_POST['fOrientation'],
                    ];
                    $input += $fOrientation;
                }

                echo "Successfully validated. <br>";

                $model = new Graphics();
                $request = $model->printingRequestFormNew($input);
                if ($request) {
                    echo 'Request submitted successfully.'; // form was submitted let user know
                    return view('printing_request_form', $data);
                } else {
                    echo 'Request failed to submit.'; // form was not submitted let user know
                    return view('printing_request_form', $data);
                }
            } else { // failed validation
                return view('printing_request_form', $data);
                // get validation
                // $validation = $session->getFlashdata('validation');
                //$validation = $session->get('validation');
                // return redirect()->to('/form');
            }
        }
        return view('printing_request_form', $data);
    }

    public function form_graph()
    {
        Home::show_errors();
        helper('form');
        helper('html');
        helper('custom1_helper');

        $validation = \Config\Services::validation();

        $first = [
            'name' => 'first',
            'id' => 'first',
            'placeholder' => 'First',
            'value' => set_value('first'),
        ];

        $last = [
            'name' => 'last',
            'id' => 'last',
            'placeholder' => 'Last',
            'value' => set_value('last'),
        ];


        $email = [
            'name' => 'email',
            'id' => 'email',
            'placeholder' => 'Email',
            'value' => set_value('email'),
        ];

        $phone = [
            'name' => 'phone',
            'id' => 'phone',
            'placeholder' => 'Phone',
            'value' => set_value('phone'),
        ];

        $title = [
            'name' => 'title',
            'id' => 'title',
            'placeholder' => 'Title',
            'value' => set_value('title'),
        ];

        $startHour = [];
        for ($i = 1; $i < 13; $i++) {
            $startHour += array($i => $i);
        }
        
        $startMinute = [];
        for ($i = 0; $i < 60; $i += 5) {
            if     ($i == 0) : $i = '00';
            elseif ($i == 5) : $i = '05'; endif;
            $startMinute += array($i => $i);
        }
        
        $startAMPM = [
            'AM' => 'AM',
            'PM' => 'PM',
        ];
        
        $endHour = [];
        for ($i = 1; $i < 13; $i++) {
            $endHour += array($i => $i);
        }
        
        $endMinute = [];
        for ($i = 0; $i < 60; $i += 5) {
            if     ($i == 0) : $i = '00';
            elseif ($i == 5) : $i = '05'; endif;
            $endMinute += array($i => $i);
        }

        $endAMPM = [
            'AM' => 'AM',
            'PM' => 'PM',
        ];

        $allDayYes = allDay("false");

        $allDayNo = allDay("true");

        $building = [
            'name' => 'building',
            'id' => 'building',
            'placeholder' => 'Building and floor',
            'value' => set_value('building'),
        ];

        $requestDate = [
            'name' => 'requestDate',
            'id' => 'requestDate',
            'type' => 'date',
            'value' => set_value('requestDate'),
        ];

        $eventDate = [
            'name' => 'eventDate',
            'id' => 'eventDate',
            'type' => 'date',
            'value' => set_value('eventDate'),
        ];

        $tvsYes = TVs("false");

        $tvsNo = TVs("true");

        $pWidth = [
            'name' => 'pWidth',
            'id' => 'pWidth',
            'placeholder' => 'width',
            'size' => '5',
            'maxlength' => '3',
            'value' => set_value('pWidth'),
        ];

        $pHeight = [
            'name' => 'pHeight',
            'id' => 'pHeight',
            'placeholder' => 'height',
            'size' => '5',
            'maxlength' => '3',
            'value' => set_value('pHeight'),
        ];

        $pAmount = [
            'name' => 'pAmount',
            'id' => 'pAmount',
            'placeholder' => 'amount',
            'size' => '5',
            'maxlength' => '3',
            'value' => set_value('pAmount'),
        ];

        $fPortrait = [
            'name' => 'fOrientation',
            'id'   => 'fOrientation',
            'value' => 'portrait',
            'checked' => false,
            'style' => 'margin:10px',
        ];

        $fLandscape = [
            'name' => 'fOrientation',
            'id'   => 'fOrientation',
            'value' => 'landscape',
            'checked' => true,
            'style' => 'margin:10px',
        ];

        $fAmount = [
            'name' => 'fAmount',
            'id' => 'fAmount',
            'placeholder' => 'amount',
            'size' => '5',
            'maxlength' => '3',
            'value' => set_value('fAmount'),
        ];

        $file = [
            'name' => 'file',
            'id' => 'file',
            'onchange' => 'return filevalidation()',
        ];

        $reset = [
            'name' => 'reset',
            'id' => 'reset',
            'value' => 'Clear Form',
        ];

        $submit = [
            'name' => 'submit',
            'id' => 'submit',
            'value' => 'Submit Form',
        ];

        $description = [
            'name' => 'description',
            'id' => 'description',
            'placeholder' => 'description of request',
            'rows' => 12,
            'cols' => 75,
            'value' => set_value('description'),
        ];

        $tz = 'America/New_York';
        $timestamp = time();
        $dt = new DateTime("now", new DateTimeZone($tz));
        $dt->setTimestamp($timestamp);

        $data = [
            'first' => $first,
            'last' => $last,
            'email' => $email,
            'phone' => $phone,
            'title' => $title,
            'startHour' => $startHour,
            'startMinute' => $startMinute,
            'startAMPM' => $startAMPM,
            'endHour' => $endHour,
            'endMinute' => $endMinute,
            'endAMPM' => $endAMPM,
            'allDayYes' => $allDayYes,
            'allDayNo' => $allDayNo,
            'building' => $building,
            'requestDate' => $requestDate,
            'eventDate' => $eventDate,
            'tvsYes' => $tvsYes,
            'tvsNo' => $tvsNo,
            'pWidth' => $pWidth,
            'pHeight' => $pHeight,
            'pAmount' => $pAmount,
            'fPortrait' => $fPortrait,
            'fLandscape' => $fLandscape,
            'fAmount' => $fAmount,
            'description' => $description,
            'dt' => $dt,
            'file' => $file,
            'reset' => $reset,
            'submit' => $submit,
            'validation' => $validation,
        ];

        $rules = [
            'first' => [
                'label'  => 'first',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'First is required.',
                ],
            ],

            'last' => [
                'label'  => 'last',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Last is required.',
                ],
            ],

            'email' => [
                'label'  => 'email',
                'rules'  => 'required|valid_email[email]',
                'errors' => [
                    'required' => 'Email is required.',
                    'valid_email' => 'Must enter valid email.',
                ],
            ],

            'phone' => [
                'label'  => 'phone',
                'rules'  => 'required|exact_length[10]',
                'errors' => [
                    'required' => 'Phone is required.',
                ],
            ],

            'title' => [
                'label'  => 'title',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Title is required.',
                ],
            ],

            'building' => [
                'label'  => 'building',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Building is required.',
                ],
            ],

            'requestDate' => [
                'label'  => 'requestDate',
                'rules'  => 'required',
                'errors' => [
                    'required' => ' Request date is required.',
                ],
            ],

            'eventDate' => [
                'label'  => 'eventDate',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Event date is required.',
                ],
            ],

            'description' => [
                'label'  => 'description',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Description is required.',
                ],
            ],

            'file' => [
                'label' => 'file',
                'rules' => 'uploaded[file]|max_size[file,7000000]',
                'errors' => [
                    'uploaded' => 'File is required.',
                    'max_size' => 'File size cannot exceed 7MB.',
                ],
            ],
        ];

        if ($this->request->getMethod() == 'post') {
            $count = 0;
            if (empty($_POST['pAmount']) || $_POST['pAmount'] == 0) {
                $count += 1;
            }
            if (empty($_POST['fAmount']) || $_POST['fAmount'] == 0) {
                $count += 1;
            }
            if ($count == 2) {
                $more_rules = [
                    'pAmount' => [
                        'label'  => 'pAmount',
                        'rules'  => 'required|is_natural_no_zero',
                        'errors' => [
                            'required' => 'Must select at least one printing option.',
                        ],
                    ],

                    'fAmount' => [
                        'label'  => 'fAmount',
                        'rules'  => 'required|is_natural_no_zero',
                        'errors' => [
                            'required' => 'Must select at least one printing option.',
                        ],
                    ],
                ];
                $rules += $more_rules;
            }

            if ($this->validate($rules)) {
                $input = [
                    'first' => $_POST['first'],
                    'last' => $_POST['last'],
                    'email' => $_POST['email'],
                    'phone' => $_POST['phone'],
                    'title' => $_POST['title'],
                    'startHour' => $_POST['startHour'],
                    'startMinute' => $_POST['startMinute'],
                    'startAMPM' => $_POST['startAMPM'],
                    'endHour' => $_POST['endHour'],
                    'endMinute' => $_POST['endMinute'],
                    'endAMPM' => $_POST['endAMPM'],
                    'allDay' => $_POST['allDay'],
                    'building' => $_POST['building'],
                    'eventDate' => $_POST['eventDate'],
                    'requestDate' => $_POST['requestDate'],
                    'tvs' => $_POST['tvs'],
                    'pAmount' => $_POST['pAmount'],
                    'fAmount' => $_POST['fAmount'],
                    'description' => $_POST['description'],
                    'file' => $_FILES['file'],
                ];

                if (empty($input['pAmount']) || $input['pAmount'] == 0) {
                    $pOrientation = [
                        'pWidth' => '',
                        'pHeight' => '',
                    ];
                    $input += $pOrientation;
                } else {
                    $pOrientation = [
                        'pWidth' => $_POST['pWidth'],
                        'pHeight' => $_POST['pHeight'],
                    ];
                    $input += $pOrientation;
                }

                if (empty($input['fAmount']) || $input['fAmount'] == 0) {
                    $fOrientation = [
                        'fOrientation' => '',
                    ];
                    $input += $fOrientation;
                } else {
                    $fOrientation = [
                        'fOrientation' => $_POST['fOrientation'],
                    ];
                    $input += $fOrientation;
                }

                echo "Successfully validated. <br>";
                $model = new Graphics();
                $request = $model->graphicsRequestFormNew($input);
                if ($request) {
                    echo 'Request submitted successfully.'; // form was submitted let user know
                    return view('graphics_request_form', $data);
                } else {
                    echo 'Request failed to submit.'; // form was not submitted let user know
                    return view('printing_request_form', $data);
                }
            } else {
                return view('graphics_request_form', $data);
            }
        }
        return view('graphics_request_form', $data);
    }
}
