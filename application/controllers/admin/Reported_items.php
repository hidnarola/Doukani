<?php

class Reported_items extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('dblogin', '', TRUE);
        $this->load->model('dbcommon', '', TRUE);
        $this->load->helper('common', '', TRUE);
        $this->per_page = 10;
        $this->perpageSuffix = "";
        $this->filterSuffix = "";


        if ($this->input->get('search')) {
            $this->filterSuffix = "?search=" . $this->input->get('search');
        }
        $this->suffix = $this->filterSuffix . $this->perpageSuffix;
    }

    public function index() {
        $data = array();
        $config = init_pagination();
        $data['page_title'] = 'Reported items List';

        if ($this->input->get('search'))
            $config['first_url'] = base_url() . "admin/reported_items/index" . $this->suffix;

        $config['suffix'] = $this->suffix;
        $config['base_url'] = base_url() . "admin/reported_items/index";
         $config['per_page'] = $this->per_page;
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $page = ($page == 0) ? 0 : ($page - 1) * $config['per_page'];

        $query = "SELECT * FROM `reported_items` `r`"
                . " LEFT JOIN `product` `p` ON `r`.`report_for_product_id` = `p`.`product_id`  "
                . "LEFT JOIN `user` `u` ON `u`.`user_id` = `r`.`user_id` Where `r`.`is_delete` =0 ";
        if ($this->input->get('search')) {
            $keyword = $this->input->get('search');
            $keyword = str_replace("'", "''", $keyword);
            $query .= " AND (p.product_id like '%$keyword%'";
            $query .= " OR ";
            $query .= "p.product_name like '%$keyword%'";
            $query .= " OR ";
            $query .= "u.first_name like '%$keyword%'";
            $query .= " OR ";
            $query .= "u.last_name like '%$keyword%'";
            $query .= " OR ";
            $query .= "u.email_id like '%$keyword%'";
            $query .= " OR ";
            $query .= "u.username like '%$keyword%')";
        }
        $query .= "ORDER BY `r`.`id` DESC";
        $items = $this->dbcommon->get_distinct($query);
        $config['total_rows'] = count($this->dbcommon->customQuery($query, 2));
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();
        $reported_items = $this->dbcommon->customQuery($query . ' Limit ' . $page . ', ' . $config['per_page'], 2);

        $data['total_records'] = sizeof($items);
        $data['reported_items'] = $reported_items;
        $this->load->view('admin/reported_items/index', $data);
    }

    public function getreported_item() {
        $id = $this->input->post('id');
        if ($id != '') {
            $reported_item = $this->dbcommon->get_reported_item($id);
            echo json_encode($reported_item);
            exit;
        }
    }

    public function delete($repoted_id = null) {

        if ($this->input->post("checked_val") != '') {
            $repoted_id = explode(",", $this->input->post("checked_val"));
            $comma_ids = implode(',', $repoted_id);
        } else
            $comma_ids = $repoted_id;

        $faqs = $this->db->query('select * from reported_items
                                  where id in (' . $comma_ids . ')')->result_array();

        $data = array();
        $success = 0;
        foreach ($faqs as $p) {
            $where = array("id" => $p['id']);
            $data = array('is_delete' => 1);
            $page = $this->dbcommon->update('reported_items', $where, $data);
            $success++;
        }

        if ($success > 0) {
            $this->session->set_flashdata(array('msg' => 'Reported item deleted successfully', 'class' => 'alert-success'));
            redirect('admin/reported_items');
        } else {
            $this->session->set_flashdata(array('msg' => 'Reported item not found', 'class' => 'alert-info'));
            redirect('admin/reported_items');
        }
    }

}
