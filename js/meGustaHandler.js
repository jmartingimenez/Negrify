var user = $("#idusuario").val();
var play = $("#idplaylist").val();

var like = document.getElementById("like");
like.addEventListener("click", function(){
  if($("#like").hasClass("conmegusta")){
    quitarMeGusta(play, user);
  }else{
    agregarMeGusta(play, user);
  }
})

function quitarMeGusta(playlist, usuario){
  var request = $.ajax({
    url: "datalayer/deleteMeGusta.php",
    method: "POST",
    data:{
      playlistId: playlist,
      userid: usuario
    }
  });

  request.done(function(response){
    if(response == true){
      $("#like").removeClass("conmegusta").addClass("sinmegusta");
    }
  })

  request.fail(function(response){
    console.log(response);
  })
}

function agregarMeGusta(playlist, usuario){
  var request = $.ajax({
    url: "datalayer/setMeGusta.php",
    method: "POST",
    data:{
      playlistId: playlist,
      userid: usuario
    }
  });

  request.done(function(response){
    if(response == true){
      $("#like").removeClass("sinmegusta").addClass("conmegusta");
    }
  })

  request.fail(function(response){
    console.log(response);
  })
};
