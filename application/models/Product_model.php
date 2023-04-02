<?php
class Product_model extends CI_Model{
      function get_products($in_stock=false,$cat_id="",$search="", $page = "",$brands = "", $min_price = "", $max_price = ""){
            $filter = "";
            $limit = "";
            $page_limit = 10;
            if($page != ""){
                $limit .= " limit ".(($page - 1) * $page_limit).",".$page_limit." ";
            }
            if($in_stock){
                $filter .=" and products.in_stock = 1 ";
            }
            if($cat_id!=""){
                $filter .=" and products.category_id = '".$cat_id."' ";
            }
             if($search!=""){
                $filter .=" and products.product_name like '".$search."' ";
            }
            if ($brands && strlen($brands) > 0) {
              $filter .= " and products.brand_id IN(".$brands.") ";
            }
            if (($min_price && strlen($min_price) > 0) && ($max_price && strlen($max_price) > 0)) {
              $filter .= " and products.price >= '".$min_price."' and products.price <= '".$max_price."' ";
            }
            $price_asc = $this->db->query("SELECT dp.*,products.*, ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) AS stock ,categories.title, brand.title AS BrandTitle, brand.urdu_title AS BrandTitleUrdu, brand.image AS BrandImage FROM products 
            inner join categories on categories.id = products.category_id
            left join brand on brand.brand_id = products.brand_id 
            left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
            left join deal_product dp on dp.product_id=products.product_id where 1 ".$filter." ORDER BY products.price ASC ".$limit);
            $final['price_asc'] =$price_asc->result();
            $price_desc = $this->db->query("SELECT dp.*,products.*, ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) AS stock ,categories.title, brand.title AS BrandTitle, brand.urdu_title AS BrandTitleUrdu, brand.image AS BrandImage FROM products 
            inner join categories on categories.id = products.category_id
            left join brand on brand.brand_id = products.brand_id 
            left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
            left join deal_product dp on dp.product_id=products.product_id where 1 ".$filter." ORDER BY products.price DESC ".$limit);
            $final['price_desc'] =$price_desc->result();
            $title_asc = $this->db->query("SELECT dp.*,products.*, ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) AS stock ,categories.title, brand.title AS BrandTitle, brand.urdu_title AS BrandTitleUrdu, brand.image AS BrandImage FROM products 
            inner join categories on categories.id = products.category_id
            left join brand on brand.brand_id = products.brand_id 
            left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
            left join deal_product dp on dp.product_id=products.product_id where 1 ".$filter." ORDER BY products.product_name ASC ".$limit);
            $final['title_asc'] =$title_asc->result();
            $title_desc = $this->db->query("SELECT dp.*,products.*, ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) AS stock ,categories.title, brand.title AS BrandTitle, brand.urdu_title AS BrandTitleUrdu, brand.image AS BrandImage FROM products 
            inner join categories on categories.id = products.category_id
            left join brand on brand.brand_id = products.brand_id 
            left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
            left join deal_product dp on dp.product_id=products.product_id where 1 ".$filter." ORDER BY products.product_name DESC ".$limit);
            $final['title_desc'] =$title_desc->result();
            $Brands = $this->db->query("SELECT DISTINCT(products.brand_id) AS BrandID, brand.title AS BrandTitle, brand.urdu_title AS BrandTitleUrdu, brand.image AS BrandImage 
            FROM products 
            inner join categories on categories.id = products.category_id
            left join brand on brand.brand_id = products.brand_id 
            where 1 ".$filter." ORDER BY brand.title ASC ".$limit);
            $Brands = $Brands->result();
            foreach ($Brands as $key => $q) {
              $Brand = $this->db->query("SELECT COUNT(`product_id`) AS totlal_products 
              FROM products  
              where `brand_id` = ".$q->BrandID." ".$filter."");
              $Brand = $Brand->result();
              $final['brands'][$key]['brand_id'] = $q->BrandID;
              $final['brands'][$key]['title'] = $q->BrandTitle;
              $final['brands'][$key]['image'] = $q->BrandImage;
              $final['brands'][$key]['totlal_products'] = $Brand[0]->totlal_products;
            }
            return $final;
      }
      function get_products_simple($in_stock=false,$cat_id="",$search="", $page = "",$brands = "", $min_price = "", $max_price = ""){
            $filter = "";
            $limit = "";
            $page_limit = 10;
            if($page != ""){
                $limit .= " limit ".(($page - 1) * $page_limit).",".$page_limit." ";
            }
            if($in_stock){
                $filter .=" and products.in_stock = 1 ";
            }
            if($cat_id!=""){
                $filter .=" and products.category_id = '".$cat_id."' ";
            }
             if($search!=""){
                $filter .=" and products.product_name like '".$search."' ";
            }
            if ($brands && strlen($brands) > 0) {
              $filter .= " and products.brand_id IN(".$brands.") ";
            }
            if (($min_price && strlen($min_price) > 0) && ($max_price && strlen($max_price) > 0)) {
              $filter .= " and products.price >= '".$min_price."' and products.price <= '".$max_price."' ";
            }
            $price_asc = $this->db->query("SELECT dp.*,products.*, ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) AS stock ,categories.title, brand.title AS BrandTitle, brand.urdu_title AS BrandTitleUrdu, brand.image AS BrandImage FROM products 
            inner join categories on categories.id = products.category_id
            left join brand on brand.brand_id = products.brand_id 
            left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
            left join deal_product dp on dp.product_id=products.product_id where 1 ".$filter." ORDER BY products.price ASC ".$limit);
            $final['products'] =$price_asc->result();
            $Brands = $this->db->query("SELECT DISTINCT(products.brand_id) AS BrandID, brand.title AS BrandTitle, brand.urdu_title AS BrandTitleUrdu, brand.image AS BrandImage 
            FROM products 
            inner join categories on categories.id = products.category_id
            left join brand on brand.brand_id = products.brand_id 
            where 1 ".$filter." ORDER BY brand.title ASC ".$limit);
            $Brands = $Brands->result();
            foreach ($Brands as $key => $q) {
              $Brand = $this->db->query("SELECT COUNT(`product_id`) AS totlal_products 
              FROM products  
              where `brand_id` = ".$q->BrandID." ".$filter."");
              $Brand = $Brand->result();
              $final['brands'][$key]['brand_id'] = $q->BrandID;
              $final['brands'][$key]['title'] = $q->BrandTitle;
              $final['brands'][$key]['image'] = $q->BrandImage;
              $final['brands'][$key]['totlal_products'] = $Brand[0]->totlal_products;
            }
            return $final;
      }
      
      function get_header_products($in_stock=false,$cat_id="",$search="", $page = ""){
            $filter = "";
            $limit = "";
            $page_limit = 10;
            if($page != ""){
                $limit .= " limit ".(($page - 1) * $page_limit).",".$page_limit." ";
            }
            if($in_stock){
                $filter .=" and header_products.in_stock = 1 ";
            }
            if($cat_id!=""){
                $filter .=" and header_products.category_id = '".$cat_id."' ";
            }
             if($search!=""){
                $filter .=" and header_products.product_name like '".$search."' ";
            }
            $q = $this->db->query("Select header_products.*,( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,header_categories.title from header_products 
            inner join header_categories on header_categories.id = header_products.category_id
            left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = header_products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = header_products.product_id
            where 1 ".$filter." ".$limit);
            $products = $q->result();
            //inner join product_price on product_price.product_id = products.product_id
            
            
            
            /*$prices = $this->get_product_price($in_stock);
            
            $products_output = array();
            foreach($products as $product){
                $price_array = array();
                foreach($prices as $price){
                    
                    if($price->product_id == $product->product_id){
                            $price_array[] = $price;        
                    }
                }
                $product->prices = $price_array;
                $products_output[] = $product;        
            }
            */
            return $products; 
      }
      
      function get_products_suggestion($in_stock=false,$cat_id="",$search="", $page = ""){
            $name=$_REQUEST['product_name'];
            $filter = "";
            $limit = "";
            $page_limit = 10;
            if($page != ""){
                $limit .= " limit ".(($page - 1) * $page_limit).",".$page_limit." ";
            }
            if($in_stock){
                $filter .=" and products.in_stock = 1 ";
            }
            if($cat_id!=""){
                $filter .=" and products.category_id = '".$cat_id."' ";
            }
             if($search!=""){
                $filter .=" and products.product_name like '.$search%%.'";
            }
            $q = $this->db->query("SELECT products.product_name, products.price, products.product_id FROM products WHERE products.product_name LIKE '$name%%'".$limit );
            $products = $q->result();
            //inner join product_price on product_price.product_id = products.product_id
            
            
            
            /*$prices = $this->get_product_price($in_stock);
            
            $products_output = array();
            foreach($products as $product){
                $price_array = array();
                foreach($prices as $price){
                    
                    if($price->product_id == $product->product_id){
                            $price_array[] = $price;        
                    }
                }
                $product->prices = $price_array;
                $products_output[] = $product;        
            }
            */
            return $products; 
      }
      
      function get_product_by_id($prod_id){
            $q = $this->db->query("Select products.*, categories.title from products 
            inner join categories on categories.id = products.category_id
            where 1 and products.product_id = '".$prod_id."' limit 1");
            return $q->row();
            
      }
      
      function get_header_product_by_id($prod_id){
            $q = $this->db->query("Select header_products.*, header_categories.title from header_products 
            inner join header_categories on header_categories.id = header_products.category_id
            where 1 and header_products.product_id = '".$prod_id."' limit 1");
            return $q->row();
            
      }
      
      function get_purchase_list(){
        $q = $this->db->query("SELECT purchase. * , products.product_name, users.user_fullname, store_login.user_fullname FROM purchase
LEFT JOIN products ON products.product_id = purchase.product_id
LEFT JOIN users ON purchase.store_id_login = users.user_id
LEFT JOIN store_login ON purchase.store_id_login = store_login.user_id");
            return $q->result();
            
      }
      function get_purchase_by_id($id){
        $q = $this->db->query("Select purchase.* from purchase 
            where 1 and purchase_id = '".$id."' limit 1");
            return $q->row();
      }
      function get_product_price($in_stock=false,$prod_id=""){
            $filter = "";
            if($in_stock){
                $filter .=" and products.in_stock = 1 ";
            }
            if($prod_id!=""){
                $filter .=" and products.product_id = '".$prod_id."' ";
            }
            $q = $this->db->query("Select product_price.* from product_price 
            inner join products on products.product_id = product_price.product_id 
            where 1 ".$filter);
            return $q->result();
      } 
      
     
      
      
      function get_prices_by_ids($ids){
            $q = $this->db->query("Select product_price.* from product_price 
            where 1 and price_id in (".$ids.")");
            return $q->result();
      }
      function get_price_by_id($price_id){
        $q = $this->db->query("Select * from product_price 
            where 1 and price_id = '".$price_id."'");
            return $q->row();
      }
      function get_socity_by_id($id){
        $q = $this->db->query("Select * from socity 
            where 1 and socity_id = '".$id."'");
            return $q->row();
      }
      function get_city_by_id($id){
        $q = $this->db->query("SELECT * FROM city WHERE city_id = '".$id."'");
            return $q->row();
      }
      function get_socities(){
        
        $q = $this->db->query("SELECT * FROM `socity` ");
            return $q->result();
      }
      function get_cities(){
        
        $q = $this->db->query("SELECT * FROM `city` ");
            return $q->result();
      }
      function get_groups($id){
        
        $q = $this->db->query("SELECT * FROM `user_product_group` WHERE `user_id` = '$id' ORDER BY `user_product_group_id` ASC");
            return $q->result();
      }
      function delete_group($id)
      {
         $this->db->where('user_product_group_id', $id);
        $this->db->delete('user_product_group');
        return true;
      }
      function get_list($group){
        #bakar
        $q = $this->db->query("
          SELECT p.*, l.list_id 
          FROM `list` AS l 
          INNER JOIN `products`AS p ON p.product_id = l.product_id 
          WHERE l.group_id = '$group' 
          ORDER BY l.at ASC
          ");
            return $q->result();
      }
      function delete_list($id)
      {
         $this->db->where('list_id', $id);
        $this->db->delete('list');
        return true;
      }
      function rewards_value(){
        
        $q = $this->db->query("Select point from rewards where id=1");
            return $q->result();
      }
      
      function update_reward($data){
         
        $this->db->where('id', 1);
        $this->db->update('rewards', $data);
        
      }
      
      function coupon($data)
      {
          
          $this->db->insert('coupons',$data);
          return true;
      }
      
      function coupon_list()
      {
          $query = $this->db->get('coupons');
          return $query->result();
      }

      function editCoupon($id,$data)
      {
        $this->db->where('id', $id);
        $this->db->update('coupons', $data);
        return true;
      }

      function deleteCoupon($id)
      {
         $this->db->where('id', $id);
        $this->db->delete('coupons');
        return true;
      }

      function getCoupon($id)
      {
        $this->db->select('*');
        $this->db->from('coupons');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row_array(); 

      }

      function lookup($keyword){ 
        $this->db->select('*')->from('products'); 
        $this->db->like('product_name',$keyword,'after'); 

        //$this->db->or_like('iso',$keyword,'after'); 
        $query = $this->db->get();     
        return $query->result(); 
      } 
      
       function looku($keyword){ 
        $this->db->select('*')->from('categories'); 

        $this->db->like('title',$keyword,'after');
        $this->db->where('parent',0) ;
        //$this->db->or_like('iso',$keyword,'after'); 
        $query = $this->db->get();     
        return $query->result(); 
      } 

       function look($keyword){ 
        $this->db->select('*')->from('categories'); 
        $this->db->like('title',$keyword,'after');
        $this->db->where('parent>',0) ; 
        //$this->db->or_like('iso',$keyword,'after'); 
        $query = $this->db->get();     
        return $query->result(); 
      } 

      function get_sale_by_user($user_id){
            $q = $this->db->query("SELECT * FROM `sale` WHERE `user_id` = $user_id AND `status` != 3 ORDER BY `sale_id` DESC");
            return $q->result();
      }
      function get_sale_by_user2($user_id){
            $q = $this->db->query("SELECT * FROM `sale` WHERE `user_id` = $user_id AND `status` = 4 ORDER BY `sale_id` DESC");
            return $q->result();
      }
      function get_sale_orders($filter=""){
         $sql = "Select distinct sale.*,registers.fname,registers.lname, registers.phone,registers.pincode,registers.admin_status,
         registers.socity_id,registers.house_no, socity.socity_name, user_location.socity_id, sale.new_store_id ,
         user_location.pincode, user_location.house_no, user_location.receiver_name, user_location.receiver_mobile  from sale 
            inner join customer AS registers on registers.customer_id = sale.user_id
            left outer join user_location on user_location.location_id = sale.location_id
            left outer join socity on socity.socity_id = user_location.socity_id
            left outer join users on users.user_id = user_location.store_id
            where 1 ".$filter." ORDER BY sale_id DESC";
            $q = $this->db->query($sql);
            return $q->result();
      } 
      
      function get_sale_order_by_id($order_id){
            $q = $this->db->query("SELECT distinct sale.*,registers.fname,registers.lname,registers.phone,registers.pincode,registers.socity_id,registers.house_no, socity.socity_name, user_location.socity_id, user_location.pincode, user_location.house_no, user_location.receiver_name, user_location.receiver_mobile from sale 
            inner join customer AS registers on registers.customer_id = sale.user_id
            left outer join user_location on user_location.location_id = sale.location_id
            left outer join socity on socity.socity_id = user_location.socity_id
            where sale_id = ".$order_id." limit 1");
            return $q->row();
      } 
      function get_sale_order_items($sale_id){
        $q = $this->db->query("
          SELECT si.*,p.*, size.name AS Size, color.name AS Color 
          FROM `sale_items` AS si 
          INNER JOIN `products` AS p ON p.product_id = si.product_id 
          LEFT JOIN `size` on size.size_id = p.size 
          LEFT JOIN `color` on color.color_id = p.color 
          WHERE si.sale_id = $sale_id 
          ");
            return $q->result();
      }
      function get_sale_order_items_invoice($sale_id){
        $q = $this->db->query("
          SELECT si.*,p.*, size.name AS Size, color.name AS Color 
          FROM `sale_items` AS si 
          INNER JOIN `products` AS p ON p.product_id = si.product_id 
          LEFT JOIN `size` on size.size_id = si.size 
          LEFT JOIN `color` on color.color_id = si.color 
          WHERE si.sale_id = $sale_id AND si.status != 'cancelled' 
          ");
            return $q->result();
      }
      function get_sale_order_items_food($sale_id){
        $q = $this->db->query("SELECT si.*,p.*, r.user_fullname 
          FROM `sale_items` AS si 
          INNER JOIN `product` AS p ON p.product_id = si.product_id 
          LEFT JOIN `registers` AS r ON si.user_id = r.user_id 
          WHERE si.sale_id = $sale_id 
          ");
        return $q->result();
      }
      
      function get_leftstock(){
        $q = $this->db->query("Select products.*,( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock from products 
        left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
            ");
        return $q->result();
      }
      
      function get_all_users(){
         $sql = "Select registers.*, ifnull(sale_order.total_amount, 0) as total_amount, total_orders, ifnull(sale_order.total_rewards, 0) as total_rewards  from customer AS registers 
            
            left outer join (Select sum(total_amount) as total_amount, count(sale_id) as total_orders, sum(total_rewards) as total_rewards, user_id from sale group by user_id) as sale_order on sale_order.user_id = registers.customer_id
            where 1 order by user_id DESC";
            $q = $this->db->query($sql);
            
            return $q->result();
      }

      function adddealproduct($data)
      {
        $this->db->insert('deal_product',$data);
        return true;
      }

       function getdealproducts()
      {

        $query = $this->db->get('deal_product');
        return $query->result();
      }
      
      function getdealproduct($id)
      {
          $this->db->where('id',$id);
          $query=$this->db->get('deal_product');
          return $query->row();
      }
      
      function edit_deal_product($id,$data)
      {
          $this->db->where('id',$id);
          $this->db->update('deal_product',$data);
          return true;
      }
      
      function get_order_list()
      {
          
      }
      function delivery_boy_order($delivery_boy_id){
            $q = $this->db->query("Select sale.*,socity.*,user_location.* from sale
            inner join socity on socity.socity_id = sale.socity_id
            left outer join user_location on user_location.location_id = sale.location_id
             where assign_to = '".$delivery_boy_id."' ORDER BY sale_id DESC");
            return $q->result();
      }
}
?>