<?php
class Category_model extends CI_Model{
        /* ========== Category========== */
        public function add_category($filters,$filter_ids)
        {
           // error_reporting(E_ALL);
            $slug = url_title($this->input->post('cat_title'), 'dash', TRUE);
           if ( strlen($this->input->post("sub_cat")) > 0 ) {
               $parentid = $this->input->post("sub_cat");
           }
           else{
            $parentid = $this->input->post("parent");
           }
           if ( strlen($this->input->post("cat_type_id")) > 0 ) {
               $cat_type_id = $this->input->post("cat_type_id");
           }
           else{
            $cat_type_id = 0;
           }
           if ( strlen($this->input->post("urdu_title")) > 0 ) {
               $urdu_title = $this->input->post("urdu_title");
           }
           else{
            $urdu_title = '';
           }
            $addcat = array(
                "title"=>$this->input->post("cat_title"),
                "slug"=>$this->input->post("slug"),
                "urdu_title"=>$urdu_title,
                "arb_title"=>$this->input->post("arb_cat_title"),
                "slug"=>$slug,
                "parent"=>$parentid, 
                "cat_type_id"=>$cat_type_id, 
                "tags"=>$this->input->post("tags"),
                "description"=>$this->input->post("description"),
                "status"=>$this->input->post("cat_status"),
                "main_menu"=>$this->input->post("main_menu"),
                "main_right_menu"=>$this->input->post("main_right_menu"),
                "main_home_page"=>$this->input->post("main_home_page"),
                "main_home_page_under_parent"=>$this->input->post("main_home_page_under_parent"),
                "meta_title"=>$this->input->post("meta_title"),
                "meta_key"=>$this->input->post("meta_key"),
                "meta_desc"=>$this->input->post("meta_desc"),
                "filters"=>$filters,
                "filter_ids"=>$filter_ids,
                "for_you"=>$this->input->post("for_you")
            );
            
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
                        $addcat["image"]=$img_data['file_name'];
                    }
                }

                if($_FILES["app_icon"]["size"] > 0){
                    $Naam = explode('.', $_FILES["app_icon"]['name']);
                    $config['upload_path']          = 'uploads/category/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg';

                    $ext = pathinfo($_FILES["app_icon"]['name'], PATHINFO_EXTENSION);
                    $config['file_name'] = 'easydoor_'.$this->input->post("cat_title").'_'.$Naam[0].'_'.md5(time().$_FILES["app_icon"]['name']).'.'.$ext;

                    //$this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ( ! $this->upload->do_upload('app_icon'))
                    {
                            $error = array('error' => $this->upload->display_errors());
                    }
                    else
                    {
                        $img_data = $this->upload->data();
                        $addcat["app_icon"]=$img_data['file_name'];
                    }
               }
               
               
                if($parentid != "0"){
                    $q = $this->db->query("select * from `categories` where id=".$parentid);
                    $parent = $q->row();
                    $leval = $parent->leval + 1;
                    $addcat["leval"] = $leval;  
                }
               $this->db->insert("categories",$addcat); 
        }
        
        

        
        public function edit_category($filters,$filter_ids)
        {
            $slug = url_title($this->input->post('cat_title'), 'dash', TRUE);
            //$parentid = $this->input->post("parent");
            if ( strlen($this->input->post("sub_cat")) > 0 ) {
                $parentid = $this->input->post("sub_cat");
            }
            else{
                if (strlen($this->input->post("parent") > 0)) {
                    $parentid = $this->input->post("parent");
                }
                else{
                    $parentid = 0;
                }
            }
            if ( strlen($this->input->post("cat_type_id")) > 0 ) {
               $cat_type_id = $this->input->post("cat_type_id");
            }
            else{
                $cat_type_id = 0;
            }
            if ( strlen($this->input->post("urdu_title")) > 0 ) {
                $urdu_title = $this->input->post("urdu_title");
            }
            else{
                $urdu_title = '';
            }
            $editcat = array(
                "title"=>$this->input->post("cat_title"),
                "slug"=>$this->input->post("slug"),
                "urdu_title"=>$urdu_title,
                "arb_title"=>$this->input->post("arb_cat_title"),
                "slug"=>$slug,
                "parent"=>$parentid,
                "cat_type_id"=>$cat_type_id, 
                "tags"=>$this->input->post("tags"),
                "description"=>$this->input->post("description"),
                "status"=>$this->input->post("cat_status"),
                "main_menu"=>$this->input->post("main_menu"),
                "main_right_menu"=>$this->input->post("main_right_menu"),
                "main_home_page"=>$this->input->post("main_home_page"),
                "main_home_page_under_parent"=>$this->input->post("main_home_page_under_parent"),
                "meta_title"=>$this->input->post("meta_title"),
                "meta_key"=>$this->input->post("meta_key"),
                "meta_desc"=>$this->input->post("meta_desc"),
                "filters"=>$filters,
                "filter_ids"=>$filter_ids,
                "for_you"=>$this->input->post("for_you")
            );
            
            if($_FILES["cat_img"]["size"] > 0){
                $Naam = explode('.', $_FILES["cat_img"]['name']);
                $config['upload_path']          = 'uploads/category/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';

                $ext = pathinfo($_FILES["cat_img"]['name'], PATHINFO_EXTENSION);
                $config['file_name'] = 'easydoor_'.$this->input->post("cat_title").'_'.$Naam[0].'_'.md5(time().$_FILES["cat_img"]['name']).'.'.$ext;

                //$this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ( ! $this->upload->do_upload('cat_img'))
                {
                        $error = array('error' => $this->upload->display_errors());
                }
                else
                {
                    $img_data = $this->upload->data();
                    $editcat["image"]=$img_data['file_name'];
                }
           }

           if($_FILES["app_icon"]["size"] > 0){
                $Naam = explode('.', $_FILES["app_icon"]['name']);
                $config['upload_path']          = 'uploads/category/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';

                $ext = pathinfo($_FILES["app_icon"]['name'], PATHINFO_EXTENSION);
                $config['file_name'] = 'easydoor_'.$this->input->post("cat_title").'_'.$Naam[0].'_'.md5(time().$_FILES["app_icon"]['name']).'.'.$ext;

                //$this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ( ! $this->upload->do_upload('app_icon'))
                {
                        $error = array('error' => $this->upload->display_errors());
                }
                else
                {
                    $img_data = $this->upload->data();
                    $editcat["app_icon"]=$img_data['file_name'];
                }
           }
           
           
            if($parentid != "0"){
                $q = $this->db->query("select * from `categories` where id=".$parentid);
                $parent = $q->row();
                $leval = $parent->leval + 1;
                $editcat["leval"] = $leval;
            }

          
            $this->db->update("categories",$editcat,array("id"=>$this->input->post("cat_id"))); 
        }
        
        public function edit_header_category()
        {
            $slug = url_title($this->input->post('cat_title'), 'dash', TRUE);
            $parentid = $this->input->post("parent");
            $editcat = array(
                            "title"=>$this->input->post("cat_title"),
                            "slug"=>$slug,
                            "parent"=>$this->input->post("parent"), 
                            "status"=>$this->input->post("cat_status")
                            );
            
                    if($_FILES["cat_img"]["size"] > 0){
                        $config['upload_path']          = './uploads/category/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg';
                        //$this->load->library('upload', $config);
                        $this->upload->initialize($config);
        
                        if ( ! $this->upload->do_upload('cat_img'))
                        {
                                $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            $img_data = $this->upload->data();
                            $editcat["image"]=$img_data['file_name'];
                        }
                        
                   }
                   if($parentid != "0"){
                    $q = $this->db->query("select * from `header_categories` where id=".$parentid);
                    $parent = $q->row();
                    $leval = $parent->leval + 1;
                    $editcat["leval"] = $leval;                       
                    }
                  
                    $this->db->update("header_categories",$editcat,array("id"=>$this->input->post("cat_id"))); 
        }
        
        public function get_categories()
        {
            $q = $this->db->query("SELECT a.*, Deriv1.prtitle FROM `categories` a  LEFT OUTER JOIN (SELECT `id`, `title` as `prtitle` FROM `categories`) as Deriv1 ON Deriv1.`id` = a.`parent` " );
           // $q = $this->db->query("select * from `categories` order by id DESC ");
            return $q->result();
        }
        public function get_header_categories()
        {
            $q = $this->db->query("SELECT a.*, Deriv1.prtitle FROM `header_categories` a  LEFT OUTER JOIN (SELECT `id`, `title` as `prtitle` FROM `categories`) as Deriv1 ON Deriv1.`id` = a.`parent` " );
           // $q = $this->db->query("select * from `categories` order by id DESC ");
            return $q->result();
        }
        
         public function sel_categories(){
            $q = $this->db->query("select * from `categories`  ");
            return $q->result();
        } 
             public function bus_category($id){
            $q = $this->db->query("select categories.title, business_category.bus_id as bcid, business_category.category_id from `business_category` INNER JOIN categories ON categories.id = business_category.category_id WHERE business_category.bus_id =".$id);
            return $q->result();
        } 
        
        public function get_categories_short($parent,$level,$th){
            $q = $th->db->query("Select a.*, ifnull(Deriv1.Count , 0) as Count, ifnull(Total1.PCount, 0) as PCount FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` 
                         LEFT OUTER JOIN (SELECT `category_id`,COUNT(*) AS PCount FROM `products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id` 
                         WHERE a.`parent`=" . $parent);
                        
                        $return_array = array();
                        
                        foreach($q->result() as $row){
                                    if ($row->Count > 0) {
                                        $sub_cat =  $this->get_categories_short($row->id, $level + 1,$th);
                                        $row->sub_cat = $sub_cat;       
                                    } elseif ($row->Count==0) {
                                    
                                    }
                            $return_array[] = $row;
                        }
        return $return_array;
    }

}
?>