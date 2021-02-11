<?php

class Model_facturen extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_Mailer');
        $this->load->model('model_reserveringen');
        $this->load->helper('file');
        $this->load->model('model_company');
    }

    public function get($id = null)
    {
        if ($id) {
            $sql = "SELECT * FROM factuur WHERE id =$id";
            $query = $this->db->query($sql);
            return $query->row_array();
        } else {
            $sql = "SELECT * FROM factuur";
            $query = $this->db->query($sql);
            return $query->result_array();
        }
    }

    public function delete($id)
    {
        if ($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('factuur');
            return ($delete == true) ? true : false;
        }
    }
    public function send($id)
    {
        //1. get invoice,
        //2. Get Reservering options
        //3. Send mail
        if ($id) {

            $sql = "SELECT * from factuur WHERE id='$id'";
            $query = $this->db->query($sql);
            $factuur = $query->row_array();

            $reservering = $this->model_reserveringen->get($factuur['reservering_id']);

            $r_id = $reservering['id'];
            $klant_id = $reservering['klant_id'];
            $sql = "SELECT * from klanten WHERE id='$klant_id'";
            $query = $this->db->query($sql);
            $klant = $query->row_array();
            $c = $this->model_company->getCompanyData(1);
            $subject = $c['company_name'] . "Factuur";

            $plaintext = "test";
            $to = array(
                array(
                    'name' => $klant['voornaam'],
                    'email' => $klant['email'],
                ),
            );
            $f_date = date_create($factuur['datum']);
            $factuur_date =  date_format($f_date, 'd-M-Y');

            $html_lijnen =  "";
            $sql = "SELECT * FROM reservering_opties WHERE reservering_id='$r_id'";
            $query = $this->db->query($sql);
            $sub = 0;
            $totaal = 0;

            $factuur_lijnen = $query->result_array();
            foreach ($factuur_lijnen as $lijnen) {
                $lijn_id = $lijnen['form_optie_id'];
                $sql = "SELECT * FROM form_options WHERE id='$lijn_id'";
                $query = $this->db->query($sql);
                $lijn = $query->row_array();
                if (is_numeric($lijnen['value'])) {
                    $aantal =  $lijnen['value'];
                    $item_totaal = $lijn['price'] * $lijnen['value'];
                } else {
                    $item_totaal = $lijn['price'];
                    $aantal = 1;
                }
                $lijn_html = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"88%\" style=\"width: 88% !important; min-width: 88%; max-width: 88%; border-width: 1px; border-style: solid; border-color: #e8e8e8; border-top: none; border-left: none; border-right: none;\">
                <tr>

                   <td width=\"7\" style=\"width: 7px; max-width: 7px; min-width: 7px;\">&nbsp;</td>
                   <td align=\"left\" valign=\"top\" width=\"57%\" style=\"width: 57%; max-width: 57%; min-width: 90px\">
                      <div style=\"height: 22px; line-height: 22px; font-size: 20px;\">&nbsp;</div>
                      <font face=\"'Source Sans Pro', sans-serif\" color=\"#000000\" style=\"font-size: 17px; line-height: 21px; font-weight: 600;\">
                         <span style=\"font-family: 'Source Sans Pro', Arial, Tahoma, Geneva, sans-serif; color: #000000; font-size: 17px; line-height: 21px; font-weight: 600;\">" . $lijn['what'] . "</span>
                      </font>
                      <div style=\"height: 2px; line-height: 2px; font-size: 1px;\">&nbsp;</div>
                      <font face=\"'Source Sans Pro', sans-serif\" color=\"#000000\" style=\"font-size: 17px; line-height: 21px;\">
                         <span style=\"font-family: 'Source Sans Pro', Arial, Tahoma, Geneva, sans-serif; color: #000000; font-size: 17px; line-height: 21px;\"></span>
                      </font>
                      <div style=\"height: 10px; line-height: 10px; font-size: 10px;\">&nbsp;</div>
                   </td>
                   <td width=\"7\" style=\"width: 7px; max-width: 7px; min-width: 7px;\">&nbsp;</td>
                   <td align=\"left\" valign=\"top\" width=\"10%\" style=\"width: 10%; max-width: 10%; min-width: 40px\">
                      <div style=\"height: 22px; line-height: 22px; font-size: 20px;\">&nbsp;</div>
                      <font face=\"'Source Sans Pro', sans-serif\" color=\"#000000\" style=\"font-size: 17px; line-height: 21px;\">
                         <span style=\"font-family: 'Source Sans Pro', Arial, Tahoma, Geneva, sans-serif; color: #000000; font-size: 17px; line-height: 21px;\">" . $aantal . "</span>
                      </font>
                      <div style=\"height: 10px; line-height: 10px; font-size: 10px;\">&nbsp;</div>
                   </td>
                   <td width=\"7\" style=\"width: 7px; max-width: 7px; min-width: 7px;\">&nbsp;</td>
                   <td align=\"right\" valign=\"top\" width=\"12%\" style=\"width: 12%; max-width: 12%; min-width: 70px\">
                      <div style=\"height: 22px; line-height: 22px; font-size: 20px;\">&nbsp;</div>
                      <font face=\"'Source Sans Pro', sans-serif\" color=\"#000000\" style=\"font-size: 17px; line-height: 21px;\">
                         <span style=\"font-family: 'Source Sans Pro', Arial, Tahoma, Geneva, sans-serif; color: #000000; font-size: 17px; line-height: 21px;\">€" . $item_totaal . "</span>
                      </font>
                      <div style=\"height: 10px; line-height: 10px; font-size: 10px;\">&nbsp;</div>
                   </td>
                </tr>
             </table>";
                if (is_numeric($lijnen['value']) && $lijnen['value'] > 0  || $lijnen['value'] == "on") {
                    $sub += $item_totaal;
                    $html_lijnen .= $lijn_html;
                }

                //1. Get Prices for each line
                //2. Calc total itme price 
                //3. Create Item line

            }
            if (is_numeric($reservering['discount'])) {
                $sub -= $reservering['discount'];
                $lijn_html = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"88%\" style=\"width: 88% !important; min-width: 88%; max-width: 88%; border-width: 1px; border-style: solid; border-color: #e8e8e8; border-top: none; border-left: none; border-right: none;\">
                <tr>

                   <td width=\"7\" style=\"width: 7px; max-width: 7px; min-width: 7px;\">&nbsp;</td>
                   <td align=\"left\" valign=\"top\" width=\"57%\" style=\"width: 57%; max-width: 57%; min-width: 90px\">
                      <div style=\"height: 22px; line-height: 22px; font-size: 20px;\">&nbsp;</div>
                      <font face=\"'Source Sans Pro', sans-serif\" color=\"#000000\" style=\"font-size: 17px; line-height: 21px; font-weight: 600;\">
                         <span style=\"font-family: 'Source Sans Pro', Arial, Tahoma, Geneva, sans-serif; color: #000000; font-size: 17px; line-height: 21px; font-weight: 600;\">Korting</span>
                      </font>
                      <div style=\"height: 2px; line-height: 2px; font-size: 1px;\">&nbsp;</div>
                      <font face=\"'Source Sans Pro', sans-serif\" color=\"#000000\" style=\"font-size: 17px; line-height: 21px;\">
                         <span style=\"font-family: 'Source Sans Pro', Arial, Tahoma, Geneva, sans-serif; color: #000000; font-size: 17px; line-height: 21px;\"></span>
                      </font>
                      <div style=\"height: 10px; line-height: 10px; font-size: 10px;\">&nbsp;</div>
                   </td>
                   <td width=\"7\" style=\"width: 7px; max-width: 7px; min-width: 7px;\">&nbsp;</td>
                   <td align=\"left\" valign=\"top\" width=\"10%\" style=\"width: 10%; max-width: 10%; min-width: 40px\">
                      <div style=\"height: 22px; line-height: 22px; font-size: 20px;\">&nbsp;</div>
                      <font face=\"'Source Sans Pro', sans-serif\" color=\"#000000\" style=\"font-size: 17px; line-height: 21px;\">
                         <span style=\"font-family: 'Source Sans Pro', Arial, Tahoma, Geneva, sans-serif; color: #000000; font-size: 17px; line-height: 21px;\">Actie</span>
                      </font>
                      <div style=\"height: 10px; line-height: 10px; font-size: 10px;\">&nbsp;</div>
                   </td>
                   <td width=\"7\" style=\"width: 7px; max-width: 7px; min-width: 7px;\">&nbsp;</td>
                   <td align=\"right\" valign=\"top\" width=\"12%\" style=\"width: 12%; max-width: 12%; min-width: 70px\">
                      <div style=\"height: 22px; line-height: 22px; font-size: 20px;\">&nbsp;</div>
                      <font face=\"'Source Sans Pro', sans-serif\" color=\"#000000\" style=\"font-size: 17px; line-height: 21px;\">
                         <span style=\"font-family: 'Source Sans Pro', Arial, Tahoma, Geneva, sans-serif; color: #000000; font-size: 17px; line-height: 21px;\">€ -" . $reservering['discount'] . "</span>
                      </font>
                      <div style=\"height: 10px; line-height: 10px; font-size: 10px;\">&nbsp;</div>
                   </td>
                </tr>
             </table>";
                $html_lijnen .= $lijn_html;
            }
            $sub +=  $c['service_charge_value'];
            $taxRate = $c['vat_charge_value'];
            $tax = $sub * $taxRate / 100;

            $totaal = $sub + $tax;

            /** Loads thanku  mail template */
            $html = file_get_contents("./files/emails/invoice.html");
            $myReplacements  = array(
                '%%invoice_prefix%%' => $c['invoice_prefix'],
                '%%voornaam%%' => $klant['voornaam'],
                '%%fac_nummer%%' => $factuur['id'],
                '%%fac_date%%' => $factuur_date,
                '%%fac_items%%' => $html_lijnen,
                '%%totaal%%' => $totaal,
                '%%sub_totaal%%' => $sub,
                '%%tax%%' => $tax,
                '%%tax_val%%' => $taxRate,
                '%%service%%' => "Service kosten",
                '%%s_kost%%' => $c['service_charge_value'],

            );
            /** Replace %%%%  tags by values */
            foreach ($myReplacements as $needle => $replacement)
                $html = str_replace($needle, $replacement, $html);

            //print_r($to);
            $from = array('name' => 'Camping la rustique', 'email' => 'info@pdik.nl');
            if ($this->model_Mailer->mail($to, $subject, $html, $from, $plaintext)) {
                $this->session->set_flashdata('success', 'Mail is verstuurd');
                redirect('admin/facturen/view');
            }
            //echo $html;
            try {
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$this->model_Mailer->ErrorInfo}";
            }
        }
    }
}
