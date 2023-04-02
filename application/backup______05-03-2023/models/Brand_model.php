<?php
class Brand_model extends CI_Model{
        /* ========== Category========== */
        public function add_brand()
        {
            $slug = url_title($this->input->post('title'), 'dash', TRUE);
            if ( strlen($this->input->post("urdu_title")) > 0 ) {
                $urdu_title = $this->input->post("urdu_title");
            }
            else{
                $urdu_title = '';
            }
            $addcat = array(
                    "title"=>$this->input->post("title"),
                    "urdu_title"=>$urdu_title,
                    "slug"=>$slug
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
                        $addcat["image"]=$img_data['file_name'];
                    }
                }
                else{
                    $addcat["image"]= strtoupper($this->input->post("title")[0]).'.jpg';
                }
                
                if($_FILES["logo_2"]["size"] > 0){
                    $config['upload_path']          = './uploads/category/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                    //$this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ( ! $this->upload->do_upload('logo_2'))
                    {
                            $error = array('error' => $this->upload->display_errors());
                    }
                    else
                    {
                        $img_data = $this->upload->data();
                        $addcat["logo_2"]=$img_data['file_name'];
                    }
                }
                if($_FILES["banner"]["size"] > 0){
                    $config['upload_path']          = './uploads/category/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                    //$this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ( ! $this->upload->do_upload('banner'))
                    {
                            $error = array('error' => $this->upload->display_errors());
                    }
                    else
                    {
                        $img_data = $this->upload->data();
                        $addcat["banner"]=$img_data['file_name'];
                    }
                }
                
                $addcat['categories'] = implode(',', $this->input->post("categories"));
                $this->db->insert("brand",$addcat); 
        }
        
        

        
        public function edit_brand()
        {
            $slug = url_title($this->input->post('title'), 'dash', TRUE);
            if ( strlen($this->input->post("urdu_title")) > 0 ) {
                $urdu_title = $this->input->post("urdu_title");
            }
            else{
                $urdu_title = '';
            }
            $editcat = array(
                "title"=>$this->input->post("title"),
                "urdu_title"=>$urdu_title,
                "slug"=>$slug
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
            if($_FILES["logo_2"]["size"] > 0){
                $config['upload_path']          = './uploads/category/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                //$this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ( ! $this->upload->do_upload('logo_2'))
                {
                        $error = array('error' => $this->upload->display_errors());
                }
                else
                {
                    $img_data = $this->upload->data();
                    $editcat["logo_2"]=$img_data['file_name'];
                }
            }
            if($_FILES["banner"]["size"] > 0){
                $config['upload_path']          = './uploads/category/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                //$this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ( ! $this->upload->do_upload('banner'))
                {
                        $error = array('error' => $this->upload->display_errors());
                }
                else
                {
                    $img_data = $this->upload->data();
                    $editcat["banner"]=$img_data['file_name'];
                }
            }
            $editcat['categories'] = implode(',', $this->input->post("categories"));
            $this->db->update("brand",$editcat,array("brand_id"=>$this->input->post("brand_id"))); 
        }
        
        public function get_brands()
        {
            $q = $this->db->query("
                SELECT b.*, COUNT(p.product_id) AS 'total_products' 
                FROM `brand` AS b 
                LEFT JOIN `products` AS p ON b.brand_id = p.brand_id 
                GROUP BY b.brand_id 
                ORDER BY b.title ASC
            ");
            return $q->result();
        }

        //Stores
        
        public function get_stores()
        {
            $q = $this->db->query("SELECT * FROM `store` ORDER BY `title` ASC");
            return $q->result();
        }
        public function add_store()
        {
            $addcat = array(
                            "title"=>$this->input->post("title"),
                            "lat"=>$this->input->post("lat"),
                            "long"=>$this->input->post("long")
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
                        $addcat["image"]=$img_data['file_name'];
                    }                    
               }
               $this->db->insert("store",$addcat); 
        }
        public function edit_store()
        {
            $editcat = array(
                            "title"=>$this->input->post("title"),
                            "lat"=>$this->input->post("lat"),
                            "long"=>$this->input->post("long"),
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
                  
                    $this->db->update("store",$editcat,array("store_id"=>$this->input->post("store_id"))); 
        }
}
?>