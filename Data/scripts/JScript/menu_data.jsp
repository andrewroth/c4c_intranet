// Add the proper scripts for either ns4 or dom.
if(ns4)_d.write("<scr"+"ipt language=JavaScript src="+aiPathToRoot+"Data/scripts/JScript/mmenuns4.jsp><\/scr"+"ipt>");
else _d.write("<scr"+"ipt language=JavaScript src="+aiPathToRoot+"Data/scripts/JScript/mmenudom.jsp><\/scr"+"ipt>");

_menuCloseDelay=500           // The time delay for menus to remain visible on mouse out
_menuOpenDelay=50            // The time delay before menus open on mouse over
_subOffsetTop=30              // Sub menu top offset
_subOffsetLeft=-10            // Sub menu left offset



with(barStyle=new mm_style()){
onbgcolor="#ffc400";
oncolor="#ffffff";
offbgcolor="#ffc400";
offcolor="#ffffff";
//bordercolor="#296488";
//borderstyle="solid";
separatorcolor="#ffffff";
separatorsize="0";
padding=4;
itemheight=20;
fontsize="10pt";
fontweight="bold";
fontstyle="normal";
fontfamily="Tahoma";
//pagecolor="black";
//pagebgcolor="#82B6D7";
//headercolor="#000000";
//headerbgcolor="#ffffff";
subimage="/Data/scripts/JScript/menuarrow.png";
subimagepadding="2";
//overfilter="Fade(duration=0.2);Alpha(opacity=90);Shadow(color='#777777', Direction=135, Strength=5)";
//outfilter="randomdissolve(duration=0.3)";
}

with(menuStyle=new mm_style()){
top="30px";
left="40px";
keepalive=1;
onbgcolor="#ffc400";
oncolor="#ffffff";
offbgcolor="#ffc400";
offcolor="#ffffff";
bordercolor="#ffc400";
borderstyle="solid";
borderwidth=1;
separatorcolor="#ffffff";
separatorsize="0";
padding=5;
itemheight=12;
fontsize="9pt";
fontweight="bold";
fontstyle="normal";
fontfamily="Tahoma";
//pagecolor="black";
//pagecolor="black";
//pagebgcolor="#82B6D7";
//headercolor="#000000";
//headerbgcolor="#ffffff";
//subimage="arrow.gif";
//subimagepadding="2";
//overfilter="Fade(duration=0.2);Alpha(opacity=90);Shadow(color='#777777', Direction=135, Strength=5)";
//outfilter="randomdissolve(duration=0.3)";
}


