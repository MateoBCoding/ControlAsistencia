	/*
			Tomar una fotografía y guardarla en un archivo v3
			@date 2020-11-07
			@autor Alejandro Ruiz Lameiro
			@website https://www.alexruiz.eu/
		*/
		
		const init = () => {
        const tieneSoporteUserMedia = () =>
            !!(navigator.mediaDevices.getUserMedia)
    
        // Si no soporta...
        // Amable aviso para que el mundo comience a usar navegadores decentes ;)
        if (typeof MediaRecorder === "undefined" || !tieneSoporteUserMedia())
            return alert("Tu navegador web no cumple los requisitos; por favor, actualiza a un navegador como Firefox o Google Chrome");
    	
		
		function _getUserMedia() {
			return (navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia).apply(navigator, arguments);
		}

    
        // Declaración de elementos del DOM
        const $dispositivosDeVideo = document.querySelector("#dispositivosDeVideo"),
			$canvas = document.querySelector("#canvas"),
            $duracion = document.querySelector("#duracion"),
            $video = document.querySelector("#video"),
            $btnDetenerGrabacion = document.querySelector("#btnDetenerGrabacion");
    
        // Algunas funciones útiles
        const limpiarSelect = elemento => {
            for (let x = elemento.options.length - 1; x >= 0; x--) {
                elemento.options.remove(x);
            }
        }
        // Variables "globales"
        let tiempoInicio, mediaRecorder, idIntervalo;
    
        // Consulta la lista de dispositivos de entrada de audio y llena el select
        const llenarLista = () => {
            navigator
                .mediaDevices
                .enumerateDevices()
                .then(dispositivos => {
                    limpiarSelect($dispositivosDeVideo);
                    dispositivos.forEach((dispositivo, indice) => {
                        if (dispositivo.kind === "videoinput") {
                            const $opcion = document.createElement("option");
                            // Firefox no trae nada con label, que viva la privacidad
                            // y que muera la compatibilidad
                            $opcion.text = dispositivo.label || `Cámara ${indice + 1}`;
                            $opcion.value = dispositivo.deviceId;
                            $dispositivosDeVideo.appendChild($opcion);
                        }
                    })
                })
        };
		
		
		$dispositivosDeVideo.addEventListener("change", function(){
			$video.pause();
			mediaRecorder.stop();
            mediaRecorder = null;
			inicializeVideo();
			
		});
    
        // Comienza a grabar el audio con el dispositivo seleccionado
		function inicializeVideo()
		{
			 _getUserMedia({
				video: true
			},
			function(stream) {
				if (!$dispositivosDeVideo.options.length) return alert("No hay cámara");
				// No permitir que se grabe doblemente
				//if (mediaRecorder) return alert("Ya se está grabando");
		
				navigator.mediaDevices.getUserMedia({
						video: {
							deviceId: $dispositivosDeVideo.value, // Indicar dispositivo de vídeo
						}
					})
					.then(stream => {
						// Poner stream en vídeo
						$video.srcObject = stream;
						$video.play();
						// Comenzar a grabar con el stream
						mediaRecorder = new MediaRecorder(stream);
						mediaRecorder.start();
						
						$btnDetenerGrabacion.addEventListener("click", function() {
	
							//Pausar reproducción
							$video.pause();
							let contexto = $canvas.getContext("2d");
							$canvas.width = $video.videoWidth;
							$canvas.height = $video.videoHeight;
							contexto.drawImage($video, 0, 0, $canvas.width, $canvas.height);
		 
							let foto = $canvas.toDataURL(); //Esta es la foto, en base 64
							$duracion.innerHTML = "Enviando foto. Por favor, espera...";
							
							fetch("foto_render.php", {
								method: "POST",
								body: encodeURIComponent(foto),
								headers: {
									"Content-type": "application/x-www-form-urlencoded",
								}
							})
								.then(resultado => {
									// A los datos los decodificamos como texto plano
									return resultado.text()
								})
								.then(nombreDeLaFoto => {
									// nombreDeLaFoto trae el nombre de la imagen que le dio PHP
									console.log("La foto fue enviada correctamente");
									$duracion.innerHTML = `Foto guardada con éxito. Puedes verla <a target='_blank' href='./${nombreDeLaFoto}'> aquí</a>`;
								})
		 
							//Reanudar reproducción
							$video.play();
							
						});
					})
					.catch(error => {
						// Aquí maneja el error, tal vez no dieron permiso
						console.log(error)
					});
			},
			function(error) {
				console.log("Permiso denegado o error: ", error);
				$estado.innerHTML = "No se puede acceder a la cámara, o no diste permiso.";
			});
		}
    
    
        /*const detenerConteo = () => {
            clearInterval(idIntervalo);
            tiempoInicio = null;
            $duracion.textContent = "";
        }
    
        const detenerGrabacion = () => {
            if (!mediaRecorder) return alert("No se está grabando");
            mediaRecorder.stop();
            mediaRecorder = null;
        };*/
    
        $btnDetenerGrabacion.addEventListener("click", function(){
			$video.pause();
			mediaRecorder.stop();
            mediaRecorder = null;
			inicializeVideo();
		});
    
        // Cuando ya hemos configurado lo necesario allá arriba llenamos la lista
    
        llenarLista();
		inicializeVideo();
    }
    
    // Esperar a que el documento esté listo...
    document.addEventListener("DOMContentLoaded", init);