// Add the proper scripts for either ns4 or dom.
if(ns4)_d.write("<scr"+"ipt language=JavaScript src="+aiPathToRoot+"Data/scripts/JScript/mmenuns4.jsp><\/scr"+"ipt>");
else _d.write("<scr"+"ipt language=JavaScript src="+aiPathToRoot+"Data/scripts/JScript/mmenudom.jsp><\/scr"+"ipt>");

_menuCloseDelay=500           // The time delay for menus to remain visible on mouse out
_menuOpenDelay=50            // The time delay before menus open on mouse over
_subOffsetTop=30              // Sub menu top offset
_subOffsetLeft=-10            // Sub menu left offset



with(barStyle=new mm_style()){
//onbgcolor="#4F8EB6";
oncolor="#0D1C42";
//offbgcolor="#DCE9F0";
offcolor="#0D1C42";
//bordercolor="#296488";
//borderstyle="solid";
separatorcolor="#0D1C42";
separatorsize="2";
valign="center";
padding=5;
itemheight=20;
fontsize="16pt";
fontweight="bold";
fontstyle="normal";
fontfamily="Lucida Grande, Verdana, sans-serif";
//pagecolor="black";
//pagebgcolor="#82B6D7";
//headercolor="#000000";
//headerbgcolor="#ffffff";
//subimage="arrow.gif";
//subimagepadding="2";
//overfilter="Fade(duration=0.2);Alpha(opacity=90);Shadow(color='#777777', Direction=135, Strength=5)";
//outfilter="randomdissolve(duration=0.3)";
}

with(menuStyle=new mm_style()){
position="absolute";
top="30px";
left="40px";
keepalive=1;
onbgcolor="#FFFFFF";
oncolor="#0D1C42";
offbgcolor="#FFFFFF";
offcolor="#0D1C42";
bordercolor="#FFFFFF";
borderstyle="solid";
borderwidth=1;
separatorcolor="#0D1C42";
separatorsize="1";
padding=5;
itemheight=12;
fontsize="10pt";
fontstyle="normal";
fontfamily="Lucida Grande, Verdana, sans-serif";
//pagecolor="black";
//pagebgcolor="#82B6D7";
//headercolor="#000000";
//headerbgcolor="#ffffff";
//subimage="arrow.gif";
//subimagepadding="2";
//overfilter="Fade(duration=0.2);Alpha(opacity=90);Shadow(color='#777777', Direction=135, Strength=5)";
//outfilter="randomdissolve(duration=0.3)";
}


