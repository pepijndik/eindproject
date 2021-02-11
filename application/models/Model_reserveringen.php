<?php

class Model_reserveringen extends CI_Model
{
    public $today = null;
    public function __construct()
    {
        parent::__construct();
        $this->today = date('Y-m-d');
    }

    public function create_invoice($id)
    {
        //Get Reservering details.

        // create invoice row 
        $data = array(
            'reservering_id' => $id,
            'datum' => $this->today,
            'paid_status' => 'Pending',
            'discount' =>  $this->input->post('discount')
        );
        $this->db->insert('factuur', $data);
    }

    public function booked($place_id)
    {
        // $v =  $this->today;
        // $sql = "SELECT * FROM reserveringen WHERE aankomst >= $v";
        // $query = $this->db->query($sql);
        // if ($query->num_rows() > 1) {
        //     return $query->row_array();
        // }
        //1. Find booked dates with this place id and
        $sql = "SELECT aankomst,vertrek FROM reserveringen WHERE plaats_id='$place_id'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function update()
    {
        $id = $this->input->post('reservering_id');

        $reservering_data = array(
            'aankomst' => $this->input->post('aankomst_datum'),
            'vertrek' =>  $this->input->post('vertrek_datum'),
            'discount' => $this->input->post('discount')
        );
        $this->db->where('id', $id);

        $this->db->update('reserveringen', $reservering_data);
        $count = count($this->input->post('options'));
        //$count_val = count($this->input->post('value'));

        // echo $count . " " . $count_val . "<br>";

        // echo "Value : ";
        // print_r($this->input->post('value'));

        for ($i = 0; $i < $count; $i++) {

            $data = array(
                'value' =>  $this->input->post('value')[$i],
            );
            // echo "<br>";
            // print_r($data);
            $this->db->where('id',  $this->input->post('options')[$i]);
            $this->db->update('reservering_opties', $data);
        }
    }
    public function get($id = null)
    {
        $v =  $this->today;
        if ($id) {
            $sql = "SELECT * FROM reserveringen WHERE id =$id";
            $query = $this->db->query($sql);
            return $query->row_array();
        } else {
            $sql = "SELECT * FROM reserveringen WHERE aankomst >= $v";
            $query = $this->db->query($sql);
            return $query->result_array();
        }
    }

    public function create()
    {
        // print_r($this->input->post());
        // $this->load->model('model_company');
        // $company_data = $this->model_company->getCompanyData();

        if ($this->input->post('vertrek_datum') != null) {
            $end = $this->input->post('vertrek_datum');
        } else {
            $end = null;
        }
        $start_date = $this->input->post('aankomst_datum');

        $data = array(
            'klant_id' => $this->input->post('klant'),
            'aankomst' => $start_date,
            'vertrek' =>  $end,
            'discount' =>  $this->input->post('korting'),
            'plaats_id' => $this->input->post('plaats_id'),
        );
        $this->db->insert('reserveringen', $data);

        $reservering_id = $this->db->insert_id(); //get id
        //$reservering_id = 1;
        $count = count($this->input->post('option_id'));
        //$count_val = count($this->input->post('value'));

        // echo $count . " " . $count_val . "<br>";

        // echo "Value : ";
        // print_r($this->input->post('value'));

        for ($i = 0; $i < $count; $i++) {

            $data = array(
                'reservering_id' => $reservering_id,
                'form_optie_id' =>  $this->input->post('option_id')[$i],
                'value' =>  $this->input->post('value')[$i],
            );
            // echo "<br>";
            // print_r($data);
            $this->db->insert('reservering_opties', $data);
        }
        return $reservering_id;
    }

    public function remove($id)
    {
        if ($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('reserveringen');
            return ($delete == true) ? true : false;
        }
    }
}
