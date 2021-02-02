<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//header('Content-type: charset=gb2312');

class Welcome extends CI_Controller {

	private $campusValue = '';
	private $buildingsValue = '';
	private $classroomValue = '';
	private $ComAddress = 'COM9';

	public function __construct(){
		parent::__construct();
		//$this->load->database();
		$this->load->library('PhpSerial');
		$this->load->helper('url_helper');
		$this->load->helper('url');   //url函数库文件
	}

	public function index(){
		$this->load->view('index');
	}

	public function SendSerial(){
		set_time_limit(0);
		$DEBUG = 0;

		exec('mode '.$this->ComAddress.': baud=9600 data=8 stop=1 parity=0');

		$fd = dio_open($this->ComAddress . ':', O_RDWR);//opens the file for both reading and writing.

		if(!$fd) die("打开串口'.$this->ComAddress.'失败");

		$ff = dio_stat($fd);
		print_r($ff);

		echo "Com Communication is start!\n";

		$t = 0;
		$str = 12345;
		do{
			$shuju=dio_read($fd);//读取串口并将读取到的数据赋值给变量‘$shuju’;
		}
		while($shuju == null);//当数据为空时;
		/*while(($t++)<1777000){
			$data = dio_read($fd, 10);
			echo "$data";
			if ($data) {
				//echo "$data";
				break;
			}
			/*if ($data = dio_read($fd, 256)){
				echo $data;
				break;
			}*/
		//}
		//$result = dio_write($fd, 'P12.25E');
		//var_dump($result);

		/*while (1){
			if ($data = dio_read($fd, 256)){
				var_dump($data);
				break;
			}
		}*/


		dio_close($fd);

	}


	public function gb2unicode($str) {
		return iconv("gb2312", "UCS-2", $str);
	}
	public function hex2str($hexstring) {
		$str = '';
		for($i=0; $i<strlen($hexstring); $i++){
			$str .= sprintf("%02X",ord(substr($hexstring,$i,1)));
		}
		return $str;
	}

	public function InvertNumbers($msisdn) {
		$len = strlen($msisdn);
		if ( 0 != fmod($len, 2) ) {
			$msisdn .= "F";
			$len = $len + 1;
		}

		for ($i=0; $i<$len; $i+=2) {
			$t = $msisdn[$i];
			$msisdn[$i] = $msisdn[$i+1];
			$msisdn[$i+1] = $t;
		}
		return $msisdn;
	}

}
