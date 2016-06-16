<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quotes extends CI_Controller {

	function __construct() {

		parent::__construct();
		$this->load->model('User');
		$this->load->model('Quote');

	}

	function index() {

		$current_user_id = $this->session->userdata['user_info']['id'];

		$data['current_user'] = $this->session->userdata('user_info');
		$data['quotes'] = $this->Quote->get_all_quotes($current_user_id);
		$data['favorites'] = $this->Quote->get_all_favorites($current_user_id);
		// var_dump($data['quotes']); die();

		$this->load->view('quotes/quotes', $data);

	}

	function create() {

		$current_user = $this->session->userdata('user_info');

		$quote_params = array(

			'user_id' => $current_user['id'],
			'author' => $this->input->post('author'),
			'quote' => $this->input->post('quote')
			// 'favorite' => false

		);

		// var_dump($quote_params); die();

		$this->Quote->create_quote($quote_params);
		redirect('quotes');

		//// Alternate Syntax?

		// $this->Quote->create_quote($this->session->userdata['user_info']['id'], $this->input->post());
		// redirect('quotes');

	}

	function add_favorite($quote_id) {

		$this->Quote->create_favorite($quote_id);
		redirect('quotes');

	}

	function remove_favorite($favorite_id) {

		$this->Quote->delete_favorite($favorite_id);
		redirect('quotes');

	}

}

?>