<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();



        $this->load->model('model_customer');
    }

    public function index()
    {
    }

    public function searchCustomer()
    {
        //If search isset search for that one
        if (isset($_GET['q'])) {
            $val = $_GET['q'];
        }
        //show all customers
        else {
            $val = "";
        }
        //Getting the data from the customer modal
        $data = $this->model_customer->search($val);
        $custom_data = array(
            'total_count' => count($data),
            'results' => $data,
            'pagination' => array('more' => true),
        );

        // echo json_encode($custom_data);
        echo '{
          "results": [
            {
              "id": 1,
              "text": "Option 1"
            },
            {
              "id": 2,
              "text": "Option 2"
            }
          ],
          "pagination": {
            "more": true
          }
        }';
        return false;
    }
    public function fetchCustomerData($id = null)
    {
        $data = $this->model_customer->getCustomerData($id);
        echo json_encode($data);
        return false;
    }
}
