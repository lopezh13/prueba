<?php
class Data_model extends CI_Model {

    public function get_data() {
        $query = $this->db->get('contactos');
        return $query->result();
    }

    public function insert_data($data) {
        $this->db->insert('contactos', $data);
        return array('status' => 'success', 'insert_id' => $this->db->insert_id());
    }
}
?>
