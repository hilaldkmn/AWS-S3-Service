<?php
class S3_upload {

	function __construct()
	{
		$this->CI =& get_instance();			// Codeigniter Kütüphane Dosyasında Codeigniter özelliklerini çağırmak için gerekli instance'ın tanımlanması
		$this->CI->load->library('s3');			// Amazon S3 PHP SDK kütüphanesinin Eklenmesi

		$this->CI->config->load('s3', TRUE);	// Config Dosyalarında Oluşturulan S3 Ayarlarının Eklenmesi
		$s3_config = $this->CI->config->item('s3');			// Config Dosyasının değişkene alınması
		$this->bucket_name = $s3_config['bucket_name'];		// Config Dosyasında tanımlı Bucket'ın Alınması
		$this->folder_name = $s3_config['folder_name'];		// Config Dosyasında tanımlı Klasörün Alınması
		$this->s3_url = $s3_config['s3_url'];				// Config Dosyasında tanımlı S3 Sunucu URL Sinin alınması
	}
	function getBucket(){											// Buckettan Dosyaların Alınma Metodu
		$saved = $this->CI->s3->getBucket($this->bucket_name);		// Bucketta Yüklenmiş Dosyaların Alınması
		$dosyalar = array();
		foreach($saved as $k => $v){
			$dosyalar[] = array("url"=>$this->s3_url.$this->bucket_name.'/'.$v["name"]);		// Bunların Dizi yardımıyla istenilen Yapıya çevirilmesi
		}
		return $dosyalar;											// Dosyaların geri Controller'a Döndürülmesi
	}
	function upload_file($file_path)								// Yükleme Metodu
	{
		$file = pathinfo($file_path);								// Yüklenecek Dosyanın bilgilerinin alınması
		$s3_file = $file['filename'].'-'.rand(1000,1).'.'.$file['extension'];	// Bilgelerin Rastgele Sayı Üreten Fonksiyon Yardımıyla çakışmasının Önüne Geçilmesi
		$mime_type = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $file_path);	// Yüklenen Dosyanın türününü belirlenmesi

		$saved = $this->CI->s3->putObjectFile(									// Amazon S3 PHP SDK yardımıyla Dosyanın upload Edilmesi
			$file_path,															// Yüklenecek Dosya yolu
			$this->bucket_name,													// Yüklenecek Bucket
			$this->folder_name.$s3_file,										// Yüklenecek Konum
			S3::ACL_PUBLIC_READ,												// Dosyanın İzin Durumu
			array(),															// Varsa Meta Etiketinin Eklenmesi
			$mime_type															// Dosyanın Tipi
		);
		if ($saved) {															// Dosya Yüklenmişse konumunun Döndürülmesi
			return $this->s3_url.$this->bucket_name.'/'.$this->folder_name.$s3_file;
		}
	}
}