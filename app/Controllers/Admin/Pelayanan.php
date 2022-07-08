<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PelayananProsesModel;

class Pelayanan extends BaseController{

	protected $pelayananProsesModel;
	public function __construct(){
		$this->pelayananProsesModel = new PelayananProsesModel();
	}

	public function index(){
		$data['title'] = "Pelayanan";
		$data['pelayanan']	= $this->pelayananProsesModel->select("*")->orderBy('id', 'DESC')->get()->getResultArray();
		$data['validation']	= $this->validation;
		echo view('main/header', $data);
		echo view('admin/pelayanan');
		echo view('main/footer');
	}
}
