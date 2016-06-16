<?php

class User extends CI_Model {

	function create_user($post_params) {

		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('alias', 'Alias', 'trim|required|is_unique[users.alias]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'trim|required');
		$this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required');

		if ($this->form_validation->run() === false) {
			
			$this->session->set_flashdata('errors', validation_errors());
			return false;

		} else {
			
			$query = "INSERT INTO users (name, alias, email, password, password_confirm, dob, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
			$values = array($post_params['name'], $post_params['alias'], $post_params['email'], $post_params['password'], $post_params['password_confirm'], $post_params['dob'], date("Y-m-d, H:i:s"), date("Y-m-d, H:i:s"));
			$this->db->query($query, $values);

			$this->session->set_flashdata('success', 'You have successfully registered!');

		}

	}

	function get_user($user) {

		$query = "SELECT *
				  FROM users
				  WHERE email = ? AND password = ?";
		$values = array($user['email'], $user['password']);

		return $this->db->query($query, $values)->row_array();

	}

	function get_user_by_id($id) {

		$query = "SELECT *
				  FROM users
				  WHERE users.id = ?";
		$values = array($id);

		return $this->db->query($query, $values)->row_array();

	}

	function get_quotes_by_user_id($id) {

		$query = "SELECT quotes.*
				  FROM users
				  INNER JOIN quotes
				  	ON quotes.user_id = users.id
				  WHERE quotes.user_id = ?";
		$values = array($id);

		return $this->db->query($query, $values)->result_array();

	}

}

?>