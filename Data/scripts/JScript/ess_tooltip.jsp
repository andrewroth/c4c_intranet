b=navigator.appName

addScroll=false;

if (navigator.userAgent.indexOf('MSIE 5')>0) {addScroll = true;}

var off=0;

var txt="";

var pX=0;

var pY=0;



document.onmousemove = mouseMove;

if (b == "Netscape") {

  document.captureEvents(Event.MOUSEMOVE);

}



function ML() {

  doIt=false;

  if (b == "Netscape") {

    if (document.layers['ToolTip'].visibility=="hide") {doIt=true;}

  } else	{

    if (document.all['ToolTip'].style.visibility=="hidden") {doIt=true;}

  }

  if (doIt!=false) {

    args=ML.arguments;

	 txt=args[0];

	 ttl=args[1];

	 args=ML.arguments;

	 txt=args[0];

	 ttl=args[1];

	 doc = '<table border="0" cellpadding="0" cellspacing="0" width="200"><tr><td bgcolor="#FFFFFF">';

	 doc = doc + '<table border="0" cellpadding="8" cellspacing="1" width="100%" align="center">';

//	 doc = doc + '<tr valign="center"><td bgcolor="#205380" align="center" class="title">:: ' + ttl +' ::</td></tr>';

	 doc = doc + '<tr valign="top">';

//Original bgcolor="#2868A0"

	 doc = doc + '<td bgcolor="#99CC99"><p><font color="#000000">' + txt + '</font></p></td>';

	 doc = doc + '</tr>';

	 doc = doc + '</table></td></tr></table>';



	 if (b == "Netscape") {

		document.layers['ToolTip'].document.write(doc);

		document.layers['ToolTip'].document.close();

	 } else {

		document.all['ToolTip'].innerHTML=doc;

	 }

	 PopTip();

  }

}



function mouseMove(evn) {

  if (b == "Netscape") {

	 pX=evn.pageX-125;

	 pY=evn.pageY;

  } else {

	 pX=event.x-125;

	 pY=event.y;

  }

  if (b == "Netscape") {

	 if (document.layers['ToolTip'].visibility=='show') {

	   PopTip();

	 }

  } else {

	 if (document.all['ToolTip'].style.visibility=='visible') {

	   PopTip();

	 }

  }

}



function PopTip() {

  if (b == "Netscape") {

	 theLayer = eval('document.layers[\'ToolTip\']');	

	 if ((pX+120)>window.innerWidth) {

	   pX=window.innerWidth-250;

	 }

	 theLayer.left=pX+10;

	 theLayer.top=pY+25;

	 theLayer.visibility='show';	

  } else {

    theLayer = eval('document.all[\'ToolTip\']');

	 if (theLayer) {

	   pX=event.x-100;

		pY=event.y+5;

		if (addScroll) {

		  pX=pX+document.body.scrollLeft;

		  pY=pY+document.body.scrollTop;

		}

		if ((pX+120)>document.body.clientWidth) {

		  pX=pX-250;			

		}

		theLayer.style.pixelLeft=pX+10;

		theLayer.style.pixelTop=pY+15;

		theLayer.style.visibility='visible';

		}

	}

}



function HideTip() {

  args=HideTip.arguments;

  if (b == "Netscape") {

    document.layers['ToolTip'].visibility='hide';

  } else {

    document.all['ToolTip'].style.visibility='hidden';

  }

}



