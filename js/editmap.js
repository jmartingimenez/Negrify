function initMap() {
  var latitud = $("#pais_latitud").val();
  var longitud = $("#pais_longitud").val();
  var miPosicion = {lat: parseFloat(latitud), lng: parseFloat(longitud)};

  var markers = [];

  $("#map_container").click(function(){
    setTimeout(function(){

      map = new google.maps.Map(document.getElementById('map'), {
        center: miPosicion,
        zoom: 10
      });

      google.maps.event.trigger(map, "resize");

      var marker = new google.maps.Marker({
        position: miPosicion,
        map: map
      });
      marker.setMap(map);
      markers.push(marker);

      google.maps.event.addListener(map, 'click', function(e) {
          placeMarker(e.latLng, map);
          setearCoordenadas(e.latLng);
          setearPais(e.latLng);
        });

    }, 200);
  })

  function placeMarker(position, map) {
    var marker = new google.maps.Marker({
      position: position,
      map: map
    });
    map.panTo(position);
    removerMarcadores();
    markers.push(marker);
  }

  function setearCoordenadas(posicion){
    $("#pais_latitud").val(posicion.lat());
    $("#pais_longitud").val(posicion.lng());
  }

  function setearPais(posicion){
    var lat = posicion.lat()+","+posicion.lng();
    $.ajax({
      url: "https://maps.googleapis.com/maps/api/geocode/json",
      method: "GET",
      data:{
        latlng: lat,
        key: 'AIzaSyDx-ThAVlQ4ynqL2IaxM-mvmMRUpPf_hLg'
      },
      dataType: "JSON",
      success: function(response){
        if(response.status == "OK"){
          $("#pais_nombre").val(buscarPais(response.results[0].address_components));
        }
      },
      error: function(response){
        alert("error al setear el pais");
      }
    });
  }

  function buscarPais(data){
    var pais = '';
    for(var i = 0; i<data.length; i++){
      if(data[i].types[0] == "country"){
        pais = data[i].long_name;
      }
    }
    return pais;
  }

  function removerMarcadores(){
    if(markers.length > 0){
      for(var i = 0; i<markers.length; i++){
        markers[i].setMap(null);
      }
    }
  }

}
