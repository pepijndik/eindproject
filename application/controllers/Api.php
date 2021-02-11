<?php

defined('BASEPATH') or exit('No direct script access allowed');

class api extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_news');
		$this->load->model('model_places');
	}
	public function places($id = null)
	{
		if ($id) {
			echo json_encode($this->model_places->getPlace($id));
		} else {
			// get all
		}
	}
	public function remove_nieuws()
	{
		if (!in_array('DeleteNews', $this->permission)) {
			redirect('admin/dashboard', 'refresh');
		}

		$news_id = $this->input->post('nieuws_id');

		$response = array();
		if ($news_id) {
			$delete = $this->model_news->remove($news_id);
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
	}
}
