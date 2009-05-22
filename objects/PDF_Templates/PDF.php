<?php

/**
 * class PDF
 * <pre> 
 * Used to extend PDF functionality.
 * </pre>
 * @author Olivier (www.fpdf.org) [Circle, Ellipse]
 * @author Maxime Delorme (www.fpdf.org) [Sector, _Arc]
 * @author Pierra Marletta (www.fpdf.org) [PieChart, BarDiag]
 */


require('fpdf/fpdf.php');

class PDF extends FPDF
{
	//CONSTANTS:
	const AUTHOR = "Campus Internet Ministries";
	const TITLE = "Generated Table PDF File";
	const CREATOR = "Campus Internet Ministries";
	const SUBJECT = "Tabulated Data";
	
	const PAGETYPE_LETTER = 0;
	const PAGETYPE_LEGAL = 1;
	const PAGETYPE_A4 = 2;
	
	const PAGEWIDTH_A4 = 595;
	const PAGEHEIGHT_A4 = 842;
	const PAGEWIDTH_LETTER = 612;
	const PAGEHEIGHT_LETTER = 792;
	const PAGEWIDTH_LEGAL = 612;
	const PAGEHEIGHT_LEGAL = 1008;	
	
	const FONT_ARIAL = "Arial";
	const FONT_HELVETICA = "Helvetica";
	const FONT_HELVETICA_BOLD = "Helvetica-Bold";
	
	const FONTSTYLE_PLAIN = "";
	const FONTSTYLE_BOLD = "B";
	const FONTSTYLE_ITALIC = "I";
	const FONTSTYLE_UNDERLINE = "U";
	
	const ENCODING = "iso8859-1";
	const PENTYPE_STROKE = "stroke";
	const COLORSPACE_RGB = "rgb";
	
	const WRITE_SHIFT = 6;	// how many pixels to shift down and right when writing in table cells
	const LINK_SHIFT = 2;	// how many pixels to shift down when placing a hyperlink (== width of horizontal lines?)
	
	// the special chars used to indicate whether data is a link of form: <prefix>linkname<suffix> http...
	const LINK_PREFIX = '[';	
	const LINK_SUFFIX = ']';
	const URL_PREFIX = 'http';
	const URL_PREFIX_LEN = 4;
// 	const URL_CONNECT = '://';
// 	const URL_CONNECT_LEN = 3;
	const URL_BASE_SUFFIX = 'php';
	const URL_BASE_SUFFIX_LEN = 3;	
	
	
	// variables for PieChart and BarDiag functions
    var $legends;
    var $wLegend;
    var $sum;
    var $NbVal;	

	/**	
	function Circle(float x, float y, float r [, string style])
	
	x: abscissa of center.
	y: ordinate of center.
	r: radius.
	style: style of rendering, like for Rect (D, F or FD). Default value: D.	
	**/
	function Circle($x,$y,$r,$style='')
	{
	    $this->Ellipse($x,$y,$r,$r,$style);
	}

	/**
	function Ellipse(float x, float y, float rx, float ry [, string style])
	
	x: abscissa of center.
	y: ordinate of center.
	rx: horizontal radius.
	ry: vertical radius.
	style: style of rendering.	
	**/	
	function Ellipse($x,$y,$rx,$ry,$style='D')
	{
	    if($style=='F')
	        $op='f';
	    elseif($style=='FD' or $style=='DF')
	        $op='B';
	    else
	        $op='S';
	    $lx=4/3*(M_SQRT2-1)*$rx;
	    $ly=4/3*(M_SQRT2-1)*$ry;
	    $k=$this->k;
	    $h=$this->h;
	    $this->_out(sprintf('%.2f %.2f m %.2f %.2f %.2f %.2f %.2f %.2f c',
	        ($x+$rx)*$k,($h-$y)*$k,
	        ($x+$rx)*$k,($h-($y-$ly))*$k,
	        ($x+$lx)*$k,($h-($y-$ry))*$k,
	        $x*$k,($h-($y-$ry))*$k));
	    $this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c',
	        ($x-$lx)*$k,($h-($y-$ry))*$k,
	        ($x-$rx)*$k,($h-($y-$ly))*$k,
	        ($x-$rx)*$k,($h-$y)*$k));
	    $this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c',
	        ($x-$rx)*$k,($h-($y+$ly))*$k,
	        ($x-$lx)*$k,($h-($y+$ry))*$k,
	        $x*$k,($h-($y+$ry))*$k));
	    $this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c %s',
	        ($x+$lx)*$k,($h-($y+$ry))*$k,
	        ($x+$rx)*$k,($h-($y+$ly))*$k,
	        ($x+$rx)*$k,($h-$y)*$k,
	        $op));
	}

	/**  
	 *  function Sector(float xc, float yc, float r, float a, float b [, string style [, boolean cw [, float o]]])
	 
		xc: abscissa of the center.
		yc: ordinate of the center.
		r: radius.
		a: start angle (in degrees).
		b: end angle (in degrees).
		style: D, F, FD or DF (draw, fill, fill and draw). Default: FD.
		cw: indicates whether to go clockwise (default: true).
		o: origin of angles (0 for 3 o'clock, 90 for noon, 180 for 9 o'clock, 270 for 6 o'clock). Default: 90.
		**/	
	 function Sector($xc, $yc, $r, $a, $b, $style='FD', $cw=true, $o=90)
    {
        if($cw){
            $d = $b;
            $b = $o - $a;
            $a = $o - $d;
        }else{
            $b += $o;
            $a += $o;
        }
        $a = ($a%360)+360;
        $b = ($b%360)+360;
        if ($a > $b)
            $b +=360;
        $b = $b/360*2*M_PI;
        $a = $a/360*2*M_PI;
        $d = $b-$a;
        if ($d == 0 )
            $d =2*M_PI;
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op='f';
        elseif($style=='FD' or $style=='DF')
            $op='b';
        else
            $op='s';
        if (sin($d/2))
            $MyArc = 4/3*(1-cos($d/2))/sin($d/2)*$r;
        //first put the center
        $this->_out(sprintf('%.2f %.2f m',($xc)*$k,($hp-$yc)*$k));
        //put the first point
        $this->_out(sprintf('%.2f %.2f l',($xc+$r*cos($a))*$k,(($hp-($yc-$r*sin($a)))*$k)));
        //draw the arc
        if ($d < M_PI/2){
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                        $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                        $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                        $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                        $xc+$r*cos($b),
                        $yc-$r*sin($b)
                        );
        }else{
            $b = $a + $d/4;
            $MyArc = 4/3*(1-cos($d/8))/sin($d/8)*$r;
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                        $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                        $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                        $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                        $xc+$r*cos($b),
                        $yc-$r*sin($b)
                        );
            $a = $b;
            $b = $a + $d/4;
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                        $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                        $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                        $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                        $xc+$r*cos($b),
                        $yc-$r*sin($b)
                        );
            $a = $b;
            $b = $a + $d/4;
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                        $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                        $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                        $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                        $xc+$r*cos($b),
                        $yc-$r*sin($b)
                        );
            $a = $b;
            $b = $a + $d/4;
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                        $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                        $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                        $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                        $xc+$r*cos($b),
                        $yc-$r*sin($b)
                        );
        }
        //terminate drawing
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3 )
    {
        $h = $this->h;
        $this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c',
            $x1*$this->k,
            ($h-$y1)*$this->k,
            $x2*$this->k,
            ($h-$y2)*$this->k,
            $x3*$this->k,
            ($h-$y3)*$this->k));
    }	
    
    /**
		PieChart(float w, float h, array data, string format [, array colors])
		
		w: maximum width of the diagram.
		h: maximum height of the diagram.
		data: associative array containing the labels and the corresponding data.
		format: format used to display the legends. It is a string which can contain the following special values: %l (label), %v (value) and %p (percentage).
		colors: array containing the colors. If not given, a grayscale will be used.
	 **/
    function PieChart($w, $h, $data, $format, $colors=null)
    {
        $this->SetFont('Courier', '', 10);
        $this->SetLegends($data,$format);
        
        $XPage = $this->GetX();
        $YPage = $this->GetY();
        $margin = 2;
        $hLegend = 5;
        $radius = min($w - $margin * 4 - $hLegend - $this->wLegend, $h - $margin * 2);
        $radius = floor($radius / 2);
        $XDiag = $XPage + $margin + $radius;
        $YDiag = $YPage + $margin + $radius;
        if($colors == null) {
            for($i = 0;$i < $this->NbVal; $i++) {
                $gray = $i * intval(255 / $this->NbVal);
                $colors[$i] = array($gray,$gray,$gray);
            }
        }

        //Sectors
        $this->SetLineWidth(0.2);
        $angleStart = 0;
        $angleEnd = 0;
        $i = 0;
        foreach($data as $val) {
            $angle = floor(($val * 360) / doubleval($this->sum));
            if ($angle != 0) {
                $angleEnd = $angleStart + $angle;
                $this->SetFillColor($colors[$i][0],$colors[$i][1],$colors[$i][2]);
                $this->Sector($XDiag, $YDiag, $radius, $angleStart, $angleEnd);
                $angleStart += $angle;
            }
            $i++;
        }
        if ($angleEnd != 360) {
            $this->Sector($XDiag, $YDiag, $radius, $angleStart - $angle, 360);
        }

        //Legends
        $this->SetFont('Courier', '', 10);
        $x1 = $XPage + (4 * $margin);	// + (2 * $radius) + (4 * $margin);	// wierd!!! had to change '+' to '-' (right alignment?)
        $x2 = $x1 + $hLegend + $margin;
        $y1 = $YDiag - $radius + (2 * $radius - $this->NbVal*($hLegend + $margin)) / 2;
        for($i=0; $i<$this->NbVal; $i++) {
            $this->SetFillColor($colors[$i][0],$colors[$i][1],$colors[$i][2]);
            $this->Rect($x1, $y1, $hLegend, $hLegend, 'DF');
            $this->SetXY($x2,$y1);
            $this->Cell(0,$hLegend,html_entity_decode($this->legends[$i]));
            $y1+=$hLegend + $margin;
        }
    } 
    
    /**
		BarDiag(float w, float h, array data, string format [, array couleur [, int maxVal [, int nbDiv]]])
		
		w: width of the diagram.
		h: height of the diagram.
		data: associative array containing the labels and the corresponding data.
		format: format used to display the legends. It is a string which can contain the following special values: %l (label), %v (value) and %p (percentage).
		color: color of the bars. If not given, gray will be used.
		maxVal: high value of the scale. Defaults to the maximum value of the data.
		nbDiv: number of subdivisions of the scale (4 by default). 
	 **/   
	 function BarDiagram($w, $h, $data, $format, $color=null, $maxVal=0, $nbDiv=4)
    {
        $this->SetFont('Courier', '', 10);
        $this->SetLegends($data,$format);

        $XPage = $this->GetX();
        $YPage = $this->GetY();
        $margin = 2;
        $YDiag = $YPage + $margin;
        $hDiag = floor($h - $margin * 2);
        $XDiag = $XPage + $margin * 2 + $this->wLegend;
        $lDiag = floor($w - $margin * 3 - $this->wLegend);
        if($color == null)
            $color=array(155,155,155);
        if ($maxVal == 0) {
            $maxVal = max($data);
        }
        $valIndRepere = ceil($maxVal / $nbDiv);
        $maxVal = $valIndRepere * $nbDiv;
        $lRepere = floor($lDiag / $nbDiv);
        $lDiag = $lRepere * $nbDiv;
        $unit = $lDiag / $maxVal;
        $hBar = floor($hDiag / ($this->NbVal + 1));
        $hDiag = $hBar * ($this->NbVal + 1);
        $eBaton = floor($hBar * 80 / 100);

        $this->SetLineWidth(0.2);
        $this->Rect($XDiag, $YDiag, $lDiag, $hDiag);

        $this->SetFont('Courier', '', 10);
        $this->SetFillColor($color[0],$color[1],$color[2]);
        $i=0;
        foreach($data as $val) {
            //Bar
            $xval = $XDiag;
            $lval = (int)($val * $unit);
            $yval = $YDiag + ($i + 1) * $hBar - $eBaton / 2;
            $hval = $eBaton;
            $this->Rect($xval, $yval, $lval, $hval, 'DF');
            //Legend
            $this->SetXY(0, $yval);
            $this->Cell($xval - $margin, $hval, $this->legends[$i],0,0,'R');
            $i++;
        }

        //Scales
        for ($i = 0; $i <= $nbDiv; $i++) {
            $xpos = $XDiag + $lRepere * $i;
            $this->Line($xpos, $YDiag, $xpos, $YDiag + $hDiag);
            $val = $i * $valIndRepere;
            $xpos = $XDiag + $lRepere * $i - $this->GetStringWidth($val) / 2;
            $ypos = $YDiag + $hDiag - $margin;
            $this->Text($xpos, $ypos, $val);
        }
    }

    function SetLegends($data, $format)
    {
        $this->legends=array();
        $this->wLegend=0;
        $this->sum=array_sum($data);
        $this->NbVal=count($data);
        foreach($data as $l=>$val)
        {
            $p=sprintf('%.2f',$val/$this->sum*100).'%';
            $legend=str_replace(array('%l','%v','%p'),array($l,$val,$p),$format);
            $this->legends[]=$legend;
            $this->wLegend=max($this->GetStringWidth($legend),$this->wLegend);
        }
    }       
}
?>