$(document).ready(function() {
    $('select').material_select();
    $('.modal').modal({
      dismissible: true, // Modal can be dismissed by clicking outside of the modal
      opacity: .5, // Opacity of modal background
      in_duration: 300, // Transition in duration
      out_duration: 200, // Transition out duration
      starting_top: '4%', // Starting top style attribute
      ending_top: '10%'
    }
  );
});

$("#searchInicial").click(function(){
  $("#searchInicial").hide();
  $("#searchbox").fadeIn(1000);
  $("#search").focus();
});

$("#closeSearch").click(function(){
  $("#searchbox").hide();
  $("#searchInicial").fadeIn(200);
});

$("#inputSearch").focusout(function(){
  $("#searchbox").hide();
  $("#searchInicial").fadeIn(400);
});

$("#search").focus(function(){
  $("#search").on("keydown", function(e){
    if(e.keyCode == 13){
      var input = $("#search").val();
      if(input.length > 0){
        window.location = "http://localhost/search.php?q="+input;
      }
    }
  });
});
