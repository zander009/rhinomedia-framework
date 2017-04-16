<?php 

/*
	Note: you need to have DOMpdf on your library

	Usage Report::generate();
	- you can still used this with or without params

	$pdf = new Report();

	$pdf->header("Header");
	$pdf->heading("heading");
	$pdf->body("body");
	$pdf->footer("footer");
	$pdf->generate("My Document");
*/

use Dompdf\Dompdf;

class Report{

	private $_header, $_heading, $_body, $_footer;

	public function generate($document_title = '', $size = '', $setting = '', $font = ''){

		$template = self::baseTemplate();

		$document_title = (empty($document_title)) ? 'PDF Report' : $document_title;
		$template = (empty($template)) ? 'Sample Text' : $template;
		$size =  (empty($size)) ? 'A4' : $size;
		$setting = (empty($setting)) ? 'portrait' : $setting;
		$font = (empty($font)) ? 'Inconsolata' : $font;


		$dompdf = new Dompdf();
		$dompdf->set_option('defaultFont', $font);
		$dompdf->loadHtml($template[0] . $template[1] . $template[2] . $template[3]);

		// Size of the Paper we want to achieve
		$dompdf->setPaper($size, $setting);
		// Rendering part 
		$dompdf->render();
		// After rendering we need to output the result
		$pdf = $dompdf->output();
		// This is the title of the document
		$dompdf->stream($document_title);
	}

	public function header($header){
		return $this->_header = $header;
	}

	public function getHeader(){
		return $this->_header;
	}

	public function heading($heading){
		return $this->_heading = $heading;
	}

	public function getHeading(){
		return $this->_heading;
	}

	public function body($body){
		return $this->_body = $body;
	}

	public function getBody(){
		return $this->_body;
	}

	public function footer($footer){
		return $this->_footer = $footer;
	}

	public function getFooter(){
		return $this->_footer;
	}

	public function baseTemplate(){
		return [self::getHeader(), self::getHeading(), self::getBody(), self::getFooter()];
	}

}