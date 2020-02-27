<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MasterController extends CI_Controller {

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

    public function profile(){
		$link = $_SERVER["REQUEST_URI"];
		$link = explode("/",$link);
    	$link = $link[2];

		$this->data["userAccs"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sys_menu")."&fn=".base64_encode("getAkses")."&id=".$this->session->userdata("UIY")."&mi=".base64_encode($link));
    	$this->data["userList"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sys_user")."&fn=".base64_encode("getUserList")."&id=".$this->session->userdata("UIY"));

		$this->load->view('common/header', $this->data);
		$this->load->view('common/navbar', $this->data);
		$this->load->view('common/sidebar', $this->data);
		$this->load->view('master/profile', $this->data);
		$this->load->view('common/footer', $this->data);
    }

    public function profile_act(){
		$link = $_SERVER["REQUEST_URI"];
    	$link = explode("/",$link);
    	$mod = $this->url_encode->base64_url_decode($link[4]);
    	$ids = $link[5];

    	$this->data["mod"] = $mod;
    	$this->data["dataId"] = $this->url_encode->base64_url_decode($ids);
		$this->data["userAccs"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sys_menu")."&fn=".base64_encode("getAkses")."&id=".$this->session->userdata("UIY")."&mi=".base64_encode($link[2]));
    	$this->data["userDtil"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sys_user")."&fn=".base64_encode("getUserDetail")."&id=".$this->session->userdata("UIY")."&ids=".$this->url_encode->base64_url_decode($ids));
    	$this->data["userAccsList"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sys_menu")."&fn=".base64_encode("getUserAksesList")."&id=".$this->session->userdata("UIY")."&mi=".$this->url_encode->base64_url_decode($ids));
    	$this->data["deptDropDown"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sys_dept")."&fn=".base64_encode("getDeptDropDown")."&id=".$this->session->userdata("UIY"));
    	$this->data["jabtDropDown"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sys_jabt")."&fn=".base64_encode("getJabtDropDown")."&id=".$this->session->userdata("UIY"));

		$this->load->view('common/header', $this->data);
		$this->load->view('common/navbar', $this->data);
		$this->load->view('common/sidebar', $this->data);
		$this->load->view('master/profile_act', $this->data);
		$this->load->view('common/footer', $this->data);    	
    }

	public function menu(){
		$link = $_SERVER["REQUEST_URI"];
		$link = explode("/",$link);
    	$link = $link[2];

		$this->data["userAccs"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sys_menu")."&fn=".base64_encode("getAkses")."&id=".$this->session->userdata("UIY")."&mi=".base64_encode($link));
    	$this->data["menuList"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sys_menu")."&fn=".base64_encode("getMenuList")."&id=".$this->session->userdata("UIY"));
    	
		$this->load->view('common/header', $this->data);
		$this->load->view('common/navbar', $this->data);
		$this->load->view('common/sidebar', $this->data);
		$this->load->view('master/menu', $this->data);
		$this->load->view('common/footer', $this->data);
	}

	public function menu_act(){
		$link = $_SERVER["REQUEST_URI"];
    	$link = explode("/",$link);
    	$mod = $this->url_encode->base64_url_decode($link[4]);
    	$ids = $this->url_encode->base64_url_decode($link[5]);

    	$this->data["mod"] = $mod;
		$this->data["dataId"] = $ids;
    	$this->data["menuDtil"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sys_menu")."&fn=".base64_encode("getMenuDetail")."&id=".$this->session->userdata("UIY")."&mi=".base64_encode($ids));

    	$this->load->view('common/header', $this->data);
		$this->load->view('common/navbar', $this->data);
		$this->load->view('common/sidebar', $this->data);
		$this->load->view('master/menu_act', $this->data);
		$this->load->view('common/footer', $this->data);
	}

	public function mst_dept(){
		$link = $_SERVER["REQUEST_URI"];
		$link = explode("/",$link);
    	$link = $link[2];

		$this->data["userAccs"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sys_menu")."&fn=".base64_encode("getAkses")."&id=".$this->session->userdata("UIY")."&mi=".base64_encode($link));
    	$this->data["deptList"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sys_dept")."&fn=".base64_encode("getDeptList")."&id=".$this->session->userdata("UIY"));

    	$this->load->view('common/header', $this->data);
		$this->load->view('common/navbar', $this->data);
		$this->load->view('common/sidebar', $this->data);
		$this->load->view('master/dept', $this->data);
		$this->load->view('common/footer', $this->data);
	}

	public function dept_act(){
		$link = $_SERVER["REQUEST_URI"];
    	$link = explode("/",$link);
    	$mod = $this->url_encode->base64_url_decode($link[4]);
    	$ids = (count($link) > 5) ? $this->url_encode->base64_url_decode($link[5]) : "";

		$this->data["mod"] = $mod;
		$this->data["dataId"] = $ids;
    	$this->data["deptDtil"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sys_dept")."&fn=".base64_encode("getDeptDetail")."&id=".$this->session->userdata("UIY")."&mi=".base64_encode($ids));

    	$this->load->view('common/header', $this->data);
		$this->load->view('common/navbar', $this->data);
		$this->load->view('common/sidebar', $this->data);
		$this->load->view('master/dept_act', $this->data);
		$this->load->view('common/footer', $this->data);
	}

	public function mst_subdept(){
		$link = $_SERVER["REQUEST_URI"];
		$link = explode("/",$link);
    	$link = $link[2];

		$this->data["userAccs"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sys_menu")."&fn=".base64_encode("getAkses")."&id=".$this->session->userdata("UIY")."&mi=".base64_encode($link));
    	$this->data["sdptList"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sys_subdept")."&fn=".base64_encode("getSubdeptList")."&id=".$this->session->userdata("UIY"));

    	$this->load->view('common/header', $this->data);
		$this->load->view('common/navbar', $this->data);
		$this->load->view('common/sidebar', $this->data);
		$this->load->view('master/subdept', $this->data);
		$this->load->view('common/footer', $this->data);

	}

	public function subdept_act(){
		$link = $_SERVER["REQUEST_URI"];
    	$link = explode("/",$link);
    	$mod = $this->url_encode->base64_url_decode($link[4]);
    	$ids = (count($link) > 5) ? $this->url_encode->base64_url_decode($link[5]) : "";

		$this->data["mod"] = $mod;
		$this->data["dataId"] = $ids;
    	$this->data["sdptDtil"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sys_subdept")."&fn=".base64_encode("getSubdeptDetail")."&id=".$this->session->userdata("UIY")."&mi=".base64_encode($ids));

    	$this->load->view('common/header', $this->data);
		$this->load->view('common/navbar', $this->data);
		$this->load->view('common/sidebar', $this->data);
		$this->load->view('master/subdept_act', $this->data);
		$this->load->view('common/footer', $this->data);
	}

	public function mst_jabt(){
		$link = $_SERVER["REQUEST_URI"];
		$link = explode("/",$link);
    	$link = $link[2];

		$this->data["userAccs"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sys_menu")."&fn=".base64_encode("getAkses")."&id=".$this->session->userdata("UIY")."&mi=".base64_encode($link));
    	$this->data["jabtList"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sys_jabt")."&fn=".base64_encode("getJabtList")."&id=".$this->session->userdata("UIY"));

    	$this->load->view('common/header', $this->data);
		$this->load->view('common/navbar', $this->data);
		$this->load->view('common/sidebar', $this->data);
		$this->load->view('master/jabatan', $this->data);
		$this->load->view('common/footer', $this->data);
	}

	public function jabt_act(){
		$link = $_SERVER["REQUEST_URI"];
    	$link = explode("/",$link);
    	$mod = $this->url_encode->base64_url_decode($link[4]);
    	$ids = (count($link) > 5) ? $this->url_encode->base64_url_decode($link[5]) : "";
		
		$this->data["mod"] = $mod;
		$this->data["dataId"] = $ids;
    	$this->data["jabtDtil"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sys_jabt")."&fn=".base64_encode("getJabtDetail")."&id=".$this->session->userdata("UIY")."&mi=".base64_encode($ids));

		$this->load->view('common/header', $this->data);
		$this->load->view('common/navbar', $this->data);
		$this->load->view('common/sidebar', $this->data);
		$this->load->view('master/jabt_act', $this->data);
		$this->load->view('common/footer', $this->data);
	}
}

?>