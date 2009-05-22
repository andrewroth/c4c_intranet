<?php

// require('fpdf/fpdf.php');		// local: require('fpdf.php');

/**
 * @package objects/PDF_Templates
 */ 
/**
 * class PDF_Template_Table
 * <pre> 
 * This page is a rough template that allows a user to create and populate a table displayed in a PDF document.
 * </pre>
 * @author  Hobbe Smit
 * Date:   05 Dec 2007
 */
 // RAD Tools: FormSingleEntry Page
class  PDF_Template_Table {
	// NOTE: all constants found in PDF.php

		
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
	
	/* [BOOLEAN] Indicates whether table has been created (for current page) */
	protected $is_table_created = false;	
	
	/* [BOOLEAN] Indicates whether page has been ended */
	protected $is_page_ended = false;
	
	/* [BOOLEAN] Indicates whether file object has been closed */
	protected $is_file_closed = false;	
	
	/* [STRING] The default link name used with URL data **/
	protected $default_link_name;
		

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
    function __construct($filePath, $page_margin, $column_widths, $default_link_name = '', $row_height = 20, $page_type = PDF::PAGETYPE_LETTER) 
    {
	    $this->file_path = $filePath;

		// Set page dimensions based on choice
		$pageType_param = '';
		switch($this->page_type)
		{
			case PDF::PAGETYPE_A4:
				$this->page_width = PDF::PAGEWIDTH_A4;
				$this->page_height = PDF::PAGEHEIGHT_A4;
				$pageType_param = 'A4';
				break;
				
			case PDF::PAGETYPE_LEGAL:
				$this->page_width = PDF::PAGEWIDTH_LEGAL;
				$this->page_height = PDF::PAGEHEIGHT_LEGAL;
				$pageType_param = 'Legal';
				break;
				
			case PDF::PAGETYPE_LETTER:
			default:
				$this->page_width = PDF::PAGEWIDTH_LETTER;
				$this->page_height = PDF::PAGEHEIGHT_LETTER;
				$pageType_param = 'Letter';
				break;
		}	

		// Create handle for new PDF document
		$this->pdf = new PDF('P','pt',$pageType_param);	//FPDF
		
		// Set general document information
		$this->pdf->SetAuthor( "Author" );
		$this->pdf->SetTitle("Title");
		$this->pdf->SetCreator("Creator");
		$this->pdf->SetSubject("Subject");		
		
		
		$this->page_type = $page_type;		
		$this->page_margin = $page_margin;
		
		$this->column_widths = $column_widths;
		$this->row_height = $row_height;
		
		$this->default_link_name = $default_link_name;			
				
		// Start a new page
 		$this->pdf->AddPage();

		// Set the basic font
		$this->pdf->SetFont(PDF::FONT_HELVETICA,'B',10);

		// Set the text colour
 		$this->pdf->SetTextColor(0, 0, 0);
 		
 		// TEST DATA
//  		$this->pdf->setXY(10,100);
// 		$this->pdf->Write(5,'not!');
	}
	
	/**
	 * function generateTable
	 * <pre>
	 * Generate the table in the PDF
	 * </pre>	
	 * @param [BOOLEAN] $endPage   whether this action is the last for this page
	 * @param [BOOLEAN] $closeFile   whether this action is the last for this document (close the object)	 
	 * @return [void]
	 */
	function generateTable($endPage=false, $closeFile=false) {
		
		$pageRows = -1;	// Set to -1 since # of lines is 1 more than number of rows
		// TODO: add a restriction parameter that restricts # of rows

		// set columns of the table
		$SHIFT = $this->page_margin;	// number of pixels to shift table down and right
// 		$LINE_WIDTH = 1;
		$bottomTrim = 0;		// the amount to trim the table by from the bottom of the page
		$inc=$this->column_widths;	// TODO?: check to ensure that the array has been set and is in proper format
		$lastIndex=count($inc)-1;
		$counter = 0;

		$bottomTrim = ($this->page_height-$SHIFT) % $this->row_height;
	
		// draw vertical lines (move along X axis)
		for ($x=$SHIFT; $x<=$this->page_width; $x+=$inc[$counter])
		{
			$this->pdf->Line($x, $SHIFT*2+$bottomTrim, $x, $this->page_height-$SHIFT);	// DEC 13: added *2 to the first SHIFT
			 
			// do not increment the counter if last index reached
			// i.e. use last width as default for the remaining columns
			if ($counter != $lastIndex)
			{
				$counter++;
			} 
		}
		
		// draw horizontal lines (move along Y axis): leaving room for headings and totals (2 rows)
		for ($y=$this->page_height-$SHIFT; $y>=$SHIFT*2; $y-=$this->row_height)
		{
		 $this->pdf->Line($SHIFT, $y, array_sum($inc)+$SHIFT, $y);
		 $pageRows++;
		} 
		$this->page_data_rows = $pageRows;
		
		// Set table creation flag
		$this->is_table_created = true;
		
		// end page
// 		if ($endPage == true)
// 		{		
// 			pdf_end_page($this->pdf);
// 			$this->is_page_ended = true;
// 			$this->is_table_created = false;
// 		}
// 		
// 		// close and save file
// 		if ($closeFile == true)
// 		{		
// 			pdf_close($this->pdf); 
// 			$this->is_file_closed = true;
// 		}
	}
	
	/**
	 * function fillTable
	 * <pre>
	 * Fill the table in the PDF
	 * </pre>	
	 * @param [ARRAY] $headings	an array containing headings; array size must == column_widths size
	 * @param [ARRAY] $totals		an array storing the totals for the value columns	 
	 * @param [ARRAY] $values		an array of arrays storing values for some number of rows
	 * @param [BOOLEAN] $endPage   whether this action is the last for this page
	 * @param [BOOLEAN] $closeFile   whether this action is the last for this document (close the object)	 
	 * @return [void]
	 */
	function fillTable($headings, $totals, $values, $endPage=false, $closeFile=false) {
		
// 		echo "page rows = ".$this->page_data_rows;
		
		// ensure that it is safe to proceed with filling the table
		if (($this->is_page_ended == false)&&($this->is_file_closed == false)&&($this->is_table_created == true)) {

			// set columns of the table
			$SHIFT = $this->page_margin;	// number of pixels to shift table down and right

			$inc=$this->column_widths;	// TODO?: check to ensure that the array has been set and is in proper format
			$lastIndex=count($inc)-1;
// 			$counter = 0;
// 		
// 			// Add table headings (move along X axis)
// 			$heading_y = ($this->page_height-$SHIFT) - $this->row_height;
// 			for ($x=$SHIFT; $x<=$this->page_width; $x+=$inc[$counter])
// 			{
// 	 
// 				// do not increment the counter if last index reached
// 				// i.e. use last width as default for the remaining columns
// 				if ($counter != $lastIndex)
// 				{
// 					pdf_show_xy($this->pdf, $headings[$counter], $x + PDF::WRITE_SHIFT, $heading_y + PDF::WRITE_SHIFT);
// 					$counter++;
// 				} 
// 			}

			$this->setColumnHeaders($headings);	
			$this->setColumnTotals($totals);
			
					// Change font-type from Bold to Plain
			$this->setFont(PDF::FONT_HELVETICA, '', 10);						
			
			// Add table data (move along Y-axis, then along X axis for each Y-axis increment)
			reset($values);
			$row = 0;
// 			$second_row_y = ($this->page_height-$SHIFT) - $this->row_height;
// 			for ($y=$second_row_y; $y>=$SHIFT; $y-=$this->row_height)
			$third_row_y = ($this->row_height)*2;
			for ($y=$third_row_y; $y<=$this->page_height-$SHIFT; $y+=$this->row_height)
			{		
				// last page row filled in... create new page
				if ($row == $this->page_data_rows)
				{
// 					echo "NEW PAGE";					
					// close old page
					//pdf_end_page($this->pdf);
					
					// create new PDF page and generate new table
					$this->pdf->AddPage();
// 					pdf_begin_page($this->pdf, $this->page_width, $this->page_height);
					$this->setFont(PDF::FONT_HELVETICA, PDF::FONTSTYLE_BOLD, 10);
					$this->generateTable();
					$this->setColumnHeaders($headings);
					$this->setColumnTotals($totals);
			
					// Change font-type from Bold to Plain
					$this->setFont(PDF::FONT_HELVETICA, '', 10);		
					
					$y=$third_row_y;		// reset cursor to top of new page
				}				
						
				$y_cursor = $y + $this->row_height;
				$row_data = current($values);
				
				$col = 0;
				for ($x=$SHIFT; $x<=$this->page_width; $x+=$inc[$col])
				{
// 					if (!isset($values[$row][$col]))
// 					{
// 						break;
// 					}
		 
					// do not increment the counter if last index reached
					// i.e. use last width as default for the remaining columns
					if ($col != $lastIndex)
					{
						$column_data = current($row_data);
						
						// UNTESTED: allows custom link names with custom link URLs
						if (substr($column_data,0,1)==PDF::LINK_PREFIX)
						{
							// find first occurrence of the link suffix
							$endLinkPos = stripos($column_data, PDF::LINK_SUFFIX);
							$remainder = substr($colum_data, $endLinkPos+1);
							$remainder = trim($remainder);
							
							// set shown data to be the link-name (without the link prefix/suffix)
							$column_data = substr($column_data,1,$endLinkPos);
							
							// set URL action, if URL was given with link name (check for the URL prefix)
							if (strcasecmp(substr($remainder,0,PDF::URL_PREFIX_LEN),PDF::URL_PREFIX) == 0)
							{							
// 								$url = pdf_create_action($this->pdf, "URI", "url=".$remainder);
// 								pdf_create_annotation ($this->pdf, $x, $y-$this->row_height, $x+$inc[$col+1],$y, "Link", "linewidth=0 action {activate $url}");
								$this->pdf->Link($x, $y, $inc[$col+1],$this->row_height,$remainder);
							}
						}	// if the data contains no link name but it does contain a URL, then use default link name
						else if (strcasecmp(substr(trim($column_data),0,PDF::URL_PREFIX_LEN),PDF::URL_PREFIX) == 0)
						{
//  							echo 'column data = '.trim($column_data).'<br>';

// 							// find the index after the end of the URL prefix, i.e. '://' in 'https://'
// 							$baseURL_start = stripos($column_data, PDF::URL_BASE_SUFFIX) + PDF::URL_BASE_SUFFIX_LEN;
// 							
// 							// use the found URL prefix to split URL and encode the last portion (with possible GET parameters)
// 							$baseURL = substr(trim($column_data),0,$baseURL_start);	
// 							$URLparams = substr(trim($column_data),$baseURL_start);							
// 							$fullURL = $baseURL.$URLparams;	//urlencode($URLparams);
// 							echo 'full url = '.$fullURL.'<br>';

							$fullURL = trim($column_data);

							
							$this->pdf->Link( $x, $y + ($this->row_height / 2) + PDF::LINK_SHIFT, $inc[$col+1], $this->row_height,$fullURL);
// 							$url = pdf_create_action($this->pdf, "URI", "url=".$fullURL);
//  							pdf_create_annotation ($this->pdf, $x, $y-$this->row_height, $x+$inc[$col+1],$y, "Link", "linewidth=0 action {activate $url}");
//  							
							$column_data = $this->default_link_name;
						}
					
						
// 						echo $row.', '.$col.'<br>';
						$this->pdf->Text($x + PDF::WRITE_SHIFT, $y_cursor + PDF::WRITE_SHIFT, html_entity_decode($column_data));
						
						// formerly above had: $values[$row][$col]
						$col++;
						next($row_data);
					} 
				}
				$row++;
// 				echo "Row # = ".$row."  ";

				// stop retrieving data when there is no more data to retrieve
				if (next($values) === FALSE)
				{
					break;
				}
				
			}
			// TODO: deal with links in table cells
// 			$url = PDF_create_action($p, "URI", "url=http://www.pdflib.com");
// 			PDF_create_annotation ($p, 44, 100, 55,700, "Link", "linewidth=0 action {activate $url}");
			
			
// 			// Set table creation flag
// 			$this->is_table_created = true;
			
			// end page
			if ($endPage == true)
			{		
				//pdf_end_page($this->pdf);
				$this->is_page_ended = true;
				$this->is_table_created = false;
			}
// 			
// 			// close and save file
// 			if ($closeFile == true)
// 			{		
// 				pdf_close($this->pdf); 
// 				$this->is_file_closed = true;				
// 			}
		}		
		// else cannot proceed
	}	
	
	/** Helper function for creating column headers - only for use with fillTable() **/
	private function setColumnHeaders($headings)
	{
		// set columns of the table
		$SHIFT = $this->page_margin;	// number of pixels to shift table down and right

		$inc=$this->column_widths;	// TODO?: check to ensure that the array has been set and is in proper format
		$lastIndex=count($inc)-1;
		$counter = 0;
	
		// Add table headings (move along X axis)
		$heading_y = $this->row_height;		//($this->page_height-$SHIFT) - $this->row_height;
		for ($x=$SHIFT; $x<=$this->page_width; $x+=$inc[$counter])
		{
 
			// do not increment the counter if last index reached
			// i.e. use last width as default for the remaining columns
			if ($counter != $lastIndex)
			{
				$this->pdf->Text($x + PDF::WRITE_SHIFT, $heading_y + PDF::WRITE_SHIFT, $headings[$counter]);

				$counter++;
			} 
		}	
		
	}
	
	/** Helper function for creating column totals - only for use with fillTable() **/
	private function setColumnTotals($totals)
	{
// 		echo 'totals = <pre>'.print_r($totals,true).'</pre>';
		
		// set columns of the table
		$SHIFT = $this->page_margin;	// number of pixels to shift table down and right

		$inc=$this->column_widths;	// TODO?: check to ensure that the array has been set and is in proper format
		$lastIndex=count($inc)-1;
		$counter = 0;
		
		reset($totals);
	
		// Add table headings (move along X axis)
		$totals_y = $this->row_height*2;		//($this->page_height-$SHIFT) - $this->row_height;
		for ($x=$SHIFT; $x<=$this->page_width; $x+=$inc[$counter])
		{
 
			// do not increment the counter if last index reached
			// i.e. use last width as default for the remaining columns
			if ($counter != $lastIndex)
			{
				$this->pdf->Text($x + PDF::WRITE_SHIFT, $totals_y + PDF::WRITE_SHIFT, current($totals));
				next($totals);
				$counter++;
			} 
		}	
		
	}	
	
	
	/** Function for changing the default font **/
	private function setFont($font, $font_type, $font_size) 
	{
		$this->pdf->SetFont($font,$font_type,$font_size);
	}		
	
	// Generate the PDF file at the file_path location
	function Output()
	{
		$this->pdf->Output($this->file_path);
	}
	
	// Retrieve the PDF page object for use with other PDF classes
	function getPDF()
	{
		return $this->pdf;
	}
}

?>
