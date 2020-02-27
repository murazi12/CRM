<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
    {
        parent::__construct();
		
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('user_agent');
		
		$this->load->helper('language');
		$this->load->helper('url');
		$this->load->helper(array('form', 'url'));

		/** GLobal Variabel Configuration URL **/
		$this->data['img_dir'] = $this->config->item('img_url');
		$this->data['skin_dir'] = $this->config->item('skin_url');
		$this->data['plug_dir'] = $this->config->item('plug_url');
		$this->data['base_url'] = $this->config->item('base_url');
		$this->data['font_dir'] = $this->config->item('font_url');
		$this->data['api_url'] = $this->config->item('api_url');

		
    }

	public function index()
	{
		redirect('/index');
	}
}
