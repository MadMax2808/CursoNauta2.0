document.querySelector('form').addEventListener('submit', function(event) {
    const user = document.getElementById('user').value;
    const password = document.getElementById('password').value;
   

    let errorMessages = [];

    // Validación de usuario
    if (user.trim() === '') {
        errorMessages.push('Ingrese su Usuario');
    }

    // Validación de contraseña
    if (password.trim() === '') {
        errorMessages.push('Ingrese su contraseña');
    }

    // Mostrar mensajes de error uno por uno
    if (errorMessages.length > 0) {
        event.preventDefault();
        errorMessages.forEach(function(message) {
            alert(message);
        });
    }
});


//Se ocupa despues
// formularioLogin.addEventListener("submit", e=>{
//   e.preventDefault();
//   const password = document.getElementById('Contraseña').value; 
//   validarContraseña1(password);
//   if (ERRORCONTRASEÑA == true && ERROREMAIL == true ) {

//       var Data = new FormData(document.getElementById("formulariologin"))

//       console.log(Data)

//       $.ajax({
//           type: 'POST',
//           url: "../Api-sanevsa/proc_login.php",
//           data: Data,
//           processData: false,
//           contentType: false,
//           success: function (response) {
              
//               console.log(response)
//               var ResponseMessage = JSON.parse(response)

//               if (ResponseMessage.errorCode == 0) {
//                   window.location.href = "Interfaz.html"
//               }
//               if (ResponseMessage.errorCode == 1) {
//                   alert(ResponseMessage.message)
//               }

//           }
//       })
      
      
//   } else {
//       alert("Por favor de revisar que haya ingresado todos los datos correctamente");  
//   }

// });