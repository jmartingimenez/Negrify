/*$("#document").ready(function(){
  $(".quitar").click(function(){
    var idCancion = $(this).find(".path").val();
    var idPlaylist = $("#id_playlist").val();
    console.log(idPlaylist);
    quitarCancion(idCancion, idPlaylist);
  })
})*/

var aux = document.getElementById("cancionesAQuitar");
$("#cancionesAQuitar").on("click", ".quitar", function(){
  var idCancion = $(this).find(".path").val();
  var idPlaylist = $("#id_playlist").val();
  console.log(idPlaylist);
  quitarCancion(idCancion, idPlaylist);
})



function quitarCancion(cancion, playlist){
  var request = $.ajax({
    url: "datalayer/quitarCancion.php",
    method: "POST",
    data:{
      playlistid: playlist,
      cancionid: cancion
    }
  });

  request.done(function(response){
    if(response == true){
      location.reload();
    }else{
      console.log("ERROR");
    }
  })

  request.fail(function(response){
    location.reload();
  })
}
