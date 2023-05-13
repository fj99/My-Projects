<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public $oa_request_form = [
        'formDropDown' => [
            'rules' => 'not_in_list[set]',
            'errors' => [
                'not_in_list' => 'Please select a Building from drop down list.',
            ],
        ],
        'first_name' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Please enter a first name.',
            ],
        ],
        'last_name' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Please enter a last name.',
            ],
        ],
        'room' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Please enter a room number.',
            ],
        ],
        'requestType' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Please select a request type.',
            ],
        ],
        'requestPriority' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Please select a request priority.',
            ],
        ],
        'datePicker' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Please select a date.',
            ],
        ],
        'residentAvailability' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Please enter your availability.',
            ],
        ],
        'descriptionRequest' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Please enter a description request.',
            ],
        ],
    ];
}
