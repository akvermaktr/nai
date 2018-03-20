<?php

class Api extends MY_Controller {

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

    function index() {
        redirect('spothiring/api/api_list');
    }

    /**
     * API Integration with GeM
     * 
     */
    function add_new_api() {

        if ($this->__validateUser()) { // Check of user is login 
            $data['title'] = "Spot Hiring: API Integration";
            $api_id = $this->input->get('api_id', TRUE); //Get api_id if exists
            $this->form_validation->set_rules('state', 'State', 'trim|required|xss_clean|alpha_numeric_space');
            $this->form_validation->set_rules('passengerno', 'No of Passengers', 'trim|required|xss_clean|alpha_numeric_space');
            $this->form_validation->set_rules('vehicletype', 'Type of Vehicle', 'trim|required|xss_clean|alpha_numeric_space');


            $data['table'] = 'service_spot_users';

            $field_data = $this->db->field_data($data['table']);
            $field_array = array();
            //prx($field_data);
            foreach ($field_data as $field) {
                if ($field->primary_key == 0) { //exclude primary key
                    $field_array[] = $field->name;
                }
            }
            $field_array[] = "USER DEFINED";
            $data['gem_table_fields'] = $field_array;


            if (isset($api_id) && $api_id != '') {
                $data['title'] = "Edit API";
                $valid_user = $this->spot_model->chk_service_creator($api_id);
            }


            if ($this->input->post()) { //Submiting Form 
                if (isset($api_id) && $api_id != '') { // update
                    if (isset($valid_user) && $valid_user != '') {
                        $this->spot_model->update_api($api_id);
                        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable">API Details updated successfully.</div>');
                        redirect('/spothiring/api/api_list');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable">You are not the valid user to access details.</div>');
                        redirect('/spothiring/api/list_all');
                    }
                } else { // insert 
                    $save = $this->spot_model->add_new_api($this->u_id);
                    if (isset($save)) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable">API linked Successfully.</div>');
                        redirect('/spothiring/api/api_list');
                    }
                }
            }


            if (isset($api_id) && $api_id != '') { // Default Form State
                if (isset($valid_user) && $valid_user != '') { //Update
                    $data['result'] = $this->spot_model->get_api_details($api_id, $this->u_id);
                    $data['api_type'] = $data['result'][0]->api_name;
                    $data['api_description'] = $data['result'][0]->api_description;
                    $data['method'] = $data['result'][0]->api_method_type;
                    $data['api_mode'] = $data['result'][0]->api_mode;
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
            $this->load->view('api_link', $data);
            $this->load->view('../../__inc/common_footer', $data);
        } else {
            redirect('/auth/login');
        }
    }

    /**
     * Delete an existing API
     */
    function delete_api($api_id) {
        
    }

    /**
     * display all integrated api 
     */
    function api_list() {
        $apis = $this->spot_model->get_api_by_user($this->u_id);

        $this->load->library('table');
        $this->table->set_heading('API Name', 'Provider ID', 'Description', 'End Point', 'Method', 'Created On', 'Action');
        $tmpl = array('table_open' => '<div class="table-responsive"><table class="table-striped table table-bordered">', 'table_close' => '</table> </div>');

        $this->table->set_template($tmpl);
        $i = 0;

        foreach ($apis as $ress) {
            $this->table->add_row($ress->api_name, $ress->api_sp_user_id, $ress->api_description, $ress->api_endpoint, $ress->api_method_type,
                    /* $ress->api_headers,  $ress->api_prams */ $ress->api_created_on, '<a href= "/spothiring/api/add_new_api?api_id=' . $ress->api_id . '" > Edit </a>   | Delete | <a href="/spothiring/api/api_mapping_to_gem/' . $ress->api_id . '" > Mapping to GeM </a>  ');
        }



        $res = $this->table->generate();
        $data['api_table'] = $res;
        $this->load->view('../../__inc/header_market', $data);
        $this->load->view('api_list', $data);
        $this->load->view('../../__inc/common_footer', $data);
    }

    /**
     * List all corp users. 
     */
    function list_all_users() {
        $curlurl = "http://sandbox-t.olacabs.com/v1/api/corporate/users";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $curlurl);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-CORPORATE-TOKEN:7fc92c6f15bc437c9d99ede2a17556a8'));
        $output = curl_exec($curl);
        if ($output === FALSE) {
            echo 'An error has occurred: ' . curl_error($curl) . PHP_EOL;
        } else {
            echo $output;
        };
        //print_r($curlresult);
    }

    /**
     * Test API Working
     */
    function test_api() {
        if ($this->input->post()) {

            $curlurl = html_entity_decode($this->input->post('api_endpoint'));  // "http://sandbox-t.olacabs.com/v1/api/corporate/user";


            if (!empty($this->input->post('header_pram_name')[0]) && !empty($this->input->post('header_pram_value')[0])) {
                $header = array();
                $header_param_value = $this->input->post('header_pram_value');
                foreach ($this->input->post('header_pram_name') as $key => $val) {
                    $header[] = $val . ":" . $header_param_value[$key];
                }
            }
            if (!empty($this->input->post('pram_name')[0]) && !empty($this->input->post('pram_value')[0])) {
                $param = array();
                $param_value = $this->input->post('pram_value');
                foreach ($this->input->post('pram_name') as $key => $val) {
                    $param[$val] = html_entity_decode($param_value[$key]);
                }
            }
            if ($this->input->post('method') == "get") {
                $param = array();
                $param_value = $this->input->post('pram_value');
                foreach ($this->input->post('pram_name') as $key => $val) {
                    $param[] = $val . '=' . html_entity_decode($param_value[$key]);
                }
            }
            /*  $header  =  array (
              "Content-Type:application/json", "x-corporate-token:7fc92c6f15bc437c9d99ede2a17556a8"
              ); */
            //$header[] = 'Content-Type:application/json';
//            $param = array(
//                'title' => "titlesdf"
//            );
//            
            $curl = curl_init();
            $options = array(
                // CURLOPT_URL => $curlurl,
                CURLOPT_HEADER => FALSE, // True : will add Header info on top 
                // CURLOPT_PORT => "3000",
                CURLOPT_CUSTOMREQUEST => strtoupper($this->input->post('method')),
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_HTTPHEADER => $header,
                CURLOPT_RETURNTRANSFER => TRUE
            );
            if ($this->input->post('method') == "post") {
                $options [CURLOPT_POSTFIELDS] = '' . json_encode($param) . '';
                $options [CURLOPT_URL] = $curlurl;
            }
            if ($this->input->post('method') == "get") {
                $curlurl = $curlurl . '?' . implode('&', str_replace(' ', '%20', $param));
                $options [CURLOPT_URL] = $curlurl;
            }

            curl_setopt_array($curl, $options);

            $response = curl_exec($curl);
            $err = curl_errno($curl);

            curl_close($curl);

            if ($err) {
                echo 'An error has occurred: ' . curl_error($curl) . PHP_EOL;
            } else {
                echo $response;
            };
            //print_r($curlresult);
        } else {
            echo "Error";
        }
    }

    /**
     * Dsipaly a form for mapping GeM Database Column to SP data
     */
    function api_mapping_to_gem($api_id_no) {
        if ($this->__validateUser()) { // Check of user is login 
            $data['title'] = "Spot Hiring: API Mapping";
            $api_id = $api_id_no; //Get api_id if exists
            $this->form_validation->set_rules('state', 'State', 'trim|required|xss_clean|alpha_numeric_space');
            $this->form_validation->set_rules('passengerno', 'No of Passengers', 'trim|required|xss_clean|alpha_numeric_space');
            $this->form_validation->set_rules('vehicletype', 'Type of Vehicle', 'trim|required|xss_clean|alpha_numeric_space');

            if (isset($api_id) && $api_id != '') {
                $data['title'] = "Edit API";
                $valid_user = $this->spot_model->chk_service_creator($api_id);
            }


            if ($this->input->post()) { //Submiting Form 
                if (isset($api_id) && $api_id != '') { // update
                    if (isset($valid_user) && $valid_user != '') {
                        $this->spot_model->update_api_mapping($api_id);
                        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable">API Details updated successfully.</div>');
                        redirect('/spothiring/api/api_list');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable">You are not the valid user to access details.</div>');
                        redirect('/spothiring/api/list_all');
                    }
                } else { // insert 
                    redirect('/spothiring/api/api_list');
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
                    $data['api_fields_map_to_gem'] = unserialize($data['result'][0]->api_fields_map_to_gem);
                    $data['api_sample_response'] = unserialize($data['result'][0]->api_sample_response);
                    // $this->get_child( $data['api_sample_response']);
                    if (in_array($data['api_type'], array('add_emp', 'remove_emp', 'update_emp', 'get_emp_data'))) { // User table
                        $data['table'] = 'service_spot_users';
                    } else if (in_array($data['api_type'], array('get_ride_data'))) { // Log table
                        $data['table'] = 'service_spot_rides';
                    } else if (in_array($data['api_type'], array('downlod_invoice'))) { // Invoice Table
                        $data['table'] = 'service_spot_users';
                    }
                    $field_data = $this->db->field_data($data['table']);
                    $field_array = array();
                    //prx($field_data);
                    foreach ($field_data as $field) {
                        if ($field->primary_key == 0) { //exclude primary key
                            $field_array[] = $field->name;
                        }
                    }
                    $data['gem_table_fields'] = $field_array;
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable">You are not the valid user to access details.</div>');
                    //  redirect('/serviceprovider/provider/leasing_view');
                }
            }
            $this->load->view('../../__inc/header_market', $data);
            $this->load->view('api_mapping', $data);
            $this->load->view('../../__inc/common_footer', $data);
        } else {
            redirect('/auth/login');
        }
    }

    /**
     * Add new corporate user.
     */
    function add() {
        $curlurl = "http://sandbox-t.olacabs.com/v1/api/corporate/user";
        $header = array('X-CORPORATE-TOKEN:7fc92c6f15bc437c9d99ede2a17556a8', 'Content-Type:application/json');
//        $users =  "select * from spot_user" ;
//        
//  
//        foreach($api as $api ) { // loop throug each service provider apis. 
//            $mapping = $api['mapping']; 
//            $array_mapped = unserilize($mapping);
//            $post_pram = array(); 
//            foreach($array_mapped as $gem_key => $sp_key) {
//                $post_pram[$sp_key] = isset($users[$gem_key]) ? $users[$gem_key] : $gem_key ; 
//            }
//        }


        $users = array(
            "corp_email_id" => "akverma23@digitalindia.gov.in",
            "name" => "Abhishek", // Gem
            "groups" => array("Default DGS&D Group"), // default field for SP
            "employee_phone_number" => "9582630255",
            "custom_field_5" => "asdfasddf" //  like Ministy : Departmet -- from GeM
        );
        // echo json_encode($users)
        ;
        $curl = curl_init();
        $options = array(
            CURLOPT_URL => $curlurl,
            CURLOPT_HEADER => FALSE,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_POSTFIELDS => json_encode($users),
            CURLOPT_RETURNTRANSFER => TRUE
        );
        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);
        $err = curl_errno($curl);

        curl_close($curl);

        if ($err) {
            echo 'An error has occurred: ' . curl_error($curl) . PHP_EOL;
        } else {
            echo $response;
        };
        //print_r($curlresult);
    }

    /**
     * Add new corporate user.
     */
    function update() {

        $header = array('X-CORPORATE-TOKEN:7fc92c6f15bc437c9d99ede2a17556a8', 'Content-Type:application/json');

        $users = array(
            "corp_email_id" => "akverma@digitalindia.gov.in",
            "phone_number" => "9898989898"
        );
        // echo json_encode($users)
        ;
        $curl = curl_init();
        $options = array(
            CURLOPT_URL => "http://sandbox-t.olacabs.com/v1/api/corporate/user",
            // CURLOPT_HEADER => TRUE,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_POSTFIELDS => json_encode($users),
            CURLOPT_RETURNTRANSFER => TRUE
        );
        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);
        $err = curl_errno($curl);

        curl_close($curl);

        if ($err) {
            echo 'An error has occurred: ' . curl_error($curl) . PHP_EOL;
        } else {
            echo $response;
        };
        //print_r($curlresult);
    }

    /**
     * Delete user 
     */
    function delete() {

        $curl = curl_init();

        $users = array(
            "corp_email_id" => "akverma@digitalindia.gov.in"
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://sandbox-t.olacabs.com/v1/api/corporate/user?corp_email_id=" . $_GET['corp_email_id'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_POSTFIELDS => json_encode($users),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: 575e3ef7-9f1d-f697-88c6-07b3ca2d7e2c",
                "x-corporate-token: 7fc92c6f15bc437c9d99ede2a17556a8"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    /**
     * get ride detils 
     * 
     */
    function get_rides() {

        $curl = curl_init();


        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://sandbox-t.olacabs.com/v1/api/corporate/rides?from_date=2017-08-01%2000%3A00%3A00&to_date=2017-08-24%2000%3A00%3A00",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "x-corporate-token: 7fc92c6f15bc437c9d99ede2a17556a8"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    function test_external_api() {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://completion.amazon.com/search/complete?search-alias=aps&client=amazon-search-ui&mkt=1&q=facebook",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: f1e0a6ee-d372-b99f-25c6-902f36be28a3"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    /**
     * 
     * @param type $api : Api Object
     * @param type $user : User Array user spot_users table
     */
    function call_add_emp_api($api, $user) {
        $a = 0;
        $api_name = "add_emp";
        if (isset($api) && isset($user)) {
            $data['result'] = $api;
            $api_id = $data['result']->api_id;
            $data['api_type'] = $data['result']->api_name;
            $data['api_description'] = $data['result']->api_description;
            $data['method'] = $data['result']->api_method_type;
            $data['api_endpoint'] = $data['result']->api_endpoint;
            $data['api_params'] = unserialize($data['result']->api_params);
            $data['headers'] = unserialize($data['result']->api_headers);
            $data['api_fields_map_to_gem'] = unserialize($data['result']->api_fields_map_to_gem);
            $valid_user = $this->spot_model->chk_service_creator($api_id);
            $curlurl = html_entity_decode($data['api_endpoint']);  // "http://sandbox-t.olacabs.com/v1/api/corporate/user";
            if (!empty($data['headers']) && !empty($data['headers'])) {
                $header = array();

                foreach ($data['headers'] as $key => $val) {
                    $header[] = $key . ":" . $val;
                }
            }
            if (!empty($data['api_params']) && !empty($data['api_params'])) {
                $param = array();

                foreach ($data['api_params'] as $key => $val) {
                    /*
                      array(3) (
                      [param_vlaue] => (string) ss_name
                      [is_required] => (string) no
                      [api_fields_list] => (string) ss_name
                      )
                     */
                    if ($val['api_fields_list'] == "USER DEFINED") {
                        //get set value for api 
                        if ($key == "groups") {
                            $param[$key] = array(html_entity_decode($val ['param_vlaue']));
                        } else {
                            $param[$key] = html_entity_decode($val ['param_vlaue']);
                        }
                    } else {
                        // get value for $user array();
                        $param[$key] = html_entity_decode($user->$val['param_vlaue']);
                    }
                }
            }
            // insert into db if GET
//            $param = array();
//            foreach ($data['api_params'] as $key => $val) {
//                $param[] = $key . '=' . html_entity_decode($val);
//            }
            //$header = array('Content-Type:application/json');
            $curl = curl_init();
            $options = array(
                // CURLOPT_URL => $curlurl,
                CURLOPT_HEADER => TRUE,
                CURLOPT_CUSTOMREQUEST => strtoupper($data['method']),
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTPHEADER => $header,
                CURLOPT_RETURNTRANSFER => TRUE
            );
            if ($data['method'] == "POST") {
                // CURLOPT_PORT => "3000",
                $options = array(
                    CURLOPT_URL => $curlurl,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode($param),
                    CURLOPT_HTTPHEADER => array(
                        "content-type: application/json"
                    ),
                );
            }
            if ($data['method'] == "GET") {
                $curlurl = $curlurl . '?' . implode('&', $param);
                $options [CURLOPT_URL] = $curlurl;
            }

            curl_setopt_array($curl, $options);

            $response = curl_exec($curl);
            $err = curl_errno($curl);
            $info = curl_getinfo($curl);
            curl_close($curl);

            if ($err) {
                //echo 'An error has occurred: ' . curl_error($curl) . PHP_EOL;
                return false;
            } else {
                $result = (json_decode($response)); // has 3 records 
                // update spot_user as status = 1 ; 
                $updated = $this->spot_model->set_active_spot_users($user->ss_id, $api->api_id);
                if ($updated) {
                    return 1;
                }
            };
            //print_r($curlresult);
        } else {
            echo "Error";
        }
    }

    /**
     * 
     * @param type $api_name
     * 
     */
    function call_my_api($api_name = "") {
        $a = 0;
        $data['result'] = $this->spot_model->get_api_details_by_type($api_name, $this->u_id);
        if ($api_name == "get_ride_data" && count($data['result']) > 0) {
            $api_id = $data['result'][0]->api_id;
            $data['api_type'] = $data['result'][0]->api_name;
            $data['api_description'] = $data['result'][0]->api_description;
            $data['method'] = $data['result'][0]->api_method_type;
            $data['api_endpoint'] = $data['result'][0]->api_endpoint;
            $data['api_params'] = unserialize($data['result'][0]->api_params);
            $data['headers'] = unserialize($data['result'][0]->api_headers);
            $data['api_fields_map_to_gem'] = unserialize($data['result'][0]->api_fields_map_to_gem);
            $valid_user = $this->spot_model->chk_service_creator($api_id);


            $curlurl = html_entity_decode($data['api_endpoint']);  // "http://sandbox-t.olacabs.com/v1/api/corporate/user";


            if (!empty($data['headers']) && !empty($data['headers'])) {
                $header = array();

                foreach ($data['headers'] as $key => $val) {
                    $header[] = $key . ":" . $val;
                }
            }
            if (!empty($data['api_params']) && !empty($data['api_params'])) {
                $param = array();

                foreach ($data['api_params'] as $key => $val) {
                    if ($this->input->post($key) !== "") {
                        $param[$key] = $key . '=' . trim($this->input->post($key)); // set by user 
                    } else {
                        $param[$key] = $key . '=' . trim($val['param_vlaue']); // defaut value 
                    }
                }
            }
            // insert into db if GET
//            $param = array();
//            foreach ($data['api_params'] as $key => $val) {
//                $param[] = $key . '=' . html_entity_decode($val['param_value']);
//            }
            // $header[] = 'Content-Type:application/json';
            $curl = curl_init();
            $options = array(
                // CURLOPT_URL => $curlurl,
                // CURLOPT_HEADER => TRUE,
                CURLOPT_CUSTOMREQUEST => strtoupper($data['method']),
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTPHEADER => $header,
                CURLOPT_RETURNTRANSFER => TRUE
            );
            if ($data['method'] == "POST") {
                $options [CURLOPT_POSTFIELDS] = json_encode($param);
                $options [CURLOPT_URL] = $curlurl;
            }
            if ($data['method'] == "GET") {
                $curlurl = $curlurl . '?' . implode('&', $param);
                $options [CURLOPT_URL] = str_replace(' ', '%20', $curlurl);
            }

            curl_setopt_array($curl, $options);

            $response = curl_exec($curl);
            $err = curl_errno($curl);



            curl_close($curl);

            if ($err) {
                echo 'An error has occurred: ' . curl_error($curl) . PHP_EOL;
            } else {
                $result = (json_decode($response)); // has 3 records 
                $mapping = $data['api_fields_map_to_gem'];
                $rows = $this->insert_data_with_mapping($result, $mapping);
                echo $rows . "Inserted";
            };
            //print_r($curlresult);
        } else {
            echo "No Record Found";
        }
    }

    /**
     * 
     * @param type $provider_id : If provider_id in not null,  will be send user data
     * @return type
     */
    function call_add_emp_all_sp($provider_id = null) {
        //Select All users with  users staus = 0
        $pending_users = $this->spot_model->get_pending_spot_users($provider_id);
        $apis = $this->spot_model->get_api_details_by_type("add_emp");
        // Select All API. check if bulk_offer
        // prepare bulk array
        // else // 
        // prepare single array 
        // call api
        //Sucess => updated users status = 1
        $u = 0;
        foreach ($pending_users as $key => $user) {
            foreach ($apis as $api) {
                $res = $this->call_add_emp_api($api, $user);
                if ($res) {
                    $u++;
                }
            }
        }
        $res = array('sucess' => 1, 'total' => $u);
        return json_encode($res);
    }

    function api_tnc() {
        $data['title'] = "Terms and Conditions.";
        $this->load->view('../../__inc/header_market', $data);
        $this->load->view('api_tnc', $data);
        $this->load->view('../../__inc/common_footer', $data);
    }

    function insert_data_with_mapping($result, $mapping) {
        $insert_data = array();
        $insert = array();
        // Find the Iterable Array/Object
        //   [0] => (string) 0.results.0.crn -- just analyze first fields \
        $key_exp = explode(".", $mapping ['api_fields_list'][0]);
        //0.results.0.abc.0.field -- shift 4 (0.results.0.abc.)
        //0.0.abc.0.field -- shift 3 fields (0.0.abc)
        //abc.0.field --shift onle field (abc)
        //0.field -- no need to shift array
        if (count($key_exp) > 2) { // if data exists in nested level.
            array_pop($key_exp);
            array_pop($key_exp);
        }
        $data_object = $result;
        foreach ($key_exp as $index) {
            if (is_array($data_object) && array_key_exists($index, $data_object)) {
                $data_object = $data_object [$index];
            } else if (is_object($data_object) && property_exists($data_object, $index)) {
                  
                $data_object = $data_object->{$index};
            }
        }
//        if (is_array($result)) {
//            $data_object = $result [$key_exp[count($key_exp) - 1]];
//        } else if (is_object($result)) {
//            $data_object = $result->{$key_exp[count($key_exp) - 1]};
//        }

        foreach ($data_object as $key => $value) { // loop through each result
            unset($insert);
            foreach ($mapping['gem_field'] as $key => $gem_fields) { // loop through each mpping fields. 
                // $caller = str_replace(".0." , "[0]->" , $mapping['api_fields_list'][$key]);
                $caller = explode(".", $mapping['api_fields_list'][$key]);
                $pop = array_pop($caller);
//                $v = $value;
//                $prop = $caller[count($caller) - 1];
//                $v = $v->{$prop};
//                foreach ($caller as $prop) {
//                    if ($prop == "0") {
//                        $v = $v[$prop];
//                    } else {
//                        $v = $v->{$prop};
//                    }
//                }
//
                if (is_array($value)) {
                    $insert[$gem_fields] = $value[$pop];
                } else if (is_object($value)) {
                    $insert[$gem_fields] = $value->{$pop};
                }
                // $insert[$gem_fields] = $v;
                $insert['ssr_provider_id'] = $this->u_id;
            }
            $insert_data[] = $insert;
        }
        $this->spot_model->insert_data_with_mapping($insert_data);
    }

//    function test_tran() {
//        $this->db->trans_begin();
//        $spot_users_data = array( 'name' => rand_string(8));
//      
//        $this->db->insert('test', $spot_users_data);
//
//        $this->load->library('table');
//        
//        $res = $this->db->select('*')->from('test')->get()->result();
//        
//
//        print_r($res);
//
//  
//       $this->db->trans_rollback();
//       test sucess ! we can show data from table without actually inserting into. as Preview to uses. and roll back 
//       I user satisfied with outout the same query will be called and executed. 
//       
//    }

    /* function get_child($obj, $sep = "-") {
      // alert(typeof (obj));
      $a = 1;
      $select = array();


      //  alert("this is object");
      foreach ($obj as $key => $val) {
      if (is_object($obj[$i]) && $obj[$i] !== null) {
      $sep = $sep . "x" . $i;
      // alert(sep);
      $parent += "[" + $i + "]"; // set parent object will add in else part.
      //  alert("parent " + parent);
      $this->get_child($obj[$i], $sep); // Recurcive call
      } else {
      //select.push( parent + i + ":" + obj[i]);
      array_push($select , $parent + "."  );

      }
      }


      //console.log(select);
      return $select;
      }
     * 
     */

    function check_ip() {
        $data['title'] = "Check IP While-Listing";
        if ($this->input->post()) {
            $host = $this->input->post('host');
            $port = $this->input->post('port');
           $msg =  $this->check_port($host, $port);
              $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable"> ' . $msg . ' </div>');
           
        }
        $this->load->view('../../__inc/header_market', $data);
        $this->load->view('check_ip', $data);
        $this->load->view('../../__inc/common_footer', $data);
    }

    /**
     * 
     * @param type $host
     * @param type $port
     */
    function check_port($host, $port) {


        $timeout = 10;

        // Try and connect
        if ($sock = fsockopen($host, $port, $errNo, $errStr, $timeout)) {
            // Connected successfully
            $up = TRUE;
            fclose($sock); // Drop connection immediately for tidiness
        } else {
            // Connection failed
            $up = FALSE;
        }

        // Display something    
        if ($up) {
            return "The server at $host:$port is up and running :-D";
        } else {
            return  "I couldn't connect to the server at $host:$port within $timeout seconds :-(<br>\nThe error I got was $errNo: $errStr";
        }
    }

}

?>
