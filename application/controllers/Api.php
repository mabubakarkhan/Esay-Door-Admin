<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
class Api extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        // header('Content-type: text/json');
        date_default_timezone_set('Asia/Kolkata');
        $this->load->database();
        $this->load->helper('sms_helper');
        $this->load->helper(array('form', 'url'));
        $this->db->query("SET time_zone='+05:30'");
        //error_reporting(E_ALL);
        //ini_set('display_errors', 1);
    }

    public function index()
    {
        echo json_encode(array("api"=>"welcome"));
    }
    public function generator_uid($string = '1234567890',$length = 6)
    {
        $password = "";
        $possible = $string;
        $maxlength = strlen($possible);
        if ($length > $maxlength)
        {
          $length = $maxlength;
        }
        $i = 0;
        while ($i < $length)
        {
          $char = substr($possible, mt_rand(0, $maxlength-1), 1);
          if (!strstr($password, $char))
          {
              $password .= $char;
              $i++;
          }
        }
        return $password;
    }
    public function get_categories_old()
    {
        $parent = 0;

        if($_REQUEST['parent']){
            $parent  = $_REQUEST['parent'];
        }
        $categories = $this->get_categories_short($parent,0,$this) ;
        $data["responce"] = true;
        $data["data"] = $categories;
        echo json_encode($data);
    }
    public function get_categories()
    {
        $parent = 0 ;

        if($_REQUEST['parent']){
            $parent  = $_REQUEST['parent'];
        }
        $q = $this->db->query("SELECT a.*, ifnull(Deriv1.Count , 0) as Count, ifnull(Total1.PCount, 0) as PCount FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` 
        LEFT OUTER JOIN (SELECT `category_id`,COUNT(*) AS PCount FROM `products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id` 
        WHERE a.`parent`=" . $parent." AND a.`status` = 1");
        $title = '';
        $i=0;
        foreach($q->result() as $key => $row){
            
            $CatID = $row->id;
            $sub_cat = $this->db->query("SELECT `title` FROM `categories` WHERE `parent` = '".$CatID."' AND `status` = 1");
            $SubCat = '';
            $j = 0;
            foreach ($sub_cat->result() as $cat) {
                if ($j == 0) {
                    $SubCat = $cat->title;
                }
                else{
                    $SubCat .= ','.$cat->title;
                }
                $j++;
            }
            $row->sub_categories = $SubCat;
            $categories[$key] = $row;
        }
        $data["responce"] = true;
        $data["data"] = $categories;
        echo json_encode($data);
    }
    public function for_you_categories()
    {
        $cats = $this->model->get_results("SELECT `id`,`title`,`image`,`app_icon` FROM `categories` WHERE `status` = 1 AND `for_you` = 'yes';");
        $data["responce"] = true;
        $data["data"] = $cats;
        echo json_encode($data);
    }

    public function get_categories_short($parent,$level,$th)
    {
        $q = $th->db->query("SELECT a.*, ifnull(Deriv1.Count , 0) as Count, ifnull(Total1.PCount, 0) as PCount FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` 
        LEFT OUTER JOIN (SELECT `category_id`,COUNT(*) AS PCount FROM `products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id` 
        WHERE a.`parent`=" . $parent);

        $return_array = array();

        foreach($q->result() as $row){
            if ($row->Count > 0) {
                $sub_cat =  $this->get_categories_short($row->id, $level + 1,$th);
                $row->sub_cat = $sub_cat;       
            }
            elseif ($row->Count==0) {

            }
            $return_array[] = $row;
        }
        return $return_array;
    }

    public function pincode()
    {
        $q =$this->db->query("SELECT * from `pincode`");
        echo json_encode($q->result());
    }
    /* user registration */               

    public function update_profile_pic()
    {
        $data = array(); 
        $this->load->library('form_validation');
        /* add users table validation */
        $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');

        if ($this->form_validation->run() == FALSE) 
        {
            $data["responce"] = false;  
            $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
        }
        else{

            if(isset($_FILES["image"]) && $_FILES["image"]["size"] > 0){
                $config['upload_path']          = './uploads/profile/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('image'))
                {
                    $data["responce"] = false;  
                    $data["error"] = 'Error! : '.$this->upload->display_errors();
                }
                else
                {
                    $img_data = $this->upload->data();
                    $this->load->model("common_model");
                    $this->common_model->data_update("customer", array(
                            "image"=>$img_data['file_name']
                            ),array("customer_id"=>$this->input->post("user_id")));
                            
                    $data["responce"] = true;
                    $data["data"] = $img_data['file_name'];
                }

            }
            else{
                $data["responce"] = false;  
                $data["error"] = 'Please choose profile image';
            }
        }
        echo json_encode($data);
    }

    public function change_password()
    {
        $data = array(); 
        if ( !(isset($_REQUEST['user_id']) && isset($_REQUEST['current_password']) && isset($_REQUEST['new_password'])) && !($_REQUEST['user_id'] > 0 && strlen($_REQUEST['current_password']) > 1 && strlen($_REQUEST['new_password']) > 1) )
        {
            $data["responce"] = false;
            $data["error"] = 'Please provide required data';
        }
        else
        {
            $this->load->model("common_model");
            $user_id = $_REQUEST['user_id'];
            $current_password = md5($_REQUEST['current_password']);
            $new_password = md5($_REQUEST['new_password']);
            $resp = $this->get_row("SELECT * FROM `customer` WHERE `customer_id` = '$user_id' and  `password` = '$current_password';");

            if($resp){
                $this->db->where('customer_id',$user_id);
                $update = $this->db->update('customer',array("password"=>$new_password));
                if ($update) {
                    $data["responce"] = true;
                }
                else{
                    $data["responce"] = false;  
                    $data["error"] = 'not updated, please try again.';
                }
            }
            else{
                $data["responce"] = false;  
                $data["error"] = 'Current password do not match';
            }
        }
        echo json_encode($data);
    }

    public function update_userdata()
    {
        $data = array(); 
        if ( !(isset($_REQUEST['user_id']) && isset($_REQUEST['fname']) && isset($_REQUEST['lname']) ) && !($_REQUEST['user_id'] > 0 && strlen($_REQUEST['fname']) > 1 && strlen($_REQUEST['lname']) > 1 ) ) 
        {
            $data["responce"] = false;  
            $data["error"] = 'Please provide all required information';
        }
        else
        {
            if(isset($_FILES["image"]) && $_FILES["image"]["size"] > 0){
                $config['upload_path']          = './uploads/profile/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('image'))
                {
                    $data["responce"] = false;  
                    $data["error"] = 'Error! : '.$this->upload->display_errors();
                    echo json_encode($data);
                    exit;
                }
                else
                {
                    $img_data = $this->upload->data();
                    $image_name = $img_data['file_name'];
                    $update["image"]=$image_name;
                }
            }

            $update['fname'] = $_REQUEST['first_name'];
            $update['lname'] = $_REQUEST['last_name'];
            if (isset($_REQUEST['email'])) {
                $check = $this->get_row("SELECT `email` FROM `customer` WHERE `email` = '".$_REQUEST['email']."' AND `customer_id` != '".$_REQUEST['user_id']."';");
                if ($check) {
                    $data["responce"] = false;  
                    $data["error"] = 'Email is already in use.';
                    echo json_encode($data);
                    exit;
                }
                $update['email'] = $_REQUEST['email'];
            }
            if (isset($_REQUEST['gender'])) {
                $update['gender'] = $_REQUEST['gender'];
            }
            if (isset($_REQUEST['country_id'])) {
                $update['country_id'] = $_REQUEST['country_id'];
            }
            if (isset($_REQUEST['state_id'])) {
                $update['state_id'] = $_REQUEST['state_id'];
            }
            if (isset($_REQUEST['city_id'])) {
                $update['city_id'] = $_REQUEST['city_id'];
            }
            if (isset($_REQUEST['house_no'])) {
                $update['house_no'] = $_REQUEST['house_no'];
            }
            $this->db->where('customer_id',$_REQUEST['user_id']);
            $resp =$this->db->update('customer',$update);
            if ($resp) {
                $user = $this->get_row("SELECT * FROM `customer` WHERE `customer_id` = '".$_REQUEST['user_id']."';");
                $data["responce"] = true;
                $data["data"] = array("data"=>$user);
            }
            else{
                $data["responce"] = false;  
                $data["error"] = 'not updated, please try again.';
            }
        }
        echo json_encode($data);
    }

    /* user login json */
     
    public function login()
    {
        $data = array(); 
        if (!(isset($_REQUEST['phone']))) 
        {
            $data["responce"] = false;
            $data["error"] =  'phone number missing';
        }
        else
        {
            $data["responce"] = true;
            $phone = $_REQUEST['phone'];
            $check = $this->get_row("SELECT `phone` FROM `customer` WHERE `phone` = '$phone';");
            if ($check) {
                $data['status'] = 'signin';
            }
            else{
                $data['status'] = 'signup';
            }
        }
        echo json_encode($data);
    }
    public function submit_login()
    {
        if (!(isset($_REQUEST['phone']) && isset($_REQUEST['password']))) {
            echo json_encode(array("responce"=>false, "error"=>"please provide required information"));
        }
        else{
            if ($_REQUEST['status'] == 'signin') {
                $password = md5($_REQUEST['password']);
                $phone = $_REQUEST['phone'];
                $login = $this->get_row("SELECT * FROM `customer` WHERE `phone` = '$phone' AND `password` = '$password';");
                if ($login) {
                    $user = $login['customer_id'];
                    $addresses = $this->get_results("
                        SELECT ud.*,c.name AS city, s.socity_name AS socity 
                        FROM `user_address` AS ud 
                        LEFT JOIN `city` AS c ON ud.city_id = c.city_id 
                        LEFT JOIN `socity` AS s ON ud.socity_id = s.socity_id 
                        WHERE ud.user_id = '$user' 
                        ORDER BY ud.user_address_id DESC
                    ;");
                    if ($addresses) {
                        $addressCheck = true;
                    }
                    else{
                        $addressCheck = false;
                        $addresses = null;
                    }
                    echo json_encode(array("responce"=>true,"user_data"=>$login,"addressCheck"=>$addressCheck,"addresses"=>$addresses));
                }
                else{
                    echo json_encode(array("responce"=>false,"message"=>"password is not correct."));
                }
            }
            else{
                $post['phone'] = $_REQUEST['phone'];
                $post['password'] = md5($_REQUEST['password']);
                $post['status'] = 'active';
                $resp = $this->db->insert('customer',$post);
                $UserID = $this->db->insert_id();
                if ($resp) {
                    $mobile = str_replace('+', '', $post['phone']);
                    $mobile = preg_replace('/-/', '', $mobile, 1);
                    $mobile = preg_replace('/=/', '', $mobile, 1);
                    $mobile = preg_replace('/00/', '', $mobile, 2);
                    $mobile = preg_replace('/0/', '92', $mobile, 1);
                    $sms_setting = $this->get_row("SELECT * FROM `sms_setting` WHERE `sms_setting_id` = '1';");
                    $ch = curl_init();
                    $mask = urlencode($sms_setting['mask']);
                    $pass = urlencode($sms_setting['password']);
                    $id = urlencode($sms_setting['username']);
                    $msg = urlencode($sms_setting['signup_msg']);
                    file_get_contents("https://fastsmsalerts.com/api/composesms&id=".$id."&pass=".$pass."&mask=".$mask."&to=".$mobile."&portable=&lang=english&msg=".$msg."&type=json");

                    $login = $this->get_row("SELECT * FROM `customer` WHERE `customer_id` = '$UserID';");
                    echo json_encode(array("status"=>true,"user_data"=>$login));
                }
                else{
                    echo json_encode(array("status"=>false,"msg"=>"not submitted, please try again."));
                }
            }
        }
    }

    function city()
    {
        $q = $this->db->query("SELECT * FROM `city`");
        $city["city"] = $q->result();
        echo json_encode($city);
    } 

    function store()
    {
        $data = array(); 
        $_POST = $_REQUEST;          
        $getdata = $_REQUEST['city_id'];
        if($getdata!=''){
            $q = $this->db->query("SELECT `user_fullname` ,`user_id` FROM `users` WHERE `user_city` = '$getdata'");
            $data["data"] = $q->result();
            echo json_encode($data);
        }
        else
        {
            $data["data"] ="Error";
            echo json_encode($data);
        }
    }
    function get_products()
    {
        $this->load->model("product_model");
        $cat_id = "";
        if($_REQUEST['cat_id']){
            $cat_id = $_REQUEST['cat_id'];
        }
        if(isset($_REQUEST['search'])){
            $search= $_REQUEST['search'];
        }
        else{
            $search= false;
        }
        if(isset($_REQUEST['page'])){
            $page= $_REQUEST['page'];
        }
        else{
            $page= 1;
        }
        if(isset($_REQUEST['brands'])){
            $brands= $_REQUEST['brands'];
        }
        else{
            $brands= false;
        }
        if(isset($_REQUEST['min_price'])){
            $min_price= $_REQUEST['min_price'];
        }
        else{
            $min_price= false;
        }
        if(isset($_REQUEST['max_price'])){
            $max_price= $_REQUEST['max_price'];
        }
        else{
            $max_price= false;
        }

        $data["responce"] = true;
        $datas = $this->product_model->get_products(false,$cat_id,$search,$page,$brands,$min_price,$max_price);
        foreach ($datas['price_asc'] as  $product) {
            $present = date('m/d/Y h:i:s a', time());
            $date1 = $product->start_date." ".$product->start_time;
            $date2 = $product->end_date." ".$product->end_time;

            if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
            {

                if(empty($product->deal_price))  ///Runing
                {
                    $price= $product->price;
                }
                else{
                    $price= $product->deal_price;
                }
            }
            else{
                $price= $product->price;//expire
            }

            $tags = $this->get_results("
                SELECT pt.value, ct.name 
                FROM `product_tag` AS pt 
                INNER JOIN `cat_tag` AS ct ON pt.cat_tag_id = ct.cat_tag_id 
                WHERE pt.product_id = '$product->product_id' AND ct.status = 'active' 
                ORDER BY ct.name ASC
            ;");

            $data['data']['price_asc'][] = array(
                'product_id' => $product->product_id,
                'product_name'=> $product->product_name,
                'product_name_arb'=> $product->product_arb_name,
                'product_name_urdu'=> $product->urdu_title,
                'product_description_arb'=>$product->product_arb_description,
                'category_id'=> $product->category_id,
                'product_description'=>$product->product_description,
                'price' =>$product->price,
                'save' =>$product->discount,
                'old_price' =>$price+$product->discount,
                'sale_percentage' =>$product->sale_percentage,
                'mrp' =>$product->mrp,
                'product_image'=>$product->product_image,
                'status' => '0',
                'in_stock' =>$product->in_stock,
                'unit_value'=>$product->unit_value,
                'unit'=>$product->unit,
                'increament'=>$product->increament,
                'rewards'=>$product->rewards,
                'stock'=>$product->stock,
                'title'=>$product->title,
                'brand_title'=>$product->BrandTitle,
                'brand_urdu_title'=>$product->BrandTitleUrdu,
                'brand_image'=>$product->BrandImage,
                'size'=>$product->size,
                'color'=>$product->color,
                'brand_id'=>$product->brand_id,
                'tags'=>$tags
            );
        }
        foreach ($datas['price_desc'] as  $product) {
            $present = date('m/d/Y h:i:s a', time());
            $date1 = $product->start_date." ".$product->start_time;
            $date2 = $product->end_date." ".$product->end_time;

            if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
            {

                if(empty($product->deal_price))  ///Runing
                {
                    $price= $product->price;
                }
                else{
                    $price= $product->deal_price;
                }
            }
            else{
                $price= $product->price;//expire
            }


            $tags = $this->get_results("
                SELECT pt.value, ct.name 
                FROM `product_tag` AS pt 
                INNER JOIN `cat_tag` AS ct ON pt.cat_tag_id = ct.cat_tag_id 
                WHERE pt.product_id = '$product->product_id' AND ct.status = 'active' 
                ORDER BY ct.name ASC
            ;");

            $data['data']['price_desc'][] = array(
                'product_id' => $product->product_id,
                'product_name'=> $product->product_name,
                'product_name_arb'=> $product->product_arb_name,
                'product_name_urdu'=> $product->urdu_title,
                'product_description_arb'=>$product->product_arb_description,
                'category_id'=> $product->category_id,
                'product_description'=>$product->product_description,
                'price' =>$product->price,
                'save' =>$product->discount,
                'old_price' =>$price+$product->discount,
                'sale_percentage' =>$product->sale_percentage,
                'mrp' =>$product->mrp,
                'product_image'=>$product->product_image,
                'status' => '0',
                'in_stock' =>$product->in_stock,
                'unit_value'=>$product->unit_value,
                'unit'=>$product->unit,
                'increament'=>$product->increament,
                'rewards'=>$product->rewards,
                'stock'=>$product->stock,
                'title'=>$product->title,
                'brand_title'=>$product->BrandTitle,
                'brand_urdu_title'=>$product->BrandTitleUrdu,
                'brand_image'=>$product->BrandImage,
                'size'=>$product->size,
                'color'=>$product->color,
                'brand_id'=>$product->brand_id,
                'tags'=>$tags
            );
        }
        foreach ($datas['title_asc'] as  $product) {
            $present = date('m/d/Y h:i:s a', time());
            $date1 = $product->start_date." ".$product->start_time;
            $date2 = $product->end_date." ".$product->end_time;

            if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
            {

                if(empty($product->deal_price))  ///Runing
                {
                    $price= $product->price;
                }
                else{
                    $price= $product->deal_price;
                }
            }
            else{
                $price= $product->price;//expire
            }

            $tags = $this->get_results("
                SELECT pt.value, ct.name 
                FROM `product_tag` AS pt 
                INNER JOIN `cat_tag` AS ct ON pt.cat_tag_id = ct.cat_tag_id 
                WHERE pt.product_id = '$product->product_id' AND ct.status = 'active' 
                ORDER BY ct.name ASC
            ;");

            $data['data']['title_asc'][] = array(
                'product_id' => $product->product_id,
                'product_name'=> $product->product_name,
                'product_name_arb'=> $product->product_arb_name,
                'product_name_urdu'=> $product->urdu_title,
                'product_description_arb'=>$product->product_arb_description,
                'category_id'=> $product->category_id,
                'product_description'=>$product->product_description,
                'price' =>$product->price,
                'save' =>$product->discount,
                'old_price' =>$price+$product->discount,
                'sale_percentage' =>$product->sale_percentage,
                'mrp' =>$product->mrp,
                'product_image'=>$product->product_image,
                'status' => '0',
                'in_stock' =>$product->in_stock,
                'unit_value'=>$product->unit_value,
                'unit'=>$product->unit,
                'increament'=>$product->increament,
                'rewards'=>$product->rewards,
                'stock'=>$product->stock,
                'title'=>$product->title,
                'brand_title'=>$product->BrandTitle,
                'brand_urdu_title'=>$product->BrandTitleUrdu,
                'brand_image'=>$product->BrandImage,
                'size'=>$product->size,
                'color'=>$product->color,
                'brand_id'=>$product->brand_id,
                'tags'=>$tags
            );
        }
        foreach ($datas['title_desc'] as  $product) {
            $present = date('m/d/Y h:i:s a', time());
            $date1 = $product->start_date." ".$product->start_time;
            $date2 = $product->end_date." ".$product->end_time;

            if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
            {

                if(empty($product->deal_price))  ///Runing
                {
                    $price= $product->price;
                }
                else{
                    $price= $product->deal_price;
                }
            }
            else{
                $price= $product->price;//expire
            }

            $tags = $this->get_results("
                SELECT pt.value, ct.name 
                FROM `product_tag` AS pt 
                INNER JOIN `cat_tag` AS ct ON pt.cat_tag_id = ct.cat_tag_id 
                WHERE pt.product_id = '$product->product_id' AND ct.status = 'active' 
                ORDER BY ct.name ASC
            ;");

            $data['data']['title_desc'][] = array(
                'product_id' => $product->product_id,
                'product_name'=> $product->product_name,
                'product_name_arb'=> $product->product_arb_name,
                'product_name_urdu'=> $product->urdu_title,
                'product_description_arb'=>$product->product_arb_description,
                'category_id'=> $product->category_id,
                'product_description'=>$product->product_description,
                'price' =>$product->price,
                'save' =>$product->discount,
                'old_price' =>$price+$product->discount,
                'sale_percentage' =>$product->sale_percentage,
                'mrp' =>$product->mrp,
                'product_image'=>$product->product_image,
                'status' => '0',
                'in_stock' =>$product->in_stock,
                'unit_value'=>$product->unit_value,
                'unit'=>$product->unit,
                'increament'=>$product->increament,
                'rewards'=>$product->rewards,
                'stock'=>$product->stock,
                'title'=>$product->title,
                'brand_title'=>$product->BrandTitle,
                'brand_urdu_title'=>$product->BrandTitleUrdu,
                'brand_image'=>$product->BrandImage,
                'size'=>$product->size,
                'color'=>$product->color,
                'brand_id'=>$product->brand_id,
                'tags'=>$tags
            );
        }
        $brands = $this->db->query("SELECT DISTINCT(`brand_id`) AS 'BrandID' FROM `products` WHERE `category_id` = '$cat_id' ");
        $brands = $brands->result();
        if ($brands) {
            foreach ($brands as $key => $value) {
                $q = $this->db->query("SELECT * FROM `brand` WHERE brand_id=".$value->BrandID);
                $brand = $q->row();
                $data['data']['brands'][$key] = array(
                    "brand_id" => $brand->brand_id,
                    "title" => $brand->title,
                    "image" => $brand->image
                );
            }
        }
        else{
            $data['data']['brands'] = false;
        }
        $data['data']['brands'] = $datas['brands'];
        echo json_encode($data);
    }

    function get_products_simple()
    {
        $this->load->model("product_model");
        $cat_id = "";
        if($_REQUEST['cat_id']){
            $cat_id = $_REQUEST['cat_id'];
        }
        if(isset($_REQUEST['search'])){
            $search= $_REQUEST['search'];
        }
        else{
            $search= false;
        }
        if(isset($_REQUEST['page'])){
            $page= $_REQUEST['page'];
        }
        else{
            $page= 1;
        }
        if(isset($_REQUEST['brands'])){
            $brands= $_REQUEST['brands'];
        }
        else{
            $brands= false;
        }
        if(isset($_REQUEST['min_price'])){
            $min_price= $_REQUEST['min_price'];
        }
        else{
            $min_price= false;
        }
        if(isset($_REQUEST['max_price'])){
            $max_price= $_REQUEST['max_price'];
        }
        else{
            $max_price= false;
        }

        $data["responce"] = true;
        $datas = $this->product_model->get_products_simple(false,$cat_id,$search,$page,$brands,$min_price,$max_price);
        foreach ($datas['products'] as  $product) {
            $present = date('m/d/Y h:i:s a', time());
            $date1 = $product->start_date." ".$product->start_time;
            $date2 = $product->end_date." ".$product->end_time;

            if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
            {

                if(empty($product->deal_price))  ///Runing
                {
                    $price= $product->price;
                }
                else{
                    $price= $product->deal_price;
                }
            }
            else{
                $price= $product->price;//expire
            }

            $tags = $this->get_results("
                SELECT pt.value, ct.name 
                FROM `product_tag` AS pt 
                INNER JOIN `cat_tag` AS ct ON pt.cat_tag_id = ct.cat_tag_id 
                WHERE pt.product_id = '$product->product_id' AND ct.status = 'active' 
                ORDER BY ct.name ASC
            ;");

            $data['data']['products'][] = array(
                'product_id' => $product->product_id,
                'product_name'=> $product->product_name,
                'product_name_arb'=> $product->product_arb_name,
                'product_name_urdu'=> $product->urdu_title,
                'product_description_arb'=>$product->product_arb_description,
                'category_id'=> $product->category_id,
                'product_description'=>$product->product_description,
                'price' =>$product->price,
                'save' =>$product->discount,
                'old_price' =>$price+$product->discount,
                'sale_percentage' =>$product->sale_percentage,
                'mrp' =>$product->mrp,
                'product_image'=>$product->product_image,
                'status' => '0',
                'in_stock' =>$product->in_stock,
                'unit_value'=>$product->unit_value,
                'unit'=>$product->unit,
                'increament'=>$product->increament,
                'rewards'=>$product->rewards,
                'stock'=>$product->stock,
                'title'=>$product->title,
                'brand_title'=>$product->BrandTitle,
                'brand_urdu_title'=>$product->BrandTitleUrdu,
                'brand_image'=>$product->BrandImage,
                'size'=>$product->size,
                'color'=>$product->color,
                'brand_id'=>$product->brand_id,
                'tags'=>$tags
            );
        }
        
        $brands = $this->db->query("SELECT DISTINCT(`brand_id`) AS 'BrandID' FROM `products` WHERE `category_id` = '$cat_id' ");
        $brands = $brands->result();
        if ($brands) {
            foreach ($brands as $key => $value) {
                $q = $this->db->query("SELECT * FROM `brand` WHERE brand_id=".$value->BrandID);
                $brand = $q->row();
                $data['data']['brands'][$key] = array(
                    "brand_id" => $brand->brand_id,
                    "title" => $brand->title,
                    "image" => $brand->image
                );
            }
        }
        else{
            $data['data']['brands'] = false;
        }
        $data['data']['brands'] = $datas['brands'];
        echo json_encode($data);
    }

    function get_products_suggestion()
    {
        $this->load->model("product_model");
        $cat_id = "";
        if($_REQUEST['cat_id'])
        {
            $cat_id = $_REQUEST['cat_id'];
        }
        $search= $_REQUEST['search'];
        $data["data"] = $this->product_model->get_products_suggestion(false,$cat_id,$search,$_REQUEST['page']);
        echo json_encode($data);
    }

    public function single($id)
    {
        $product = $this->get_row("
            SELECT p.*, b.title AS Brand,b.slug AS BrandSlug, c.title AS Category, c.filters 
            FROM `products` AS p 
            INNER JOIN `categories` AS c ON c.id = p.category_id 
            LEFT JOIN `brand` AS b ON p.brand_id = b.brand_id 
            WHERE p.product_id = '$id' AND p.in_stock = 1
        ;");
        if ($product) {
            $tags = $this->get_results("
                SELECT pt.value, ct.name 
                FROM `product_tag` AS pt 
                INNER JOIN `cat_tag` AS ct ON pt.cat_tag_id = ct.cat_tag_id 
                WHERE pt.product_id = $id AND ct.status = 'active' 
                ORDER BY ct.name ASC
            ;");
            $data['product'] = $product;
            $data['tags'] = $tags;
            if (strlen($product['size']) > 0) {
                $sizes = $product['size'];
                $data["sizes"] = $this->get_results("SELECT `size_id`,`name`,`full_name` FROM `size` WHERE `size_id` IN($sizes) ORDER BY `name` ASC;");
            }
            else{
                $data["sizes"] = false;
            }
            if (strlen($product['color']) > 0) {
                $colors = $product['color'];
                $data["colors"] = $this->get_results("SELECT `color_id`,`name`,`font_color` FROM `color` WHERE `color_id` IN($colors) ORDER BY `name` ASC;");
            }
            else{
                $data["colors"] = false;
            }
            $data['photos'] = $this->get_results("SELECT `image` FROM `product_image` WHERE `product_id` = '$id';");
            $this->db->query("UPDATE `products` SET `visit`=`visit`+1 WHERE `product_id` = '$id'");
        }
        else{
            $data["responce"] = false;
            $data["error"] = 'error! : wrong ID passed.';
        }
        echo json_encode($data);
    }


    function get_time_slot()
    {
        if (isset($_REQUEST['date']) && !(strlen($_REQUEST['date']) > 0)) 
        {
            $data["responce"] = false;
            $data["error"] = 'Warning! : please provide required data';
            
        }
        else
        {
            $date = date("Y-m-d",strtotime($_REQUEST['date']));
            
            $time = date("H:i:s");            
                    
            $this->load->model("time_model");
            $time_slot = $this->time_model->get_time_slot();
            $cloasing_hours =  $this->time_model->get_closing_hours($date);
            
            $begin = new DateTime($time_slot->opening_time);
            $end   = new DateTime($time_slot->closing_time);
            
            $interval = DateInterval::createFromDateString($time_slot->time_slot.' min');
            
            $times    = new DatePeriod($begin, $interval, $end);
            $time_array = array();
            foreach ($times as $time) {
                if(!empty($cloasing_hours)){
                    foreach($cloasing_hours as $c_hr){
                    if($date == date("Y-m-d")){
                        if(strtotime($time->format('h:i A')) > strtotime(date("h:i A")) &&  strtotime($time->format('h:i A')) > strtotime($c_hr->from_time) && strtotime($time->format('h:i A')) <  strtotime($c_hr->to_time) ){
                            $time_array[] =  $time->format('h:i A'). ' - '.$time->add($interval)->format('h:i A');
                        }else{
                            $time_array[] =  $time->format('h:i A'). ' - '.$time->add($interval)->format('h:i A');
                        }
                    
                    }else{
                        if(strtotime($time->format('h:i A')) > strtotime($c_hr->from_time) && strtotime($time->format('h:i A')) <  strtotime($c_hr->to_time) ){
                            $time_array[] =  $time->format('h:i A'). ' - '.$time->add($interval)->format('h:i A');
                        }else{
                            $time_array[] =  $time->format('h:i A'). ' - '.$time->add($interval)->format('h:i A');
                        }
                    }
                    
                    }
                }
                else{
                    if(strtotime($date) == strtotime(date("Y-m-d"))){
                        if(strtotime($time->format('h:i A')) > strtotime(date("h:i A"))){
                            $time_array[] =  $time->format('h:i A'). ' - '.$time->add($interval)->format('h:i A');
                        }
                    }
                    else{
                        $time_array[] =  $time->format('h:i A'). ' - '. $time->add($interval)->format('h:i A');
                    }
                }
            }
            $data["responce"] = true;
            $data["times"] = $time_array;
        }
        echo json_encode($data);
    } 

    public function create_group()
    {
        if (!(isset($_REQUEST['user_id']) && isset($_REQUEST['title'])) && !(strlen($_REQUEST['user_id']) > 0 && strlen($_REQUEST['title']) > 0)) 
        {
            $data["responce"] = false;  
            $data["error"] = 'Warning! : please provide required data';
            echo json_encode($data);
        }
        else{
            $insert_array = array(
                "user_id"=>$_REQUEST['user_id'],
                "title" =>$_REQUEST['title']
            );
            $this->load->model("common_model");
            $data['group_id'] = $this->common_model->data_insert("user_product_group",$insert_array);
            $data['title'] = $_REQUEST['title'];
            $data["responce"] = true;
            echo json_encode($data);
        }
    }
    public function get_groups()
    {
        $this->load->model("product_model");
        if (!(isset($_REQUEST['user_id'])) && !(strlen($_REQUEST['user_id']) > 0))
        {
            $data["responce"] = false;  
            $data["error"] = 'Warning! : user ID required';
            echo json_encode($data);
        }
        else{
            $data  = $this->product_model->get_groups($_REQUEST['user_id']);
            echo json_encode($data);
        }
    }
    public function delete_group()
    {
        $this->load->model("product_model");
        if (!(isset($_REQUEST['group_id'])) && !(strlen($_REQUEST['group_id']) > 0))
        {
            $data["responce"] = false;  
            $data["error"] = 'Warning! : Group ID required';
            echo json_encode($data);
        }
        else{
            $data  = $this->product_model->delete_group($_REQUEST['group_id']);
            echo json_encode($data);
        }
    }
    public function add_to_list()
    {
        if (!(isset($_REQUEST['group_id']) && isset($_REQUEST['product_id'])) && !(strlen($_REQUEST['group_id']) > 0 && strlen($_REQUEST['product_id']) > 0))
        {
            $data["responce"] = false;  
            $data["error"] = 'Warning! : Please provide required data';
            echo json_encode($data);
        }
        else{
            $insert_array = array(
                "group_id"=>$_REQUEST['group_id'],
                "product_id" =>$_REQUEST['product_id']
            );
            $this->load->model("common_model");
            $this->common_model->data_insert("list",$insert_array);
            $data["responce"] = true;  
            echo json_encode($data);
        }
    }

    public function get_list()
    {
        $this->load->model("product_model");
        if (!(isset($_REQUEST['group_id'])) && !(strlen($_REQUEST['group_id']) > 0))
        {
            $data["responce"] = false;  
            $data["error"] = 'Warning! : Group ID required';
            echo json_encode($data);
        }
        else{
            $data  = $this->product_model->get_list($_REQUEST['group_id']);
            echo json_encode($data);
        }
    }
    public function delete_list()
    {
        $this->load->model("product_model");
        if (!(isset($_REQUEST['list_id'])) && !(strlen($_REQUEST['list_id']) > 0))
        {
            $data["responce"] = false;  
            $data["error"] = 'Warning! : List ID required';
            echo json_encode($data);
        }
        else{
            $data  = $this->product_model->delete_list($_REQUEST['list_id']);
            echo json_encode($data);
        }
    }
    function text_for_send_order()
    {
        echo json_encode(array("data"=>"<p>Our delivery boy will come withing your choosen time and will deliver your order. \n </p>"));
    }
    function send_order()
    {
        if ( !(isset($_REQUEST['user_id'])  && isset($_REQUEST['data']) && isset($_REQUEST['location'])) && !($_REQUEST['user_id'] > 0 && strlen($_REQUEST['data']) > 1 && strlen($_REQUEST['location']) > 1 ) )
        {
            $data["responce"] = false;  
            $data["error"] = 'Warning! : Some required data missing';
        }
        else
        {
            $ld = $this->db->query("SELECT user_location.*, socity.* FROM user_location
            INNER JOIN socity ON socity.socity_id = user_location.socity_id
            WHERE user_location.location_id = '".$_REQUEST['location']."' limit 1");
            $location = $ld->row();

            $store_id= $_REQUEST['store_id'];
            $payment_method= $_REQUEST['payment_method'];
            $sales_id= $_REQUEST['sales_id'];
            $date = date("Y-m-d", strtotime($_REQUEST['date']));

            $times = explode('-',$_REQUEST['time']);
            $fromtime = date("h:i a",strtotime(trim($times[0])));
            $totime = date("h:i a",strtotime(trim($times[1])));

            if (isset($_REQUEST['note']) && strlen($_REQUEST['note']) > 0) {
                $note = $_REQUEST['note'];
            }
            else{
                $note = '';
            }


            $user_id = $_REQUEST['user_id'];
            $insert_array = array(
                "user_id"=>$user_id,
                "socity_id" => $location->socity_id, 
                "delivery_charge" => $location->delivery_charge,
                "location_id" => $location->location_id, 
                "payment_method" => $payment_method,
                "note" => $note,
                "new_store_id" => $store_id
            );
            $this->load->model("common_model");
            $id = $this->common_model->data_insert("sale",$insert_array);

            $data_post = $_REQUEST['data'];
            $data_array = json_decode($data_post);
            $total_rewards = 0;
            $total_price = 0;
            $total_kg = 0;
            $total_items = array();
            foreach($data_array as $dt){
                $qty_in_kg = $dt->qty; 
                if($dt->unit=="gram"){
                    $qty_in_kg =  ($dt->qty * $dt->unit_value) / 1000;     
                }
                if(strlen($dt->size) > 0){
                    $size = $dt->size;
                }
                else{
                    $size = '';
                }
                if(strlen($dt->color) > 1){
                    $color = $dt->color;
                }
                else{
                    $color = '';
                }
                $total_rewards = $total_rewards + ($dt->qty * $dt->rewards);
                $total_price = $total_price + ($dt->qty * $dt->price);
                $total_kg = $total_kg + $qty_in_kg;
                $total_items[$dt->product_id] = $dt->product_id;

                if (isset($dt->user_id) && strlen($dt->user_id) > 0 && $dt->user_id != '') {
                    $order_user_id = $dt->user_id;
                }
                else{
                    $order_user_id = 0;
                }    

                $array = array(
                    "product_id"=>$dt->product_id,
                    "user_id"=>$order_user_id,
                    "qty"=>$dt->qty,
                    "unit"=>$dt->unit,
                    "unit_value"=>$dt->unit_value,
                    "sale_id"=>$id,
                    "price"=>$dt->price,
                    "qty_in_kg"=>$qty_in_kg,
                    "size"=>$size,
                    "color"=>$color,
                    "rewards" =>$dt->rewards
                );
                $this->common_model->data_insert("sale_items",$array);
            }
            if($_REQUEST['total_ammount'] !="" || $_REQUEST['total_ammount'] != 0 )
            {
                $total_price = $_REQUEST['total_ammount'];
            }
            $this->db->query("UPDATE sale SET total_amount = '".$total_price."', total_kg = '".$total_kg."', total_items = '".count($total_items)."', total_rewards = '".$total_rewards."' where sale_id = '".$id."'");
            $data["responce"] = true;  
            $data["data"] = addslashes( "<p>Your order No #".$id." is send success fully \n Our delivery person will delivered order \n                         between ".$fromtime." to ".$totime." on ".$date." \n Please keep <strong>".$total_price."</strong> on delivery Thanks for being with Us.</p>" );
            $data["data_arb"] = addslashes( "<p> تم إرسال طلبك رقم  #".$id." بنجاح . سوف يقوم موظف التسليم الخاص بنا بتسليم الطلب بين الساعة  ".$fromtime."ص و  ".$totime." ص في  ".$date." \n . الرجاء الاحتفاظ بالرقم  <strong>".$total_price."</strong> عند التسليم . شكراً لكونك معنا..</p>" );
            $data["order_number"] = $id;
            if (isset($_REQUEST['type']) && strlen($_REQUEST['type']) > 0 && $_REQUEST['type'] == 'food') {
                $data["delivery_charge"] = $location->delivery_charge;
                $data["total_price"] = $total_price;
                $data["total_order_price"] = $total_price + $location->delivery_charge;
            }
        }
        echo json_encode($data);
    }
    public function post_order()
    {
        $json = file_get_contents('php://input');
        $_REQUEST['data'] = json_decode($json);
        // error_reporting(E_ALL);
        #working
        $user = $this->get_row("SELECT * FROM `customer` WHERE `customer_id` = '".$_REQUEST['user_id']."';");
        $address = $this->get_row("SELECT * FROM `user_address` WHERE `user_address_id` = '".$_REQUEST['address_id']."';");
        $location['user_id'] = $_REQUEST['user_id'];
        $location['pincode'] = $address['pincode'];
        $location['house_no'] = $address['house_no'];
        $location['receiver_name'] = $address['receiver_name'];
        $location['receiver_mobile'] = $address['receiver_mobile'];
        $location['receiver_email'] = $address['receiver_email'];
        $location['socity_id'] = 1;
        $location['city_id'] = $address['city_id'];
        $this->db->insert('user_location',$location);
        $location_id = $this->db->insert_id();

        $addresses = $this->get_row("SELECT `user_address_id` FROM `user_address` WHERE `user_id` = '".$_REQUEST['user_id']."' ORDER BY `user_address_id` DESC;");
        if (!($addresses)) {
            $location['title'] = 'Address 1';
            $this->db->insert('user_address',$location);
        }

        $cart['user_id'] = $_REQUEST['user_id'];
        $cart['location_id'] = $location_id;
                    
        $cart['payment_method'] = $_REQUEST['payment_method'];
        if ($cart['payment_method'] == 'card' && $_REQUEST['save_my_card'] == 'yes') {
            $cart['card_name'] = $_REQUEST['card_name'];
            $cart['card_number'] = $_REQUEST['card_number'];
            $cart['card_cvc'] = $_REQUEST['card_cvc'];
            $cart['card_expiry_month'] = $_REQUEST['card_expiry_month'];
            $cart['card_expiry_year'] = $_REQUEST['card_expiry_year'];
            $cart['save_my_card'] = 'yes';
        }
        $cart['total_amount'] = $_REQUEST['total_amount'];
        $cart['total_items'] = $_REQUEST['total_products'];
        $cart['delivery_charge'] = $_REQUEST['shipping_fee'];
                    
        $cart['discount_code'] = '';
        $cart['discount'] = 0;

        $stripeAmount = ($cart['delivery_charge']+$cart['total_amount'])*100;
        $cart['sale_id'] = $this->order_number();
        $resp = $this->db->insert('sale',$cart);
        $sale_id = $cart['sale_id'];

        // $data_array = json_decode($_REQUEST['data']);
        if ($_REQUEST['data']) {
            foreach ($_REQUEST['data']->data as $k => $q) {
                $id = $q->product_id;
                $Product = $this->get_row("SELECT * FROM `products` WHERE `product_id` = '$id';");
                $item['sale_id'] = $sale_id;
                $item['product_id'] = $Product['product_id'];
                $item['product_name'] = $Product['product_name'];
                $item['qty'] = $q->qty;
                $item['price'] = $q->price;
                $item['total'] = $q->total;
                $item['size'] = $q->size;
                $item['color'] = $q->color;
                $this->db->insert('sale_items',$item);
            }
        }

                    if ($_REQUEST['payment_method'] == 'card') {
                        require_once('application/libraries/stripe-php/init.php');
                        \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
                        
                        
                        $charge = \Stripe\Charge::create ([
                                "amount" => $stripeAmount,
                                "currency" => "pkr",
                                "source" => $data2['stripeToken'],
                                "description" => "easy door payment" 
                        ]);
                        $status = $charge->status;
                        if ($status == 'succeeded') {
                            $Update2['card_payment_status'] = 'paid';
                            $Update2['strip_id'] = $charge->id;
                            $Update2['strip_balance_transaction'] = $charge->balance_transaction;
                            $this->db->where('sale_id',$sale_id);
                            $this->db->update('sale',$Update2);
                            $this->session->set_flashdata('success', 'Payment made successfully.');
                        }
                        else{
                            $Update2['status'] = '3';
                            $Update2['tracking_status'] = 'cancelled';
                            $Update2['card_payment_status'] = 'unpaid';
                            $this->db->update('sale',$Update2);
                            
                            $this->db->where('sale_id',$sale_id);
                            $this->db->update('sale_items',array("status","cancelled"));
                            $this->session->set_flashdata('failure', 'Payment Not Made.');
                        }
                    }
        $sms_setting = $this->get_row("SELECT * FROM `sms_setting` WHERE `sms_setting_id` = '1';");

        $mobile = str_replace('+', '', $user['phone']);
        $mobile = preg_replace('/-/', '', $mobile, 1);
        $mobile = preg_replace('/=/', '', $mobile, 1);
        $mobile = preg_replace('/00/', '', $mobile, 2);
        $mobile = preg_replace('/0/', '92', $mobile, 1);
        $ch = curl_init();
        $mask = urlencode($sms_setting['mask']);
        $pass = urlencode($sms_setting['password']);
        $id = urlencode($sms_setting['username']);
        $msg = urlencode($sms_setting['order_msg']);
        file_get_contents("https://fastsmsalerts.com/api/composesms&id=".$id."&pass=".$pass."&mask=".$mask."&to=".$mobile."&portable=&lang=english&msg=".$msg."&type=json");

        if (strlen($user['email']) > 3) {
            $to = $user['email'];
            $subject = 'Order Submit | easydoor.pk';
            $message = $sms_setting['order_msg'];
            $from = EMAIL_FROM;
            $headers = ''; 
            $headers .= "From: ".$from."" ."\r\n" .
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
            $headers .= "X-Priority: 3\r\n";
            $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;
            mail($to, $subject, $message, $headers);
        }


        $mobile = str_replace('+', '', '923455555613');
        $mobile = preg_replace('/-/', '', $mobile, 1);
        $mobile = preg_replace('/=/', '', $mobile, 1);
        $mobile = preg_replace('/00/', '', $mobile, 2);
        $mobile = preg_replace('/0/', '92', $mobile, 1);
        $ch = curl_init();
        $mask = urlencode($sms_setting['mask']);
        $pass = urlencode($sms_setting['password']);
        $id = urlencode($sms_setting['username']);
        $msg = urlencode('new order on easydoor.pk.');
        file_get_contents("https://fastsmsalerts.com/api/composesms&id=".$id."&pass=".$pass."&mask=".$mask."&to=".$mobile."&portable=&lang=english&msg=".$msg."&type=json");

        $from = 'sale@easydoor.pk';
        $to = 'sale@easydoor.pk';
        $subject = 'Order Submitted';
        $message = 'new order on easydoor.pk.';
        $headers = '';
        $headers .= "From: ".$from."" ."\r\n" .
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $headers .= "X-Priority: 3\r\n";
        $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;
        mail($to, $subject, $message, $headers);

        echo json_encode(array("status"=>true,"msg"=>"order submitted successfully, will contact back you very soon","order_id"=>$sale_id));
    }
    protected function order_number()
    {
        date_default_timezone_set('Asia/Karachi');
        $lastOrder = $this->get_row("SELECT `sale_id`,`at` FROM `sale` ORDER BY `sale_id` DESC");
        $today = new DateTime();
        $lastDate = new DateTime($lastOrder['at']);
        $interval = $today->diff($lastDate);
        $hours = ($interval->format('%d')*24)+$interval->format('%h');
        if ($hours <= 4) {
            $a = array(5,7,9);
            $rand = array_rand($a,1);
            $id = $lastOrder['sale_id'] + $a[$rand];
        }
        else if ($hours <= 24) {
            $a = array(21,23,27);
            $rand = array_rand($a,1);
            $id = $lastOrder['sale_id'] + $a[$rand];
        }
        else {
            $days = round($hours/24);
            $id = $lastOrder['sale_id'] + $days;
        }
        return intval($id);
    }

    function my_orders($user_id)
    {
        $resp = $this->get_results("SELECT * FROM `sale` WHERE `user_id` = '$user_id' ORDER BY `sale_id` DESC;");
        echo json_encode(array("status"=>true,"data"=>$resp));
    }
    
    function delivered_complete()
    {
        $this->load->model("product_model");
        if (!(isset($_REQUEST['user_id']) && $_REQUEST['user_id'] > 0))
        {
            $data["responce"] = false;  
            $data["error"] = 'Warning! : please provide user ID';
            
        }
        else
        {
            $this->load->model("product_model");
            $data = $this->product_model->get_sale_by_user2($_REQUEST['user_id']);
        }
        echo json_encode($data);
    }
    function order_details($sale_id)
    {
        $resp = $this->get_results("
            SELECT si.*,p.*, size.name AS Size, color.name AS Color 
            FROM `sale_items` AS si 
            INNER JOIN `products` AS p ON p.product_id = si.product_id 
            LEFT JOIN `size` on size.size_id = p.size 
            LEFT JOIN `color` on color.color_id = p.color 
            WHERE si.sale_id = $sale_id 
        ");
        echo json_encode(array("status"=>true,"data"=>$resp));
    }
    function cancel_order()
    {
        $this->load->model("product_model");
        if (!(isset($_REQUEST['sale_id']) && $_REQUEST['sale_id'] > 0) && !(isset($_REQUEST['user_id']) && $_REQUEST['user_id'] > 0))
        {
            $data["responce"] = false;  
            $data["error"] = 'Warning! : please provide sale/user ID';
        }
        else
        {
            $user_id = $_REQUEST['user_id'];
            $sale_id = $_REQUEST['sale_id'];
            $this->db->query("UPDATE `sale` SET `status` = 3 WHERE `user_id` = '$user_id' and  `sale_id` = '$sale_id' ");
            $this->db->delete('sale_items', array('sale_id' => $_REQUEST['sale_id'])); 
            $data["responce"] = true;
            $data["message"] = "Your order cancel successfully";
        }
        echo json_encode($data);
    }
    public function get_countries()
    {            
        $data  = $this->get_results("SELECT * FROM `country` ORDER BY `name` ASC");
        echo json_encode(array("data"=>$data));
    }
    public function get_states($country)
    {            
        $data  = $this->get_results("SELECT * FROM `state` WHERE `country_id` = '$country' ORDER BY `name` ASC");
        echo json_encode(array("data"=>$data));
    }
    public function get_cities($state)
    {            
        $data  = $this->get_results("SELECT * FROM `city` WHERE `state_id` = '$state' ORDER BY `name` ASC");
        echo json_encode(array("data"=>$data));
    }
    function get_varients_by_id()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('ComaSepratedIdsString', 'IDS',  'trim|required');
        if ($this->form_validation->run() == FALSE) 
        {
            $data["responce"] = false;  
            $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
            
        }
        else
        {
            $this->load->model("product_model");
            $data  = $this->product_model->get_prices_by_ids($this->input->post("ComaSepratedIdsString"));
        }
        echo json_encode($data);
    }
    function get_sliders()
    {
        $q = $this->db->query("SELECT * FROM `slider`");
        echo json_encode($q->result());
    }
    function get_banner()
    {
        $q = $this->db->query("SELECT * FROM `banner`");
        echo json_encode($q->result());
    }
    function get_feature_banner()
    {
        $q = $this->db->query("SELECT * FROM `feature_slider`");
        echo json_encode($q->result());
    }
    function get_waive_limit_settings()
    {
        $q = $this->get_row("SELECT * FROM `settings` WHERE `id` = 3");
        echo json_encode(array('data' => $q ));
    }
    function add_address()
    {
        if ( !(isset($_REQUEST['user_id']) && isset($_REQUEST['pincode']) && isset($_REQUEST['socity_id']) && isset($_REQUEST['house_no']) && isset($_REQUEST['title']) && isset($_REQUEST['city_id']) && isset($_REQUEST['state_id']) && isset($_REQUEST['country_id'])) && !($_REQUEST['user_id'] > 0 && strlen($_REQUEST['pincode']) > 0 && strlen($_REQUEST['socity_id']) > 0 && strlen($_REQUEST['house_no']) > 0 && strlen($_REQUEST['title']) > 0 && strlen($_REQUEST['city_id']) > 0 && strlen($_REQUEST['state_id']) > 0 && strlen($_REQUEST['country_id']) > 0 ) )
        {
            $data["responce"] = false;  
            $data["error"] = 'Warning! : please provide all required data';
        }
        else
        {            
            $this->db->insert("user_address",$_REQUEST);
            $insert_id = $this->db->insert_id();
            $UserID = $_REQUEST['user_id'];
            $addresses = $this->get_results("
                SELECT ud.*,c.name AS city, s.socity_name AS socity 
                FROM `user_address` AS ud 
                LEFT JOIN `city` AS c ON ud.city_id = c.city_id 
                LEFT JOIN `socity` AS s ON ud.socity_id = s.socity_id 
                WHERE ud.user_id = '$UserID' 
                ORDER BY ud.user_address_id DESC
            ;");
            $data["responce"] = true;
            $data["data"] = $addresses;
        }
        echo json_encode($data);
    }
    public function edit_address()
    {
        $data = array();
        if ( !(isset($_REQUEST['user_address_id']) && isset($_REQUEST['pincode']) && isset($_REQUEST['socity_id']) && isset($_REQUEST['house_no']) && isset($_REQUEST['title']) && isset($_REQUEST['city_id']) && isset($_REQUEST['state_id']) && isset($_REQUEST['country_id']) ) && !($_REQUEST['user_address_id'] > 0 && strlen($_REQUEST['pincode']) > 0 && strlen($_REQUEST['socity_id']) > 0 && strlen($_REQUEST['house_no']) > 0 && strlen($_REQUEST['title']) > 0 && strlen($_REQUEST['city_id']) > 0 && strlen($_REQUEST['state_id']) > 0 && strlen($_REQUEST['country_id']) > 0 ) )
        {
            $data["responce"] = false;  
            $data["error"] = 'Warning! : please provide all required data';
        }
        else
        {
            $this->db->where('user_address_id',$_REQUEST['user_address_id']);
            unset($_REQUEST['user_address_id']);
            $this->db->update('user_address',$_REQUEST);
            $data["responce"] = true;
            $data["message"] = "Your Address Update successfully";  
        }
        echo json_encode($data);
    }
    /* Delete Address */
    public function delete_address()
    {
        if (!( isset($_REQUEST['user_address_id']) && strlen($_REQUEST['user_address_id']) > 0 ))
        {
            $data["responce"] = false;
            $data["error"] = 'Address ID required';
        }
       else{
            $this->db->delete("user_address",array("user_address_id"=>$_REQUEST['user_address_id']));
            $data["responce"] = true;
            $data["message"] = 'Your Address deleted successfully.';
        }
        echo json_encode($data);
    }
    /* End Delete  Address */
    public function get_address()
    {
        if (!( isset($_REQUEST['user_id']) && strlen($_REQUEST['user_id']) > 0 ))
        {
            $data["responce"] = false;
            $data["error"] = 'User ID required';
        }
        else
        {
            $UserID = $_REQUEST['user_id'];
            $addresses = $this->get_results("
                SELECT ud.*,c.name AS city, s.socity_name AS socity 
                FROM `user_address` AS ud 
                LEFT JOIN `city` AS c ON ud.city_id = c.city_id 
                LEFT JOIN `socity` AS s ON ud.socity_id = s.socity_id 
                WHERE ud.user_id = '$UserID' 
                ORDER BY ud.user_address_id DESC
            ;");
            $data["responce"] = true;
            $data["data"] = $addresses;
        }
        echo json_encode($data);
    }
    /* contact us */
    public function returnpolicy()
    {
        $q = $this->db->query("SELECT * FROM `pageapp` WHERE id =4");
        $data["responce"] = true;
        $data['data'] = $q->result();
        echo json_encode($data);
    }
    /* end contact us */
    /* about us */
    public function aboutus()
    {
        $q = $this->db->query("SELECT * FROM `pageapp` WHERE id=2"); 
        $data["responce"] = true;     
        $data['data'] = $q->result();
        echo json_encode($data);  
    }
    /* end about us */
    /* about us */
    public function terms()
    {
        $q = $this->db->query("SELECT * FROM `pageapp` WHERE id=3");
        $data["responce"] = true;
        $data['data'] = $q->result();
        echo json_encode($data);
    }
    /* end about us */
    public function register_fcm()
    {
        $data = array();
        if ( !(isset($_REQUEST['user_id']) && isset($_REQUEST['token']) && isset($_REQUEST['device'])) && !($_REQUEST['user_id'] > 0 && strlen($_REQUEST['token']) > 1 && strlen($_REQUEST['device']) > 1) ) 
        {
            $data["responce"] = false;
            $data["error"] = 'Please provide required data';
            
        }
        else
        {   
            $device = $_REQUEST['device'];
            $token =  $_REQUEST['token'];
            $user_id =$_REQUEST['user_id'];
            
            $field = "";
            if($device=="android"){
                $field = "user_ios_token";
            }else if($device=="ios"){
                $field = "user_ios_token";
            }
            if($field!=""){
                $this->db->query("UPDATE registers SET ".$field." = '".$token."' WHERE user_id = '".$user_id."'");
                $data["responce"] = true;    
            }else{
                $data["responce"] = false;
                $data["error"] = "Device type is not set";
            }        
        }
        echo json_encode($data);
    }
    public function test_fcm()
    {
        $message["title"] = "test";
        $message["message"] = "grocery test";
        $message["image"] = "";
        $message["created_at"] = date("Y-m-d");  
        $this->load->helper('gcm_helper');
        $gcm = new GCM();   
        $result = $gcm->send_topics("gorocer",$message ,"android"); 
        echo $result;
    }
    /* Check Duplicate User */
    public function check_user_via_phone()
    {
        $data = array();
        if (!( isset($_REQUEST['phone']) && strlen($_REQUEST['phone']) > 0 ))
        {
            $data["responce"] = false;
            $data["error"] = 'Phone required';
        }
        else{
            $phone = $_REQUEST['phone'];
            $request = $this->db->query("SELECT `user_phone` FROM `registers` WHERE `user_phone` = '$phone' LIMIT 1");
            if($request->num_rows() > 0){
                $data["responce"] = true;
                $data["msg"] = 'user already registered';
            }
            else{
                $data["responce"] = false;
                $data["msg"] = 'user not registered';
            }
        }
        echo json_encode($data);
    }
    /* Forgot Password */
    public function forgot_password()
    {
        $data = array();
        if (!( isset($_REQUEST['email']) && strlen($_REQUEST['email']) > 0 ))
        {
            $data["responce"] = false;
            $data["error"] = 'Email ID required';
        }
        else
        {
            $email = $_REQUEST['email'];
            $request = $this->db->query("SELECT * FROM `registers` WHERE `user_email` = '$email' LIMIT 1");
            if($request->num_rows() > 0){
                $user = $request->row();
                $code=mt_rand(1000,9999);
                $token=md5($code);
                $update=$this->db->query("UPDATE `registers` SET varified_token='".$token."' WHERE user_email='".$email."' "); 
                $email = $user->user_email;
                $name = $user->user_fullname;
                $return = $this->send_email_verified_mail($email,$token,$name);
                if ($update){
                    $data["responce"] = true;
                    $data["error"] = 'Varification Mail Send : ';
                    $data["error_arb"] = 'نجاح! : أرسل البريد الاسترداد إلى عنوان البريد الإلكتروني الخاص بك يرجى التحقق من الارتباط.';
                }
                else{
                    $data["responce"] = false;  
                    $data["error"] = 'Warning! : Something is wrong with system.';
                    $data["error_arb"] = 'خطـأ!. : لا يوجد مستخدم مسجل بهذا البريد الإلكتروني.';
                }
            }
            else{
                $data["responce"] = false;  
                $data["error"] = 'Warning! : No user found with this email.';
                $data["error_arb"] = 'خطـأ! : لا يوجد مستخدم مسجل بهذا البريد الإلكتروني.';
            }
        }
        echo json_encode($data);
    }
    public function send_email_verified_mail($email,$token,$name)
    {
        $message = $this->load->view('users/modify_password',array("name"=>$name,"active_link"=>site_url("index.php/users/verify_email?email=".$email."&token=".$token)),TRUE);
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->to($email);
        $this->email->from('support@noveltyretail.com','Novelty Retail');
        $this->email->subject('Forgot password request');
        $this->email->message('Hi '.$name.'<br> Your password forgot request is accepted plase visit following link to change your password.<br><br>
        '.site_url().'/users/modify_password/'.$token);
        return $this->email->send();
    }
    /* End Forgot Password */
    public function wallet(){
        $data = array(); 
        $_POST = $_REQUEST;
        if($_REQUEST['user_id']==""){
            $data= array("success" => 'unsucess', "wallet"=>0 );
        }
        else{
            $id = $_REQUEST['user_id'];
            $q = $this->db->query("SELECT * FROM `registers` WHERE `user_id` = '$id' Limit 1");
            if ($q->num_rows() > 0)
            {
                $row = $q->row(); 
                $data["responce"] = true;  
                $data= array("success" => 'success', "wallet"=>$row->wallet);
            }
            else{
                $data= array("success" => 'unsucess', "wallet"=>0 );
            }
        }
        echo json_encode($data);
    }
    public function rewards(){
        $data = array(); 
        $_GET = $_REQUEST;
        $id = $_REQUEST['user_id'];
        if($_REQUEST['user_id']==""){
            $data= array("success" => 'unsucess', "total_rewards"=> 0 ) ;
        }
        else{
            $q = $this->db->query("SELECT `rewards` FROM `registers` WHERE `user_id` = '$id' ");
            if ($q->num_rows() > 0)
            {
                $row = $q->row(); 
                $data["responce"] = true;  
                $data= array("success" => 'success', "total_rewards"=>$row->rewards) ;
            }
            else{
                $data= array("success" => hastalavista, "total_rewards"=> 0 ) ;
            }
        }
        echo json_encode($data);
    }
    public function shift(){
        $data = array(); 
        $_POST = $_REQUEST;
        if($_REQUEST['user_id']==""){
            $data= array("success" => 'unsucess', "total_rewards"=> 0 ) ;
        }
        else{
            $amount=$_REQUEST['amount'];
            $rewards=$_REQUEST['rewards'];
            $final_rewards= 0;
                        
                        
            $select= $this->db->query("SELECT * FROM rewards WHERE id=1");
            if ($select->num_rows() > 0)
            {
               $row = $select->row_array(); 
               $point= $row['point'];
            }    
            $reward_value = $point*$rewards;
            $final_amount=$amount+$reward_value;
            $data["wallet_amount"]= [array("final_amount"=>$final_amount, "final_rewards"=>0,"amount"=>$amount,"rewards"=>$rewards,"pont"=>$point)];
            $this->db->query("DELETE FROM delivered_order WHERE user_id = '".$_REQUEST['user_id']."'");
            $this->db->query("UPDATE `registers` SET wallet='".$final_amount."', rewards='0' where(user_id='".$_REQUEST['user_id']."' )"); 
        }
        echo json_encode($data);
    }
    public function wallet_on_checkout(){
        $data = array(); 
        $_POST = $_REQUEST;
        if($_REQUEST['wallet_amount']>=$_REQUEST['total_amount']){
            $wallet_amount=$_REQUEST['wallet_amount'];
            $amount=$_REQUEST['total_amount'];
            $final_amount=$wallet_amount-$amount;
            $balance=0;
            $data["final_amount"]= [array("wallet"=>$final_amount, "total"=>$balance)];
        }
        if($_REQUEST['wallet_amount']<=$_REQUEST['total_amount']){
            $wallet_amount=$_REQUEST['wallet_amount'];
            $amount=$_REQUEST['total_amount'];
            $final_amount=0;
            $balance=$amount-$wallet_amount;
            $data["final_amount"]= [array("wallet"=>$final_amount, "total"=>$balance, "used_wallet" => $wallet_amount)];
        }
        else{
            
        }
        echo json_encode($data);
    }
    public function recharge_wallet(){
        $data = array(); 
        $_POST = $_REQUEST;
        $user_id = $_REQUEST['user_id'];
        $q = $this->db->query("SELECT wallet FROM `registers` WHERE `user_id`='$user_id' ");
        if ($q->num_rows() > 0)
        {
            $row = $q->row(); 
            $current_amount=$q->row()->wallet;
            $request_amount=$_REQUEST['wallet_amount'];
            $new_amount=$current_amount+$request_amount;
            $this->db->query("UPDATE `registers` SET wallet='".$new_amount."' where(user_id='".$user_id."' )"); 
            $data= array("success" => 'success', "wallet_amount"=>"$new_amount");
        }
        echo json_encode($data);
    }
    public function deelOfDay()
    {
        $data = array();
        $_POST = $_REQUEST;
        $q = $this->db->get('deelofday');
        $data['responce']="true";
        $data['Deal_of_the_day'] = $q->result();
        echo json_encode($data);
    }
    public function top_selling_product()
    {
        $data = array();
        $limit = $_REQUEST['limit'];
        if ($limit == 0) {
            $Limit = '';
        }
        else{
            $Limit = 'LIMIT '.$limit;
        }
        // $_POST = $_REQUEST;
        $q = $this->db->query("SELECT b.title AS brand_title,b.image AS brand_image,p.*,dp.start_date,dp.start_time,dp.end_time,dp.deal_price,c.title,count(si.product_id) AS top,si.product_id FROM products p INNER JOIN sale_items si ON p.product_id=si.product_id INNER JOIN categories c ON c.id=p.category_id LEFT JOIN deal_product dp ON dp.product_id=si.product_id LEFT JOIN brand AS b ON p.brand_id = b.brand_id GROUP BY si.product_id ORDER BY top DESC $Limit ");
        $data['responce']="true";
        //print_r($q->result());exit();
        //$data[top_selling_product] = $q->result();
        foreach($q->result() as $product)
        {
            $present = date('m/d/Y h:i:s a', time());
            $date1 = $product->start_date." ".$product->start_time;
            $date2 = $product->start_date." ".$product->end_time;

            if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
            {

                if(empty($product->deal_price)){
                    $price= $product->price;
                }
                else{
                    $price= $product->deal_price;
                }

            }
            else{
                $price= $product->price;//expired
            } 

            $data['top_selling_product'][] = array(
                'product_id' => $product->product_id,
                'product_name'=> $product->product_name,
                'category_id' => $product->category_id,
                'product_description'=>$product->product_description,
                'price' =>$product->price,
                'discount' =>$product->discount,
                'sale_percentage' =>$product->sale_percentage,
                'mrp'=>$product->mrp,
                'product_image'=>$product->product_image,
                'in_stock' =>$product->in_stock,
                'unit_value'=>$product->unit_value,
                'unit'=>$product->unit,
                'status' => $product->in_stock,
                'title'=>$product->title,
                'brand_title'=>$product->brand_title,
                'brand_image'=>$product->brand_image
            );
        }
        echo json_encode($data);
    }
    public function get_all_top_selling_product()
    {
        $data = array();
        $_POST = $_REQUEST;
            $q = $this->db->query("SELECT b.title AS brand_title, b.image AS brand_image,dp.*,products.*, ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) AS stock ,categories.title FROM products 
            LEFT JOIN brand AS b ON b.brand_id = products.brand_id 
            INNER JOIN categories ON categories.id = products.category_id
            LEFT OUTER JOIN(SELECT SUM(qty) as c_qty,product_id FROM sale_items GROUP BY product_id) AS consuption ON consuption.product_id = products.product_id 
            LEFT OUTER JOIN(SELECT SUM(qty) as p_qty,product_id FROM purchase GROUP BY product_id) AS producation ON producation.product_id = products.product_id
            LEFT JOIN deal_product dp on dp.product_id=products.product_id WHERE 1 ".$filter." ".$limit);

            $data[responce]="true";
            foreach($q->result() as $product)
            {
                $present = date('m/d/Y h:i:s a', time());
                $date1 = $product->start_date." ".$product->start_time;
                $date2 = $product->end_date." ".$product->end_time;

                if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
                {

                    if(empty($product->deal_price)){
                        $price= $product->price;
                    }
                    else{
                        $price= $product->deal_price;
                    }

                }
                else{
                    $price= $product->price;//expired
                } 

                $data['top_selling_product'][] = array(
                    'product_id' => $product->product_id,
                    'product_name'=> $product->product_name,
                    'category_id' => $product->category_id,
                    'product_description'=>$product->product_description,
                    'price' =>$product->price,
                    'discount' =>$product->discount,
                    'sale_percentage' =>$product->sale_percentage,
                    'mrp'=>$product->mrp,
                    'product_image'=>$product->product_image,
                    'in_stock' =>$product->in_stock,
                    'unit_value'=>$product->unit_value,
                    'unit'=>$product->unit,
                    'status' => $product->in_stock,
                    'title'=>$product->title,
                    'brand_title'=>$product->brand_title,
                    'brand_image'=>$product->brand_image
                );
            }
        echo json_encode($data);
    }
    public function deal_product()
    {
        $data = array();
        $_POST = $_REQUEST;

        $q = $this->db->query("SELECT deal_product.*,products.*,categories.title, brand.title AS brand_title, brand.image AS brand_image from deal_product 
        INNER JOIN products on deal_product.product_name = products.product_name 
        LEFT JOIN brand on products.brand_id = brand.brand_id 
        INNER JOIN categories on categories.id=products.category_id limit 4");

        $data['responce']="true";
        foreach ($q->result() as $product) {

            $present = date('d/m/Y H:i ', time());
            $date1 = $product->start_date." ".$product->start_time;
            $date2 = $product->end_date." ".$product->end_time;

            if($date1 <= $present && $present <=$date2)
            { 
                $status = 1;//running 
            }
            else if($date1 > $present)
            { 
                $status = 2;//is going to 
            }
            else
            {   
                $status = 0;//expired
            }

            $data['Deal_of_the_day'][] = array(
                'product_id' => $product->product_id,
                'product_name'=> $product->product_name,
                'product_name_arb'=> $product->product_arb_name,
                'product_description_arb'=>$product->product_arb_description,
                'product_description'=>$product->product_description,
                'deal_price'=>$product->deal_price,
                'start_date'=>$product->start_date,
                'start_time'=>$product->start_time,
                'end_date'=>$product->end_date,
                'end_time'=>$product->end_time,
                'price' =>$product->price,
                'mrp' =>$product->mrp,
                'product_image'=>$product->product_image,
                'status' => $status,
                'in_stock' =>$product->in_stock,
                'unit_value'=>$product->unit_value,
                'unit'=>$product->unit,
                'increament'=>$product->increament,
                'rewards'=>$product->rewards,
                'title'=>$product->title,
                'brand_title'=>$product->brand_title,
                'brand_image'=>$product->brand_image
            );
        }
        echo json_encode($data);
    }
    public function get_all_deal_product()
    {
        $data = array();
        $_POST = $_REQUEST;

        if($_REQUEST['dealproduct'])
        {
            $q = $this->db->query("SELECT Brand.title AS brand_title,Brand.image AS brand_image,dp.*,products.*, ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title from deal_product dp
            LEFT JOIN  products ON products.product_name=dp.product_name 
            LEFT JOIN  brand ON products.brand_id=Brand.brand_id 
            INNER JOIN categories ON categories.id = products.category_id 
            LEFT OUTER JOIN (SELECT SUM(qty) AS c_qty,product_id FROM sale_items GROUP BY product_id) AS consuption ON consuption.product_id = products.product_id 
            LEFT OUTER JOIN(SELECT SUM(qty) AS p_qty,product_id FROM purchase GROUP BY product_id) AS producation ON producation.product_id = products.product_id
            WHERE 1 ".$filter." ".$limit);
        }
        $data['responce']="true";
        foreach ($q->result() as $product) {
            $present = date('d/m/Y H:i:s ', time());
            $date1 = $product->start_date." ".$product->start_time;
            $date2 = $product->end_date." ".$product->end_time;

            if($date1 <= $present&&$present <=$date2)
            {
                if(empty($product->deal_price))   ///Runing
                {
                    $price= $product->price;
                }
                else{
                    $price= $product->deal_price;
                }
            }
            else{
                $price= $product->price;//expired
            } 


            $data['Deal_of_the_day'][] = array(
                'product_id' => $product->product_id,
                'product_name'=> $product->product_name,
                'product_name_arb'=> $product->product_arb_name,
                'product_description_arb'=>$product->product_arb_description,
                'category_id' =>$product->category_id,
                'product_description'=>$product->product_description,
                'deal_price'=>$product->deal_price,
                'start_date'=>$product->start_date,
                'start_time'=>$product->start_time,
                'end_date'=>$product->end_date,
                'end_time'=>$product->end_time,
                'mrp'=>$product->mrp,
                'price' =>  $price,
                'product_image'=>$product->product_image,
                'status' =>$product->in_stock,
                'in_stock' =>$product->in_stock,
                'unit_value'=>$product->unit_value,
                'unit'=>$product->unit,
                'increament'=>$product->increament,
                'rewards'=>$product->rewards,
                'stock' =>$product->stock,
                'title'=>$product->title,
                'brand_title'=>$product->brand_title,
                'brand_image'=>$product->brand_image
            );
        }
        echo json_encode($data);
    }
    public function icon()
    {
        $parent = 0 ;
        if($_REQUEST['parent']){
            $parent = $_REQUEST['parent'];
        }
        $categories = $this->get_header_categories_short($parent,0,$this) ;
        $data["responce"] = true;
        $data["data"] = $categories;
        echo json_encode($data);
    }
    public function get_header_categories_short($parent,$level,$th)
    {
        $q = $th->db->query("Select a.*, ifnull(Deriv1.Count , 0) as Count, ifnull(Total1.PCount, 0) as PCount FROM `header_categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `header_categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` 
        LEFT OUTER JOIN (SELECT `category_id`,COUNT(*) AS PCount FROM `header_products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id` 
        WHERE a.`parent`=" . $parent);
        $return_array = array();
        foreach($q->result() as $row){
            if ($row->Count > 0) {
                $sub_cat =  $this->get_header_categories_short($row->id, $level + 1,$th);
                $row->sub_cat = $sub_cat;       
            }
            elseif ($row->Count==0) {

            }
            $return_array[] = $row;
        }
        return $return_array;
    }
    function get_header_products()
    {
        $this->load->model("product_model");
        $cat_id = "";
        if($_REQUEST['cat_id']){
            $cat_id = $_REQUEST['cat_id'];
        }
        $search= $_REQUEST['search'];
        $data["responce"] = true;  
        $datas = $this->product_model->get_header_products(false,$cat_id,$search,$_REQUEST['page']);
        foreach ($datas as $product) {
            $data['data'][] =  array(
                'product_id' => $product->product_id,
                'product_name'=> $product->product_name,
                'product_name_arb'=> $product->product_arb_name,
                'product_description_arb'=>$product->product_arb_description,
                'category_id'=> $product->category_id,
                'product_description'=>$product->product_description,
                'deal_price'=>"",
                'start_date'=>"",
                'start_time'=>"",
                'end_date'=>"",
                'end_time'=>"",
                'price' =>$product->price,
                'product_image'=>$product->product_image,
                'status' => '0',
                'in_stock' =>$product->in_stock,
                'unit_value'=>$product->unit_value,
                'unit'=>$product->unit,
                'increament'=>$product->increament,
                'rewards'=>$product->rewards,
                'stock'=>$product->stock,
                'title'=>$product->title
            );
        }
        echo json_encode($data);
    }
    public function coupons()
    {
        $q = $this->db->query("SELECT * FROM `coupons`");
        $data["responce"] = true;
        $data['data'] = $q->result();
        echo json_encode($data);
    }
    public function get_coupons()
    {
        $code = $_REQUEST['coupon_code'];
        $q = $this->db->query("SELECT * FROM `coupons` where `coupon_code` = '$code' ");
        if($q->result()>0)
        {
            foreach($q->result() as $row)
            {
                if($row->valid_from<= date('Y-m-d') && $row->valid_to>= date('Y-m-d'))
                {
                    if($row->cart_value<=$_REQUEST['payable_amount'])
                    {
                        $payable_amount=$_REQUEST['payable_amount'];
                        $coupon_amount=$row->discount_value;
                        $new_amount=$payable_amount-$coupon_amount;
                        $data["responce"] = true;
                        $data["msg"] = "Coupon code apply successfully ";
                        $data["Total_amount"] = $new_amount;
                        $data["coupon_value"] = $coupon_amount;
                    }
                    else
                    {
                        $data["responce"] = false;
                        $data["msg"] = "Your Cart Amount is not Enough For This Coupon ";
                        $data["Total_amount"] = $_REQUEST['payable_amount'];
                        $data["coupon_value"] = 0;
                    }
                }
                else{
                    $data["responce"] = false;
                    $data["msg"] = "This coupon is Expired";
                    $data["Total_amount"] = $_REQUEST['payable_amount'];
                    $data["coupon_value"] = 0;
                }
            }
        }
        else{
            $data["responce"] = false;
            $data["msg"] = "Invalid Coupon";
            $data["Total_amount"] = $_REQUEST['payable_amount'];
            $data["coupon_value"] = 0;
        }
        echo json_encode($data);
    }
    public function get_sub_cat()
    {
        $parent = 0 ;
        $id = $_REQUEST['parent'];
        if($id > 0){
            $q = $this->db->query("SELECT * FROM `categories` WHERE `parent`=$id AND `status` = 1 ");
                $data["responce"] = true;
                 $data["subcat"] = $q->result();
                 echo json_encode($data);
        }
        else{
            $data["responce"] = false;
            $data["subcat"]="";
            echo json_encode($data);
        }
    }
    public function delivery_boy()
    {
        $q = $this->db->query("SELECT `id`,`user_name` FROM `delivery_boy` WHERE `user_status`=1");
        $data['delivery_boy'] = $q->result();
        echo json_encode($data);
    }
    public function delivery_boy_login()
    {
        $data = array();    
        if (!$_REQUEST['user_password']) 
        {
            $data["responce"] = false;  
            $data["error"] =  strip_tags($this->form_validation->error_string());
        }
        else
        {
            $q = $this->db->query("SELECT * FROM `delivery_boy` WHERE `user_password` = '".$_REQUEST['user_password']."'");
            if ($q->result() > 0)
            {
                $row = $q->result(); 
                $access=$row->user_status;
                if($access=='0')
                {
                    $data["responce"] = false;  
                    $data["data"] = 'Your account currently inactive.Please Contact Admin';
                }
                else
                {
                    $data["responce"] = true;
                    $q = $this->db->query("SELECT `id`,`user_name` FROM delivery_boy WHERE `user_password` = '".$_REQUEST['user_password']."'");
                    $product=$q->result();
                    $data['product']= $product;
                }
            }
            else
            {
                $data["responce"] = false;
                $data["data"] = 'Invalide Username or Passwords';
            }
        }
       echo json_encode($data);
    }
    public function add_purchase(){
        if(_is_user_login($this)){
            if(isset($_POST))
            {
                if ($_REQUEST['product_id'] == '' && $_REQUEST['qty'] == '' && $_REQUEST['unit'] == '')
                {
                    $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                    <i class="fa fa-warning"></i>
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <strong>Warning!</strong> Please provide required data
                    </div>');
                }
                else
                {
                    $this->load->model("common_model");
                    $array = array(
                        "product_id"=>$_REQUEST['product_id'],
                        "qty"=>$_REQUEST['qty'],
                        "price"=>$_REQUEST['price'],
                        "unit"=>$_REQUEST['unit'],
                        "store_id_login"=>$_REQUEST['store_id_login']
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
                $this->load->view("admin/product/purchase",$data);  

            }
        }
    }
    public function stock() 
    {
        $this->load->model("product_model");
        $cat_id = "";
        if($_REQUEST['cat_id']){
            $cat_id = $_REQUEST['cat_id'];
        }
        $search= $_REQUEST['search'];
        $datas = $this->product_model->get_products(false,$cat_id,$search,$_REQUEST['page']);
        foreach ($datas as  $product) {
            $present = date('m/d/Y h:i:s a', time());
            $date1 = $product->start_date." ".$product->start_time;
            $date2 = $product->end_date." ".$product->end_time;

            if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
            {
                if(empty($product->deal_price))   ///Runing
                {
                    $price= $product->price;
                }
                else{
                    $price= $product->deal_price;
                }
            }
            else{
                $price= $product->price;//expired
            }
            $data['products'][] = array(
                'product_id' => $product->product_id,
                'product_name'=> $product->product_name
            );
        }
        echo json_encode($data);
    }
    public function stock_insert()
    {
        if (!$_REQUEST['product_id'])
        {
            $data["data"] = 'Please select the product';
        }
        else
        {
            $this->load->model("common_model");
            $array = array(
                "product_id"=>$_REQUEST['product_id'],
                "qty"=>$_REQUEST['qty'],
                "price"=>$_REQUEST['price'],
                "unit"=>$_REQUEST['unit'],
                "store_id_login"=>$_REQUEST['store_id_login']
            );
            $this->common_model->data_insert("purchase",$array);
            $data['product'][] = array("msg"=>'Your Stock is Updated');
        }
        echo json_encode($data);
        $this->load->model("product_model");
        $data["purchases"]  = $this->product_model->get_purchase_list();
        $data["products"]  = $this->product_model->get_products();
    }
    public function assign()
    {
        $order=$_REQUEST['order_id'];
        $order=$_REQUEST['d_boy'];
        $this->load->model("common_model");
        $this->common_model->data_update("sale",$update_array,array("sale_id"=>$order));
    }
    public function delivery_boy_order()
    {
        $delivery_boy_id = $_REQUEST['d_id'];
        $date = date("d-m-Y", strtotime('-3 day'));
        $this->load->model("product_model");
        $data = $this->product_model->delivery_boy_order($delivery_boy_id);
        $this->db->query("DELETE FROM `signature` WHERE `date` < '$date'");
        echo json_encode($data);
    }
    public function assign_order()
    {
        $order_id = $_REQUEST['order_id'];
        $boy_name = $_REQUEST['boy_name'];
        $update_array = array("assign_to"=>$boy_name);
        $this->load->model("common_model");
        $hit=$this->db->query("UPDATE sale SET `assign_to`='".$boy_name."' where `sale_id`='".$order_id."'" );
        if($hit){
            $data['assign'][]=array("msg"=>"Assign Successfully");
        }
        else{
            $data['assign'][]=array("msg"=>"Assign Not Successfully");
        }
        echo json_encode($data);
    }
    public function mark_delivered()
    {
        $order_id=$_REQUEST['id'];

        $q2 = $this->db->query("SELECT * FROM `sale` WHERE `sale_id` = '".$order_id."' AND `status` ='4'");
        $user2 = $q2->result();
        if(count($user2)>0)
        {
            $data=array("success"=>"0", "msg"=>"This Order Already Complete");
        }
        else
        {
            $img = $_REQUEST['signature'];
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $image = base64_decode($img);

            if ($image) {

                header('Content-Type: bitmap; charset=utf-8');
                $path="/uploads/signature/" . uniqid() . '.png';
                $filelocation = ".".$path;
                file_put_contents($filelocation, $image);
                $order_id=$_REQUEST['id'];
                $q =$this->db->query("INSERT INTO signature (order_id, signature) VALUES ('$order_id', '$path')");
                if($q){

                    $data=array("success"=>"1", "msg"=>"Upload Successfull");

                    $this->db->query("UPDATE `sale` SET `status`=4 WHERE `sale_id`='".$order_id."'");
                    $this->db->query("INSERT INTO delivered_order (sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method)
                    SELECT sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method FROM sale where sale_id = '".$order_id."'");

                    $q2 = $this->db->query("Select user_id from sale where sale_id = '".$order_id."'");
                    $user2 = $q2->row();

                    $q = $this->db->query("Select * from registers where user_id = '".$user2->user_id."'");
                    $user = $q->row();
                    $mobileNumber->$user->user_phone;

                    $message="Order Complete Thanks for being with Us";
                    $send_msg=$this->sms($mobileNumber,$message);
                }
                else{
                    $data=array("success"=>"0", "msg"=>"Upload Not Successfull");
                }
            }
            else
            {
                $data=array("success"=>"0", "msg"=>"Image Type Not Right");
            }
        }
        echo json_encode($data);
    }
    public function mark_delivered2()
    {
        if ((($_FILES["signature"]["type"] == "image/gif")
        || ($_FILES["signature"]["type"] == "image/jpeg")
        || ($_FILES["signature"]["type"] == "image/jpg")
        || ($_FILES["signature"]["type"] == "image/jpeg")
        || ($_FILES["signature"]["type"] == "image/png")
        || ($_FILES["signature"]["type"] == "image/png"))) {
            //Move the file to the uploads folder
            move_uploaded_file($_FILES["signature"]["tmp_name"], "./uploads/signature/" . $_FILES["signature"]["name"]);
            //Get the File Location
            $filelocation = './uploads/signature/'.$_FILES["signature"]["name"];
            //Get the File Size
            $order_id=$_REQUEST['id'];

            $q =$this->db->query("INSERT INTO signature (order_id, signature) VALUES ('$order_id', '$filelocation')");
            //$this->db->insert("signature",$add);
            if($q){

                $data=array("success"=>"1", "msg"=>"Upload Successfull");
                $this->db->query("UPDATE `sale` SET `status`=4 WHERE `sale_id`='".$order_id."'");
                $this->db->query("INSERT INTO delivered_order (sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method)
                SELECT sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method FROM sale where sale_id = '".$order_id."'");


                $q2 = $this->db->query("Select total_rewards, user_id from sale where sale_id = '".$order_id."'");
                $user2 = $q2->row();

                $q = $this->db->query("Select * from registers where user_id = '".$user2->user_id."'");
                $user = $q->row();

                $rewrd_by_profile=$user->rewards;
                $rewrd_by_order=$user2->total_rewards;

                $new_rewards=$rewrd_by_profile+$rewrd_by_order;
                $this->db->query("update registers set rewards = '".$new_rewards."' where user_id = '".$user2->user_id."'");

            }
            else{
                $data=array("success"=>"0", "msg"=>"Upload Not Successfull");
            }
        }
        else
        {
            $data=array("success"=>"0", "msg"=>"Image Type Not Right");
        }
        echo json_encode($data);
    }
    public function ads()
    {
        $qry=$this->db->query("SELECT * FROM `ads`");
        $data=$qry->result();
        echo json_encode($data); 
    }
    public function paypal()
    {
        $qry=$this->db->query("SELECT * FROM `paypal`");
        $data['paypal']=$qry->result();
        echo json_encode($data); 
    } 
    public function razorpay()
    {
        $qry=$this->db->query("SELECT * FROM `razorpay`");
        $data=$qry->result();
        echo json_encode($data); 
    }
    public function get_categories12()
    {
        $parent = 0 ;
        if($_REQUEST['parent']){
            $parent    = $_REQUEST['parent'];
        }
        $categories = $this->get_categories_short2($parent,0,$this) ;
        $data["responce"] = true;
        $data["data"] = $categories;
        echo json_encode($data);
    }
    public function get_categories_short2($parent,$level,$th)
    {
        $q = $th->db->query("Select a.*, ifnull(Deriv1.Count , 0) as Count, ifnull(Total1.PCount, 0) as PCount FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` 
        LEFT OUTER JOIN (SELECT `category_id`,COUNT(*) AS PCount FROM `products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id` 
        WHERE a.`parent`=" . $parent." LIMIT 12");
        $return_array = array();
        foreach($q->result() as $row){
            if ($row->Count > 0) {
                $sub_cat =  $this->get_categories_short2($row->id, $level + 1,$th);
                $row->sub_cat = $sub_cat;       
            } 
            elseif ($row->Count==0) {

            }
            $return_array[] = $row;
        }
        return $return_array;
    }
    public function cart()
    {
        $user_id=$_REQUEST['user_id'];
        $pro_id=$_REQUEST['product_id'];
        $qty=$_REQUEST['qty'];
        if($user_id){
            $cart_create =$this->db->query("INSERT INTO cart (qty, user_id, product_id) VALUES ('$qty', '$user_id', '$pro_id')");
            if($cart_create){
                $data['responce'] = true;
                $data['msg'] = "Add Cart Successfull";
            }
            else{
                $data['responce'] = false;
                $data['msg'] = "Add Cart Not Successfull";
            }
        }
        else{
            $data['responce'] = false;
            $data['msg'] = "Add Cart Not Successfull";
        }
        echo json_encode($data);
    }
    public function view_cart()
    {
        $user_id = $_REQUEST['user_id'];
        if($user_id)
        {
            $cart_productr = $this->db->query("SELECT * FROM `cart` WHERE `user_id` = '".$_REQUEST['user_id']."'");
            $user = $cart_productr->result();
            $cart_quantity= $cart_productr->num_rows();
            if ($cart_quantity > 0)
            {
                $i=1;
                foreach ($user as $user) 
                {
                    $id= $user->product_id;
                    $qty=$user->qty;
                    $cart_id=$user->cart_id;
                    $q = $this->db->query("SELECT dp.*,products.*, ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title from products 
                    inner join categories on categories.id = products.category_id
                    left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
                    left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
                    left join deal_product dp on dp.product_id=products.product_id where products.product_id =  '".$id."'");
                    $products =$q->result();
                    foreach ($products as  $product) 
                    {
                        $present = date('m/d/Y h:i:s a', time());
                        $date1 = $product->start_date." ".$product->start_time;
                        $date2 = $product->end_date." ".$product->end_time;

                        if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
                        {
                            if(empty($product->deal_price))   ///Runing
                            {
                                $price= $product->price;
                            }
                            else{
                                $price= $product->deal_price;
                            }
                        }
                        else{
                            $price= $product->price;//expired
                        } 
                        $data['responce'] = true;
                        $data['total_item']=$i;
                        $sum['total']=$price*$qty;
                        //array_push($data['total_amount'], $sum);
                        //$data['total_amount']=$sum;
                        $data['data'][] = array(
                            'product_id' => $product->product_id,
                            'product_name'=> $product->product_name,
                            'category_id'=> $product->category_id,
                            'product_description'=>$product->product_description,
                            'deal_price'=>'',
                            'start_date'=>"",
                            'start_time'=>"",
                            'end_date'=>"",
                            'end_time'=>"",
                            'price' =>$price,
                            'mrp' =>$product->mrp,
                            'product_image'=>$product->product_image,
                            //'tax'=>$product->tax,
                            'status' => '0',
                            'in_stock' =>$product->in_stock,
                            'unit_value'=>$product->unit_value,
                            'unit'=>$product->unit,
                            'increament'=>$product->increament,
                            'rewards'=>$product->rewards,
                            'stock'=>$product->stock,
                            'title'=>$product->title,
                            'qty'=>$qty,
                            'cart_id'=>$cart_id,
                            'total_product_amount'=>$qty*$price
                        );
                    } $i++;
                }
            }
            else if($cart_quantity < 1)
            {
                $data['total_item']=0;
                $data['responce'] = false;
                $data['msg'] = "Your Cart is Empty ";
            }
        }
        else{
            $data['responce'] = false;
            $data['msg'] = "Cart Not Available ";
        }
        echo json_encode($data);
    }
    public function delete_from_cart()
    {
        $user_id = $_REQUEST['user_id'];
        $cart_id = $_REQUEST['cart_id'];
        $done=$this->db->query("DELETE FROM `cart` WHERE cart_id = '".$cart_id."'");
        if($done)
        {
            $data['responce'] = true;
            $data['msg'] = "Product Delete From Cart Successfully";
        }
        echo json_encode($data);
    }
    public function payment_success()
    {
        $order_id = $_REQUEST['order_id'];
        $amount = $_REQUEST['amount'];
        $this->db->query("UPDATE `sale` SET `is_paid`='".$amount."' WHERE `sale_id`='".$order_id."'");
    }
    public function update_cart()
    {
        $cart_id = $_REQUEST['cart_id'];
        $qty=$_REQUEST['qty'];
        if ($_REQUEST['cart_id'] == '' && $_RE['qty'] == '') 
        {
            $data["responce"] = false;  
            $data["error"] = 'Warning! : please provide all required data';
        }
        else
        {
            $cart_update =$this->db->query("UPDATE `cart` SET `qty`='".$qty."' WHERE `cart_id`='".$cart_id."'");
            if($cart_update){
                $data['responce'] = true;
                $data['msg'] = "Add update Successfull";
            }
            else{
                $data['responce'] = false;
                $data['msg'] = "Add Cart Not Successfull";
            }
        }
        echo json_encode($data);
    }
    public function get_categories22()
    {
        $parent = 0 ;
        if($_REQUEST['parent']){
            $parent    = $_REQUEST['parent'];
        }
        $categories = $this->get_categories_short22($parent,0,$this) ;
        $data["responce"] = true;
        $data["data"] = $categories;
        echo json_encode($data);
    }
    public function get_categories_short22($parent,$level,$th)
    {
        $q = $th->db->query("Select a.*, ifnull(Deriv1.Count , 0) as Count, ifnull(Total1.PCount, 0) as PCount FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` 
        LEFT OUTER JOIN (SELECT `category_id`,COUNT(*) AS PCount FROM `products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id` 
        WHERE a.`parent`=" . $parent." LIMIT 9");
        $return_array = array();
        foreach($q->result() as $row){
            if ($row->Count > 0) {
                $sub_cat =  $this->get_categories_short($row->id, $level + 1,$th);
                $row->sub_cat = $sub_cat;       
            }
            elseif ($row->Count==0) {

            }
            $return_array[] = $row;
        }
        return $return_array;
    }
    public function get_categoriesz()
    {
        $parent = 0 ;
        /*if(isset($_REQUEST['parent'])){
            $parent = $_REQUEST['parent']);
        }*/
        $categories = $this->get_categories_shortz($_REQUEST['parent'],0,$this) ;
        $data["responce"] = true;
        $data["data"] = $categories;
        echo json_encode($data);
    }
    public function get_categories_shortz($parent,$level,$th)
    {
        $q = $th->db->query("SELECT a.*, ifnull(Deriv1.Count , 0) as Count, ifnull(Total1.PCount, 0) as PCount FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` 
        LEFT OUTER JOIN (SELECT `category_id`,COUNT(*) AS PCount FROM `products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id` 
        WHERE a.`parent`=" . $parent. "");
        $return_array = array();
        foreach($q->result() as $row){
            if ($row->Count > 0) {
                $sub_cat =  $this->get_categories_shortz($row->id, $level + 1,$th);
                $row->sub_cat = $sub_cat;       
            }
            elseif ($row->Count==0) {

            }
            $return_array[] = $row;
        }
        return $return_array;
    }
    public function ios_send_order()
    {
        $total_rewards = "";
        $total_price = "";
        $total_kg = "";
        if ($_REQUEST['user_id'] == '' && $_REQUEST['date'] == '' && $_REQUEST['time'] == '' && $_REQUEST['location'] == '') 
        {
            $data["responce"] = false;  
            $data["error"] = 'Warning! : please provide required data';

        }
        else
        {
            $ld = $this->db->query("select user_location.*, socity.* from user_location
            inner join socity on socity.socity_id = user_location.socity_id
            where user_location.location_id = '".$this->input->post("location")."' limit 1");
            $location = $ld->row(); 

            $store_id= $this->input->post("store_id");
            $payment_method= $this->input->post("payment_method");
            $date = date("Y-m-d", strtotime($this->input->post("date")));
            //$timeslot = explode("-",$this->input->post("timeslot"));

            $times = explode('-',$this->input->post("time"));
            $fromtime = date("h:i a",strtotime(trim($times[0]))) ;
            $totime = date("h:i a",strtotime(trim($times[1])));


            $user_id = $this->input->post("user_id");
            $insert_array = array("user_id"=>$user_id,
                "on_date"=>$date,
                "delivery_time_from"=>$fromtime,
                "delivery_time_to"=>$totime,
                "delivery_address"=>$location->house_no."\n, ".$location->house_no,
                "socity_id" => $location->socity_id, 
                "delivery_charge" => $location->delivery_charge,
                "location_id" => $location->location_id, 
                "payment_method" => $payment_method,
                "new_store_id" => $store_id
            );
            $this->load->model("common_model");
            $id = $this->common_model->data_insert("sale",$insert_array);

            $cart= $this->db->query("SELECT * FROM `cart` WHERE `user_id` = '".$user_id."'");
            $cart_value= $cart->result();
            foreach ($cart_value as $cart_value) {

                $q = $this->db->query("SELECT dp.*,products.*, ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title from products 
                inner join categories on categories.id = products.category_id
                left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
                left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
                left join deal_product dp on dp.product_id=products.product_id where products.product_id =  '".$cart_value->product_id."'");
                $products =$q->result();
                foreach ($products as  $product) 
                {
                    $present = date('m/d/Y h:i:s a', time());
                    $date1 = $product->start_date." ".$product->start_time;
                    $date2 = $product->end_date." ".$product->end_time;

                    if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
                    {
                        if(empty($product->deal_price))   ///Runing
                        {
                            $price= $product->price;
                        }
                        else{
                            $price= $product->deal_price;
                        }

                    }
                    else{
                        $price= $product->price;//expired
                    }


                    $qty_in_kg = $cart_value->qty; 
                    if($product->unit=="gram"){
                        $qty_in_kg =  ($cart_value->qty * $product->unit_value) / 1000;     
                    }
                    $total_rewards = $total_rewards + ($cart_value->qty * $product->rewards);
                    $total_price = $total_price + ($cart_value->qty * $product->price);
                    $total_kg = $total_kg + $qty_in_kg;
                    $total_items[$product->product_id] = $product->product_id;


                    $array = array("product_id"=>$product->product_id,
                        "qty"=>$cart_value->qty,
                        "unit"=>$product->unit,
                        "unit_value"=>$product->unit_value,
                        "sale_id"=>$id,
                        "price"=>$product->price,
                        "qty_in_kg"=>$qty_in_kg,
                        "rewards" =>$product->rewards
                    );
                    $this->common_model->data_insert("sale_items",$array);
                }

            }



            // $data_post = $this->input->post("data");
            // $data_array = json_decode($data_post);
            // $total_rewards = 0;
            // $total_price = 0;
            // $total_kg = 0;
            // $total_items = array();
            // foreach($data_array as $dt){
            //     $qty_in_kg = $dt->qty; 
            //     if($dt->unit=="gram"){
            //         $qty_in_kg =  ($dt->qty * $dt->unit_value) / 1000;     
            //     }
            //     $total_rewards = $total_rewards + ($dt->qty * $dt->rewards);
            //     $total_price = $total_price + ($dt->qty * $dt->price);
            //     $total_kg = $total_kg + $qty_in_kg;
            //     $total_items[$dt->product_id] = $dt->product_id;    

            //     $array = array("product_id"=>$dt->product_id,
            //     "qty"=>$dt->qty,
            //     "unit"=>$dt->unit,
            //     "unit_value"=>$dt->unit_value,
            //     "sale_id"=>$id,
            //     "price"=>$dt->price,
            //     "qty_in_kg"=>$qty_in_kg,
            //     "rewards" =>$dt->rewards
            //     );
            //     $this->common_model->data_insert("sale_items",$array);

            // }

            $total_price = $total_price + $location->delivery_charge;
            $this->db->query("Update sale set total_amount = '".$total_price."', total_kg = '".$total_kg."', total_items = '".count($total_items)."', total_rewards = '".$total_rewards."' where sale_id = '".$id."'");

            $data["responce"] = true;  
            $data["data"] = addslashes( "<p>Your order No #".$id." is send success fully \n Our delivery person will delivered order \n 
            between ".$fromtime." to ".$totime." on ".$date." \n
            Please keep <strong>".$total_price."</strong> on delivery
            Thanks for being with Us.</p>" );
        }
        echo json_encode($data);
    }
    function add_coupons()
    {

        $this->load->helper('form');
        $this->load->model('product_model');
        $this->load->library('session');
       
        $this->load->library('form_validation');
        $this->form_validation->set_rules('coupon_title', 'Coupon name', 'trim|required|max_length[6]|alpha_numeric');
        $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required|max_length[6]|alpha_numeric');
        $this->form_validation->set_rules('from', 'From', 'required'); //|callback_date_valid
        $this->form_validation->set_rules('to', 'To', 'required'); //|callback_date_valid
        
        $this->form_validation->set_rules('value', 'Value', 'required|numeric');
        $this->form_validation->set_rules('cart_value', 'Cart Value', 'required|numeric');
        // $this->form_validation->set_rules('restriction', 'Uses restriction', 'required|numeric');
        // $this->form_validation->set_rules('product_id', 'Product ID', 'required|numeric');

        $data= array();
        if($this->form_validation->run() == FALSE)
        {
            $data["responce"] = false;  
            $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
             
        }else{
            $data = array(
            'coupon_name'=>$this->input->post('coupon_title'),
            'coupon_code'=> $this->input->post('coupon_code'),
            'valid_from'=> $this->input->post('from'),
            'valid_to'=> $this->input->post('to'),
            'validity_type'=> "",
            // 'product_name'=> "",
            'product_id'=> $this->input->post('product_id'),
            'discount_type'=> "",
            'discount_value'=> $this->input->post('value'),
            'cart_value'=> $this->input->post('cart_value'),
            'uses_restriction'=> $this->input->post('restriction')
             );
             //print_r($data);
             if($this->product_model->coupon($data))
             {
                 $data["responce"] = true;  
                 $data["msg"] = 'Coupon Create Successfull';
             }
        }
       //$data['coupons'] = $this->product_model->coupon_list();
        echo json_encode($data);   
    }
    public function assign_client_count()
    {
        $d = date('d/m/y');
        $q =$this->db->query("SELECT * FROM assign_client WHERE sale_user_id = '".$_REQUEST['sales_id']."'");
        $data['count']=$q->num_rows();
        echo json_encode($data);
    }
    public function sales_report()
    {
        $d = date('d/m/y');
        $create_by=$_REQUEST['sales_id'];
        $sql = "SELECT * FROM sale 
        inner join socity on socity.socity_id = sale.socity_id 
        inner join registers on registers.user_id = sale.user_id
        WHERE sale.created_by='".$create_by."' AND sale.created_on ='".$d."' ORDER BY sale.sale_id DESC ";
        $q = $this->db->query($sql);
        $data["responce"] = true;  
        $data['run']=$q->result();
        echo json_encode($data);
    }
    public function user_create_by()
    {
        $create_by = $_REQUEST['sales_id'];
        $q =$this->db->query("SELECT * FROM `registers` WHERE `created_by` = '".$create_by."'");
        $data['create_by']=$q->num_rows();
        echo json_encode($data);
    }
    
    public function sale_by_salesman()
    {
        $create_by = $_REQUEST['sales_id'];
        $q =$this->db->query("SELECT * FROM `sale` WHERE `created_by` = '".$create_by."'");
        $data['create_by']=$q->num_rows();
        echo json_encode($data);
    }
    
    public function created_by_salesman()
    {
        $create_by = $_REQUEST['sales_id'];
        $q =$this->db->query("SELECT * FROM `registers` WHERE `created_by` = '".$create_by."'");
        $data['create_by']=$q->result();
        echo json_encode($data);
    }
    public function today_user_create_by()
    {
        $create_by = $_REQUEST['sales_id'];
        $today = date('d/m/y');
        $q =$this->db->query("SELECT * FROM registers WHERE created_by = '".$create_by."' AND created_on = '".$today."' ");
        $data['create_by']=$q->num_rows();
        echo json_encode($data);
    }
    public function today_sale_by_salesman()
    {
        $create_by = $_REQUEST['sales_id'];
        $today = date('d/m/y');
        $q =$this->db->query("SELECT * FROM sale WHERE created_by = '".$create_by."' AND created_on = '".$today."'");
        $data['create_by']=$q->num_rows();
        echo json_encode($data);
    }
    public function today_created_by_salesman()
    {
        $create_by = $_REQUEST['sales_id'];
        $today = date('d/m/y');
        $q =$this->db->query("SELECT * FROM registers WHERE created_by = '".$create_by."' AND created_on = '".$today."'");
        $data['create_by']=$q->result();
        echo json_encode($data);
    }
    public function today_assign_client_count()
    {
        $date = date('d/m/y');
        $q =$this->db->query("SELECT * FROM assign_client WHERE sale_user_id = '".$_REQUEST['sales_id']."' AND on_date = '".$date."'");
        $data['count']=$q->num_rows();
        echo json_encode($data);
    }
    public function user_profile_detail()
    {
        $q =$this->db->query("SELECT * FROM registers WHERE user_id = '".$_REQUEST['detail_id']."'");
        $data['detail']=$q->result();
        //$q =$this->db->query("Select registers.*, user_location.* from registers left join user_location on user_location.user_id=registers.user_id where registers.user_id = '".$this->input->post('user_id')."'");
        $que =$this->db->query("SELECT user_location.* , socity.socity_name FROM user_location LEFT JOIN socity ON socity.socity_id=user_location.socity_id WHERE user_location.user_id = '".$_REQUEST['detail_id']."'");
        foreach($que->result() as $addresses)
        {
         $get[] = $addresses->receiver_name." , ".$addresses->house_no." ".$addresses->socity_name." ".$addresses->pincode."";
        }
        $data['address']=$get;
        echo json_encode($data);
    }
    public function purchase_history()
    {
        $q =$this->db->query("SELECT * FROM sale WHERE user_id = '".$_REQUEST['user_id']."'");
        $data['purchase_history'] = $q->result();
        echo json_encode($data);
    }
    public function order_by_salesman()
    {
        $create_by = $_REQUEST['sales_id'];
        $q =$this->db->query("SELECT * FROM sale WHERE created_by = '".$create_by."'");
        $data['order']=$q->result();
        echo json_encode($data);
    }
    public function user_detail()
    {
        $this->load->model("product_model");
        $qry=$this->db->query("SELECT * FROM `registers` where user_id = '".$_REQUEST['user_id']."'");
        $data["user"] = $qry->result();
        echo json_encode($data);       
    }
    public function wallet_at_checkout()
    {
        $id = $_REQUEST['user_id'];
        $q=$this->db->query("SELECT * FROM `registers` where `user_id` = '$id'");
        $row = $q->row();
        $profile_amount= $row->wallet;
        $wallet_amount=$_REQUEST['wallet_amount'];
        $new_wallet_amount=$profile_amount-$wallet_amount;
        $this->db->query("UPDATE `registers` set `wallet` = '$new_wallet_amount' WHERE `user_id` = '$id'");   
    }    
    public function contact_numbers(){
        $q =$this->db->query("SELECT * FROM `tbl_numbers` WHERE `id` = 1");
        $data['numbers']=$q->result();
        echo json_encode($data);
    }
    public function get_restaurant(){
        //$q =$this->db->query("SELECT * FROM `registers` WHERE `type` = 'restaurant'");
        //https://stackoverflow.com/questions/19101550/mysql-join-two-tables-with-comma-separated-values

        $q =$this->db->query("
            SELECT r.*, GROUP_CONCAT(c.name ORDER BY c.user_id) Categories 
            FROM `registers` AS r 
            LEFT JOIN `category` AS c ON find_in_set(c.user_id, r.user_id) 
            WHERE r.type = 'restaurant' 
            GROUP BY r.user_id 
        ");

        $data['all_restaurants'] = $q->result();
        if ($data['all_restaurants']) {
            $data['all_restaurants'] = $data['all_restaurants'];
        }
        else{
            $data['all_restaurants'] = false;
        }
        $q2 =$this->db->query("
            SELECT r.*, GROUP_CONCAT(c.name ORDER BY c.user_id) Categories 
            FROM `registers` AS r 
            LEFT JOIN `category` AS c ON find_in_set(c.user_id, r.user_id) 
            WHERE r.type = 'restaurant' AND r.featured = 'yes'
            GROUP BY r.user_id 
        ");
        $data['featured_restaurants'] = $q2->result();
        if ($data['featured_restaurants']) {
            $data['featured_restaurants'] = $data['featured_restaurants'];
        }
        else{
            $data['featured_restaurants'] = false;
        }
        echo json_encode($data);
    }
    public function get_restaurant_categories($user_id){
        $q =$this->db->query("SELECT `category_id`,`user_id`,`name` FROM `category` WHERE `user_id` = '$user_id' AND `status` = 'active' AND `addon` = '0' ORDER BY `name` ASC;");
        $data['categories'] = $q->result();
        if ($data['categories']) {
            $data['categories'] = $data['categories'];
        }
        else{
            $data['categories'] = false;
        }
        echo json_encode($data);
    }
    public function get_restaurant_products($cat_id){
        $q =$this->db->query("SELECT p.product_id,p.category_id,p.user_id,p.name,p.price,p.detail,p.variations, c.name AS CategoryName FROM `product` AS p INNER JOIN `category` AS c ON p.category_id = c.category_id WHERE p.category_id = '$cat_id' AND p.parent = 0 AND p.status = 'active' ORDER BY p.name ASC;");
        $data['products'] = $q->result();
        if ($data['products']) {
            $data['products'] = $data['products'];
        }
        else{
            $data['products'] = false;
        }
        echo json_encode($data);
    }
    public function get_product_variations($pro_id){
        /*$q = $this->db->query("SELECT `product_id`,`category_id`,`user_id`,`name`,`price`,`detail`,`variations`,`parent` FROM `product` WHERE `parent` = '$pro_id' AND `status` = 'active' ORDER BY `name` ASC;");
        $data['products'] = $q->result();
        if ($data['products']) {
            $data['products'] = $data['products'];
        }
        else{
            $data['products'] = false;
        }
        echo json_encode($data);*/

        $cats = $this->db->query("SELECT * FROM `category` WHERE `addon` = '$pro_id' ORDER BY `category_id` ASC;");
        $cats = $cats->result();
        $final = array();
        if ($cats) {
            foreach ($cats as $key => $q) {
                $final[$key]['variation_heading'] = $q->name;
                $final[$key]['required'] = $q->required;
                $catID = $q->category_id;
                $products = $this->db->query("SELECT * FROM `product` WHERE `category_id` = '$catID' ORDER BY `product_id` ASC;");
                $final[$key]['products'] = $products->result();
            }
            $data['data'] = $final;
        }
        else{
            $data = false;
        }
        echo json_encode($data);
    }
    public function save_lat_long()
    {
        $update['lat'] = $_REQUEST['lat'];
        $update['long'] = $_REQUEST['long'];
        $update['city'] = $_REQUEST['city'];
        $update['address_type'] = $_REQUEST['address_type'];
        $update['address_type'] = $_REQUEST['address_type'];
        $update['rider_note'] = $_REQUEST['rider_note'];
        $this->db->where('user_id',$_REQUEST['user_id']);
        $this->db->update('registers',$update);
        echo json_encode(true);
    }
    public function get_restaurant_orders($id,$status)
    {
        $ids = $this->get_results("SELECT DISTINCT(`sale_id`) AS 'id' FROM `sale_items` WHERE `user_id` = '$id' ORDER BY `sale_id` DESC");
        $final = false;
        if ($ids) {
            foreach ($ids as $key => $id) {
                $SaleID = $id['id'];
                if ($status == 'all') {
                    $order = $this->get_row("SELECT * FROM `sale` WHERE `sale_id` = '$SaleID'");
                    if ($order) {
                        $final[$key]['order'] = $order;
                    }
                }
                else if ($status == 'confirm') {
                    $order = $this->get_row("SELECT * FROM `sale` WHERE `sale_id` = '$SaleID' AND `status` = '0'");
                    if ($order) {
                        $final[$key]['order'] = $order;
                    }
                }
                else if ($status == 'out') {
                    $order = $this->get_row("SELECT * FROM `sale` WHERE `sale_id` = '$SaleID' AND `status` = '1'");
                    if ($order) {
                        $final[$key]['order'] = $order;
                    }
                }
                else if ($status == 'complete') {
                    $order = $this->get_row("SELECT * FROM `sale` WHERE `sale_id` = '$SaleID' AND `status` = '2'");
                    if ($order) {
                        $final[$key]['order'] = $order;
                    }
                }
                if ($final[$key]['order']) {
                    $final[$key]['order_items'] = $this->get_results("SELECT * FROM `sale_items` WHERE `sale_id` = '$SaleID' ORDER BY `sale_item_id` ASC");
                }
            }
            if ($final) {
                $data['data'] = $final;
                $data['status'] = true;
                echo json_encode($data);
            }
            else{
                echo json_encode(false);
            }
        }
        else{
            echo json_encode(false);
        }
    }


    public function save_temp_address()
    {
        $this->db->insert('temp_address',$_REQUEST);
        echo json_encode(array("status"=>true));
    }
    public function get_temp_address($id)
    {
        $resp = $this->get_results("SELECT * FROM `temp_address` WHERE `user_id` = '$id' AND `status` = 'new';");
        /*$update['status'] = 'used';
        $this->db->where('user_id',$id);
        $this->db->where('status','new');
        $this->db->update('temp_address',$update);*/
        if ($resp) {
            foreach ($resp as $key => $q) {
                $q['img'] = base_url("img/".$resp['type']."_address.png");
                $final[$key][] = $q;
            }
            echo json_encode(array("status"=>true,"data"=>$final));
        }
        else{
            echo json_encode(array("status"=>false));
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
}