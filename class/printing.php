<?php
// require('../media/FPDF/fpdf.php'); //use this if it is in the root directory of your system
require('../../media/FPDF/fpdf.php');

class PDF extends FPDF
{
	public $empno = '';
	public $empname = '';
	public $page_no_x = 10;
	public $page_no_y = 280;
	function place_values($value,$font,$ordinate){
		$this->SetAutoPageBreak(false);
		$this->SetFont('Arial', $font['weight'], $font['size']);
		$this->SetXY($ordinate['x'], $ordinate['y']);
		$this->Write( 0, $value);
		return $ordinate['y'];
	}
	function place_values_in_cell($value,$font,$ordinate){
		// $this->SetAutoPageBreak(false);
		if($ordinate['ordinate_y'] > 260) {
			$ordinate['y']  = 0;
			$this->SetXY($this->page_no_x, $this->page_no_y);	
			$this->Cell(0,0,'Appraisal of ['.$this->empno.'] '.$this->empname.' (Page '.$this->return_page_number() . '{totalPages})',0,0,'C');
			$this->add_page();
		}
		$this->SetFont($font['style'], $font['weight'], $font['size']);
		$this->SetXY($ordinate['x'], $ordinate['y']);		
		
		if(is_array($value)) {
			$additional_row = 5;
			for($x=0;$x<count($value);$x++){
				if($ordinate['y'] + $additional_row > 260) {
					$ordinate['y']  = 30;
					$additional_row = 0;
					$this->SetXY($this->page_no_x, $this->page_no_y);	
					$this->Cell(0,0,'Appraisal of ['.$this->empno.'] '.$this->empname.' (Page '.$this->return_page_number() . '{totalPages})',0,0,'C');
					$this->add_page();
				}
				$this->SetXY($ordinate['x'], $ordinate['y'] + $additional_row);	
				$this->Cell( 0, 0, $value[$x], 0, 0, $font['text_align'] );
				// $this->SetXY($ordinate['x'], $ordinate['y'] + $additional_row);	
				if(($x-1) != count($value)) {
					$additional_row += 5;
				}				
			}
		} else {
			$this->Cell( 0, 0, $value, 0, 0, $font['text_align'] );
		}
		if(isset($additional_row)) {
			$return['condition'] = true;
			$return['next_line'] = true;
			$return['ordinate_y'] = $ordinate['y'] + $additional_row;
			return $return;	
		}		
		return $ordinate['y'];
	}
	function place_values_in_table_td($value,$font,$ordinate,$fill){
		$this->SetAutoPageBreak(false);
		$this->SetFont($font['style'], $font['weight'], $font['size']);
		$this->SetXY($ordinate['x'], $ordinate['y']);
		$this->SetFillColor(224,235,255);
		if( is_array($value) ){
			$additional_row = 6;
			for($x=0;$x<count($value);$x++){
				if( ($ordinate['y'] + $additional_row) > 260 ) {
					$ordinate['y'] = 10;
					$additional_row = 6;
					$this->SetXY($this->page_no_x, $this->page_no_y);	
					$this->Cell(0,0,'Appraisal of ['.$this->empno.'] '.$this->empname.' (Page '.$this->return_page_number() . '{totalPages})',0,0,'C');
					$this->add_page();					
				}
				if($x==0){
					$this->Cell( 0, 6, $value[$x],0, 0, $font['text_align'],$fill);
				}else{
					$this->SetXY($ordinate['x'], ($ordinate['y']+$additional_row) );
					$this->Cell( 0, 6, $value[$x],0, 0, $font['text_align'],$fill);
					/* set fill for col 0 */
					$this->SetXY(13, ($ordinate['y']+$additional_row) );
					$this->Cell( 128, 6, '',0, 0, $font['text_align'],$fill);
					$additional_row += 6;
				}
			}
		}else{
			$this->Cell( 0, 6, $value,0, 0, $font['text_align'],$fill);
			// $this->MultiCell( 75, 6 , $value, 0, $font['text_align'],$fill );
		}
		return $ordinate['y'];
	}
	function place_values_multicell($value,$font,$ordinate){
		$this->SetAutoPageBreak(false);
		$this->SetFont($font['style'], $font['weight'], $font['size']);
		$this->SetXY($ordinate['x'], $ordinate['y']);
		$this->MultiCell( 50, 1 , $value, 0, $font['text_align'] );
		// $this->MultiCell( 200, 5 , $value, 0, $font['text_align'] ); // for word wrap :)
		return $ordinate['y'];
	}
	function place_values_multiline($label,$value,$font,$ordinate){
		/* breakdown per breakline */
		$array_values = explode("\n",$value);
		$additional_space = 5;

		for($x=0;$x<count($array_values);$x++){
			$this->SetAutoPageBreak(false);
			$this->SetFont('Arial', $font['weight'], $font['size']);
			if($x==0){
				if(strpos($array_values[$x],':') !== false){
					$this->SetFont('Arial', 'B', $font['size']);
				}
				$this->SetXY($ordinate['x'], $ordinate['y']);
			}else{
				$this->SetFont('Arial', $font['weight'], $font['size']);
				$this->SetXY($ordinate['x'], ($ordinate['y'] + $additional_space) );
				$additional_space += 4;
			}
			if(isset($label[$x]) && $label[$x] != ""){
				$this->cell( 23, 10, $label[$x]." : ",0 );
				if($x==0){
					$this->SetXY( ($ordinate['x']+25), ($ordinate['y']) );
				}else{
					$this->SetXY( ($ordinate['x']+25), ($ordinate['y'] + $additional_space-5) );
				}
				$this->cell( 23, 10, $array_values[$x],0 );
			}else{
				$this->write( 0, $array_values[$x]);
			}
			
		}
		return $ordinate['y'] + $additional_space;
	}
	
	function table_with_design($header, $data)
	{
		// $data = $this->LoadData($data);
		// Colors, line width and bold font
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('','B');
		// Header
		$w = array(0,10,10);
		for($i=0;$i<count($header);$i++) {
			$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
			$this->Ln();
		}
		$w = array(40, 35, 40);
		// Color and font restoration
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('');
		// Data
		$fill = false;
		for($i=0;$i<count($data);$i++)
		{
			$this->Cell($w[0],6,$data[$i][0],'LR',0,'L',$fill);
			$this->Cell($w[1],6,$data[$i][1],'LR',0,'L',$fill);
			$this->Cell($w[2],6,$data[$i][2],'LR',0,'L',$fill);
			// $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
			$this->Ln();
			$fill = !$fill;
		}
		// Closing line
		$this->Cell(array_sum($w),0,'','T');
	}
	
	function add_page(){
		$this->AddPage('P');
	}
	function return_page_number() {
		return $this->PageNo().' of '.$this->AliasNbPages('{totalPages}');
	}
	
}