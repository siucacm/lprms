<!--
 
var pop = document.getElementById('popup');
 
var xoffset = 15;
var yoffset = 10;
 
document.onmousemove = function(e) {
  var x, y, right, bottom;
  
  try { x = e.pageX; y = e.pageY; } // FF
  catch(e) { x = event.x; y = event.y; } // IE
 
  right = (document.documentElement.clientWidth || document.body.clientWidth || document.body.scrollWidth);
  bottom = (window.scrollY || document.documentElement.scrollTop || document.body.scrollTop) + (window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight || document.body.scrollHeight);
 
  x += xoffset;
  y += yoffset;
 
  if(x > right-pop.offsetWidth)
    x = right-pop.offsetWidth;
 
  if(y > bottom-pop.offsetHeight)
    y = bottom-pop.offsetHeight;
  
  pop.style.top = y+'px';
  pop.style.left = x+'px';
 
}
 
function popup(textdivid) {
  textdiv = document.getElementById(textdivid);
  pop.innerHTML = textdiv.innerHTML;
  pop.style.display = 'block';
}
 
function popout() {
  pop.style.display = 'none';
}
 
//-->