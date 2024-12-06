<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// $parent_class = "../../media/PHPExcel.php";
$parent_class = "../../media/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php";
if(file_exists($parent_class)){
	include($parent_class); //call the parent class
} else{
	$parent_class = "../../../media/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php";
	if(file_exists($parent_class)){
		include($parent_class); //call the parent class
	} else{
		$parent_class = "../../../../media/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php";
		if(file_exists($parent_class)){
			include($parent_class); //call the parent class
		} else{
			echo 'file '.$parent_class.' does not exist!';
			exit;
		}	
	}	
}
	
class EXCEL extends PHPExcel{
	public $title = '';
	public $objPHPExcel = '';
	public $objDrawing = '';
	/* 
		create new phpexcel page
	*/
	public function add_page(){
		$this->objPHPExcel = $this->getActiveSheet();
		$this->objPHPExcel->setTitle($this->title); //set title cont.
	}
	
	public function add_row($num_row){
		$this->objPHPExcel = $this->getActiveSheet();
		// $num_row = $this->objPHPExcel->getHighestRow();
		// $this->objPHPExcel->insertNewRowBefore($num_row + 1, 2);
		$this->objPHPExcel->insertNewRowBefore(8, 2);
	}
	public function set_page_orientation_a4_landscape(){
		$this->objPHPExcel->getPageSetup()
			->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$this->objPHPExcel->getPageSetup()
			->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
	}
	
	/* 
		Set default font style
	*/
	public function set_default_font_style(){
		$this->getDefaultStyle()->getFont()->setName('Arial');
	}
	/* 
		Set Margin
	*/
	public function set_margin(){
		$this->objPHPExcel->getPageMargins()
		->setTop(0.40)
		->setRight(0.27)
		->setLeft(0.31)
		->setBottom(0.45);
	}
	public function set_margin_dynamic($top,$right,$left,$bottom){
		$this->objPHPExcel->getPageMargins()
		->setTop($top)
		->setRight($right)
		->setLeft($left)
		->setBottom($bottom);
	}
	/* 
		set print area 
	*/
	public function set_print_area(){
		$this->objPHPExcel->getPageSetup()
					->setPrintArea('A2:K74');
	}
	public function setPrintFitToWidth()
	{
		$this->objPHPExcel->getPageSetup()->setFitToWidth(1);    
		$this->objPHPExcel->getPageSetup()->setFitToHeight(0);    
	}
	
	public function set_print_area_dynamic($cell){
		$this->objPHPExcel->getPageSetup()
					->setPrintArea($cell);
	}
	
	public function set_page_break($cell){
		$this->objPHPExcel->setBreak( 'A10' , PHPExcel_Worksheet::BREAK_ROW );
	}
	/*  
		Set active sheet
	*/
	public function set_active_sheet($sheet_number){
		$this->setActiveSheetIndex($sheet_number);
	}
	/* 
		Create new sheet
	*/
	public function add_sheet($index){
		$this->createSheet($index);
		$this->set_active_sheet($index);
		$this->objPHPExcel = $this->getActiveSheet();
		$this->objPHPExcel->setTitle($this->title); //set title cont.
	}
	/* 
		Set cell width
	*/
	public function set_width($cell,$width){
		$this->objPHPExcel->getColumnDimension($cell)->setWidth($width);
	}
	/* 
		Set height
	*/
	public function set_height($row,$height){
		$this->objPHPExcel->getRowDimension($row)->setRowHeight($height);
	}
	/* 
		Set borders
	*/
	public function set_borders($cell,$left,$right,$top,$bottom,$border_style){
		if(!isset($border_style)){
			$border_style = "";
		}
		if($border_style == "thin"){
			$default_border = PHPExcel_Style_Border::BORDER_THIN;
		}else if($border_style == "medium"){
			$default_border = PHPExcel_Style_Border::BORDER_MEDIUM;
		}else if($border_style == "thick"){
			$default_border = PHPExcel_Style_Border::BORDER_THICK;
		}else if($border_style == "double"){
			$default_border = PHPExcel_Style_Border::BORDER_DOUBLE;
		}else{
			$default_border = PHPExcel_Style_Border::BORDER_THIN;
		}
		
		if($left == '1' && $right == '1' && $top == '1' && $bottom == '1'){
			$styleArray = array(
			  'borders' => array(
				'allborders' => array(
				  'style' => $default_border,
				)
			  )
			);
			$this->objPHPExcel->getStyle($cell)->applyFromArray($styleArray);
		}else{
			if($left == '1'){
				$left_border = array(
				  'borders' => array(
					'left' => array(
						  'style' => $default_border,
						)
					)
				);
				$this->objPHPExcel->getStyle($cell)->applyFromArray($left_border);
			}
			if($right == '1'){
				$right_border = array(
				  'borders' => array(
					'right' => array(
						  'style' => $default_border,
						)
					)
				);
				$this->objPHPExcel->getStyle($cell)->applyFromArray($right_border);
			}
			if($top == '1'){
				$top_border = array(
				  'borders' => array(
					'top' => array(
						  'style' => $default_border,
						)
					)
				);
				$this->objPHPExcel->getStyle($cell)->applyFromArray($top_border);
			}
			if($bottom == '1'){
				$bottom_border = array(
				  'borders' => array(
					'bottom' => array(
						  'style' => $default_border,
						)
					)
				);
				$this->objPHPExcel->getStyle($cell)->applyFromArray($bottom_border);
			}
		}
	}
	
	public function set_outline_borders($cell,$border_style, $color){
		if($border_style == "thin"){
			$default_border = PHPExcel_Style_Border::BORDER_THIN;
		}else if($border_style == "medium"){
			$default_border = PHPExcel_Style_Border::BORDER_MEDIUM;
		}else{
			$default_border = PHPExcel_Style_Border::BORDER_THICK;
		}
		$styleArray = array(
		  'borders' => array(
			'outline' => array(
			  'style' => $default_border,
			  'color' => array('rgb' => $color)
			)
		  )
		);
		$this->objPHPExcel->getStyle($cell)->applyFromArray($styleArray);
	}
	/* 
		merge cells
	*/
	public function merge_cells($cell){
		$this->objPHPExcel->mergeCells($cell);
	}
	/* 
		set font 
	*/
	public function set_font($cell,$bold,$italic,$color,$background_color,$size,$font){
		if(!$bold){
			$bold = false;
		}
		if(!$italic){
			$italic = false;
		}
		if($color == ''){
			$color = '';
		}
		if($background_color != ''){
			$background_type = PHPExcel_Style_Fill::FILL_SOLID;
		}else{
			$background_color 	= '';
			$background_type	= '';
		}
		if($size == ''){
			$size = '11';
		}
		if($font == ''){
			$font = 'Arial';
		}
		$styleArray = array(
			'font'  => array(
				'bold'   => $bold,
				'italic' => $italic,
				'color'  => array('rgb' => $color),
				'size'   => $size,
				'name'   => $font
			)
			,'fill' => array(
					'type' => $background_type,
					'color' => array('rgb' => $background_color)
			)
		);
		$this->objPHPExcel->getStyle($cell)->applyFromArray($styleArray);
	}
	/* 
		place values
	*/
	public function place_value($cell,$value,$data_type){

		if(!isset($data_type)){
			$data_type = '';
		}
		if(isset($data_type) && $data_type == 'string'){
			if($value == 'N/A' || $value == ''){ //return date if value exist
				$this->objPHPExcel->setCellValueExplicit($cell, 'N/A', PHPExcel_Cell_DataType::TYPE_STRING);
			}else{
				$this->objPHPExcel->setCellValueExplicit($cell, $value, PHPExcel_Cell_DataType::TYPE_STRING);
			}
		}else if($data_type == 'number_2_decimal'){
			$this->objPHPExcel->getCell($cell)->setValue($value);
			$this->objPHPExcel->getStyle($cell)->getNumberFormat()->setFormatCode('0.00');
		}else if($data_type == 'number_0_decimal'){
			$this->objPHPExcel->getCell($cell)->setValue($value);
			$this->objPHPExcel->getStyle($cell)->getNumberFormat()->setFormatCode('0');
		}else if($data_type == 'percentage_0_decimal'){
			$this->objPHPExcel->getCell($cell)->setValue($value);
			$this->objPHPExcel->getStyle($cell)->getNumberFormat()->setFormatCode('0');
			$style_array_percentage = array( 
												'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE
											);
			$this->objPHPExcel->getStyle($cell)->getNumberFormat()->applyFromArray( $style_array_percentage );
		}else if($data_type == 'percentage_2_decimal'){
			$this->objPHPExcel->getCell($cell)->setValue($value);
			$this->objPHPExcel->getStyle($cell)->getNumberFormat()->setFormatCode('0');
			$style_array_percentage = array( 
												'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
											);
			$this->objPHPExcel->getStyle($cell)->getNumberFormat()->applyFromArray( $style_array_percentage );
		}else if($data_type == 'date_format'){
			if($value == 'N/A' || $value == ''){ //return date if value exist
				$this->objPHPExcel->setCellValueExplicit($cell, $value, PHPExcel_Cell_DataType::TYPE_STRING);
			}else{//return string if value not exist
				$timestamp = PHPExcel_Shared_Date::PHPToExcel(strtotime($value));
				// Set the cell value as the timestamp
				$this->objPHPExcel->setCellValue($cell, $timestamp);
				$this->objPHPExcel->getStyle($cell);
				// $this->objPHPExcel->getStyle($cell)->getNumberFormat()->setFormatCode('dd-mmm-yy');
			}
			// if($value != ''){ //return date if value exist
			// 	$timestamp = PHPExcel_Shared_Date::PHPToExcel(strtotime($value));
			// 	// Set the cell value as the timestamp
			// 	$this->objPHPExcel->setCellValue($cell, $timestamp);
			// 	$this->objPHPExcel->getStyle($cell)->getNumberFormat()->setFormatCode('dd-mmm-yy');
			// }else{//return string if value not exist
			// 	$this->objPHPExcel->setCellValueExplicit($cell, $value, PHPExcel_Cell_DataType::TYPE_STRING);
			// }
			
		}
		else{
			$this->objPHPExcel->getCell($cell)->setValue($value);
		}
	}
	
	public function set_format($cell,$array_format){
		$array_font = array();
		$array_fill = array();
		$array_alignment = array();
		$array_format_code = array();
		/********************
		* 		FONT 		*
		********************/
		/* font style */
		if(isset($array_format['name']) && $array_format['name'] != ''){
			$name = $array_format['name'];
		}else{
			$name = "Arial";
		}
		$array_font['name'] = $name;
		/* font size */
		if(isset($array_format['size']) && $array_format['size'] != ''){
			$size = $array_format['size'];
		}else{
			$size = 10;
		}
		$array_font['size'] = $size;
		/* bold */
		if(isset($array_format['bold']) && $array_format['bold'] != '' && $array_format['bold'] != false){
			$bold = $array_format['bold'];
		}else{
			$bold = false;
		}
		$array_font['bold'] = $bold;
		/* italic */
		if(isset($array_format['italic']) && $array_format['italic'] != '' && $array_format['italic'] != false){
			$italic = $array_format['italic'];
		}else{
			$italic = false;
		}
		$array_font['italic'] = $italic;
		/* color */
		if(isset($array_format['color']) && $array_format['color'] != ''){
			$color = $array_format['color'];
		}else{
			$color = '000000';
		}
		$array_font['color'] = array('rgb' => $color);
		/********************
		* 		FILL 		*
		********************/
		/* fill_color */
		if(isset($array_format['fill_color']) && $array_format['fill_color'] != ''){
			$color = $array_format['fill_color'];
			$type = PHPExcel_Style_Fill::FILL_SOLID;
			$array_fill['type'] = $type;
			$array_fill['color'] = array('rgb' => $color);
		}else{
			$color = '';
			$type = '';
		}		
		
		/********************
		* 	  ALIGNMENT	   	*
		********************/
		/* alignment */
		if(isset($array_format['h_alignment']) && $array_format['h_alignment'] != ''){
			switch($array_format['h_alignment']){
				case "left" 	: $horizontal = PHPExcel_Style_Alignment::HORIZONTAL_LEFT; break;
				case "right"	: $horizontal = PHPExcel_Style_Alignment::HORIZONTAL_RIGHT; break;
				case "center"	: $horizontal = PHPExcel_Style_Alignment::HORIZONTAL_CENTER; break;
			}
		}else{
			// $horizontal = PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
			$horizontal = '';
		}
		if(isset($array_format['wordwrap']) && $array_format['wordwrap'] != '' && $array_format['wordwrap'] != false){
			$wordwrap = true;
		}else{
			$wordwrap = false;
		}
		$array_alignment['horizontal'] 	= $horizontal;
		$array_alignment['vertical'] 	= PHPExcel_Style_Alignment::VERTICAL_CENTER;
		$array_alignment['wrap'] 		= $wordwrap;
		
		/********************
		* 	ARRAY STYLE	*
		********************/
		$styleArray = array(
			 'font'  => $array_font
			,'fill' => $array_fill
			,'alignment' => $array_alignment
		);
		$this->objPHPExcel->getStyle($cell)->applyFromArray($styleArray);
	}
	/*
		wrape text
	*/
	public function wrap_text($cell){
		$this->objPHPExcel->getStyle($cell)->getAlignment()->setWrapText(true);
	}
	/* 
		
	*/
	public function add_image($ordinate,$image,$height){
		$this->objDrawing = new PHPExcel_Worksheet_Drawing();
		$this->objDrawing->setWorksheet( $this->getActiveSheet() );
		$this->objDrawing->setPath($image);
		$this->objDrawing->setCoordinates($ordinate);
		if($height != ""){
			$this->objDrawing->setHeight($height);
		}
		$this->objDrawing->setOffsetX(20);
		$this->objDrawing->setOffsetY(20);
	}
	
	
	/* 
		Generate Excel Output 
	*/
	public function output($filename, $file_type){
		if($file_type == "2007"){
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename='.$filename.'.xlsx'); //used for excel 2007 format
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($this, 'Excel2007'); //used for excel 2007 format
		}else if($file_type == "2003"){
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename='.$filename.'.xls'); // used for excel 2003 format
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($this, 'Excel5'); // used for excel 2003 format
		}else{
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename='.$filename.'.xlsx'); //used for excel 2007 format
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($this, 'Excel2007'); //used for excel 2007 format
		}
//		ob_end_clean();
        if (ob_get_contents()) ob_end_clean();
		$objWriter->save('php://output');
	}
}
?>