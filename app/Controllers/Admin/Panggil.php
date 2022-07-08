<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\PelayananProsesModel;
use App\Models\LoketProsesModel;
use App\Models\AntrianProsesModel;

class Panggil extends BaseController{

	protected $pelayananProsesModel, $loketProsesModel, $antrianProsesModel;
	public function __construct(){
		$this->pelayananProsesModel = new PelayananProsesModel();
		$this->loketProsesModel = new LoketProsesModel();
		$this->antrianProsesModel = new AntrianProsesModel();
	}

	public function panggil($id){

		$detailLoket = $this->loketProsesModel->select("loket.*, a.nama as nama_pelayanan, a.kode")->join('pelayanan a', 'loket.pelayanan_id=a.id')->where('loket.id', $id)->get();

		if($detailLoket->getNumRows()<1){
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}else{
			$data['detailLoket']	= $detailLoket->getRowArray();

			$kondisi = [
				'status <='  => '1',
				'pelayanan_id' => $data['detailLoket']['pelayanan_id']
			];
			$loket = [$id, null];
			$tanggalSekarang	= date("Y-m-d");
			$data['antrian']	= $this->antrianProsesModel->select("antrian.*, a.kode as kode")
			->join('pelayanan a', 'antrian.pelayanan_id=a.id')->groupStart()->where('loket_id', $id)->orWhere('loket_id', null)->groupEnd()
			->where($kondisi)->like('antrian.tanggal', $tanggalSekarang)->limit(5)->get();

			$data['title']				= "Pelayanan ".$data['detailLoket']['nama'];
			echo view('main/header', $data);
			echo view('admin/pelayanan-panggil');
			echo view('main/footer');
		}
	}
}
