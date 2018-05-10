var audio = new Audio();
var canciones = new Array();
var path = "archivos/canciones/";
var cancionActual = 0;
var link;

$(".cancion").each(function(){
  canciones.push(path+$(this).data("cancion"));
});

var playlistTam = canciones.length - 1;

// inicializo el reproductor con la primer cancion
audio.src= canciones[0];
$("#canciones li:first-child").addClass("seleccionada");

// acciones a realizarse cuando se cargan las canciones
audio.addEventListener("loadedmetadata", function(){
  $('#duracion').attr('max',audio.duration);
  $('#tiempo').text("00:00");
  $('#tiempoTotal').text(convertirSegundosAMinutos(audio.duration));
})

// acciones a realizarse cuando se cliquea en una cancion
$("#canciones").find('li').click(function(e){
  e.preventDefault();
  link = $(this);
  var nuevaCancion = path + link.data("cancion");
  audio.pause();
  audio.src = nuevaCancion;
  audio.play();
  $("#play").first().html("pause_circle_outline");
  removerSeleccion();
  link.addClass("seleccionada");
  cancionActual = link.data("orden");
});


// cuando se termina de reproducir una cancion, que vaya automaticamente a la siguiente.
audio.addEventListener('ended',function(e){
  $("#next").trigger("click");
});

// actualizar el tiempo de la cancion cuando se cliquea en el range
$("#duracion").on("change", function() {
  audio.currentTime = $(this).val();
  $("#duracion").attr("max", audio.duration);
});

// actualizar el tiempo transcurrido de la cancion
audio.addEventListener('timeupdate',function (){
  $("#tiempo").text(convertirSegundosAMinutos(audio.currentTime));
  var tiempoActual = parseInt(audio.currentTime, 10);
  $("#duracion").val(tiempoActual);
});

// ----------------------------- CONTROLES -------------------------------//
$("#xspf").click(function(e){
  $("#btn_exportar").trigger("click");
})

$("#play").click(function(e){
  if(audio.paused){
    audio.play();
    $(this).first()[0].innerHTML = "pause_circle_outline";
  }else{
    audio.pause();
    $(this).first()[0].innerHTML = "play_circle_outline";
  }
})
var playboton = document.getElementById("play");
playboton.addEventListener("click", function(){
  var pid = $("#idplaylist").val();
  setearReproduccion(pid);
})

function setearReproduccion(pid){
  if(document.cookie.indexOf("reprodujo"+pid) == -1){
    var request = $.ajax({
      url: "datalayer/setReproduccion.php",
      method: "POST",
      data:{
        playlistId: pid,
      }
    });

    request.done(function(response){
      if(response == true){
        document.cookie = "reprodujo"+pid+"=si";
      }
    })
  }
}

$("#next").click(function(e){
  var indice;
  if(cancionActual < playlistTam){
    indice = cancionActual + 1;
  }else{
    indice = 0;
  }
  $(".cancion").each(function(i){
    if( $(this).data("orden") == indice ){
      audio.pause();
      audio.src = path+$(this).data("cancion");
      audio.play();
      removerSeleccion();
      $(this).addClass("seleccionada");
      cancionActual = $(this).data("orden");
    }
  })
})

$("#prev").click(function(e){
  var indice;
  if(cancionActual > 0){
    indice = cancionActual - 1;
  }else{
    indice = playlistTam;
  }
  $(".cancion").each(function(i){
    if( $(this).data("orden") == indice ){
      audio.pause();
      audio.src = path+$(this).data("cancion");
      audio.play();
      removerSeleccion();
      $(this).addClass("seleccionada");
      cancionActual = $(this).data("orden");
    }
  })
})

$("#mute").click(function(e){
  if(audio.muted){
    audio.muted = false;
    $(this).first()[0].innerHTML = "volume_up";
  }else{
    audio.muted = true;
    $(this).first()[0].innerHTML = "volume_off";
  }
})

// ----------------------------- FIN CONTROLES -------------------------------//


function convertirSegundosAMinutos(secs) {
  var hr  = Math.floor(secs / 3600);
  var min = Math.floor((secs - (hr * 3600))/60);
  var sec = Math.floor(secs - (hr * 3600) -  (min * 60));

  if (min < 10){
    min = "0" + min;
  }
  if (sec < 10){
    sec  = "0" + sec;
  }

  return min + ':' + sec;
}


function removerSeleccion(){
  $(".cancion").removeClass("seleccionada");
}


// ------------------------------------------FIN REPRODUCTOR--------------------//
$("#tab_reportar").click(function(){
  $("#modal_report").trigger("click");
})

var botonReport = document.getElementById("btn_reportar");
botonReport.addEventListener("click", function(){
  var idPlaylist = $("#idplaylist").val();
  var idDenunciante = $("#idusuario").val();
  reportarPlaylist(idPlaylist, idDenunciante);
})

function reportarPlaylist(idPlaylist, idDenunciante){
  var request = $.ajax({
    url: "datalayer/reportPlaylist.php",
    method: "POST",
    data:{
      playlistId: idPlaylist,
      denunciante: idDenunciante
    }
  });

  request.done(function(response){
    if(response == true){
      document.getElementById("btn_reportar").innerHTML = '<i class="material-icons">done</i><span> REPORTADO</span>';
    }else{
      $("#modal_yareportado").trigger("click");
    }
  })

  request.fail(function(response){
    console.log(response);
  })
}
