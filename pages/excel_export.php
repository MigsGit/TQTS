<?php
$excel_class = '../class/excel.php';
if(file_exists($excel_class)){
	include($excel_class);
}else{
	echo 'File '.$excel_class.' does not exist';
	exit;
}

$excel = new EXCEL;
/* set title */
$excel->title = 'Expired Materials';
/* add a new page */
$excel->add_page();
/* use the default font style */
$excel->set_default_font_style();
/* select an active page */
$excel->set_active_sheet(0);

/* set width - Array Cells, Array Width */
// $array_cell = array('A','B','C','E');
// $array_width = array('20','20','20','20');
// $excel->set_width($array_cell,$array_width);

/* set height - Array Rows, Array Height */
// $array_row = array('2','3');
// $array_height = array(25,50);
// $excel->set_height($array_row,$array_height);

/* borders - Cell, Left, Right, Top, Bottom */
// $excel->set_borders('A2',1,1,1,1);
// $excel->set_borders('B2:B3',1,1,1,1);

/* place value - cell, value, type(string or blanl), alignment, wordwrap(true or false) */
// $excel->place_value('A1','450121212121212121212121','string','',true);

/* set font - cell, bold, color, size, style */
// $excel->set_font('A1',true,'',14,'Verdana');



/* set file name */
$filename = "sample";
/* output excel - filename, excel version (2003,2007) */
$excel->output($filename,'2007');
