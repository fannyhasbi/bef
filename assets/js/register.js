$(function () {
  $("#btn").click(function(e) {
    var password  = $("#password").val();
    var password2 = $("#password2").val();

    if(password.length < 6){
      alert("Password terlalu pendek");
      return false;
    }

    if (password != password2) {
      alert("Password tidak cocok");
      return false;
    }

    return true;
  });
});