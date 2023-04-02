<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {
    
    private static $API_SERVER_KEY = 'Your Server Key';
    private static $is_background = "TRUE";
   
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->database();
        $this->load->helper('login_helper');
        $this->load->helper('sms_helper');
        $this->load->library('upload');
    }
    function signout(){
        $this->session->sess_destroy();
        redirect("admin");
    }
    public function index()
    {
        // if(_is_user_login($this)){
        //     redirect(_get_user_redirect($this));
        // }else{
            
            $data = array("error"=>"");       
            if(isset($_POST))
            {
                
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('email', 'Email', 'trim|required');
                $this->form_validation->set_rules('password', 'Password', 'trim|required');
                if ($this->form_validation->run() == FALSE) 
                {
                   if($this->form_validation->error_string()!=""){
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                    }
                }else
                {
                   
                $q = $this->db->query("Select * from `users` where (`user_email`='".$this->input->post("email")."')
                 and user_password='".md5($this->input->post("password"))."' and user_login_status='1'");
                    
                   // print_r($q) ; 
                    if ($q->num_rows() > 0)
                    {
                        $row = $q->row(); 
                        if($row->user_status == "0")
                        {
                            $data["error"] = '<div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> Your account currently inactive.</div>';
                        }
                        else
                        {
                            $newdata = array(
                                                   'user_name'  => $row->user_fullname,
                                                   'user_email' => $row->user_email,
                                                   'logged_in' => TRUE,
                                                   'user_id'=>$row->user_id,
                                                   'user_type_id'=>$row->user_type_id
                                                  );
                            $this->session->set_userdata($newdata);
                            redirect(_get_user_redirect($this));
                         
                        }
                    }
                    else
                    {
                        $data["error"] = '<div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> Invalid User and password. </div>';
                    }
                   
                    
                }
            }
            else
            {
                $this->session->sess_destroy();
            }
            $data["active"] = "login";
            
            $this->load->view("admin/login2",$data);
        // }
    }
    public function dashboard(){
        if(_is_user_login($this)){
            $data = array();
            $this->load->model("product_model");
            $date = date("Y-m-d");
            $data["today_orders"] = $this->product_model->get_sale_orders(" and sale.at >= CURDATE() ");
            $nexday = date('Y-m-d', strtotime(' +1 day'));
            $data["nextday_orders"] = $this->product_model->get_sale_orders(" and sale.at >= CURDATE() ");
            $this->load->view("admin/dashboard",$data);
        }
        else{
            redirect("admin");
        }
    }
    public function orders(){
        if(_is_user_login($this)){
            $data = array();
            $this->load->model("product_model");
            $fromdate = date("Y-m-d");
            $todate = date("Y-m-d");
            $data['date_range_lable'] = $this->input->post('date_range_lable');
           
             $filter = "";
            if($this->input->post("date_range")!=""){
                $filter = $this->input->post("date_range");
                $dates = explode(",",$filter);                
                $fromdate =  date("Y-m-d", strtotime($dates[0]));
                $todate =  date("Y-m-d", strtotime($dates[1])); 
                $filter = " and sale.on_date >= '".$fromdate."' and sale.on_date <= '".$todate."' and sale.type != 'food' ";
                $filter = " ";
            }
            else{
                $filter = " and sale.type != 'food' ";
            }
            $data["today_orders"] = $this->product_model->get_sale_orders($filter);
            
            $this->load->view("admin/orders/orderslist2",$data);
        }
        else{
            redirect("admin");
        }
    }
    public function order_reports(){
        if(_is_user_login($this)){
            $data = array();
            $this->load->view("admin/orders/order_reports",$data);
        }
        else{
            redirect("admin");
        }
    }
    public function get_order_report_ajax()
    {
        if(_is_user_login($this)){
            if ($_POST) {
                $status = $_POST['status'];
                $to = $_POST['to'];
                $from = $_POST['from'];
                $resp = $this->get_results("SELECT * FROM `sale` WHERE `tracking_status` = '$status' AND `at` >= '$from' AND `at` <= '$to' ORDER BY `at` DESC;");
                if ($resp) {
                    echo json_encode(array("status"=>true,"data"=>$resp));
                }
                else{
                    echo json_encode(array("status"=>false,"msg"=>"no record found"));
                }
            }
            else{
                redirect("admin");
            }
        }
        else{
            redirect("admin");
        }
    }
    public function food_orders(){
        if(_is_user_login($this)){
            $data = array();
            $this->load->model("product_model");
            $fromdate = date("Y-m-d");
            $todate = date("Y-m-d");
            $data['date_range_lable'] = $this->input->post('date_range_lable');
           
             $filter = "";
            if($this->input->post("date_range")!=""){
                $filter = $this->input->post("date_range");
                $dates = explode(",",$filter);                
                $fromdate =  date("Y-m-d", strtotime($dates[0]));
                $todate =  date("Y-m-d", strtotime($dates[1])); 
                $filter = " and sale.on_date >= '".$fromdate."' and sale.on_date <= '".$todate."' sale.type = 'food' ";
            }
            else{
                $filter = " and sale.type = 'food' ";
            }
            $data["today_orders"] = $this->product_model->get_sale_orders($filter);
            
            $this->load->view("admin/orders/orderslist_food",$data);
        }
        else{
            redirect("admin");
        }
    }
    public function confirm_order($order_id){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_id);
            if(!empty($order)){
                $this->db->query("update sale set status = 1 where sale_id = '".$order_id."'");
                 $q = $this->db->query("Select * from registers where user_id = '".$order->user_id."'");
                $user = $q->row();
                
                                $message["title"] = "Confirmed  Order";
                                $message["message"] = "Your order Number '".$order->sale_id."' confirmed successfully";
                                $message["image"] = "";
                                $message["created_at"] = date("Y-m-d h:i:s"); 
                                $message["obj"] = "";
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   
                            if($user->user_gcm_code != ""){
                            $result = $gcm->send_notification(array($user->user_gcm_code),$message ,"android");
                            }
                             if($user->user_ios_token != ""){
                            $result = $gcm->send_notification(array($user->user_ios_token),$message ,"ios");
                             }
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order confirmed. </div>');
            }
            redirect("admin/orders");
        }
        else{
            redirect("admin");
        }
    }
    
    public function delivered_order($order_id){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_id);
            if(!empty($order)){
                $this->db->query("update sale set status = 2 where sale_id = '".$order_id."'");
                /* $this->db->query("INSERT INTO delivered_order (sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method)
                SELECT sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method FROM sale
                where sale_id = '".$order_id."'"); 

                */
                
                $q = $this->db->query("Select * from registers where user_id = '".$order->user_id."'");
                $user = $q->row();
                
                        $message["title"] = "Delivered  Order";
                        $message["message"] = "Your order Number '".$order->sale_id."' Delivered successfully. Thank you for being with us";
                        $message["image"] = "";
                        $message["created_at"] = date("Y-m-d h:i:s"); 
                        $message["obj"] = "";
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   
                            if($user->user_gcm_code != ""){
                            $result = $gcm->send_notification(array($user->user_gcm_code),$message ,"android");
                            }
                             if($user->user_ios_token != ""){
                            $result = $gcm->send_notification(array($user->user_ios_token),$message ,"ios");
                             }
                
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order delivered. </div>');
            }
            redirect("admin/orders");
        }
        else{
            redirect("admin");
        }
    }
    
    public function delivered_order_complete($order_id){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_id);
            if(!empty($order)){
                $this->db->query("update sale set status = 4 where sale_id = '".$order_id."'");
                $this->db->query("INSERT INTO delivered_order (sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method)
                SELECT sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method FROM sale
                where sale_id = '".$order_id."'"); 

                
                $q = $this->db->query("Select * from registers where user_id = '".$order->user_id."'");
                $user = $q->row();

                $q2 = $this->db->query("Select total_rewards, user_id from sale where sale_id = '".$order_id."'");
                $user2 = $q2->row();
                        
                        $rewrd_by_profile=$user->rewards;
                        $rewrd_by_order=$user2->total_rewards;

                        $new_rewards=$rewrd_by_profile+$rewrd_by_order;
                        $this->db->query("update registers set rewards = '".$new_rewards."' where user_id = '".$user2->user_id."'");

                        $message["title"] = "Delivered  Order";
                        $message["message"] = "Your order Number '".$order->sale_id."' Delivered successfully. Thank you for being with us";
                        $message["image"] = "";
                        $message["created_at"] = date("Y-m-d h:i:s");
                        $message["obj"] = "";
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   
                            if($user->user_gcm_code != ""){
                            $result = $gcm->send_notification(array($user->user_gcm_code),$message ,"android");
                            }
                             if($user->user_ios_token != ""){
                            $result = $gcm->send_notification(array($user->user_ios_token),$message ,"ios");
                             }
                
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order delivered. </div>');
            }
            redirect("admin/orders");
        }
        else{
            redirect("admin");
        }
    }

    public function cancle_order($order_id){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_id);
            
            if(!empty($order)){
                $this->db->query("update sale set status = 3 where sale_id = '".$order_id."'");
                $this->db->delete('sale_items', array('sale_id' => $order_id)); 
                
                 $q = $this->db->query("Select * from users where user_id = '".$order->user_id."'");  
                 $user = $q->row();  
                                $message["title"] = "Cancel  Order";
                                $message["message"] = "Your order Number '".$order->sale_id."' cancel successfully";
                                $message["image"] = "";
                                $message["created_at"] = date("Y-m-d h:i:s"); 
                                $message["obj"] = "";
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   
                           if($user->user_gcm_code != ""){
                            $result = $gcm->send_notification(array($user->user_gcm_code),$message ,"android");
                            }
                             if($user->user_ios_token != ""){
                            $result = $gcm->send_notification(array($user->user_ios_token),$message ,"ios");
                             }
                
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order Cancle. </div>');
            }
            redirect("admin/orders");
        }
        else{
            redirect("admin");
        }
    }

    public function change_tracking_status($order_id,$status){
        if(_is_user_login($this)){
            
            $this->db->where('sale_id',$order_id);
            $this->db->update('sale',array("tracking_status"=>str_replace('_', ' ', $status)));

            $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                              <strong>Success!</strong> Order tracking status changed. </div>');
            redirect("admin/orders");
        }
        else{
            redirect("admin");
        }
    }
    
    public function delete_order($order_id){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_id);
            if(!empty($order)){
                $this->db->query("delete from sale where sale_id = '".$order_id."'");
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order deleted. </div>');
            }
            redirect("admin/orders");
        }
        else{
            redirect("admin");
        }
    }

    public function orderdetails($order_id){
        if(_is_user_login($this)){
            $data = array();
            $this->load->model("product_model");
            $data["order"] = $this->product_model->get_sale_order_by_id($order_id);
            $locationID = $data["order"]->location_id;
            if ($locationID) {
                $location = $this->db->query("
                    SELECT l.*,s.socity_name, c.name AS city_name 
                    FROM `user_location` AS l 
                    LEFT JOIN `socity` AS s ON l.socity_id = s.socity_id 
                    LEFT JOIN `city` AS c ON l.city_id = c.city_id 
                    WHERE l.location_id = '".$locationID."'
                ;");
                $data['location'] = $location->result()[0];
            }
            else{
                $data['location'] = false;
            }
            $data["order_items"] = $this->product_model->get_sale_order_items_invoice($order_id);
            $img = $this->db->query("SELECT * FROM signature WHERE order_id='".$order_id."'");
            if(count($img->result())==0)
            {
                $data["signature"] = array('signature'=>'N/A');
                // echo "na";
            }
            else
            {
                $d=$img->row();
                $data["signature"] = array('signature'=>$d->signature);
                // echo "yes".count($img->result());
            }
            // var_dump($data["signature"]);
            // //print_r( $data);exit();
            $this->load->view("admin/orders/orderdetails2",$data);
        }
        else{
            redirect("admin");
        }
    }
    public function orderdetails_food($order_id){
        if(_is_user_login($this)){
            $data = array();
            $this->load->model("product_model");
            $data["order"] = $this->product_model->get_sale_order_by_id($order_id);
            $locationID = $data["order"]->location_id;
            if ($locationID) {
                $location = $this->db->query("
                    SELECT l.*,s.socity_name, c.city_name 
                    FROM `user_location` AS l 
                    LEFT JOIN `socity` AS s ON l.socity_id = s.socity_id 
                    LEFT JOIN `city` AS c ON l.city_id = c.city_id 
                    WHERE l.location_id = '".$locationID."'
                ;");
                $data['location'] = $location->result()[0];
            }
            else{
                $data['location'] = false;
            }
            $data["order_items"] = $this->product_model->get_sale_order_items_food($order_id);
            $img = $this->db->query("SELECT * FROM signature WHERE order_id='".$order_id."'");
            if(count($img->result())==0)
            {
                $data["signature"] = false;
                // echo "na";
            }
            else
            {
                $d=$img->row();
                $data["signature"] = array('signature'=>$d->signature);
                // echo "yes".count($img->result());
            }
            // var_dump($data["signature"]);
            // //print_r( $data);exit();
            $this->load->view("admin/orders/orderdetails22",$data);
        }
        else{
            redirect("admin");
        }
    }

    public function change_status(){
        $table = $this->input->post("table");
        $id = $this->input->post("id");
        $on_off = $this->input->post("on_off");
        $id_field = $this->input->post("id_field");
        $status = $this->input->post("status");
        
        $this->db->update($table,array("$status"=>$on_off),array("$id_field"=>$id));
    }
/*=========USER MANAGEMENT==============*/   
    public function user_types(){
        $data = array();
        if(isset($_POST))
            {
                
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('user_type', 'User Type', 'trim|required');
                if ($this->form_validation->run() == FALSE) 
                {
                   if($this->form_validation->error_string()!=""){
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                    }
                }else
                {
                        $user_type = $this->input->post("user_type");
                        
                            $this->load->model("common_model");
                            $this->common_model->data_insert("user_types",array("user_type_title"=>$user_type));
                            $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> User Type added Successfully
                                </div>') ;
                             redirect("admin/user_types/");   
                        
                }
            }
        
        $this->load->model("users_model");
        $data["user_types"] = $this->users_model->get_user_type();
        $this->load->view("admin/user_types",$data);
    }

    function user_type_delete($type_id){
        $data = array();
            $this->load->model("users_model");
            $usertype  = $this->users_model->get_user_type_id($type_id);
           if($usertype){
                $this->db->query("Delete from user_types where user_type_id = '".$usertype->user_type_id."'");
                redirect("admin/user_types");
           }
    }

    public function user_access($user_type_id){
        if($_POST){
           //print_r($_POST);     
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('user_type_id', 'User Type', 'trim|required');
                if ($this->form_validation->run() == FALSE) 
                {
                   if($this->form_validation->error_string()!=""){
                        $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                 }
                }else{
                    //$user_type_id = $this->input->post("user_type_id");
                    $this->load->model("common_model");
                    $this->common_model->data_remove("user_type_access",array("user_type_id"=>$user_type_id));
                    
                    $sql = "Insert into user_type_access(user_type_id,class,method,access) values";
                    $sql_insert = array();
                    foreach(array_keys($_POST["permission"]) as $controller){
                        foreach($_POST["permission"][$controller] as $key=>$methods){
                            if($key=="all"){
                                $key = "*";
                            }
                            $sql_insert[] = "($user_type_id,'$controller','$key',1)";
                        }
                    }
                    $sql .= implode(',',$sql_insert)." ON DUPLICATE KEY UPDATE access=1";
                    $this->db->query($sql);
                }
        }
        $data['user_type_id'] = $user_type_id;
        $data["controllers"] = $this->config->item("controllers");
        $this->load->model("users_model");
        $data["user_access"] = $this->users_model->get_user_type_access($user_type_id);
        
        //$data["user_types"] = $this->users_model->get_user_type();
        $this->load->view("admin/user_access",$data);
    }
/*============USRE MANAGEMENT===============*/

  
/* ========== Categories =========== */
    public function addcategories()
    {
       if(_is_user_login($this)){
           // error_reporting(E_ALL);
            $data["error"] = "";
            $data["active"] = "addcat";
            if(isset($_REQUEST["addcatg"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('cat_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('slug', 'URL Slug', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                    }
                }
                else
                {
                    $filters = implode(',', $_POST['filters']);
                    $filter_ids = implode(',', $_POST['filter_ids']);
                    $this->load->model("category_model");
                    // $this->category_model->add_category($filters,$filter_ids);
                    $this->category_model->add_category($filters,'');
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/addcategories');
                }
            }
        //$data['filters'] = $this->get_results("SELECT `filter_id`,`title`,`admin_title` FROM `filter` WHERE `status` = 'active' ORDER BY `title` ASC");
        $this->load->view('admin/categories/addcat2',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function add_cat_child($parent)
    {
        if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "addcat";
            $data['parent'] = $this->get_row("SELECT `id`,`title`,`leval` FROM `categories` WHERE `id` = '$parent';");
            $this->load->view('admin/categories/add_cat_child',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function post_cat_child($parent)
    {
        if(_is_user_login($this)){
            if ($_POST) {
                $_POST['slug'] = $this->clean($_POST['title']);
                if($_FILES["cat_img"]["size"] > 0){
                    $config['upload_path']          = './uploads/category/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg';

                    $ext = pathinfo($_FILES["cat_img"]['name'], PATHINFO_EXTENSION);
                    $config['file_name'] = 'Euro_store_online_delivery_'.md5(time().$_FILES["cat_img"]['name']).'.'.$ext;

                    //$this->load->library('upload', $config);
                    $this->upload->initialize($config);
    
                    if ( ! $this->upload->do_upload('cat_img'))
                    {
                        $error = array('error' => $this->upload->display_errors());
                    }
                    else
                    {
                        $img_data = $this->upload->data();
                        $_POST["image"]=$img_data['file_name'];
                    }
               }
                $this->db->insert('categories',$_POST);
                redirect('admin/add_cat_child/'.$parent.'/');
            }
            else{
                redirect('admin');
            }
        }
        else
        {
            redirect('admin');
        }
    }
    public function add_header_categories()
    {
       if(_is_user_login($this)){
           
            $data["error"] = "";
            $data["active"] = "addcat";
            if(isset($_REQUEST["addcatg"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('cat_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                    }
                }
                else
                {
                    $this->load->model("category_model");
                    $this->category_model->add_header_category(); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/add_header_categories');
                }
            }
        $this->load->view('admin/icon_categories/addcat',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function editcategory($id)
    {
       if(_is_user_login($this))
       {
            $q = $this->db->query("select * from `categories` WHERE id=".$id);
            $data["getcat"] = $q->row();
            
            $data["error"] = "";
            $data["active"] = "listcat";
            if(isset($_REQUEST["savecat"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('cat_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('slug', 'URL Slug', 'trim|required');
                $this->form_validation->set_rules('cat_id', 'Categories Id', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim');
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                   }
                }
                else
                {
                    $filters = implode(',', $_POST['filters']);
                    $filter_ids = implode(',', $_POST['filter_ids']);
                    $this->load->model("category_model");
                    // $this->category_model->edit_category($filters,$filter_ids);
                    $this->category_model->edit_category($filters,'');
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your category saved successfully...
                                    </div>');
                    redirect('admin/listcategories');
                }
            }
            //$data['dynamic_filters'] = $this->get_results("SELECT `filter_id`,`title`,`admin_title` FROM `filter` WHERE `status` = 'active' ORDER BY `title` ASC");
            $this->load->view('admin/categories/editcat2',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
     public function edit_header_category($id)
    {
       if(_is_user_login($this))
       {
            $q = $this->db->query("select * from `header_categories` WHERE id=".$id);
            $data["getcat"] = $q->row();
            
            $data["error"] = "";
            $data["active"] = "listcat";
            if(isset($_REQUEST["savecat"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('cat_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('cat_id', 'Categories Id', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                   }
                }
                else
                {
                    $this->load->model("category_model");
                    $this->category_model->edit_header_category(); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your category saved successfully...
                                    </div>');
                    redirect('admin/header_categories');
                }
            }
           $this->load->view('admin/icon_categories/editcat',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function get_cat_tags()
    {
       if(_is_user_login($this)){
           $id = $_POST['cat'];
           $tags = $this->get_results("SELECT * FROM `cat_tag` WHERE `category_id` = '$id';");
           if ($tags) {
                $html = '';
               foreach ($tags as $key => $q) {
                    $html .= '<div class="row"  style="margin-top:50px">';
                        $html .= '<label class="col-md-3 label-on-left">'.$q['name'].' :</label>';
                        $html .= '<div class="col-md-9">';
                            $html .= '<div class="form-group label-floating is-empty">';
                                $html .= '<label class="control-label"></label>';
                                $html .= '<input type="hidden" name="cat_tag_id[]" value="'.$q['cat_tag_id'].'"/>';
                                $html .= '<input type="text" name="cat_tag_value[]" class="form-control"/>';
                            $html .= '<span class="material-input"></span></div>';
                        $html .= '</div>';
                    $html .= '</div>';
               }
               echo json_encode(array("status"=>true,"html"=>$html));
           }
           else{
            echo json_encode(array("status"=>true));
           }
        }
        else
        {
            redirect('admin');
        }
    }
    public function get_cat_tags_edit($tags)
    {
        $html = '';
        foreach ($tags as $key => $q) {
            $html .= '<div class="row"  style="margin-top:50px">';
                $html .= '<label class="col-md-3 label-on-left">'.$q['name'].' :</label>';
                $html .= '<div class="col-md-9">';
                    $html .= '<div class="form-group label-floating is-empty">';
                        $html .= '<label class="control-label"></label>';
                        $html .= '<input type="hidden" name="cat_tag_id[]" value="'.$q['cat_tag_id'].'"/>';
                        $html .= '<input type="text" name="cat_tag_value[]" value="'.$q['value'].'" class="form-control"/>';
                    $html .= '<span class="material-input"></span></div>';
                $html .= '</div>';
            $html .= '</div>';
        }
        return $html;
    }
    public function cattags($id)
    {
       if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "listcat";
           $data["cat"] = $this->get_row("SELECT * FROM `categories` WHERE `id` = '$id';");
           $data["page_title"] = $data['cat']['title'].' -> Tags';
           $data["tags"] = $this->get_results("SELECT * FROM `cat_tag` WHERE `category_id` = '$id' ORDER BY `name` ASC;");
           $this->load->view('admin/categories/cattags',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function submit_cat_tage()
    {
        if(_is_user_login($this)){
            if ($_POST) {
                $resp = $this->db->insert('cat_tag',$_POST);
                if ($resp) {
                    echo json_encode(array("status"=>true,"msg"=>"Submitted"));
                }
                else{
                    echo json_encode(array("status"=>false,"msg"=>"not submitted, please try again"));
                }
            }
            else{
                redirect('admin');
            }
        }
        else{
            redirect('admin');
        }
    }
    public function update_cat_tage()
    {
        if(_is_user_login($this)){
            if ($_POST) {
                $cat_tag_id = $_POST['cat_tag_id'];
                unset($_POST['cat_tag_id']);
                $this->db->where('cat_tag_id',$cat_tag_id);
                $resp = $this->db->update('cat_tag',$_POST);
                if ($resp) {
                    echo json_encode(array("status"=>true,"msg"=>"Submitted"));
                }
                else{
                    echo json_encode(array("status"=>false,"msg"=>"not updated, please try again"));
                }
            }
            else{
                redirect('admin');
            }
        }
        else{
            redirect('admin');
        }
    }
    public function deletecattag($id,$cat)
    {
       if(_is_user_login($this)){
            
            $this->db->delete("cat_tag",array("cat_tag_id"=>$id));
            $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your item deleted successfully...
                                    </div>');
            redirect('admin/cattags/'.$cat);
        }
        else
        {
            redirect('admin');
        }
    }
    public function listcategories()
    {
        if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "listcat";
           $this->load->model("category_model");
           $data["allcat"] = $this->category_model->get_categories();
           $this->load->view('admin/categories/listcat2',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function product_bulk_products_file()
    {
        if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "listcat";
           $this->load->model("category_model");
           $data['parents'] = $this->get_results("SELECT * FROM `categories` WHERE `parent` = '0' AND `leval` = '0' ORDER BY `title` ASC");
           $this->load->view('admin/categories/product_bulk_products_file',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function upload_filters_to_category()
    {
        if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "listcat";
           $this->load->view('admin/categories/upload_filters_to_category',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function sms_setting()
    {
       if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "sms_setting";
           $data["q"] = $this->get_row("SELECT * FROM `sms_setting` WHERE `sms_setting_id` = '1';");
           $this->load->view('admin/sms_setting/sms_setting',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function updatesmssetting()
    {
        if(_is_user_login($this)){
            $this->db->where('sms_setting_id',1);
            $this->db->update('sms_setting',$_POST);
            redirect('admin/sms_setting');
        }
        else
        {
            redirect('admin');
        }
    }
    public function food_cats()
    {
       if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "food_cats";
           $this->load->model("restaurant_model");
           $data["cats"] = $this->restaurant_model->get_food_cats();
           $this->load->view('admin/restaurants/cats',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function add_admin_cat()
    {
       if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "food_cats";
           $this->load->model("restaurant_model");
           $this->load->view('admin/restaurants/add_cat',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function post_admin_cat()
    {
        if(_is_user_login($this)){
            $name = $_POST['name'];
            $qry=$this->db->query("SELECT * FROM `admin_category` where `name` = '".$name."'");
            $check = $qry->result();
            if ($check) {
                $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                    <i class="fa fa-warning"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> category name is already in use
                                </div>');
            }
            else{
                $_POST['status'] = ($_POST['status']=="on")? 'active' : 'inactive';
                $resp = $this->db->insert('admin_category',$_POST);
                if ($resp) {
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Category added successfully...
                                    </div>');
                    redirect('admin/add_admin_cat');
                }
                else{
                    $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                    <i class="fa fa-warning"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> something wrong please try again.
                                </div>');
                    redirect('admin/add_admin_cat');
                }
            }  
        }
        else
        {
            redirect('admin');
        }
    }
    public function edit_admin_cat($id)
    {
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $qry = $this->db->query("SELECT * FROM `admin_category` where admin_category_id = '".$id."'");
            $data["q"] = $qry->result();
            $data["q"] = $data["q"][0];
            $this->load->view("admin/restaurants/edit_cat",$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function update_admin_cat()
    {
        if(_is_user_login($this)){
            $name = $_POST['name'];
            $id = $_POST['id'];
            $qry=$this->db->query("SELECT * FROM `admin_category` where `name` = '".$name."' AND `admin_category_id` != '".$id."'");
            $check = $qry->result();
            if ($check) {
                $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                    <i class="fa fa-warning"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> category name is already in use
                                </div>');
            }
            else{
                $update['name'] = $_POST['name'];
                $update['status'] = ($_POST['status']=="on")? 'active' : 'inactive';
                $this->db->where('admin_category_id',$id);
                $resp = $this->db->update('admin_category',$update);
                if ($resp) {
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Category updated successfully...
                                    </div>');
                    redirect('admin/food_cats');
                }
                else{
                    $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                    <i class="fa fa-warning"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> something wrong please try again.
                                </div>');
                    redirect('admin/edit_admin_cat/'.$id);
                }
            }  
        }
        else
        {
            redirect('admin');
        }
    }
    public function admin_food_pros($CatID)
    {
        if(_is_user_login($this)){
            $data['CatID'] = $CatID;
            $qry = $this->db->query("SELECT * FROM `admin_category` where admin_category_id = '".$CatID."'");
            $data["cat"] = $qry->result();
            $data["cat"] = $data["cat"][0];
            $data["error"] = "";
            $data["active"] = "food_cats";
            $this->load->model("restaurant_model");
            $data["pros"] = $this->restaurant_model->get_food_pros($CatID);
            $this->load->view('admin/restaurants/pros',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function add_admin_food_pro($CatID)
    {
        if(_is_user_login($this)){
            $data['CatID'] = $CatID;
            $qry = $this->db->query("SELECT * FROM `admin_category` where admin_category_id = '".$CatID."'");
            $data["cat"] = $qry->result();
            $data["cat"] = $data["cat"][0];
            $data["error"] = "";
            $data["active"] = "food_cats";
            $this->load->model("restaurant_model");
            $this->load->view('admin/restaurants/add_pro',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function post_admin_pro()
    {
        if(_is_user_login($this)){
            $update['status'] = ($_POST['status']=="on")? 'active' : 'inactive';
            $resp = $this->db->insert('admin_product',$_POST);
            if ($resp) {
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                    <i class="fa fa-check"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> product added successfully...
                                </div>');
                redirect('admin/add_admin_food_pro/'.$_POST['category_id']);
            }
            else{
                $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                <i class="fa fa-warning"></i>
                              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                              <strong>Warning!</strong> something wrong please try again.
                            </div>');
                redirect('admin/add_admin_cat');
            }
        }
        else
        {
            redirect('admin');
        }
    }
    public function edit_admin_food_pro($id)
    {
        if(_is_user_login($this)){
            $qry = $this->db->query("SELECT * FROM `admin_product` where admin_product_id = '".$id."'");
            $data["q"] = $qry->result();
            $data["q"] = $data["q"][0];

            $CatID = $data["q"]->category_id;
            $data['CatID'] = $CatID;
            $qry = $this->db->query("SELECT * FROM `admin_category` where admin_category_id = '".$CatID."'");
            $data["cat"] = $qry->result();
            $data["cat"] = $data["cat"][0];

            $data["error"] = "";
            $data["active"] = "food_cats";
            $this->load->model("restaurant_model");
            $this->load->view('admin/restaurants/edit_pro',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function update_admin_pro()
    {
        if(_is_user_login($this)){
            $update['name'] = $_POST['name'];
            $update['status'] = ($_POST['status']=="on")? 'active' : 'inactive';
            $update['detail'] = $_POST['detail'];
            $update['price'] = $_POST['price'];
            $this->db->where('admin_product_id',$_POST['id']);
            $resp = $this->db->update('admin_product',$update);
            if ($resp) {
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                    <i class="fa fa-check"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Product updated successfully...
                                </div>');
                redirect('admin/admin_food_pros/'.$_POST['category_id']);
            }
            else{
                $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                <i class="fa fa-warning"></i>
                              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                              <strong>Warning!</strong> something wrong please try again.
                            </div>');
                redirect('admin/edit_admin_food_pro/'.$id);
            }
        }
        else
        {
            redirect('admin');
        }
    }
    public function sellers()
    {
        if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "sellers";
            $this->load->model("seller_model");
            $data["users"] = $this->seller_model->get_sellers();
            $this->load->view('admin/seller/list',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function edit_seller($user_id)
    {
        if(_is_user_login($this)){
        
            if(isset($_POST['profile']))
            {
                unset($_POST['profile']);
                if (strlen($_POST['password']) > 1) {
                    $_POST['password'] = md5($_POST['password']);
                }
                else{
                    unset($_POST['password']);
                }
                $brand_id = $_POST['brand_id'];
                unset($_POST['brand_id']);
                $update = $_POST;
                $this->db->where('seller_id',$user_id);
                $this->db->update('seller',$update);
                if (intval($brand_id) > 0) {
                    $this->db->where('seller_id',$user_id);
                    $this->db->update('brand',array("seller_id"=>0));

                    $this->db->where('brand_id',$brand_id);
                    $this->db->update('brand',array("seller_id"=>$user_id));
                }

                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                    <i class="fa fa-check"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Your request edited successfully...
                                </div>');
                redirect('admin/sellers');
            }
            
            if(isset($_POST['amount']))
            {
                $_POST['featured'] = ($_POST['featured']=="on")? 'yes' : 'no';
                $_POST['is_new'] = ($_POST['is_new']=="on")? 'yes' : 'no';
                $_POST['show_name'] = ($_POST['show_name']=="on")? 'yes' : 'no';
                unset($_POST['amount']);
                $this->db->where('user_id',$user_id );
                $resp = $this->db->update('registers',$_POST );
                unset($_POST);
                if ($resp) {
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request edited successfully...
                                    </div>');
                    redirect('admin/restaurants');
                }
                else{
                    $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> some data missing please try again
                                    </div>');
                }

            }
            $this->load->model("product_model");
            $qry=$this->db->query("SELECT * FROM `seller` where seller_id = '".$user_id."'");
            $data["user"] = $qry->result();
            $qry2=$this->db->query("SELECT * FROM `brand` where seller_id = 0 OR `seller_id` = '".$user_id."' ORDER BY `title` ASC");
            $data["brands"] = $qry2->result();
            $orders=$this->db->query("
                SELECT item.*, s.updated_at, s.delivery_time_from, s.delivery_time_to, s.status, p.name 
                FROM `sale_items` AS item 
                INNER JOIN `sale` AS s ON item.sale_id = s.sale_id 
                INNER JOIN `product` AS p ON item.product_id = p.product_id 
                WHERE item.user_id = '$user_id' 
                ORDER BY s.updated_at DESC
            ");
            $data["orders"] = $orders->result();
            $this->load->view("admin/seller/edit",$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function restaurants()
    {
        if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "restaurants";
            $this->load->model("restaurant_model");
            $data["users"] = $this->restaurant_model->get_restaurants();
            $this->load->view('admin/restaurants/list',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function add_restaurant()
    {
       if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "restaurants";
           $this->load->model("restaurant_model");
           $this->load->view('admin/restaurants/add',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function post_restaurant()
    {
        if(_is_user_login($this)){
            $phone = $_POST['phone'];
            $qry=$this->db->query("SELECT * FROM `registers` where `user_phone` = '".$phone."'");
            $check = $qry->result();
            if ($check) {
                $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                    <i class="fa fa-warning"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> phone number is already in use
                                </div>');
            }
            else{
                $_POST['user_password'] = md5($_POST['password']);unset($_POST['password']);unset($_POST['addrestaurant']);
                $_POST['type'] = 'restaurant';
                $_POST['featured'] = ($_POST['featured']=="on")? 'yes' : 'no';
                $_POST['is_new'] = ($_POST['is_new']=="on")? 'yes' : 'no';
                $_POST['show_name'] = ($_POST['show_name']=="on")? 'yes' : 'no';
                $_POST['status'] = ($_POST['status']=="on")? 1 : 0;
                $resp = $this->db->insert('registers',$_POST);
                if ($resp) {
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Restaurant added successfully...
                                    </div>');
                    redirect('admin/restaurants');
                }
                else{
                    $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                    <i class="fa fa-warning"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> something wrong please try again.
                                </div>');
                    redirect('admin/add_restaurant');
                }
            }  
        }
        else
        {
            redirect('admin');
        }
    }
    public function edit_restaurant($user_id)
    {
        if(_is_user_login($this)){
        
            if(isset($_POST['profile']))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('name', 'Name', 'trim|required');
                // $this->form_validation->set_rules('email', 'Email', 'trim|required');
                $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
                $this->form_validation->set_rules('password', 'Password', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                   }
                }
                else
                {
                    extract($_POST);
                    $status = ($this->input->post("status")=="on")? 1 : 0;
                    $this->db->select('user_password'); // Change it to what column name you have for id
                    $this->db->from('registers');
                    $this->db->where('user_id',$user_id ); // 'Yes' or 'yes', depending on what you have in db
                    $query = $this->db->get();
                    $pass= $query->row();
                    
                    if($pass->user_password==$password) 
                    {
                        $password_new=$password;
                    }
                    else
                    {
                        $password_new=md5($password);
                    }
                    
                    $update=$this->db->query("UPDATE `registers` SET `user_phone`='".$phone."',`user_fullname`='".$name."',`user_email`='".$email."',`user_password`='".$password_new."',`city`='".$city."',`address`='".$address."',status='".$status."' WHERE `user_id`='".$user_id."'");
                    if(!$update){
                        redirect('admin/restaurants');
                    }
                    
                   //$this->product_model->edit_deal_product($id,$array); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request edited successfully...
                                    </div>');
                    redirect('admin/restaurants');
                }
            }
            
            if(isset($_POST['amount']))
            {
                $_POST['featured'] = ($_POST['featured']=="on")? 'yes' : 'no';
                $_POST['is_new'] = ($_POST['is_new']=="on")? 'yes' : 'no';
                $_POST['show_name'] = ($_POST['show_name']=="on")? 'yes' : 'no';
                unset($_POST['amount']);
                $this->db->where('user_id',$user_id );
                $resp = $this->db->update('registers',$_POST );
                unset($_POST);
                if ($resp) {
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request edited successfully...
                                    </div>');
                    redirect('admin/restaurants');
                }
                else{
                    $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> some data missing please try again
                                    </div>');
                }

            }
            $this->load->model("product_model");
            $qry=$this->db->query("SELECT * FROM `registers` where user_id = '".$user_id."'");
            $data["user"] = $qry->result();
            $orders=$this->db->query("
                SELECT item.*, s.on_date, s.delivery_time_from, s.delivery_time_to, s.status, p.name 
                FROM `sale_items` AS item 
                INNER JOIN `sale` AS s ON item.sale_id = s.sale_id 
                INNER JOIN `product` AS p ON item.product_id = p.product_id 
                WHERE item.user_id = '$user_id' 
                ORDER BY s.on_date DESC
            ");
            $data["orders"] = $orders->result();
            $this->load->view("admin/restaurants/edit",$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function brands()
    {
        if ($_SESSION['user_type_id'] == '1') {
            redirect('dashboard');
        }
        if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "brands";
           $this->load->model("brand_model");
           $data["brands"] = $this->brand_model->get_brands();
           $this->load->view('admin/brands/listbrand',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function addbrand()
    {
       if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "addbrand";
            if(isset($_REQUEST["addbrand"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('title', 'Brand Title', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                    }
                }
                else
                {
                    $this->load->model("brand_model");
                    $this->brand_model->add_brand();
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/addbrand');
                }
            }
            $this->load->view('admin/brands/addbrand',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function editbrand($id)
    {
       if(_is_user_login($this))
       {
            $q = $this->db->query("select * from `brand` WHERE brand_id=".$id);
            $data["brand"] = $q->row();
            
            $data["error"] = "";
            $data["active"] = "brands";
            if(isset($_REQUEST["savebrand"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('title', 'Brand Title', 'trim|required');
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                   }
                }
                else
                {
                    $this->load->model("brand_model");
                    $this->brand_model->edit_brand(); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your category saved successfully...
                                    </div>');
                    redirect('admin/brands');
                }
            }
           $this->load->view('admin/brands/editbrand',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function addbrandcsv()
    {
       if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "addbrand";
            $this->load->view('admin/brands/addbrandcsv',$data);
        }
        else{
            redirect('admin');
        }
    }
    public function stores()
    {
       if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "stores";
           $this->load->model("brand_model");
           $data["stores"] = $this->brand_model->get_stores();
           $this->load->view('admin/stores/stores',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function addstore()
    {
       if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "addstore";
            if(isset($_REQUEST["addstore"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('title', 'Store Title', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                    }
                }
                else
                {
                    $this->load->model("brand_model");
                    $this->brand_model->add_store(); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/addstore');
                }
            }
        $this->load->view('admin/stores/addstore',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function editstore($id)
    {
       if(_is_user_login($this))
       {
            $q = $this->db->query("select * from `store` WHERE store_id=".$id);
            $data["store"] = $q->row();
            
            $data["error"] = "";
            $data["active"] = "stores";
            if(isset($_REQUEST["savestore"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('title', 'Store Title', 'trim|required');
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                   }
                }
                else
                {
                    $this->load->model("brand_model");
                    $this->brand_model->edit_store(); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your category saved successfully...
                                    </div>');
                    redirect('admin/stores');
                }
            }
           $this->load->view('admin/stores/editstore',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function header_categories()
    {
       if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "listcat";
           $this->load->model("category_model");
           $data["allcat"] = $this->category_model->get_header_categories();
           $this->load->view('admin/icon_categories/listcat',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function deletecat($id)
    {
       if(_is_user_login($this)){
            
            $this->db->delete("categories",array("id"=>$id));
            $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your item deleted successfully...
                                    </div>');
            redirect('admin/listcategories');
        }
        else
        {
            redirect('admin');
        }
    }
    public function deletebrand($id)
    {
       if(_is_user_login($this)){
            
            $this->db->delete("brand",array("brand_id"=>$id));
            $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your item deleted successfully...
                                    </div>');
            redirect('admin/brands');
        }
        else
        {
            redirect('admin');
        }
    }
    public function deletestore($id)
    {
       if(_is_user_login($this)){
            
            $this->db->delete("store",array("store_id"=>$id));
            $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your item deleted successfully...
                                    </div>');
            redirect('admin/stores');
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function delete_header_categories($id)
    {
       if(_is_user_login($this)){
            
            $this->db->delete("header_categories",array("id"=>$id));
            $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your item deleted successfully...
                                    </div>');
            redirect('admin/header_categories');
        }
        else
        {
            redirect('admin');
        }
    }

      
/* ========== End Categories ========== */    
/* ========== Products ==========*/
function products($catId = 0){
    error_reporting(E_ALL);
    if(_is_user_login($this)){
        $this->load->model("product_model");
        if ($catId > 0) {
            $data["products"]  = $this->product_model->get_products(false,$catId);
        }
        else{
            $data["products"]  = $this->product_model->get_products();
        }
        $this->load->view("admin/product/list2",$data);
    }
    else
    {
        redirect('admin');
    }
}
public function product_images_bulk(){
    if(_is_user_login($this)){
        $data['test'] = true;
        $this->load->model("product_model");
        $this->load->view("admin/product/product_images_bulk",$data);
    }
    else
    {
        redirect('admin');
    }
}
public function uploadproductbulkimages()
{
    if(_is_user_login($this)){
        if($_FILES["userfile"]["size"] > 0){
            $config['upload_path'] = './uploads/products/';
            $config['allowed_types'] = 'zip';
            $this->upload->initialize($config);
            if ( ! $this->upload->do_upload('userfile'))
            {
                $error = array('error' => $this->upload->display_errors());
                echo json_encode($error);
            }
            else
            {
                redirect('admin/product_images_bulk');
            }
        }
    }
    else
    {
        redirect('admin');
    }
}
public function get_product_images()
{
    if(_is_user_login($this)){
        $images = $this->get_results("SELECT * FROM `product_image` WHERE `product_id` = '".$_POST['id']."';");
        if ($images) {
            $html = '';
            foreach ($images as $key => $q) {
                $html .= '<tr>';
                    $html .= '<td><img width="200px" src="'.$this->config->item('base_url').'uploads/products/'.$_POST['cat'].'/'.$q['image'].'" /></td>';
                    $html .= '<td><a href="javascript://" class="delete-product-image btn btn-danger btn-round" data-id="'.$q['product_image_id'].'"><i class="material-icons">close</i></a></td>';
                $html .= '</tr>';
            }
            echo json_encode(array("status"=>true,"html"=>$html));
        }
        else{
            echo json_encode(array("status"=>false));
        }
    }
    else
    {
        redirect('admin');
    }
}

public function delete_product_image()
{
    if(_is_user_login($this)) {
        $id = $_POST['id'];
        $resp = $this->db->query("delete from product_image where product_image_id = '".$id."'");
        if ($resp) {
            echo json_encode(array("status"=>true));
        }
        else{
            echo json_encode(array("status"=>false,"msg"=>"not deleted, please try again or reload youyr web page."));
        }
    }
    else
    {
        redirect('admin');
    }
}


public function upload_product_images($id,$cat)
{
    if(_is_user_login($this)){
        if ($_FILES){
            for ($i=0; $i < count($_FILES); $i++) { 
                $config['upload_path'] = 'uploads/products/'.$cat.'/';
                $config['allowed_types'] = 'gif|jpg|png|PNG|JPEG|JPG';
                $config['encrypt_name'] = TRUE;
                $ext = pathinfo($_FILES['img'.$i]['name'], PATHINFO_EXTENSION);
                $new_name = md5(time().$_FILES['img'.$i]['name']).'.'.$ext;
                $config['file_name'] = $new_name;
                //$this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('img'.$i))
                {
                    $final[$i]['img'] = $this->upload->data()['file_name'];
                }
            }
            if (count($final) > 0) {
                foreach ($final as $key => $img) {
                    $post['product_id'] = $id;
                    $post['image'] = $img['img'];
                    $this->db->insert('product_image',$post);
                }
                $images = $this->get_results("SELECT * FROM `product_image` WHERE `product_id` = '$id';");
                if ($images) {
                    $html = '';
                    foreach ($images as $key => $q) {
                        $html .= '<tr>';
                            $html .= '<td><img width="200" src="'.$this->config->item('base_url').'uploads/products/'.$cat.'/'.$q['image'].'" /></td>';
                            $html .= '<td><a href="javascript://" class="delete-product-image btn btn-danger btn-round" data-id="'.$q['product_image_id'].'"><i class="material-icons">close</i></a></td>';
                        $html .= '</tr>';
                    }
                    echo json_encode(array("status"=>true,"html"=>$html));
                }
                else{
                    echo json_encode(array("status"=>false));
                }
            }
            else {
                echo json_encode(array("status"=>false,"data"=>'Images not uploaded, please try again or reload your webpage or check your internet connection'));
            }
        }
    }
    else{
        redirect('admin');
    }
}


 function header_products(){
        $this->load->model("product_model");
        $data["products"]  = $this->product_model->get_header_products();
        $this->load->view("admin/icon_product/list",$data);    
}

function edit_products($prod_id){
       if(_is_user_login($this)){
            $this->load->model("product_model");
            $data["product"] = $this->product_model->get_product_by_id($prod_id);
            $data['colors'] = $this->get_results("SELECT * FROM `color` WHERE `status` = 'active' ORDER BY `name` ASC;");
            $data['sizes'] = $this->get_results("SELECT * FROM `size` WHERE `status` = 'active' ORDER BY `name` ASC;");
            $cat_id = $data["product"]->category_id;
            $data['cat'] = $this->get_row("SELECT * FROM `categories` WHERE `id` = '$cat_id';");
            
            //$ProductFilters = $this->get_row("SELECT GROUP_CONCAT(`filter_value_id`) AS 'FilterIds' FROM `product_filter_value` WHERE `product_id` = '$prod_id';");
            $ProductFilters = explode(',', $data["product"]->dynamic_filters);
            $FiltersIds = $data['cat']['filter_ids'];
            if ($FiltersIds && strlen($FiltersIds) > 0) {
                $resp = $this->get_results("SELECT `filter_id`,`title` FROM `filter` WHERE `filter_id` IN($FiltersIds) AND `status` = 'active' ORDER BY `title`;");
            }
            else{
                $resp = false;
            }
            if ($resp) {
                $html = '';
                foreach ($resp as $key => $Filter) {
                    $FilterID = $Filter['filter_id'];
                    $values = $this->get_results("SELECT `filter_value_id`,`title` FROM `filter_value` WHERE `filter_id` = '$FilterID' AND `status` = 'active' ORDER BY `title`;");
                    if ($values) {
                        $html .= '<div class="row" style="border-top: 1px solid #eee;border-bottom: 1px solid #eee;margin-top: 10px;padding-top: 10px;">';
                            $html .= '<label class="col-md-3 label-on-left">'.$Filter['title'].'</label>';
                            $html .= '<div class="col-md-9">';
                                foreach ($values as $key => $filter){
                                    $html .= '<div class="form-group">';
                                        if (in_array($filter['filter_value_id'], $ProductFilters)) {
                                            $html .= '<input type="checkbox" name="filter_value_id[]" value="'.$filter['filter_value_id'].'" checked="checked"> &nbsp;&nbsp;';
                                        }
                                        else{
                                            $html .= '<input type="checkbox" name="filter_value_id[]" value="'.$filter['filter_value_id'].'"> &nbsp;&nbsp;';
                                        }
                                        $html .= '<label class="control-label">'.$filter['title'].'</label>';
                                    $html .= '</div><!-- /form-group -->';
                                }
                            $html .= '</div>';
                        $html .= '</div>';
                    }
                }
                $data['filters_html'] = $html;
            }
            else{
                $data['filters_html'] = 'false';
            }

            $tags = $this->get_results("
                SELECT ct.*, pt.value 
                FROM `cat_tag` AS ct 
                LEFT JOIN `product_tag` AS pt ON ct.cat_tag_id = pt.cat_tag_id 
                WHERE ct.status = 'active' AND ct.category_id = '$cat_id' AND pt.product_id = '$prod_id' 
                ORDER BY ct.name ASC;
            ");
            if ($tags) {
                $data['tags_html'] = $this->get_cat_tags_edit($tags);
            }
            else{
                $data['tags_html'] = false;
            }
            $this->load->view("admin/product/edit2",$data);
        }
        else
        {
            redirect('admin');
        }
}


public function update_product()
{
    if(_is_user_login($this)){
        if(isset($_POST))
        {
            $ProductID = $_POST['product_id'];
            unset($_POST['addcatg']);
            unset($_POST['product_id']);
            if($_FILES["prod_img"]["size"] > 0){
                $config['upload_path'] = './uploads/products/'.$_POST['category_id'].'/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                //$this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ( ! $this->upload->do_upload('prod_img'))
                {
                    $error = array('error' => $this->upload->display_errors());
                }
                else
                {
                    $img_data = $this->upload->data();
                    $_POST["product_image"]=$img_data['file_name'];
                }
            }
            
            $colors = '';
            $colorImages = '';
            $ImageCount = 0;
            $ColorCount = 0;
            $colorPrice = 0;
            foreach ($_POST['color'] as $key => $color) {
                if ($key == 0) {
                    $colors = $color;
                }
                else{
                    $colors .= ','.$color;
                }
                if ($ColorCount == 0) {
                    if (isset($_POST['color_price'.$color])) {
                        $colorPrice = $color.'-'.$_POST['color_price'.$color];
                        $ColorCount = 1;
                    }
                }
                else{
                    if (isset($_POST['color_price'.$color])) {
                        $colorPrice .= ','.$color.'-'.$_POST['color_price'.$color];
                    }
                }
                unset($_POST['color_price'.$color]);
                unset($_POST['color'][$key]);
                if($_FILES['color_file'.$color]['size'] > 0){
                    $config['upload_path'] = './uploads/products/'.$_POST['category_id'].'/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    // $config['encrypt_name'] = TRUE;
                    $ext = pathinfo($_FILES['color_file'.$color]['name'], PATHINFO_EXTENSION);
                    $new_name = $color.'-'.md5(time().$_FILES['color_file'.$color]['name']).'.'.$ext;
                    $config['file_name'] = $new_name;
                    //$this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ( ! $this->upload->do_upload('color_file'.$color))
                    {
                        $error = array('error' => $this->upload->display_errors());
                    }
                    else
                    {
                        $img_data = $this->upload->data();
                        if ($ImageCount == 0) {
                            $colorImages = $img_data['file_name'];
                            $ImageCount = 1;
                        }
                        else{
                            $colorImages .= ','.$img_data['file_name'];
                        }
                    }
                }
                else{
                    if ($key == 0) {
                        if (strlen($_POST['color_file_value'.$color]) > 4) {
                            $colorImages = $_POST['color_file_value'.$color];
                            unset($_POST['color_file_value'.$color]);
                        }
                    }
                    else{
                        if (strlen($_POST['color_file_value'.$color]) > 4) {
                            $colorImages .= ','.$_POST['color_file_value'.$color];
                            unset($_POST['color_file_value'.$color]);
                        }
                    }
                }
            }
            $_POST['color'] = $colors;
            $_POST['color_price'] = $colorPrice;
            $_POST['color_images'] = $colorImages;

            $sizes = '';
            $SizeCount = 0;
            $sizePrice = 0;
            foreach ($_POST['size'] as $key => $size) {
                if ($key == 0) {
                    $sizes = $size;
                }
                else{
                    $sizes .= ','.$size;
                }
                unset($_POST['size'][$key]);
                if ($SizeCount == 0) {
                    if (isset($_POST['size_price'.$size])) {
                        $sizePrice = $size.'-'.$_POST['size_price'.$size];
                        $SizeCount = 1;
                    }
                }
                else{
                    if (isset($_POST['size_price'.$size])) {
                        $sizePrice .= ','.$size.'-'.$_POST['size_price'.$size];
                    }
                }
                unset($_POST['size_price'.$size]);
            }
            $_POST['size'] = $sizes;
            $_POST['size_price'] = $sizePrice;

            $cat_tag_value = $_POST['cat_tag_value'];unset($_POST['cat_tag_value']);
            $cat_tag_id = $_POST['cat_tag_id'];unset($_POST['cat_tag_id']);

            $_POST['price'] = $_POST['price'] - $_POST['discount'];

            $_POST['slug'] = $this->clean($_POST['product_name']);

            $filters = $_POST['filter_value_id'];unset($_POST['filter_value_id']);
            $_POST['dynamic_filters'] = implode(',', $filters);
            if (strlen($_POST['dynamic_filters']) > 0) {
                $_POST['dynamic_filters'] = $_POST['dynamic_filters'];
            }
            else{
                $_POST['dynamic_filters'] = 0;
            }

            //Meta Data
            $Brand = $this->get_row("SELECT `title` FROM `brand` WHERE `brand_id` = '".$_POST['brand_id']."'");
            $Category = $this->get_row("SELECT `title` FROM `categories` WHERE `id` = '".$_POST['category_id']."'");
            //meta_title
            $meta_title = $this->get_setting_byid(9);
            $meta_title = str_replace('[product]', $_POST['product_name'], $meta_title['value']);
            $meta_title = str_replace('[brand]', $Brand['title'], $meta_title);
            $meta_title = str_replace('[category]', $Category['title'], $meta_title);
            $_POST['meta_title'] = $meta_title;

            //meta_key
            $meta_key = $this->get_setting_byid(10);
            $meta_key = str_replace('[product]', $_POST['product_name'], $meta_key['value']);
            $meta_key = str_replace('[brand]', $Brand['title'], $meta_key);
            $meta_key = str_replace('[category]', $Category['title'], $meta_key);
            $_POST['meta_key'] = $meta_key;

            //meta_desc
            $meta_desc = $this->get_setting_byid(11);
            $meta_desc = str_replace('[product]', $_POST['product_name'], $meta_desc['value']);
            $meta_desc = str_replace('[brand]', $Brand['title'], $meta_desc);
            $meta_desc = str_replace('[category]', $Category['title'], $meta_desc);
            $_POST['meta_desc'] = $meta_desc;

            $this->db->where("product_id",$ProductID);
            $this->db->update("products",$_POST);
            $this->db->delete("product_tag",array("product_id"=>$ProductID));

            foreach ($cat_tag_id as $key => $id) {
                $post['product_id'] = $ProductID;
                $post['cat_tag_id'] = $id;
                $post['value'] = $cat_tag_value[$key];
                $this->db->insert("product_tag",$post);
            }

            $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                <i class="fa fa-check"></i>
                              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                              <strong>Success!</strong> Your request added successfully...
                            </div>');
            redirect('admin/products/'.$_POST['category_id']);
        }
    }
    else{
        redirect('admin');
    }
}





function edit_header_products($prod_id){
       if(_is_user_login($this)){
        
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('prod_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                   }
                }
                else
                {
                    $this->load->model("common_model");
                    $array = array( 
                    "product_name"=>$this->input->post("prod_title"), 
                    "category_id"=>$this->input->post("parent"), 
                    "product_description"=>$this->input->post("product_description"),
                    "in_stock"=>$this->input->post("prod_status"),
                    "price"=>$this->input->post("price"),
                    "unit_value"=>$this->input->post("qty"),
                    "unit"=>$this->input->post("unit"),
                    "rewards"=>$this->input->post("rewards")
                    
                    );
                    if($_FILES["prod_img"]["size"] > 0){
                        $config['upload_path']          = './uploads/products/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg';
                        //$this->load->library('upload', $config);
                        $this->upload->initialize($config);
        
                        if ( ! $this->upload->do_upload('prod_img'))
                        {
                                $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            $img_data = $this->upload->data();
                            $array["product_image"]=$img_data['file_name'];
                        }
                        
                   }
                    
                    $this->common_model->data_update("header_products",$array,array("product_id"=>$prod_id)); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/header_products');
                }
            }
            $this->load->model("product_model");
            $data["product"] = $this->product_model->get_header_product_by_id($prod_id);
            $this->load->view("admin/icon_product/edit",$data);
        }
        else
        {
            redirect('admin');
        }
    
}

function add_products(){
       if(_is_user_login($this)){
            
            $data['colors'] = $this->get_results("SELECT * FROM `color` WHERE `status` = 'active' ORDER BY `name` ASC;");
            $data['sizes'] = $this->get_results("SELECT * FROM `size` WHERE `status` = 'active' ORDER BY `name` ASC;");
            $data['parents'] = $this->get_results("SELECT * FROM `categories` WHERE `parent` = '0' AND `leval` = '0' ORDER BY `title` ASC");

            $this->load->view("admin/product/add2",$data);
        }
        else
        {
            redirect('admin');
        }
    
}


public function post_product()
{
    if(_is_user_login($this)){
        if(isset($_POST))
        {
            unset($_POST['addcatg']);
            if($_FILES["prod_img"]["size"] > 0){
                $config['upload_path'] = './uploads/products/'.$_POST['category_id'].'/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                //$this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ( ! $this->upload->do_upload('prod_img'))
                {
                    $error = array('error' => $this->upload->display_errors());
                }
                else
                {
                    $img_data = $this->upload->data();
                    $_POST["product_image"]=$img_data['file_name'];
                }
            }
            
            $colors = '';
            $colorImages = '';
            $ImageCount = 0;
            $ColorCount = 0;
            $colorPrice = 0;
            foreach ($_POST['color'] as $key => $color) {
                if ($key == 0) {
                    $colors = $color;
                }
                else{
                    $colors .= ','.$color;
                }
                unset($_POST['color'][$key]);
                if ($ColorCount == 0) {
                    if (isset($_POST['color_price'.$color])) {
                        $colorPrice = $color.'-'.$_POST['color_price'.$color];
                        $ColorCount = 1;
                    }
                }
                else{
                    if (isset($_POST['color_price'.$color])) {
                        $colorPrice .= ','.$color.'-'.$_POST['color_price'.$color];
                    }
                }
                unset($_POST['color_price'.$color]);
                if($_FILES['color_file'.$color]['size'] > 0){
                    $config['upload_path'] = './uploads/products/'.$_POST['category_id'].'/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    //$config['encrypt_name'] = TRUE;
                    $ext = pathinfo($_FILES['color_file'.$color]['name'], PATHINFO_EXTENSION);
                    $new_name = $color.'-'.md5(time().$_FILES['color_file'.$color]['name']).'.'.$ext;
                    $config['file_name'] = $new_name;
                    //$this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ( ! $this->upload->do_upload('color_file'.$color))
                    {
                        $error = array('error' => $this->upload->display_errors());
                    }
                    else
                    {
                        $img_data = $this->upload->data();
                        if ($ImageCount == 0) {
                            $colorImages = $img_data['file_name'];
                            $ImageCount = 1;
                        }
                        else{
                            $colorImages .= ','.$img_data['file_name'];
                        }
                    }
                }
            }
            $_POST['color'] = $colors;
            $_POST['color_price'] = $colorPrice;
            $_POST['color_images'] = $colorImages;

            $sizes = '';
            $SizeCount = 0;
            $sizePrice = 0;
            foreach ($_POST['size'] as $key => $size) {
                if ($key == 0) {
                    $sizes = $size;
                }
                else{
                    $sizes .= ','.$size;
                }
                unset($_POST['size'][$key]);
                if ($SizeCount == 0) {
                    if (isset($_POST['size_price'.$size])) {
                        $sizePrice = $size.'-'.$_POST['size_price'.$size];
                        $SizeCount = 1;
                    }
                }
                else{
                    if (isset($_POST['size_price'.$size])) {
                        $sizePrice .= ','.$size.'-'.$_POST['size_price'.$size];
                    }
                }
                unset($_POST['size_price'.$size]);
            }
            $_POST['size'] = $sizes;
            $_POST['size_price'] = $sizePrice;

            $cat_tag_value = $_POST['cat_tag_value'];unset($_POST['cat_tag_value']);
            $cat_tag_id = $_POST['cat_tag_id'];unset($_POST['cat_tag_id']);

            $_POST['slug'] = $this->clean($_POST['product_name']);

            $_POST['price'] = $_POST['price'] - $_POST['discount'];

            $filters = $_POST['filter_value_id'];unset($_POST['filter_value_id']);
            $_POST['dynamic_filters'] = implode(',', $filters);
            if (strlen($_POST['dynamic_filters']) > 0) {
                $_POST['dynamic_filters'] = $_POST['dynamic_filters'];
            }
            else{
                $_POST['dynamic_filters'] = 0;
            }

            //Meta Data
            $Brand = $this->get_row("SELECT `title` FROM `brand` WHERE `brand_id` = '".$_POST['brand_id']."'");
            $Category = $this->get_row("SELECT `title` FROM `categories` WHERE `id` = '".$_POST['category_id']."'");
            //meta_title
            $meta_title = $this->get_setting_byid(9);
            $meta_title = str_replace('[product]', $_POST['product_name'], $meta_title['value']);
            $meta_title = str_replace('[brand]', $Brand['title'], $meta_title);
            $meta_title = str_replace('[category]', $Category['title'], $meta_title);
            $_POST['meta_title'] = $meta_title;

            //meta_key
            $meta_key = $this->get_setting_byid(10);
            $meta_key = str_replace('[product]', $_POST['product_name'], $meta_key['value']);
            $meta_key = str_replace('[brand]', $Brand['title'], $meta_key);
            $meta_key = str_replace('[category]', $Category['title'], $meta_key);
            $_POST['meta_key'] = $meta_key;

            //meta_desc
            $meta_desc = $this->get_setting_byid(11);
            $meta_desc = str_replace('[product]', $_POST['product_name'], $meta_desc['value']);
            $meta_desc = str_replace('[brand]', $Brand['title'], $meta_desc);
            $meta_desc = str_replace('[category]', $Category['title'], $meta_desc);
            $_POST['meta_desc'] = $meta_desc;

            $this->db->insert("products",$_POST);
            $lastID = $this->db->insert_id();

            foreach ($cat_tag_id as $key => $id) {
                $post['product_id'] = $lastID;
                $post['cat_tag_id'] = $id;
                $post['value'] = $cat_tag_value[$key];
                $this->db->insert("product_tag",$post);
            }

            $purchaasr=$this->db->query("Insert into purchase(product_id, qty, unit, date, store_id_login) values('".$lastID."', 1, '".$_POST['unit']."', '".date('d-m-y h:i:s ')."', '"._get_current_user_id($this)."')");
            if($purchaasr){ $m=1; }else{ $m=0; }
            $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                <i class="fa fa-check"></i>
                              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                              <strong>Success!</strong> Your request added successfully..."'.$m.'"
                            </div>');
            redirect('admin/products');
        }
    }
    else{
        redirect('admin');
    }
}

function add_header_products(){
       if(_is_user_login($this)){
        
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('prod_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                 $this->form_validation->set_rules('price', 'price', 'trim|required');
                $this->form_validation->set_rules('qty', 'qty', 'trim|required'); 
                
                if ($this->form_validation->run() == FALSE)
                {
                      if($this->form_validation->error_string()!="") { 
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                 }
                                   
                }
                else
                {
                    $this->load->model("common_model");
                    $array = array( 
                    "product_name"=>$this->input->post("prod_title"), 
                    "category_id"=>$this->input->post("parent"),
                    "in_stock"=>$this->input->post("prod_status"),
                    "product_description"=>$this->input->post("product_description"),
                    "price"=>$this->input->post("price"),
                    "unit_value"=>$this->input->post("qty"),
                    "unit"=>$this->input->post("unit"), 
                    "rewards"=>$this->input->post("rewards")
                    );
                    if($_FILES["prod_img"]["size"] > 0){
                        $config['upload_path']          = './uploads/products/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg';
                        //$this->load->library('upload', $config);
                        $this->upload->initialize($config);
        
                        if ( ! $this->upload->do_upload('prod_img'))
                        {
                                $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            $img_data = $this->upload->data();
                            $array["product_image"]=$img_data['file_name'];
                        }
                        
                   }
                    
                    $this->common_model->data_insert("header_products",$array); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/header_products');
                }
            }
            
            $this->load->view("admin/icon_product/add");
        }
        else
        {
            redirect('admin');
        }
    
}

function delete_product($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from products where product_id = '".$id."'");
            $this->db->query("Delete from product_tag where product_id = '".$id."'");
            redirect("admin/products");
        }
        else
        {
            redirect('admin');
        }
        
}

function delete_header_product($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from header_products where product_id = '".$id."'");
            redirect("admin/header_products");
        }
}

/* ========== Products ==========*/  
/* ========== Purchase ==========*/
public function add_purchase(){
    if(_is_user_login($this)){
        
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('product_id', 'product_id', 'trim|required');
                $this->form_validation->set_rules('qty', 'Qty', 'trim|required');
                $this->form_validation->set_rules('unit', 'Unit', 'trim|required');
                if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                }
                else
                {
              
                    $this->load->model("common_model");
                    $array = array(
                    "product_id"=>$this->input->post("product_id"),
                    "qty"=>$this->input->post("qty"),
                    "price"=>$this->input->post("price"),
                    "unit"=>$this->input->post("unit")
                    );
                    $this->common_model->data_insert("purchase",$array);
                    
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("admin/add_purchase");
                }
                
                $this->load->model("product_model");
                $data["purchases"]  = $this->product_model->get_purchase_list();
                $data["products"]  = $this->product_model->get_products();
                $this->load->view("admin/product/purchase2",$data);  
                
            }
    }
    else
    {
        redirect('admin');
    }
    
}

function edit_purchase($id){
    if(_is_user_login($this)){
        
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('product_id', 'product_id', 'trim|required');
                $this->form_validation->set_rules('qty', 'Qty', 'trim|required');
                $this->form_validation->set_rules('unit', 'Unit', 'trim|required');
                if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                }
                else
                {
              
                    $this->load->model("common_model");
                    $array = array(
                    "product_id"=>$this->input->post("product_id"),
                    "qty"=>$this->input->post("qty"),
                    "price"=>$this->input->post("price"),
                    "unit"=>$this->input->post("unit")
                    );
                    $this->common_model->data_update("purchase",$array,array("purchase_id"=>$id));
                    
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("admin/add_purchase");
                }
                
                $this->load->model("product_model");
                $data["purchase"]  = $this->product_model->get_purchase_by_id($id);
                $data["products"]  = $this->product_model->get_products();
                $this->load->view("admin/product/edit_purchase2",$data);  
                
            }
    }
    else
    {
        redirect('admin');
    }
}

function delete_purchase($id){
    if(_is_user_login($this)){
        $this->db->query("Delete from purchase where purchase_id = '".$id."'");
        redirect("admin/add_purchase");
    }
    else
    {
        redirect('admin');
    }
}
/* ========== Purchase END ==========*/
    public function socity(){
        if(_is_user_login($this)){
            
                if(isset($_POST))
                {
                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('pincode', 'pincode', 'trim|required');
                    $this->form_validation->set_rules('socity_name', 'Socity Name', 'trim|required');
                     $this->form_validation->set_rules('delivery', 'Delivery Charges', 'trim|required');

                    if ($this->form_validation->run() == FALSE)
                    {
                      if($this->form_validation->error_string()!="")
                          $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                            <i class="fa fa-warning"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                        </div>');
                    }
                    else
                    {
                  
                        $this->load->model("common_model");
                        $array = array(
                        "socity_name"=>$this->input->post("socity_name"),
                        "pincode"=>$this->input->post("pincode"),
                          "delivery_charge"=>$this->input->post("delivery")

                        );
                        $this->common_model->data_insert("socity",$array);
                        
                        $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your request added successfully...
                                        </div>');
                        redirect("admin/socity");
                    }
                    
                    $this->load->model("product_model");
                    $data["socities"]  = $this->product_model->get_socities();
                    $this->load->view("admin/socity/list2",$data);  
                    
                }
        }
        else
        {
            redirect('admin');
        }
            
    }

    public function city(){
        if(_is_user_login($this)){


            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('city_name', 'City Name', 'trim|required');
                $this->form_validation->set_rules('delivery_charge', 'Delivery Charges', 'trim|required');

                if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                }
                else
                {
              
                    $this->load->model("common_model");
                    $array = array(
                    "city_name"=>$this->input->post("city_name"),
                    "delivery_charge"=>$this->input->post("delivery_charge")
                    );
                    $this->common_model->data_insert("city",$array);
                    
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("admin/city");
                } 
                
            }
        
            $ct  = $this->db->query("select * from `city`");
            $data["cities"] = $ct->result();
            $this->load->view("admin/socity/city_list",$data);  
        }
        else{
            redirect("admin");
        }
        
    }

    public function delete_city($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from city where city_id = '".$id."'");
            redirect("admin/city");
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function declared_rewards(){
        if(_is_user_login($this)){
            
                $this->load->library('form_validation');
               $this->load->model("product_model");
               
                   
                    
                     $this->form_validation->set_rules('delivery', 'Delivery Charges', 'trim|required');

                    if (!$this->form_validation->run() == FALSE)
                    {
                        
                        $point = array(
                           'point' => $this->input->post('delivery')
                          
                        );
                        
                        $this->product_model->update_reward($point);
                        
                        
                      if($this->form_validation->error_string()!="")
                          $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                            <i class="fa fa-warning"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                        </div>');
                    
                    
                   }
                    
                    $data['rewards']  = $this->product_model->rewards_value();
                    //print_r( $data['rewards']);
                    $this->load->view("admin/declared_rewards/edit2",$data);  
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function edit_socity($id){
        if(_is_user_login($this)){
        
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('pincode', 'pincode', 'trim|required');
                $this->form_validation->set_rules('socity_name', 'Socity Name', 'trim|required');
                $this->form_validation->set_rules('delivery', 'Delivery Charges', 'trim|required');

                if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                }
                else
                {
              
                    $this->load->model("common_model");
                    $array = array(
                    "socity_name"=>$this->input->post("socity_name"),
                    "pincode"=>$this->input->post("pincode"),
                       "delivery_charge"=>$this->input->post("delivery")

                    );
                    $this->common_model->data_update("socity",$array,array("socity_id"=>$id));
                    
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("admin/socity");
                }
                
                $this->load->model("product_model");
                $data["socity"]  = $this->product_model->get_socity_by_id($id);
                $this->load->view("admin/socity/edit2",$data);  
                
            }
        }
        else
        {
            redirect('admin');
        }
        
    }
    public function edit_city($id){
        if(_is_user_login($this)){
        
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('city_name', 'City Name', 'trim|required');
                $this->form_validation->set_rules('delivery_charge', 'Delivery Charges', 'trim|required');

                if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                }
                else
                {
              
                    $this->load->model("common_model");
                    $array = array(
                    "city_name"=>$this->input->post("city_name"),
                       "delivery_charge"=>$this->input->post("delivery_charge")

                    );
                    $this->common_model->data_update("city",$array,array("city_id"=>$id));
                    
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("admin/city");
                }
                
                $this->load->model("product_model");
                $data["city"]  = $this->product_model->get_city_by_id($id);
                $this->load->view("admin/socity/editCity",$data);  
                
            }
        }
        else
        {
            redirect('admin');
        }
        
    }
    public function delete_socity($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from socity where socity_id = '".$id."'");
            redirect("admin/socity");
        }
        else
        {
            redirect('admin');
        }
    }

    function registers(){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $users = $this->product_model->get_all_users();
            $this->load->view("admin/allusers2",array("users"=>$users));
        }
        else
        {
            redirect('admin');
        }
    }
 
 /* ========== Page app setting =========*/
public function addpage_app()
    {
       if(_is_user_login($this))
       {
           
            $data["error"] = "";
            $data["active"] = "addpageapp"; 
            
            if(isset($_REQUEST["addpageapp"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('page_title', 'Page  Title', 'trim|required');
                $this->form_validation->set_rules('page_descri', 'Page Description', 'trim|required');
                if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                }
                else
                {
                    $this->load->model("page_app_model");
                    $this->page_app_model->add_page(); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Page added successfully...</div>');
                    redirect('admin/addpage_app');
                }

            }
            $this->load->view('admin/page_app/addpage_app',$data);
        }
        else
        {
            redirect('login');
        }
    }
    
    public function allpageapp()
    {
       if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "allpage";
           
           $this->load->model("page_app_model");
           $data["allpages"] = $this->page_app_model->get_pages();
           
           $this->load->view('admin/page_app/allpage_app2',$data);
        }
        else
        {
            redirect('login');
        }
    }
    public function editpage_app($id)
    {
       if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "allpage";
           
           $this->load->model("page_app_model");
           $data["onepage"] = $this->page_app_model->one_page($id);
           
           if(isset($_REQUEST["savepageapp"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('page_title', 'Page Title', 'trim|required');
                $this->form_validation->set_rules('page_id', 'Page Id', 'trim|required');
                $this->form_validation->set_rules('page_descri', 'Page Description', 'trim|required');
                if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                }
                else
                {
                    $this->load->model("page_app_model");
                    $this->page_app_model->set_page(); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your page saved successfully...</div>');
                    redirect('admin/allpageapp');
                }
            }
           $this->load->view('admin/page_app/editpage_app2',$data);
        }
        else
        {
            redirect('login');
        }
    }
    public function deletepageapp($id)
    {
       if(_is_user_login($this)){
            
            $this->db->delete("pageapp",array("id"=>$id));
            $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your page deleted successfully...
                                    </div>');
            redirect('admin/allpage_app');
        }
        else
        {
            redirect('login');
        }
    }

/* ========== End page page setting ========*/

public function setting(){
    if(_is_user_login($this)){
          $this->load->model("setting_model"); 
                $data["settings"]  = $this->setting_model->get_settings(); 
              
                $this->load->view("admin/setting/settings2",$data);  
    }
    else
    {
        redirect('admin');
    }
}

public function edit_settings($id){
    if(_is_user_login($this)){
        
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                 
                $this->form_validation->set_rules('value', 'Amount', 'trim|required');
                if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                }
                else
                {
              
                    $this->load->model("common_model");
                    $array = array(
                    "title"=>$this->input->post("title"), 
                    "value"=>$this->input->post("value")
                    );
                    
                    $this->common_model->data_update("settings",$array,array("id"=>$id));
                    
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("admin/setting");
                }
                
                $this->load->model("setting_model");
                $data["editsetting"]  = $this->setting_model->get_setting_by_id($id);
                $this->load->view("admin/setting/edit_settings2",$data);  
                
            }
    }
    else
        {
            redirect('admin');
        }
}
    
public function stock(){
    if(_is_user_login($this)){
        $this->load->model("product_model");
        $data["stock_list"] = $this->product_model->get_leftstock();
        $this->load->view("admin/product/stock2",$data);
    }
    else
        {
            redirect('admin');
        }
}
/* ========== End page page setting ========*/
   function testnoti(){
        $token =  "dLmBHiGL_6g:APA91bGp5L_mZ0NwPZiihxIDVmo-d-UV05fvmcIDzDiyJ82ztCelmFl4oFRD2hEOPT2lE--ze-yH6Nac6KxbHspYWSQw4mmw8AZ-3HRrwD_crCO1o3p9mRu9WvOOsaw_vvScMnIIv2np";
    }

    function notification(){
        if(_is_user_login($this)){
        
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('descri', 'Description', 'trim|required');
                  if ($this->form_validation->run() == FALSE)
                  {
                              if($this->form_validation->error_string()!="")
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                  }else{
                            // $message["title"] = 'Minerva Grocery';
                            $message= $this->input->post("descri");
                            ///$message["created_at"] = date("Y-m-d h:i:s");
                            
                            //$msg = $this->input->post("descri");
                            
                            $message=array('title' => 'Minerva Grocery', 'body' => $message ,'sound'=>'Default','image'=>'Notification Image' );
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   
                            //$result = $gcm->send_topics("/topics/rabbitapp",$message ,"ios"); 
                            
                            //$result = $gcm->send_topics("Minerva_Grocery",$message ,"android");
                            //$result = $gcm->send_notification("Minerva_Grocery", $message,"android");
                            
                                                                        $q = $this->db->query("Select user_ios_token from registers");
                                                                        $registers = $q->result();
                                                                  foreach($registers as $regs){
                                                                         if($regs->user_ios_token!=""){
                                                                                 $registatoin_ids[] = $regs->user_ios_token;
                                                                                 $result = $gcm->send_notification($regs->user_ios_token, $message,"android");
                                                                         }
                                                                  }
                    //  if(count($registatoin_ids) > 1000){
                      
                    //   $chunk_array = array_chunk($registatoin_ids,1000);
                    //   foreach($chunk_array as $chunk){
                    //     $result = $gcm->send_notification($chunk, $message,"android");
                    //   }
                      
                    //  }
                    //  else{
    
                    //   //$result = $gcm->send_notification($registatoin_ids, $message,"android");
                    //     }  
                            
                             redirect("admin/notification");
                  }
                   
                   $this->load->view("admin/product/notification2");
                
            }
        }
        else
        {
            redirect('admin');
        }
        
    }
    
    function time_slot(){
        if(_is_user_login($this)){
                $this->load->model("time_model");
                $timeslot = $this->time_model->get_time_slot();
                
                $this->load->library('form_validation');
                $this->form_validation->set_rules('opening_time', 'Opening Hour', 'trim|required');
                $this->form_validation->set_rules('closing_time', 'Closing Hour', 'trim|required');
                if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                }
                else
                {
                  if(empty($timeslot)){
                    $q = $this->db->query("Insert into time_slots(opening_time,closing_time,time_slot) values('".date("H:i:s",strtotime($this->input->post('opening_time')))."','".date("H:i:s",strtotime($this->input->post('closing_time')))."','".$this->input->post('interval')."')");
                  }else{
                    $q = $this->db->query("Update time_slots set opening_time = '".date("H:i:s",strtotime($this->input->post('opening_time')))."' ,closing_time = '".date("H:i:s",strtotime($this->input->post('closing_time')))."',time_slot = '".$this->input->post('interval')."' ");
                  }  
                }            
            
            $timeslot = $this->time_model->get_time_slot();
            $this->load->view("admin/timeslot/edit2",array("schedule"=>$timeslot));
        }
        else
        {
            redirect('admin');
        }
    }

    function closing_hours(){
        if(_is_user_login($this)){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('date', 'Date', 'trim|required');
                    $this->form_validation->set_rules('opening_time', 'Start Hour', 'trim|required');
                    $this->form_validation->set_rules('closing_time', 'End Hour', 'trim|required');
                    if ($this->form_validation->run() == FALSE)
                    {
                      if($this->form_validation->error_string()!="")
                          $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                            <i class="fa fa-warning"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                        </div>');
                    }
                    else
                    {
                          $array = array("date"=>date("Y-m-d",strtotime($this->input->post("date"))),
                          "from_time"=>date("H:i:s",strtotime($this->input->post("opening_time"))),
                          "to_time"=>date("H:i:s",strtotime($this->input->post("closing_time")))
                          ); 
                          $this->db->insert("closing_hours",$array); 
                    }
            
             $this->load->model("time_model");
             $timeslot = $this->time_model->get_closing_date(date("Y-m-d"));
             $this->load->view("admin/timeslot/closing_hours2",array("schedule"=>$timeslot));
        }
        else
        {
            redirect('admin');
        }
            
    }
    
     
    function delete_closing_date($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from closing_hours where id = '".$id."'");
            redirect("admin/closing_hours");
        }
        else
        {
            redirect('admin');
        }
    }

    public function addslider()
    {
       if(_is_user_login($this)){
           
            $data["error"] = "";
            $data["active"] = "addslider";
            
            if(isset($_REQUEST["addslider"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
                if (empty($_FILES['slider_img']['name']))
                {
                    $this->form_validation->set_rules('slider_img', 'Slider Image', 'required');
                }
                
                if ($this->form_validation->run() == FALSE)
                {
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                }
                else
                {
                    $add = array(
                                    "slider_title"=>$this->input->post("slider_title"),
                                    "slider_status"=>$this->input->post("slider_status"),
                                    "slider_url"=>$this->input->post("slider_url")
                                    );
                    
                        if($_FILES["slider_img"]["size"] > 0){
                            $config['upload_path']          = './uploads/sliders/';
                            $config['allowed_types']        = 'gif|jpg|png|jpeg';
                            //$this->load->library('upload', $config);
                            $this->upload->initialize($config);
            
                            if ( ! $this->upload->do_upload('slider_img'))
                            {
                                    $error = array('error' => $this->upload->display_errors());
                            }
                            else
                            {
                                $img_data = $this->upload->data();
                                $add["slider_image"]=$img_data['file_name'];
                            }
                            
                       }
                       
                       $this->db->insert("slider",$add);
                    
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider added successfully...
                                    </div>');
                    redirect('admin/addslider');
                }
            }
        $this->load->view('admin/slider/addslider2',$data);
        }
        else
        {
            redirect('admin');
        }
    }
 
    public function listslider()
    {
        if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "listslider";
           $this->load->model("slider_model");
           $data["allslider"] = $this->slider_model->get_slider();
           $this->load->view('admin/slider/listslider2',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    
    public function add_Banner()
    {
       if(_is_user_login($this)){
           
            $data["error"] = "";
            $data["active"] = "addslider";
            
            if(isset($_REQUEST["addslider"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
                if (empty($_FILES['slider_img']['name']))
                {
                    $this->form_validation->set_rules('slider_img', 'Slider Image', 'required');
                }
                
                if ($this->form_validation->run() == FALSE)
                {
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                }
                else
                {
                    $add = array(
                                    "slider_title"=>$this->input->post("slider_title"),
                                    "slider_status"=>$this->input->post("slider_status"),
                                    "slider_url"=>$this->input->post("slider_url"),
                                    "sub_cat"=>$this->input->post("sub_cat")
                                    );
                    
                        if($_FILES["slider_img"]["size"] > 0){
                            $config['upload_path']          = './uploads/sliders/';
                            $config['allowed_types']        = 'gif|jpg|png|jpeg';
                            //$this->load->library('upload', $config);
                            $this->upload->initialize($config);
            
                            if ( ! $this->upload->do_upload('slider_img'))
                            {
                                    $error = array('error' => $this->upload->display_errors());
                            }
                            else
                            {
                                $img_data = $this->upload->data();
                                $add["slider_image"]=$img_data['file_name'];
                            }
                            
                       }
                       
                       $this->db->insert("banner",$add);
                    
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider added successfully...
                                    </div>');
                    redirect('admin/add_Banner');
                }
            }
        $this->load->view('admin/banner/addslider2',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function banner()
    {
       if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "listslider";
           $this->load->model("slider_model");
           $data["allslider"] = $this->slider_model->banner();
           $this->load->view('admin/banner/listslider2',$data);
        }
        else
        {
            redirect('admin');
        }
    }

    public function edit_banner($id)
    {
       if(_is_user_login($this))
       {
            
            $this->load->model("slider_model");
           $data["slider"] = $this->slider_model->get_banner($id);
           
            $data["error"] = "";
            $data["active"] = "listslider";
            if(isset($_REQUEST["saveslider"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
               
                  if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                }
                else
                {
                    $this->load->model("slider_model");
                    $this->slider_model->edit_banner($id); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider saved successfully...
                                    </div>');
                    redirect('admin/banner');
                }
            }
           $this->load->view('admin/banner/editslider2',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function editslider($id)
    {
       if(_is_user_login($this))
       {
            
            $this->load->model("slider_model");
           $data["slider"] = $this->slider_model->get_slider_by_id($id);
           
            $data["error"] = "";
            $data["active"] = "listslider";
            if(isset($_REQUEST["saveslider"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
               
                  if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                }
                else
                {
                    $this->load->model("slider_model");
                    $this->slider_model->edit_slider($id); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider saved successfully...
                                    </div>');
                    redirect('admin/listslider');
                }
            }
           $this->load->view('admin/slider/editslider2',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function deleteslider($id){

        if(_is_user_login($this))
        {
            $data = array();
            $this->load->model("slider_model");
            $slider  = $this->slider_model->get_slider_by_id($id);
            if($slider){
                $this->db->query("Delete from slider where id = '".$slider->id."'");
                unlink("uploads/sliders/".$slider->slider_image);
                redirect("admin/listslider");
           }
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function delete_banner($id){
        if(_is_user_login($this))
        {
            $data = array();
            $this->db->query("Delete from banner where id = '".$id."'");
            unlink("uploads/sliders/".$slider->slider_image);
            redirect("admin/banner");
        }
        else
        {
            redirect('admin');
        }   
           
    }
    
    public function coupons(){
        if(_is_user_login($this)){
            $this->load->helper('form');
            $this->load->model('product_model');
            $this->load->library('session');
           
            $this->load->library('form_validation');
            $this->form_validation->set_rules('coupon_title', 'Coupon name', 'trim|required|max_length[6]|alpha_numeric');
            $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required|max_length[6]|alpha_numeric');
            $this->form_validation->set_rules('from', 'From', 'required|callback_date_valid');
            $this->form_validation->set_rules('to', 'To', 'required|callback_date_valid');
            
            $this->form_validation->set_rules('value', 'Value', 'required|numeric');
            $this->form_validation->set_rules('cart_value', 'Cart Value', 'required|numeric');
            $this->form_validation->set_rules('restriction', 'Uses restriction', 'required|numeric');

            $data= array();
            $data['coupons'] = $this->product_model->coupon_list();
            if($this->form_validation->run() == FALSE)
            {
                $this->form_validation->set_error_delimiters('<div class="text-danger">not wor', '</div>');
                
                $this->load->view("admin/coupons/coupon_list2",$data); 
                 
            }
            else{
                $data = array(
                'coupon_name'=>$this->input->post('coupon_title'),
                'coupon_code'=> $this->input->post('coupon_code'),
                'valid_from'=> $this->input->post('from'),
                'valid_to'=> $this->input->post('to'),
                'validity_type'=> $this->input->post('product_type'),
                'product_name'=> $this->input->post('printable_name'),
                'discount_type'=> $this->input->post('discount_type'),
                'discount_value'=> $this->input->post('value'),
                'cart_value'=> $this->input->post('cart_value'),
                'uses_restriction'=> $this->input->post('restriction')
                 );
                 //print_r($data);
                 if($this->product_model->coupon($data))
                 {
                     $this->session->set_flashdata('addmessage','Coupon added Successfully.');
                    $data['coupons'] = $this->product_model->coupon_list();
                    $this->load->view("admin/coupons/coupon_list2",$data);
                 }
            }
        }
        else
        {
            redirect('admin');
        }
        
    }  

    public function add_coupons(){
        if(_is_user_login($this))
        {
            $this->load->helper('form');
            $this->load->model('product_model');
            $this->load->library('session');
           
            $this->load->library('form_validation');
            $this->form_validation->set_rules('coupon_title', 'Coupon name', 'trim|required|max_length[6]');
            $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required|max_length[6]');
            /*$this->form_validation->set_rules('from', 'From', 'required|callback_date_valid');
            $this->form_validation->set_rules('to', 'To', 'required|callback_date_valid');*/
            $this->form_validation->set_rules('from', 'From', 'required');
            $this->form_validation->set_rules('to', 'To', 'required');
            
            $this->form_validation->set_rules('value', 'Value', 'required|numeric');
            $this->form_validation->set_rules('cart_value', 'Cart Value', 'required|numeric');
            //$this->form_validation->set_rules('restriction', 'Uses restriction', 'required|numeric');

            $data= array();
            $data['coupons'] = $this->product_model->coupon_list();
            if($this->form_validation->run() == FALSE)
            {
                $this->form_validation->set_error_delimiters('<div class="text-danger">not wor', '</div>');
                
                $this->load->view("admin/coupons/add_coupons",$data); 
                 
            }else{
                $data = array(
                'coupon_name'=>$this->input->post('coupon_title'),
                'coupon_code'=> $this->input->post('coupon_code'),
                'valid_from'=> date('Y-m-d',strtotime($this->input->post('from'))),
                'valid_to'=> date('Y-m-d',strtotime($this->input->post('to'))),
                'validity_type'=> "",
                'product_name'=> "",
                'discount_type'=> "",
                'discount_value'=> $this->input->post('value'),
                'cart_value'=> $this->input->post('cart_value'),
                'uses_restriction'=> $this->input->post('restriction')
                 );
                 if($this->product_model->coupon($data))
                 {
                     $this->session->set_flashdata('addmessage','Coupon added Successfully.');
                    $data['coupons'] = $this->product_model->coupon_list();
                    $this->load->view("admin/coupons/add_coupons",$data);
                 }
            }
        }
    } 

    public function date_valid($date)
    {
        $parts = explode("/", $date);
        if (count($parts) == 3) {      
            if (checkdate($parts[1], $parts[0], $parts[2]))
            {
                return TRUE;
            }
        }
        $this->form_validation->set_message('date_valid', 'The Date field must be dd/mm/yyyy');
        return false;
    }

    function lookup(){  
        $this->load->model("product_model");  
        $this->load->helper("url");  
        $this->load->helper('form');
        // process posted form data  
        $keyword = $this->input->post('term');
        $type = $this->input->post('type');  
        $data['response'] = 'false'; //Set default response  
        if($type=='Category')
        {
            
        } 
        elseif ($type=='Sub Category') {
            
        }
        else{
            $query = $this->product_model->lookup($keyword); //Search DB 
        }
        if( ! empty($query) )  
        {  
            $data['response'] = 'true'; //Set response  
            $data['message'] = array(); //Create array  
            foreach( $query as $row )  
            {  
                $data['message'][] = array(   
                                          
                                        'value' => $row->product_name 
                                         
                                     );  //Add a row to array  
            }  
        }
        //print_r( $data['message']);
        if('IS_AJAX')  
        {  
            echo json_encode($data); //echo json string if ajax request 
            //$this->load->view('admin/coupons/coupon_list',$data);
        }  
        else 
        {  
            $this->load->view('admin/coupons/coupon_list',$data); //Load html view of search results  
        }  
    }  
    
    function looku(){

        $this->load->model("product_model");  
        $this->load->helper("url");  
        $this->load->helper('form');
        // process posted form data  
        $keyword = $this->input->post('term');
        $type = $this->input->post('type');  
        $data['response'] = 'false'; //Set default response  
        
            $query = $this->product_model->looku($keyword); //Search DB 
        
        if( ! empty($query) )  
        {  
            $data['response'] = 'true'; //Set response  
            $data['message'] = array(); //Create array  
            foreach( $query as $row )  
            {  
                $data['message'][] = array(   
                                          
                                        'value' => $row->title 
                                         
                                     );  //Add a row to array  
            }  
        }
        //print_r( $data['message']);
        if('IS_AJAX')  
        {  
            echo json_encode($data); //echo json string if ajax request 
            //$this->load->view('admin/coupons/coupon_list',$data);
        }  
        else 
        {  
            $this->load->view('admin/coupons/coupon_list',$data); //Load html view of search results  
        }  
    }

    function look(){

        $this->load->model("product_model");  
        $this->load->helper("url");  
        $this->load->helper('form');
        // process posted form data  
        $keyword = $this->input->post('term');
        $type = $this->input->post('type');  
        $data['response'] = 'false'; //Set default response  
        if($type=='Category')
        {
            
        } 
        elseif ($type=='Sub Category') {
            
        }
        else{
            $query = $this->product_model->look($keyword); //Search DB 
        }
        if( ! empty($query) )  
        {  
            $data['response'] = 'true'; //Set response  
            $data['message'] = array(); //Create array  
            foreach( $query as $row )  
            {  
                $data['message'][] = array(   
                                          
                                        'value' => $row->title 
                                         
                                     );  //Add a row to array  
            }  
        }
        //print_r( $data['message']);
        if('IS_AJAX')  
        {  
            echo json_encode($data); //echo json string if ajax request 
            //$this->load->view('admin/coupons/coupon_list',$data);
        }  
        else 
        {  
            $this->load->view('admin/coupons/coupon_list',$data); //Load html view of search results  
        }  
    }

    function editCoupon($id){
        if(_is_user_login($this)){
            //echo $id;die();
            $this->load->helper('form');
            $this->load->library('form_validation');
           
            $this->load->model('product_model');

            $this->load->model('product_model');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('coupon_title', 'Coupon name', 'trim|required|max_length[6]|alpha_numeric');
            $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required|max_length[6]|alpha_numeric');
            /*$this->form_validation->set_rules('from', 'From', 'required|callback_date_valid');
            $this->form_validation->set_rules('to', 'To', 'required|callback_date_valid');*/
            $this->form_validation->set_rules('from', 'From', 'required');
            $this->form_validation->set_rules('to', 'To', 'required');

            $this->form_validation->set_rules('value', 'Value', 'required|numeric');
            $this->form_validation->set_rules('cart_value', 'Cart Value', 'required|numeric');
            $this->form_validation->set_rules('restriction', 'Uses restriction', 'required|numeric');

            $data= array();
            if($this->form_validation->run() == FALSE)
            {
                $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
                $data['coupon'] = $this->product_model->getCoupon($id);
                $this->load->view("admin/coupons/edit_coupon",$data); 
                 
            }
            else{
                $data = array(
                'coupon_name'=>$this->input->post('coupon_title'),
                'coupon_code'=> $this->input->post('coupon_code'),
                'valid_from'=> date('Y-m-d',strtotime($this->input->post('from'))),
                'valid_to'=> date('Y-m-d',strtotime($this->input->post('to'))),
                'validity_type'=> "",
                'product_name'=> "",
                'discount_type'=> "",
                'discount_value'=> $this->input->post('value'),
                'cart_value'=> $this->input->post('cart_value'),
                'uses_restriction'=> $this->input->post('restriction')
                 );
                 if($this->product_model->editCoupon($id,$data)){
                    $this->session->set_flashdata('addmessage','Coupon edited Successfully.');
                    redirect("admin/coupons");
                }
            }
        }
        else
        {
            redirect('admin');
        }
    }

    function deleteCoupon($id)
    {
        if(_is_user_login($this)){
            $this->load->model('product_model');
            if($this->product_model->deleteCoupon($id))
            {
                $this->session->set_flashdata('addmessage','One Coupon deleted Successfully.');
                redirect("admin/coupons");
            }
        }
        else
        {
            redirect('admin');
        }
    }

    function dealofday()
    {

        /*$this->load->model("product_model");
        $data["deal_products"]  = $this->product_model->getdealproducts(); 
        $this->load->view('admin/deal/deal_list2',$data);*/

        $this->load->model("product_model");
        $data["products"]  = $this->get_results("SELECT * FROM `deal` ORDER BY `start` DESC;");
        $this->load->view('admin/deal/list',$data);

    }

    function add_dealproduct(){
        $this->load->helper('form');

        if(_is_user_login($this)){
       
          

            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('prod_title', 'Product', 'trim|required');
                $this->form_validation->set_rules('deal_price', 'Price', 'trim|required');
                $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
                $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
                $this->form_validation->set_rules('end_date', 'End Date', 'trim|required'); 
                $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');  
                
                if ($this->form_validation->run() == FALSE)
                {
                      if($this->form_validation->error_string()!="") { 
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                 }
                                   
                }
                else
                {
                    $this->load->model("product_model");
                    $array = array( 
                    "product_name"=>$this->input->post("prod_title"), 
                    "deal_price"=>$this->input->post("deal_price"),
                    "start_date"=>$this->input->post("start_date"),
                    "start_time"=>$this->input->post("start_time"),
                    "end_date"=>$this->input->post("end_date"),
                    "end_time"=>$this->input->post("end_time")
                    
                    );
                    
                    
                    $this->product_model->adddealproduct($array); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/dealofday');
                }
            }
            
            $this->load->view("admin/deal/add2");
        }
        else
        {
            redirect('admin');
        }
    
    }
    
    function edit_deal_product($id){
       if(_is_user_login($this)){
        
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                 $this->form_validation->set_rules('prod_title', 'Product', 'trim|required');
                $this->form_validation->set_rules('deal_price', 'Price', 'trim|required');
                $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
                $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
                $this->form_validation->set_rules('end_date', 'End Date', 'trim|required'); 
                $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');  
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                   }
                }
                else
                {
                    $this->load->model("product_model");
                    $array = array( 
                    "product_name"=>$this->input->post("prod_title"), 
                    "deal_price"=>$this->input->post("deal_price"),
                    "start_date"=>$this->input->post("start_date"),
                    "start_time"=>$this->input->post("start_time"),
                    "end_date"=>$this->input->post("end_date"),
                    "end_time"=>$this->input->post("end_time")
                    
                    );
                    
                   $this->product_model->edit_deal_product($id,$array); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request edited successfully...
                                    </div>');
                    redirect('admin/dealofday');
                }
            }
            $this->load->model("product_model");
            $data["product"] = $this->product_model->getdealproduct($id);
            $this->load->view("admin/deal/edit2",$data);
        }
        else
        {
            redirect('admin');
        }
    }

    function delete_deal_product($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from deal where deal_id = '".$id."'");
            redirect("admin/dealofday");
        }
        else
        {
            redirect('admin');
        }
    }

    public function feature_banner()
    {
       if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "listslider";
           $this->load->model("slider_model");
           $data["allslider"] = $this->slider_model->feature_banner();
           $this->load->view('admin/feature_banner/listslider2',$data);
        }
        else
        {
            redirect('admin');
        }
    }

    public function add_feature_Banner()
    {
       if(_is_user_login($this)){
           
            $data["error"] = "";
            $data["active"] = "addslider";
            
            if(isset($_REQUEST["addslider"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
                if (empty($_FILES['slider_img']['name']))
                {
                    $this->form_validation->set_rules('slider_img', 'Slider Image', 'required');
                }
                
                if ($this->form_validation->run() == FALSE)
                {
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                }
                else
                {
                    $add = array(
                                    "slider_title"=>$this->input->post("slider_title"),
                                    "slider_status"=>$this->input->post("slider_status"),
                                    "slider_url"=>$this->input->post("slider_url"),
                                    "sub_cat"=>$this->input->post("sub_cat")
                                    );
                    
                        if($_FILES["slider_img"]["size"] > 0){
                            $config['upload_path']          = './uploads/sliders/';
                            $config['allowed_types']        = 'gif|jpg|png|jpeg';
                            //$this->load->library('upload', $config);
                            $this->upload->initialize($config);
            
                            if ( ! $this->upload->do_upload('slider_img'))
                            {
                                    $error = array('error' => $this->upload->display_errors());
                            }
                            else
                            {
                                $img_data = $this->upload->data();
                                $add["slider_image"]=$img_data['file_name'];
                            }
                            
                       }
                       
                       $this->db->insert("feature_slider",$add);
                    
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider added successfully...
                                    </div>');
                    redirect('admin/feature_banner');
                }
            }
        $this->load->view('admin/feature_banner/addslider2',$data);
        }
        else
        {
            redirect('admin');
        }
    }
        
    public function edit_feature_banner($id)
    {
       if(_is_user_login($this))
       {
            
            $this->load->model("slider_model");
           $data["slider"] = $this->slider_model->get_feature_banner($id);
           
            $data["error"] = "";
            $data["active"] = "listslider";
            if(isset($_REQUEST["saveslider"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
               
                  if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                }
                else
                {
                    $this->load->model("slider_model");
                    $this->slider_model->edit_feature_banner($id); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider saved successfully...
                                    </div>');
                    redirect('admin/feature_banner');
                }
            }
           $this->load->view('admin/feature_banner/editslider2',$data);
        }
        else
        {
            redirect('admin');
        }
    }

    public function delete_feature_banner($id){
        if(_is_user_login($this)){
            $data = array();
            $this->db->query("Delete from feature_slider where id = '".$id."'");
            unlink("uploads/sliders/".$slider->slider_image);
            redirect("admin/feature_banner");
        }
        else
        {
            redirect('admin');
        }   
    }
        
    public function help()
    {
        if(_is_user_login($this)){
           
            $data["error"] = "";
            $data["active"] = "addcat";
            if(isset($_REQUEST["addcatg"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('mobile', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('email', 'Categories Parent', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                    }
                }
                else
                {
                    $this->load->model("category_model");
                    $this->category_model->add_category(); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request Send successfully...
                                    </div>');
                    redirect('admin/addcategories');
                }
            }
            $this->load->view('admin/help/form');
        }
        else
        {
            redirect('admin');
        }
    }
        
    public function move(){
        $header = array(
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded',
            'X-Auth-Token : A878BFCAF5D52016244C671D94FCAF06DD0753CD5356987289EDC317144C82FFAECC66A99800DBAB'
        );
        
        $curl = curl_init();
        curl_setopt ($curl, CURLOPT_URL, "http://384772.true-order.com/WebReporter/api/v1/items?limit=30249");
        curl_setopt($curl , CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($curl, CURLOPT_HTTPHEADER, $header);
        
        $projects = curl_exec($curl);
        $p =json_decode($projects, true);
        
        //echo $projects (?limit=30249);
        
        $data = json_decode($projects);
        /*foreach ($data as $key => $item){
            if ($key=='items'){
                
                    foreach ($key as $k => $itemName){
                        echo '<br><br>Value found at array name=> '.$k."=>" . $itemName;
                    }
            }
            echo '<br><br>Value found at array key=> '.$key."=>" . $item;
        }*/
        foreach($data->items as $items) {
           echo  "<br><br>NAME =>".$itemName = $items->itemName;
           echo  "<br>description =>".$description = $items->description;
           
           foreach($items->stock as $stock) {
               //$stock = $items->stock;
               echo "<br>MRP =>".$mrp = $stock->mrp;
               echo "<br>S.P =>".$salePrice = $stock->salePrice;
               echo "<br>TAX(%) =>".$taxPercentage = $stock->taxPercentage;
               echo "<br>MAIN_cat =>".$cat = $stock->Cat2;
               echo "<br>SUB_cat =>".$sub_cat = $stock->Cat1;
               echo "<br>UNIT_VALUE =>".$unit_value = $stock->packing;
               echo "<br>TITLE =>".$variantName = $stock->variantName;
           }
        }
    }
    
    public function payment(){
        if(_is_user_login($this)){
        $data["paypal"]=$this->db->query("SELECT status FROM `paypal` where id = 1");
        $data["razor"]=$this->db->query("SELECT status FROM `razorpay` where id = 1");
        $this->load->view("admin/payment/list",$data);
        }
        else
        {
            redirect('admin');
        }
    }

    public function paypal_detail(){
        
        if(_is_user_login($this)){
               
            $data["error"] = "";
            $data["active"] = "pp";
            if(isset($_POST["pp"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('client_id', 'Client ID', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                    }
                }
                else
                {
                    $client_id = $this->input->post("client_id");
                    //$emp_fullname = $this->input->post("emp_fullname");
                    $status = ($this->input->post("status")=="on")? 1 : 0;
                    $array = array(
                        'client_id'=>$client_id,
                        'status'=>$status
                        );
                    
                    $this->load->model("common_model");
                    $this->common_model->data_update("paypal",$array,array("id"=>1)); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request Send successfully...
                                    </div>');
                    redirect('admin/payment');
                }
            }
                

            $data["paypal"]=$this->db->query("SELECT * FROM `paypal` where id = 1");
            $this->load->view("admin/payment/edit_paypal",$data);
        }
        else
        {
            redirect('admin');
        }
         
    }
    
    public function razorpay_detail(){
        if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "pp";
            if(isset($_POST["pp"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('api_key', 'Client ID', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                    }
                }
                else
                {
                    $api_key = $this->input->post("api_key");
                    //$emp_fullname = $this->input->post("emp_fullname");
                    $status = ($this->input->post("status")=="on")? 1 : 0;
                    $array = array(
                        'api_key'=>$api_key,
                        'status'=>$status
                        );
                    
                    $this->load->model("common_model");
                    $this->common_model->data_update("razorpay",$array,array("id"=>1)); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request Send successfully...
                                    </div>');
                    redirect('admin/payment');
                }
            }
            

            $data["razor"]=$this->db->query("SELECT * FROM `razorpay` where id = 1");
            $this->load->view("admin/payment/edit_razorpay",$data);
        }
        else
        {
            redirect('admin');
        }
         
    }

    public function ads(){
        if(_is_user_login($this))
        {
            $data["ads"]=$this->db->query("SELECT * FROM `ads`");
            
            $this->load->view("admin/ads/list",$data);
        }
         else
            {
                redirect('admin');
            }
    }

    public function edit_ads($id){
        if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "pp";
            if(isset($_POST["pp"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('ads_key', 'Client ID', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                    }
                }
                else
                {
                    $ads_key = $this->input->post("ads_key");
                    $status = ($this->input->post("status")=="on")? 1 : 0;
                    $array = array(
                        'ads_key'=>$ads_key,
                        'status'=>$status
                        );
                    
                    $this->load->model("common_model");
                    $this->common_model->data_update("ads",$array,array("id"=>$id)); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request Send successfully...
                                    </div>');
                    redirect('admin/ads');
                }
            }
            

            $data["ads"]=$this->db->query("SELECT * FROM `ads` where id ='".$id."'");
            $this->load->view("admin/ads/edit_ads",$data);
        }
        else
        {
            redirect('admin');
        }
         
    }
    
    public function user_action($user_id){
        if(_is_user_login($this)){
        
            if(isset($_POST['profile']))
            {
                unset($_POST['profile']);

                $this->db->select('password');
                $this->db->from('customer');
                $this->db->where('customer_id',$user_id );
                $query = $this->db->get();
                $pass= $query->row();

                if($pass->password==$_POST['password']) 
                {
                    $_POST['password'] = $_POST['password'];
                }
                else
                {
                    $_POST['password'] = md5($_POST['password']);
                }
                $this->db->where('customer_id',$user_id);
                $this->db->update('customer',$_POST);
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                    <i class="fa fa-check"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Your request edited successfully...
                                </div>');
                redirect('admin/registers');
            }
            
            if(isset($_POST['amount']))
            {
                unset($_POST['amount']);
                $this->db->where('customer_id',$user_id);
                $this->db->update('customer',$_POST);
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                    <i class="fa fa-check"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Your request edited successfully...
                                </div>');
                redirect('admin/registers');
            }

            $this->load->model("product_model");
            $qry=$this->db->query("SELECT * FROM `customer` where customer_id = '".$user_id."'");
            $data["user"] = $qry->result();
            //$data["order"] = $this->product_model->get_sale_orders(" and sale.user_id = '".$user_id."' AND sale.status=4 ");
            $data["order"] = $this->product_model->get_sale_orders(" and sale.user_id = '".$user_id."' ");
            $this->load->view("admin/registers/useraction",$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function notification22(){
        if(_is_user_login($this)){
            $serverObject = new SendNotification(); 
            $jsonString = $serverObject->sendPushNotificationToFCMSever( $token, $message, $order_id );  
            $jsonObject = json_decode($jsonString);
            return $jsonObject;
        }
        else
        {
            redirect('admin');
        }
    
    }
    
    public function language_status()
    {
       if(_is_user_login($this))
       {
            $q = $this->db->query("select * from `language_setting` WHERE id=1");
            $data["status"] = $q->row();
            
            $data["error"] = "";
            $data["active"] = "listcat";
            if(isset($_REQUEST["update"]))
            {
                extract($_POST);
                if($status=="")
                {
                    $status="0";
                }

                $this->load->library('form_validation');
                $update=$this->db->query("UPDATE `language_setting` SET `status`='".$status."' WHERE `id`=1 ");
                

                if (!$update)
                {
                   
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> Update Not Successfull. Something wents Wrong</div>';
                   
                }
                else
                {
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Update Successfull </div>');
                    redirect('admin/language_status');
                }
            }
           $this->load->view('admin/setting/language',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function mobile_number()
    {
        $q = $this->db->query("select * from `tbl_numbers` WHERE id=1");
        $data["numbers"] = $q->row();
        
        if(isset($_REQUEST["update"]))
        {
            extract($_POST);

            $update=$this->db->query("UPDATE `tbl_numbers` SET `whatsapp`='".$whatsapp."',`calling`='".$call."' WHERE `id`=1");
            

            if (!$update)
            {
                $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                    <i class="fa fa-warning"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> Update Not Successfull. Something wents Wrong</div>';
                
            }
            else
            {
                $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                    <i class="fa fa-check"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Update Successfull </div>');
                redirect('admin/mobile_number');
            }
        }
        $q = $this->db->query("select * from `tbl_numbers` WHERE id=1");
        $data["numbers"] = $q->row();
        $this->load->view('admin/number_update',$data);
            
    }
     
     public function bakar_cat()
     {
        if (_is_user_login($this)) { 
            if ($_POST['id'] > 0) {
              $id = $_POST['id'];
              $resp = $this->db->query("SELECT `id`,`title` FROM `categories` WHERE `parent` = '$id';");
              if ($resp->num_rows()>0){
                $html = '<option value="">Select Sub Category</option>';
                foreach ($resp->result_array() as $row){
                  $html .= '<option value="'.$row['id'].'">'.$row['title'].'</option>';
                }
                echo json_encode(array("status"=>true,"data"=>$html));
              }
              else{
                echo json_encode(array("status"=>false));
              }
            }
            else{
              echo json_encode(array("status"=>false));
            }
        }
        else
        {
            redirect('admin');
        }
     }
    
    public function get_product_reviews()
    {
        if (_is_user_login($this) && $_POST) {
            $id = $_POST['id'];
            $reviews = $this->get_results("
                SELECT r.*, c.fname, c.lname 
                FROM `review` AS r 
                LEFT JOIN `customer` AS c ON r.user_id = c.customer_id 
                WHERE r.product_id = '$id' AND r.status = 'new' 
                ORDER BY `at` ASC
            ;");
            if ($reviews) {
                $html = '';
                foreach ($reviews as $key => $q) {
                    $html .= '<tr>';
                        if (strlen($q['fname']) > 0) {
                            $html .= '<td>'.$q['fname'].' '.$q['lname'].'</td>';
                        }
                        else{
                            $html .= '<td>User</td>';
                        }
                        $html .= '<td>'.$q['title'].'</td>';
                        $html .= '<td>'.$q['ratting'].'</td>';
                        $html .= '<td>'.$q['comment'].'</td>';
                        $html .= '<td>'.$q['brand_review'].'</td>';
                        $html .= '<td><b>ratting: '.$q['rider_ratting'].'</b><hr><b>Comment</b><br><p>'.$q['rider_comment'].'</p></td>';
                        $html .= '<td>';
                            for ($i=1; $i < 7; $i++) { 
                                if (strlen($q['image_'.$i]) > 4) {
                                    $html .= '<a href="'.SITE_UPLOADS.'/reviews/'.$q['image_'.$i].'" target="_blank"><img src="'.SITE_UPLOADS.'/reviews/'.$q['image_'.$i].'" width="50" height="50" style="width:50px;height:50px;border:1px solid #eee;margin:3px;object-fit: cover;background:#fff;"></a>';
                                }
                            }
                        $html .= '</td>';
                        $html .= '<td>'.date('d M, Y',strtotime($q['at'])).'</td>';
                        $html .= '<td><a href="jascript://" data-id="'.$q['review_id'].'" data-status="active" class="btn btn-success change-review-status">Active</a><a href="jascript://" data-id="'.$q['review_id'].'" data-status="inactive" class="btn btn-danger change-review-status">inactive</a></td>';
                    $html .= '</tr>';
                }
                echo json_encode(array("status"=>true,"html"=>$html));
            }
            else{
                echo json_encode(array("status"=>false,"msg"=>"no new review found"));
            }
        }
    }
    public function change_product_review()
    {
        if (_is_user_login($this) && $_POST) {
            $id = $_POST['id'];
            $update['status'] = $_POST['status'];
            $this->db->where('review_id',$id);
            $resp = $this->db->update('review',$update);
            if ($update['status'] == 'active') {
                $review = $this->get_row("SELECT * FROM `review` WHERE `review_id` = '$id';");
                $ratting = $this->get_row("SELECT AVG(`ratting`) AS ratting FROM `review` WHERE `product_id` = '".$review['product_id']."' AND `status` = 'active';");
                $this->db->query("UPDATE `products` SET `reviews`=`reviews`+1, `ratting` = '".$ratting['ratting']."' WHERE `product_id` = ".$review['product_id']."");
            }
            echo json_encode(array("status"=>true));
        }
    }

    public function ad()
    {
        if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "ad";
            $data["ads"] = $this->get_results("SELECT * FROM `ad` ORDER BY `ad_id` ASC;");
            $this->load->view('admin/ad/list',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function edit_ad($id)
    {
       if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "ad";
            $data['ad_id'] = $id;
            $data['q'] = $this->get_row("SELECT * FROM `ad` WHERE `ad_id` = '$id';");
            $this->load->view('admin/ad/edit',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function update_ad()
    {
        if(_is_user_login($this)){
            if($_FILES["image"]["size"] > 0){
                $config['upload_path'] = './uploads/ad/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                //$this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ( ! $this->upload->do_upload('image'))
                {
                        $error = array('error' => $this->upload->display_errors());
                }
                else
                {
                    $img_data = $this->upload->data();
                    $_POST["image"] = $img_data['file_name'];
                }
            }
            $id = $_POST['id'];unset($_POST['id']);
            $this->db->where('ad_id',$id);
            $this->db->update('ad',$_POST);
            redirect('admin/ad');
        }
        else
        {
            redirect('admin');
        }
    }
    public function newsletter()
    {
        if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "newsletter";
            $this->load->view('admin/newsletter/add',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function add_newsletter()
    {
        if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "newsletter";
            $this->load->view('admin/newsletter/add',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function post_newsletter()
    {
        if(_is_user_login($this)){
            $query = $this->db->get('newsletter');
            foreach ($query->result() as $row) {
                $post = $_POST;
                $post['email'] = $row->email;
                $this->db->insert('newsletter_send',$post);
            }
            redirect('admin/newsletter/add');
        }
        else
        {
            redirect('admin');
        }
    }

    public function faqs()
    {
       if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "faqs";
           $data["faqs"] = $this->get_results("SELECT * FROM `faq` ORDER BY `title` ASC;");
           $this->load->view('admin/faqs/faqs',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function addfaq()
    {
       if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "faqs";
            $this->load->view('admin/faqs/addfaq',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function postfaq()
    {
        if(_is_user_login($this)){
            $this->db->insert('faq',$_POST);
            redirect('admin/addfaq');
        }
        else
        {
            redirect('admin');
        }
    }
    public function editfaq($id)
    {
       if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "faqs";
            $data['faqID'] = $id;
            $data['q'] = $this->get_row("SELECT * FROM `faq` WHERE `faq_id` = '$id';");
            $this->load->view('admin/faqs/editfaq',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function updatefaq()
    {
        if(_is_user_login($this)){
            error_reporting(E_ALL);
            $id = $_POST['id'];
            unset($_POST['id']);
            $this->db->where('faq_id',$id);
            $resp =$this->db->update('faq',$_POST);
            redirect('admin/faqs');
        }
        else
        {
            redirect('admin');
        }
    }
    public function deletefaq($id)
    {
        if(_is_user_login($this)) {
            $this->db->query("delete from faq where faq_id = '".$id."'");
            redirect('admin/faqs');
        }
        else
        {
            redirect('admin');
        }
    }



    public function filters()
    {
       if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "filters";
           $data["filters"] = $this->get_results("SELECT * FROM `filter` ORDER BY `title` ASC;");
           $this->load->view('admin/filter/list',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function addfiltervaluecsv()
    {
       if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "filters";
            $this->load->view('admin/filter/addcsv',$data);
        }
        else{
            redirect('admin');
        }
    }
    public function addfiltercsv()
    {
       if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "filters";
            $this->load->view('admin/filter/addfiltercsv',$data);
        }
        else{
            redirect('admin');
        }
    }
    public function addfilter()
    {
       if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "filters";
            $this->load->view('admin/filter/add',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function postfilter()
    {
        if(_is_user_login($this)){
            $this->db->insert('filter',$_POST);
            redirect('admin/addfilter');
        }
        else
        {
            redirect('admin');
        }
    }
    public function editfilter($id)
    {
       if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "filters";
            $data['faqID'] = $id;
            $data['q'] = $this->get_row("SELECT * FROM `filter` WHERE `filter_id` = '$id';");
            $this->load->view('admin/filter/edit',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function updatefilter()
    {
        if(_is_user_login($this)){
            $id = $_POST['id'];
            unset($_POST['id']);
            $this->db->where('filter_id',$id);
            $resp =$this->db->update('filter',$_POST);
            redirect('admin/filters');
        }
        else
        {
            redirect('admin');
        }
    }
    public function deletefilter($id)
    {
        if(_is_user_login($this)) {
            $this->db->query("delete from filter where filter_id = '".$id."'");
            redirect('admin/filters');
        }
        else
        {
            redirect('admin');
        }
    }
    public function get_filter_values()
    {
        $id = $_POST['id'];
        $resp = $this->get_results("SELECT * FROM `filter_value` WHERE `filter_id` = '$id' ORDER BY `title` ;");
        $html = '';
        foreach ($resp as $key => $q) {
            $html .= '<tr>';
                $html .=  '<td>'.$q['title'].'</td>';
                $html .=  '<td>'.$q['value'].'</td>';
                $html .=  '<td><a href="javascript://" class="delete-value" data-id="'.$q['filter_value_id'].'">Delete</a></td>';
            $html .= '</tr>';
        }
        echo json_encode(array("status"=>true,"html"=>$html));
    }
    public function post_filter_values()
    {
        parse_str($_POST['data'],$post);
        $resp = $this->db->insert('filter_value',$post);
        $id = $this->db->insert_id();
        if ($resp) {
            $html = '<tr>';
                $html .=  '<td>'.$post['title'].'</td>';
                $html .=  '<td>'.$post['value'].'</td>';
                $html .=  '<td><a href="javascript://" class="delete-value" data-id="'.$q['$id'].'">Delete</a></td>';
            $html .= '</tr>';
            echo json_encode(array("status"=>true,"html"=>$html));
        }
        else{
            echo json_encode(array("status"=>false));
        }
    }
    public function post_filter_copy()
    {
        parse_str($_POST['data'],$post);
        $insert['title'] = $post['title'];
        $insert['admin_title'] = $post['admin_title'];
        $this->db->insert('filter',$insert);
        $id = $this->db->insert_id();
        $values = $this->get_results("SELECT `title`,`value` FROM `filter_value` WHERE `filter_id` = '".$post['filter_id']."' ORDER BY `filter_value_id` ASC ;");
        if ($values) {
            foreach ($values as $key => $q) {
                $q['filter_id'] = $id;
                $this->db->insert('filter_value',$q);
            }
            echo json_encode(array("status"=>true));
        }
        else{
            echo json_encode(array("status"=>false));
        }
    }
    public function delete_filter_value()
    {
        $resp = $this->db->query("DELETE FROM `filter_value` WHERE `filter_value_id` = '".$_POST['id']."'");
        if ($resp) {
            echo json_encode(array("status"=>true));
        }
        else{
            echo json_encode(array("status"=>false));
        }
    }
    public function get_filter_values_html()
    {
        $id = $_POST['id'];
        if (isset($id) && strlen($id) > 0) {
            $resp = $this->get_results("SELECT `filter_id`,`title` FROM `filter` WHERE `filter_id` IN($id) AND `status` = 'active' ORDER BY `title`;");
        }
        else{
            $resp = false;
        }
        if ($resp) {
            $html = '';
            foreach ($resp as $key => $Filter) {
                $FilterID = $Filter['filter_id'];
                $values = $this->get_results("SELECT `filter_value_id`,`title` FROM `filter_value` WHERE `filter_id` = '$FilterID' AND `status` = 'active' ORDER BY `title`;");
                if ($values) {
                    $html .= '<div class="row" style="border-top: 1px solid #eee;border-bottom: 1px solid #eee;margin-top: 10px;padding-top: 10px;">';
                        $html .= '<label class="col-md-3 label-on-left">'.$Filter['title'].'</label>';
                        $html .= '<div class="col-md-9">';
                            foreach ($values as $key => $filter){
                                $html .= '<div class="form-group">';
                                    $html .= '<input type="checkbox" name="filter_value_id[]" value="'.$filter['filter_value_id'].'" checked="checked"> &nbsp;&nbsp;';
                                    $html .= '<label class="control-label">'.$filter['title'].'</label>';
                                $html .= '</div><!-- /form-group -->';
                            }
                        $html .= '</div>';
                    $html .= '</div>';
                }
            }
            echo json_encode(array("status"=>true,"html"=>$html));
        }
        else{
            echo json_encode(array("status"=>false));
        }
    }

    public function create_bulk_products_csv_file()
    {
        if ($_POST) {
            $data = 'Product Name,Product Description,Product Image,Category Id,In Stock,Price,Unit Value,Unit,Increament,Rewards,Urdu Title,Brand,Size,size_price,color,color_price,filter_price_show,Warranty,SKU,SKU Easydoor,Tag 1,Tag 2,Tag 3,Tag 4,Tag 5,Tag 6,Tag 7';
            $filters = $this->get_row("SELECT `title`,`filter_ids` FROM `categories` WHERE `id` = '".$_POST['category_id']."';");
            $file = str_replace(' ', '-', $filters['title']).'.csv';
            if (strlen($filters['filter_ids']) > 0) {
                $ids = $filters['filter_ids'];
                $filters = $this->get_results("SELECT `filter_id`,`title` FROM `filter` WHERE `filter_id` IN($ids) ORDER BY `title` ASC;");
                if ($filters) {
                    foreach ($filters as $key => $q) {
                        $FilterValues = $this->get_results("SELECT `value` FROM `filter_value` WHERE `filter_id` = '".$q['filter_id']."' ORDER BY `value` ASC;");
                        if ($FilterValues) {
                            $Data = '(';
                            foreach ($FilterValues as $key_ => $q_) {
                                if ($key_ == 0) {
                                    $Data .= $q_['value'];
                                }
                                else{
                                    $Data .= ' + '.$q_['value'];
                                }
                            }
                            $Data .= ')';
                            $data .= ','.$q['title'].'('.$Data.')';
                        }
                    }
                }
            }
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename="'.$file.'"');
            echo $data; exit();
        }
    }
    public function download_product_pricing()
    {
        $data = array("Product ID","Product Name","Price");
        $products = $this->get_results("SELECT `product_id`,`product_name`,`price` FROM `products` ORDER BY `product_id` ASC;");
        $file = 'products.csv';
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$file.'"');

        $fp = fopen('php://output', 'w');
        fputcsv($fp, $data);
        foreach ($products as $row) {
            $product[0] = $row['product_id'];
            $product[1] = $row['product_name'];
            $product[2] = $row['price'];
            fputcsv($fp, $product);
        }
        fclose($fp);
    }
    public function upload_product_pricing_csv()
    {
        if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "products";
           $this->load->view('admin/product/upload_product_pricing_csv',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function testimonials()
    {
       if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "testimonials";
           $data["testimonials"] = $this->get_results("SELECT * FROM `testimonial` ORDER BY `title` ASC;");
           $this->load->view('admin/testimonial/list',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function addtestimonial()
    {
       if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "testimonials";
            $this->load->view('admin/testimonial/add',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function posttestimonial()
    {
        if(_is_user_login($this)){
            if($_FILES["image"]["size"] > 0){
                $config['upload_path'] = './uploads/category/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                //$this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ( ! $this->upload->do_upload('image'))
                {
                        $error = array('error' => $this->upload->display_errors());
                }
                else
                {
                    $img_data = $this->upload->data();
                    $_POST["image"] = $img_data['file_name'];
                }
            }
            $this->db->insert('testimonial',$_POST);
            redirect('admin/addtestimonial');
        }
        else
        {
            redirect('admin');
        }
    }
    public function edittestimonial($id)
    {
       if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "testimonials";
            $data['faqID'] = $id;
            $data['q'] = $this->get_row("SELECT * FROM `testimonial` WHERE `testimonial_id` = '$id';");
            $this->load->view('admin/testimonial/edit',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function updatetestimonial()
    {
        if(_is_user_login($this)){
            error_reporting(E_ALL);
            $id = $_POST['id'];
            unset($_POST['id']);
            if($_FILES["image"]["size"] > 0){
                $config['upload_path'] = './uploads/category/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                //$this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ( ! $this->upload->do_upload('image'))
                {
                        $error = array('error' => $this->upload->display_errors());
                }
                else
                {
                    $img_data = $this->upload->data();
                    $_POST["image"] = $img_data['file_name'];
                }
            }
            $this->db->where('testimonial_id',$id);
            $resp =$this->db->update('testimonial',$_POST);
            redirect('admin/testimonials');
        }
        else
        {
            redirect('admin');
        }
    }
    public function deletetestimonial($id)
    {
        if(_is_user_login($this)) {
            $this->db->query("delete from testimonial where testimonial_id = '".$id."'");
            redirect('admin/testimonials');
        }
        else
        {
            redirect('admin');
        }
    }
    public function email_templates()
    {
        if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "email_templates";
           $data["data"] = $this->get_results("SELECT * FROM `email_template` ORDER BY `title` ASC;");
           $this->load->view('admin/email/list',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function add_email_template()
    {
       if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "email_templates";
            $this->load->view('admin/email/add',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function post_email_template()
    {
        $this->db->insert('email_template',$_POST);
        redirect('admin/email_templates');
    }
    public function edit_email_template($id)
    {
       if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "email_templates";
            $data['q'] = $this->get_row("SELECT * FROM `email_template` WHERE `email_template_id` = '$id';");
            $this->load->view('admin/email/edit',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function update_email_template($id)
    {
        $this->db->where('email_template_id',$_POST['email_template_id']);
        unset($_POST['email_template_id']);
        $resp =$this->db->update('email_template',$_POST);
        redirect('admin/email_templates');
    }
    public function delete_email_template($id)
    {
        if(_is_user_login($this)) {
            $this->db->query("delete from email_template where email_template_id = '".$id."'");
            redirect('admin/email_templates');
        }
        else
        {
            redirect('admin');
        }
    }
    public function update_email_template_contacts_bulk()
    {
        if ($_FILES) {
            $fp = fopen($_FILES['csv']['tmp_name'],'r') or die("can't open file");
            $count = false;
            $insert['email_template_id'] = $_POST['email_template_id'];
            while($csv_line = fgetcsv($fp,1024))
            {
                for($i = 0, $j = count($csv_line); $i < $j; $i++)
                {
                    $insert['email'] = $csv_line[0];
                }
                $i++;
                $this->db->insert('send_email',$insert);
            }
            fclose($fp) or die("can't close file");
        }
        redirect('admin/email_templates');
    }
    public function sizes()
    {
        if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "sizes";
           $data["sizes"] = $this->get_results("SELECT * FROM `size` ORDER BY `name` ASC;");
           $this->load->view('admin/size/list',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function update_size()
    {
        parse_str($_POST['data'],$post);
        $id = $post['size_id'];unset($post['size_id']);
        $this->db->where('size_id',$id);
        $resp = $this->db->update('size',$post);
        if ($resp) {
            echo json_encode(array("status"=>true));
        }
        else{
            echo json_encode(array("status"=>false));
        }
    }
    public function post_size()
    {
        parse_str($_POST['data'],$post);
        $resp = $this->db->insert('size',$post);
        if ($resp) {
            echo json_encode(array("status"=>true));
        }
        else{
            echo json_encode(array("status"=>false));
        }
    }
    public function colors()
    {
        if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "sizes";
           $data["colors"] = $this->get_results("SELECT * FROM `color` ORDER BY `name` ASC;");
           $this->load->view('admin/color/list',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function update_color()
    {
        parse_str($_POST['data'],$post);
        $id = $post['color_id'];unset($post['color_id']);
        $this->db->where('color_id',$id);
        $resp = $this->db->update('color',$post);
        if ($resp) {
            echo json_encode(array("status"=>true));
        }
        else{
            echo json_encode(array("status"=>false));
        }
    }
    public function post_color()
    {
        parse_str($_POST['data'],$post);
        $resp = $this->db->insert('color',$post);
        if ($resp) {
            echo json_encode(array("status"=>true));
        }
        else{
            echo json_encode(array("status"=>false));
        }
    }
    public function blog()
    {
        if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "blog";
           $data["blog"] = $this->get_results("SELECT * FROM `blog` ORDER BY `title` ASC;");
           $this->load->view('admin/blog/list',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function addblog()
    {
       if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "blog";
            $this->load->view('admin/blog/add',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function postblog()
    {
        if(_is_user_login($this)){
            if($_FILES["image"]["size"] > 0){
                $config['upload_path'] = './uploads/category/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                //$this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ( ! $this->upload->do_upload('image'))
                {
                        $error = array('error' => $this->upload->display_errors());
                }
                else
                {
                    $img_data = $this->upload->data();
                    $_POST["image"] = $img_data['file_name'];
                }
            }
            $_POST['slug'] = $this->clean($_POST['title']);
            $this->db->insert('blog',$_POST);
            redirect('admin/blog');
        }
        else
        {
            redirect('admin');
        }
    }
    public function editblog($id)
    {
       if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "blog";
            $data['blogID'] = $id;
            $data['q'] = $this->get_row("SELECT * FROM `blog` WHERE `blog_id` = '$id';");
            $this->load->view('admin/blog/edit',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function updateblog()
    {
        if(_is_user_login($this)){
            error_reporting(E_ALL);
            $id = $_POST['id'];
            unset($_POST['id']);
            if($_FILES["image"]["size"] > 0){
                $config['upload_path'] = './uploads/category/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                //$this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ( ! $this->upload->do_upload('image'))
                {
                        $error = array('error' => $this->upload->display_errors());
                }
                else
                {
                    $img_data = $this->upload->data();
                    $_POST["image"] = $img_data['file_name'];
                }
            }
            $_POST['slug'] = $this->clean($_POST['title']);
            $this->db->where('blog_id',$id);
            $resp =$this->db->update('blog',$_POST);
            redirect('admin/blog');
        }
        else
        {
            redirect('admin');
        }
    }
    public function deleteblog($id)
    {
        if(_is_user_login($this)) {
            $this->db->query("delete from blog where blog_id = '".$id."'");
            redirect('admin/blog');
        }
        else
        {
            redirect('admin');
        }
    }
    public function send_sms_customers()
    {
        if(_is_user_login($this)) {
            $users = $this->get_results("SELECT `customer_id`,`phone` FROM `customer` WHERE `phone` != '';");
            foreach ($users as $key => $post) {
                $post['sms'] = $_POST['sms'];
                $this->db->insert('send_sms',$post);
            }
            redirect('admin/registers');
        }
        else
        {
            redirect('admin');
        }
    }
    public function get_products_for_deal()
    {
        if(_is_user_login($this)) {
            $sale_percentage = $_POST['discount'];
            $products = $this->get_results("SELECT `product_id`,`product_name`,`sale_percentage` FROM `products` WHERE `sale_percentage` >= '$sale_percentage' ORDER BY `product_name` ASC;");
            if ($products) {
                $html = '';
                foreach ($products as $key => $q) {
                    $html .= '<input type="checkbox" name="product_id[]" value="'.$q['product_id'].'"> '.$q['product_name'].'('.intval($q['sale_percentage']).'%)<br>';
                }
                echo json_encode(array("status"=>true,"html"=>$html));
            }
            else{
                echo json_encode(array("status"=>false));
            }
        }
        else
        {
            redirect('admin');
        }
    }
    public function post_deal($value='')
    {
        if(_is_user_login($this)) {
            $post['title'] = $_POST['title'];
            $post['start'] = date('Y-m-d H:i:s',strtotime($_POST['start']));
            $post['end'] = date('Y-m-d H:i:s',strtotime($_POST['end']));
            $post['discount'] = $_POST['discount'];
            $post['products'] = implode(',', $_POST['product_id']);
            $resp = $this->db->insert('deal',$post);
            redirect('admin/dealofday');
        }
        else
        {
            redirect('admin');
        }
    }
    public function get_deal_for_edit($value='')
    {
        if(_is_user_login($this)) {
            $id = $_POST['id'];
            $resp = $this->get_row("SELECT * FROM `deal` WHERE `deal_id` = '$id';");
            if ($resp) {
                $ProductIDs = explode(',', $resp['products']);
                $sale_percentage = $resp['discount'];
                $products = $this->get_results("SELECT `product_id`,`product_name`,`sale_percentage` FROM `products` WHERE `sale_percentage` >= '$sale_percentage' ORDER BY `product_name` ASC;");
                $html = '';
                foreach ($products as $key => $q) {
                    if (in_array($q['product_id'], $ProductIDs)) {
                        $html .= '<input type="checkbox" name="product_id[]" value="'.$q['product_id'].'" checked="checked"> '.$q['product_name'].'('.intval($q['sale_percentage']).'%)<br>';
                    }
                    else{
                        $html .= '<input type="checkbox" name="product_id[]" value="'.$q['product_id'].'"> '.$q['product_name'].'('.intval($q['sale_percentage']).'%)<br>';
                    }
                }
                $options = '';
                for ($i=1; $i < 21; $i++) { 
                    if (5*$i == $resp['discount']) {
                        $options .= '<option value="'. 5*$i .'"selected="selected">'. 5*$i .' %</option>';
                    }
                    else{
                        $options .= '<option value="'. 5*$i .'">'. 5*$i.' %</option>';
                    }
                }
                echo json_encode(array("status"=>true,"html"=>$html,"data"=>$resp,"options"=>$options));
            }
            else{
                echo json_encode(array("status"=>false));
            }
        }
        else
        {
            redirect('admin');
        }
    }
    public function update_deal($value='')
    {
        if(_is_user_login($this)) {
            $post['title'] = $_POST['title'];
            $post['start'] = date('Y-m-d H:i:s',strtotime($_POST['start']));
            $post['end'] = date('Y-m-d H:i:s',strtotime($_POST['end']));
            $post['discount'] = $_POST['discount'];
            $post['products'] = implode(',', $_POST['product_id']);
            $resp = $this->db->where('deal_id',$_POST['id']);
            $resp = $this->db->update('deal',$post);
            redirect('admin/dealofday');
        }
        else
        {
            redirect('admin');
        }
    }
    public function get_order_items()
    {
        if(_is_user_login($this)) {
            $id = $_POST['id'];
            $items = $this->get_results("
                SELECT si.*, b.title AS Brand, s.name AS Size , c.name AS Color 
                FROM `sale_items` AS si 
                INNER JOIN `products` AS p ON si.product_id = p.product_id 
                LEFT JOIN `brand` AS b ON p.brand_id = b.brand_id 
                LEFT JOIN `size` AS s ON si.size = s.size_id 
                LEFT JOIN `color` AS c ON si.color = c.color_id 
                WHERE si.sale_id = '$id' 
                ORDER BY si.product_name ASC;");
            $html = '';
            if ($items) {
                foreach ($items as $key => $item) {
                    $html .= '<tr>
                        <td>'.$item['sale_item_id'].'</td>
                        <td><a target="_blank" href="'.MAIN_SITE.'product/-'.$item['product_id'].'">'.$item['product_name'].'</a></td>
                        <td>'.$item['Brand'].'</td>
                        <td>'.$item['qty'].'</td>
                        <td>'.$item['Size'].'/'.$item['Color'].'</td>
                        <td class="status">'.$item['status'].'</td>
                        <td>';
                            if ($item['status'] == 'delivered') {
                                $html .= '---';
                            }
                            elseif ($item['status'] == 'returned'){
                                $html .= '---';
                            }
                            elseif ($item['status'] == 'cancelled'){
                                $html .= '---';
                            }
                            else{
                                $html .= '<select name="change_item_status" class="form-control" data-id="'.$item['sale_item_id'].'">';
                                    $html .= '<option value="">Change Status</option>';
                                    
                                    if ($item['status'] == 'pending'){
                                        $html .= '<option value="in process">In Process</option>';
                                    }
                                    elseif ($item['status'] == 'in process'){
                                        $html .= '<option value="delivered to courier">Delivered To Courier</option>';
                                    }
                                    elseif ($item['status'] == 'delivered to courier'){
                                        $html .= '<option value="on way">On Way</option>';
                                    }
                                    elseif ($item['status'] == 'on way'){
                                        $html .= '<option value="delivered">Delivered</option>';
                                        $html .= '<option value="returned">Returned</option>';
                                    }
                                    $html .= '<option value="cancelled">Cancelled</option>';
                                    
                                $html .= '</select>';
                            }
                        $jhtml .= '</td>';
                    $html .= '</tr>';
                }
            }
            else{
                $html .= '<tr><td colspan="6">No item found</td></tr>';
            }
            echo json_encode(array("status"=>true,"html"=>$html));
        }
        else
        {
            redirect('admin');
        }
    }
    public function change_order_item_status()
    {
        if(_is_user_login($this)) {
            $update['status'] = $_POST['status'];
            $this->db->where('sale_item_id',$_POST['id']);
            $resp = $this->db->update('sale_items',$update);
            if ($resp) {
                if ($_POST['status'] == 'returned' || $_POST['status'] == 'cancelled') {
                    $id = $_POST['id'];
                    $item = $this->get_row("SELECT * FROM `sale_items` WHERE `sale_item_id` = '$id';");
                    $slaeID = $item['sale_id'];
                    $sale = $this->get_row("SELECT * FROM `sale` WHERE `sale_id` = '$slaeID';");
                    $saleUpdate['total_amount'] = $sale['total_amount'] - $item['total'];
                    $saleUpdate['total_items'] = $sale['total_items'] - 1;
                    if ($saleUpdate['total_items'] == 0) {
                        $saleUpdate['status'] = '3';
                        $saleUpdate['tracking_status'] = 'cancelled';
                    }
                    $this->db->where('sale_id',$slaeID);
                    $this->db->update('sale',$saleUpdate);
                }
                else if ($_POST['status'] == 'delivered' || $_POST['status'] == 'delivered') {
                    $itemID = $_POST['id'];
                    $resp = $this->get_row("
                        SELECT s.seller_id,s.profit_percentage,s.balance, si.total 
                        FROM `sale_items` AS si 
                        INNER JOIN `products` AS p ON si.product_id = p.product_id 
                        INNER JOIN `brand` AS b ON p.brand_id = b.brand_id 
                        INNER JOIN `seller` AS s ON b.seller_id = s.seller_id 
                        WHERE si.sale_item_id = '$itemID';
                    ");
                    if ($resp['profit_percentage'] > 0) {
                        $balance = $resp['total']/100;
                        $balance = $balance*$resp['profit_percentage'];
                        $balance = $resp['total'] - $balance;
                        $updateBalance['balance'] = $balance+$resp['balance'];
                        $this->db->where('seller_id',$resp['seller_id']);
                        $this->db->update('seller',$updateBalance);
                    }
                }
                echo json_encode(array("status"=>true));
            }
            else{
                echo json_encode(array("status"=>false));
            }
        }
        else
        {
            redirect('admin');
        }
    }
    public function get_child_cats()
    {
        if (isset($_POST['id']) && strlen($_POST['id']) > 0) {
            $id = $_POST['id'];
            $resp = $this->get_results("SELECT * FROM `categories` WHERE `parent` = '$id' ORDER BY `title` ASC;");
            if ($resp) {
                $next = explode('-', $_POST['blockID']);
                $next = $next[1];
                $html = '<div class="row">';
                    $html .= '<label class="col-md-3 label-on-left">Select Category</label>';
                    $html .= '<div class="col-md-9">';
                        $html .= '<div class="form-group label-floating is-empty">';
                            $html .= '<label class="control-label"></label>';
                            $html .= '<select class="text-input form-control category-select-tag category-select-tag-dynamic" id="'.$_POST['blockID'].'" data-id="'.$next.'" required="required">';
                                $html .= '<option value="">Select Catgory</option>';
                                foreach ($resp as $key => $q) {
                                    $filters = explode(',', $q['filters']);
                                    if (in_array('size', $filters)) {
                                        $SizesFilter = 'true';
                                    }
                                    else{
                                        $SizesFilter = 'false';
                                    }
                                    if (in_array('color', $filters)) {
                                        $ColorsFilter = 'true';
                                    }
                                    else{
                                        $ColorsFilter = 'false';
                                    }
                                    $html .= '<option value="'.$q['id'].'" data-size="'.$SizesFilter.'" data-color="'.$ColorsFilter.'" data-filter-ids="'.$q['filter_ids'].'">'.$q['title'].'</option>';
                                }
                            $html .= '</select>';
                        $html .= '<span class="material-input"></span></div>';
                    $html .= '</div>';
                $html .= '</div>';
                echo json_encode(array("status"=>true,"html"=>$html));
            }
            else{
                echo json_encode(array("status"=>false));
            }
        }
    }
    public function get_transfer_history()
    {
        if ($_POST['id'] > 0) {
            $id = $_POST['id'];
            $seller = $this->get_row("SELECT `balance` FROM `seller` WHERE `seller_id` = '$id';");
            if ($seller) {
                $history = $this->get_results("SELECT * FROM `transfer_history` WHERE `seller_id` = '$id' ORDER BY `at` DESC;");
                $html = '';
                if ($history) {
                    foreach ($history as $key => $q) {
                        $html .= '<tr>';
                            $html .= '<td>'.$q['transfer_history_id'].'</td>';
                            $html .= '<td>'.$q['amount'].'</td>';
                            $html .= '<td>'.$q['method'].'</td>';
                            $html .= '<td>'.$q['desc'].'</td>';
                            $html .= '<td>'.$q['ref'].'</td>';
                            $html .= '<td>'.$q['at'].'</td>';
                        $html .= '</tr>';
                    }
                    $first = false;
                }
                else{
                    $first = true;
                }
                echo json_encode(array("status"=>true,"balance"=>$seller['balance'],"html"=>$html,"first"=>$first));
            }
            else{
                echo json_encode(array("status"=>false,"msg"=>"Nothing found."));
            }
        }
    }
    public function save_transfer_history()
    {
        if ($_POST) {
            parse_str($_POST['data'],$post);
            $sellerID = $post['seller_id'];
            $post['amount'] = str_replace('+', '', $post['amount']);
            $post['amount'] = str_replace('-', '', $post['amount']);
            $post['amount'] = str_replace('/', '', $post['amount']);
            $post['amount'] = str_replace('*', '', $post['amount']);
            $seller = $this->get_row("SELECT `balance` FROM `seller` WHERE `seller_id` = '$sellerID';");
            if ($post['amount'] > $seller['balance']) {
                echo json_encode(array("status"=>false,"msg"=>"your entered amount is not valid."));
            }
            else{
                $newBlance = $seller['balance'] - $post['amount'];
                unset($post['balance']);
                $this->db->insert('transfer_history',$post);
                $lastID = $this->db->insert_id();

                $this->db->where('seller_id', $sellerID);
                $this->db->update('seller',array("balance"=>$newBlance));

                $q = $this->get_row("SELECT * FROM `transfer_history` WHERE `transfer_history_id` = '$lastID';");
                $html = '';
                if ($q) {
                    $html .= '<tr>';
                        $html .= '<td>'.$q['transfer_history_id'].'</td>';
                        $html .= '<td>'.$q['amount'].'</td>';
                        $html .= '<td>'.$q['method'].'</td>';
                        $html .= '<td>'.$q['desc'].'</td>';
                        $html .= '<td>'.$q['ref'].'</td>';
                        $html .= '<td>'.$q['at'].'</td>';
                    $html .= '</tr>';
                }
                echo json_encode(array("status"=>true,"html"=>$html,"balance"=>$newBlance,"first"=>false));
            }

        }
    }
    public function get_filters_by_catid()
    {
        if ($_POST) {
            $id = $_POST['id'];
            $cat = $_POST['cat'];
            $ids = $this->get_row("SELECT `filter_ids` FROM `categories` WHERE `id` = '$cat';");
            $ids = $ids['filter_ids'];
            if (strlen($ids) > 0) {
                $filters = $this->get_results("SELECT * FROM `filter` WHERE `filter_id` IN ($ids) AND `status` = 'active' ORDER BY `admin_title` ASC;");
            }
            else{
                $filters = false;
            }
            $html = '';
            if ($filters) {
                foreach ($filters as $key => $q) {
                    $html .= '<tr>';
                        $html .= '<td>'.$q['filter_id'].'</td>';
                        $html .= '<td>'.$q['admin_title'].'</td>';
                        $html .= '<td>'.$q['title'].'</td>';
                        $values = $this->get_results("SELECT * FROM `filter_value` WHERE `filter_id` = '".$q['filter_id']."' ORDER BY `title` ASC;");
                        if ($values) {
                            $html .= '<td>';
                                $html .= '<table class="table table-bordered">';
                                    foreach ($values as $key2 => $value) {
                                        $html .= '<tr>';
                                            $html .= '<td>'.$value['title'].'</td>';
                                            $html .=  '<td><a href="javascript://" class="delete-value" data-id="'.$value['filter_value_id'].'">Delete</a></td>';
                                        $html .= '</tr>';
                                    }
                                $html .= '</table>';
                            $html .= '</td>';
                        }
                        else{
                            $html .= '<td></td>';
                        }
                    $html .= '</tr>';
                }
                echo json_encode(array("status"=>true,"html"=>$html));
            }
            else{
                echo json_encode(array("status"=>false));
            }
        }
    }
    public function get_filters_for_edit()
    {
        if ($_POST) {
            $id = $_POST['id'];
            $ids = $this->get_row("SELECT `filter_ids` FROM `categories` WHERE `id` = '".$_POST['cat']."';");
            $ids = $ids['filter_ids'];
            if (strlen($ids) > 0) {
                $filters = $this->get_results("SELECT `filter_id`,`title`,`admin_title` FROM `filter` WHERE `filter_id` IN ($ids) AND `status` = 'active' ORDER BY `admin_title` ASC;");
            }
            else{
                $filters = false;
            }
            if ($filters) {
                $html = '<input type="hidden" name="cat_id" value="'.$_POST['cat'].'">';
                foreach ($filters as $key => $q) {
                    $html .= '<div class="form-group">';
                        $html .= '<input type="checkbox" name="filter_ids[]" value="'.$q['filter_id'].'" checked="checked">&nbsp;&nbsp;';
                        $html .= '<label>'.$q['admin_title'].'</label>';
                    $html .= '</div><!-- /form-group -->';
                }
                $html .= '<div class="form-group">';
                    $html .= '<button type="submit" class="btn btn-success">Update</button>';
                $html .= '</div><!-- /form-group -->';
                echo json_encode(array("status"=>true,"html"=>$html));
            }
            else{
                echo json_encode(array("status"=>false,"msg"=>"nothing found"));
            }
        }
    }
    public function submit_cat_filters_ajax()
    {
        if ($_POST) {
            parse_str($_POST['data'],$data);
            $ids = implode(',', $data['filter_ids']);
            $update['filter_ids'] = $ids;
            $this->db->where('id',$data['cat_id']);
            $resp = $this->db->update('categories',$update);
            if ($resp) {
                $filters = $this->get_results("SELECT * FROM `filter` WHERE `filter_id` IN ($ids) ORDER BY `admin_title` ASC;");
                $html = '';
                if ($filters) {
                    foreach ($filters as $key => $q) {
                        $html .= '<tr>';
                            $html .= '<td>'.$q['admin_title'].'</td>';
                            $html .= '<td>'.$q['title'].'</td>';
                            $values = $this->get_results("SELECT * FROM `filter_value` WHERE `filter_id` = '".$q['filter_id']."' ORDER BY `title` ASC;");
                            if ($values) {
                                $html .= '<td>';
                                    $html .= '<table class="table table-bordered">';
                                        foreach ($values as $key2 => $value) {
                                            $html .= '<tr>';
                                                $html .= '<td>'.$value['title'].'</td>';
                                            $html .= '</tr>';
                                        }
                                    $html .= '</table>';
                                $html .= '</td>';
                            }
                            else{
                                $html .= '<td></td>';
                            }
                        $html .= '</tr>';
                    }
                    echo json_encode(array("status"=>true,"html"=>$html));
                }
                else{
                    echo json_encode(array("status"=>false,"msg"=>"no filter","error"=>2));
                }
            }
            else{
                echo json_encode(array("status"=>false,"msg"=>"not updated","error"=>1));
            }
        }
    }
    public function get_filters_for_add()
    {
        if ($_POST) {
            $id = $_POST['id'];
            $ids = $this->get_row("SELECT `filter_ids` FROM `categories` WHERE `id` = '$id';");
            $ids = $ids['filter_ids'];
            if (strlen($ids) > 0) {
                $filters = $this->get_results("SELECT `filter_id`,`title`,`admin_title` FROM `filter` WHERE `filter_id` NOT IN ($ids) AND `status` = 'active' ORDER BY `admin_title` ASC;");
            }
            else{
                $filters = $this->get_results("SELECT `filter_id`,`title`,`admin_title` FROM `filter` WHERE `status` = 'active' ORDER BY `admin_title` ASC;");
            }
            if ($filters) {
                foreach ($filters as $key => $q) {
                    $html .= '<option value="'.$q['filter_id'].'">'.$q['admin_title'].'</option>';
                }
                echo json_encode(array("status"=>true,"html"=>$html));
            }
            else{
                echo json_encode(array("status"=>false));
            }
        }
    }
    public function post_cat_filters_ajax()
    {
        if ($_POST) {
            parse_str($_POST['data'],$data);
            $id = $data['cat_id'];
            $ids_ = $this->get_row("SELECT `filter_ids` FROM `categories` WHERE `id` = '$id';");
            $ids_ = $ids_['filter_ids'];
            $ids = implode(',', $data['filter']);
            if (strlen($ids_) > 0) {
                $update['filter_ids'] = $ids_.','.$ids;
            }
            else{
                $update['filter_ids'] = $ids;
            }
            $this->db->where('id',$data['cat_id']);
            $resp = $this->db->update('categories',$update);
            if ($resp) {
                $ids = $update['filter_ids'];
                $filters = $this->get_results("SELECT * FROM `filter` WHERE `filter_id` IN ($ids) ORDER BY `admin_title` ASC;");
                $html = '';
                if ($filters) {
                    foreach ($filters as $key => $q) {
                        $html .= '<tr>';
                            $html .= '<td>'.$q['admin_title'].'</td>';
                            $html .= '<td>'.$q['title'].'</td>';
                            $values = $this->get_results("SELECT * FROM `filter_value` WHERE `filter_id` = '".$q['filter_id']."' ORDER BY `title` ASC;");
                            if ($values) {
                                $html .= '<td>';
                                    $html .= '<table class="table table-bordered">';
                                        foreach ($values as $key2 => $value) {
                                            $html .= '<tr>';
                                                $html .= '<td>'.$value['title'].'</td>';
                                            $html .= '</tr>';
                                        }
                                    $html .= '</table>';
                                $html .= '</td>';
                            }
                            else{
                                $html .= '<td></td>';
                            }
                        $html .= '</tr>';
                    }
                    echo json_encode(array("status"=>true,"html"=>$html));
                }
                else{
                    echo json_encode(array("status"=>false,"msg"=>"no filter","error"=>2));
                }
            }
            else{
                echo json_encode(array("status"=>false,"msg"=>"not updated","error"=>1));
            }
        }
    }

    public function update_product_image()
    {
        if ($_POST) {
            parse_str($_POST['data'],$post);
            $this->db->where('product_id',$post['product_id']);
            $resp = $this->db->update('products',array("product_image"=>$post['product_image']));
            if ($resp) {
                echo json_encode(array("status"=>true,"msg"=>"image updated"));
            }
            else{
                echo json_encode(array("status"=>true,"msg"=>"image not updated"));
            }
        }
    }
    public function update_product_price()
    {
        if ($_POST) {
            parse_str($_POST['data'],$post);
            $this->db->where('product_id',$post['product_id']);
            $resp = $this->db->update('products',array("price"=>$post['price']));
            if ($resp) {
                echo json_encode(array("status"=>true,"msg"=>"price updated"));
            }
            else{
                echo json_encode(array("status"=>true,"msg"=>"price not updated"));
            }
        }
    }
    public function update_cat_colors()
    {
        if ($_POST) {
            parse_str($_POST['data'],$post);
            $update['colors'] = implode(',', $post['color']);
            $this->db->where('id',$post['id']);
            $resp = $this->db->update('categories',$update);
            if ($resp) {
                echo json_encode(array("status"=>false,"msg"=>"updated :)"));
            }
            else{
                echo json_encode(array("status"=>false,"msg"=>"not updated :("));
            }
        }
    }
    public function update_cat_sizes()
    {
        if ($_POST) {
            parse_str($_POST['data'],$post);
            $update['sizes'] = implode(',', $post['size']);
            $this->db->where('id',$post['id']);
            $resp = $this->db->update('categories',$update);
            if ($resp) {
                echo json_encode(array("status"=>false,"msg"=>"updated :)"));
            }
            else{
                echo json_encode(array("status"=>false,"msg"=>"not updated :("));
            }
        }
    }

    //----
    public function get_cat_colors()
    {
        if ($_POST) {
            $id = $_POST['id'];
            $cat = $this->get_row("SELECT `id`,`colors`,`title` FROM `categories` WHERE `id`= '$id';");
            if ($cat) {
                $html = '';
                $catColors = explode(',', $cat['colors']);

                $colors = $this->get_results("SELECT `color_id`,`name` FROM `color` ORDER BY `name` ASC;");
                foreach ($colors as $key => $q) {
                    $html .= '<div class="col-md-6">';
                        $html .= '<div class="form-group">';
                            if (in_array($q['color_id'], $catColors)) {
                                $html .= '<input type="checkbox" name="color[]" value="'.$q['color_id'].'" checked="checked">';
                            }
                            else{
                                $html .= '<input type="checkbox" name="color[]" value="'.$q['color_id'].'">';
                            }
                            $html .= '<label>&nbsp;'.$q['name'].'</label>';
                        $html .= '</div><!-- /form-group -->';
                    $html .= '</div><!-- /6 -->';
                }

                $html .= '<div class="col-md-12">';
                    $html .= '<div class="form-group">';
                        $html .= '<button type="submit" class="btn btn-success">Update</button>';
                    $html .= '</div><!-- /form-group -->';
                $html .= '</div><!-- /12 -->';

                echo json_encode(array("status"=>true,"html"=>$html,"title"=>$cat['title'].' -> colors'));
            }
            else{
                echo json_encode(array("status"=>false,"msg"=>"invalid call!"));
            }
        }
    }
    public function get_colors_by_cat()
    {
        if ($_POST) {
            $id = $_POST['id'];
            $cat = $this->get_row("SELECT `id`,`colors`,`title` FROM `categories` WHERE `id`= '$id';");
            if ($cat) {
                $html = '';
                $cat['colors'] = trim($cat['colors']);
                $catColors = explode(',', $cat['colors']);
                if (strlen($catColors[0]) > 0) {
                    $colors = $this->get_results("SELECT `color_id`,`name` FROM `color` ORDER BY `name` ASC;");
                    $html = '<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="checkbox" id="check-all-colors"> &nbsp;&nbsp;
                                        <label class="control-label">All</label>
                                    </div>
                                </div><!-- /2 -->
                            </div><!-- {row} -->';
                    foreach ($colors as $key => $q) {
                        if (in_array($q['color_id'], $catColors)) {
                            $html .= '<div class="row">';
                                $html .= '<div class="col-md-2">';
                                    $html .= '<div class="form-group">';
                                        $html .= '<input type="checkbox" name="color[]" value="'.$q['color_id'].'"> &nbsp;&nbsp;';
                                        $html .= '<label class="control-label">'.$q['name'].'</label>';
                                    $html .= '</div>';
                                $html .= '</div><!-- /4 -->';
                                $html .= '<div class="col-md-4">';
                                    $html .= '<div class="form-group">';
                                        $html .= '<input type="file" name="color_file'.$q['color_id'].'"> &nbsp;&nbsp;';
                                        $html .= '<label class="btn" style="display: block; cursor: pointer;background: #fff;color: #000;border: 3px solid '.$q['name'].';">'.$q['name'].' Image</label>';
                                    $html .= '</div>';
                                $html .= '</div><!-- /4 -->';
                                $html .= '<div class="col-md-6">';
                                    $html .= '<div class="form-group">';
                                        $html .= '<label>Price</label>';
                                        $html .= '<input type="text" data-name="color_price'.$q['color_id'].'" class="form-control color-price color-filter-price" value="0"> &nbsp;&nbsp;';
                                    $html .= '</div>';
                                $html .= '</div><!-- /6 -->';
                            $html .= '</div><!-- {row} -->';
                        }
                    }
                    echo json_encode(array("status"=>true,"html"=>$html));
                }
                else{
                    echo json_encode(array("status"=>false));
                }
            }
            else{
                echo json_encode(array("status"=>false));
            }
        }
    }
    public function get_cat_sizes()
    {
        if ($_POST) {
            $id = $_POST['id'];
            $cat = $this->get_row("SELECT `id`,`sizes`,`title` FROM `categories` WHERE `id`= '$id';");
            if ($cat) {
                $html = '';
                $catsizes = explode(',', $cat['sizes']);

                $sizes = $this->get_results("SELECT `size_id`,`name` FROM `size` ORDER BY `name` ASC;");
                foreach ($sizes as $key => $q) {
                    $html .= '<div class="col-md-6">';
                        $html .= '<div class="form-group">';
                            if (in_array($q['size_id'], $catsizes)) {
                                $html .= '<input type="checkbox" name="size[]" value="'.$q['size_id'].'" checked="checked">';
                            }
                            else{
                                $html .= '<input type="checkbox" name="size[]" value="'.$q['size_id'].'">';
                            }
                            $html .= '<label>&nbsp;'.$q['name'].'</label>';
                        $html .= '</div><!-- /form-group -->';
                    $html .= '</div><!-- /6 -->';
                }

                $html .= '<div class="col-md-12">';
                    $html .= '<div class="form-group">';
                        $html .= '<button type="submit" class="btn btn-success">Update</button>';
                    $html .= '</div><!-- /form-group -->';
                $html .= '</div><!-- /12 -->';

                echo json_encode(array("status"=>true,"html"=>$html,"title"=>$cat['title'].' -> sizes'));
            }
            else{
                echo json_encode(array("status"=>false,"msg"=>"invalid call!"));
            }
        }
    }
    public function get_sizes_by_cat()
    {
        if ($_POST) {
            $id = $_POST['id'];
            $cat = $this->get_row("SELECT `id`,`sizes`,`title` FROM `categories` WHERE `id`= '$id';");
            if ($cat) {
                $cat['sizes'] = trim($cat['sizes']);
                $catsizes = explode(',', $cat['sizes']);
                $sizes = $this->get_results("SELECT `size_id`,`name` FROM `size` ORDER BY `name` ASC;");

                if (strlen($catsizes[0]) > 0) {
                    $html = '<div class="form-group">
                                <input type="checkbox" id="check-all-sizes"> &nbsp;&nbsp;
                                <label class="control-label">All</label>
                            </div>';
                    foreach ($sizes as $key => $q) {
                        if (in_array($q['size_id'], $catsizes)) {
                            $html .= '<div class="row">';
                                $html .= '<div class="col-md-4">';
                                    $html .= '<div class="form-group">';
                                        $html .= '<input type="checkbox" name="size[]" value="'.$q['size_id'].'"> &nbsp;&nbsp;';
                                        $html .= '<label class="control-label">'.$q['name'].'</label>';
                                    $html .= '</div>';
                                $html .= '</div><!-- /4 -->';
                                $html .= '<div class="col-md-8">';
                                    $html .= '<div class="form-group">';
                                        $html .= '<label>Price</label>';
                                        $html .= '<input type="text" data-name="size_price'.q['size_id'].'" class="form-control size-price size-filter-price" value="0"> &nbsp;&nbsp;';
                                    $html .= '</div>';
                                $html .= '</div><!-- /8 -->';
                            $html .= '</div><!-- {row} -->';
                        }
                    }
                    echo json_encode(array("status"=>true,"html"=>$html));
                }
                else{
                    echo json_encode(array("status"=>false));
                }

            }
            else{
                echo json_encode(array("status"=>false));
            }
        }
    }

    //common select

    public function get_results($sql){
        $res = $this->db->query($sql);
        if ($res->num_rows() > 0)
        {
            return $res->result_array();
        }
        else
        {
            return false;
        }
    }
    public function get_row($sql){
        $res = $this->db->query($sql);
        if ($res->num_rows() > 0)
        {
            $resp = $res->result_array();
            return $resp[0];
        }
        else
        {
            return false;
        }
    }
    private function clean($string) {
        $string = str_replace(' ', '-', $string);
        $string = str_replace('&', '-', $string);
        $string = str_replace('/', '-', $string);
        $string = str_replace('%', '-', $string);
        $string = str_replace('(', '-', $string);
        $string = str_replace(')', '-', $string);
        $string = str_replace('{', '-', $string);
        $string = str_replace('}', '-', $string);
        $string = str_replace('[', '-', $string);
        $string = str_replace(']', '-', $string);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }
    public function get_setting_byid($id)
    {
        return $this->get_row("SELECT * FROM `settings` WHERE `id` = '$id';");
    }
    public function category_folders()
    {
        $cat = $this->get_row("SELECT `id` FROM `categories` WHERE `images_moved` = 'no' ORDER BY `id` ASC;");
        if ($cat) {
            $path = './uploads/products/'.$cat['id'];
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $catId = $cat['id'];
            $products = $this->get_results("SELECT `product_id`,`product_image`,`color_images` FROM `products` WHERE `category_id` = '$catId' AND `images_moved` = 'no';");
            if ($products) {
                foreach ($products as $key => $p) {
                    $productId = $p['product_id'];
                    $img = $p['product_image'];
                    if (strlen($img) > 4) {
                        rename('./uploads/products/'.$img, $path.'/'.$img);
                        if (strlen($p['color_images']) > 4) {
                            $colorImages = explode(',', $p['color_images']);
                            foreach ($colorImages as $key => $cImg) {
                                rename('./uploads/products/'.$cImg, $path.'/'.$cImg);
                            }
                        }
                        $images = $this->get_results("SELECT `product_image_id`,`image` FROM `product_image` WHERE `product_id` = '$productId' AND `images_moved` = 'no';");
                        if ($images) {
                            foreach ($images as $key => $image) {
                                $img_ = $image['image'];
                                rename('./uploads/products/'.$img_, $path.'/'.$img_);
                                $this->db->where('product_image_id',$image['product_image_id']);
                                $this->db->update('product_image',array('images_moved'=>'yes'));
                            }
                            echo 'complete';
                        }
                        else{
                            $this->db->where('product_id',$productId);
                            $this->db->update('products',array('images_moved'=>'yes'));
                            echo 'no images Found';
                        }
                    }
                    else{
                        $this->db->where('product_id',$productId);
                        $this->db->update('products',array('images_moved'=>'yes','image_found'=>'no'));
                        echo 'no image Found';
                    }
                }
            }
            else{
                $this->db->where('id',$catId);
                $this->db->update('categories',array('images_moved'=>'yes'));
                echo 'no product Found';
            }
        }
        else{
            echo 'The End';
        }
    }
}
