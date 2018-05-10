function initMap() {
  var latitud = $("#pais_lat").val();
  var longitud = $("#pais_long").val();
  var myLatLng = {lat: parseFloat(latitud), lng: parseFloat(longitud)};
  map = new google.maps.Map(document.getElementById('map'), {
    center: myLatLng,
    zoom: 10
  });
  google.maps.event.addListener(map, 'click', function(e) {
    placeMarker(e.latLng, map);
  });
  var marker = new google.maps.Marker({
    position: myLatLng,
    map: map
  });
  marker.setMap(map);
}
