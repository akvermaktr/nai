<?php

class Order extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('session', 'tcpdf', 'Pdf', 'email', 'Sms_lib', 'pagination', 'form_validation', 'Csrf_custom', 'user_agent'));
        $this->load->model(array('spot_model', 'carlisting/carlist_model', 'service/service_model'));
        $this->load->helper(array('url', 'date', 'security'));

      
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
        $this->invoice_status = array(
            0 => 'draft', //Seller can change this status
            1 => 'pending', // Pending as SP end
            2 => 'confirmed', // Seller -> confirmed 
            3 => 'recommended for payment', // Buyer
            4 => 'paid' // DDO
        );
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
        return false;
    }

    public function finalorderspot($trail_id = NULL) {
        if (!$this->u_id) {
            redirect('/auth/login');
        }
        $data = array();
        //For CSRF
        $this->load->library('Csrf_custom');
        if ($this->input->post() && $this->csrf_custom->check_valid('post') == false) {

            $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissable"><i class="fa fa-warning"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><b>Try Again!</b> You are doing something wrong.</div>');
            //            redirect('/payauthority/orderlist/' . $org_id);
        }
        $data['csrf_name'] = $this->csrf_custom->get_token_name();
        $data['csrf_hash'] = $this->csrf_custom->get_token_hash();
        //END For CSRF
        $data['booked_no'] = random_string('alnum', 10);
        $data['sess_name'] = $this->u_name;
        $data['title'] = "Place Order";
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['trail_id'] = $trail_id;
        $data['booked_data'] = $this->carlist_model->get_booked_detail_spot($trail_id);
        $data['comparision_data'] = $this->carlist_model->get_comparision_detail_spot($trail_id);
        $data['alreadybooked'] = $this->carlist_model->get_order_status($trail_id);
        $data['order_id'] = $this->carlist_model->get_order_id();

        $data['booked_no'] = "GEM-" . date('Y') . "-TS." . strtoupper(substr($data['booked_data']->service_type, 0, 1)) . "H-" . $data['booked_data']->booker_id . "-" . ($data['order_id']->order_id + 1);
        $this->load->view('../../__inc/header_market', $data);
        $this->load->view('place_order_steps_1', $data);
        $this->load->view('../../__inc/common_footer', $data);
    }

    public function finalorder_add_spot() {

        if ($this->input->post()) {

            $data['order_no'] = $this->input->post('order_no');
            $data['car_od_id'] = $this->input->post('trailid');
            $data['car_or_startdate'] = $this->input->post('start_date');
            $data['car_or_enddate'] = $this->input->post('end_date');
            $data['status'] = 'FA Uploaed'; //Step 1 : FA UPod , Step : 2 User Added; step = 3 : Completed // 'Completed!'; // Append new stage--  {Uploaded Financial approval File
            $data['approval_id'] = $this->input->post('approval_id');
            $data['or_placed_by'] = $this->u_id;

            $data['or_placed_by_email'] = $this->service_model->get_end_users($this->u_id);
            $data['or_placed_for'] = implode(",", $this->input->post('end_user'));
            $data['spot_gem_users'] = $this->spot_model->get_userdata_for_spot($this->input->post('end_user'));
            $this->spot_model->add_spot_users($data['spot_gem_users']);
            $data['or_PayAuthroty'] = $this->input->post('ddPayAuthroty');
            $data['approved_by'] = $this->input->post('approval_by');
            $data['quantity'] = 0;
            $data['approvedfilename'] = 'financial_' . $data['order_no'] . '.pdf';

            $data['remarks'] = $this->input->post('remarks');

            $save = $this->carlist_model->addorderspot($data);
            $company_nm = $this->carlist_model->gettraildetailspot($this->input->post('trailid'));
            if ($save) {
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable"><i class="fa fa-success"></i>Order Created! Please ADD More Users other. Who is not registered on GeM  <strong>' . $company_nm->u_firstname . '</strong> ' . '</div>');
                // ADD Additional NON-GeM Users.
                redirect('/spothiring/order/add_spot_users/' . $data['order_no']);
            }
        }
    }

    function index() {
        $this->load->view('../../__inc/header_market', $data);
        $this->load->view('place_order_steps_1', $data);
        $this->load->view('../../__inc/common_footer', $data);
    }

    function add_spot_users($order_trail_id = "") {
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
                        'ss_department' => $insert_data['department'][$key],
                        'ss_order_id' => $order_trail_id
                    );
                    $spot_users_data[] = $insert;
                }

                $save = $this->spot_model->add_spot_users($spot_users_data);

                if (isset($save)) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable">Users Added Successfully.</div>');
                    redirect('/spothiring/order/viewCarOrderDetails/' . $order_trail_id); // redirect to Next Step >> 
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
            $this->load->view('add_spot_users', $data); //same as 
            $this->load->view('../../__inc/common_footer', $data);
        } else {
            redirect('/auth/login');
        }
    }

    function viewCarOrderDetails($orderno) {
        if (isset($this->u_id) && $this->u_id != '') {
            if (in_array('16', $this->role_id)) {
                $CheckOrder = $this->carlist_model->checkOrderByProvider($this->u_id, $orderno);
            } else {
                $CheckOrder = $this->carlist_model->checkOrderByUser($this->u_id, $orderno);
            }

            if ($this->input->post()) { //Submiting Form 
                $is_agree = $this->input->post('agree');

                if ($is_agree === "agree") {
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable">Thnak You!</div>');
                    $this->step4($orderno);
                    //redirect('/spothiring/order/step4/' . $order_trail_id); // redirect to Next Step >> 
                }
            }
            if (!empty($CheckOrder->order_id)) {
                $data['site_domain'] = $this->site_domain;
                $data['site_name'] = $this->site_name;
                $data['sess_name'] = $this->u_name;
                $data['user_id'] = $this->u_id;
                $data['title'] = "Order Summary";
                $data['page_title'] = 'Order Summary';
                $data['billcycletbl'] = '';

                // select all from service_orders and
                $sumry = $this->carlist_model->viewOrderDetails($orderno);
                $data['spot_user'] = $this->spot_model->get_spot_users_by_order_id($orderno);
                $data['demand_accounting'] = $this->carlist_model->get_demand_accounting($sumry['orderdata']->car_od_id);

                // select all form service_order_transactions ; 
                $data['demand_data'] = $this->carlist_model->get_demand($sumry['orderdata']->car_od_id);
                if (isset($sumry) && $sumry != '' && count($sumry) >= 1) {

                    $data['summary'] = $this->getorderdetails($sumry);

                    //$data['bookerDetails'] = $this->supplier_model->viewUserDetails($data['user_id']);
                    $file = $this->upload_files . 'upload/service/financialApproval/financial_' . $orderno . '.pdf';
                    $file1 = $this->upload_files . 'upload/service/unsigned_financialApproval/financial_' . $orderno . '.pdf';

                    if (file_exists($file)) {
                        $data['apprFileOK'] = 1;
                    } else if (file_exists($file1)) {
                        $data['apprFileOK'] = 1;
                    } else {
                        $data['apprFileOK'] = 0;
                    }

                    $userId = $this->nehbr_auth->get_user_id();
                    $res = $this->db->select('GROUP_CONCAT(ur_role) as roles')->from('user_roles')->where('ur_user_id', $userId)->get()->result();

                    // $data['billcycletbl'] = $this->getbillcyclelist($orderno);
                    //$data['commitment'] = $this->getBudgetCommitment($orderno);
                    //$userroleee = $this->session->userdata('userrole');
                    //$NewRole = $userroleee['roleid'];


                    $data['userRole'] = $res[0]->roles;
                    $data['service_type'] = $serviceType = $data['summary']['orderdata']->service_type;
                    if ($serviceType != 'spot') {
                        $bookerid = $data['summary']['orderdata']->or_placed_by;
                        $providerid = $data['summary']['providerId'];

                        //  $data['driverData'] = $this->carlist_model->getCarDriverDetails($orderno, $this->u_id, $bookerid, $providerid);
                    }
                } else {
                    $data['noorder'] = 'No such order found.';
                }
                $this->load->view('../../__inc/header_market', $data);
                $this->load->view('place_order_steps_3', $data);
                $this->load->view('../../__inc/common_footer', $data);
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable"><i class="fa fa-success"></i>You are not authorised to access this order.</div>');
                if (in_array('16', $this->role_id))
                    redirect('/serviceprovider/provider/order');
                else
                    redirect('/carlisting/final_order');
            }
        } else {

            redirect('/auth/login');
        }
    }

    function step2() {
        $this->load->view('../../__inc/header_market', $data);
        $this->load->view('place_order_steps_2', $data);
        $this->load->view('../../__inc/common_footer', $data);
    }

    function step3() {
        $this->load->view('../../__inc/header_market', $data);
        $this->load->view('place_order_steps_3', $data);
        $this->load->view('../../__inc/common_footer', $data);
    }

    /**
     * Display Thank You Message 
     * Update Order Status = User Added 
     * Insert into Notification log table and Start Sending request to all SP using AJAX. 
     * 
     */
    function step4($order_id) {
        if ($this->input->post()) {
            $a = 0;
            $this->spot_model->update_order_status($order_id, "Completed!");
            //Get all users of this order with status 
            $this->spot_model->insert_linked_api($order_id);
            redirect('/spothiring/order/step4/' . $order_id);
        }
        $this->load->view('../../__inc/header_market', $data);
        $this->load->view('place_order_steps_4', $data);
        $this->load->view('../../__inc/common_footer', $data);
    }

    public function getorderdetails($sumry) {


        $orderno = $sumry['orderdata']->order_no;
        $trailid = $sumry['orderdata']->trail_id;
        $data['bookForId'] = $bookForId = $sumry['bookForId'];
        $data['bookerId'] = $bookerId = $sumry['bookerId'];
        $data['providerId'] = $providerId = $sumry['providerId'];
        $data['orderdata'] = $orderdata = $sumry['orderdata'];
        if (isset($bookForId) && $bookForId != '') {
            $data['EndUser_id'] = explode(",", $bookForId);
            $data['bookedfor_details'] = $this->carlist_model->getForUserDetailsview($bookForId, $orderno);
        }
        if (isset($trailid) && $trailid != '') {
            $data['bidra'] = $this->carlist_model->getbidrabytrail($trailid);
        }

        if (isset($bookerId) && $bookerId != '') {
            $data['booker_details'] = $this->carlist_model->getUserDetails($bookerId);
        }

        if (isset($providerId) && $providerId != '') {
            $data['provider_details'] = $this->carlist_model->getServiceProviderDetails($providerId);
        }
        if ($orderdata->service_type != "spot") {
            $payAuthId = $orderdata->or_PayAuthroty;
            $data['payAuth_details'] = $this->carlist_model->getUserDetails($payAuthId);
        }
        return $data;
    }

    function getbillcyclelist($orderno) {
        $this->isSessionUser();
        $billlist = $this->carlist_model->getOrderBillCycleList($orderno);

        if (!empty($billlist)) {
            $this->load->library('table');
            $this->table->set_heading('Bill No', 'Bill Start Date', 'Bill End Date', 'Bill Cycle Date', 'Days Count For Bill', 'Bill Adjustment With Bill No');
            $tmpl = array('table_open' => '<div class="table-responsive"><table class="table table-bordered table-striped table-hover">', 'table_close' => '</table> </div>');

            $this->table->set_template($tmpl);

            $i = 0;
            foreach ($billlist as $row) {
                //echo "<pre>"; print_r($row); echo "</pre>";
                if ($row->billcycle_day == 32) {
                    $row->billcycle_day = 'Month End';
                } else {
                    $row->billcycle_day = $row->billcycle_day;
                }
                $this->table->add_row($row->billcycle_no, date('d-m-Y', $row->bill_cycle_start_date), date('Y-m-d', $row->bill_cycle_end_date), $row->billcycle_day, $row->daycount_for_bill, $row->adjustbill_billcycle_no);
            }
            $res = $this->table->generate();
        } else {
            $res = "Billing Cycle Not Applied.";
        }
        return $res;
    }

    function getBudgetCommitment($order_id) {
        $commitment = $this->carlist_model->getBudgetCommitment($order_id);
        $this->load->library('table');
        $this->table->set_heading('Start Date', 'End Date', 'Anticipated Extra KM (For All Vehicle)', 'Anticipated Extra Hrs (For All Vehicle)', 'Anticipated Toll/Parking (For All Vehicle)', 'Billed Amount', 'Unblock amount(Blocked-Draft)', 'Estimated Blocking', 'Action');
        foreach ($commitment as $row) {
            if (isset($row->sbc_fy_start) && isset($row->sbc_fy_end)) {
                $ttl_billed = $this->carlist_model->getTotalBilled($order_id, $row->sbc_fy_start, $row->sbc_fy_end);
            }
            $curr_time = strtotime(date('Y-m-d'));
            $start_date = strtotime(date($row->sbc_fy_start));
            if ($row->sbc_status == "committed" && $curr_time > $start_date) {
                $action = "<a href=''> Block Committed Budget </a> ";
            } else {
                $action = $row->sbc_status;
            }
            $total[] = $row->sbc_amt;
            $this->table->add_row(date('d-m-Y', strtotime($row->sbc_fy_start)), date('d-m-Y', strtotime($row->sbc_fy_end)), $row->anticipated_ex_km, $row->anticipated_ex_hr, $row->anticipated_toll, $ttl_billed[0]->bill_amount, $row->sbc_amt - $ttl_billed[0]->bill_amount, $row->sbc_amt, $action);
        }
        $this->table->add_row('', '', '', '', '', '', '<strong> Total </strong> ', array_sum($total), '');
        $template = array(
            'table_open' => '<table class="table table-bordered table-striped table-hover" style="width:100%">'
        );
        $this->table->set_template($template);
        $output = array(
            'table' => $this->table->generate(),
            'data' => $commitment
        );

        return $output;

        // print_r($commitment);
    }

    private function isSessionUser() {
        if (empty($this->u_id)) {
            redirect('auth/login');
        }
    }

    public function FAupload() {
        $this->sessionWithGovtUser();
        $demandid = $_POST['demand_id'];
        //------------------Check validity--of ---file--------------------

        $imgtype = $_FILES["file"]["type"];
        $fileSize = $_FILES['file']['size'];
        $fileTypeMiME = $imgtype; // mime_content_type($_FILES['file']['tmp_name']);
        $fileName = $_FILES['file']['name'];
        $tmpName = $_FILES['file']['tmp_name'];

        $fileData = file_get_contents($tmpName);

        $pos = strpos($fileData, "</script>");
        $pos3 = strpos($fileData, "<script");
        $pos1 = strpos($fileData, "<?php");
        $pos4 = strpos($fileData, "<?xml");
        $pos2 = strpos($fileData, "<html");

        $CheckConnt = false;
        if ($pos === false && $pos1 === false && $pos2 === false && $pos3 === false) {
            $CheckConnt = true;
        }

        $ext = $this->GetImageExtension($imgtype);
        $doubleext = explode(".", $fileName);
        $doubleextCnt = count($doubleext);

        if ($CheckConnt == true && $ext == ".pdf" && $fileSize > 0 && $doubleextCnt == 2 && (strtolower($fileTypeMiME) == "application/pdf" || strtolower($fileTypeMiME) == "application/force-download")) {
            
        } else {
            $errorMessage = "Blank file or file type is not valid, please upload only pdf file.";
            $returnData['return_message'] = $errorMessage;
            $returnData['error'] = TRUE;
            $returnData['success'] = FALSE;
//            echo "vinay";
//              print_r($returnData,true);  
            echo json_encode($returnData);
            die();
        }
        //------------------Check validity-------------------------
//          $fileTypeMiME = mime_content_type($_FILES['file']['tmp_name']);
        $proImgDir = $this->upload_files . 'upload/service/unsigned_financialApproval/';
        $newImgPath = 'financial_' . $demandid . '.pdf';
        $target_file = $proImgDir . $newImgPath;
        $sts = move_uploaded_file($tmpName, $target_file);

        if (0 < $_FILES['file']['error']) {
//                         echo 'Error: ' . $_FILES['file']['error'] . '<br>';
            $returnData['return_message'] = $_FILES['file']['error'];
            $returnData['error'] = TRUE;
            $returnData['success'] = FALSE;
            echo json_encode($returnData);
        } else {
            move_uploaded_file($_FILES['file']['tmp_name'], $target_file);
            $errorMessage = "File has been uploaded successfully";
            $returnData['return_message'] = $errorMessage;
            $returnData['error'] = FALSE;
            $returnData['success'] = TRUE;
            $returnData['filename'] = $newImgPath;
            $this->load->library('esign_libprod');
            $uid = $this->u_id;
            $resp = $this->esign_libprod->genereate_otp($uid);
            echo $resp;
        }
    }

    /**
     * Dispay as First TAB
     * @param type $order_id
     */
    function view_all_rides($order_id) {
        $spot_users = $this->spot_model->get_rides_by_id($order_id);
        $data['order_no'] = $order_id;
        $this->load->library('table');
        $this->table->set_heading('Sl. No.', 'Unuque ID', 'Email ', 'Mobile', 'Pickup From', 'Distance');
        $tmpl = array('table_open' => '<div class="table-responsive"><table id="example1"  class="table-striped table table-bordered">', 'table_close' => '</table> </div>');

        $this->table->set_template($tmpl);
        $i = 0;
        foreach ($spot_users as $ress) {
            $i++;
            $this->table->add_row($i, $ress->ssr_unique_id, $ress->ssr_user_email, $ress->ssr_user_mobile, $ress->ssr_pickup_location, $ress->ssr_distance);
        }

        $data['spot_users'] = $this->table->generate();

        $this->load->view('../../__inc/header_market', $data);
        $this->load->view('view_all_rides', $data);
        $this->load->view('../../__inc/common_footer', $data);
    }

    /**
     * Display as 2nd Tab
     * @param type $order_id
     */
    function view_pending_rides($order_id) {
        $spot_users = $this->spot_model->get_pending_rides_by_id($order_id);
        if ($this->input->post('from_date') !== null && $this->input->post('from_date') !== null) {
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
        }
        $data['order_id'] = $order_id;
        $this->load->library('table');
        $this->table->set_heading('Sl. No.', 'Unuque ID', 'Email ', 'Start Time ', 'End Time  ', 'Mobile', 'Pickup From', 'Distance');
        $tmpl = array('table_open' => '<div class="table-responsive"><table id="example1"  class="table-striped table table-bordered">', 'table_close' => '</table> </div>');

        $this->table->set_template($tmpl);
        $i = 0;
        foreach ($spot_users as $ress) {
            $i++;
            $this->table->add_row($i, $ress->ssr_unique_id, $ress->ssr_user_email, $ress->ssr_pickup_time, $ress->ssr_droping_time, $ress->ssr_user_mobile, $ress->ssr_pickup_location, $ress->ssr_distance);
        }

        $data['spot_users'] = $this->table->generate();

        $this->load->view('../../__inc/header_market', $data);
        $this->load->view('view_pending_rides', $data);
        $this->load->view('../../__inc/common_footer', $data);
    }

    /**
     * Display as 3rd Tab
     * @param type $order_id
     */
    function view_billed_rides($order_id, $invoice_id = null) {
        $spot_users = $this->spot_model->get_billed_rides_by_id($order_id, $invoice_id);
        $data['order_id'] = $order_id;
        $this->load->library('table');
        $this->table->set_heading('Sl. No.', 'Unuque ID', 'Email ', 'Mobile', 'Pickup From', 'Distance');
        $tmpl = array('table_open' => '<div class="table-responsive"><table id="example1"  class="table-striped table table-bordered">', 'table_close' => '</table> </div>');

        $this->table->set_template($tmpl);
        $i = 0;
        foreach ($spot_users as $ress) {
            $i++;
            $this->table->add_row($i, $ress->ssr_unique_id, $ress->ssr_user_email, $ress->ssr_user_mobile, $ress->ssr_pickup_location, $ress->ssr_distance);
        }

        $data['spot_users'] = $this->table->generate();

        $this->load->view('../../__inc/header_market', $data);
        $this->load->view('view_billed_rides', $data);
        $this->load->view('../../__inc/common_footer', $data);
    }

    /**
     * Display table of invoice
     * @param type $order_id
     */
    function view_invoices($order_id) {
        $spot_users = $this->spot_model->get_invoices_by_id($order_id);
        $this->load->library('table');
        $data['order_no'] = $order_id;
        $this->table->set_heading('Sl. No.', 'Invoice ID', 'Invoice Date', 'Ride From Date', 'Ride To Date', 'Tax', 'Total Amount', 'Payment Status', 'Action');
        $tmpl = array('table_open' => '<div class="table-responsive"><table id="example1"  class="table-striped table table-bordered">', 'table_close' => '</table> </div>');

        $this->table->set_template($tmpl);
        $i = 0;
        foreach ($spot_users as $ress) {
            $i++;
            $this->table->add_row($i, "<a href='/spothiring/order/view_billed_rides/$order_id/$ress->ssi_id' >" . $ress->ssi_id . "</a>", $ress->ssi_created_on, $ress->ssi_from_date, $ress->ssi_to_date, $ress->ssi_tax, $ress->ssi_amount, $this->invoice_status[$ress->ssi_status], '<a href="/spothiring/order/view_invoice_details/' . $order_id . '/' . $ress->ssi_id . '"> View Invoice Details</a> | <br/>' .
                    '<a href="/spothiring/order/invoice_process/' . $order_id . '/' . $ress->ssi_id . '" title="Send Invoice to Buyer for Payment"> Process </a> | <br/>');
        }

        $data['spot_users'] = $this->table->generate();

        $this->load->view('../../__inc/header_market', $data);
        $this->load->view('view_invoices', $data);
        $this->load->view('../../__inc/common_footer', $data);
    }

    /**
     * If from date and to date given, invoice will be generated only of that date range 
     * otherwise it will auto-detect the billing cycle wise invoice.
     * @param type $order_id
     * @param type $from_date: optional
     * @param type $to_date:optional
     */
    function generate_invoice($order_id) {

        if ($order_id == NULL) {
            redirect('/serviceprovider/provider/order');
        }
        if ($this->input->post('from_date') !== null && $this->input->post('from_date') !== null &&
                $this->input->post('from_date') !== "" && $this->input->post('from_date') !== "") {
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
        } else {
            redirect('/spothiring/order/view_pending_rides/' . $order_id);
        }
        $data['order_details'] = $this->spot_model->viewOrderDetails($order_id);
        $data['buyer_details'] = $this->spot_model->user_details($data['order_details'] [0]->or_placed_by);

        $this->load->library('table');

        $price_log = $this->spot_model->get_fare_log_details();
        $this->table->set_heading('Sl. No.', 'Base Fare', 'Distance Fare', 'Per Min Fare', 'Distance Fare/KM', 'Free Min', 'Updated On ', 'State');
        $tmpl = array('table_open' => '<div class="table-responsive"><table id="example2"  class="table-striped table table-bordered">', 'table_close' => '</table> </div>');
        $this->table->set_template($tmpl);
        $j = 0;
        foreach ($price_log as $ress) {
            $total = $this->cal_fare($distance, $travel_time, $waiting_time, $fare_rule);
            $this->table->add_row($j + 1, $ress->base_fare, $ress->extrapriceperkm, $ress->extrapricepermin, $ress->free_km, $ress->free_min, $ress->created_date, $ress->s_reg_state);
            $j++;
        }
        $data['price_log'] = $this->table->generate();
        $spot_users = $this->spot_model->get_pending_rides_by_id($order_id);

        if (count($spot_users) == 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissable"><i class="fa fa-warning"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><b>Try Again!</b> No Ride Data available to generate Invoice. Please Fetch latest ride data.</div>');
        }
        $data['order_id'] = $order_id;

        $this->table->set_heading('Sl. No.', 'ID', 'Name', 'Email', 'Mobile', 'Pickup Time', 'Drop Time', 'Pickup Location', 'Distance', 'Total');
        $tmpl = array('table_open' => '<div class="table-responsive"><table id="example1"  class="table-striped table table-bordered">', 'table_close' => '</table> </div>');

        $this->table->set_template($tmpl);
        $i = 0;
        $sub_total = 0;
        foreach ($spot_users as $ress) {
            $i++;
            if ($i == 1) {
                $data['from_date'] = $ress->ssr_pickup_time;
            }
            if ($i == count($spot_users)) {
                $data['to_date'] = $ress->ssr_droping_time;
            }
            $travel_time = round(abs(strtotime($ress->ssr_droping_time) - strtotime($ress->ssr_pickup_time)) / 60, 2);
            $waiting_time = 0;
            $total = $this->cal_fare($ress->ssr_distance, $travel_time, $waiting_time, $price_log[0]);
            $this->table->add_row($i . "<input name=ride_id[]  type='hidden' value='" . $ress->ssr_id . "' />", $ress->ssr_unique_id, $ress->ssr_name, $ress->ssr_user_email, $ress->ssr_user_mobile, $ress->ssr_pickup_time, $ress->ssr_droping_time, $ress->ssr_pickup_location, $ress->ssr_distance, $total);
            $sub_total += $total;
        }
        $data['sub_total'] = $sub_total;
        $data['spot_users'] = $this->table->generate();

        $this->load->view('../../__inc/header_market', $data);
        $this->load->view('generate_invoice', $data);
        $this->load->view('../../__inc/common_footer', $data);
    }

    /**
     * Change invoice status to next step for payment process by Buyer
     * And Also send notification. 
     * @param type $order_id
     * @param type $invoice_id
     *  $this->invoice_status = array(
            0 => 'draft', //Seller can change this status
            1 => 'pending', // Pending as SP end
            2 => 'confirmed', // SP -> confirmed 
            3 => 'recommended for payment', // Buyer
            4 => 'paid' // DDO
        );
     */
    function invoice_process($order_id = NULL, $invoice_id = NULL) {
        $status = $this->spot_model->get_invoice_status($order_id, $invoice_id);

        if (($status == 0 || $status == NULL) && in_array(16, $this->role_id)) {
            // changs status to next step
            $u_status = $this->spot_model->set_invoice_status($order_id, $invoice_id, 2); // == draft skiping 1 because invoce is generated by sp
            $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissable"><i class="fa fa-warning"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><b>Done!</b> Invoice send to Buyer for further process.</div>');
        } else if ($status == 2 && in_array(3, $this->role_id)) {
            // payment is undre proces to Buery
            $u_status = $this->spot_model->set_invoice_status($order_id, $invoice_id, 3); // == confirmed by sp
            $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissable"><i class="fa fa-warning"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><b>In-process!</b> Invoice is under process.</div>');
        } else if ($status == 3 && in_array(20, $this->role_id)) {
            // changs status to next step
            $u_status = $this->spot_model->set_invoice_status($order_id, $invoice_id, 3);// == recommeded for payment
            // Also update status as "recommed for payment" in paymnet == 3
            
            $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissable"><i class="fa fa-warning"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><b>Done!</b> Invoice send to Buyer for further process.</div>');
        }

        redirect('/spothiring/order/view_invoices/' . $order_id . '/' . $invoice_id);
    }

    /**
     * Display details of generated invoice
     * @param type $order_id
     * @param type $invoice_id
     */
    function view_invoice_details($order_id = NULL, $invoice_id = NULL) {

        if ($order_id == NULL || $invoice_id == NULL) {
            redirect('/serviceprovider/provider/order');
        }

        $data['order_details'] = $this->spot_model->viewOrderDetails($order_id);
        $data['buyer_details'] = $this->spot_model->user_details($data['order_details'] [0]->or_placed_by);


        $this->load->library('table');

        $price_log = $this->spot_model->get_fare_log_details();
        $this->table->set_heading('Sl. No.', 'Base Fare', 'Distance Fare', 'Per Min Fare', 'Distance Fare/KM', 'Free Min', 'Updated On ', 'State');
        $tmpl = array('table_open' => '<div class="table-responsive"><table id="example2"  class="table-striped table table-bordered">', 'table_close' => '</table> </div>');
        $this->table->set_template($tmpl);
        $j = 0;
        foreach ($price_log as $ress) {
            $total = $this->cal_fare($distance, $travel_time, $waiting_time, $fare_rule);
            $this->table->add_row($j + 1, $ress->base_fare, $ress->extrapriceperkm, $ress->extrapricepermin, $ress->free_km, $ress->free_min, $ress->created_date, $ress->s_reg_state);
            $j++;
        }
        $data['price_log'] = $this->table->generate();

        $spot_users = $this->spot_model->get_invoice_details($order_id, $invoice_id);

        if (count($spot_users) == 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissable"><i class="fa fa-warning"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><b>Try Again!</b> No Ride Data available to generate Invoice. Please Fetch latest ride data.</div>');
        }
        $data['order_id'] = $order_id;

        $this->table->set_heading('Sl. No.', 'ID', 'Name', 'Email', 'Mobile', 'Pickup Time', 'Drop Time', 'Pickup Location', 'Distance', 'Total');
        $tmpl = array('table_open' => '<div class="table-responsive"><table id="example1"  class="table-striped table table-bordered">', 'table_close' => '</table> </div>');

        $this->table->set_template($tmpl);
        $i = 0;
        $sub_total = 0;
        foreach ($spot_users as $ress) {
            $i++;
            if ($i == 1) {
                $data['from_date'] = $ress->ssr_pickup_time;
            }
            if ($i == count($spot_users)) {
                $data['to_date'] = $ress->ssr_droping_time;
            }
            $travel_time = round(abs(strtotime($ress->ssr_droping_time) - strtotime($ress->ssr_pickup_time)) / 60, 2);
            $waiting_time = 0;
            $total = $this->cal_fare($ress->ssr_distance, $travel_time, $waiting_time, $price_log[0]);
            $this->table->add_row($i . "<input name=ride_id[]  type='hidden' value='" . $ress->ssr_id . "' />", $ress->ssr_unique_id, $ress->ssr_name, $ress->ssr_user_email, $ress->ssr_user_mobile, $ress->ssr_pickup_time, $ress->ssr_droping_time, $ress->ssr_pickup_location, $ress->ssr_distance, $total);
            $sub_total += $total;
        }
        $data['sub_total'] = $sub_total;
        $data['spot_users'] = $this->table->generate();

        $this->load->view('../../__inc/header_market', $data);
        $this->load->view('view_invoice_details', $data);
        $this->load->view('../../__inc/common_footer', $data);
    }

    function save_invoice_data() {
        $a = 0;
        if ($this->input->post()) {
            $ride_ids = $this->input->post('ride_id');
            $order_id = $this->input->post('order_id');

            $saved = $this->spot_model->update_pending_rides_by_id($this->input->post('order_id'), $ride_ids);
            if ($saved) {
                $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissable"><i class="fa fa-warning"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"> Invoice Gennerated for Order ID ' . $order_id . ' . ID# ' . $saved . '</div>');
                // redirect to invoice list page.
                redirect('/serviceprovider/provider/order');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissable"><i class="fa fa-warning"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"> Something went wrong.</div>');
            // redirect to invoice list page.
            redirect('/serviceprovider/provider/order');
        }
    }

    /**
      [0] => stdClass object {
      base_fare => (string) 10
      extrapriceperkm => (string) 10
      extrapricepermin => (string) 10
      free_km => (string) 10
      free_min => (string) 10
      created_date => (string) 2017-11-08 13:15:56
      s_reg_state => (string) 0
      }
     * @param type $distance
     * @param type $travel_time
     * @param type $waiting_time
     * @param type $fare_rule
     */
    function cal_fare($distance = 0, $travel_time = 0, $waiting_time = 0, $fare_rule) {
        $total_fare = $fare_rule->base_fare + $distance * $fare_rule->extrapriceperkm + $travel_time * $fare_rule->extrapricepermin;

        return $total_fare;
    }

}

?>
