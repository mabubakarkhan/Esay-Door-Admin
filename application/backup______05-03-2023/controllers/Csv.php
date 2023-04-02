<?php
class Csv extends CI_Controller
{
    public $data;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('csv_model');
    }
    function index()
    {
        $data['parents'] = $this->get_results("SELECT * FROM `categories` WHERE `parent` = '0' AND `leval` = '0' ORDER BY `title` ASC");
        $this->load->view('admin/uploadCsvView',$data);
    }
    function uploadData()
    {
        error_reporting(E_ALL);
        $this->csv_model->uploadData();
        redirect('csv');
    }
    function uploadproductpricingcsv()
    {
        $this->csv_model->UploadproductsPricing();
        redirect('admin/products');
    }
    function uploadbrandcsv()
    {
        $this->csv_model->UploadBrands();
        redirect('admin/brands');
    }
    function uploadfiltervaluecsv()
    {
        $this->csv_model->UploadFilterValues();
        redirect('admin/filters');
    }
    function uploadfiltercsv()
    {
        $this->csv_model->uploadfilter();
        redirect('admin/filters');
    }
    function uploadfilterstocategoriescsv()
    {
        $this->csv_model->uploadfilterstocategories();
        redirect('admin/listcategories');
    }
    function doownloadfile()
    {
        $fileName = basename('SampleFile.csv');
        $filePath = base_url().'uploads/'.$fileName;
        if(!empty($fileName) && file_exists($filePath)){
            // Define headers
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$fileName");
            header("Content-Type: application/zip");
            header("Content-Transfer-Encoding: binary");
            
            // Read the file
            readfile($filePath);
            exit;
        }
        else{
            echo "not_valid =>".$fileName."<br> AND =>".$filePath;
        }
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


}
?>