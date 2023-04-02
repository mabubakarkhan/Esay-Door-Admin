<?php
class Restaurant_model extends CI_Model{
    /* ========== Category========== */
    public function get_restaurants()
    {
        $q = $this->db->query("SELECT * FROM `registers` WHERE `type` = 'restaurant' ORDER BY `user_fullname` ASC");
        return $q->result();
    }
    public function get_food_cats()
    {
        $q = $this->db->query("SELECT * FROM `admin_category` ORDER BY `name` ASC");
        return $q->result();
    }
    public function get_food_pros($id)
    {
        $q = $this->db->query("SELECT * FROM `admin_product` WHERE `category_id` = '$id' ORDER BY `name` ASC");
        return $q->result();
    }
}