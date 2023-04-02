<?php
class Csv_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

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


    function uploadData()
    {
        error_reporting(E_ALL);
            if ($_POST['category_id'] > 0) {
                $categoryId = $_POST['category_id'];
            }
            $count=0;
            $fp = fopen($_FILES['userfile']['tmp_name'],'r') or die("can't open file");
            while($csv_line = fgetcsv($fp,1024))
            {
                $count++;
                if($count == 1)
                {
                    $heading = array();
                    for ($a=26; $a < count($csv_line); $a++) { 
                        $heading[$a] = $csv_line[$a];
                    }
                    continue;
                }//keep this if condition if you want to remove the first row
                for($i = 0, $j = count($csv_line); $i < $j; $i++)
                {
                    $insert_csv = array();
                    $insert_csv['product_name'] = $csv_line[0];
                    if (strlen($csv_line[1]) > 0) {
                        $insert_csv['product_description'] = $csv_line[1];
                    }
                    else{
                        $insert_csv['product_description'] = $csv_line[0];
                    }
                    $insert_csv['product_image'] = $csv_line[2];
                    if ($categoryId > 0) {
                        $insert_csv['category_id'] = $categoryId;
                    }
                    else{
                        $insert_csv['category_id'] = $csv_line[3];
                    }
                    $insert_csv['category_id'] = $csv_line[3];
                    $insert_csv['in_stock'] = $csv_line[4];
                    $insert_csv['price'] = $csv_line[5];
                    $insert_csv['unit_value'] = $csv_line[6];
                    $insert_csv['unit'] =  $csv_line[7];
                    $insert_csv['increament'] = $csv_line[8];
                    $insert_csv['rewards'] = $csv_line[9];
                    $insert_csv['urdu_title'] = $csv_line[10];
                    $insert_csv['brand_id'] = $csv_line[11];

                    if (strlen($csv_line[12]) > 0) {
                        $sizes = explode(',', $csv_line[12]);
                        foreach ($sizes as $sizeKey => $size) {
                            $sizeID = $this->get_row("SELECT `size_id` FROM `size` WHERE `name` = '$size'");
                            if ($sizeID) {
                                $SizeID = $sizeID['size_id'];
                            }
                            else{
                                $SizeInsert['name'] = $size;
                                $SizeInsert['full_name'] = $size;
                                $this->db->insert('size',$SizeInsert);
                                $SizeID = $this->db->insert_id();
                            }
                            if ($sizeKey == 0) {
                                $Size_IDs = $SizeID;
                            }
                            else{
                                $Size_IDs .= ','.$SizeID;
                            }
                        }
                        $insert_csv['size'] = $Size_IDs;
                    }
                    else{
                        $insert_csv['size'] = $csv_line[12];
                    }
                    if (strlen($csv_line[13]) > 0) {
                        $sizes = explode(',', $csv_line[13]);
                        foreach ($sizes as $sizeKey => $size) {
                            $size = explode('-', $size);
                            $sizeID = $this->get_row("SELECT `size_id` FROM `size` WHERE `name` = '".$size[0]."' LIMIT 1");
                            if ($sizeID) {
                                foreach ($sizeID as $sizeId):
                                    $SizeID = $sizeID['size_id'];
                                endforeach;
                            }
                            else{
                                $SizeInsert['name'] = $size;
                                $SizeInsert['full_name'] = $size;
                                $this->db->insert('size',$SizeInsert);
                                $SizeID = $this->db->insert_id();
                            }
                            if ($sizeKey == 0) {
                                $Size_Price = $SizeID.'-'.$size[1];
                            }
                            else{
                                $Size_Price .= ','.$SizeID.'-'.$size[1];
                            }
                        }
                        $insert_csv['size_price'] = $Size_Price;
                    }
                    else{
                        $insert_csv['size_price'] = $csv_line[13];
                    }
                    if (strlen($csv_line[14]) > 0) {
                        $colors = explode(',', $csv_line[14]);
                        foreach ($colors as $colorKey => $color) {
                            $colorID = $this->get_row("SELECT `color_id` FROM `color` WHERE `name` = '$color' LIMIT 1");
                            if ($colorID) {
                                /*foreach ($colorID as $colorId):
                                    $ColorID = $colorId['color_id'];
                                endforeach;*/
                                $ColorID = $colorID['color_id'];
                            }
                            else{
                                $ColorInsert['name'] = $color;
                                $ColorInsert['font_color'] = 'white';
                                $this->db->insert('color',$ColorInsert);
                                $ColorID = $this->db->insert_id();
                            }
                            if ($colorKey == 0) {
                                $Color_IDs = $ColorID;
                            }
                            else{
                                $Color_IDs .= ','.$ColorID;
                            }
                        }
                        $insert_csv['color'] = $Color_IDs;
                    }
                    else{
                        $insert_csv['color'] = $csv_line[14];
                    }
                    if (strlen($csv_line[15]) > 0) {
                        $colors = explode(',', $csv_line[14]);
                        foreach ($colors as $colorKey => $color) {
                            $color = explode('-', $color);
                            $colorID = $this->db->query("SELECT `color_id` FROM `color` WHERE `name` = '".$color[0]."' LIMIT 1");
                            $colorID = $colorID->result();
                            foreach ($colorID as $colorId):
                                $ColorID = $colorId->color_id;
                            endforeach;
                            if ($colorKey == 0) {
                                $Color_Price = $ColorID.'-'.$color[1];
                            }
                            else{
                                $Color_Price .= ','.$ColorID.'-'.$color[1];
                            }
                        }
                        $insert_csv['color_price'] = $Color_Price;
                    }
                    else{
                        $insert_csv['color_price'] = $csv_line[15];
                    }

                    $insert_csv['filter_price_show'] = $csv_line[16];
                    $insert_csv['warranty'] = $csv_line[17];
                    $insert_csv['sku'] = $csv_line[18];
                    $insert_csv['sku_own'] = $csv_line[19];
                    for ($a=27; $a < count($csv_line); $a++) {
                        $Heading = $heading[$a];
                        $Heading = preg_replace("/\([^)]+\)/","",$Heading);
                        $Heading = str_replace(')', '', $Heading);
                        $Heading = str_replace('(', '', $Heading);
                        if ($a == 27) {
                            $dynamic_filters = $csv_line[$a];
                        }
                        else{
                            $dynamic_filters .= ','.$csv_line[$a];
                        }
                        $filters = $this->db->query("SELECT `filter_id` FROM `filter` WHERE `title` = '$Heading' LIMIT 1");
                        $filters = $filters->result();
                        foreach ($filters as $filter):
                            $FilterID = $filter->filter_id;
                        endforeach;
                        $DynamicFilters = explode(',', $dynamic_filters);
                        $DynamicFilterQuery = '';
                        foreach ($DynamicFilters as $keyKey2 => $DynamicFilter) {
                            if ($keyKey2 == 0) {
                                $DynamicFilterQuery .= "`title` = '".$DynamicFilter."' ";
                            }
                            else{
                                $DynamicFilterQuery .= "OR `title` = '".$DynamicFilter."' ";
                            }
                        }
                        $filterValues = $this->db->query("SELECT `filter_value_id` FROM `filter_value` WHERE ($DynamicFilterQuery) AND `filter_id` = '$FilterID';");
                        $filterValues = $filterValues->result();
                        foreach ($filterValues as $Fkey => $value):
                            if ($Fkey == 0 && $a == 27) {
                                $FilterIDz = $value->filter_value_id;
                            }
                            else{
                                $FilterIDz .= ','.$value->filter_value_id;
                            }
                        endforeach;
                    }
                }
                $i++;

                if (!(strlen($FilterIDz) > 0) && !(isset($FilterIDz))) {
                    $FilterIDz = 0;
                }

                $BrandID = $insert_csv['brand_id'];
                $brands = $this->db->query("SELECT `brand_id` FROM `brand` WHERE `title` = '$BrandID' LIMIT 1");
                $brands = $brands->result();
                foreach ($brands as $brand):
                    $BrandID = $brand->brand_id;
                endforeach;
                $slug = $this->clean($insert_csv['product_name']);
                $data = array(
                    'product_id' => "" ,
                    'product_name' => $insert_csv['product_name'],
                    'slug' => $slug,
                    'product_description' => $insert_csv['product_description'],
                    'product_image' => $insert_csv['product_image'],
                    'category_id' => $categoryId,
                    'in_stock' => $insert_csv['in_stock'],
                    'price' => $insert_csv['price'] - $insert_csv['discount'],
                    'unit_value' => $insert_csv['unit_value'],
                    'unit' => $insert_csv['unit'],
                    'increament' => $insert_csv['increament'],
                    'rewards' => $insert_csv['rewards'],
                    'urdu_title' => $insert_csv['urdu_title'],
                    'brand_id' => $BrandID,
                    'size' => $insert_csv['size'],
                    'color' => $insert_csv['color'],
                    'warranty' => $insert_csv['warranty'],
                    'sku' => $insert_csv['sku'],
                    'sku_own' => $insert_csv['sku_own'],
                    'dynamic_filters' => $FilterIDz
                );


                //Meta Data
                $Brand = $this->get_row("SELECT `title` FROM `brand` WHERE `seller_id` = '".$user['seller_id']."'");
                $Category = $this->get_row("SELECT `title` FROM `categories` WHERE `id` = '$categoryId'");
                //meta_title
                $meta_title = $this->get_setting_byid(9);
                $meta_title = str_replace('[product]', $insert_csv['product_name'], $meta_title['value']);
                $meta_title = str_replace('[brand]', $Brand['title'], $meta_title);
                $meta_title = str_replace('[category]', $Category['title'], $meta_title);
                $data['meta_title'] = $meta_title;

                //meta_key
                $meta_key = $this->get_setting_byid(10);
                $meta_key = str_replace('[product]', $insert_csv['product_name'], $meta_key['value']);
                $meta_key = str_replace('[brand]', $Brand['title'], $meta_key);
                $meta_key = str_replace('[category]', $Category['title'], $meta_key);
                $data['meta_key'] = $meta_key;

                //meta_desc
                $meta_desc = $this->get_setting_byid(11);
                $meta_desc = str_replace('[product]', $insert_csv['product_name'], $meta_desc['value']);
                $meta_desc = str_replace('[brand]', $Brand['title'], $meta_desc);
                $meta_desc = str_replace('[category]', $Category['title'], $meta_desc);
                $data['meta_desc'] = $meta_desc;

                $data['crane_features'] = $this->db->insert('products', $data);
                $in_id=$this->db->insert_id();
                $date=date('Y-m-d h:i:s');

                $CatId = $csv_line[3];
                $CatTags = $this->db->query("SELECT `cat_tag_id`,`name` FROM `cat_tag` WHERE `category_id` = '$CatId' ORDER BY `cat_tag_id` ASC");
                $CatTags = $CatTags->result();
                $keyForCatTag = 0;
                for ($i=20; $i < 27; $i++) {
                    if (strlen($csv_line[$i]) > 0 && intval($CatTags[$keyForCatTag]->cat_tag_id) > 0) {
                        $CatTagInsert['product_id'] = $in_id;
                        $CatTagInsert['cat_tag_id'] = $CatTags[$keyForCatTag]->cat_tag_id;
                        $CatTagInsert['value'] = $csv_line[$i];
                        $this->db->insert("product_tag",$CatTagInsert);
                    }
                    $keyForCatTag++;
                }
                
                $data1 = array(
                    'purchase_id' => "" ,
                    'product_id' => $in_id,
                    'qty' => '1',
                    'unit' => $insert_csv['unit'],
                    'date' => $date,
                    'store_id_login' => '1'
                    );
                $data['crane_features']=$this->db->insert('purchase', $data1);
            }
            fclose($fp) or die("can't close file");
            $data['success']="Product upload success";
            return $data;
    }
    public function get_setting_byid($id)
    {
        return $this->get_row("SELECT * FROM `settings` WHERE `id` = '$id';");
    }
    public function clean($string) {
        $string = str_replace(' ', '-', $string);
        $string = str_replace('&', '-', $string);
        $string = str_replace('/', '-', $string);
        $string = str_replace('%', '-', $string);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }
    function UploadBrands()
    {
        $count=0;
            $fp = fopen($_FILES['userfile']['tmp_name'],'r') or die("can't open file");
            while($csv_line = fgetcsv($fp,1024))
            {
                $count++;
                if($count == 1)
                {
                    continue;
                }//keep this if condition if you want to remove the first row
                for($i = 0, $j = count($csv_line); $i < $j; $i++)
                {
                    $insert_csv = array();
                    $insert_csv['title'] = $csv_line[0];
                    $insert_csv['urdu_title'] = $csv_line[1];
                    $insert_csv['slug'] = strtolower(str_replace(' ', '-', $insert_csv['title']));
                    if (strlen($csv_line[2]) > 2) {
                        $insert_csv['image'] = $csv_line[2];
                    }
                    else{
                        $insert_csv['image'] = strtoupper($csv_line[0][0]).'.jpg';
                    }
                    $insert_csv['categories'] = $csv_line[3];
                    $insert_csv['seller_id'] = $csv_line[4];
                }
                $i++;

                $data = array(
                    'title' => $insert_csv['title'],
                    'urdu_title' => $insert_csv['urdu_title'],
                    'slug' => $insert_csv['slug'],
                    'image' => $insert_csv['image'],
                    'categories' => $insert_csv['categories'],
                    'seller_id' => $insert_csv['seller_id']
                    );
                $this->db->insert('brand', $data);
            }
            fclose($fp) or die("can't close file");
            $data['success']="Brand(s) uploaded successfully";
            return $data;
    }
    function UploadFilterValues()
    {
        $count=0;
        $fp = fopen($_FILES['userfile']['tmp_name'],'r') or die("can't open file");
        while($csv_line = fgetcsv($fp,1024))
        {
            $count++;
            if($count == 1)
            {
                continue;
            }//keep this if condition if you want to remove the first row
            for($i = 0, $j = count($csv_line); $i < $j; $i++)
            {
                $insert_csv = array();
                $insert_csv['filter_id'] = $csv_line[0];
                $insert_csv['title'] = $csv_line[1];
                $insert_csv['value'] = $csv_line[1];
            }
            $i++;

            $data = array(
                'filter_id' => $insert_csv['filter_id'],
                'title' => $insert_csv['title'],
                'value' => $insert_csv['value']
                );
            $this->db->insert('filter_value', $data);
        }
        fclose($fp) or die("can't close file");
        $data['success']="Filter Value(s) uploaded successfully";
        return $data;
    }
    function uploadfilter()
    {
        $count=0;
        $fp = fopen($_FILES['userfile']['tmp_name'],'r') or die("can't open file");
        while($csv_line = fgetcsv($fp,1024))
        {
            $count++;
            if($count == 1)
            {
                continue;
            }//keep this if condition if you want to remove the first row
            for($i = 0, $j = count($csv_line); $i < $j; $i++)
            {
                $insert_csv = array();
                $insert_csv['title'] = $csv_line[0];
                $insert_csv['admin_title'] = $csv_line[1];
            }
            $i++;

            $data = array(
                'title' => $insert_csv['title'],
                'admin_title' => $insert_csv['admin_title']
                );
            $this->db->insert('filter', $data);
        }
        fclose($fp) or die("can't close file");
        $data['success']="Filter(s) uploaded successfully";
        return $data;
    }
    function UploadproductsPricing()
    {
        $count=0;
        $fp = fopen($_FILES['userfile']['tmp_name'],'r') or die("can't open file");
        while($csv_line = fgetcsv($fp,1024))
        {
            $count++;
            if($count == 1)
            {
                continue;
            }//keep this if condition if you want to remove the first row
            for($i = 0, $j = count($csv_line); $i < $j; $i++)
            {
                $id = $csv_line[0];
                $price = $csv_line[2];
            }
            $i++;
            $this->db->where('product_id', $id);
            $this->db->update('products', array("price"=>$price));
        }
        fclose($fp) or die("can't close file");
        $data['success']="Product(s) Price(s) updated successfully";
        return $data;
    }
    function uploadfilterstocategories()
    {
        $fp = fopen($_FILES['userfile']['tmp_name'],'r') or die("can't open file");
        while($csv_line = fgetcsv($fp,1024))
        {
            for($i = 0, $j = count($csv_line); $i < $j; $i++)
            {
                $filters = $csv_line[0];
                $id = $csv_line[1];
                $check = $this->get_row("SELECT `filter_ids` FROM `categories` WHERE `id` = '$id';");
                if ($check) {
                    if (strlen($check['filter_ids']) > 0 && $check['filter_ids'] != '') {
                        $ids = explode(',', $check['filter_ids']);
                        if (!(in_array($filters, $ids))) {
                            $check['filter_ids'] = $check['filter_ids'].','.$filters;
                            $filters = $check['filter_ids'];
                            $this->db->where('id', $id);
                            $this->db->update('categories', array("filter_ids"=>$filters));
                        }
                    }
                    else{
                        $this->db->where('id', $id);
                        $this->db->update('categories', array("filter_ids"=>$filters));
                    }
                }
            }
            $i++;
        }
        fclose($fp) or die("can't close file");
        $data['success']="category(s) Filter(s) updated successfully";
        return $data;
    }
}