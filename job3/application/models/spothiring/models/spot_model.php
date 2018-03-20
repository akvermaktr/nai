<?php

class Spot_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->prefix = $this->config->item('prefix');
        $this->car_listing = 'carlisting';
        $this->t_state = $this->config->item('prefix') . 'states_master';
        $this->t_city = 'city_master';
        $this->t_brand = 'c_brand';
        $this->t_model = 'c_model';
        $this->body_type_table = 'c_body_type';
        $this->fuel_table = 'tbl_fuel_type';
        $this->seat_pic = 'c_seat_pic';
        $this->car_od = 'car_orderservicedetail';
        $this->variant = 'c_variant';
    }

    function get_spot_users($offset = null) {
        $this->db->select(' DISTINCT(`ss_id`) AS ss_id, `ss_name`, `ss_mobile_no`, `ss_department`, `ss_email`, `ss_status`, `ss_order_id`');

        //$this->db->where();
        $this->db->from('service_spot_users ss');
        $this->db->join('service_spot_user_api_status sua', 'sua.sua_u_id = ss.ss_id ');
        $this->db->join('service_spot_api api', 'api.api_id = sua.sua_api_id');
        $this->db->where(array(
            'sua_status' => 1,
            'api_name' => 'add_emp',
            'api_sp_user_id' => $this->u_id,
        ));


        $this->db->order_by("ss_id", "ASC");
        // $this->db->limit($offset, 10);
        $query = $this->db->get();
        return $query->result();
    }

    function get_pending_spot_users($provider_id = null) {
        $this->db->select(' DISTINCT(`ss_id`) AS ss_id, `ss_name`, `ss_mobile_no`, `ss_department`, `ss_email`, `ss_status`, `ss_order_id`');
        $this->db->from('service_spot_users ss');
        $this->db->join('service_spot_user_api_status sua', 'sua.sua_u_id = ss.ss_id ');

        $this->db->join('service_spot_api api', 'api.api_id = sua.sua_api_id');
        $this->db->where(array('sua_status' => 0));
        if (isset($provider_id) && $provider_id !== null) {
            $this->db->where(array('api_sp_user_id' => $this->u_id));
        }
        $this->db->order_by("ss_id", "ASC");
        // $this->db->limit($offset, 10);
        $query = $this->db->get();
        return $query->result();
    }

    function set_active_spot_users($u_id, $api_id) {
        $this->db->where(array('sua_u_id' => $u_id));
        $updated = $this->db->update('service_spot_user_api_status', array('sua_status' => 1));
        return $updated;
    }

    function get_spot_users_by_order_id($order_id) {
        $this->db->select('*');
        $this->db->from('service_spot_users');
        $this->db->where(array('ss_order_id' => $order_id));
        $this->db->order_by("ss_id", "ASC");
        // $this->db->limit($offset, 10);
        $query = $this->db->get();
        return $query->result();
    }

    function get_spot_rides($offset = null) {
        $this->db->select('*');
        $this->db->from('service_spot_rides');
        $this->db->where(array('ssr_provider_id' => $this->u_id));
        $this->db->order_by("ssr_id", "ASC");
        // $this->db->limit($offset, 10);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Select All downloaded rides through  API, form service_spot_rides where provider_id is $this->u_id AND order_id
     * @param type $order_id
     * @return type
     */
    function get_rides_by_id($order_id) {
        $this->db->select('ssr.*');
        $this->db->from('service_spot_rides ssr');
        $this->db->join('service_spot_users ssu', 'ssu.ss_email = ssr.ssr_user_email');
        $this->db->join('service_orders so', 'ssu.ss_order_id = so.order_no');
        $this->db->where(array('ssr_provider_id' => $this->u_id, 'so.order_no' => $order_id));
        $this->db->order_by("ssr_id", "ASC");
        // $this->db->limit($offset, 10);
        $query = $this->db->get();
        return $query->result();
    }

    function get_fare_log_details() {
        $this->db->select('sl.base_fare, sl.extrapriceperkm, sl.extrapricepermin , sl.free_km , sl.free_min, sl.created_date , cs.s_reg_state');
        $this->db->from('spot_log sl');
        $this->db->join('carlisting_spothiring cs', 'cs.spot_id = sl.spot_id');

        $this->db->where('created_date', '2017-11-08 13:15:56', '<=');
        $this->db->order_by('created_date', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }

    function get_invoice_details($order_id = NULL, $invoice_id = NULL) {
        $this->db->select('ssr.*');
        $this->db->from('service_spot_rides ssr');
        $this->db->join('service_spot_users ssu', 'ssu.ss_email = ssr.ssr_user_email');
        $this->db->join('service_spot_invoiced_rides ssir', 'ssir.sir_ride_id = ssr.ssr_id');
        $this->db->join('service_spot_invoice ssi', 'ssi.ssi_id = ssir.sir_invoice_id');

        //service_spot_invoiced_rides
        $this->db->join('service_orders so', 'ssu.ss_order_id = so.order_no');
        $this->db->where(array(
            'so.order_no' => $order_id,
            'ssi.ssi_id' => $invoice_id
        )); // 0 == invoice not generated , 1 = invoice generated
        // $this->db->where_not_in('ssr_id', 'select sir_ride_id from service_spot_invoiced_rides' );
        $this->db->where("(ssr_provider_id = $this->u_id OR or_placed_by = $this->u_id)");
        $this->db->order_by("ssr_id", "ASC");
        // $this->db->limit($offset, 10);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * List of rides associated with a order id for logged in SP user. 
     * @param type $order_id
     * @param type $from_date
     * @param type $to_date
     * @return type
     */
    function get_pending_rides_by_id($order_id, $from_date = null, $to_date = null) {
        if ($this->input->post('from_date') !== null && $this->input->post('from_date') !== null && $this->input->post('from_date') !== "" && $this->input->post('from_date') !== "") {
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
        }
        $this->db->select('ssr.*');
        $this->db->from('service_spot_rides ssr');
        $this->db->join('service_spot_users ssu', 'ssu.ss_email = ssr.ssr_user_email');
        // $this->db->join('service_spot_invoiced_rides ssir', 'ssir.sir_ride_id = ssr.ssr_id', 'LEFT');
        //service_spot_invoiced_rides
        $this->db->join('service_orders so', 'ssu.ss_order_id = so.order_no');
        $this->db->where(array(
            'ssr_provider_id' => $this->u_id,
            'so.order_no' => $order_id
        )); // 0 == invoice not generated , 1 = invoice generated
        $this->db->where('ssr_id not in (select sir_ride_id from service_spot_invoiced_rides) ');
        //$this->db->where('ssir.sir_status is NULL ');
        if (isset($from_date) && isset($to_date)) {
            $this->db->where('ssr.ssr_pickup_time' . ' >= ' . "'" . date('Y-m-d', strtotime($from_date)) . "'");
            $this->db->where('ssr.ssr_pickup_time' . ' <= ' . "'" . date('Y-m-d', strtotime($to_date)) . "'");
        }
        $this->db->order_by("ssr_id", "ASC");
        // $this->db->limit($offset, 10);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * List of rides associated with a order id for logged in SP user. 
     * @param type $order_id
     * @param type $from_date
     * @param type $to_date
     * @return type
     */
    function update_pending_rides_by_id($order_id, $ride_ids) {
        $this->db->trans_begin();
        if ($this->input->post()) {

            //$insert_invoice_id = insert_into('invoice'); 


            $invoice_data = array(
                'ssi_order_id' => $order_id, //
                'ssi_amount' => $this->input->post('amount'),
                'ssi_from_date' => $this->input->post('from_date'),
                'ssi_to_date' => $this->input->post('to_date'),
                'ssi_tax' => $this->input->post('tax'),
                'ssi_created_by' => $this->u_id,
            );
            $this->db->insert('service_spot_invoice', $invoice_data);
            $invoice_id = $this->db->insert_id();
            // Also insert into bill_bueyr_draft table to merge with existing payment flow.
            // Status Should be Pending at Service Provider.
            // only difference is the Draft state will be changed by SP not Buyer.
            // Challenge: whenever status changes in this table need to updated in 
            // service_spot_invoice table also. 

            $bill_buyer_draft = array(
                'order_id' => $order_id,
                'bill_no' => $invoice_id,
                'bill_date' => date('Y-m-d H:i:s'),
                'bill_status' => 'pending',
                'bill_amount' => $invoice_data['ssi_amount']
            );
            $this->db->delete('service_bill_buyer_draft', array(
                'order_id' => $order_id,
                'bill_no' => $invoice_id,
            ));
            $this->db->insert('service_bill_buyer_draft', $bill_buyer_draft);
            // ALSO INSERT INTO provider_payment table 
            $provider_pay_data = array(
                'order_no' => $order_id,
                'bill_no' => $invoice_id,
                'orderplacedby_id' => $this->input->post('buyer_id'),
                'orderplacedfor_id' => $this->input->post('buyer_id'),
                'provider_id' => $this->u_id, // Service Provider id 
                'start_date' => $this->input->post('from_date'),
                'end_date' => $this->input->post('to_date'),
                'service_tax' => $this->input->post('tax'),
                'billing_date' => date('Y-m-d H:i:s'),
                'bill_amount' => $invoice_data['ssi_amount'],
                'payment_mode' => $this->get_payment_mode($this->input->post('buyer_id')),
                'request_status' => 0,
                'billing_date' => date('Y-m-d H:i:s'),
                'status' => 0
            );
            $this->db->insert('provider_payment', $provider_pay_data);

            $ride_invoice_data = array();
            //update service_spot_invoiced_rides
            foreach ($ride_ids as $ride_id) {
                $ride_invoice_data[] = array(
                    'sir_invoice_id' => $invoice_id,
                    'sir_ride_id' => $ride_id,
                    'sir_status' => 1
                );
            }
            $this->db->insert_batch('service_spot_invoiced_rides', $ride_invoice_data);
            //  $invoice_id = $this->db->insert_id();


            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return $invoice_id;
            }
        }
    }

    function get_billed_rides_by_id($order_id, $invoice_id) {
        $this->db->select('ssr.*');
        $this->db->from('service_spot_rides ssr');
        $this->db->join('service_spot_users ssu', 'ssu.ss_email = ssr.ssr_user_email');
        $this->db->join('service_orders so', 'ssu.ss_order_id = so.order_no');

        $where = array('ssr_provider_id' => $this->u_id, 'so.order_no' => $order_id);
        if (isset($invoice_id) && $invoice_id !== null) {
            $this->db->join('service_spot_invoiced_rides ssir', 'ssir.sir_invoice_id = ssr.ssr_id');
            $where['ssir.sir_invoice_id'] = $invoice_id;
            // $this->db->where('ssr_id in (select sir_ride_id from service_spot_invoiced_rides) ' );
        }
        $this->db->where('ssr_id in (select sir_ride_id from service_spot_invoiced_rides) ');
        $this->db->where($where);
        $this->db->order_by("ssr_id", "ASC");
        // $this->db->limit($offset, 10);
        $query = $this->db->get();
        return $query->result();
    }

    function get_invoices_by_id($order_id) {
        $this->db->select('ssi.*');
        $this->db->from('service_spot_invoice ssi');
        $this->db->join('service_orders so', 'ssi.ssi_order_id = so.order_no');
        $this->db->where(array('ssi.ssi_order_id' => $order_id));
        $this->db->where("(ssi_created_by = $this->u_id OR or_placed_by = $this->u_id)");
        $this->db->order_by("ssi_id", "ASC");
        // $this->db->limit($offset, 10);
        $query = $this->db->get();
        return $query->result();
    }

    function get_invoice_status($order_id, $invoice_id) {
        $this->db->select('ssi.ssi_status');
        $this->db->from('service_spot_invoice ssi');

        $this->db->where(array(
            'ssi.ssi_order_id' => $order_id,
            // 'ssi.ssi_created_by' => $this->u_id
            'ssi.ssi_id' => $invoice_id
        ));
        $this->db->order_by("ssi_id", "ASC");
        // $this->db->limit($offset, 10);
        $query = $this->db->get();
        return $query->result()[0]->ssi_status;
    }

    function set_invoice_status($order_id, $invoice_id, $status = 0) {

        $this->db->trans_begin();


        $update_data = array(
            'ssi_status' => $status,
        );
        $condition = array(
            'ssi_order_id' => $order_id,
            'ssi_id' => $invoice_id);
        $this->db->where($condition);
        $updated = $this->db->update('service_spot_invoice', $update_data);
        if ($status == 3) {
            $payment_req_data = array(
                'request_status' => '1'
                    );
            $this->db->where(array(
                'order_no' => $order_id,
                'bill_no' => $invoice_id
            ));
            $this->db->update('provider_payment', $payment_req_data);

            $bill_buyer_draft_status = array(
                'bill_status' => 'recommended for payment'
                    );
            $this->db->where(array(
                 'order_id' => $order_id,
                'bill_no' => $invoice_id
            ));
            $this->db->update('service_bill_buyer_draft', $bill_buyer_draft_status);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    function get_api_by_user($uid) {
        $this->db->select('*');
        $this->db->from('service_spot_api');
        $this->db->where(array('api_sp_user_id' => $uid));
//        $this->db->order_by("ss_id", "ASC");
        // $this->db->limit($offset, 10);
        $query = $this->db->get();
        return $query->result();
    }

    function get_api_details($api_id, $uid) {
        $this->db->select('*');
        $this->db->from('service_spot_api');
        $this->db->where(array('api_sp_user_id' => $uid, 'api_id' => $api_id));
//        $this->db->order_by("ss_id", "ASC");
        // $this->db->limit($offset, 10);
        $query = $this->db->get();
        return $query->result();
    }

    function get_api_details_by_type($api_name, $uid = null) {
        $this->db->select('*');
        $this->db->from('service_spot_api');
        $cond = array();
        if (isset($uid)) {
            $cond['api_sp_user_id'] = $uid;
        }
        if (isset($api_name)) {
            $cond['api_name'] = $api_name;
        }

        $this->db->where($cond);

        $query = $this->db->get();
        return $query->result();
    }

    function chk_service_creator($api_id) {
        $user_id = $this->u_id;
        $array = array('api_id' => $api_id, 'api_sp_user_id' => $user_id);
        $this->db->select('api_id')->from('service_spot_api');
        $this->db->where($array);

        $query = $this->db->get()->result();
        return $query[0]->api_id;
    }

    function add_new_api($user_id) {
        ///  echo $uid.$sescarservice_type;

        $this->db->trans_begin();
        if ($this->input->post()) {

            $param = array();
            $param_value = $this->input->post('pram_value');
            $is_required = $this->input->post('is_required');
            $api_fields_list = $this->input->post('api_fields_list');

            foreach ($this->input->post('pram_name') as $key => $val) {
                $param[$val] = array(
                    'param_vlaue' => html_entity_decode($param_value[$key]),
                    'is_required' => $is_required[$key],
                    'api_fields_list' => $api_fields_list[$key],
                );
            }

            $header = array();
            $header_value = $this->input->post('header_pram_value');
            foreach ($this->input->post('header_pram_name') as $key => $val) {
                $header[$val] = html_entity_decode($header_value[$key]);
            }


            $spotpost_data = array(
                'api_name' => $this->input->post('api_type'), //
                'api_sp_user_id' => $this->u_id,
                'api_description' => $this->input->post('api_description'),
                'api_method_type' => $this->input->post('method'),
                'api_endpoint' => $this->input->post('api_endpoint'),
                'api_headers' => serialize($header),
                'api_params' => serialize($param),
                'api_created_on' => date('Y-m-d H:i:s'),
                'api_updated_on' => date('Y-m-d H:i:s'),
                'api_fields_map_to_gem' => "",
                'api_sample_response' => $this->input->post('api_sample_response'),
            );
            $this->db->insert('service_spot_api', $spotpost_data);
            $carlisting_insert_id = $this->db->insert_id();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        }
        redirect('/carlisting/index');
    }

    function update_api_mapping($api_id) {


        $this->db->trans_begin();
        if ($this->input->post()) {



            $map_data = array();
            $map_data['gem_field'] = $this->input->post('gem_field');
            $map_data['api_fields_list'] = $this->input->post('api_fields_list');
            $map_data['data_type'] = $this->input->post('data_type');

            $spotpost_data = array(
                'api_updated_on' => date('Y-m-d H:i:s'),
                'api_fields_map_to_gem' => serialize($map_data),
            );
            $array = array('api_id' => $api_id);
            $this->db->where($array);
            $updated = $this->db->update('service_spot_api', $spotpost_data);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        }
        redirect('/carlisting/index');
    }

    function update_api($api_id) {

        $this->db->trans_begin();
        if ($this->input->post()) {

            $param = array();
            $param_value = $this->input->post('pram_value');
            $is_required = $this->input->post('is_required');
            $api_fields_list = $this->input->post('api_fields_list');

            foreach ($this->input->post('pram_name') as $key => $val) {
                $param[$val] = array(
                    'param_vlaue' => html_entity_decode($param_value[$key]),
                    'is_required' => $is_required[$key],
                    'api_fields_list' => $api_fields_list[$key],
                );
            }

            $header = array();
            $header_value = $this->input->post('header_pram_value');
            foreach ($this->input->post('header_pram_name') as $key => $val) {
                $header[$val] = html_entity_decode($header_value[$key]);
            }


            $spotpost_data = array(
                'api_name' => $this->input->post('api_type'), //
                'api_sp_user_id' => $this->u_id,
                'api_description' => $this->input->post('api_description'),
                'api_method_type' => $this->input->post('method'),
                'api_endpoint' => $this->input->post('api_endpoint'),
                'api_headers' => serialize($header),
                'api_params' => serialize($param),
                'api_updated_on' => date('Y-m-d H:i:s'),
                'api_fields_map_to_gem' => "",
                'api_sample_response' => serialize($this->input->post('api_sample_response'))
            );
            $array = array('api_id' => $api_id);
            $this->db->where($array);
            $updated = $this->db->update('service_spot_api', $spotpost_data);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        }
        redirect('/carlisting/index');
    }

    function insert_data_with_mapping($insert_data) {
        foreach ($insert_data as $values) {
            $this->db->select('ssr_unique_id');
            $this->db->from('service_spot_rides');
            $this->db->where(array('ssr_unique_id' => $values['ssr_unique_id']));
            $val = $this->db->get()->result();

            if (count($val) == 0) {
                $this->db->insert('service_spot_rides', $values);
            }
        }
    }

    /**
     * Build Array with user data ready to inserting in Spot table. 
     * 
     * Add exsiting GeM Register User to Autorized spot user table(
     * @param type $uid_array
     * @return type
     */
    function get_userdata_for_spot($uid_array) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where_in('u_id', $uid_array);
//        $this->db->order_by("ss_id", "ASC");
        // $this->db->limit($offset, 10);
        $result = $this->db->get()->result();
        $insert = array();
        foreach ($result as $key => $val) {
            $insert[] = array(
                'ss_name' => $val->u_firstname,
                'ss_mobile_no' => $val->u_mobile_no,
                'ss_email' => $val->u_email,
                'ss_department' => $val->u_dept_id
            );
        }
        return $insert;
    }

    function add_spot_users($spot_users_data) {
//         $insert_data = $this->input->post();
//         $insert = array();
//         $i = 0; 
        $this->db->insert_batch('service_spot_users', $spot_users_data);

//        foreach ($insert_data['user_name'] as $key => $values) {
//           /* $this->db->select('ss_id');
//            $this->db->from('service_spot_users');
//            $this->db->where(array('ss_mobile_no' => $insert_data['user_mobile'][$key], 'ss_email' => $insert_data['user_email'][$key]));
//            $val = $this->db->get()->result();
//            */
//            if(count($val) == 0 || 1 ) {
//                $i++; 
//                $insert  = array(
//                    'ss_name' => $insert_data['user_name'][$key],
//                    'ss_mobile_no' => $insert_data['user_mobile'][$key],
//                    'ss_email' => $insert_data['user_email'][$key],
//                    'ss_department' => $insert_data['department'][$key]                                        
//                );
//                 $this->db->insert('service_spot_users', $insert);
//                // unset($insert);
//            }
//        }
        /*
          if ($i > 0){
          return $i;
          }else {
          return false;
          } */
        return 1;
    }

    function update_order_status($order_id, $status) {
        $this->db->trans_begin();
        if (isset($order_id) && isset($status)) {
            $spotpost_data = array(
                'status' => $status
            );
            $array = array('order_no' => $order_id);
            $this->db->where($array);
            $updated = $this->db->update('service_orders', $spotpost_data);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        }
    }

    /**
     * Default status = 0 ;
     */
    function insert_linked_api($order_id) {
        $this->db->select('ss_id');
        $this->db->from('service_spot_users');
        $array_1 = array('ss_order_id' => $order_id);
        $this->db->where($array_1);
        $spot_user = $this->db->get()->result();

        // Get API
        $this->db->select('api_id');
        $this->db->from('service_spot_api');
        $array_2 = array('api_name' => 'add_emp');

        $this->db->where($array_2);

//        $this->db->order_by("ss_id", "ASC");
        // $this->db->limit($offset, 10);
        $apis = $this->db->get()->result();

        $insert = array();
        foreach ($spot_user as $user) {
            foreach ($apis as $api) {
                $insert[] = array(
                    'sua_u_id' => $user->ss_id,
                    'sua_api_id' => $api->api_id,
                    'sua_status' => 0
                );
            }
        }

        $status = $this->db->insert_batch('service_spot_user_api_status', $insert);

        return $status;
    }

    function get_price_log() {
        $this->db->select('*');
        $this->db->from('spot_log');
        $this->db->where_in('u_id', $uid_array);
//        $this->db->order_by("ss_id", "ASC");
        // $this->db->limit($offset, 10);
        $result = $this->db->get()->result();
    }

    function update_logs($data = "", $carid = "") {
        if ($carid != "") {
            // reun update query 
            $carlisting_spotcityfare = array(
                'spot_id' => $carid,
                'base_fare' => $data['base_price'],
                'extrapriceperkm' => $data['price_prkm'],
                'extrapricepermin' => $data['wtng_price_prmin'],
                'free_km' => $data['spot_free_km'],
                'free_min' => $data['spot_free_min'],
                'created_date' => date('Y-m-d H:i:s')
            );



            $this->db->insert('spot_log', $carlisting_spotcityfare);
        }
    }

    function get_payment_mode($uid) {
        $demandCount = 0;
        $arrays = array('u.u_id' => $uid);
        $this->db->select("u_HOD.u_payment_mode");
        $this->db->from('users AS u');
        $this->db->join('users as u_HOD', 'u_HOD.u_id=u.u_parent_id', 'LEFT');
        $this->db->where($arrays);
        $query = $this->db->get();
        $rowcount = $query->num_rows();
        if ($rowcount > 0) {
            $row = $query->row();
            $demandCount = $row->u_payment_mode;
        }
        return $demandCount;
    }

    function viewOrderDetails($orderNo) {

        $this->db->select("sorder.order_id,sorder.order_no,sorder.car_od_id,sorder.start_date,sorder.end_date,sorder.status,sorder.approval_id,
                sorder.or_placed_by, sorder.or_placed_for, sorder.or_PayAuthroty, sorder.so_DDO_id, sorder.so_DDO_code,sorder.approved_by,sorder.quantity,
                sorder.approvedfilename,sorder.remarks, sorder.buyer_status_date, sorder.sp_status_date,
                car.car_od_id, car.s_comp_name, car.carlisting_id ,car.car_od_created_by ,
                car.car_od_created_on ,car.carlisting_category, car.car_name,car.car_brand,car.car_model,car.car_bodytype,
		car.car_enginecapacity,car.car_nopassenger,car.car_reg_state,car.car_od_ac,car.trail_id,car.car_od_regno,
                car.car_od_reg_validity,car.car_od_insu_validity,car.car_od_odomtr_reading,car.car_od_remark,
		car.car_od_basefare,car.car_od_price_prkm,car.car_od_watingpriceprmin,car.car_od_quantity,
		car.car_or_startdate,car.car_or_enddate,car.booker_id, car.service_type, car.servicesubtype,
                car.city,car.bid_id,sorder.amend_status");
        $this->db->from('service_orders AS sorder');
        $this->db->join('car_orderservicedetail AS car', 'car.trail_id=sorder.car_od_id', 'INNER');
        $this->db->where('sorder.order_no', $orderNo);
        $rsltnt1 = $this->db->get()->result();

        return $rsltnt1;
    }

    public function user_details($userid) {
        if (is_null($userid) === FALSE) {
            $this->db->select('uc_data');
            $this->db->where_in('uc_user_id', $userid);
            $qry = $this->db->get('cached_user');
            if ($qry->num_rows() > 1) {
                $res = $qry->result();
                $result = array();
                foreach ($res as $row) {
                    $result[] = json_decode(utf8_encode($row->uc_data));
                }
                return $result;
            } else {
                $res = $qry->row();
                return json_decode(utf8_encode($qry->row()->uc_data));
            }
//         echo $this->db->last_query();die;
        } else {
            return $this->db->select('*')->from('users')->where(array('u_id' => $userid))->get->result();
        }
    }

}

?>