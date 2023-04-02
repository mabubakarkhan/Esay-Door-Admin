<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {
    public function __construct()
    {
                parent::__construct();
                // Your own constructor code
                $this->load->database();
                $this->load->helper('login_helper');
    }
    public function index()
    {
        if(_is_user_login($this)){
            $data = array();
            $this->load->model("users_model");
            $data["users"] = $this->users_model->get_alluser();
            $this->load->view("users/list2",$data);
        }
        else
        {
            redirect('admin');
        }
    }

    public function add_user(){
        if(_is_user_login($this)){
            $data = array();
            $this->load->model("users_model");
            if($_POST){
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('user_fullname', 'Full Name', 'trim|required');
                $this->form_validation->set_rules('user_email', 'Email Id', 'trim|required');
                $this->form_validation->set_rules('user_password', 'Password', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
                {
                  
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                    
                }else
                {
                    
                        $user_fullname = $this->input->post("user_fullname");
                        $emp_fullname = $this->input->post("emp_fullname");
                        $user_email = $this->input->post("user_email");
                        $user_password = $this->input->post("user_password");
                        $user_phone = $this->input->post("mobile");
                        $user_city = $this->input->post("city");
                        $status = ($this->input->post("status")=="on")? 1 : 0;
                        
                        if($_FILES["pro_pic"]["size"] > 0){
                                    $config['upload_path']          = './uploads/profile/';
                                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                                    $this->load->library('upload', $config);
                    
                                    if ( ! $this->upload->do_upload('pro_pic'))
                                    {
                                            $error = array('error' => $this->upload->display_errors());
                                            $image="";
                                    }
                                    else
                                    {
                                        $img_data = $this->upload->data();
                                        //$array["user_image"]=$img_data['file_name'];
                                        $image=$_FILES["pro_pic"]['name'];
                                    }
                                    
                                }

                        else{
                            $image="";
                        }
                        

                            $this->load->model("common_model");
                            $this->common_model->data_insert("store_login",
                                array(
                                "user_fullname"=>$user_fullname,
                                "user_name"=>$emp_fullname,
                                "user_email"=>$user_email,
                                "user_image"=>$image,
                                "user_password"=>md5($user_password),
                                "user_phone"=>$user_phone,
                                "user_status"=>$status,
                                "user_city"=>$user_city));
                                
                                
                         $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                         <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
                                         <span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> User Added Successfully
                                </div>');
                        
                }
            }
            
            $data["user_types"] = $this->users_model->get_user_type();
            $this->load->view("users/add_user2",$data);
        }
        else
        {
            redirect('admin');
        }
    }

    public function edit_user($user_id){
        if(_is_user_login($this)){
            $data = array();
            $this->load->model("users_model");
            $data["user_types"] = $this->users_model->get_user_type();
            $user = $this->users_model->get_user_by_id($user_id);
            $data["user"] = $user;
            if($_POST){
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('user_fullname', 'Full Name', 'trim|required');
                $this->form_validation->set_rules('user_password', 'Password', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
                {
                  
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                    
                }else
                {
                        $user_fullname = $this->input->post("user_fullname");
                        $emp_fullname = $this->input->post("emp_fullname");
                        $user_email = $this->input->post("user_email");
                        $user_password = $this->input->post("user_password");
                        $user_phone = $this->input->post("mobile"); 
                        $user_city = $this->input->post("city");
                        $status = ($this->input->post("status")=="on")? 1 : 0;
                        
                        if($_FILES["pro_pic"]["size"] > 0){
                                    $config['upload_path']          = './uploads/profile/';
                                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                                    $this->load->library('upload', $config);
                    
                                    if ( ! $this->upload->do_upload('pro_pic'))
                                    {
                                            $error = array('error' => $this->upload->display_errors());
                                    }
                                    else
                                    {
                                        $img_data = $this->upload->data();
                                        //$array["user_image"]=$img_data['file_name'];
                                        $image=base_url()."/uploads/profile/".$img_data['file_name'];
                                    }
                                    
                                    $update_array = array(
                                    "user_fullname"=>$user_fullname,
                                    "user_name"=>$emp_fullname,
                                    "user_email"=>$user_email,
                                    "user_phone"=>$user_phone,
                                    "user_status"=>$status,
                                    "user_image"=>$image,
                                    "user_city"=>$user_city);
                                    
                                }
                        else
                        {
                            $update_array = array(
                            "user_fullname"=>$user_fullname,
                            "user_name"=>$emp_fullname,
                            "user_email"=>$user_email,
                            "user_phone"=>$user_phone,
                            "user_status"=>$status,
                            "user_city"=>$user_city);
                        }

                        
                        $user_password = $this->input->post("user_password");
                        if($user->user_password != $user_password){
                            
                        $update_array["user_password"]= md5($user_password);

                        }
                        
                            $this->load->model("common_model");
                            $this->common_model->data_update("store_login",$update_array,array("user_id"=>$user_id)
                                );
                            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> User Added Successfully
                                </div>');
                                redirect("users");
                        
                }
            }
            
            
            $this->load->view("users/edit_user2",$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function edit_mainuser($user_id){
        if(_is_user_login($this)){
            $data = array();
            $this->load->model("users_model");
            $data["user_types"] = $this->users_model->get_user_type();
            $user = $this->users_model->get_mainuser_by_id($user_id);
            $data["user"] = $user;
            if($_POST){
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('user_fullname', 'Full Name', 'trim|required');
                $this->form_validation->set_rules('user_password', 'Password', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
                {
                  
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                    
                }else
                {
                        $user_fullname = $this->input->post("user_fullname");
                        $emp_fullname = $this->input->post("emp_fullname");
                        $user_email = $this->input->post("user_email");
                        $user_password = $this->input->post("user_password");
                        $user_phone = $this->input->post("mobile"); 
                        $user_city = $this->input->post("city");
                        $status = ($this->input->post("status")=="on")? 1 : 0;
                        
                        if($_FILES["pro_pic"]["size"] > 0)
                        {
                            $config['upload_path']          = './uploads/profile/';
                            $config['allowed_types']        = 'gif|jpg|png|jpeg';
                            $this->load->library('upload', $config);
            
                            if ( ! $this->upload->do_upload('pro_pic'))
                            {
                                    $error = array('error' => $this->upload->display_errors());
                            }
                            else
                            {
                                $img_data = $this->upload->data();
                                //$array["user_image"]=$img_data['file_name'];
                                $image=$img_data['file_name'];
                            }

                            $update_array = array(
                                "user_fullname"=>$user_fullname,
                                "user_name"=>$emp_fullname,
                                "user_email"=>$user_email,
                                "user_phone"=>$user_phone,
                                "user_status"=>$status,
                                "user_image"=>$image,
                                "user_city"=>$user_city);
                                    
                        }

                        else
                        {
                            $update_array = array(
                                "user_fullname"=>$user_fullname,
                                "user_name"=>$emp_fullname,
                                "user_email"=>$user_email,
                                "user_phone"=>$user_phone,
                                "user_status"=>$status,
                                "user_city"=>$user_city);
                        }
                    

                        $user_password = $this->input->post("user_password");
                        if($user->user_password != $user_password){
                            
                        $update_array["user_password"]= md5($user_password);

                        }
                        
                            $this->load->model("common_model");
                            $this->common_model->data_update("users",$update_array,array("user_id"=>$user_id)
                                );
                            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> User Added Successfully
                                </div>');
                                redirect("admin/dashboard");
                        
                }
            }
            
            
            $this->load->view("users/edit_user2",$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function delete_user($user_id){
        if(_is_user_login($this)){
            $data = array();
            $this->load->model("users_model");
            $user  = $this->users_model->get_user_by_id($user_id);
            if($user){
                $this->db->query("Delete  from store_login where user_id = '".$user_id."'");
                redirect("users");
            }
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function modify_password($token){
        $data = array();
        $q = $this->db->query("Select * from registers where varified_token = '".$token."' limit 1");
        if($q->num_rows() > 0){
                        $data = array();
                        $this->load->library('form_validation');
                        $this->form_validation->set_rules('n_password', 'New password', 'trim|required');
                        $this->form_validation->set_rules('r_password', 'Re password', 'trim|required|matches[n_password]');
                        if ($this->form_validation->run() == FALSE) 
                        {
                            if($this->form_validation->error_string()!=""){
                                  
                                    $data["response"] = "error";
                                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                                </div>';
                                                }
                                    
                        }else
                        {
                                   $user = $q->row();
                                   $this->db->update("registers",array("user_password"=>md5($this->input->post("n_password")),"varified_token"=>""),array("user_id"=>$user->user_id));
                                   $data["success"] = true;                             
                                                                   
                        }
                        $this->load->view("users/modify_password",$data);
        }else{
            echo "No access token found";
        }
    }
    
    public function sales_rep_list()
    {
        if(_is_user_login($this)){
            $data = array();
            $this->load->model("users_model");
            $q=$this->db->query("Select * from sales_rep_login");
            $data["users"] = $q->result();
            $this->load->view("users/sales_rep_list",$data);
        }
        else
        {
            redirect('admin');
        }

    }
    
    public function add_sales_rep(){
        if(_is_user_login($this)){
            $data = array();
            $this->load->model("users_model");
            if($_POST){
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('user_fullname', 'Full Name', 'trim|required');
                $this->form_validation->set_rules('user_email', 'Email Id', 'trim|required');
                $this->form_validation->set_rules('user_password', 'Password', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
                {
                  
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                    
                }else
                {
                    
                        $user_fullname = $this->input->post("user_fullname");
                        $emp_fullname = $this->input->post("emp_fullname");
                        $user_email = $this->input->post("user_email");
                        $user_password = $this->input->post("user_password");
                        $user_phone = $this->input->post("mobile");
                        $user_city = $this->input->post("city");
                        $status = ($this->input->post("status")=="on")? 1 : 0;
                        
                        if($_FILES["pro_pic"]["size"] > 0){
                                    $config['upload_path']          = './uploads/profile/';
                                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                                    $this->load->library('upload', $config);
                    
                                    if ( ! $this->upload->do_upload('pro_pic'))
                                    {
                                            $error = array('error' => $this->upload->display_errors());
                                            $image="";
                                    }
                                    else
                                    {
                                        $img_data = $this->upload->data();
                                        //$array["user_image"]=$img_data['file_name'];
                                        $image=$img_data["pro_pic"]['file_name'];
                                    }
                                    
                                }

                        else{
                            $image="";
                        }
                        

                            $this->load->model("common_model");
                            $this->common_model->data_insert("sales_rep_login",
                                array(
                                "user_fullname"=>$user_fullname,
                                "user_name"=>$emp_fullname,
                                "user_email"=>$user_email,
                                "user_image"=>$image,
                                "user_password"=>md5($user_password),
                                "user_phone"=>$user_phone,
                                "user_status"=>$status,
                                "user_city"=>$user_city));
                                
                                
                                         $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
                                 <span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> User Added Successfully
                                </div>');
                        
                }
            }
            
            $data["user_types"] = $this->users_model->get_user_type();
            $this->load->view("users/add_sale_rep",$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function edit_sales_rep($user_id){
        if(_is_user_login($this)){
            $data = array();
            $this->load->model("users_model");
            $data["user_types"] = $this->users_model->get_user_type();
            $u = $this->db->query("Select * from sales_rep_login where user_id ='".$user_id."'");
            $user = $u->result();
            $data["user"] = $user;
            if($_POST){
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('user_fullname', 'Full Name', 'trim|required');
                $this->form_validation->set_rules('user_password', 'Password', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
                {
                  
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                    
                }else
                {
                        $user_fullname = $this->input->post("user_fullname");
                           $emp_fullname = $this->input->post("emp_fullname");
                        $user_email = $this->input->post("user_email");
                        $user_password = $this->input->post("user_password");
                         $user_phone = $this->input->post("mobile"); 
                          $user_city = $this->input->post("city");
                        $status = ($this->input->post("status")=="on")? 1 : 0;
                        
                        if($_FILES["pro_pic"]["size"] > 0){
                                    $config['upload_path']          = './uploads/profile/';
                                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                                    $this->load->library('upload', $config);
                    
                                    if ( ! $this->upload->do_upload('pro_pic'))
                                    {
                                            $error = array('error' => $this->upload->display_errors());
                                    }
                                    else
                                    {
                                        $img_data = $this->upload->data();
                                        //$array["user_image"]=$img_data['file_name'];
                                        $image=$img_data['file_name'];
                                    }
                                    
                                }
                    

                        $update_array = array(
                                "user_fullname"=>$user_fullname,
                                "user_name"=>$emp_fullname,
                                "user_email"=>$user_email,
                                "user_phone"=>$user_phone,
                                "user_status"=>$status,
                                "user_image"=>$image,
                                "user_city"=>$user_city);
                        $user_password = $this->input->post("user_password");
                        if($user->user_password != $user_password){
                            
                        $update_array["user_password"]= md5($user_password);

                        }
                        
                            $this->load->model("common_model");
                            $this->common_model->data_update("sales_rep_login",$update_array,array("user_id"=>$user_id)
                                );
                            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> User Added Successfully
                                </div>');
                                redirect("users/sales_rep_list");
                        
                }
            }
            
            
            $this->load->view("users/edit_sales_rep",$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function assing_sales(){
        if(_is_user_login($this)){
            $data = array();
            ini_set('allow_url_fopen',1);
            $this->load->model("users_model");
            if($_POST){
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('user_name', 'Full Name', 'trim|required');
                $this->form_validation->set_rules('user_email', 'Email Id', 'trim|required');
                $this->form_validation->set_rules('mobile', 'Phone Number', 'trim|required');
                $this->form_validation->set_rules('user_address', 'Address', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
                {
                  
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                    
                }else
                {
                    
                        $user_fullname = $this->input->post("user_name");
                        $user_email = $this->input->post("user_email");
                        $user_password = $this->input->post("user_address");
                        $user_phone = $this->input->post("mobile");
                        $sales_man = $this->input->post("sales_man");
                        //$addres = $this->input->post("user_address");
                        $d = date('d/m/y');
                        $addres = $this->input->post("user_address");
                        $latitude="";
                        $longitude="";
                        
                        // $prepAddr = str_replace(' ','+',$addres);
                        // $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr);
                        // $output = json_decode($geocode);
                        
                        
                        //     $latitude = $output->results[1]->geometry->location->lat;
                        //     $longitude = $output->results[1]->geometry->location->lng;
                        

                        
                        // $address2 = str_replace(" ","+",$addres);
                        // //$address2 = str_replace(",", "", $address);
                        // $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address2&sensor=false&region=India");
                        // $jsons = json_decode($json);
                    
                        // $latitude = $jsons->results[0]->geometry->location->lat;
                        // $longitude = $jsons->results[0]->geometry->location->lng;

                            
                        //   echo "latitude - ".$latitude;
                        //   echo "longitude - ".$longitude;
                        

                            $this->load->model("common_model");
                            $this->common_model->data_insert("assign_client",
                                array(
                                "name"=>$user_fullname,
                                "email"=>$user_email,
                                "phone"=>$user_phone,
                                "lat"=>$latitude,
                                "lon"=>$longitude,
                                "sale_user_id"=>$sales_man,
                                "address"=>$addres,
                                "on_date"=>$d));
                                
                                
                                         $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
                                 <span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> User Added Successfully
                                </div>');
                            
                        
                }
            }
            
            $data["user_types"] = $this->users_model->get_user_type();
            $this->load->view("users/assgin_sales",$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
}