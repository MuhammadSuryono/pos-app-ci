<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Setting_m extends CI_Model {

	function get_key_val() {
		$out = array();
		$this->db->select('id,setting_key,setting_val');
		$this->db->from('setting');
		$query = $this->db->get();
		if($query->num_rows()>0){
				$result = $query->result();
				foreach($result as $value){
					$out[$value->setting_key] = $value->setting_val;
				}
				return $out;
		} else {
			return FALSE;
		}
	}
	
	function simpan() {
		$opsi_val_arr = $this->get_key_val();
		foreach ($opsi_val_arr as $key => $val) {
			if($this->input->post($key) || $this->input->post($key) == 0 ) {
				$data = array ('setting_val'=> $this->input->post($key));
				$this->db->where('setting_key',$key);
				if($this->db->update('setting',$data)) {
					// ok 
				} else {
					return FALSE;
				}
			}
		}
		return TRUE;
	}
	
}