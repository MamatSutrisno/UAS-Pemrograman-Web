<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminProsesModel;

class Admin extends BaseController{

	protected $adminProsesModel;
	public function __construct(){
		$this->adminProsesModel = new AdminProsesModel();
	}

	public function index(){
		$data['title']      = "Admin";
		$data['validation'] = $this->validation;
		$data['admin']       = $this->adminProsesModel->select("*")->orderBy("id", "DESC")->get()->getResultArray();
		echo view('main/header', $data);
		echo view('admin/admin');
		echo view('main/footer');
	}
}
