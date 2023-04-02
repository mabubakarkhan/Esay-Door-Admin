<?php
class Seller_model extends CI_Model{
    /* ========== Category========== */
    public function get_sellers()
    {
        $q = $this->db->query("
        	SELECT s.*, b.title AS Brand 
        	FROM `seller` AS s 
        	LEFT JOIN `brand` AS b ON s.seller_id = b.seller_id 
        	ORDER BY s.seller_id DESC
    	");
        return $q->result();
    }
}