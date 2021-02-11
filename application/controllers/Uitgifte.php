<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Uitgifte extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->not_logged_in();

    $this->data['page_title'] = 'uitgifte';

    $this->load->model('model_users');
    $this->load->model('model_uitgifte');
    $this->load->model('model_products');
    $this->load->model('model_company');
    $this->load->model('model_klas');
  }

  /* 
	* Standaard pagina
	*/
  public function index()
  {
    //check permissions
    if (!in_array('bekijk_uitgifte', $this->permission)) {
      redirect('dashboard', 'refresh');
    }

    $this->data['page_title'] = 'Uitgiftes';
    $this->render_template('uitgifte/index', $this->data);
  }
  /*
	* Fetches the orders data from the orders table 
	* this function is called from the datatable ajax function
	*/
  public function fetchUitgifteData()
  {
    $result = array('data' => array());

    $data = $this->model_uitgifte->getUitgifteData();

    foreach ($data as $key => $value) {

      $count_total_item = $this->model_uitgifte->countUitgifteItem($value['uitgifte_id']);
      //  $date = date('d-m-Y', $value['Uitgifte_datum_tijd']);
      //$time = date('h:i a', $value['Uitgifte_datum_tijd']);
      $date = $value['Uitgifte_datum_tijd'];
      //$date_time = $date . ' ' . $time;

      // button
      $buttons = '';

      if (in_array('bekijk_uitgifte', $this->permission)) {
        $buttons .= '<a target="__blank" href="' . base_url('uitgifte/printDiv/' . $value['uitgifte_id']) . '" class="btn btn-default"><i class="fa fa-print"></i></a>';
      }

      if (in_array('update_uitgifte', $this->permission)) {
        $buttons .= ' <a href="' . base_url('uitgifte/bewerk/' . $value['uitgifte_id']) . '" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
      }

      if (in_array('verwijder_uitgifte', $this->permission)) {
        $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc(' . $value['uitgifte_id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
      }

      if ($value['uitgifte_status'] == 1) {
        $status = '<span class="label label-success">Ingeleverd</span>';
      } else {
        $status = '<span class="label label-warning">Nog in bezit</span>';
      }

      $result['data'][$key] = array(
        $value['uitgifte_id'],
        $value['groep_id'],
        $date,
        $value['Inlever_datum_tijd'],
        $status,
        $buttons

      );
    } // /foreach
    //print_r($result);
    echo json_encode($result);
  }
  public function nieuw()
  {
    //check permissions
    if (!in_array('nieuw_uitgifte', $this->permission)) {
      redirect('dashboard', 'refresh');
    }

    $this->data['page_title'] = 'Nieuwe uitgiftes';
    $this->form_validation->set_rules('product[]', 'Product name', 'trim|required');

    if ($this->form_validation->run() == TRUE) {

      $order_id = $this->model_uitgifte->nieuw();

      if ($order_id) {
        $this->session->set_flashdata('success', 'Successfully created');
        redirect('uitgifte/bewerk/' . $order_id, 'refresh');
      } else {
        $this->session->set_flashdata('errors', 'Error occurred!!');
        redirect('uitgifte/nieuw/', 'refresh');
      }
    } else {
      // false case
      $company = $this->model_company->getCompanyData(1);
      $this->data['company_data'] = $company;
      $this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
      $this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

      $this->data['products'] = $this->model_products->getActiveProductData();

      $this->render_template('uitgifte/nieuw', $this->data);
    }
  }
  /*
	* If the validation is not valid, then it redirects to the edit orders page 
	* If the validation is successfully then it updates the data into the database 
	* and it stores the operation message into the session flashdata and display on the manage group page
	*/
  public function bewerk($id)
  {
    if (!in_array('updateOrder', $this->permission)) {
      redirect('dashboard', 'refresh');
    }

    if (!$id) {
      redirect('dashboard', 'refresh');
    }

    $this->data['page_title'] = 'Update Uitgifte';

    $this->form_validation->set_rules('product[]', 'Product name', 'trim|required');


    if ($this->form_validation->run() == TRUE) {

      $update = $this->model_uitgifte->update($id);

      if ($update == true) {
        $this->session->set_flashdata('success', 'Successfully updated');
        redirect('uitgifte/bewerk/' . $id, 'refresh');
      } else {
        $this->session->set_flashdata('errors', 'Error occurred!!');
        redirect('uitgifte/bewerk/' . $id, 'refresh');
      }
    } else {
      // false case
      // $company = $this->model_company->getCompanyData(1);

      $result = array();
      $uitgifte_data = $this->model_uitgifte->getUitgifteData($id);

      //print_r($uitgifte_data);
      $result['uitgifte'] = $uitgifte_data;
      $orders_item = $this->model_uitgifte->getuitgifteItemData($uitgifte_data['uitgifte_id']);
      print_r($orders_item);
      foreach ($orders_item as $k => $v) {
        $result['uitgifte_item'][] = $v;
      }

      $this->data['uitgifte_data'] = $result;

      $this->data['products'] = $this->model_products->getActiveProductData();

      $this->render_template('uitgifte/edit', $this->data);
    }
  }
  /*
	* It removes the data from the database
	* and it returns the response into the json format
	*/
  public function verwijder()
  {
    if (!in_array('verwijder_uitgifte', $this->permission)) {
      redirect('dashboard', 'refresh');
    }

    $uitgifte_id = $this->input->post('uitgifte_id');

    $response = array();
    if ($uitgifte_id) {
      $delete = $this->model_uitgifte->verwijder($uitgifte_id);
      if ($delete == true) {
        $response['success'] = true;
        $response['messages'] = "Succesvol verwijderd";
      } else {
        $response['success'] = false;
        $response['messages'] = "Error in the database while removing the product information";
      }
    } else {
      $response['success'] = false;
      $response['messages'] = "Refersh the page again!!";
    }

    echo json_encode($response);
  }
  /*
	* It gets the product id passed from the ajax method.
	* It checks retrieves the particular product data from the product id 
	* and return the data into the json format.
	*/
  public function getProductValueById()
  {
    $product_id = $this->input->post('product_id');
    if ($product_id) {
      $product_data = $this->model_products->getProductData($product_id);
      echo json_encode($product_data);
    }
  }
  public function getTableProductRow()
  {
    $products = $this->model_products->getActiveProductData();
    echo json_encode($products);
  }
  /*
	* It gets the product id and fetch the order data. 
	* The order print logic is done here 
	*/
  public function printDiv($id)
  {
    if (!in_array('viewOrder', $this->permission)) {
      redirect('dashboard', 'refresh');
    }

    if ($id) {
      $uitgifte_data = $this->model_uitgifte->getUitgifteData($id);
      $uitgifte_items = $this->model_uitgifte->getuitgifteItemData($id);
      $company_info = $this->model_company->getCompanyData(1);

      //verijg user data
      $user_data = $this->model_users->getUserData($uitgifte_data['aangemaakt_id']);

      $naam = $user_data['username'];
      //print_r($uitgifte_data);


      $status = ($uitgifte_data['uitgifte_status'] == 1) ? "Ingeleverd" : "nog in bezit";

      $html = '<!-- Main content -->
			<!DOCTYPE html>
			<html>
			<head>
			  <meta charset="utf-8">
			  <meta http-equiv="X-UA-Compatible" content="IE=edge">
			  <title>Pdik systems | Uitgifte</title>
			  <!-- Tell the browser to be responsive to screen width -->
			  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
			  <!-- Bootstrap 3.3.7 -->
			  <link rel="stylesheet" href="' . base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') . '">
			  <!-- Font Awesome -->
			  <link rel="stylesheet" href="' . base_url('assets/bower_components/font-awesome/css/font-awesome.min.css') . '">
			  <link rel="stylesheet" href="' . base_url('assets/dist/css/AdminLTE.min.css') . '">
			</head>
			<body onload="window.print();">
			
			<div class="wrapper">
			  <section class="invoice">
			    <!-- title row -->
			    <div class="row">
			      <div class="col-xs-12">
			        <h2 class="page-header">
			          ' . $company_info['company_name'] . '
                      <small class="pull-right">Uitgifte Datum: ' . $uitgifte_data['Uitgifte_datum_tijd'] . '</small><br>
                      <small class="pull-right">Inlever Datum: ' . $uitgifte_data['Inlever_datum_tijd'] . '</small>
			        </h2>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- info row -->
			    <div class="row invoice-info">
			      
			      <div class="col-sm-4 invoice-col">
			        
			        <b>Groep ID:</b> ' . $uitgifte_data['groep_id'] . '<br>
			   
			        <b>Klas:</b> Klas  <br />
			        <b>aangemaakt door::</b> ' . $naam . '
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->

			    <!-- Table row -->
			    <div class="row">
			      <div class="col-xs-12 table-responsive">
			        <table class="table table-striped">
			          <thead>
			          <tr>
			            <th>Product naam</th>
			         
			            <th>Aantal</th>
			        
			          </tr>
			          </thead>
			          <tbody>';

      foreach ($uitgifte_items as $k => $v) {

        $product_data = $this->model_products->getProductData($v['product_id']);

        $html .= '<tr>
				            <td>' . $product_data['name'] . '</td>
				            <td>' . $v['aantal'] . '</td>	       
			          	</tr>';
      }

      $html .= '</tbody>
			        </table>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->

			    <div class="row">
			      
			      <div class="col-xs-6 pull pull-right">

			        <div class="table-responsive">
			          <table class="table">
			          
			            <tr>
			              <th>Inlever status:</th>
			              <td>' . $status . '</td>
			            </tr>
			          </table>
			        </div>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->
			  </section>
			  <!-- /.content -->
			</div>
		</body>
	</html>';

      echo $html;
    }
  }
}
