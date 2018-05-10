$("#buscar").click(function(){
  var cancion = $("#input").val();
  buscarCancion(cancion);
});

function buscarCancion(data){
  $.ajax({
    url: "datalayer/buscarcancion.php",
    method: "GET",
    data:{
      buscar: data
    },
    dataType: "JSON",
    success: function(response){
      handleResponse(response);
    },
    error: function(response){
      alert("error");
    }
  });
}

function handleResponse(response){
  if(response == "error"){
    //alert("error");
    console.log("error");
  }else{
    limpiarDiv();
    for(cancion of response){
      mostrarCancion(cancion);
    }
  }
}

function limpiarDiv(){
  var div = document.getElementById("resultado");
  while(div.firstChild){
    div.removeChild(div.firstChild);
  }
}

function mostrarCancion(cancion){
  var divPadre = document.getElementById("resultado");
  var divCancion = document.createElement("div");
  divCancion.className = "col l4 s5";
  divCancion.innerHTML = `
  <div class="card-panel">
    <span class="black-text text-darken-2"><strong>Nombre: </strong>`+ cancion["nombre"]+`</span>
    <div class="divider"></div>
    <span class="black-text text-darken-2"><strong>Artista: </strong>`+ cancion["artista"]+`</span>
    <div class="divider"></div>
    <span class="black-text text-darken-2"><strong>Album: </strong>`+ cancion["album"]+`</span>
    <div class="row">
    <div class="waves-effect waves-light btn col s12 blue accent-4 agregar">
      <input type="text" class="path" value="`+cancion["id"]+`" hidden>
      <i class="material-icons left">add</i><span>agregar</span></div>
    </div>
  </div>
  `
  divPadre.appendChild(divCancion);
}

///////////////////////agregar cancion/////////////////////////
$("#resultado").on("click", ".agregar", function(){
  var idPlaylist = document.getElementById("idplaylist").value;
  var idCancion = this.children[0].value;
  agregarCancion(idPlaylist, idCancion, this);
});

function agregarCancion(playlist, cancion, ambito){
  var request = $.ajax({
    url: "datalayer/addcancion.php",
    method: "POST",
    data:{
      playlistid: playlist,
      cancionid: cancion
    }
  });

  request.done(function(response){
    if(response == "error"){
      alert("Ocurrio un error al registrar la playlist");
    }else if(response == "existe"){
      alert("La cancion ya se encuentra en la playlist");
    }else{
      ambito.children[1].innerHTML = "done";
      ambito.children[2].innerHTML = "agregada";
      ambito.id = "aux";
      $("#aux").removeClass("agregar").addClass("remover");
      ambito.id = "";
    }
  });

  request.fail(function (jqXHR, textStatus, errorThrown){
    alert("Ocurrio un error");
    console.log(jqXHR.responseText);
  });
}

/////////////////////////Quitar cancion/////////////////////////////////////
$("#resultado").on("click", ".remover", function(){
  var idPlaylist = document.getElementById("idplaylist").value;
  var idCancion = this.children[0].value;
  removerCancion(idPlaylist, idCancion, this);
});

function removerCancion(playlist, cancion, ambito){
  var request = $.ajax({
    url: "datalayer/removecancion.php",
    method: "POST",
    data:{
      playlistid: playlist,
      cancionid: cancion
    }
  });

  request.done(function(response){
    if(response == "error"){
      alert("Ocurrio un error al registrar la playlist");
    }else if(response == "existe"){
      alert("La cancion ya se encuentra en la playlist");
    }else{
      ambito.children[1].innerHTML = "add";
      ambito.children[2].innerHTML = "agregar";
      ambito.id = "aux";
      $("#aux").removeClass("remover").addClass("agregar");
      ambito.id = "";
    }
  });

  request.fail(function (jqXHR, textStatus, errorThrown){
    alert("Ocurrio un error");
  });
}
