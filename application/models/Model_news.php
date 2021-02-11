<?php 

class Model_news extends CI_Model
{

    /**
     *
     * @description Get news from database 
     */
	public function __construct()
	{
		parent::__construct();
    }

    	/* get the News data */
	public function getAllNews()
	{
		$sql = "SELECT * FROM camping_news";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create(){
		$data = array(
            'title' => $this->input->post('news_title'),
            'datum' => date('Y-m-d h:i:s a'),
            'beschrijving' => $this->input->post('news_beschrijving'),
			'post_url' => '/main/nieuws' 
        );

        $insert = $this->db->insert('camping_news', $data);
		$news_id = $this->db->insert_id();
		return ($news_id) ? $news_id : false;
	}
	public function getNews($id){
		$sql = "SELECT * FROM camping_news where id= $id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getOtherNews($id){
		$sql = "SELECT * FROM camping_news 
		WHERE  id !=$id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('camping_news');
			return ($delete == true) ? true : false;
		}else{
			return false;
		}
	}

    
}