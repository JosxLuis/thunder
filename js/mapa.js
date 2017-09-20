function initialize() {
  // Create an array of styles.
  var styles = [
    {
      stylers: [
        { "hue": "#99cc33" },
      { "saturation": -65 },
      { "visibility": "on" }
      ]
    }
  ];

  // Create a new StyledMapType object, passing it the array of styles,
  // as well as the name to be displayed on the map type control.
  var styledMap = new google.maps.StyledMapType(styles,
    {name: "Sauber productos de limpieza"});

  // Create a map object, and include the MapTypeId to add
  // to the map type control.
  var mapOptions = {
    zoom: 18,
    scrollwheel: false,
    panControl: false,
    zoomControl: true,
    center: new google.maps.LatLng(16.752342, -93.070314),
    mapTypeControlOptions: {
      mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
    }
  };
  var map = new google.maps.Map(document.getElementById('map-canvas'),
    mapOptions);

  //Associate the styled map with the MapTypeId and set it to display.
  map.mapTypes.set('map_style', styledMap);
  map.setMapTypeId('map_style');

  var myLatlng  = new google.maps.LatLng(16.752342, -93.070314);

    new google.maps.Marker({
        position: myLatlng
        , draggable: false
        , raiseOnDrag : false
        , map: map
        , title: 'UbicaciÃ³n'
        , icon: ''
        , cursor: 'default'
    });


}