<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PelayananProsesModel;

class PelayananProses extends BaseController{

	protected $pelayananProsesModel;
	public function __construct(){
		$this->pelayananProsesModel = new PelayananProsesModel();
	}
	
	public function tambah(){
		$validation = [
			'nama'	=> [
				'label'	=> 'Nama',
				'rules'	=> 'required|min_length[5]',
				'errors'=> [
					'required'	=> 'Wajib Diisi',
					'min_length'=> 'Minimal 5 Karakter',
				]
			],
			'keterangan'	=> [
				'label'	=> 'Keterangan',
				'rules'	=> 'required|min_length[10]',
				'errors'=> [
					'required'	=> 'Wajib Diisi',
					'min_length'=> 'Minimal 10 Karakter',
				]
			],
			'kode'	=> [
				'label'	=> 'Kode',
				'rules'	=> 'required|min_length[2]|is_unique[pelayanan.kode]',
				'errors'=> [
					'required'	=> 'Wajib Diisi',
					'min_length'=> 'Minimal 2 Karakter',
					'is_unique'	=> 'Kode Sudah Digunakan',
				]
			]
		];

		if(!$this->validate($validation)){
			session()->setFlashData('errorForm', '1');
			return redirect()->back()->withInput();
		}else{
			$this->pelayananProsesModel->insert([
				'nama'			=> $this->request->getPost("nama"),
				'keterangan'=> $this->request->getPost("keterangan"),
				'kode'			=> $this->request->getPost("kode"),
			]);

			return redirect('admin/pelayanan');
		}
	}

	public function hapus(){
		$validation = [
			'id'	=> [
				'label'	=> 'id',
				'rules'	=> 'required',
				'errors'=> [
					'required'	=> 'Wajib Diisi',
				]
			]
		];

		if(!$this->validate($validation)){
			return redirect()->back()->withInput();
		}else{
			$id = $this->request->getPost('id');
			$data = $this->pelayananProsesModel->where('id', $id)->delete();

			if($data){
				echo json_encode(1);
			}else{
				echo json_encode(0);
			}
		}
	}

	public function update(){
		$validation = [
			'idEdit'		=> [
				'label'	=> 'ID',
				'rules'	=> 'required',
				'errors'=> [
					'required' => 'Wajib Diisi',
					'numeric'	=> 'Harus Angka', 
				]
			],
			'namaEdit'	=> [
				'label'	=> 'Nama',
				'rules'	=> 'required|min_length[5]',
				'errors'=> [
					'required'	=> 'Wajib Diisi',
					'min_length'=> 'Minimal 5 Karakter',
				]
			],
			'keteranganEdit'	=> [
				'label'	=> 'Keterangan',
				'rules'	=> 'required|min_length[10]',
				'errors'=> [
					'required'	=> 'Wajib Diisi',
					'min_length'=> 'Minimal 10 Karakter',
				]
			],
		];

		if(!$this->validate($validation)){
			session()->setFlashData('errorFormEdit', '1');
			return redirect()->back()->withInput();
		}else{
			$id = $this->request->getPost('idEdit');

			$dataUpdate = [
				'nama'		=> $this->request->getPost("namaEdit"),
				'keterangan'=> $this->request->getPost("keteranganEdit"),
			];

			$query = $this->pelayananProsesModel->update($id, $dataUpdate);

			if($query){
				echo "<script>alert('Update Berhasil');window.location.href='/admin/pelayanan'</script>";
			}else{
				echo "<script>alert('Update Gagal');window.location.href='/admin/pelayanan'</script>";
			}
		}
	}
}
