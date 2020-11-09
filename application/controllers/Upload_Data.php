<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 10/10/2018
 * Time: 9:34 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_Data extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        session_start();
        $this->load->model('Model1');
        $this->load->model('Employee_Taskes');
        $this->load->model('Call_Status');
        $this->load->model('Clients');
        $this->load->model('User_Log');
        $this->load->model('InternalMessages');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->library('zip');
        $this->load->model('Import_model', 'import');
    }

    // upload xlsx|xls file
    public function index() {
        $data['page'] = 'import';
        $data['url'] = base_url();
        $data['title'] = 'تحميل ملف';
        $this->load->view('UploadData/Upload', $data);
    }
    // import excel data
    public function save() {
        $this->load->library('excel');

        if ($this->input->post('importfile')) {
            $path = ROOT_UPLOAD_IMPORT_PATH;

            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls|jpg|png';
            $config['remove_spaces'] = TRUE;
            $this->upload->initialize($config);
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('userfile')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }

            if (!empty($data['upload_data']['file_name'])) {
                $import_xls_file = $data['upload_data']['file_name'];
            } else {
                $import_xls_file = 0;
            }
            $inputFileName = $path . $import_xls_file;
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                    . '": ' . $e->getMessage());
            }
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

            $arrayCount = count($allDataInSheet);
            $flag = 0;
            $createArray = array('First_Name', 'Last_Name', 'Email', 'DOB', 'Contact_NO');
            $makeArray = array('First_Name' => 'First_Name', 'Last_Name' => 'Last_Name', 'Email' => 'Email', 'DOB' => 'DOB', 'Contact_NO' => 'Contact_NO');
            $SheetDataKey = array();
            foreach ($allDataInSheet as $dataInSheet) {
                foreach ($dataInSheet as $key => $value) {
                    if (in_array(trim($value), $createArray)) {
                        $value = preg_replace('/\s+/', '', $value);
                        $SheetDataKey[trim($value)] = $key;
                    } else {

                    }
                }
            }
            $data = array_diff_key($makeArray, $SheetDataKey);

            if (empty($data)) {
                $flag = 1;
            }
            if ($flag == 1) {
                for ($i = 2; $i <= $arrayCount; $i++) {
                    $addresses = array();
                    $Name = $SheetDataKey[0];
                    $phone = $SheetDataKey[1];
                    $gov = $SheetDataKey[2];
                    $job = $SheetDataKey[3];
                    $email = $SheetDataKey[4];
                    $Name = filter_var(trim($allDataInSheet[$i][$Name]), FILTER_SANITIZE_STRING);
                    $phone = filter_var(trim($allDataInSheet[$i][$phone]), FILTER_SANITIZE_STRING);
                    $email = filter_var(trim($allDataInSheet[$i][$email]), FILTER_SANITIZE_EMAIL);
                    $gov = filter_var(trim($allDataInSheet[$i][$gov]), FILTER_SANITIZE_STRING);
                    $job = filter_var(trim($allDataInSheet[$i][$job]), FILTER_SANITIZE_STRING);
                    $fetchData[] = array('customerCrmName' => $Name, 'customerCrmPhone' => $phone, 'customerCrmGov' => $gov,
                        'customerCrmJob' => $job, 'customerCrmEmail' => $email);
                }
                $data['cutomerinfo'] = $fetchData;
                $this->import->setBatchImport($fetchData);
                $this->import->importData();
            } else {
                echo "Please import correct file";
            }
        }
//        $this->load->view('import/display', $data);

    }
}