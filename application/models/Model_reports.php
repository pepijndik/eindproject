<?php

class Model_reports extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*getting the total months*/
	private function months()
	{
		return array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
	}

	/* getting the year of the orders */
	public function getInvoiceYear()
	{
		$sql = "SELECT * FROM factuur WHERE paid_status = ?";
		$query = $this->db->query($sql, array(1));
		$result = $query->result_array();

		$return_data = array();
		foreach ($result as $k => $v) {

			$date = date_format(date_create($v['datum']), 'Y');
			$return_data[] = $date;
		}

		$return_data = array_unique($return_data);

		return $return_data;
	}

	// getting the order reports based on the year and moths
	public function getInvoiceData($year)
	{
		if ($year) {
			$months = $this->months();

			$sql = "SELECT * FROM factuur WHERE paid_status = ?";
			$query = $this->db->query($sql, array(1));
			$result = $query->result_array();

			$final_data = array();
			foreach ($months as $month_k => $month_y) {
				$get_mon_year = $year . '-' . $month_y;

				$final_data[$get_mon_year][] = '';
				foreach ($result as $k => $v) {
					$month_year = date_format(date_create($v['datum']), 'Y-m');
					//echo $get_mon_year . ' ' . $month_year . "<br>";
					if ($get_mon_year == $month_year) {

						$id = $v['reservering_id'];
						$sql = "SELECT * FROM reservering_opties WHERE reservering_id='$id'";
						$query =  $this->db->query($sql);
						$factuur_lijnen = $query->result_array();
						$totaal = 0;
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
							$totaal += $item_totaal;
						}
						$v['gross_amount'] = $totaal;
						$final_data[$get_mon_year][] = $v;
					}
				}
			}

			//	print_r($final_data);
			return $final_data;
		}
	}
}
