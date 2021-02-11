<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->data['page_title'] = 'Stores';
		$this->load->model('model_reports');
	}

	/* 
    * It redirects to the report page
    * and based on the year, all the orders data are fetch from the database.
    */
	public function index()
	{
		if (!in_array('viewReports', $this->permission)) {
			redirect('dashboard', 'refresh');
		}




		$years = $this->model_reports->getInvoiceYear();
		$this->data['report_years'] =  $years;
		$today_year = $this->find_closest($years, date("Y")); //Select always the closest year  to this year, if this year has now data then selected previos as default

		if ($this->input->post('select_year')) {
			$today_year = $this->input->post('select_year');
		}

		$parking_data = $this->model_reports->getInvoiceData($today_year);

		$final_parking_data = array();
		$aantal_r = array();
		foreach ($parking_data as $k => $v) {


			if (count($v) > 1) {
				$total_amount_earned = array();
				$total_r_m = array();
				foreach ($v as $k2 => $v2) {
					if ($v2) {
						$total_amount_earned[] = $v2['gross_amount'];
						$total_r_m[] = 1;
					}
				}
				$final_parking_data[$k] = array_sum($total_amount_earned);
				$aantal_r[$k] =  array_sum($total_r_m);
			} else {
				$final_parking_data[$k] = 0;
				$aantal_r[$k] = 0;
			}
		}

		$this->data['selected_year'] = $today_year;
		$this->data['company_currency'] = $this->company_currency();
		$this->data['results'] = $final_parking_data;
		$this->data['reserveringen'] = $aantal_r;
		$this->render_template('reports/index', $this->data);
	}

	function find_closest($array, $date)
	{
		//$count = 0;
		foreach ($array as $day) {
			//$interval[$count] = abs(strtotime($date) - strtotime($day));
			$interval[] = abs(strtotime($date) - strtotime($day));
			//$count++;
		}

		asort($interval);
		$closest = key($interval);

		return $array[$closest];
	}
}
