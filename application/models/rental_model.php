<?php

class rental_model extends CI_model {
	public function get_data($table) {
		return $this->db->get($table);
	}

	public function insert_data ($data,$table) {
		$this->db->insert($table,$data);
	}

	public function update_data ($table, $data, $where) {
		$this->db->update($table, $data, $where);
	}

	public function delete_data ($where,$table) {
		$this->db->where($where);
		$this->db->delete($table);
	}

	public function ambil_id_barang($id)
	{
		$this->db->select('*');
		$this->db->from('barang');
		$this->db->join('type', 'barang.kode_type = type.kode_type', 'left');
		$result = $this->db->where('barang.id_barang', $id)->get();
		if ($result->num_rows() > 0) {
			return $result->result();
		}else {
			return false;
		}
	}

	public function cek_login()
	{
		$username = set_value('username');
		$password = set_value('password');

		$result = $this->db
					   ->where ('username', $username)
					   ->where ('password', md5 ($password))
					   ->limit (1)
					   ->get('customer');
		if ($result->num_rows() > 0) {
			return $result->row();
		}else {
			return false;
		}
	}

	public function ganti_password_aksi ($where, $data, $table)
	{
		$this->db->where($where);
		$this->db->update($table, $data);
	}
	
	public function getDataById($id)
	{
		$result = $this->db->where('id_customer',$id)->get('customer')->result_array();
		return $result;
	}

	public function addSupir($data)
	{
		return $this->db->insert('data_driver',$data);
	}

	public function getSupir()
	{
		return $this->db->get('data_driver')->result_array();
	}

	public function updateDriverStatus($id)
	{
		$this->db->where('id_supir',$id);
		return $this->db->update('data_driver',["status_supir"=>'0']);
	}

	public function deActiveDriverStatus($id)
	{
		$this->db->where('id_supir',$id);
		return $this->db->update('data_driver',["status_supir"=>'1']);
	}

	public function beli_motor($data)
	{
		return $this->db->insert('transaksi',$data);
	}

	public function updateStatusMobil($data)
	{
		
		$this->db->where('id_mobil',$data['id_mobil']);
		return $this->db->update('mobil',["status"=>'1']);
	}

	public function hapusSupir($id)
	{
		$this->db->where('id_supir',$id);
		return $this->db->delete('data_driver');
	}

	public function getSupirActive()
	{
		$this->db->where('status_supir','0');
		return $this->db->get('data_driver')->result_array();
	}

	public function getAllOrder()
	{
		$data = $this->db->query("SELECT * 
		FROM transaksi
			INNER JOIN customer 
				ON transaksi.id_customer = customer.id_customer
			INNER JOIN barang 	
				ON transaksi.id_barang = barang.id_barang
			INNER JOIN type
				ON type.kode_type = barang.kode_type")->result();
		return $data;
	}

	public function getOrderById($id)
	{
		$data = $this->db->query("SELECT * 
		FROM transaksi
			INNER JOIN customer 
				ON transaksi.id_customer = customer.id_customer
			INNER JOIN barang 	
				ON transaksi.id_barang = barang.id_barang
			INNER JOIN type
				ON type.kode_type = barang.kode_type
			WHERE transaksi.id_trans = '".$id."'")->result();
		return $data;
	}

	public function updateCarInRent($id)
	{
		$this->db->where('id_sewa',$id);
		return $this->db->update('data_sewa_mobil',["flag_sewa"=>"1"]);
	}

	public function updateCarIsBack($id)
	{
		$this->db->where('id_sewa',$id);
		return $this->db->update('data_sewa_mobil',["flag_sewa"=>"2"]);
	}
	

	public function updateStatusMobil2($id)
	{
		$this->db->where('id_barang',$id);
		return $this->db->update('barang',["status"=>'0']);
	}

	public function updateStatusMobil3($data)
	{
		$this->db->where('id_barang',$data['id_barang']);
		return $this->db->update('barang',["status"=>'3']);
	}

	public function cancelSewa($id)
	{
		$this->db->where('id_sewa',$id);
		return $this->db->delete('data_sewa_mobil');
	}

	public function getDataForCalculate($id)
	{
		$query = "SELECT * FROM data_sewa_mobil as dsm INNER JOIN mobil as car on dsm.id_mobil=car.id_mobil where
		dsm.id_sewa='".$id."'";
		return $this->db->query($query)->result_array();
	}

	public function getPesanan($id)
	{
		$this->db->select('*');
		$this->db->from('barang');
		$this->db->join('transaksi', 'barang.id_barang=transaksi.id_barang', 'inner');
		$this->db->where('transaksi.id_customer',$id);
		return $this->db->get()->result_array();
	}

	public function updateTransaksi($data)
	{
		$this->db->where('id_trans',$data['id_trans']);
		return $this->db->update('transaksi',$data);
	}

	public function konfirmasiPembayaran($id)
	{
		$this->db->where('id_trans',$id);
		return $this->db->update('transaksi',["satatus_transaksi"=>"2"]);
	}
}

?>