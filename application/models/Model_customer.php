<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_customer extends CI_Model
{
        public function __construct()
        {
                parent::__construct();
        }


        public function search($val)
        {
                if ($val) {
                        $sql = "SELECT * FROM klanten WHERE achternaam like ?";
                        $query = $this->db->query($sql, array($val));
                        return $query->row_array();
                } else {
                        $sql = "SELECT * from klanten";
                        $query = $this->db->query($sql);
                        return $query->result_array();
                        //return json_encode()
                }
        }
        /* get the brand data */
        public function getCustomerData($id = null)
        {
                if ($id) {
                        $sql = "SELECT * FROM klanten WHERE id = ?";
                        $query = $this->db->query($sql, array($id));
                        return $query->row_array();
                } else {
                        $sql = "SELECT * from klanten";
                        $query = $this->db->query($sql);
                        return $query->result_array();
                }
        }

        public function update($data, $id)
        {
                if ($data && $id) {
                        $this->db->where('id', $id);
                        $update = $this->db->update('company', $data);
                        return ($update == true) ? true : false;
                }
        }

        public function create()
        {
                $user_id = $this->session->userdata('id');
                $data = array(
                        'voornaam' => $this->input->post('naam'),
                        'tvoegsel' => $this->input->post('tvoegsel'),
                        'achternaam' => $this->input->post('achternaam'),
                        'email' => $this->input->post('email'),
                );
                $c_id =  $this->db->insert('klanten', $data);
                return ($c_id) ? $c_id : false;
        }
}
