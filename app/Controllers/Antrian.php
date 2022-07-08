<?php

namespace App\Controllers;

use App\Models\PelayananProsesModel;
use App\Models\AntrianProsesModel;
use App\Models\LoketProsesModel;

class Antrian extends BaseController{

	protected $pelayananProsesModel, $antrianProsesModel, $loketProsesModel;
	public function __construct(){
		$this->pelayananProsesModel = new PelayananProsesModel();
		$this->antrianProsesModel = new AntrianProsesModel();
		$this->loketProsesModel = new LoketProsesModel();
	}

	public function index(){
		$data['title'] = "Sistem Antrian";
		$data['pelayanan']	= $this->pelayananProsesModel->select("*")->orderBy('id', 'DESC')->get()->getResultArray();
		echo view('main/header', $data);
		echo view('antrian/ambil');
		echo view('main/footer');
	}

	public function antrian(){

		$data['panggilTerakhir'] = $this->antrianProsesModel->select('antrian.*, a.kode, b.nama as nama_loket')
		->join('pelayanan a', 'antrian.pelayanan_id=a.id')->join('loket b', 'antrian.loket_id=b.id')
		->where('antrian.status', 1)->orderBy('antrian.waktu_panggil', 'DESC')->limit(1)->get();

		$data['detailLoket']	= $this->loketProsesModel->select("loket.id, loket.nama, a.kode")
		->join('pelayanan a', 'loket.pelayanan_id=a.id')->orderBy('id', 'ASC')->get()->getResultArray();

		$data['title'] = "Detail Antrian";
		echo view('main/header', $data);
		echo view('antrian/detail');
		echo view('main/footer');
	}
}
