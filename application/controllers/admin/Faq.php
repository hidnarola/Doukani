<?php

class Faq extends My_controller {

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

        $data = array();
        $data['page_title'] = 'FAQ List';

        $query = ' is_delete=0 order by sort_order';
        $faq = $this->dbcommon->filter('faq', $query);
        
        $data['total_records'] = sizeof($faq);        
        $data['faq'] = $faq;
        $msg = $this->session->flashdata('msg');
        if (!empty($msg)):
            $data['msg'] = $this->session->flashdata('msg');
            $data['msg_class'] = $this->session->flashdata('class');
        endif;
        $this->load->view('admin/faq/index', $data);
    }

    public function add() {
        $data = array();
        $data['page_title'] = 'Add FAQ';

        $user = $this->session->userdata('user');
        if (!empty($_POST)):

            $this->form_validation->set_rules('question', 'Question', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run() == FALSE):

                $data['msg'] = "Please fill all required fields";
                $data['msg_class'] = 'alert-info';
                $this->load->view('admin/faq/add', $data);
            else:
                $current_user = $this->session->userdata('user');

                $query = "SELECT max(`sort_order`) as sort_order  FROM `faq`";
                $result = $this->dbcommon->get_distinct($query);
                $data = array(
                    'question' => $_POST['question'],
                    'answer' => $_POST['answer'],
                    'meta_title' => $_POST['meta_title'],
                    'meta_desc' => $_POST['meta_desc'],
                    'meta_keyword' => $_POST['meta_keyword'],
                    'created_date' => date('y-m-d H:i:s', time()),
                    'created_by' => $current_user->user_id,
                    'sort_order' => $result[0]['sort_order'] + 1,
                    'is_delete' => 0
                );

                $result = $this->dbcommon->insert('faq', $data);
                if ($result):
                    $this->session->set_flashdata(array('msg' => 'FAQ added successfully', 'class' => 'alert-success'));
                    redirect('admin/faq');
                else:
                    $data['msg'] = 'FAQ not added, Please try again';
                    $data['msg_class'] = 'alert-info';
                    $this->load->view('admin/faq/add', $data);
                endif;
            endif;
        else:
            $this->load->view('admin/faq/add', $data);
        endif;
    }

    public function edit($faq_id = null) {
        $data = array();
        $where = " where faq_id='" . $faq_id . "'";
        $faq = $this->dbcommon->getdetails('faq', $where);
        $data['page_title'] = 'Edit FAQ';



        if ($faq_id != null && !empty($faq)):
            $data['faq'] = $faq;
            if (!empty($_POST)):
                $this->form_validation->set_rules('question', 'Question', 'trim|required');
                $this->form_validation->set_error_delimiters('', '');
                if ($this->form_validation->run() == FALSE):

                    $data['msg'] = "Please fill all required fields";
                    $data['msg_class'] = 'alert-info';
                    $this->load->view('admin/faq/edit', $data);
                else:

                    $current_user = $this->session->userdata('user');
                    $data = array(
                        'question' => $_POST['question'],
                        'answer' => $_POST['answer'],
                        'meta_title' => $_POST['meta_title'],
                        'meta_desc' => $_POST['meta_desc'],
                        'meta_keyword' => $_POST['meta_keyword'],
                        'modified_date' => date('y-m-d H:i:s', time()),
                        'modified_by' => $current_user->user_id,
                        'is_delete' => 0
                    );
                    $array = array('faq_id' => $faq[0]->faq_id);
                    $result = $this->dbcommon->update('faq', $array, $data);
                    if ($result):
                        $this->session->set_flashdata(array('msg' => 'FAQ updated successfully', 'class' => 'alert-success'));
                        redirect('admin/faq');
                    else:
                        $data['msg'] = 'FAQ not added, Please try again';
                        $data['msg_class'] = 'alert-info';
                        $this->load->view('admin/faq/edit', $data);
                    endif;
                endif;
            else:
                $this->load->view('admin/faq/edit', $data);
            endif;
        else:
            $this->session->set_flashdata(array('msg' => 'FAQ not found', 'class' => 'alert-info'));
            redirect('admin/faq');
        endif;
    }

    public function delete($faq_id = null) {

        if ($this->input->post("checked_val") != '') {
            $faq_id = explode(",", $this->input->post("checked_val"));
            $comma_ids = implode(',', $faq_id);
        } else
            $comma_ids = $faq_id;
        
        $faqs = $this->db->query('select * from faq
                                  where faq_id in (' . $comma_ids . ')')->result_array();

        $data = array();
        $success = 0;

        foreach ($faqs as $p) {

            $where = array("faq_id" => $p['faq_id']);
            $data = array('is_delete' => 1);
            $page = $this->dbcommon->update('faq', $where, $data);
            $success++;
        }

        if ($success > 0) {
            $this->session->set_flashdata(array('msg' => 'FAQ deleted successfully', 'class' => 'alert-success'));
            redirect('admin/faq');
        } else {
            $this->session->set_flashdata(array('msg' => 'FAQ not found', 'class' => 'alert-info'));
            redirect('admin/faq');
        }
    }

    public function order_pages() {
        echo json_encode($_POST);
        $order = $this->input->post("sort_order");
        $i = min($order);
        foreach ($order as $value) {
            $data = array(
                'sort_order' => $i
            );
            $array = array('faq_id' => $value);
            $result = $this->dbcommon->update('faq', $array, $data);
            $i++;
        }
    }

}

?>