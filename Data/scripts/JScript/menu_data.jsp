// Add the proper scripts for either ns4 or dom.
if(ns4)_d.write("<scr"+"ipt language=JavaScript src="+aiPathToRoot+"Data/scripts/JScript/mmenuns4.jsp><\/scr"+"ipt>");
else _d.write("<scr"+"ipt language=JavaScript src="+aiPathToRoot+"Data/scripts/JScript/mmenudom.jsp><\/scr"+"ipt>");

_menuCloseDelay=500           // The time delay for menus to remain visible on mouse out
_menuOpenDelay=50            // The time delay before menus open on mouse over
_subOffsetTop=5               // Sub menu top offset
_subOffsetLeft=-10            // Sub menu left offset



with(barStyle=new mm_style()){
//onbgcolor="#4F8EB6";
oncolor="#ffffff";
//offbgcolor="#DCE9F0";
offcolor="#ffffff";
//bordercolor="#296488";
//borderstyle="solid";
separatorcolor="#ffffff";
separatorsize="1";
valign="center"
padding=4;
itemheight=20;
fontsize="7pt";
fontweight="bold";
fontstyle="normal";
fontfamily="Verdana, Arial, Helvetica, sans-serif";
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
keepalive=1
onbgcolor="#000080";
oncolor="#ffffff";
offbgcolor="#eeeeee";
offcolor="#666666";
bordercolor="#666666";
borderstyle="solid";
borderwidth=1;
separatorcolor="#ffffff";
separatorsize="1";
padding=5;
itemheight=20;
fontsize="7pt";
fontstyle="normal";
fontfamily="Verdana, Arial, Helvetica, sans-serif";
//pagecolor="black";
//pagebgcolor="#82B6D7";
//headercolor="#000000";
//headerbgcolor="#ffffff";
//subimage="arrow.gif";
//subimagepadding="2";
//overfilter="Fade(duration=0.2);Alpha(opacity=90);Shadow(color='#777777', Direction=135, Strength=5)";
//outfilter="randomdissolve(duration=0.3)";
}


