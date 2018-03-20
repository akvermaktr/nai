<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Apply_model extends CI_Model {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	/**
	 * create_user function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @param mixed $email
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function create_user($username, $email, $password) {
		
		$data = array(
			'username'   => $username,
			'email'      => $email,
			'password'   => $this->hash_password($password),
			'created_at' => date('Y-m-j H:i:s'),
		);
		
		return $this->db->insert('users', $data);
		
	}
	
	/**
	 * resolve_user_login function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function get_application_data($registration_no=null) {
		
		$this->db->select('id, 
submittion, 
project_category, 
name_of_applicant, 
gardion_of_applicant, 
date_of_birth, 
age_of_applicant_on_date_of_submittion, 
cast_category, 
gender, 
postal_address, 
phone_number, 
email_id, 
course_id, 
permanent_address, 
sponsoring_department_address, 
post_hald_at_present, 
examination_passed, 
subject, 
marks, 
year_of_passing, 
percentage_grade_of_marks, 
name_board, 
pc_examination_passed, 
pc_subject, 
pc_marks, 
pc_year_of_passing, 
pc_percentage_grade_of_marks, 
pc_name_board, 
file_upload_path, 
amountPaid, 
course_applied_for_code, 
form_submit_on, 
valid, 
');
		$this->db->from('application_form_table');
                if(isset($registration_no)) {
                    $this->db->where('username', $username);
                }
                $this->db->limit(1,1); 
		$hash = $this->db->get()->row('password');
		
		return $this->verify_password_hash($password, $hash);
		
	}
	
	/**
	 * get_user_id_from_username function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_user_id_from_username($username) {
		
		$this->db->select('id');
		$this->db->from('users');
		$this->db->where('username', $username);

		return $this->db->get()->row('id');
		
	}
	
	/**
	 * get_user function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user($user_id) {
		
		$this->db->from('users');
		$this->db->where('id', $user_id);
		return $this->db->get()->row();
		
	}
	
	/**
	 * hash_password function.
	 * 
	 * @access private
	 * @param mixed $password
	 * @return string|bool could be a string on success, or bool false on failure
	 */
	private function hash_password($password) {
		
		return password_hash($password, PASSWORD_BCRYPT);
		
	}
	
	/**
	 * verify_password_hash function.
	 * 
	 * @access private
	 * @param mixed $password
	 * @param mixed $hash
	 * @return bool
	 */
	private function verify_password_hash($password, $hash) {
		
		return password_verify($password, $hash);
		
	}
	
}
