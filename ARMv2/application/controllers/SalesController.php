<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SalesController extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('user_agent');
		$this->load->library('curl');
		$this->load->library('url_encode');

		$this->load->helper('language');
		$this->load->helper('url');
		$this->load->helper(array('form', 'url'));
		
		$this->data['pray_lang']=$this->session->userdata('language');
		if (empty($this->data['pray_lang'])){
			$this->session->set_userdata('language', 'english');
		}
		if(!empty($this->session->userdata("UIY"))){
			$this->data["menu"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sys_menu")."&fn=".base64_encode("getMenu")."&id=".$this->session->userdata("UIY"));
		}
		else{
			redirect('./');
		}
		
    }

    public function sls_stage(){
		$link = $_SERVER["REQUEST_URI"];
		$link = explode("/",$link);
    	$link = $link[2];

		$this->data["userAccs"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sys_menu")."&fn=".base64_encode("getAkses")."&id=".$this->session->userdata("UIY")."&mi=".base64_encode($link));
    	$this->data["slsStgList"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sls_sales_stage")."&fn=".base64_encode("getSalesStageList")."&id=".$this->session->userdata("UIY"));

    	$this->load->view('common/header', $this->data);
		$this->load->view('common/navbar', $this->data);
		$this->load->view('common/sidebar', $this->data);
		$this->load->view('sales/sales_stage', $this->data);
		$this->load->view('common/footer', $this->data);
    }

    public function sls_stage_act(){
		$link = $_SERVER["REQUEST_URI"];
    	$link = explode("/",$link);
    	$mod = $this->url_encode->base64_url_decode($link[4]);
    	$ids = (count($link) > 5) ? $this->url_encode->base64_url_decode($link[5]) : "";

		$this->data["mod"] = $mod;
		$this->data["dataId"] = $ids;
    	$this->data["slsStgDtil"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sls_sales_stage")."&fn=".base64_encode("getSalesStageDetail")."&id=".$this->session->userdata("UIY")."&mi=".base64_encode($ids));

    	$this->load->view('common/header', $this->data);
		$this->load->view('common/navbar', $this->data);
		$this->load->view('common/sidebar', $this->data);
		$this->load->view('sales/sales_stage_act', $this->data);
		$this->load->view('common/footer', $this->data);
    }

    public function sls_oppo_type(){
		$link = $_SERVER["REQUEST_URI"];
		$link = explode("/",$link);
    	$link = $link[2];

		$this->data["userAccs"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sys_menu")."&fn=".base64_encode("getAkses")."&id=".$this->session->userdata("UIY")."&mi=".base64_encode($link));
    	$this->data["oppoTypeList"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sls_oppo_type")."&fn=".base64_encode("getOppoTypeList")."&id=".$this->session->userdata("UIY"));

		$this->load->view('common/header', $this->data);
		$this->load->view('common/navbar', $this->data);
		$this->load->view('common/sidebar', $this->data);
		$this->load->view('sales/oppo_type', $this->data);
		$this->load->view('common/footer', $this->data);
    }

    public function sls_oppo_type_act($mod,$id=null){
    	$mod = $this->url_encode->base64_url_decode($mod);
    	$dataId = (empty($id)) ? '' : $this->url_encode->base64_url_decode($id);

		$this->data["mod"] = $mod;
		$this->data["dataId"] = $dataId;
    	$this->data["oppoTypDtil"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sls_oppo_type")."&fn=".base64_encode("getOppoTypeDetail")."&id=".$this->session->userdata("UIY")."&mi=".base64_encode($dataId));

		$this->load->view('common/header', $this->data);
		$this->load->view('common/navbar', $this->data);
		$this->load->view('common/sidebar', $this->data);
		$this->load->view('sales/oppo_type_act', $this->data);
		$this->load->view('common/footer', $this->data);

    }
}

?>