<?php
class Excel_export_model extends CI_Model
{
 function fetch_data()
 {
  $this->db->order_by("sale_id", "DESC");
  $query = $this->db->get("sale");
  return $query->result();
 }

 
}