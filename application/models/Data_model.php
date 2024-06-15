<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_data() {
        $query = $this->db->get('contactos');
        return $query->result_array();
    }

    public function insert_data($data) {
        $this->db->insert('contactos', $data);
        return ($this->db->affected_rows() > 0) ? true : false;
    }
}
?>
