<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 * 
 * @extends CI_Controller
 */
class Apply extends CI_Controller {

    /**
     * __construct function.
     * 
     * @access public
     * @return void
     */
    public function __construct() {

        parent::__construct();
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->model('user_model');
        $this->load->model('apply_model');
    }

// job3/apply	
    function index() {


        // create the data object
        $data = new stdClass();

        // load form helper and validation library
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set validation rules
        $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]|is_unique[users.username]', array('is_unique' => 'This username already exists. Please choose another one.'));
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');

        if ($this->form_validation->run() === false) {

            // validation not ok, send validation errors to the view
            $this->load->view('header');
            $this->load->view('apply/basic_detail', $data);
            $this->load->view('footer');
        }
        else {

            // set variables from the form
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            if ($this->user_model->create_user($username, $email, $password)) {

                // user creation ok
                $this->load->view('header');
                $this->load->view('apply/basic_detail', $data);
                $this->load->view('footer');
            }
            else {

                // user creation failed, this should never happen
                $data->error = 'There was a problem creating your new account. Please try again.';

                // send error to the view
                $this->load->view('header');
                $this->load->view('apply/basic_detail', $data);
                $this->load->view('footer');
            }
        }
    }

//  job3/apply/application_details
    function application_details() {
        $this->load->view('header');
        $this->load->view('apply/basic_detail');
        $this->load->view('footer');
    }

//  job3/apply/qualification_details
    function qualification_details() {
        $this->load->view('header');
        $this->load->view('apply/basic_detail');
        $this->load->view('footer');
    }

//  job3/apply/confirm_and_pay
    function confirm_and_pay() {
        $MERCHANT_KEY = "gtKFFx";
        $SALT = "eCwWELxi";
        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
        $this->load->model('apply_model');
        $posted = $this->apply_model->get_application_data(null); 
        $hashVarsSeq = explode('|', $hashSequence);
        $hash_string = '';
        foreach ($hashVarsSeq as $hash_var) {
            $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
            $hash_string .= '|';
        }

        $hash_string .= $SALT;


        $hash = strtolower(hash('sha512', $hash_string));
        $action = $PAYU_BASE_URL . '/_payment';
        $data['MERCHANT_KEY'] = "";
        $data['hash'] = $hash;
        $data['txnid'] = "";
        $this->load->view('header');
        $this->load->view('apply/confirm_and_pay', $data);
        $this->load->view('footer');
    }

//   job3/apply/success
    function success() {
        $this->load->view('header');
        $this->load->view('basic_detail');
        $this->load->view('footer');
    }

    /**
     * register function.
     * 
     * @access public
     * @return void
     */
    public function register() {

        // create the data object
        $data = new stdClass();

        // load form helper and validation library
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set validation rules
        $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]|is_unique[users.username]', array('is_unique' => 'This username already exists. Please choose another one.'));
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');

        if ($this->form_validation->run() === false) {

            // validation not ok, send validation errors to the view
            $this->load->view('header');
            $this->load->view('user/register/register', $data);
            $this->load->view('footer');
        }
        else {

            // set variables from the form
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            if ($this->user_model->create_user($username, $email, $password)) {

                // user creation ok
                $this->load->view('header');
                $this->load->view('user/register/register_success', $data);
                $this->load->view('footer');
            }
            else {

                // user creation failed, this should never happen
                $data->error = 'There was a problem creating your new account. Please try again.';

                // send error to the view
                $this->load->view('header');
                $this->load->view('user/register/register', $data);
                $this->load->view('footer');
            }
        }
    }

    /**
     * login function.
     * 
     * @access public
     * @return void
     */
    public function basic_details() {

        // create the data object
        $data = new stdClass();

        // load form helper and validation library
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set validation rules
        $this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == false) {

            // validation not ok, send validation errors to the view
            $this->load->view('header');
            $this->load->view('apply/basic_details');
            $this->load->view('footer');
        }
        else {

            // set variables from the form
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            if ($this->user_model->resolve_user_login($username, $password)) {

                $user_id = $this->user_model->get_user_id_from_username($username);
                $user = $this->user_model->get_user($user_id);

                // set session user datas
                $_SESSION['user_id'] = (int) $user->id;
                $_SESSION['username'] = (string) $user->username;
                $_SESSION['logged_in'] = (bool) true;
                $_SESSION['is_confirmed'] = (bool) $user->is_confirmed;
                $_SESSION['is_admin'] = (bool) $user->is_admin;

                // user login ok
                $this->load->view('header');
                $this->load->view('user/login/login_success', $data);
                $this->load->view('footer');
            }
            else {

                // login failed
                $data->error = 'Wrong username or password.';

                // send error to the view
                $this->load->view('header');
                $this->load->view('user/login/login', $data);
                $this->load->view('footer');
            }
        }
    }

    /**
     * logout function.
     * 
     * @access public
     * @return void
     */
    public function logout() {

        // create the data object
        $data = new stdClass();

        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

            // remove session datas
            foreach ($_SESSION as $key => $value) {
                unset($_SESSION[$key]);
            }

            // user logout ok
            $this->load->view('header');
            $this->load->view('user/logout/logout_success', $data);
            $this->load->view('footer');
        }
        else {

            // there user was not logged in, we cannot logged him out,
            // redirect him to site root
            redirect('/');
        }
    }

}
