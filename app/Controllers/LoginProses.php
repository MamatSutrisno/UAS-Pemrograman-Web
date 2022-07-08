<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LoginProsesModel;

class LoginProses extends BaseController{
	
	protected $loginProsesModel;
	public function __construct(){
		$this->loginProsesModel = new LoginProsesModel();
	}

	public function login(){
		$validation = [
			'username'		=> [
				'label'	=> 'Username',
				'rules'	=> 'required|is_not_unique[admin.username]',
				'errors'=> [
					'required'			=> 'Wajib Diisi',
					'is_not_unique'	=> 'Username Tidak Ada'
				]
			],
			'password'	=> [
				'label'	=> 'Password',
				'rules'	=> 'required',
				'errors'=> [
					'required'	=> 'Wajib Diisi',
				]
			]
		];

		if(!$this->validate($validation)){
			return redirect()->back()->withInput();
		}else{

			$username = $this->request->getPost('username');
			$password = $this->request->getPost('password');

			$kondisi = ['username'=>$username, 'password'=>$password];
			$query = $this->loginProsesModel->select('*')->where($kondisi)->get();
			if($query->getNumRows()<1){

				session()->setFlashData('passwordSalah', 'Password Salah');
				return redirect()->back()->withInput();
			}else{

				$detailUser = $query->getRowArray();
				session()->set([
					'id'		=> $detailUser['id'],
					'nama'	=> $detailUser['nama'],
					'username' => $detailUser['username'],
					'masuk'	=> True
				]);

				return redirect()->to('/');
			}
		}
	}

	public function logout(){
		session()->destroy();
		return redirect()->to('/login');
	}
}
