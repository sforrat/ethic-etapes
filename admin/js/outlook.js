//free JavaScripts at http://www.ScriptBreaker.com
var height = 350;
var vwidth = 200;
var speed = 0;
var step =30;

var hheight = 25; // heigth of a header item
var iheight = 20; // heigth of a item

var bgc = "lightyellow" // background color of the item
var tc = "black" // text color of the item
var  textdec  =  "none";
  
var over_bgc = "silver";
var over_tc = "red";
var  over_textdec  =  "none"; // underline 
var open = -1;

var N = (document.all) ? 0 : 1;
var Link_count = 0;
var ntop = 0;
var items = false
var z = 0;
var hnr = 1;
var timerID = null;
var link_array = new Array();

function write_menu()
{
document.write("<div id=main_panel style='height:")
if (N) document.write(height);
else document.write(height-2);
document.write(";width:");
if (N) document.write(vwidth)
else document.write(vwidth-2)
document.write("'>");

cl =0;
for(i=0;i<Link.length;i++)
{
 la = Link[i].split("|");
 if(la[0] == "0")
 {
   if (items == true) {document.write("</div>");items = false;}
   document.write("<div class='head_item' id='move"+cl+"' style='cursor=pointer;height:"+hheight+";width:"+vwidth+";top:"+(ntop-1)+";z-index:"+z+"' onclick='move("+cl+","+hnr+")'>&nbsp;"+la[1]+"</div>");
   link_array[cl] = new Array("up",0,hnr);
   cl++;hnr++;
   ntop += hheight-1;
   z++;
 }
 else
 {
  cheight = height - ntop + 1;
  if (items == false) {document.write("<div class='item_panel' id='move"+cl+"' style='height:"+cheight+"px;width:"+vwidth+";top:")
  if (N) document.write(ntop+2);
  else document.write(ntop);
  document.write(";z-index:"+z+"'>");
  z++;
  link_array[cl] = new Array("up",0,"");
  cl++;
  }
   document.write("<a href='"+la[2]+"'");
   if (la[3] != "") document.write(" target='" + la[3] + "' ");
   document.write(" onmouseover=color('item"+i+"') onmouseout=uncolor('item"+i+"') ><div class='item' id='item"+i+"' style='height:"+iheight+";width:"+vwidth+"'>&nbsp;&nbsp;"+la[1]+"</div></a>");
  items = true;
 }
}
document.write("</div>");
if (items == true) {document.write("</div>");}
}

function color(obj)
{
 document.getElementById(obj).style.backgroundColor = over_bgc;
 document.getElementById(obj).style.color = over_tc
 document.getElementById(obj).style.textDecoration  =  over_textdec; 
}

function uncolor(obj)
{
 document.getElementById(obj).style.backgroundColor = bgc;
 document.getElementById(obj).style.color = tc;
 document.getElementById(obj).style.textDecoration  =  textdec;
}

function move(idnr,hid)
{
 if ((idnr != open)&& (timerID == null))
 {
 if(link_array[idnr][0] == "up")
 {
  down = height - (hid * hheight) - ((hnr -(hid+1))* hheight) + 2;
  if(N) down+=2;
  dmover(idnr+2,down);
 }
 else
 {
  up = height - ((hid -1) * hheight) -((hnr - (hid))* hheight) +2;
  if(N) up+=2;
  umover(idnr,up);
 }
 open = idnr;
 }
}

function dmover(idnr,down)
{
 for (i=idnr;i<link_array.length;i++)
 {
  if(link_array[i][0] == "up")
  {
   txt_obj = "move" + i
   document.getElementById(txt_obj).style.top = parseInt(document.getElementById(txt_obj).style.top) + step;
  }
 }
 down-= step;
 if(down > 0)timerID = setTimeout("dmover("+idnr+","+down+")",speed);
 else 
 {
  for (i=idnr;i<link_array.length;i++) {link_array[i][0] = "down";}
 timerID = null;
 }
}

function umover(idnr,up)
{
 for (i=0;i<(idnr+2);i++)
 {
  if(link_array[i][0] == "down")
  {
   txt_obj = "move" + i
   document.getElementById(txt_obj).style.top = parseInt(document.getElementById(txt_obj).style.top) - step;
  }
 }
 up-=step;
 if(up > 0)timerID = setTimeout("umover("+idnr+","+up+")",speed);
 else 
 {
  for (i=0;i<(idnr+2);i++) {link_array[i][0] = "up";}
 timerID = null;
 }
}
//free JavaScripts at http://www.ScriptBreaker.com

function start(idnr)
{
 write_menu();
 for(i=0;i<link_array.length;i++)
 {
  if (link_array[i][2] == idnr)
  {
   pull = i;
   i = link_array.length;
  }
 }
   move(pull,idnr);
}  