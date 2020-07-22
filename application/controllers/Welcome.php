<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('S3_upload');									// Oluşturduğumuz S3 Upload Kütüphanesinin Eklenmesi
	}
	public function index()
	{
		$this->data["resimler"] = $this->s3_upload->getBucket();			//Oluşturduğumuz S3 Upload Kütüphanesi Yardımıyla Buckettan Dosyaların Alınması 
		$this->load->view('Homepage',$this->data);							// View'a Nesnenin Gönderilmesi
	}
}
