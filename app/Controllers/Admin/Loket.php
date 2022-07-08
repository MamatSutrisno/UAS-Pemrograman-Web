<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LoketProsesModel;
use App\Models\PelayananProsesModel;

class Loket extends BaseController{

	protected $loketProsesModel, $pelayananProsesModel;
	public function __construct(){
		$this->loketProsesModel = new LoketProsesModel();
		$this->pelayananProsesModel = new PelayananProsesModel();
	}

	public function index(){
		$data['title']      = "Loket";
		$data['validation'] = $this->validation;
		$data['loket']      = $this->loketProsesModel->select("loket.*, pelayanan.nama as nama_pelayanan")->JOIN('pelayanan', 'loket.pelayanan_id=pelayanan.id')->orderBy("id", "DESC")->get()->getResultArray();
		$data['pelayanan']	= $this->pelayananProsesModel->select('*')->orderBy('id', 'DESC')->get()->getResultArray();

		echo view('main/header', $data);
		echo view('admin/loket');
		echo view('main/footer');
	}
}
