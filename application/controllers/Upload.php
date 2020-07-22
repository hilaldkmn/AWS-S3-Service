<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS'); 
 
if(array_key_exists('HTTP_ACCESS_CONTROL_REQUEST_HEADERS', $_SERVER)) {
    header('Access-Control-Allow-Headers: '
           . $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']);
} else {
    header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, cache-control');
}
if($_SERVER['REQUEST_METHOD']=='OPTIONS') die();
/*
    Dropzone JS Çalıştırılması İçin Link Kontrolleri
*/
class Upload extends CI_Controller {
    public function index() {
        if (!empty($_FILES['file']['name'])) {                                  // Yüklenen Dosyanın Ad Kontrolü
            $config['upload_path'] = 'uploads/';                                // Sunucu Upload Klasörü
            $config['allowed_types'] = 'jpg|jpeg|png|gif';                      // İzin Verilen Dosya Türleri
            $config['max_size'] = '1024';                                       // Maksimum Dosya Boyutu Megabayt
            $config['file_name'] = $_FILES['file']['name'];                     // Yüklenen Dosya Adı

            $this->load->library('upload', $config);                            // Codeigniter Upload Sınıfı
            $this->load->library('S3_upload');                                  // Oluşturduğumuz S3 Yükleme Sınıfı
            
            if ($this->upload->do_upload('file')) {                             // Codeigniter Upload sınıfı yardımıyla Dosyanın Yüklenmesi
                $uploadData = $this->upload->data();
		        $this->s3_upload->upload_file(FCPATH."uploads/".$_FILES['file']['name']);       // Sunucuya Alınan Dosyanın Amazon S3 Depolama Servisine Aktarılması
            }
        }
    }
}
