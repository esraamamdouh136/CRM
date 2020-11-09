<?php 
    require_once('config/tcpdf_config.php');
	$l = Array();
	$l['a_meta_charset'] = 'UTF-8';
	$l['a_meta_dir'] = 'rtl';
	$l['a_meta_language'] = 'dejavusans';
	$l['w_page'] = 'page';
	
    require_once('tcpdf.php');
	class MYPDF extends TCPDF {
		public function Header(){
			$foot = '<div style="padding-right:10px;line-height:10px; "><p>كود الفاتوره : <span>121</span></p><p>اسم العميل : احمد رمضان سيد</p><p>العنوان :  13 شارع بركات المرجوشي </p><p style="width:100%">رقم التليفون :  01129736251<span style="width:100%;float:left"> تاريخ الطباعه  :  '.date('Y-m-d').'</span></p></div>';
			$l = Array();
			$l['a_meta_charset'] = 'UTF-8';
			$l['a_meta_dir'] = 'rtl';
			$l['a_meta_language'] = 'dejavusans';
			$l['w_page'] = 'page';
			$this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			$this->setLanguageArray($l);	
			$this->setRTL(true);
			$this->setFontSubsetting(true);
			$this->SetFont('aealarabiya','',12,'',true);
			$this->setCellPaddings($left ='0',$top ='0',$right ='2',$bottom ='0');
			$this->writeHTMLCell($w=97.6 ,$h=50,$x='',$y='',$foot,$border=0,$ln=0,$fill=0,$reseth=true,$align='',$autopadding=true);
			$this->writeHTMLCell($w=97.6 ,$h=50,$x='',$y='',$foot,$border=0,$ln=0,$fill=0,$reseth=true,$align='',$autopadding=true);
			$this->writeHTMLCell($w=97.6 ,$h=50,$x='',$y='',$foot,$border=0,$ln=0,$fill=0,$reseth=true,$align='',$autopadding=true);
			
		}public function Footer(){
			$l = Array();
			$l['a_meta_charset'] = 'UTF-8';
			$l['a_meta_dir'] = 'rtl';
			$l['a_meta_language'] = 'dejavusans';
			$l['w_page'] = 'page';
			$this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			$this->setLanguageArray($l);
			$this->setRTL(true);
			$this->setFontSubsetting(true);
			$this->SetFont('aealarabiya','',14,'',true);
			$this->setCellPaddings($left ='0',$top ='0',$right ='1',$bottom ='0');
			$foot = '<table><tr  style="line-height:25px;text-align:center; ">
				<th  rowspan="2"  style="width:90px; border: 1px solid black;">الفاتوره</th>
				<th  rowspan="2" style="width:90px;border: 1px solid black;">السابق</th>
				<th colspan="2" style="width:160px;border: 1px solid black;">الاجمالي</th></tr>
			<tr style="line-height:25px;text-align:center; ">
				<th style="border: 1px solid black;">مدين - عليه</th>
				<th style="border: 1px solid black;">دائن - له</th></tr>
			<tr style="line-height:25px;text-align:center; ">
				<th style="border: 1px solid black;">0</th>
				<th style="border: 1px solid black;">0</th>
				<th style="border: 1px solid black;">1000</th>
				<th style="border: 1px solid black;">0</th></tr></table>';
			$this->writeHTMLCell($w=97.6 ,$h=0,$x='',$y='',$foot,$border=0,$ln=0,$fill=0,$reseth=true,$align='',$autopadding=true);
			$this->writeHTMLCell($w=97.6 ,$h=0,$x='',$y='',$foot,$border=0,$ln=0,$fill=0,$reseth=true,$align='',$autopadding=true);
			$this->writeHTMLCell($w=97.6 ,$h=0,$x='',$y='',$foot,$border=0,$ln=0,$fill=0,$reseth=true,$align='',$autopadding=true);
		}
	}
    $pdf = new MYPDF('LANDSCAPE',PDF_UNIT,"RL",true,'UTF8',false);
	 $pdf->setcreator(PDF_CREATOR);
	 $pdf->setAuthor('Ahmed Ramadan');
	 $pdf->SetSubject('cas asca');
	 //$pdf->SetKeyword('asca');
	 //$pdf->SetHeaderData("Screenshot_1.png",'100','Hello '.'001',"cascas");

	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA,'',PDF_FONT_SIZE_DATA));
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	$pdf->SetMargins(2,33,2);
	$pdf->SetHeaderMargin(2);
	$pdf->SetFooterMargin(25);
	$pdf->SetAutoPageBreak(TRUE,30);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	
	$pdf->setLanguageArray($l);
	$pdf->setRTL(true);
	$pdf->setFontSubsetting(true);
	$pdf->SetFont('aealarabiya','',10,'',true);
	$pdf->AddPage();
	
	$Bod = '<table cellpadding="0" cellspacing="0" style="width:100%;table-layout:auto;border-collapse:auto">
			<tr style="width: auto;line-height:30px; text-align:center; border: 1px solid black;">    
				<th style="width:31px;white-space:nowrap;padding:2px;border: 1px solid black;" >#</th>
				<th style="width:130px;white-space:nowrap;padding:2px;border: 1px solid black;" >اسم المنتج</th>
				<th style="width:70px;white-space:nowrap;padding:2px;border: 1px solid black;">سعر الوحده</th>
				<th style="width:50px;white-space:nowrap;padding:2px;border: 1px solid black;">الخصم</th>
				<th style="width:60px;white-space:nowrap;padding:2px;border: 1px solid black;">الاجمالي</th>
			</tr>
			
			
			<tr style=" line-height:17px; text-align:center; border: 1px solid black;">    
				<td style= "white-space:nowrap;padding:2px;border: 1px solid black;line-height:250%" >1</td>
				<td style="white-space:nowrap;padding:2px;border: 1px solid black;" >كالهيبارين5000 وحده امبول *50.5 س ج</td>
				<td  style="white-space:nowrap;padding:2px;border: 1px solid black;line-height:250%">10</td>
				<td  style="white-space:nowrap;padding:2px;border: 1px solid black;line-height:250%">3</td>
				<td  style="white-space:nowrap;padding:2px;border: 1px solid black;line-height:250%">1000</td>
			</tr>	
			
		</table>';
	
	$pdf->writeHTMLCell($w=97.7 ,$h=10,$x='',$y='',$Bod,$border=0,$ln=0,$fill=0,$reseth=false,$align='',$autopadding=true);
	$pdf->writeHTMLCell($w=97.7 ,$h=10,$x='',$y='',$Bod,$border=0,$ln=0,$fill=0,$reseth=true,$align='',$autopadding=true);
	$pdf->writeHTMLCell($w=97.7 ,$h=10,$x='',$y='',$Bod,$border=0,$ln=0,$fill=0,$reseth=true,$align='',$autopadding=true);
	$pdf->Output('exap.pdf','I');
?>