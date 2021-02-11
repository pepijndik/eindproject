<?php

defined('BASEPATH') or exit('No direct script access allowed');


/**
 * 
 * Main admin controller
 * 
 * @author pepijn dik
 */
class Admin extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();

		//Loading models
		$this->load->model('model_auth');
		$this->load->model('model_news');
		$this->load->model('model_company');
		$this->load->model('model_reserveringen');
		$this->load->model('model_customer');
		$this->load->model('model_form');
		$this->load->model('model_facturen');
		$this->load->model('model_Mailer');
	}


	public function index()
	{

		$this->logged_in();
		$this->load->view('login');
	}
	/* 
		Check if the login form is submitted, and validates the user credential
		If not submitted it redirects to the login page
	*/
	public function login()
	{

		$this->logged_in();

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == TRUE) {
			// true case
			$exist = $this->model_auth->check_username($this->input->post('username'));

			if ($exist == TRUE) {
				$login = $this->model_auth->login($this->input->post('username'), $this->input->post('password'));

				if ($login) {
					$logged_in_sess = array(
						'id' => $login['id'],
						'username'  => $login['username'],
						'email'     => $login['email'],
						'logged_in' => TRUE
					);

					$this->session->set_userdata($logged_in_sess);
					redirect('admin/dashboard', 'refresh');
				} else {
					$this->data['errors'] = 'Combinatie wachtwoord en gebruikersnaam incorect';
					$this->load->view('login', $this->data);
				}
			} else {
				$this->data['errors'] = 'Gebruikersnaam Bestaat niet';

				$this->load->view('login', $this->data);
			}
		} else {
			// false case

			$this->load->view('login');
		}
	}

	/**
	 * Manage prices
	 */
	public function tarieven($actie = null, $id = null)
	{

		$this->not_logged_in();
		$this->data['page_title'] = ' La Rustique | Tarieven';
		switch ($actie) {
			case "get":
				if (empty($id)) {
					$data = $this->model_form->fetch();
					foreach ($data as $key => $value) {
						// button
						$buttons = '';
						if (in_array('updateCompany', $this->permission)) {
							$buttons .= ' <button onclick="editPrice(' . $value['id'] . ')"   data-toggle="modal" data-target="#editPrice" class="btn btn-default"><i class="fa fa-pencil"></i></button>';
						}

						if (in_array('updateCompany', $this->permission)) {
							$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
						}


						$result['data'][$key] = array(

							$value['what'],
							$value['price'],
							$value['type'],
							$value['max'],
							$buttons
						);
					} // /foreach

					echo json_encode($result);
				} else {

					echo json_encode($this->model_form->getPrice($id));
				}

				break;
			case "view":
				$this->render_template('prices/index', $this->data);
				break;

			case "update":
				$up = $this->model_form->update();
				if ($up) {
					return true;
				} else {
					return false;
				}

				break;
		}
	}

	public function camping_map()
	{

		$this->render_template('place_picker/show', $this->data);
	}
	public function dashboard()
	{
		$this->data['page_title'] = ' La Rustique | Dashboard';

		$this->not_logged_in();


		$user_id = $this->session->userdata('id');
		$is_admin = ($user_id == 1) ? true : false;

		$this->data['is_admin'] = $is_admin;
		$this->render_template('dashboard', $this->data);
	}
	public function klant($actie = null, $id = null)
	{
		$this->not_logged_in();
		switch ($actie) {
			case "create":
				$this->form_validation->set_rules('naam', 'naam', 'trim|required');
				$this->form_validation->set_rules('email', 'email', 'trim|required');
				if ($this->form_validation->run() == TRUE) {
					$klanten = $this->model_customer->create();
					if ($klanten) {
						$this->session->set_flashdata('success', 'Klant succesvol aangemaakt');
						redirect('admin/reseveringen/add', 'refresh');
					} else {
						$this->session->set_flashdata('errors', 'Error occurred!!');
						redirect('admin/klant/create', 'refresh');
					}
				}
				break;
		}
	}

	public function reseveringen($actie = null, $id = null)
	{
		$this->not_logged_in();
		if (!in_array('ViewReserveringen', $this->permission)) {
			redirect('admin/dashboard', 'refresh');
		}
		switch ($actie) {
			case "invoice":
				if (!in_array('CreateReserveringen', $this->permission)) {
					redirect('admin/dashboard', 'refresh');
				}
				$c_id = $this->input->post('id');
				if ($c_id) {
					//1. Maak factuur
					$f = $this->model_reserveringen->create_invoice($c_id);
					if ($f) {
						$this->session->set_flashdata('success', 'Successfully created');

						redirect('admin/facturen/view', 'refresh');
					}
				} else {
					$this->data['page_title'] = ' La Rustique | Maak factuur';
					$this->session->set_flashdata('errors', 'Geen factuur');
					$this->render_template('reseveringen/index', $this->data);
				}
				break;
			case "view":
				if (!in_array('ViewReserveringen', $this->permission)) {
					redirect('admin/dashboard', 'refresh');
				}
				$this->data['page_title'] = ' La Rustique | Reseveringen';
				$this->render_template('reseveringen/index', $this->data);
				break;

			case "add":

				if (!in_array('CreateReserveringen', $this->permission)) {
					redirect('admin/dashboard', 'refresh');
				}
				$this->form_validation->set_rules('aankomst_datum', 'Aankomst', 'required');
				$this->form_validation->set_rules('klant', 'klant', 'required');
				if ($this->form_validation->run() == TRUE) {
					$id = $this->model_reserveringen->create();
					if ($id) {
						$this->session->set_flashdata('success', 'Successfully created');
						redirect('admin/reseveringen/edit/' . $id, 'refresh');
						//Send email with to confirm resevation 
						// $this->model_Mailer->init(true, $smtp);
					} else {
						$this->session->set_flashdata('errors', 'Error occurred!!');
						redirect('admin/reseveringen/add', 'refresh');
					}
				} else {
					$company = $this->model_company->getCompanyData(1);
					$klanten = $this->model_customer->getCustomerData();
					$form_options =  $this->model_form->getOptions();
					$this->data['company_data'] = $company;
					$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
					$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;
					$this->data['page_title'] = ' La Rustique | Reseveringen';
					$this->data['klanten'] = $klanten;
					$this->data['form_options'] = $form_options;
					$this->render_template('reseveringen/nieuw', $this->data);
				}
				break;
			case "edit":
				if (!in_array('UpdateReserveringen', $this->permission)) {
					redirect('admin/dashboard', 'refresh');
				}
				$this->form_validation->set_rules('aankomst_datum', 'Aankomst', 'required');
				if ($this->form_validation->run() == TRUE) {
					$this->model_reserveringen->update($id);
					if ($id) {
						$this->session->set_flashdata('success', 'Successfully created');
						redirect('admin/reseveringen/edit/' . $id, 'refresh');
						//Send email with to confirm resevation 
						// $this->model_Mailer->init(true, $smtp);
					} else {
						$this->session->set_flashdata('errors', 'Error occurred!!');
						redirect('admin/reseveringen/edit/' . $id, 'refresh');
					}
				} else {
					$this->data['page_title'] = ' La Rustique | Reseveringen';
					$r = $this->model_reserveringen->get($id);
					$klanten = $this->model_customer->getCustomerData();
					$form_options =  $this->model_form->getSelected($r['id']);
					$company = $this->model_company->getCompanyData(1);
					$this->data['company_data'] = $company;
					$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
					$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;
					$this->data['klanten'] = $klanten;
					$this->data['reservering'] = $r;
					$this->data['form_options'] = $form_options;
					$this->render_template('reseveringen/edit', $this->data);
				}

				break;
			case "delete":
				if (!in_array('DeleteReserveringen', $this->permission)) {
					redirect('admin/dashboard', 'refresh');
				}
				$r_id = $this->input->post('id');

				echo $r_id . "id";
				$response = array();
				if ($r_id) {
					$delete = $this->model_reserveringen->remove($r_id);
					if ($delete == true) {
						$response['success'] = true;
						$response['messages'] = "Successfully removed";
					} else {
						$response['success'] = false;
						$response['messages'] = "Error in the database while removing the product information";
					}
				} else {
					$response['success'] = false;
					$response['messages'] = "Refersh the page again!!";
				}
				echo json_encode($response);
				break;
			case "booked":
				$booked_dates = $this->model_reserveringen->booked($id);
				echo json_encode($booked_dates);
				break;
			case "get":
				$data = $this->model_reserveringen->get();
				if (empty($data)) {
					echo json_encode(array());
				} else {


					foreach ($data as $key => $value) {
						// button
						$buttons = '';
						$buttons .= ' <a data-toggle="modal" data-target="#printFactuur"  onclick="setid(' . $value['id'] . ')"  class="btn btn-default"><i class="fa fa-file-pdf-o"></i></a>';

						if (in_array('UpdateReserveringen', $this->permission)) {
							$buttons .= ' <a href="' . base_url('admin/reseveringen/edit/' . $value['id']) . '" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
						}

						if (in_array('DeleteReserveringen', $this->permission)) {
							$buttons .= ' <button type="button" class="btn btn-default" onclick="removeReservering(' . $value['id'] . ')" data-toggle="modal" data-target="#removeReserveringModal"><i class="fa fa-trash"></i></button>';
						}

						$c = $this->model_customer->getCustomerData($value['klant_id']);
						//		$p = $this->
						$result['data'][$key] = array(
							$value['id'],
							$c['voornaam'] . " " . $c['tvoegsel'] . " " . $c['achternaam'],
							$value['plaats_id'],
							$value['aankomst'],
							$value['vertrek'],
							$buttons
						);
					} // /foreach

					echo json_encode($result);
				}
				break;
			default:
				$this->data['page_title'] = ' La Rustique | Reseveringen';
				$this->render_template('reseveringen/index', $this->data);
				break;
		}
	}
	public function facturen($actie = null, $id = null)
	{
		$this->not_logged_in();
		if (!in_array('ViewFactuur', $this->permission)) {
			redirect('admin/dashboard', 'refresh');
		}
		switch ($actie) {
			case "send":
				//1. get invoice
				$send =	$this->model_facturen->send($id);
				if ($send) {
					$this->session->set_flashdata('success', 'Verstuurd');
					$this->render_template('facturen/index', $this->data);
				} else {
					$this->session->set_flashdata('errors', 'Geen factuur');
					$this->render_template('facturen/index', $this->data);
				}
				//2 Send invoice
				break;
			case "get":
				$data = $this->model_facturen->get();
				if (empty($data)) {
					echo json_encode(array());
				} else {

					foreach ($data as $key => $value) {
						// button
						$buttons = '';

						if (in_array('UpdateReserveringen', $this->permission)) {
							$buttons .= ' <a href="' . base_url('admin/facturen/send/' . $value['id']) . '" class="btn btn-default"><i class="fa  fa-paper-plane"></i></a>';
						}

						if (in_array('DeleteReserveringen', $this->permission)) {
							$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFacturen(' . $value['id'] . ')" data-toggle="modal" data-target="#removeFacturenModal"><i class="fa fa-trash"></i></button>';
						}

						$r = $this->model_reserveringen->get($value['reservering_id']);
						$c = $this->model_customer->getCustomerData($r['klant_id']);
						//		$p = $this->
						$result['data'][$key] = array(
							$value['id'],
							$c['voornaam'] . " " . $c['tvoegsel'] . " " . $c['achternaam'],
							$r['discount'],
							$buttons
						);
					} // /foreach

					echo json_encode($result);
				}
				break;
			case "view":
				if (!in_array('DeleteFactuur', $this->permission)) {
					redirect('admin/dashboard', 'refresh');
				}
				$this->data['page_title'] = ' La Rustique | Facturen';
				$this->render_template('facturen/index', $this->data);
				break;

			case "add":
				if (!in_array('CreateFactuur', $this->permission)) {
					redirect('admin/dashboard', 'refresh');
				}
				$this->data['page_title'] = ' La Rustique | Reseveringen';
				$this->render_template('reseveringen/index', $this->data);
				break;
			case "edit":
				if (!in_array('UpdateFactuur', $this->permission)) {
					redirect('admin/dashboard', 'refresh');
				}
				$this->data['page_title'] = ' La Rustique | Reseveringen';
				$this->render_template('reseveringen/index', $this->data);
				break;
			case "delete":
				if (!in_array('DeleteFactuur', $this->permission)) {
					redirect('admin/dashboard', 'refresh');
				}
				$id = $this->input->post('id');

				echo $id . "id";
				$response = array();
				if ($id) {
					$delete = $this->model_facturen->delete($id);
					if ($delete == true) {
						$response['success'] = true;
						$response['messages'] = "Successfully removed";
					} else {
						$response['success'] = false;
						$response['messages'] = "Error in the database while removing the product information";
					}
				} else {
					$response['success'] = false;
					$response['messages'] = "Refersh the page again!!";
				}
				echo json_encode($response);
				break;
			default:
				$this->data['page_title'] = ' La Rustique | Facturen';
				$this->render_template('facturen/index', $this->data);
				break;
		}
	}

	public function form($actie = null, $id = null)
	{
		//Get form prices 
		switch ($actie) {
			case "getPrice":
				$prices = $this->model_form->getPrice();
				echo json_encode($prices);
				break;
			case  "create":
				//Create new form option
				break;
			case "update":
				$this->model_form->update($id);
				break;
		}
	}

	public function news($actie = null)
	{

		$this->not_logged_in();
		// if(isset($actie)){
		switch ($actie) {
			case "create":
				if (!in_array('CreateNews', $this->permission)) {
					redirect('admin/dashboard', 'refresh');
				}
				$this->form_validation->set_rules('news_title', 'News title', 'required');
				$this->form_validation->set_rules('news_beschrijving', 'News Beschrijving', 'required');
				if ($this->form_validation->run() == TRUE) {
					$news_id = $this->model_news->create();
					if ($news_id) {
						$this->session->set_flashdata('success', 'Successfully created');
						redirect('admin/news/edit/' . $news_id, 'refresh');
					} else {
						$this->session->set_flashdata('errors', 'Error occurred!!');
						redirect('admin/news/create', 'refresh');
					}
				} else {
					$this->data['page_title'] = ' La Rustique | News | Create';
					$this->render_template('news/create', $this->data);
				}
				break;
			case "view":
				break;
			default:
				$this->data['page_title'] = ' La Rustique | News';
				$this->render_template('news/index', $this->data);
				break;
		}
	}
	public function rapport()
	{
		$this->render_template('reports/index', $this->data);
	}
	/*
		clears the session and redirects to login page
	*/
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('admin/login', 'refresh');
	}
}
