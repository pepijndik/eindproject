<?php

class Model_prices extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getall()
    {
        $sql = "SELECT * FROM form_options";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
