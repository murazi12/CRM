<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller {

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
		
    }

	public function index()
	{
		if(empty($this->session->userdata("UIY"))){
			redirect('login');
		}
		else{
			$this->data["menu"] = $this->curl->simple_get(API_URL."?pg=".base64_encode("sys_menu")."&fn=".base64_encode("getMenu")."&id=".$this->session->userdata("UIY"));
			$this->load->view('common/header', $this->data);
			$this->load->view('common/navbar', $this->data);
			$this->load->view('common/sidebar', $this->data);
			$this->load->view('index', $this->data);
			$this->load->view('common/footer', $this->data);
		}
	}

	public function login(){
		if(empty($_REQUEST["uiy"])){
			if($this->agent->is_browser()){
				$agent = $this->agent->browser()." ".$this->agent->version();
			}
			elseif($this->agent->is_mobile()){
				$agent = $this->agent->mobile();
			}
			elseif($this->agent->is_robot()){
				$agent = $this->agent->robot();
			}
			else{
				$agent = "Unidentified";
			}
			$this->data["agent"] = $agent;
			$this->data["ops"] = $this->agent->platform();
			$this->data["ips"] = $this->input->ip_address();
			$this->data["url_api"] = API_URL."?pg=".base64_encode("sys_login")."&fn=".base64_encode("masuk");

			$this->load->view('common/header', $this->data);
			$this->load->view('login', $this->data);
		}
		else{
			$userData = array("UIY"=>$_REQUEST["uiy"], "UID"=>$_REQUEST["uid"], "EML"=>$_REQUEST["eml"]);
			$this->session->set_userdata($userData);
			redirect('index');
		}
	}

	public function logout(){
		if(!empty($this->session->userdata("UIY"))){
			$this->session->sess_destroy();
		}
		redirect('index');
	}
}
