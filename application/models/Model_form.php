<?php

class Model_form extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getPrice($id = null)
    {
        if ($id) {
            $sql = "SELECT * FROM form_options where id = $id";
            $query = $this->db->query($sql);
            return $query->row_array();
        } else {
            $sql = "SELECT * FROM form_options";
            $query = $this->db->query($sql);
            return $query->result_array();
        }
    }

    public function remove($id)
    {
        if ($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('form_options');
            return ($delete == true) ? true : false;
        }
    }
    public function fetch()
    {
        $sql = "SELECT * FROM form_options ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function getOptions()
    {
        $sql = "SELECT * FROM form_options";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getSelected($r_id = null)
    {
        $sql = "SELECT reservering_opties.id as selected_option, form_options.what, form_options.type, reservering_opties.reservering_id, form_options.id as id,reservering_opties.value    FROM reservering_opties INNER JOIN form_options on reservering_opties.form_optie_id = form_options.id WHERE reservering_id = $r_id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function update()
    {
        if (empty($this->input->post('max'))) {
            $max = null;
        } else {
            $max = $this->input->post('max');
        }

        $data =  array(
            'what' => $this->input->post('what'),
            'price' => $this->input->post('price'),
            'type' => $this->input->post('type'),
            'max' => $max
        );
        //  print_r($data);
        $this->db->where('id', $this->input->post('id'));
        $update = $this->db->update('form_options', $data);
        return ($update == true) ? true : false;
    }
}
