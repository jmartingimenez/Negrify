$(document).ready(function(){
  if(document.cookie.indexOf("sinverificar") != -1){
    setInterval(function(){
      $("#btn_sin_verificar").trigger("click");
    }, 25000);
  }
})
