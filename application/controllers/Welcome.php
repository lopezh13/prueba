<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	
	public function form() {
		$this->load->view('formulario_contacto');
	}

	public function getData() {
        $this->load->model('Data_model');
        $data = $this->Data_model->get_data();
        echo json_encode($data);
    }

	public function saveData() {
        $data = $this->input->post();
        $this->load->model('Data_model');
        $result = $this->Data_model->insert_data($data);
        echo json_encode($result);
    }
}
