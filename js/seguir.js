var seguidor = $("#idcliente").val();
var seguido = $("#idProfileCreator").val();

var btn_seguir = document.getElementById("btn_seguir");
btn_seguir.addEventListener("click", function(){
  if($(btn_seguir).hasClass("siguiendo")){
    unfollow(seguidor, seguido);
  }else {
    follow(seguidor,seguido);
  }
});

function follow(seguidorid, seguidoid){
  var request = $.ajax({
    url: "datalayer/seguir.php",
    method: "POST",
    data:{
      seguidor: seguidorid,
      seguido: seguidoid
    }
  });

  request.done(function(response){
    if(response == true){
      $(btn_seguir).addClass("siguiendo")

      document.getElementById("icon_seguir").innerHTML = 'remove_circle_outline';
    }else{
      console.log("debug");
    }
  })

  request.fail(function(response){
    console.log(response);
  })
}

function unfollow(seguidorid, seguidoid){
  var request = $.ajax({
    url: "datalayer/unfollow.php",
    method: "POST",
    data:{
      seguidor: seguidorid,
      seguido: seguidoid
    }
  });

  request.done(function(response){
    if(response == true){
      $(btn_seguir).removeClass("siguiendo");
      document.getElementById("icon_seguir").innerHTML = 'person_add';
    }else{
      console.log("debug");
    }
  })

  request.fail(function(response){
    console.log(response);
  })
}

$("#btn_menu_reportar").click(function(){
  $("#modal_report").trigger("click");
})

var botonReport = document.getElementById("btn_reportar");
botonReport.addEventListener("click", function(){
  reportarUsuario(seguido, seguidor);
})

function reportarUsuario(idDenunciado, idDenunciante){
  var request = $.ajax({
    url: "datalayer/reportarUsuario.php",
    method: "POST",
    data:{
      denunciado: idDenunciado,
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
