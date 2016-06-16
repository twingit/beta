<?php

class Quote extends CI_Model {

	function create_quote($quote_params) {

		$this->form_validation->set_rules('author', 'Author', 'trim|required');
		$this->form_validation->set_rules('quote', 'Quote', 'trim|required');

		if ($this->form_validation->run() === false) {
			
			$this->session->set_flashdata('errors', validation_errors());
			return false;

		} else {
			
			$query = "INSERT INTO quotes (user_id, author, quote, created_at, updated_at) VALUES (?, ?, ?, ?, ?)";
			$values = array($quote_params['user_id'], $quote_params['author'], $quote_params['quote'], date("Y-m-d, H:i:s"), date("Y-m-d, H:i:s"));

			return $this->db->query($query, $values);

		}

	}

	function get_all_quotes($current_user_id) {

		$query = "SELECT users.name, quotes.*
				  FROM users
				  INNER JOIN quotes
				  	ON quotes.user_id = users.id
				  WHERE quotes.id
				  NOT IN (SELECT favorites.quote_id FROM favorites WHERE favorites.user_id = ?)
				  ORDER BY quotes.id DESC";
		$values = array($current_user_id);

		return $this->db->query($query, $values)->result_array();

	}

	function get_all_favorites($current_user_id) {

		$query = "SELECT users.name, quotes.*
				  FROM users
				  INNER JOIN quotes
				  	ON quotes.user_id = users.id
				  INNER JOIN favorites
				  	ON favorites.quote_id = quotes.id
				  WHERE favorites.user_id = ?";
		$values = array($current_user_id);

		return $this->db->query($query, $values)->result_array();

	}

	function create_favorite($quote_id) {

		$current_user = $this->session->userdata['user_info']['id'];
		$query = "INSERT INTO favorites (user_id, quote_id, created_at, updated_at)
				  VALUES (?, ?, ?, ?)";
		$values = array($current_user, $quote_id, date("Y-m-d, H:i:s"), date("Y-m-d, H:i:s"));

		return $this->db->query($query, $values);

	}

	function delete_favorite($favorite_id) {

		$current_user = $this->session->userdata['user_info']['id'];
		$query = "DELETE FROM favorites
				  WHERE user_id = ? AND quote_id = ?";
		$values = array($current_user, $favorite_id);

		return $this->db->query($query, $values);

	}

}

?>