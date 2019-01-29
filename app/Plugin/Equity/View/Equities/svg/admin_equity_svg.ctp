<?php
echo '<?xml version="1.0" encoding="UTF-8" standalone="no"?>';
echo '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 20010904//EN"
  "http://www.w3.org/TR/2001/REC-SVG-20010904/DTD/svg10.dtd">';
echo '<svg
   xmlns:dc="http://purl.org/dc/elements/1.1/"
   xmlns:cc="http://creativecommons.org/ns#"
   xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
   xmlns:svg="http://www.w3.org/2000/svg"
   xmlns="http://www.w3.org/2000/svg"
   xmlns:xlink="http://www.w3.org/1999/xlink"
   xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
   xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
   id="svg2"
   version="1.1"
   inkscape:version="0.48.2 r9819"
   sodipodi:docname="crowdfund.svg"
   viewBox="30 120 760 180"
   onload="init(evt)">'
   ;?>
   <style xmlns="http://www.w3.org/1999/xhtml" charset="utf-8" type="text/css">
  <![CDATA[
   * {
  outline: medium none;
  }
   .tooltip{
    font-size: 11px;
    fill:white;
    font-family:Arial;
  }
  rect.tooltip_bg{
    fill:black;
    stroke:black;
	opacity: 0.85;	
   }
  ]]>
</style>
 <script type="text/ecmascript">
  <![CDATA[
  var svgNS = "http://www.w3.org/2000/svg";
  var width = 180;
  function init(evt)  {
    if ( window.svgDocument == null )  {
      svgDocument = evt.target.ownerDocument;
    }
    tooltip = svgDocument.getElementById('tooltip');
    tooltip_bg = svgDocument.getElementById('tooltip_bg');
  }
  function createElement(element) {
    if (typeof document.createElementNS != 'undefined') {
      return document.createElementNS(svgNS, element);
    }
    if (typeof document.createElement != 'undefined') {
      return document.createElement(element);
    }
    return false;
  }
  function create_multiline(text, x, y, tooltip_X, tooltip_Y) {
    var words = text.split(' ');
	tooltip_text = window.top.document.getElementById('tooltip_text');
    svgDocument.getElementById('tooltip').textContent = '';
    var text_element = svgDocument.getElementById('tooltip');
    text_element.setAttribute("y", y + (tooltip_Y + 20));
    var bg_element = svgDocument.getElementById('tooltip_bg');
    var tspan_element = createElement("tspan");   // Create first tspan element
    tspan_element.setAttribute("x", x - tooltip_X);
    tspan_element.setAttribute("dy", 0);
    var text_node = svgDocument.createTextNode(words[0]);       // Create text in tspan element
    tspan_element.appendChild(text_node);               // Add tspan element to DOM
    text_element.appendChild(tspan_element);            // Add text to tspan element
    var height = 0;
    for(var i=1; i<words.length; i++) {
      var len = tspan_element.firstChild.data.length;       // Find number of letters in string
      tspan_element.firstChild.data += " " + words[i];      // Add next word
      tooltip_text.innerHTML = tspan_element.firstChild.data;
	  tooltip_text_width = tooltip_text.offsetWidth-20;
      if (tooltip_text_width > width) {
        tspan_element.firstChild.data = tspan_element.firstChild.data.slice(0, len);  // Remove added word
        var tspan_element = createElement("tspan");     // Create new tspan element
        tspan_element.setAttribute("x", x - tooltip_X);
        tspan_element.setAttribute("dy", 18);
        text_node = svgDocument.createTextNode(words[i]);
        tspan_element.appendChild(text_node);
        text_element.appendChild(tspan_element);
        height = height + 18;
      }
    }
    bg_element.setAttribute("width", 190);
    bg_element.setAttribute("height", height + 30);
    bg_element.setAttribute("x", x-(tooltip_X+5));
    bg_element.setAttribute("y", y + tooltip_Y);
  }
  function ShowTooltip(evt, mouseovertext, curObj, tooltip_X, tooltip_Y) {
    if (window.top.document.body.clientWidth < 1024) {
		tooltip_X = tooltip_X-120;
		tooltip_Y = tooltip_Y+10;
	}
    create_multiline(mouseovertext, evt.clientX, evt.clientY, tooltip_X, tooltip_Y);
    tooltip_bg.setAttribute("visibility","visible");
    tooltip.setAttribute("visibility","visible");
  }
  function HideTooltip(evt, curObj) {
    curObj.setAttribute("class",'circle first');
    tooltip.setAttribute("visibility","hidden");
    tooltip_bg.setAttribute("visibility","hidden");
  }
  function sleeping(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
    }
  }
  function delaying(delay) {
     var start = new Date().getTime();
     while (new Date().getTime() < start + delay);
  }
  ]]>
</script>
  <?php echo '<defs
   id="defs4">';
  echo '<linearGradient
     inkscape:collect="always"
     id="linearGradient10628">';
    echo '<stop
     style="stop-color:#abab57;stop-opacity:1;"
     offset="0"
     id="stop10630" />';
    echo '<stop
     style="stop-color:#abab57;stop-opacity:0;"
     offset="1"
     id="stop10632" />';
  echo '</linearGradient>';
  echo '<linearGradient
     id="linearGradient10612">';
    echo'<stop
     style="stop-color:#0e3400;stop-opacity:1;"
     offset="0"
     id="stop10614" />';
   echo'<stop
     style="stop-color:#252525;stop-opacity:0;"
     offset="1"
     id="stop10616" />';
  echo'</linearGradient>';
  echo '<marker
     inkscape:stockid="Arrow2Invest"
     orient="auto"
     refY="0"
     refX="0"
     id="Arrow2Invest"
     style="overflow:visible">';
    echo'<path
     id="path3816"
     style="font-size:12px;fill-rule:evenodd;stroke-width:0.625;stroke-linejoin:round"
     d="M 8.7185878,4.0337352 -2.2072895,0.01601326 8.7185884,-4.0017078 c -1.7454984,2.3720609 -1.7354408,5.6174519 -6e-7,8.035443 z"
     transform="matrix(-1.1,0,0,-1.1,-1.1,0)"
     inkscape:connector-curvature="0" />';
  echo'</marker>';
  echo'<marker
     inkscape:stockid="Arrow2Mend"
     orient="auto"
     refY="0"
     refX="0"
     id="Arrow2Mend"
     style="overflow:visible">';
    echo'<path
     id="path3822"
     style="font-size:12px;fill-rule:evenodd;stroke-width:0.625;stroke-linejoin:round"
     d="M 8.7185878,4.0337352 -2.2072895,0.01601326 8.7185884,-4.0017078 c -1.7454984,2.3720609 -1.7354408,5.6174519 -6e-7,8.035443 z"
     transform="scale(-0.6,-0.6)"
     inkscape:connector-curvature="0" />';
  echo'</marker>';
  echo'<inkscape:perspective
     sodipodi:type="inkscape:persp3d"
     inkscape:vp_x="0 : 526.18109 : 1"
     inkscape:vp_y="0 : 1000 : 0"
     inkscape:vp_z="744.09448 : 526.18109 : 1"
     inkscape:persp3d-origin="372.04724 : 350.78739 : 1"
     id="perspective3768" />';
  echo'<marker
     style="overflow:visible"
     id="marker4196-55"
     refX="0"
     refY="0"
     orient="auto"
     inkscape:stockid="Arrow2Mend">';
    echo';<path
     transform="scale(-0.6,-0.6)"
     d="M 8.7185878,4.0337352 -2.2072895,0.01601326 8.7185884,-4.0017078 c -1.7454984,2.3720609 -1.7354408,5.6174519 -6e-7,8.035443 z"
     style="font-size:12px;fill-rule:evenodd;stroke-width:0.625;stroke-linejoin:round"
     id="path4198-1"
     inkscape:connector-curvature="0" />';
  echo'</marker>';
  echo'<marker
     style="overflow:visible"
     id="marker4196-1-8"
     refX="0"
     refY="0"
     orient="auto"
     inkscape:stockid="Arrow2Mend">';
    echo'<path
     transform="scale(-0.6,-0.6)"
     d="M 8.7185878,4.0337352 -2.2072895,0.01601326 8.7185884,-4.0017078 c -1.7454984,2.3720609 -1.7354408,5.6174519 -6e-7,8.035443 z"
     style="font-size:12px;fill-rule:evenodd;stroke-width:0.625;stroke-linejoin:round"
     id="path4198-8-2"
     inkscape:connector-curvature="0" />';
  echo'</marker>';
   echo'<marker
     style="overflow:visible"
     id="marker4196-9"
     refX="0"
     refY="0"
     orient="auto"
     inkscape:stockid="Arrow2Mend">';
    echo'<path
     transform="scale(-0.6,-0.6)"
     d="M 8.7185878,4.0337352 -2.2072895,0.01601326 8.7185884,-4.0017078 c -1.7454984,2.3720609 -1.7354408,5.6174519 -6e-7,8.035443 z"
     style="font-size:12px;fill-rule:evenodd;stroke-width:0.625;stroke-linejoin:round"
     id="path4198-4"
     inkscape:connector-curvature="0" />';
  echo'</marker>';
  echo'<marker
     style="overflow:visible"
     id="Arrow2Mend-17"
     refX="0"
     refY="0"
     orient="auto"
     inkscape:stockid="Arrow2Mend">';
    echo'<path
     inkscape:connector-curvature="0"
     transform="scale(-0.6,-0.6)"
     d="M 8.7185878,4.0337352 -2.2072895,0.01601326 8.7185884,-4.0017078 c -1.7454984,2.3720609 -1.7354408,5.6174519 -6e-7,8.035443 z"
     style="font-size:12px;fill-rule:evenodd;stroke-width:0.625;stroke-linejoin:round"
     id="path4574-4" />';
  echo'</marker>';
  echo'<marker
     style="overflow:visible"
     id="Arrow2Mend-1"
     refX="0"
     refY="0"
     orient="auto"
     inkscape:stockid="Arrow2Mend">';
    echo'<path
     inkscape:connector-curvature="0"
     transform="scale(-0.6,-0.6)"
     d="M 8.7185878,4.0337352 -2.2072895,0.01601326 8.7185884,-4.0017078 c -1.7454984,2.3720609 -1.7354408,5.6174519 -6e-7,8.035443 z"
     style="font-size:12px;fill-rule:evenodd;stroke-width:0.625;stroke-linejoin:round"
     id="path4574-7" />';
  echo'</marker>';
  echo'<marker
     style="overflow:visible"
     id="marker7782-98"
     refX="0"
     refY="0"
     orient="auto"
     inkscape:stockid="Arrow2Mend">';
    echo'<path
     transform="scale(-0.6,-0.6)"
     d="M 8.7185878,4.0337352 -2.2072895,0.01601326 8.7185884,-4.0017078 c -1.7454984,2.3720609 -1.7354408,5.6174519 -6e-7,8.035443 z"
     style="font-size:12px;fill-rule:evenodd;stroke-width:0.625;stroke-linejoin:round"
     id="path7784-6"
     inkscape:connector-curvature="0" />';
  echo'</marker>';
  echo'<marker
     style="overflow:visible"
     id="marker4196-1"
     refX="0"
     refY="0"
     orient="auto"
     inkscape:stockid="Arrow2Mend">';
    echo'<path
     transform="scale(-0.6,-0.6)"
     d="M 8.7185878,4.0337352 -2.2072895,0.01601326 8.7185884,-4.0017078 c -1.7454984,2.3720609 -1.7354408,5.6174519 -6e-7,8.035443 z"
     style="font-size:12px;fill-rule:evenodd;stroke-width:0.625;stroke-linejoin:round"
     id="path4198-8"
     inkscape:connector-curvature="0" />';
  echo'</marker>';
  echo'<marker
     style="overflow:visible"
     id="marker4196-5"
     refX="0"
     refY="0"
     orient="auto"
     inkscape:stockid="Arrow2Mend">';
    echo'<path
     transform="scale(-0.6,-0.6)"
     d="M 8.7185878,4.0337352 -2.2072895,0.01601326 8.7185884,-4.0017078 c -1.7454984,2.3720609 -1.7354408,5.6174519 -6e-7,8.035443 z"
     style="font-size:12px;fill-rule:evenodd;stroke-width:0.625;stroke-linejoin:round"
     id="path4198-7"
     inkscape:connector-curvature="0" />';
  echo'</marker>';
  echo'<marker
     style="overflow:visible"
     id="marker4196"
     refX="0"
     refY="0"
     orient="auto"
     inkscape:stockid="Arrow2Mend">';
    echo'<path
     transform="scale(-0.6,-0.6)"
     d="M 8.7185878,4.0337352 -2.2072895,0.01601326 8.7185884,-4.0017078 c -1.7454984,2.3720609 -1.7354408,5.6174519 -6e-7,8.035443 z"
     style="font-size:12px;fill-rule:evenodd;stroke-width:0.625;stroke-linejoin:round"
     id="path4198"
     inkscape:connector-curvature="0" />';
  echo'</marker>';
  echo'<marker
     style="overflow:visible"
     id="marker7782-9"
     refX="0"
     refY="0"
     orient="auto"
     inkscape:stockid="Arrow2Mend">';
    echo'<path
     transform="scale(-0.6,-0.6)"
     d="M 8.7185878,4.0337352 -2.2072895,0.01601326 8.7185884,-4.0017078 c -1.7454984,2.3720609 -1.7354408,5.6174519 -6e-7,8.035443 z"
     style="font-size:12px;fill-rule:evenodd;stroke-width:0.625;stroke-linejoin:round"
     id="path7784-48"
     inkscape:connector-curvature="0" />';
  echo'</marker>';
  echo'<marker
     style="overflow:visible"
     id="marker7782-7"
     refX="0"
     refY="0"
     orient="auto"
     inkscape:stockid="Arrow2Mend">';
    echo'<path
     transform="scale(-0.6,-0.6)"
     d="M 8.7185878,4.0337352 -2.2072895,0.01601326 8.7185884,-4.0017078 c -1.7454984,2.3720609 -1.7354408,5.6174519 -6e-7,8.035443 z"
     style="font-size:12px;fill-rule:evenodd;stroke-width:0.625;stroke-linejoin:round"
     id="path7784-4"
     inkscape:connector-curvature="0" />';
  echo'</marker>';
  echo'<marker
     style="overflow:visible"
     id="marker7782"
     refX="0"
     refY="0"
     orient="auto"
     inkscape:stockid="Arrow2Mend">';
    echo'<path
     transform="scale(-0.6,-0.6)"
     d="M 8.7185878,4.0337352 -2.2072895,0.01601326 8.7185884,-4.0017078 c -1.7454984,2.3720609 -1.7354408,5.6174519 -6e-7,8.035443 z"
     style="font-size:12px;fill-rule:evenodd;stroke-width:0.625;stroke-linejoin:round"
     id="path7784"
     inkscape:connector-curvature="0" />';
  echo'</marker>';
  echo'<marker
     style="overflow:visible"
     id="Arrow2Mend-5"
     refX="0"
     refY="0"
     orient="auto"
     inkscape:stockid="Arrow2Mend">';
    echo'<path
     transform="scale(-0.6,-0.6)"
     d="M 8.7185878,4.0337352 -2.2072895,0.01601326 8.7185884,-4.0017078 c -1.7454984,2.3720609 -1.7354408,5.6174519 -6e-7,8.035443 z"
     style="font-size:12px;fill-rule:evenodd;stroke-width:0.625;stroke-linejoin:round"
     id="path4574-2"
     inkscape:connector-curvature="0" />';
  echo'</marker>';
  echo'<linearGradient
     gradientUnits="userSpaceOnUse"
     y2="438.36218"
     x2="264"
     y1="441.36218"
     x1="89"
     id="linearGradient4189"
     xlink:href="#linearGradient4183"
     inkscape:collect="always" />';
  echo'<marker
     inkscape:stockid="TriangleInL"
     orient="auto"
     refY="0"
     refX="0"
     id="TriangleInL"
     style="overflow:visible">';
    echo'<path
     inkscape:connector-curvature="0"
     id="path4059"
     d="m 5.77,0 -8.65,5 0,-10 8.65,5 z"
     style="fill-rule:evenodd;stroke:#000000;stroke-width:1pt;marker-start:none"
     transform="scale(-0.8,-0.8)" />';
  echo'</marker>';
  echo'<marker
     inkscape:stockid="Arrow2Lstart"
     orient="auto"
     refY="0"
     refX="0"
     id="Arrow2Lstart"
     style="overflow:visible">';
    echo'<path
     inkscape:connector-curvature="0"
     id="path3943"
     style="font-size:12px;fill-rule:evenodd;stroke-width:0.625;stroke-linejoin:round"
     d="M 8.7185878,4.0337352 -2.2072895,0.01601326 8.7185884,-4.0017078 c -1.7454984,2.3720609 -1.7354408,5.6174519 -6e-7,8.035443 z"
     transform="matrix(1.1,0,0,1.1,1.1,0)" />';
  echo'</marker>';
  echo'<marker
     inkscape:stockid="TriangleOutL"
     orient="auto"
     refY="0"
     refX="0"
     id="TriangleOutL"
     style="overflow:visible">';
    echo'<path
     inkscape:connector-curvature="0"
     id="path4068"
     d="m 5.77,0 -8.65,5 0,-10 8.65,5 z"
     style="fill-rule:evenodd;stroke:#000000;stroke-width:1pt;marker-start:none"
     transform="scale(0.8,0.8)" />';
  echo'</marker>';
  echo'<marker
     inkscape:stockid="DiamondSstart"
     orient="auto"
     refY="0"
     refX="0"
     id="DiamondSstart"
     style="overflow:visible">';
    echo'<path
     inkscape:connector-curvature="0"
     id="path4020"
     d="M 0,-7.0710768 -7.0710894,0 0,7.0710589 7.0710462,0 0,-7.0710768 z"
     style="fill-rule:evenodd;stroke:#000000;stroke-width:1pt;marker-start:none"
     transform="matrix(0.2,0,0,0.2,1.2,0)" />';
  echo'</marker>';
  echo'<marker
     inkscape:stockid="Arrow1Invest"
     orient="auto"
     refY="0"
     refX="0"
     id="Arrow1Invest"
     style="overflow:visible">';
    echo'<path
     inkscape:connector-curvature="0"
     id="path3928"
     d="M 0,0 5,-5 -12.5,0 5,5 0,0 z"
     style="fill-rule:evenodd;stroke:#000000;stroke-width:1pt;marker-start:none"
     transform="matrix(-0.8,0,0,-0.8,-10,0)" />';
  echo'</marker>';
  echo'<marker
     inkscape:stockid="Arrow1Lstart"
     orient="auto"
     refY="0"
     refX="0"
     id="Arrow1Lstart"
     style="overflow:visible">';
    echo'<path
     inkscape:connector-curvature="0"
     id="path3925"
     d="M 0,0 5,-5 -12.5,0 5,5 0,0 z"
     style="fill-rule:evenodd;stroke:#000000;stroke-width:1pt;marker-start:none"
     transform="matrix(0.8,0,0,0.8,10,0)" />';
  echo'</marker>';
  echo'<marker
     inkscape:stockid="TriangleOutL"
     orient="auto"
     refY="0"
     refX="0"
     id="TriangleOutL-6"
     style="overflow:visible">';
    echo'<path
     inkscape:connector-curvature="0"
     id="path4068-1"
     d="m 5.77,0 -8.65,5 0,-10 8.65,5 z"
     style="fill-rule:evenodd;stroke:#000000;stroke-width:1pt;marker-start:none"
     transform="scale(0.8,0.8)" />';
  echo'</marker>';
  echo'<marker
     inkscape:stockid="TriangleOutL"
     orient="auto"
     refY="0"
     refX="0"
     id="TriangleOutL-6-9"
     style="overflow:visible">';
    echo'<path
     inkscape:connector-curvature="0"
     id="path4068-1-3"
     d="m 5.77,0 -8.65,5 0,-10 8.65,5 z"
     style="fill-rule:evenodd;stroke:#000000;stroke-width:1pt;marker-start:none"
     transform="scale(0.8,0.8)" />';
  echo'</marker>';
  echo'<marker
     inkscape:stockid="TriangleOutL"
     orient="auto"
     refY="0"
     refX="0"
     id="TriangleOutL-6-9-9"
     style="overflow:visible">';
    echo'<path
     inkscape:connector-curvature="0"
     id="path4068-1-3-8"
     d="m 5.77,0 -8.65,5 0,-10 8.65,5 z"
     style="fill-rule:evenodd;stroke:#000000;stroke-width:1pt;marker-start:none"
     transform="scale(0.8,0.8)" />';
  echo'</marker>';
  echo'<marker
     inkscape:stockid="TriangleOutL"
     orient="auto"
     refY="0"
     refX="0"
     id="TriangleOutL-6-9-9-8"
     style="overflow:visible">';
    echo'<path
     inkscape:connector-curvature="0"
     id="path4068-1-3-8-6"
     d="m 5.77,0 -8.65,5 0,-10 8.65,5 z"
     style="fill-rule:evenodd;stroke:#000000;stroke-width:1pt;marker-start:none"
     transform="scale(0.8,0.8)" />';
  echo'</marker>';
  echo'<linearGradient
     id="linearGradient4183"
     inkscape:collect="always">';
    echo'<stop
     id="stop4185"
     offset="0"
     style="stop-color:#000000;stop-opacity:1;" />';
    echo'<stop
     id="stop4187"
     offset="1"
     style="stop-color:#000000;stop-opacity:0;" />';
  echo'</linearGradient>';
  echo'<marker
     style="overflow:visible"
     id="Arrow2Mstart"
     refX="0"
     refY="0"
     orient="auto"
     inkscape:stockid="Arrow2Mstart">';
    echo'<path
     inkscape:connector-curvature="0"
     transform="scale(0.6,0.6)"
     d="M 8.7185878,4.0337352 -2.2072895,0.01601326 8.7185884,-4.0017078 c -1.7454984,2.3720609 -1.7354408,5.6174519 -6e-7,8.035443 z"
     style="font-size:12px;fill-rule:evenodd;stroke-width:0.625;stroke-linejoin:round"
     id="path4571" />';
  echo'</marker>';
  echo'<marker
     style="overflow:visible"
     id="Arrow1Mend"
     refX="0"
     refY="0"
     orient="auto"
     inkscape:stockid="Arrow1Mend">';
    echo'<path
     inkscape:connector-curvature="0"
     transform="matrix(-0.4,0,0,-0.4,-4,0)"
     style="fill-rule:evenodd;stroke:#000000;stroke-width:1pt;marker-start:none"
     d="M 0,0 5,-5 -12.5,0 5,5 0,0 z"
     id="path4556" />';
  echo'</marker>';
  echo'<marker
     style="overflow:visible"
     id="Arrow2Mend-4"
     refX="0"
     refY="0"
     orient="auto"
     inkscape:stockid="Arrow2Mend">';
    echo'<path
     inkscape:connector-curvature="0"
     transform="scale(-0.6,-0.6)"
     d="M 8.7185878,4.0337352 -2.2072895,0.01601326 8.7185884,-4.0017078 c -1.7454984,2.3720609 -1.7354408,5.6174519 -6e-7,8.035443 z"
     style="font-size:12px;fill-rule:evenodd;stroke-width:0.625;stroke-linejoin:round"
     id="path4574" />';
  echo'</marker>';
  echo'<marker
     style="overflow:visible"
     id="Arrow2Mend-4-8"
     refX="0"
     refY="0"
     orient="auto"
     inkscape:stockid="Arrow2Mend">';
    echo'<path
     inkscape:connector-curvature="0"
     transform="scale(-0.6,-0.6)"
     d="M 8.7185878,4.0337352 -2.2072895,0.01601326 8.7185884,-4.0017078 c -1.7454984,2.3720609 -1.7354408,5.6174519 -6e-7,8.035443 z"
     style="font-size:12px;fill-rule:evenodd;stroke-width:0.625;stroke-linejoin:round"
     id="path4574-3" />';
  echo'</marker>';
  echo'<marker
     style="overflow:visible"
     id="Arrow2Mend-4-2"
     refX="0"
     refY="0"
     orient="auto"
     inkscape:stockid="Arrow2Mend">';
    echo'<path
     inkscape:connector-curvature="0"
     transform="scale(-0.6,-0.6)"
     d="M 8.7185878,4.0337352 -2.2072895,0.01601326 8.7185884,-4.0017078 c -1.7454984,2.3720609 -1.7354408,5.6174519 -6e-7,8.035443 z"
     style="font-size:12px;fill-rule:evenodd;stroke-width:0.625;stroke-linejoin:round"
     id="path4574-78" />';
  echo'</marker>';
  echo'<marker
     style="overflow:visible"
     id="Arrow2Mend-4-8-2"
     refX="0"
     refY="0"
     orient="auto"
     inkscape:stockid="Arrow2Mend">';
    echo'<path
     inkscape:connector-curvature="0"
     transform="scale(-0.6,-0.6)"
     d="M 8.7185878,4.0337352 -2.2072895,0.01601326 8.7185884,-4.0017078 c -1.7454984,2.3720609 -1.7354408,5.6174519 -6e-7,8.035443 z"
     style="font-size:12px;fill-rule:evenodd;stroke-width:0.625;stroke-linejoin:round"
     id="path4574-3-0" />';
  echo'</marker>';
  echo'<marker
     style="overflow:visible"
     id="Arrow2Mend-4-8-28"
     refX="0"
     refY="0"
     orient="auto"
     inkscape:stockid="Arrow2Mend">';
    echo'<path
     inkscape:connector-curvature="0"
     transform="scale(-0.6,-0.6)"
     d="M 8.7185878,4.0337352 -2.2072895,0.01601326 8.7185884,-4.0017078 c -1.7454984,2.3720609 -1.7354408,5.6174519 -6e-7,8.035443 z"
     style="font-size:12px;fill-rule:evenodd;stroke-width:0.625;stroke-linejoin:round"
     id="path4574-3-2" />';
  echo'</marker>';
  echo'<marker
     style="overflow:visible"
     id="Arrow2Mend-4-8-5"
     refX="0"
     refY="0"
     orient="auto"
     inkscape:stockid="Arrow2Mend">';
    echo'<path
     inkscape:connector-curvature="0"
     transform="scale(-0.6,-0.6)"
     d="M 8.7185878,4.0337352 -2.2072895,0.01601326 8.7185884,-4.0017078 c -1.7454984,2.3720609 -1.7354408,5.6174519 -6e-7,8.035443 z"
     style="font-size:12px;fill-rule:evenodd;stroke-width:0.625;stroke-linejoin:round"
     id="path4574-3-5" />';
  echo'</marker>';
  echo'<marker
     style="overflow:visible"
     id="Arrow2Mend-4-8-7"
     refX="0"
     refY="0"
     orient="auto"
     inkscape:stockid="Arrow2Mend">';
    echo'<path
     inkscape:connector-curvature="0"
     transform="scale(-0.6,-0.6)"
     d="M 8.7185878,4.0337352 -2.2072895,0.01601326 8.7185884,-4.0017078 c -1.7454984,2.3720609 -1.7354408,5.6174519 -6e-7,8.035443 z"
     style="font-size:12px;fill-rule:evenodd;stroke-width:0.625;stroke-linejoin:round"
     id="path4574-3-6" />';
  echo'</marker>';
  echo'<radialGradient
     inkscape:collect="always"
     xlink:href="#linearGradient10612"
     id="radialGradient10620"
     cx="206.5"
     cy="7.8621826"
     fx="206.5"
     fy="7.8621826"
     r="12.5"
     gradientTransform="matrix(1,0,0,0.92,0,0.62897461)"
     gradientUnits="userSpaceOnUse" />';
  echo'<linearGradient
     inkscape:collect="always"
     xlink:href="#linearGradient10612"
     id="linearGradient10626"
     x1="194"
     y1="7.8621826"
     x2="219"
     y2="7.8621826"
     gradientUnits="userSpaceOnUse"
     spreadMethod="pad" />';
  echo'<linearGradient
     inkscape:collect="always"
     xlink:href="#linearGradient10628"
     id="linearGradient10634"
     x1="194"
     y1="7.8621826"
     x2="219"
     y2="7.8621826"
     gradientUnits="userSpaceOnUse" />';
  echo'</defs>';
  ;?>
 <?php echo'<sodipodi:namedview
   id="base"
   pagecolor="#ffffff"
   bordercolor="#666666"
   borderopacity="1.0"
   inkscape:pageopacity="0.0"
   inkscape:pageshadow="2"
   inkscape:zoom="0.5"
   inkscape:cx="249.76455"
   inkscape:cy="501.59104"
   inkscape:document-units="px"
   inkscape:current-layer="layer1"
   showgrid="false"
   inkscape:snap-global="false"
   inkscape:window-width="1280"
   inkscape:window-height="968"
   inkscape:window-x="-4"
   inkscape:window-y="-4"
   inkscape:window-maximized="1" />';
  echo'<metadata
   id="metadata7">';
  echo'<rdf:RDF>';
    echo'<cc:Work
     rdf:about="">';
    echo'<dc:format>image/svg+xml</dc:format>';
    echo'<dc:type
       rdf:resource="http://purl.org/dc/dcmitype/StillImage" />';
    echo'<dc:title>'; echo'</dc:title>';
    echo'</cc:Work>';
  echo'</rdf:RDF>';
  echo'</metadata>';
  echo'<g
   inkscape:label="Layer 1"
   inkscape:groupmode="layer"
   id="layer1"
   transform="translate(0,-652.36218)">';
  echo'<rect
     style="opacity:0;fill:#a5a5a5;fill-opacity:1;fill-rule:evenodd;stroke:#abab57;stroke-width:1;stroke-miterlimit:4;stroke-opacity:1;stroke-dasharray:2, 2;stroke-dashoffset:0"
     id="rect10565"
     width="272"
     height="120"
     x="62"
     y="390.36218"
     rx="2.6639636"
     ry="3" />';
  echo'<rect
     style="opacity:0;fill:#a5a5a5;fill-opacity:1;fill-rule:nonzero;stroke:#abab57;stroke-width:1;stroke-miterlimit:4;stroke-opacity:1;stroke-dasharray:2, 2;stroke-dashoffset:0"
     id="rect10575"
     width="204"
     height="135"
     x="176"
     y="427.36218"
     rx="2.6639636"
     ry="3" />';
  echo'<g
     id="g11059"
     transform="translate(10,-18)">';
    echo'<text
     sodipodi:linespacing="125%"
     id="text3770"
     y="876.16907"
     x="299.43152"
     style="font-size:12px;font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;text-align:start;line-height:125%;letter-spacing:0px;word-spacing:0px;writing-mode:lr-tb;text-anchor:start;fill:#ffffff;fill-opacity:1;stroke:none;font-family:Arial;-inkscape-font-specification:Arial"
     xml:space="preserve">'; echo'<tspan
       y="876.16907"
       x="299.43152"
       id="tspan3772"
       sodipodi:role="line">Pending(270)</tspan>'; echo'</text>';
    echo'<rect
     ry="3"
     rx="2.6639636"
     y="784.36218"
     x="107"
     height="50"
     width="163"
     id="rect5593"
     style="fill:none;stroke:none" />';
    echo'<g
     transform="translate(0,640)"
     id="g9211">';
   echo '<a
     xlink:href="'.Router::url(array('controller'=>'projects','action'=>'add','project_type'=> "equity"),true).'"
     target="_top"
     id="a64-6">';
    echo'<rect
       style="fill:#8cae50;fill-opacity:1;stroke:none"
       id="rect5597"
       width="90"
       height="24"
       x="73"
       y="231.36218"
       rx="2.6639636"
       ry="3" />';

    if (isPluginEnabled('Idea')) {
      $new_link = __l("Add Idea");
    } else {
      $new_link = __l("Add Project");
    }
    echo'<text
       xml:space="preserve"
       style="font-size:40px;font-style:normal;font-weight:normal;line-height:125%;letter-spacing:0px;word-spacing:0px;fill:#000000;fill-opacity:1;stroke:none;font-family:Sans"
       x="87"
       y="247.36218"
       id="text5599"
       sodipodi:linespacing="125%">'; echo'<tspan
       sodipodi:role="line"
       id="tspan5601"
       x="87"
       y="247.36218"
       style="font-size:12px;font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;fill:#ffffff;fill-opacity:1;font-family:Arial;-inkscape-font-specification:Arial">' .$new_link. '</tspan>'; echo'</text>';
    echo '</a>';
    echo'</g>';
    echo'<g
     transform="translate(0,640)"
     id="g9139">';
   echo '<a
     xlink:href="'.Router::url(array('controller'=>'equities','action'=>'index','project_status_id' => ConstEquityProjectStatus::Pending),true).'"
     target="_top"
     id="a64-6">';
    echo'<rect
       style="fill:#E49F18;fill-opacity:1;stroke:none"
       id="rect5597-4"
       width="90"
       height="24"
       x="268"
       y="232.36218"
       rx="2.6639636"
       ry="3" />';
    echo'<text
       xml:space="preserve"
       style="font-size:40px;font-style:normal;font-weight:normal;line-height:125%;letter-spacing:0px;word-spacing:0px;fill:#000000;fill-opacity:1;stroke:none;font-family:Sans"
       x="281.6748"
       y="248.39441"
       id="text5599-8"
       sodipodi:linespacing="125%">'; echo'<tspan
       sodipodi:role="line"
       id="tspan5601-8"
       x="281.6748"
       y="248.39441"
       style="font-size:12px;font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;fill:#ffffff;fill-opacity:1;font-family:Arial;-inkscape-font-specification:Arial">'.sprintf(__l('Pending (%s)'),$this->Html->cInt($pending_project_count,false)).'</tspan>'; echo'</text>';
    echo '</a>';
    echo'</g>';
    echo'<path
     inkscape:connector-curvature="3"
     inkscape:connector-type="polyline"
     id="path5644"
     d="m 163,883.59295 105,0.53846"
     style="fill:none;stroke:#000000;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1;marker-end:url(#Arrow2Mend-4)" />';
    echo'<g
     transform="translate(0,640)"
     id="g9216">';
   echo '<a
     xlink:href="'.Router::url(array('controller'=>'equities','action'=>'index','project_status_id' => ConstEquityProjectStatus::OpenForInvesting),true).'"
     target="_top"
     id="a64-6">';
    echo'<rect
       style="fill:#8F91DB;fill-opacity:1;stroke:none"
       id="rect5597-4-2"
       width="139"
       height="24"
       x="475"
       y="231.36218"
       rx="4.1143436"
       ry="3" />';
    echo'<text
       xml:space="preserve"
       style="font-size:40px;font-style:normal;font-weight:normal;line-height:125%;letter-spacing:0px;word-spacing:0px;fill:#000000;fill-opacity:1;stroke:none;font-family:Sans"
       x="491.0293"
       y="246.46765"
       id="text5599-8-4"
       sodipodi:linespacing="125%">'; echo'<tspan
       sodipodi:role="line"
       id="tspan5601-8-5"
       x="486.0293"
       y="246.46765"
       style="font-size:12px;font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;fill:#ffffff;fill-opacity:1;font-family:Arial;-inkscape-font-specification:Arial">'.__l('Open for investing') . ' (' . $this->Html->cInt($opened_project_count,false) . ')'.'</tspan>'; echo'</text>';
    echo '</a>';
    echo'</g>';
    echo'<path
     inkscape:connector-curvature="3"
     inkscape:connector-type="polyline"
     id="path7809"
     d="m 358,884.1678 117,-0.5054"
     style="fill:none;stroke:#000000;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1;marker-end:url(#Arrow2Mend-4)" />';

    echo'<g
     transform="translate(0,640)"
     id="g9226">';
   echo '<a
     xlink:href="'.Router::url(array('controller'=>'equities','action'=>'index','project_status_id' => ConstEquityProjectStatus::ProjectClosed),true).'"
     target="_top"
     id="a64-6">';
    echo'<rect
       style="fill:#557D36;fill-opacity:1;stroke:none"
       id="rect5597-4-2-5-1"
       width="76"
       height="24"
       x="675"
       y="231.36218"
       rx="2.2495692"
       ry="3" />';
    echo'<text
       xml:space="preserve"
       style="font-size:40px;font-style:normal;font-weight:normal;line-height:125%;letter-spacing:0px;word-spacing:0px;fill:#000000;fill-opacity:1;stroke:none;font-family:Sans"
       x="680.03"
       y="246.47058"
       id="text5599-8-4-1-1"
       sodipodi:linespacing="125%">'; echo'<tspan
       sodipodi:role="line"
       id="tspan5601-8-5-7-5"
       x="680.03"
       y="246.47058"
       style="font-size:12px;font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;fill:#ffffff;fill-opacity:1;font-family:Arial;-inkscape-font-specification:Arial">'.sprintf(__l('Closed (%s)'),$this->Html->cInt($closed_project_count,false)).'</tspan>'; echo'</text>';
    echo '</a>';
    echo'</g>';
    echo'<path
     inkscape:connector-curvature="3"
     inkscape:connector-type="polyline"
     id="path8110"
     d="m 614,883.36218 59.5,0"
     style="fill:none;stroke:#000000;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1;marker-end:url(#Arrow2Mend-4)" />';
    echo'<g
     transform="translate(26,664)"
     id="g9105">';
   echo '<a
     xlink:href="'.Router::url(array('controller'=>'equities','action'=>'index','transaction_type_id' => ConstTransactionTypes::ListingFee),true).'"
     target="_top"
     id="a64-6">';
    echo'<rect
       style="fill:#E49F18;fill-opacity:0;stroke:#abab57;stroke-width:0.99319583;stroke-miterlimit:4;stroke-opacity:1;stroke-dasharray:1.98639164, 1.98639164;stroke-dashoffset:0"
       id="rect5597-4-27"
       width="142.00681"
       height="24.006804"
       x="123.99659"
       y="146.35878"
       rx="4.2033439"
       ry="3.0008504" />';
    echo'<text
       xml:space="preserve"
       style="font-size:40px;font-style:normal;font-weight:normal;line-height:125%;letter-spacing:0px;word-spacing:0px;fill:#000000;fill-opacity:1;stroke:none;font-family:Sans"
       x="139.6748"
       y="163.39441"
       id="text5599-3"
       sodipodi:linespacing="125%">'; echo'<tspan
       sodipodi:role="line"
       id="tspan5601-6"
       x="139.6748"
       y="163.39441"
       style="font-size:12px;font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;fill:#abab57;fill-opacity:1;font-family:Arial;-inkscape-font-specification:Arial">'.sprintf(__l('Listing Fee Paid (%s)'),$this->Html->cInt($paid_projects,false)).'</tspan>'; echo'</text>';
   echo '</a>';
    echo'</g>';
    echo'<g
     transform="translate(215.00001,663)"
     id="g9105-2">';
   echo '<a
     xlink:href="'.Router::url(array('controller'=>'equities','action'=>'index','project_status_id' => ConstEquityProjectStatus::OpenForIdea),true).'"
     target="_top"
     id="a64-6">';
    echo'<rect
       style="fill:#78a595;fill-opacity:0;stroke:#abab57;stroke-width:0.92958486;stroke-miterlimit:4;stroke-opacity:1;stroke-dasharray:1.85916971, 1.85916971;stroke-dashoffset:0"
       id="rect5597-4-27-4"
       width="124.07042"
       height="24.070414"
       x="137.96478"
       y="146.32698"
       rx="3.6724341"
       ry="3.0088017" />';
    echo'<text
       xml:space="preserve"
       style="font-size:40px;font-style:normal;font-weight:normal;line-height:125%;letter-spacing:0px;word-spacing:0px;fill:#000000;fill-opacity:1;stroke:none;font-family:Sans"
       x="151.6748"
       y="163.39441"
       id="text5599-3-5"
       sodipodi:linespacing="125%">'; echo'<tspan
       sodipodi:role="line"
       id="tspan5601-6-8"
       x="145.6748"
       y="163.39441"
       style="font-size:12px;font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;fill:#78a595;fill-opacity:1;font-family:Arial;-inkscape-font-specification:Arial"> '.__l('Open for voting') . ' (' . $this->Html->cInt($open_for_idea,false) . ')'.'</tspan>'; echo'</text>';
    echo '</a>';
    echo'</g>';
    echo'<g
     id="g9139-8"
     transform="translate(237,577)">';
   echo '<a
     xlink:href="'.Router::url(array('controller'=>'equities','action'=>'index','project_status_id' => ConstEquityProjectStatus::ProjectCanceled),true).'"
     target="_top"
     id="a64-6">';
    echo'<rect
       style="fill:#FF85AD;fill-opacity:1;stroke:none"
       id="rect5597-4-1"
       width="90"
       height="24"
       x="268"
       y="232.36218"
       rx="2.6639636"
       ry="3" />';
    echo'<text
       xml:space="preserve"
       style="font-size:40px;font-style:normal;font-weight:normal;line-height:125%;letter-spacing:0px;word-spacing:0px;fill:#000000;fill-opacity:1;stroke:none;font-family:Sans"
       x="275.6748"
       y="248.39441"
       id="text5599-8-2"
       sodipodi:linespacing="125%">'; echo'<tspan
       sodipodi:role="line"
       id="tspan5601-8-1"
       x="278.6748"
       y="248.39441"
       style="font-size:12px;font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;fill:#ffffff;fill-opacity:1;font-family:Arial;-inkscape-font-specification:Arial">'.__l('Canceled') . ' (' . $this->Html->cInt($canceled_project_count,false) . ')'.'</tspan>'; echo'</text>';
    echo '</a>';
    echo'</g>';
    echo'<g
     transform="translate(0,626)"
     id="g9238">';
   echo '<a
     xlink:href="'.Router::url(array('controller'=>'equities','action'=>'index','project_status_id' => ConstEquityProjectStatus::ProjectExpired),true).'"
     target="_top"
     id="a64-6">';
    echo'<rect
       style="fill:#49C8F5;fill-opacity:1;stroke:none"
       id="rect5597-4-9"
       width="90"
       height="24"
       x="499"
       y="311.36218"
       rx="2.6639636"
       ry="3" />';
    echo'<text
       xml:space="preserve"
       style="font-size:40px;font-style:normal;font-weight:normal;line-height:125%;letter-spacing:0px;word-spacing:0px;fill:#000000;fill-opacity:1;stroke:none;font-family:Sans"
       x="512.6748"
       y="327.39441"
       id="text5599-8-8"
       sodipodi:linespacing="125%">'; echo'<tspan
       sodipodi:role="line"
       id="tspan5601-8-2"
       x="512.6748"
       y="327.39441"
       style="font-size:12px;font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;fill:#ffffff;fill-opacity:1;font-family:Arial;-inkscape-font-specification:Arial">'.sprintf(__l('Expired (%s)'),$this->Html->cInt($expired_project_count,false)).'</tspan>'; echo'</text>';
    echo '</a>';
    echo'</g>';
    echo'<path
     inkscape:connection-end-point="d4"
     inkscape:connection-end="#g9211"
     inkscape:connection-start-point="d4"
     inkscape:connection-start="#g9211"
     inkscape:connector-curvature="3"
     inkscape:connector-type="polyline"
     id="path9243"
     d="m 118,883.36218 0,0"
     style="fill:none;stroke:#000000;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" />';
   if($formFieldStep){
   echo'<g
     transform="translate(0,626)"
     id="g9238">';
   echo '<a
     xlink:href="'.Router::url(array('controller'=>'equities','action'=>'index','project_status_id' => ConstEquityProjectStatus::PendingAction),true).'"
     target="_top"
     id="a64-6">';
    echo'<rect
       style="fill:#726D78;fill-opacity:0.7;stroke:#726D78;stroke-width:0.99319583;stroke-miterlimit:4;stroke-opacity:1;stroke-dasharray:1.98639164, 1.98639164;stroke-dashoffset:0"
       id="rect5597-4-3"
       width="179"
       height="24"
       x="232"
       y="311.36218"
       rx="2.6639636"
       ry="3" />';
    echo'<text
       xml:space="preserve"
       style="font-size:40px;font-style:normal;font-weight:normal;line-height:125%;letter-spacing:0px;word-spacing:0px;fill:#000000;fill-opacity:1;stroke:none;font-family:Sans"
       x="512.6748"
       y="327.39441"
       id="text5599-8-8"
       sodipodi:linespacing="125%">'; echo'<tspan
       sodipodi:role="line"
       id="tspan5601-8-2"
       x="250.6748"
       y="327.39441"
       style="font-size:12px;font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;fill:#ffffff;fill-opacity:1;font-family:Arial;-inkscape-font-specification:Arial">'.sprintf(__l('Pending Action to Admin (%s)'),$this->Html->cInt($pending_action_to_admin_count,false)).'</tspan>'; echo'</text>';
    echo '</a>';
    echo'</g>';
	echo'<path
     inkscape:connector-curvature="3"
     inkscape:connector-type="polyline"
     id="path10097-8-1"
     d="m 312.87551,895.25995 -0.10256,41.21171"
     style="fill:none;stroke:#000000;stroke-width:0.77969152px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1;marker-end:url(#Arrow2Mend-4-8)" />';
	}
    echo'<path
     inkscape:connection-end-point="d4"
     inkscape:connection-end="#g9105"
     inkscape:connection-start-point="d4"
     inkscape:connection-start="#g9105"
     inkscape:connector-curvature="3"
     inkscape:connector-type="polyline"
     id="path9255"
     d="m 220.99999,822.36218 0,0"
     style="fill:none;stroke:#000000;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" />';
    echo'<path
     inkscape:connector-curvature="3"
     inkscape:connector-type="polyline"
     id="path9253"
     d="m 117.53118,871.42626 -0.20693,-48.42104"
     style="fill:#a5a5a5;fill-opacity:1;stroke:#000000;stroke-width:0.8812142px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" />';
    echo'<path
     inkscape:connector-curvature="3"
     inkscape:connector-type="polyline"
     id="path9257"
     d="m 117.17493,823.53267 31.99749,-0.19795"
     style="fill:#a5a5a5;fill-opacity:1;stroke:#000000;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1;marker-end:url(#Arrow2Mend-4)" />';
    echo'<path
     inkscape:connector-curvature="3"
     inkscape:connector-type="polyline"
     id="path10095"
     d="m 292.34036,824.36218 15.39895,0"
     style="fill:none;stroke:#000000;stroke-width:0.83669639px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1;display:inline" />';
    echo'<path
     inkscape:connector-curvature="3"
     inkscape:connector-type="polyline"
     id="path10097"
     d="m 307.22862,824.69039 -0.47321,47.23229"
     style="fill:none;stroke:#000000;stroke-width:0.82898831px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1;marker-end:url(#Arrow2Mend-4-8)" />';
    echo'<path
     inkscape:connector-curvature="3"
     inkscape:connector-type="polyline"
     id="path9253-8"
     d="m 329.6673,872.60631 0.0767,-48.42142"
     style="fill:#a5a5a5;fill-opacity:1;stroke:#000000;stroke-width:0.8812142px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" />';
    echo'<path
     inkscape:connector-curvature="3"
     inkscape:connector-type="polyline"
     id="path9257-0"
     d="m 329.32523,824.26871 22.82779,-0.2052"
     style="fill:#a5a5a5;fill-opacity:1;stroke:#000000;stroke-width:0.85998046px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1;marker-end:url(#Arrow2Mend-4)" />';
    echo'<path
     inkscape:connector-curvature="3"
     inkscape:connector-type="polyline"
     id="path10097-8"
     d="m 494.92179,823.15432 -0.4732,47.23204"
     style="fill:none;stroke:#000000;stroke-width:0.8289693px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1;marker-end:url(#Arrow2Mend-4-8)" />';
    echo'<path
     inkscape:connector-curvature="3"
     inkscape:connector-type="polyline"
     id="path10095-9"
     d="m 476.37783,823.61218 18.24435,0"
     style="fill:none;stroke:#000000;stroke-width:0.91072339px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1;display:inline" />';
    echo'<path
     inkscape:connector-curvature="3"
     inkscape:connector-type="polyline"
     id="path10097-8-0"
     d="m 541.60935,871.43896 -0.0432,-37.03579"
     style="fill:none;stroke:#000000;stroke-width:0.74374002px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1;marker-end:url(#Arrow2Mend-4-8)" />';
    echo'<path
     inkscape:connector-curvature="3"
     inkscape:connector-type="polyline"
     id="path10097-8-2"
     d="m 541.87551,895.25995 -0.10256,41.21171"
     style="fill:none;stroke:#000000;stroke-width:0.77969152px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1;marker-end:url(#Arrow2Mend-4-8)" />';



    echo'<g
     transform="matrix(0.71715729,0,0,0.70227083,194.46661,424.22137)" class="circle first"
     onmousemove="ShowTooltip(evt, \''.sprintf(__l('If listing fee added in settings, all %s can be added only when %s pay the fee.'), Configure::read('project.alt_name_for_project_plural_small'), Configure::read('project.alt_name_for_borrow_noun_singular_small')).'\',this, 50, 130)"
     onmouseout="HideTooltip(evt, this)"
     id="g10936">';
    echo'<rect
       style="fill:#404040;fill-opacity:1;fill-rule:nonzero"
       id="rect10930"
       width="20"
       height="19"
       x="126"
       y="535.36218"
       rx="9.166667"
       ry="9.5" />';
    echo'<text
       xml:space="preserve"
       style="font-size:63.35290909px;font-style:normal;font-weight:normal;line-height:125%;letter-spacing:0px;word-spacing:0px;fill:#000000;fill-opacity:1;stroke:none;font-family:Arial;-inkscape-font-specification:Arial"
       x="83.076973"
       y="871.22046"
       id="text10932"
       sodipodi:linespacing="125%"
       transform="scale(1.5838227,0.6313838)">'; echo'<tspan
       sodipodi:role="line"
       id="tspan10934"
       x="83.076973"
       y="871.22046"
       style="font-size:25.34116364px;fill:#ffffff;fill-opacity:1">i</tspan>'; echo'</text>';
    echo'</g>';
    echo'<g
     transform="matrix(0.71715729,0,0,0.70227083,67.46661,486.72137)" class="circle first"
     onmousemove="ShowTooltip(evt, \''. sprintf(__l('If idea enabled, all projects considered as ideas. If not, considered as %s.'), Configure::read('project.alt_name_for_project_plural_small')).'\',this, 50, 130)"
     onmouseout="HideTooltip(evt, this)"
     id="g10936-7">';
    echo'<rect
       style="fill:#404040;fill-opacity:1;fill-rule:nonzero"
       id="rect10930-2"
       width="20"
       height="19"
       x="126"
       y="535.36218"
       rx="9.166667"
       ry="9.5" />';
    echo'<text
       xml:space="preserve"
       style="font-size:63.35290909px;font-style:normal;font-weight:normal;line-height:125%;letter-spacing:0px;word-spacing:0px;fill:#000000;fill-opacity:1;stroke:none;font-family:Arial;-inkscape-font-specification:Arial"
       x="83.076973"
       y="871.22046"
       id="text10932-5"
       sodipodi:linespacing="125%"
       transform="scale(1.5838227,0.6313838)">'; echo'<tspan
       sodipodi:role="line"
       id="tspan10934-5"
       x="83.076973"
       y="871.22046"
       style="font-size:25.34116364px;fill:#ffffff;fill-opacity:1">i</tspan>'; echo'</text>';
    echo'</g>';
	if($formFieldStep){
		echo'<g
		 transform="matrix(0.71715729,0,0,0.70227083,260.46661,488.72137)" class="circle first"
		 onmousemove="ShowTooltip(evt, \''.sprintf(__l('All %s will be approved by Admin.'), Configure::read('project.alt_name_for_project_plural_small')).'\',this, 50, 130)"
		 onmouseout="HideTooltip(evt, this)"
		 id="g10936-2">';
	} else {
				echo'<g
		 transform="matrix(0.71715729,0,0,0.70227083,260.46661,488.72137)" class="circle first"
		 onmousemove="ShowTooltip(evt, \''.sprintf(__l('All %s will be approved automatically.'), Configure::read('project.alt_name_for_project_plural_small')).'\',this, 50, 130)"
		 onmouseout="HideTooltip(evt, this)"
		 id="g10936-2">';

	}
    echo'<rect
       style="fill:#404040;fill-opacity:1;fill-rule:nonzero"
       id="rect10930-1"
       width="20"
       height="19"
       x="126"
       y="535.36218"
       rx="9.166667"
       ry="9.5" />';
    echo'<text
       xml:space="preserve"
       style="font-size:63.35290909px;font-style:normal;font-weight:normal;line-height:125%;letter-spacing:0px;word-spacing:0px;fill:#000000;fill-opacity:1;stroke:none;font-family:Arial;-inkscape-font-specification:Arial"
       x="83.076973"
       y="871.22046"
       id="text10932-4"
       sodipodi:linespacing="125%"
       transform="scale(1.5838227,0.6313838)">'; echo'<tspan
       sodipodi:role="line"
       id="tspan10934-8"
       x="83.076973"
       y="871.22046"
       style="font-size:25.34116364px;fill:#ffffff;fill-opacity:1">i</tspan>'; echo'</text>';
    echo'</g>';
	echo'<g
		 transform="matrix(0.71715729,0,0,0.70227083,260.46661,488.72137)" class="circle first"
		 onmousemove="ShowTooltip(evt, \''.sprintf(__l('%s confirmation step waiting for admin approval.'), Configure::read('project.alt_name_for_project_singular_caps')).'\',this, 50, 65)"
		 onmouseout="HideTooltip(evt, this)"
		 id="g10936-2">';
    echo'<rect
       style="fill:#404040;fill-opacity:1;fill-rule:nonzero"
       id="rect10930-1"
       width="20"
       height="19"
       x="197"
       y="627.362"
       rx="9.166667"
       ry="9.5" />';
    echo'<text
       xml:space="preserve"
       style="font-size:63.35290909px;font-style:normal;font-weight:normal;line-height:125%;letter-spacing:0px;word-spacing:0px;fill:#000000;fill-opacity:1;stroke:none;font-family:Arial;-inkscape-font-specification:Arial"
       x="83.076973"
       y="871.22046"
       id="text10932-4"
       sodipodi:linespacing="125%"
       transform="scale(1.5838227,0.6313838)">'; echo'<tspan
       sodipodi:role="line"
       id="tspan10934-8"
       x="127.97"
       y="1019.42"
       style="font-size:25.34116364px;fill:#ffffff;fill-opacity:1">i</tspan>'; echo'</text>';
    echo'</g>';
    echo'<g
     transform="matrix(0.71715729,0,0,0.70227083,380.46661,423.72137)" class="circle first"
     onmousemove="ShowTooltip(evt, \''.sprintf(__l('If idea is enabled, initially all the %s will be considered as an idea. Based on votes, it will be moved as a %s by administrator.'), Configure::read('project.alt_name_for_project_singular_small'), Configure::read('project.alt_name_for_project_singular_small')).'\',this, 50, 130)"
     onmouseout="HideTooltip(evt, this)"
     id="g10936-6">';
    echo'<rect
       style="fill:#404040;fill-opacity:1;fill-rule:nonzero"
       id="rect10930-4"
       width="20"
       height="19"
       x="126"
       y="535.36218"
       rx="9.166667"
       ry="9.5" />';
    echo'<text
       xml:space="preserve"
       style="font-size:63.35290909px;font-style:normal;font-weight:normal;line-height:125%;letter-spacing:0px;word-spacing:0px;fill:#000000;fill-opacity:1;stroke:none;font-family:Arial;-inkscape-font-specification:Arial"
       x="83.076973"
       y="871.22046"
       id="text10932-6"
       sodipodi:linespacing="125%"
       transform="scale(1.5838227,0.6313838)">'; echo'<tspan
       sodipodi:role="line"
       id="tspan10934-89"
       x="83.076973"
       y="871.22046"
       style="font-size:25.34116364px;fill:#ffffff;fill-opacity:1">i</tspan>'; echo'</text>';
    echo'</g>';
    echo'<g
     transform="matrix(0.71715729,0,0,0.70227083,497.46661,423.72137)" class="circle first"
     onmousemove="ShowTooltip(evt, \''.__l("Amount authorization will be canceled").'\',this, 50, 130)"
     onmouseout="HideTooltip(evt, this)"
     id="g10936-8">';
    echo'<rect
       style="fill:#404040;fill-opacity:1;fill-rule:nonzero"
       id="rect10930-3"
       width="20"
       height="19"
       x="126"
       y="535.36218"
       rx="9.166667"
       ry="9.5" />';
    echo'<text
       xml:space="preserve"
       style="font-size:63.35290909px;font-style:normal;font-weight:normal;line-height:125%;letter-spacing:0px;word-spacing:0px;fill:#000000;fill-opacity:1;stroke:none;font-family:Arial;-inkscape-font-specification:Arial"
       x="83.076973"
       y="871.22046"
       id="text10932-55"
       sodipodi:linespacing="125%"
       transform="scale(1.5838227,0.6313838)">'; echo'<tspan
       sodipodi:role="line"
       id="tspan10934-1"
       x="83.076973"
       y="871.22046"
       style="font-size:25.34116364px;fill:#ffffff;fill-opacity:1">i</tspan>'; echo'</text>';
    echo'</g>';
    echo'<g
     transform="matrix(0.71715729,0,0,0.70227083,517.46661,487.72137)" class="circle first"
     onmousemove="ShowTooltip(evt, \''.sprintf(__l('%s accepting equities from %s.'), Configure::read('project.alt_name_for_project_plural_caps'), Configure::read('project.alt_name_for_investor_plural_small')).'\',this, 50, 130)"
     onmouseout="HideTooltip(evt, this)"
     id="g10936-5">';
    echo'<rect
       style="fill:#404040;fill-opacity:1;fill-rule:nonzero"
       id="rect10930-5"
       width="20"
       height="19"
       x="126"
       y="535.36218"
       rx="9.166667"
       ry="9.5" />';
    echo'<text
       xml:space="preserve"
       style="font-size:63.35290909px;font-style:normal;font-weight:normal;line-height:125%;letter-spacing:0px;word-spacing:0px;fill:#000000;fill-opacity:1;stroke:none;font-family:Arial;-inkscape-font-specification:Arial"
       x="83.076973"
       y="871.22046"
       id="text10932-8"
       sodipodi:linespacing="125%"
       transform="scale(1.5838227,0.6313838)">'; echo'<tspan
       sodipodi:role="line"
       id="tspan10934-4"
       x="83.076973"
       y="871.22046"
       style="font-size:25.34116364px;fill:#ffffff;fill-opacity:1">i</tspan>'; echo'</text>';
    echo'</g>';
    echo'<g
     transform="matrix(0.71715729,0,0,0.70227083,491.46661,553.72137)" class="circle first"
     onmousemove="ShowTooltip(evt, \'' .sprintf(__l('If needed amount not reached within the %s end date, %s moves to expire.'), Configure::read('project.alt_name_for_project_singular_small'), Configure::read('project.alt_name_for_project_plural_small')) .'\',this, 50, 30)"
     onmouseout="HideTooltip(evt, this)"
     id="g10936-0">';
    echo'<rect
       style="fill:#404040;fill-opacity:1;fill-rule:nonzero"
       id="rect10930-54"
       width="20"
       height="19"
       x="126"
       y="535.36218"
       rx="9.166667"
       ry="9.5" />';
    echo'<text
       xml:space="preserve"     style="font-size:63.35290909px;font-style:normal;font-weight:normal;line-height:125%;letter-spacing:0px;word-spacing:0px;fill:#000000;fill-opacity:1;stroke:none;font-family:Arial;-inkscape-font-specification:Arial"
       x="83.076973"
       y="871.22046"
       id="text10932-7"
       sodipodi:linespacing="125%"
       transform="scale(1.5838227,0.6313838)">'; echo'<tspan
       sodipodi:role="line"
       id="tspan10934-2"
       x="83.076973"
       y="871.22046"
       style="font-size:25.34116364px;fill:#ffffff;fill-opacity:1">i</tspan>'; echo'</text>';
    echo'</g>';

    echo'<g
     transform="matrix(0.71715729,0,0,0.70227083,807.46661,487.72137)" class="circle first"
     onmousemove="ShowTooltip(evt, \''.sprintf(__l('All fundings moves to %s wallet and commission amount moves to site admin account.'), Configure::read('project.alt_name_for_equity_project_owner_singular_small')).'\',this, 175, 60)"
     onmouseout="HideTooltip(evt, this)"
     id="g10936-3">';
    echo'<rect
       style="fill:#404040;fill-opacity:1;fill-rule:nonzero"
       id="rect10930-0"
       width="20"
       height="19"
       x="-82"
       y="535.36218"
       rx="9.166667"
       ry="9.5" />';
    echo'<text
       xml:space="preserve"
       style="font-size:63.35290909px;font-style:normal;font-weight:normal;line-height:125%;letter-spacing:0px;word-spacing:0px;fill:#000000;fill-opacity:1;stroke:none;font-family:Arial;-inkscape-font-specification:Arial"
       x="-47.92"
       y="871.22046"
       id="text10932-3"
       sodipodi:linespacing="125%"
       transform="scale(1.5838227,0.6313838)">'; echo'<tspan
       sodipodi:role="line"
       id="tspan10934-50"
       x="-47.92"
       y="871.22046"
       style="font-size:25.34116364px;fill:#ffffff;fill-opacity:1">i</tspan>'; echo'</text>';
    echo'</g>';
  echo'</g>';
   echo'</g>';
 echo '<rect x="10" y="10" height="20" rx="5" ry="5" style=" fill:black" class="tooltip_bg" id="tooltip_bg" visibility="hidden"></rect>';
  echo '<text class="tooltip" id="tooltip" visibility="hidden" style="fill:white; font-size:11px; font-family:Arial;"></text>';
  echo'<style
   id="style3">';
  echo'g.button:hover{
  opacity: 0.75;
  }';
echo'</style>';
echo'</svg>'; ?>