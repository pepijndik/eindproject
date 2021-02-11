<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class main extends Admin_Controller 
{

	public function __construct()
	{
		parent::__construct();	
		$this->load->model('model_news');

	}
	public function index()
	{	
		$news = $this->model_news->getAllNews();
		$this->data['news'] = $news;
    	$this->load->view('public/index', $this->data);
	}

	public function nieuws($id = null){
		if($id == null){
			$this->data['new'] =$this->model_news->getAllNews();
			$this->load->view('public/news', $this->data);
		}else{
			$news = $this->model_news->getNews($id);
			$this->data['new'] = $news[0];
			$this->data['other_news'] =$this->model_news->getOtherNews($id);
			$this->load->view('public/news', $this->data);
		}
		
	
	}


	public function getnews(){
		$result = array('data' => array());

		$data =  $this->model_news->getAllNews();

		foreach ($data as $key => $value) {

			// button
			$buttons = '';

			if (in_array('ViewNews', $this->permission)) {
				$buttons .= '<a target="__blank" href="' . base_url('main/nieuws/' . $value['id']) . '" class="btn btn-default"><i class="fa fa-print"></i></a>';
			}


			if (in_array('DeleteNews', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}



			$result['data'][$key] = array(
				$value['id'],
				$value['datum'],
				$value['title'],
				$value['beschrijving'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);

	}

	public function remove_nieuws(){
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
