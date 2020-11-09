<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class copydata extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->helper('url');
        session_start();
        $this->load->model('Model1');
        $this->load->model('Clients');
        require_once APPPATH."/third_party/PHPExcel.php";
    }

    public function index()
    {
        $data['url'] = base_url();

        if(isset($_SESSION['userid'])){
            $config['upload_path']          = 'files/';
            $config['allowed_types']        = 'xls|xlsx|csv';
            // $config['max_size']             = 100;
            // $config['max_width']            = 1024;
            // $config['max_height']           = 768;
            $config['file_name']             = time();
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('img') )
            {
                echo $this->upload->display_errors();
            }
            else
            {
                $data['data'] = array('upload_data' => $this->upload->data());
                $file="files/".$data['data']['upload_data']["orig_name"];
                $objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file

                //
                $clientData['addedby'] = $_SESSION['userid'];

                $custnames=null;
                $custphones=null;
                $i=-1;
                $ClientCount = 0;
                foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
                {
                    $highestRow = $worksheet->getHighestRow();
                    for($row=2; $row<=$highestRow; $row++)
                    {
                        $clientData['customerCrmName']= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $clientData['customerCrmPhone']= $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $clientData['customerCrmSecondPhone']= $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $clientData['customerCrmJob']= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $clientData['customerCrmQualification']= $worksheet->getCellByColumnAndRow(17, $row)->getValue();
                        $clientData['customerCrmEmail']= $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $clientData['customerCrmCountry']= $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $clientData['customerCrmGov']= $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                        $clientData['customerCrmAddress']= $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $clientData['customerCrmAge']= $worksheet->getCellByColumnAndRow(18, $row)->getValue();
                        $Gender = $worksheet->getCellByColumnAndRow(19, $row)->getValue();
                        if ($Gender == "أنثى" || $Gender =="أنثي" ||
                            $Gender == "انثى" || $Gender =="انثي" ||
                            $Gender == "إنثى" || $Gender =="إنثي" ||
                            $Gender == 1 || strtolower($Gender) == "female" ){
                            $clientData['customerCrmGender']= true;
                        }else{
                            $clientData['customerCrmGender']=false;
                        }
                        $clientData['customerCrmCompany']= $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $clientData['customerCrmActivity']= $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $clientData['customerCrmOther']= $worksheet->getCellByColumnAndRow(21, $row)->getValue();
                        $error = false;
                        if ($i>=0){
                            for ($n=0;$n<=$i;$n++){
                                if ($custnames[$n] == $clientData['customerCrmName'] && $custphones[$n] ==$clientData['customerCrmPhone']){

                                    $error = true;
                                    break;

                                }
                            }
                        }

                        if ($error == false){
                            if (!is_null($clientData['customerCrmName']) && !is_null($clientData['customerCrmPhone'])){
                                $this->Model1->addtotable("customercrm",$clientData);
                                $ClientCount +=1;
                            }
                        }

                        $i++;
                        $custnames[$i] = $clientData['customerCrmName'];
                        $custphones[$i] =  $clientData['customerCrmPhone'];

                    }
                }
                echo $ClientCount;
            }
        }else{
            $this->load->view('login',$data);
        }
    }

    public function Export(){
        $this->load->library('excel');
        $object  = new PHPExcel();
        $object->setActiveSheetIndex(0);
        $table_columns = array("الاسم","الهاتف","العنوان","الوظيفه","الشركة","طريقه الشحن","البريد الالكتروني","الإيميل","السعر","الدوله","النشاط","الخدمه","المنتج","رقم هاتف اخر","تليفون ارضي","المحافظة","طريقه الدفع","المؤهل الدراسي","السن","النوع","الكمية","بيان اخر","حالة المكالمة","اخر تعليق");
        $column = 0;
        foreach ($table_columns as $field){
            $object->getActiveSheet()->setCellValueByColumnAndRow($column,1,$field);
            $column++;
        }
        //Get Data
        $clientData = $this->Clients->GetClientDataForExport();
        // print_r($clientData);die();
        $Excel_row = 2;
        if (isset($clientData) && !is_null($clientData)){
            foreach ($clientData as $client){
                $object->getActiveSheet()->setCellValueByColumnAndRow(0,$Excel_row,$client->customerCrmName);
                $object->getActiveSheet()->setCellValueByColumnAndRow(1,$Excel_row,$client->customerCrmPhone);
                $object->getActiveSheet()->setCellValueByColumnAndRow(2,$Excel_row,$client->customerCrmAddress);
                $object->getActiveSheet()->setCellValueByColumnAndRow(3,$Excel_row,$client->customerCrmJob);
                $object->getActiveSheet()->setCellValueByColumnAndRow(4,$Excel_row,$client->customerCrmCompany);
                $object->getActiveSheet()->setCellValueByColumnAndRow(5,$Excel_row,"");
                $object->getActiveSheet()->setCellValueByColumnAndRow(6,$Excel_row,$client->customerCrmEmail);
                $object->getActiveSheet()->setCellValueByColumnAndRow(7,$Excel_row,"");
                $object->getActiveSheet()->setCellValueByColumnAndRow(8,$Excel_row,"");
                $object->getActiveSheet()->setCellValueByColumnAndRow(9,$Excel_row,$client->customerCrmCountry);
                $object->getActiveSheet()->setCellValueByColumnAndRow(10,$Excel_row,$client->customerCrmActivity);
                $object->getActiveSheet()->setCellValueByColumnAndRow(11,$Excel_row,"");
                $object->getActiveSheet()->setCellValueByColumnAndRow(12,$Excel_row,"");
                $object->getActiveSheet()->setCellValueByColumnAndRow(13,$Excel_row,$client->customerCrmSecondPhone);
                $object->getActiveSheet()->setCellValueByColumnAndRow(14,$Excel_row,"");
                $object->getActiveSheet()->setCellValueByColumnAndRow(15,$Excel_row,$client->customerCrmGov);
                $object->getActiveSheet()->setCellValueByColumnAndRow(16,$Excel_row,"");
                $object->getActiveSheet()->setCellValueByColumnAndRow(17,$Excel_row,$client->customerCrmQualification);
                $object->getActiveSheet()->setCellValueByColumnAndRow(18,$Excel_row,$client->customerCrmAge);
                $object->getActiveSheet()->setCellValueByColumnAndRow(19,$Excel_row,($client->customerCrmGender==0)?"ذكر":"انثى");
                $object->getActiveSheet()->setCellValueByColumnAndRow(20,$Excel_row,"");
                $object->getActiveSheet()->setCellValueByColumnAndRow(21,$Excel_row,$client->customerCrmOther);

                if (isset($client->title) && !is_null($client->title) && !empty($client->title)){
                    $title = $client->title;
                }else{
                    $title = 'غير موزع';
                }
                $object->getActiveSheet()->setCellValueByColumnAndRow(22,$Excel_row,$title);
                if (isset($client->Comment_Text) && !empty($client->Comment_Text)){
                    $object->getActiveSheet()->setCellValueByColumnAndRow(23,$Excel_row,strip_tags(htmlspecialchars_decode($client->Comment_Text)));
                }

                $Excel_row++;
            }
        }


//        $objWriter = new PHPExcel_Writer_Excel2007($object);
//        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//        header("Content-Disposition: attachment;filename=report.xlsx");
//        header('Cache-Control: max-age=0');
//        $objWriter->save('php://output');

        $object_writer = PHPExcel_IOFactory::createWriter($object,'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="ClientsData.xls"');
        $object_writer->save('php://output');
    }

}
