<?php

class Model_uitgifte extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function nieuw()
    {
        $user_id = $this->session->userdata('id');


        $vandaag = getdate();
        $vandaag_tijd = date_format($vandaag, 'H:i:s');
        $vandaag_datum =  date_format($vandaag, 'd/m/y');
        $data = array(
            'groep_id' => $this->input->post('groep_id'),
            'Uitgifte_datum_tijd' => date('Y-m-d h:i:s a'),
            'Inlever_datum_tijd' => null,
            'uitgifte_status' => 0,
            'aangemaakt_id' => $user_id
        );

        $insert = $this->db->insert('uitgiftes', $data);
        $order_id = $this->db->insert_id();
        //Laad producten modal
        $this->load->model('model_products');
        $count_product = count($this->input->post('product'));
        for ($x = 0; $x < $count_product; $x++) {
            $items = array(
                'uitgifte_id' => $order_id,
                'product_id' => $this->input->post('product')[$x],
                'aantal' => $this->input->post('qty')[$x],
                // 'box' => $this->input->post('box')[$x],
                'box' => 0
            );

            $this->db->insert('uitgifte_items', $items);

            // now decrease the stock from the product
            $product_data = $this->model_products->getProductData($this->input->post('product')[$x]);
            $qty = (int) $product_data['qty'] - (int) $this->input->post('qty')[$x];

            $update_product = array('qty' => $qty);


            $this->model_products->update($update_product, $this->input->post('product')[$x]);
        }

        return ($order_id) ? $order_id : false;
    }



    public function countUitgifteItem($uitgifte_id)
    {
        if ($uitgifte_id) {
            $sql = "SELECT * FROM uitgifte_items WHERE uitgifte_id = ?";
            $query = $this->db->query($sql, array($uitgifte_id));
            return $query->num_rows();
        }
    }

    // get the uitgifte  groep item data
    public function getUitgifteGroepItemData($groep_id = null)
    {
        if (!$groep_id) {
            return false;
        }

        $sql = "SELECT * FROM uitgifte_groep_items WHERE groep_id = ?";
        $query = $this->db->query($sql, array($groep_id));
        return $query->result_array();
    }
    /* get the uitgite data */
    public function getUitgifteData($id = null)
    {
        if ($id) {
            $sql = "SELECT * FROM uitgiftes WHERE uitgifte_id = ?";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT * FROM uitgiftes ORDER BY uitgifte_id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    // get the orders item data
    public function getuitgifteItemData($uitgifte_id = null)
    {
        if (!$uitgifte_id) {
            return false;
        }

        $sql = "SELECT * FROM uitgifte_items WHERE uitgifte_id = ?";
        $query = $this->db->query($sql, array($uitgifte_id));
        return $query->result_array();
    }


    public function update($id)
    {
        if ($id) {
            $user_id = $this->session->userdata('id');
            // fetch the order data 

            $data = array(
                'groep_id' => $this->input->post('groep_id'),
                'Uitgifte_datum_tijd' => $this->input->post('Uitgifte_datum_tijd'),
                'Inlever_datum_tijd' => $this->input->post('inlever_datum_tijd'),
                'uitgifte_status' => $this->input->post('uitgifte_status'),
                'aangemaakt_id' => $user_id
            );

            $this->db->where('uitgifte_id', $id);
            $update = $this->db->update('uitgiftes', $data);

            // now the order item 
            // first we will replace the product qty to original and subtract the qty again
            $this->load->model('model_products');
            $get_order_item = $this->getuitgifteItemData($id);
            foreach ($get_order_item as $k => $v) {
                $product_id = $v['product_id'];
                $qty = $v['aantal'];
                // get the product 
                $product_data = $this->model_products->getProductData($product_id);
                $update_qty = $qty + $product_data['qty'];
                $update_product_data = array('qty' => $update_qty);

                // update the product qty
                $this->model_products->update($update_product_data, $product_id);
            }

            // now remove the order item data 
            $this->db->where('uitgifte_id', $id);
            $this->db->delete('uitgifte_items');

            // now decrease the product qty
            $count_product = count($this->input->post('product'));
            for ($x = 0; $x < $count_product; $x++) {
                $items = array(
                    'uitgifte_id' => $id,
                    'product_id' => $this->input->post('product')[$x],
                    'aantal' => $this->input->post('aantal')[$x],
                    'box' => 0,
                );
                $this->db->insert('uitgifte_items', $items);

                // now decrease the stock from the product
                $product_data = $this->model_products->getProductData($this->input->post('product')[$x]);
                //If ingeleverd update
                if ($data['uitgifte_status'] == 1) {
                    // + 
                    $qty = (int) $product_data['qty'] + (int) $this->input->post('qty')[$x];
                } else {
                    // -
                    $qty = (int) $product_data['qty'] - (int) $this->input->post('qty')[$x];
                }


                $update_product = array('qty' => $qty);
                $this->model_products->update($update_product, $this->input->post('product')[$x]);
            }

            return true;
        }
    }

    public function verwijder($id)
    {
        if ($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('uitgiftes');

            $this->db->where('uitgifte_id', $id);
            $delete_item = $this->db->delete('uitgifte_items');
            return ($delete == true && $delete_item) ? true : false;
        }
    }

    public function countTotaalUitgiftes()
    {
        $sql = "SELECT * FROM uitgiftes WHERE uitgifte_status = ?";
        $query = $this->db->query($sql, array(0));
        return $query->num_rows();
    }

    public function countTotaalIngeleverdUitgiftes()
    {
        $sql = "SELECT * FROM uitgiftes WHERE uitgifte_status = ?";
        $query = $this->db->query($sql, array(1));
        return $query->num_rows();
    }
}
