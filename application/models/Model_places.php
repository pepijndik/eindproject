<?php

class Model_places extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getPlace($id)
    {
        $sql = "SELECT * FROM camp_places where id='$id'";
        $query = $this->db->query($sql);
        return $query->row_array();
    }
}
