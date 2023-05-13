<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\Others;


/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;


    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $computerName = gethostbyaddr($_SERVER['REMOTE_ADDR']);

        $hallid = '';
        $hallname = '';
        $building_code = '';
        $admin = false;

        $mod = new Others();
        $query = $mod->ComputerNames($computerName);
        helper("custom1_helper");

        foreach ($query->getResult() as $row) {
            switch (strtolower($computerName)) {
                case $row->name:
                    $hallid = $row->hall_id;
                    $hallname = $row->hall_name;
                    $building_code = $row->hall_abv;
                    $admin = $row->admin;
                    break;
                default:
                    break;
            }
        }
        $hallid = CheckNorth($hallid);
        if ($admin) {
            // print_r($hallid);
            echo "admin:";
            echo $hallname . ' ';
            if (is_array($hallid)) {

                foreach ($hallid as $key => $value) {
                    echo $value . '-';
                }
            }
            echo '<br>';
        }
        $session = session();
        $session->set('hallid', $hallid);
        $session->set('hallname', $hallname);
        $session->set('building_code', $building_code);
        $session->set('admin', $admin);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }
}
