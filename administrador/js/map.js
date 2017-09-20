function initialize() {
	
	var latlng = new google.maps.LatLng(16.759663,-93.116895);
	var myOptions = {
	  zoom: 16,
	  center: latlng,
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	var map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
	
	/*
	
	var image = new google.maps.MarkerImage('imagenes/gmap_icon.png',
	  // This marker is 20 pixels wide by 32 pixels tall.
	  new google.maps.Size(20, 32),
	  // The origin for this image is 0,0.
	  new google.maps.Point(0,0),
	  // The anchor for this image is the base of the flagpole at 0,32.
	  new google.maps.Point(0, 32));
  var shadow = new google.maps.MarkerImage('imagenes/gmap_icon_sombra.png',
	  // The shadow image is larger in the horizontal dimension
	  // while the position and offset are the same as for the main image.
	  new google.maps.Size(37, 32),
	  new google.maps.Point(0,0),
	  new google.maps.Point(0, 32));
	  // Shapes define the clickable region of the icon.
	  // The type defines an HTML <area> element 'poly' which
	  // traces out a polygon as a series of X,Y points. The final
	  // coordinate closes the poly by connecting to the first
	  // coordinate.
  var shape = {
	  coord: [1, 1, 1, 20, 18, 20, 18 , 1],
	  type: 'poly'
  };
  	var marker = new google.maps.Marker({
						position: latlng,
						map: map,
						shadow: shadow,
						icon: image,
						shape: shape,
						title: "ASSCOM",
						zIndex: 1
					});
	*/
	var marker = new google.maps.Marker({
						position: latlng,
						map: map,
						title: "iWARE",
						zIndex: 99
					});
	/* var contentString = '<div id="content">'+
	'<div id="siteNotice">'+
	'</div>'+
	'<h1 id="firstHeading" class="firstHeading">iWARE</h1>'+
	'<div id="bodyContent">'+
	'<p><b>Desarrollo de Sitios y Aplicaciones Web</b></p> <br> ' +
	'2a. Poniente Norte No. 757, Tuxtla Guti&eacute;rrez, Chiapas.<br> Tel. Fax (01 961) 612 8855</p>'+
	'</div>'+
	'</div>';*/

/*
	var infowindow = new google.maps.InfoWindow({
		content: contentString
	});
	
	google.maps.event.addListener(marker, 'click', function() {
	  infowindow.open(map,marker);
	});*/

 }
  $(function(){
	 initialize()
 });