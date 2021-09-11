			  function mostrarMensaje(titulo, tipo, tiempo){
                swal({
                    position: 'top-end',
                    type: tipo,
                    title: titulo,
                    showConfirmButton: false,
                    timer: tiempo
                })
            }
