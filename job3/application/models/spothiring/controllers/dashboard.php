<?php

class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('session', 'tcpdf', 'Pdf', 'email', 'Sms_lib', 'pagination', 'form_validation', 'Csrf_custom', 'user_agent'));
        $this->load->model(array('spot_model',));
        $this->load->helper(array('url', 'date', 'security'));

        $this->pfmsMode = $this->config->item("esign_mode");
        $this->demo_mode = $this->config->item('demo_mode');
        $this->pfmsIP = $this->config->item("pfms_IP");
        $this->defaultCity = $this->config->item("defaultCity");
        $this->pfms_PASS = $this->config->item("pfms_PASS");
        $this->upload_files = $this->config->item("upload_files");
        $this->esignMode = $this->config->item("esign_mode");
        $this->upload_files = $this->config->item("upload_files");
        $this->db = $this->load->database('default', TRUE);
        $this->site_name = $this->config->item('site_name');
        $this->site_domain = $this->config->item('site_domain');
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->input->post(array(), TRUE);
        $this->input->get(array(), TRUE);
        $_GET = $this->security->xss_clean($_GET);
        $this->load->library('form_validation');
        $this->u_name = $this->nehbr_auth->get_userFirstNAme();
        $this->u_id = $this->nehbr_auth->get_user_id();
        $this->role_id = $this->ci->session->userdata('role_id');
        $this->service_type = $this->ci->session->userdata('service_type');
        $this->load->model('servicebcyclog/servicebcyclog_model');
    }

    function __validateUser() {
        $userId = $this->nehbr_auth->get_user_id();
        $res = $this->db->select('GROUP_CONCAT(ur_role) as roles')->from('user_roles')->where('ur_user_id', $userId)->get()->result();
        if (in_array(16, explode(',', $res [0]->roles))) {
            return true;
        }

        if (in_array(3, explode(',', $res [0]->roles))) {
            return true;
        }
        
        if (in_array(1, explode(',', $res [0]->roles))) {
            return true;
        }
        return false;
    }

    function servicelist() {
        if (isset($this->u_id) && $this->u_id != '') {
            $p = trim($this->input);
            $data['title'] = "Spot Hiring";
            $data['sess_name'] = $this->u_name;
            $data['cars'] = $this->carlist_model->searchCarsSpot();
            $data['city'] = $this->carlist_model->get_city();
            $data['model'] = $this->carlist_model->get_model();
            $data['brand'] = $this->carlist_model->get_brand();
            $this->load->view('../../__inc/header_market', $data);
            $this->load->view('servicelist', $data);
            $this->load->view('../../__inc/common_footer', $data);
        } else {
            redirect('/auth/login');
        }
    }

    function __validateGovtUser() {
        $userId = $this->nehbr_auth->get_user_id();
        $res = $this->db->select('GROUP_CONCAT(ur_role) as roles')->from('user_roles')->where('ur_user_id', $userId)->get()->result();
        if (in_array('1', explode(',', $res [0]->roles))) { // admin DGSND
            return true;
        } else if (in_array('2', explode(',', $res [0]->roles))) { // HOD
            return true;
        } else if (in_array('3', explode(',', $res [0]->roles)) || in_array('4', explode(',', $res [0]->roles))) { // Indentor
            return true;
        } else if (in_array('6', explode(',', $res [0]->roles)) || in_array('5', explode(',', $res [0]->roles))) { // Purchaser
            return true;
        } else if (in_array('7', explode(',', $res [0]->roles)) || in_array('8', explode(',', $res [0]->roles))) { // Consignee
            return true;
        } else if (in_array('9', explode(',', $res [0]->roles)) || in_array('10', explode(',', $res [0]->roles))) { // payauth
            return true;
        }
        return false;
    }

    /**
     * show aggregrated value of user/ride/billing data
     * add graph with pyament status. (track your payment)
     * add pending payments. 
     * 
     */
    function index() {
        redirect('spothiring/dashboard/manage_spot_users');
    }

    /**
     * 
     */
    function manage_spot_users($offset) {
        if ($this->__validateUser()) {
            $data['title'] = "Manage Riders";
            $data['sess_name'] = $this->u_name;
            $spot_users = $this->spot_model->get_spot_users($offset);
//            print_r($spot_users);
//            die();

            $this->load->library('table');
            $this->table->set_heading('Sl. No.', 'Name', 'Mobile', 'Department ID', 'Email', 'Order ID');
            $tmpl = array('table_open' => '<div class="table-responsive"><table id="example1"  class="table-striped table table-bordered">', 'table_close' => '</table> </div>');

            $this->table->set_template($tmpl);
            $i = 0;
            foreach ($spot_users as $ress) {
                $i++;
                $this->table->add_row($i, $ress->ss_name, $ress->ss_mobile_no, $ress->ss_department, $ress->ss_email,  $ress->ss_order_id);
            }

            $data['spot_users'] = $this->table->generate();

            $this->load->view('../../__inc/header_market', $data);
            $this->load->view('manage_spot_users', $data);
            $this->load->view('../../__inc/common_footer', $data);
        } else {
            redirect('/auth/login');
        }
    }

    /**
     * 
     */
    function manage_rides() {
        if ($this->__validateUser()) {
            $data['title'] = "Manage Riders";
            $data['sess_name'] = $this->u_name;
            $spot_users = $this->spot_model->get_spot_rides($offset);
//            print_r($spot_users);
//            die();
            $data['ride_api'] = $this->spot_model->get_api_details_by_type("get_ride_data", $this->u_id);
            $data['api_params']  = unserialize($data['ride_api'][0]->api_params);
            $this->load->library('table');
            $this->table->set_heading('Sl. No.', 'ID', 'Email' , 'Mobile' ,  'Pickup Location', 'Drop Location', 'Distance', 'Action');
            $tmpl = array('table_open' => '<div class="table-responsive"><table id="example1"  class="table-striped table table-bordered">', 'table_close' => '</table> </div>');

            $this->table->set_template($tmpl);
            $i = 0;
            foreach ($spot_users as $ress) {
                $i++;
                $this->table->add_row($i, $ress->ssr_unique_id,  $ress->ssr_user_email, $ress->ssr_user_mobile, $ress->ssr_pickup_location, $ress->ssr_drop_location, $ress->ssr_distance, 'Action ');
            }

            $data['spot_ride_data'] = $this->table->generate();

            $this->load->view('../../__inc/header_market', $data);
            $this->load->view('manage_rides', $data);
            $this->load->view('../../__inc/common_footer', $data);
        } else {
            redirect('/auth/login');
        }
    }



    /**
     * Only Buyer are allowed  to access this function during order process. 
     * deparment => current_users_deprtment_id
     * status = 0 => new 
     *  1 => active
     * 2 => deactive
     * 3 => deleted
     * Unique fields ==> email,mobile 
     * user_type {
     *  0 => non-gem usser
     *  buyer_role_id => 
     * }
     */
    function add_spot_users() {
        if ($this->__validateUser()) { // Check of user is login 
            $data['title'] = "Add Spot User | GeM";
            $api_id = $this->input->get('api_id', TRUE); //Get api_id if exists
            $this->form_validation->set_rules('state', 'State', 'trim|required|xss_clean|alpha_numeric_space');
            $this->form_validation->set_rules('passengerno', 'No of Passengers', 'trim|required|xss_clean|alpha_numeric_space');
            $this->form_validation->set_rules('vehicletype', 'Type of Vehicle', 'trim|required|xss_clean|alpha_numeric_space');



            if ($this->input->post()) { //Submiting Form 
                $insert_data = $this->input->post();
                $insert = array();
                $i = 0;
                foreach ($insert_data['user_name'] as $key => $values) {
       
                        $i++;
                        $insert = array(
                            'ss_name' => $insert_data['user_name'][$key],
                            'ss_mobile_no' => $insert_data['user_mobile'][$key],
                            'ss_email' => $insert_data['user_email'][$key],
                            'ss_department' => $insert_data['department'][$key]
                        );
                        $spot_users_data[] =  $insert;
          
                    
                }

                $save = $this->spot_model->add_spot_users($spot_users_data);

                if (isset($save)) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable">Users Added Successfully.</div>');
                    redirect('/spothiring/dashboard/manage_spot_users');
                }
            }


            if (isset($api_id) && $api_id != '') { // Default Form State
                if (isset($valid_user) && $valid_user != '') { //Update
                    $data['result'] = $this->spot_model->get_api_details($api_id, $this->u_id);
                    $data['api_type'] = $data['result'][0]->api_name;
                    $data['api_description'] = $data['result'][0]->api_description;
                    $data['method'] = $data['result'][0]->api_method_type;
                    $data['api_endpoint'] = $data['result'][0]->api_endpoint;
                    $data['api_params'] = unserialize($data['result'][0]->api_params);
                    $data['headers'] = unserialize($data['result'][0]->api_headers);
                    $data['api_sample_response'] = unserialize($data['result'][0]->api_sample_response);
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable">You are not the valid user to access details.</div>');
                    //  redirect('/serviceprovider/provider/leasing_view');
                }
            }
            $this->load->view('../../__inc/header_market', $data);
            $this->load->view('add_spot_users', $data);
            $this->load->view('../../__inc/common_footer', $data);
        } else {
            redirect('/auth/login');
        }
    }

}

?>
