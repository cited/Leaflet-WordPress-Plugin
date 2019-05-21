<style type="text/css">
<!--
.style1 {
	color: #76401a;
	font-weight: bold;
}
.style2 {color: #76401a}
.style4 {
	color: #339900;
	font-weight: bold;
}
.style6 {
	color: #BF1515;
	font-weight: bold;
}
.style7 {font-size: 24px}
.style10 {color: #76401a; font-size: 18px; }
.style11 {font-size: 18px}
.style12 {font-size: 14px; }
.style13 {color: #990000}
.style15 {color: #3333CC; font-weight: bold; }
.style17 {color: #CC6666; font-weight: bold; }
.style19 {color: #FF9900; font-weight: bold; }
.style21 {color: #330066; font-weight: bold; }
.style22 {
	color: #FF0000;
	font-weight: bold;
}
.style23 {color: #FF0000}
.style24 {
	color: #000000;
	font-weight: bold;
}
.style26 {
	color: #0066CC;
	font-weight: bold;
}
.style28 {color: #006699; font-weight: bold; }
-->
</style>
<ol class="breadcrumb breadcrumb-arrow" style="margin: 10px 15px 0 0;">
		<li><a href="#"><i class="fa fa-home"></i> Dashboard</a></li>
		<li><a href="#"><i class="fa fa-leaf"></i> <?=MF_PLUGIN_NAME_FORMATED?></a></li>
		<li class="active"><span><i class="fa fa-book"></i> Documentation</span></li>
		<li class="active pull-right help"><span><a href="<?=MF_HELP_URL?>" title="Help?" target="_blank"><img src="<?=plugins_url('../images/question-mark.png', __FILE__)?>" style="height:30px;width:30px;"></a></span></li>
	</ol>

<section id="social plugin" class="wrapssss" >

	<div id="icon-themes" class="icon32"><br></div>
	<h2>Documentation</h2>
	<div class="wrapssss">
	<img src="<?php echo plugins_url('../images/logo.png', __FILE__) ?>" >
	<p class="style11">AcuGIS is designed to easily add stylish, meaningful maps to your WordPress site. </p>
	<p class="style11">The plugin is designed for ease of use and to offer a full array of features.</p>
	<p class="style12">If you would like to view a video or read full documentation, please visit <a href="https://www.acugis.com/leaflet-map-plugin/docs/" target="_blank">https://www.acugis.com/leaflet-map-plugin/docs/</a>.</p>
	<p>&nbsp; </p>
	<p align="center"><span class="style10"><strong>Step 1.)</strong> Click on <a href="<?=admin_url().'admin.php?page=add-new-map'?>">Add New Map</a> to create a new map and a  maker.</span></p>
	<p align="center"><img src="<?php echo plugins_url('../screenshots/add-new-map.jpg', __FILE__) ?>"/></p>
	<p>&nbsp; </p>

	<p class="style7"><span class="style1">Select Map Options</span>:</p>
	<p>&nbsp; </p>
	<table width="100%" border="0">
      <tr>
        <td>&nbsp;</td>
        <td rowspan="16"><img src="<?php echo plugins_url('../screenshots/create-map.jpg', __FILE__) ?>"/></td>
      </tr>
      <tr>
        <td><span class="style6">Map Title</span>: Give your map a name. </td>
      </tr>
      <tr>
        <td><span class="style6">Width</span>: Width of Map in Pixels</td>
      </tr>
      <tr>
        <td><span class="style6">Height</span>: Height of Map in Pixels</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><span class="style4"><span class="style13">Show Sidebar</span> </span>: Sidebar with locations</td>
      </tr>
      <tr>
        <td><span class="style15">Show Search </span>: Search map.</td>
      </tr>
      <tr>
        <td><span class="style17">Show Measure </span>: Measure Distance.</td>
      </tr>
      <tr>
        <td><span class="style19">Show MiniMap </span>: MiniMap </td>
      </tr>
      <tr>
        <td><span class="style21">Show Export </span>: Export HTML,iframe,or JSON </td>
      </tr>
      <tr>
        <td><strong><span class="style23">SVG</span>: Show Shapes as SVG (Premium Plus Only) </strong></td>
      </tr>
      <tr>
        <td><span class="style22">GPX: <span class="style24">Show GPX Tracks (Premium Plus Only) </span></span></td>
      </tr>
      <tr>
        <td><span class="style28">Zoom Level</span>: Set Zoom Level </td>
      </tr>
      <tr>
        <td><span class="style28">Base Map</span>: Base Map to Display </td>
      </tr>

      <tr>
        <td><span class="style26">Base Map</span> Group: Group to Display </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>

      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p><span class="style7"><span class="style1">Select Marker Options</span>:</span></p>
	<p align="left">Click the marker icon and drop it onto map. You will see the marker   options pop-up as shown at right. Once you have added your first  marker   and created your map, you can add as many markers to the map  you wish   to. </p>
	<table width="100%" border="0">
      <tr>
        <td>&nbsp;</td>
        <td rowspan="18"><img src="<?php echo plugins_url('../screenshots/marker-options.jpg', __FILE__) ?>"/></td>
      </tr>

      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>

      <tr>
        <td><strong> Location:</strong>This can be a specific address or just a city, country, or well known-place (e.g. Paris, China, Disneyworld).</td>
      </tr>
      <tr>
        <td><strong>Description:</strong>: Content that will be displayed when your marker is clicked on.</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><strong>Add Google Maps Directions Link</strong>: Include a &quot;Get Directions&quot; link.</td>
      </tr>
      <tr>
        <td><strong>Display Modal InfoBox</strong>: Show InfoBox as Modal Pop-Up </td>
      </tr>
      <tr>
        <td><strong>Include Location on PopUp</strong>: Display address in the marker balloon.</td>
      </tr>
      <tr>
        <td><strong>Hide Label on PopUp </strong>: Do not show description labels.</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><strong>Marker Icon: </strong>Icon for marker.*</td>
      </tr>
      <tr>
        <td><strong>Marker Color: </strong>Color for marker.*</td>
      </tr>
      <tr>
        <td><strong>*</strong>If you do not select marker style and color, it will use the default Leafletjs blue marker.</td>
      </tr>
    </table>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p align="center" class="style7">Click the &quot;Save&quot; Button. You have now created your first map! </p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p align="center"><span class="style10"><strong>Step 3.)</strong> You can additional marker, polygons, and lines to your map as well as edit both the map and markers. </span></p>
	<p>&nbsp;</p>
	<p><span class="style10"><strong>Step 4.)</strong> Add your map(s) to your Posts or Pages by clicking on the Add AcuGIS Map button above the editor.</span> </p>
	<p align="center"><img src="<?php echo plugins_url('../screenshots/add-to-post.jpg', __FILE__) ?>" /></p>
	<p align="center"><strong>That's it! Simple as that.</strong></p>
	<p>&nbsp; </p>

	<p>&nbsp; </p>
	<p align="center"><span class="style2 style11"><strong>BONUS! - The Widget:</strong> </span></p>
	<p align="center"><span class="style2 style11">Your AcuGIS Plugin includes an integrated Widget! For Widget information, see the <a href="<?=admin_url().'admin.php?page=get_started_widget'?>">Widget Page</a> </span></p>
	<p>&nbsp; </p>

	<p><span class="style2"><strong>Downloading Maps and JSON </strong>:</span></p>
	<p>AcuGIS maps are made to be self-contained. On your <a href="<?=admin_url().'admin.php?page=my-maps'?>">MyMaps</a> page, you can download your maps if you wish to use them outside of WordPress.</p>
	<p>You can also download the GeoJSON source as well.</p>
	<p><span class="style2"><strong>About AcuGIS </strong>:</span></p>
	<p>The plugin is produced by <a href="htttps://www.acugis.com" target="_blank">AcuGIS</a>. AcuGIS provides GIS hosting services to individuals, corporations, and leading research and educational institutions in over 40 countries worldwide. </p>
	<p><strong>AcuGIS Version 5.1.1.0</strong></p>
	<p><span class="style2"><strong>Terms </strong>:</span></p>
	<p>In using this plugin, you are agreeing to the <a href="http://www.openstreetmap.org/copyright" target="_blank">license requirement</a> to retain attribution to <a href="http://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a>. You are also agreeing to maintain attribution to any other tile providers used as well as <a href="https://www.acugis.com" target="_blank">AcuGIS</a> and to <a href="http://leafletjs.com/" target="_blank">Leafletjs</a> as well. </p>
	<p> <strong><u>Indemnification</u></strong>&nbsp; This product is offered without warranty and user will not hold AcuGIS liable for any damages incurred by use of this plugin. User  agrees to indemnify and hold AcuGIS, Inc and its suppliers, affiliates, partners, subsidiaries and employees (collectively, the &quot;Indemnified Parties&quot;) harmless from any and all claims and demands, losses, liability costs and expenses (including, but not limited to, reasonable attorneys' fees), incurred by an Indemnified Party arising out of use of plugin. To the fullest extent permitted by law, the foregoing indemnity will apply regardless of any fault, negligence, or breach of warranty or contract of AcuGIS, Inc and/or its suppliers, affiliates, partners, subsidiaries and employees.</p>
	<p>Please see our website at <a href="https://www.acugis.com" target="_blank">https://www.acugis.com</a> to check for updates as well as full documentation.</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>

	<p align="center">Copyright @ <?PHP date('Y'); ?> AcuGIS, Inc |  <a href="http://www.acugis.com/" target="_blank">AcuGIS</a></p>
	<p align="center"><img src="<?php echo plugins_url('../screenshots/logo.png', __FILE__) ?>" ></p>
	<p align="center">We make GIS simple. </p>
	<p>&nbsp;</p>
	<p><strong>AcuGIS, Inc</strong></p>
	<ul>
	  <li>
	    <p><strong>Address</strong>: 2711 Centerville Road, Suite 400,  Wilmington, Delaware 19808</p>
      </li>
	  <li>
	    <p><strong>Tel</strong>: 302 384-9810</p>
      </li>
	  </ul>
	<p><strong>AcuGIS Europe </strong></p>
		<ul><li><p><strong>Tel</strong>: 44 203 318 7221</p>
      </li>
	  </ul>
	<p>&nbsp;</p>
	<p><br />
	  </p>
	<p>&nbsp;  </p>
	</div>

</section>


<?php include 'include/footer.php';?>