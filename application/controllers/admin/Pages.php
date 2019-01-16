<?php

class Pages extends My_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('dblogin', '', TRUE);
        $this->load->model('dbcommon', '', TRUE);
        $this->load->library('permission');
    }

    function file_get_contents_curl($url) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    public function index() {

        $data['page_title'] = 'Pages List';
        $page = $this->dbcommon->select('pages_cms');
        $data['total_records'] = sizeof($page);
        $join = $this->dbcommon->join_on_pages();
        foreach ($join as $join_row) {
            foreach ($page as $key => $value) {
                if ($page[$key]['page_id'] == $join_row['page_id']) {
                    $page[$key]['parent_title'] = $join_row['parent_title'];
                }
            }
        }

        $data['page'] = $page;
        $msg = $this->session->flashdata('msg');
        if (!empty($msg)):
            $data['msg'] = $this->session->flashdata('msg');
            $data['msg_class'] = $this->session->flashdata('class');
        endif;
        $this->load->view('admin/pages/index', $data);
    }

    public function add() {
        $data = array();
        $data['page_title'] = 'Add Page';
        $fields = ' page_id, page_title ';
        $where = array('parent_page_id' => 0
        );
        $pages = $this->dbcommon->get_specific_colums('pages_cms', $fields, $where, 'order', 'asc');
        $data['pages'] = $pages;
        $pattern = '/\.(fa-(?:\w+(?:-)?)+):before/';
        // $pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
        $target_dir = base_url() . front_fontawesome . 'font-awesome.css';
//        $subject = $this->file_get_contents_curl($target_dir);
        $subject = file_get_contents(document_root . front_fontawesome . 'font-awesome.css');
        preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

        $icons = array();
        foreach ($matches as $match) {
            $icons[] = $match[1];
        }
        $data['icons'] = $icons;

        $user = $this->session->userdata('user');
        if (!empty($_POST)):
            // validation 
            $this->form_validation->set_rules('page_title', 'Page Title', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run() == FALSE):
                $data['msg'] = "Please fill all required fields";
                $data['msg_class'] = 'alert-info';
                $this->load->view('admin/pages/add', $data);
            else:


                if (isset($_POST['page_state'])) {
                    $pagestate = 1;
                } else {
                    $pagestate = 0;
                }
                // $query = "SELECT max(`order`) as page_order  FROM `classified_app`.`pages_cms`";
                $query = "SELECT max(`order`) as page_order  FROM `pages_cms`";
                $result = $this->dbcommon->get_distinct($query);
                $data = array(
                    'page_title' => $_POST['page_title'],
                    'sub_title' => $_POST['sub_title'],
                    'page_content' => $_POST['page_content'],
                    'page_state' => $pagestate,
                    'page_meta_title' => $_POST['page_meta_title'],
                    'page_meta_desc' => $_POST['page_meta_desc'],
                    'parent_page_id' => $_POST['parent_id'],
                    'direct_url' => $_POST['direct_url'],
                    'page_meta_keyword' => $_POST['page_meta_keyword'],
                    'color' => $_POST['color'],
                    'slug_url' => strtolower(str_replace(" ", "-", $_POST['page_title'])),
                    'order' => $result[0]['page_order'] + 1
                );
                if ($_POST['select_icons'] != '')
                    $data['icon'] = $_POST['select_icons'];

                $result = $this->dbcommon->insert('pages_cms', $data);
                if ($result):
                    $data['msg'] = 'Page added successfully.';
                    $data['msg_class'] = 'alert-success';
                    $this->session->set_flashdata(array('msg' => 'Page added successfully', 'class' => 'alert-success'));
                    redirect('admin/pages');
                else:
                    $data['msg'] = 'Page not added, Please try again';
                    $data['msg_class'] = 'alert-info';
                    $this->load->view('admin/pages/add', $data);
                endif;
            endif;
        else:
            $this->load->view('admin/pages/add', $data);
        endif;
    }

    public function edit($page_id = null) {
        $data = array();
        $where = " where page_id='" . $page_id . "'";
        $page = $this->dbcommon->getdetails('pages_cms', $where);
        $data['page_title'] = 'Edit Page';
        $fields = ' page_id, page_title ';
        $where = array('page_id !=' => $page_id,
            'parent_page_id' => 0
        );
        $pages = $this->dbcommon->get_specific_colums('pages_cms', $fields, $where, 'order', 'asc');
        $data['pages'] = $pages;
        $pattern = '/\.(fa-(?:\w+(?:-)?)+):before/';
        // $pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
        $target_dir = base_url() . front_fontawesome . 'font-awesome.css';
//        $subject = $this->file_get_contents_curl($target_dir);
        $subject = file_get_contents(document_root . front_fontawesome . 'font-awesome.css');
        preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

        $icons = array();

        foreach ($matches as $match) {
            $icons[] = $match[1];
        }
        $data['icons'] = $icons;
        if ($page_id != null && !empty($page)):
            $data['page'] = $page;
            if (!empty($_POST)):
                $this->form_validation->set_rules('page_title', 'Page Title', 'trim|required');
                $this->form_validation->set_error_delimiters('', '');
                if ($this->form_validation->run() == FALSE):
                    $data['msg'] = "Please fill all required fields";
                    $data['msg_class'] = 'alert-info';
                    $this->load->view('admin/pages/edit', $data);
                else:

                    if (isset($_POST['page_state'])) {
                        $pagestate = 1;
                    } else {
                        $pagestate = 0;
                    }
                    $data = array(
                        'page_title' => $_POST['page_title'],
                        'sub_title' => $_POST['sub_title'],
                        'page_content' => $_POST['page_content'],
                        'page_state' => $pagestate,
                        'page_meta_title' => $_POST['page_meta_title'],
                        'page_meta_desc' => $_POST['page_meta_desc'],
                        'parent_page_id' => $_POST['parent_id'],
                        'direct_url' => $_POST['direct_url'],
                        'color' => $_POST['color'],
                        'page_meta_keyword' => $_POST['page_meta_keyword'],
//                        'slug_url' => strtolower(str_replace(" ", "-", $_POST['page_title'])),
                    );
                    if ($_POST['select_icons'] != '')
                        $data['icon'] = $_POST['select_icons'];


                    $array = array('page_id' => $page[0]->page_id);
                    $result = $this->dbcommon->update('pages_cms', $array, $data);
                    if ($result):
                        $this->session->set_flashdata(array('msg' => 'Page updated successfully', 'class' => 'alert-success'));
                        redirect('admin/pages');
                    else:
                        $data['msg'] = 'Page not updated, Please try again';
                        $data['msg_class'] = 'alert-info';
                        $this->load->view('admin/pages/edit', $data);
                    endif;
                endif;
            else:
                $this->load->view('admin/pages/edit', $data);
            endif;
        else:
            $this->session->set_flashdata(array('msg' => 'Page not found', 'class' => 'alert-info'));
            redirect('admin/pages');
        endif;
    }

    public function delete($page_id = null) {

        if ($this->input->post("checked_val") != '') {
            $page_id = explode(",", $this->input->post("checked_val"));
            $comma_ids = implode(',', $page_id);
        } else
            $comma_ids = $page_id;

        $pages = $this->db->query('select * from pages_cms
                                  where page_id in (' . $comma_ids . ')')->result_array();

        $target_dir = document_root . pages;
        $data = array();
        $success = 0;
        foreach ($pages as $p) {

            $where = array("page_id" => $p['page_id']);
            $page = $this->dbcommon->delete('pages_cms', $where);
            if ($page):
                @unlink($target_dir . "original/" . $p['page_image']);
                @unlink($target_dir . "small/" . $p['page_image']);
                @unlink($target_dir . "medium/" . $p['page_image']);
            endif;
            $success++;
        }

        if ($success > 0) {
            $this->session->set_flashdata(array('msg' => 'Page(s) deleted successfully', 'class' => 'alert-success'));
            redirect('admin/pages');
        } else {
            $this->session->set_flashdata(array('msg' => 'Page(s) not found', 'class' => 'alert-info'));
            redirect('admin/pages');
        }
    }

    public function order_pages() {
        echo json_encode($_POST);
        $order = $this->input->post("order");
        $i = min($order);
        foreach ($order as $value) {
            $data = array(
                'order' => $i
            );
            $array = array('page_id' => $value);
            $result = $this->dbcommon->update('pages_cms', $array, $data);
            $i++;
        }
    }

    public function manage() {
        $data = array();
        $data['page_title'] = 'Manage Pages';
        $data = array_merge($data, $this->get_elements());

        $this->load->view('admin/pages/manage', $data);
    }

    public function set_location() {
        // echo json_encode($_POST);

        $data = array(
            $_POST['location'] => $_POST['value']
        );
        // echo json_encode($data);
        $array = array('page_id' => $_POST['page_id']);
        $this->dbcommon->update('pages_cms', $array, $data);
    }

}

?>