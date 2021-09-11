$(function(){
  var l = new Login();
})


class Login {
  constructor() {
    this.checkSession();
    this.submitEvent();
  }

  submitEvent(){
    $('form').submit((event)=>{
      event.preventDefault()
      this.sendForm()
    })
  }

  sendForm(){
    let form_data = new FormData();
    form_data.append('username', $('#user').val())
    form_data.append('password', $('#password').val())
    $.ajax({
      url: './server/check_login.php',
      dataType: "json",
      cache: false,
      processData: false,
      contentType: false,
      data: form_data,
      type: 'POST',
      success: function(php_response){
        if (php_response.msg == "OK") {
          window.location.href = 'main.html';
        }else {
          alert(php_response.msg);
        }
      },
      error: function(){
        alert("error en la comunicación con el servidor");
      }
    })
  }

  checkSession(){
    $.ajax({
      url:"./server/check_session.php",
      type: "GET",
      dataType: "json",
      cache:false,
      success: function(response){
        if(response.code==1){
          window.location.href = 'main.html';
        }else{
          console.log("inicion no iniciada");
        }
      },
      error: function(){
        alert("Error al verificar sesion")
      }
    })
  }
}
