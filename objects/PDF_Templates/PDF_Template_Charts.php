<?php

// require('fpdf/fpdf.php');		// local: require('fpdf.php');

/**
 * @package objects/PDF_Templates
 */ 
/**
 * class PDF_Template_Charts
 * <pre> 
 * This page is a rough template that allows a user to add charts to a PDF document
 * TODO: allow this class to create its own document with charts (easy to implement)
 * </pre>
 * @author  Hobbe Smit
 * Date:   14 Dec 2007
 */
 // RAD Tools: FormSingleEntry Page
class  PDF_Template_Charts {
	
	// CONSTANTS:
	const LINE_SPACING = 12;		// the # of units between lines/objects 
// 	const LABEL_HEIGHT = 30;		// the height of the legend label cells
 	const LEGEND_DIMENSION = 15;		// the width/height of the legend color boxes

	//VARIABLES:
	/* [OBJECT] the PDF object */
	protected $pdf;	
	
	/* [STRING] the file path */
	protected $file_path;
	
	/* [INTEGER] The page type currently being used */
	protected $page_type;
	
	/* [INTEGER] The page width */
	protected $page_width;	
	
	/* [INTEGER] The page height */
	protected $page_height;	
		
	/* [INTEGER] the # of pixels used to shift table down and right */
	protected $page_margin;
	
	/* [ARRAY] The array of column widths (with integer indices and index 0 having value = 0) */
	protected $column_widths;	
	
	/* [INTEGER] the # of pixels used for each row's height */
	protected $row_height;
	
	/* [INTEGER] the # of data rows on a PDF page */
	protected $page_data_rows;
	
	/* [STRING] The default link name used with URL data **/
	protected $default_link_name;
	
	/* [STRING] The heading font */
	protected $heading_font;
	protected $heading_font_style;
	protected $heading_font_size;	
	
	/* [STRING] The legend label font */
	protected $label_font;
	protected $label_font_style;
	protected $label_font_size;			

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the object.
	 * </pre>
	 * @param $filePath [STRING] The filepath to the existing or to-be-created PDF file
	 * @param $page_margin [INTEGER] The number of pixels from the top and left that table is displaced by
	 * @param $column_widths [ARRAY] The array of column widths (with integer indices and index 0 having value = 0)
	 *											(index 1 represent width of column 1, etc.; keep in mind that pagetype restricts total width available)
	 * @param $default_link_name [STRING] The title given to URL data that doesn't come with a link title
	 * @param $row_height [INTEGER] Specify the row height in pixels (DEFAULT = 20)
	 * @param $page_type [INTEGER] Specify the page type, using a constant value	 (DEFAULT = letter-size)
	 * @return [void]
	 */
//     function __construct($filePath, $page_margin, $column_widths, $default_link_name = '', $row_height = 20, $page_type = PDF::PAGETYPE_LETTER) 
//     {
// 	    $this->file_path = $filePath;

// 		// Set page dimensions based on choice
// 		$pageType_param = '';
// 		switch($this->page_type)
// 		{
// 			case PDF::PAGETYPE_A4:
// 				$this->page_width = PDF::PAGEWIDTH_A4;
// 				$this->page_height = PDF::PAGEHEIGHT_A4;
// 				$pageType_param = 'A4';
// 				break;
// 				
// 			case PDF::PAGETYPE_LEGAL:
// 				$this->page_width = PDF::PAGEWIDTH_LEGAL;
// 				$this->page_height = PDF::PAGEHEIGHT_LEGAL;
// 				$pageType_param = 'Legal';
// 				break;
// 				
// 			case PDF::PAGETYPE_LETTER:
// 			default:
// 				$this->page_width = PDF::PAGEWIDTH_LETTER;
// 				$this->page_height = PDF::PAGEHEIGHT_LETTER;
// 				$pageType_param = 'Letter';
// 				break;
// 		}	

// 		// Create handle for new PDF document
// 		$this->pdf = new PDF('P','pt',$pageType_param);	//FPDF
// 		
// 		// Set general document information
// 		$this->pdf->SetAuthor( "Author" );
// 		$this->pdf->SetTitle("Title");
// 		$this->pdf->SetCreator("Creator");
// 		$this->pdf->SetSubject("Subject");		
// 		
// 		
// 		$this->page_type = $page_type;		
// 		$this->page_margin = $page_margin;
// 		
// 		$this->column_widths = $column_widths;
// 		$this->row_height = $row_height;
// 		
// 		$this->default_link_name = $default_link_name;			
// 				
// 		// Start a new page
//  		$this->pdf->AddPage();

// 		// Set the basic font
// 		$this->pdf->SetFont(PDF::FONT_HELVETICA,'B',10);

// 		// Set the text colour
//  		$this->pdf->SetTextColor(0, 0, 0);
// 	}
	
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the object.
	 * </pre>
	 * @param $pdf [OBJECT] An existing PDF object to add to
	 * @return [void]
	 */
	 function __construct($pdf)
	 {
		 $this->pdf = $pdf;
		 $this->pdf->AddPage();	
		 
		 // set heading font
		 $this->heading_font = PDF::FONT_ARIAL;
		 $this->heading_font_style = PDF::FONTSTYLE_BOLD.PDF::FONTSTYLE_ITALIC.PDF::FONTSTYLE_UNDERLINE;
		 $this->heading_font_size = 12;
		 
		 // set legend label font
		 $this->label_font = PDF::FONT_ARIAL;
		 $this->label_font_style = PDF::FONTSTYLE_PLAIN;
		 $this->label_font_size = 10;		 
	 }
	 
	 // TODO: create set() methods for setting font specs for heading and labels
	 
	 /**
	   function createPieChart
	   title: the title of the chart
		width: maximum width of the diagram.
		height: maximum height of the diagram.
		data: associative array containing the labels and the corresponding data.
		format: format used to display the legends. It is a string which can contain the following special values: %l (label), %v (value) and %p (percentage).
		colors: array containing the colors. If not given, a grayscale will be used.
	  **/
	 function createPieChart($title, $chart_width, $chart_height, $data, $format='%l (%p)')	//, $colors='')
	 {
		//$data = array('Men' => 1010, 'Women' => 1610, 'Children' => 600);

		$this->pdf->SetFont($this->heading_font, $this->heading_font_style, $this->heading_font_size);
		$this->pdf->Cell(0, $this->heading_font_size, $title, 0, 1);	// w = to right margin, h = 5, title, no border, cursor to next line
		$this->pdf->Ln(PDF_Template_Charts::LINE_SPACING);

		$this->pdf->SetFont($this->label_font, $this->label_font_style, $this->label_font_size);
		$valX = $this->pdf->GetX();
		$valY = $this->pdf->GetY();
		
// 		echo 'valX, valY = '.$valX.', '.$valY;
		
// 		// find max label width
// 		$label_width = 0;
// 		$label_array = explode(',', $labels);
// 		foreach( array_keys($label_array) as $k )
// 		{
// 			$record = current($label_array);
// 			$width = strlen($record;			
// 			
// 			if ($width > $label_width)
// 			{
// 				$label_width = $width;
// 			}
// 		}
		
// 		
// 		$this->pdf->Cell($label_width, $this->label_font_size, 'Number of men:');
// 		$this->pdf->SetXY($valX + 100, $valY);
// 		$this->pdf->Cell(15, 5, $data['Men'], 0, 0, 'R');
// 		$this->pdf->Ln(PDF_Template_Charts::LINE_SPACING);
// 		$this->pdf->Cell(30, 5, 'Number of women:');
// 		$this->pdf->SetXY($valX + $chart_width, $valY + 12);
// 		$this->pdf->Cell(15, 5, $data['Women'], 0, 0, 'R');
// 		$this->pdf->Ln(PDF_Template_Charts::LINE_SPACING);
// 		$this->pdf->Cell(30, 5, 'Number of children:');
// 		$this->pdf->SetXY($valX + $chart_width, $valY + 24);
// 		$this->pdf->Cell(15, 5, $data['Children'], 0, 0, 'R');
// 		$this->pdf->Ln(PDF_Template_Charts::LINE_SPACING);
// 		$this->pdf->Ln(PDF_Template_Charts::LINE_SPACING);

		$this->pdf->SetXY(302, 370);
		
// 		if ($colors == '')
// 		{
// 			$colour1=array(100,100,255);	
// 			$colour2=array(255,100,100);
// 			$colour3=array(255,255,100);			
// 		}

		$colours = array();
		$numColours = count($data);
		for ($i=0; $i < $numColours; $i++)
		{
			$colour = $this->getColourTriple($i);	//$this->randomTriple();
// 			echo 'color = <pre>'.print_r($colour,true).'</pre>';
			$colours[$i] = $colour;
		}

		$this->pdf->sum = array_sum($data);
// 		echo 'sum = '.$this->pdf->sum;
		$this->pdf->PieChart($chart_width, $chart_height, $data, '%l (%p)', $colours);
	}
	
	// thanks to php at capuzza dot net   from   http://ca.php.net/manual/en/function.srand.php
	// NOTE: this method takes too long to be efficient
	protected function randomTriple()
	{
		$randomTriple = array();
		list($usec, $sec) = explode(" ", microtime());
		srand((int)($usec*10));
		$rand_value = rand(0, 255);
		//echo($rand_value."<br>");
		$randomTriple[0] = ($rand_value/10)*10;
		
		$foo=file_get_contents
		("http://www.google.com/search?q=search+term+does+not+matter&hl=en");
		list($usec, $sec) = explode(" ", microtime());
		srand((int)($usec*10));
		$rand_value = rand(0, 255);
// 		echo($rand_value."<br>");
		$randomTriple[1] = ($rand_value/10)*10;
		
		$foo=file_get_contents
		("http://www.google.com/search?q=sea
		rch+term+still+does+not+matter&hl=en");
		list($usec, $sec) = explode(" ", microtime());
		srand((int)($usec*10));
		$rand_value = rand(0, 255);
// 		echo($rand_value."<br>");
		$randomTriple[2] = ($rand_value/10)*10;
		
		return $randomTriple;
	}
	
	
	// Systematically use colours (spacing them by $COLOR_DIFF)
	protected function getColourTriple($iteration)
	{
		$BASE_COLOR = 225;
		$COLOR_DIFF = 15;
		$colourTriple = array();
		$roundTotal = 12;
		if ($iteration < $roundTotal)	// pattern 1
		{
			$colourTriple[0] = $BASE_COLOR - ($iteration*$COLOR_DIFF);
			$colourTriple[1] = $BASE_COLOR - ($iteration*$COLOR_DIFF);
			$colourTriple[2] = 0;
		}
		else 
		if ($iteration < $roundTotal*2)	// pattern 2
		{
			$decrement = $iteration - $roundTotal;
			$colourTriple[0] = 0;
			$colourTriple[1] = $BASE_COLOR - ($decrement*$COLOR_DIFF);
			$colourTriple[2] = $BASE_COLOR - ($decrement*$COLOR_DIFF);	
		}
		else if ($iteration < $roundTotal*3)	// pattern 3 	
		{
			$decrement = $iteration - $roundTotal*2;
			$colourTriple[0] = $BASE_COLOR - ($decrement*$COLOR_DIFF);
			$colourTriple[1] = 0;
			$colourTriple[2] = $BASE_COLOR - ($decrement*$COLOR_DIFF);		
		}
		else if ($iteration < $roundTotal*4)	// pattern 4 				
		{
			$decrement = $iteration - $roundTotal*3;
			$colourTriple[0] = $BASE_COLOR - ($decrement*$COLOR_DIFF);
			$colourTriple[1] = $BASE_COLOR - ($decrement*$COLOR_DIFF);
			$colourTriple[2] = 255;		
		}
		else if ($iteration < $roundTotal*5)	// pattern 5
		{
			$decrement = $iteration - $roundTotal*4;
			$colourTriple[0] = 255;
			$colourTriple[1] = $BASE_COLOR - ($decrement*$COLOR_DIFF);
			$colourTriple[2] = $BASE_COLOR - ($decrement*$COLOR_DIFF);	
		}
		else if ($iteration < $roundTotal*6)	// pattern 6 	
		{
			$decrement = $iteration - $roundTotal*5;
			$colourTriple[0] = $BASE_COLOR - ($decrement*$COLOR_DIFF);
			$colourTriple[1] = 255;
			$colourTriple[2] = $BASE_COLOR - ($decrement*$COLOR_DIFF);		
		}
		else if ($iteration < $roundTotal*7)	// pattern 6 	
		{
			$decrement = $iteration - $roundTotal*6;
			$colourTriple[0] = $BASE_COLOR - ($decrement*$COLOR_DIFF);
			$colourTriple[1] = $BASE_COLOR - ($decrement*$COLOR_DIFF);
			$colourTriple[2] = $BASE_COLOR - ($decrement*$COLOR_DIFF);		
		}
		
		return $colourTriple;
	}	
		
		
// //Bar diagram
// $this->pdf->SetFont('Arial', 'BIU', 12);
// $this->pdf->Cell(0, 5, '2 - Bar diagram', 0, 1);
// $this->pdf->Ln(8);
// $valX = $this->pdf->GetX();
// $valY = $this->pdf->GetY();
// $this->pdf->BarDiagram(190, 70, $data, '%l : %v (%p)', array(255,175,100));
// $this->pdf->SetXY($valX, $valY + 80);

}

?>