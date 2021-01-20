<?php

class data_barang extends Secure_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->authForAdmin($this->session->userdata());
	}
	public function index ()
	{	
		$data['barang'] = $this->rental_model->get_data('barang')->result();
		$data['type'] = $this->rental_model->get_data('type')->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/data_motor', $data);
		$this->load->view('templates_admin/footer');
	}

	public function tambah_barang ()
	{
		$data['type'] = $this->rental_model->get_data('type')->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/form_tambah_mobil', $data);
		$this->load->view('templates_admin/footer');
	}

	public function tambah_barang_aksi ()
	{
		$this->_rules();

		if($this->form_validation->run() == FALSE) {
			$this->tambah_barang();
		} else {
			$kode_type        = $this->input->post('kode_type');
			$merk             = $this->input->post('merk');
			$diskon          = $this->input->post('diskon');
			$warna            = $this->input->post('warna');
			$stok            = $this->input->post('stok');
			$status           = $this->input->post('status');
			$harga            = $this->input->post('harga');
			$gambar           = $_FILES['gambar'] ['name'];
			if ($gambar='') {} else {
				$config['upload_path']       = './assets/upload';
				$config['allowed_types']     = 'jpg|jpeg|png|tiff';

				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('gambar')) {
					echo "Gambar Barang Gagal Diupload!";
				} else {
					$gambar = $this->upload->data('file_name');
				}
			}

			$data = array(
				'kode_type'          => $kode_type,
				'merk'               => $merk,
				'diskon'            => $diskon,
				'stok'              => $stok,
				'warna'              => $warna,
				'status'             => $status,
				'gambar'             => $gambar,
				'harga'             => $harga,
			);

			$this->rental_model->insert_data($data, 'barang');
			$this->session->set_flashdata('pesan', '<div class= "alert alert-success alert-dismissible fade show" role="alert">
				Data Berhasil Ditambahkan!.
				<button type="button" close="close" data-dismiss="alert" aria-label="close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
			redirect ('admin/data_barang');
		}
	}

	public function update_barang ($id) {
		$data ['barang'] = $this->db->query("SELECT * 
												FROM barang brg 
											LEFT JOIN type 
												ON brg.kode_type = type.kode_type
											WHERE brg.id_barang = '$id'")->result ();
		$data ['type'] = $this->rental_model->get_data('type')->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/form_update_mobil', $data);
		$this->load->view('templates_admin/footer');
	}

	public function barang_update()
	{
		$this->_rules();

		If ($this->form_validation->run()==false)
		{
			$this->update_barang($this->input->post('id_barang'));
		}else{
			$id        = $this->input->post('id_barang');
			$kode_type        = $this->input->post('kode_type');
			$merk             = $this->input->post('merk');
			$diskon          = $this->input->post('diskon');
			$warna            = $this->input->post('warna');
			$stok            = $this->input->post('stok');
			$status           = $this->input->post('status');
			$harga            = $this->input->post('harga');
			$gambar           = $_FILES['gambar'] ['name'];
			if ($gambar) {
				$config['upload_path']       = './assets/upload';
				$config['allowed_types']     = 'jpg|jpeg|png|tiff';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('gambar')) {
					$gambar=$this->upload->data('file_name');
					$this->db->set('gambar' , $gambar);
				}else{
					echo $this->upload->display_error();
				}
			}
			$data = array(
				'kode_type'          => $kode_type,
				'merk'               => $merk,
				'diskon'            => $diskon,
				'stok'              => $stok,
				'warna'              => $warna,
				'status'             => $status,
				'harga'             => $harga,
			);
			$where = array (
				'id_barang' => $id
			);

			$this->rental_model->update_data('barang', $data, $where);
			$this->session->set_flashdata('pesan', '<div class= "alert alert-success alert-dismissible fade show" role="alert">
				Data Motor Berhasil Diupdate!.
				<button type="button" close="close" data-dismiss="alert" aria-label="close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
			redirect ('admin/data_barang');
		}
	}
	public function _rules()
	{
		$this->form_validation->set_rules('kode_type', 'Kode Type', 'required');
		$this->form_validation->set_rules('merk', 'Merk', 'required');
		$this->form_validation->set_rules('diskon', 'Diskon', 'required');
		$this->form_validation->set_rules('stok', 'Stok', 'required');
		$this->form_validation->set_rules('warna', 'Warna', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_rules('harga', 'Harga', 'required');
	}

	public function detail_barang($id)
	{
		$data['detail'] = $this->rental_model->ambil_id_barang($id);
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/detail_motor', $data);
		$this->load->view('templates_admin/footer');
	}

	public function delete_barang ($id)
	{
		$where = array ('id_barang' => $id);
		$this->rental_model->delete_data($where, 'barang');
		$this->session->set_flashdata('pesan', '<div class= "alert alert-danger alert-dismissible fade show" role="alert">
				Data Barang Berhasil Dihapus!.
				
					<span aria-hidden="true">&times;</span>
				</div>');
			redirect ('admin/data_barang');
	}
}

?>