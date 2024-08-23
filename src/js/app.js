let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
    id: '',
    name: '',
    date: '',
    hour: '',
    services: []
}


document.addEventListener('DOMContentLoaded', function() {
    // Código aquí
    iniciarApp();
});

function iniciarApp () {
    mostrarSeccion(); // Muestar y Oculta las secciones
    tabs(); // Cambia la seleccion cuando presionen los datos
    botonesPaginador(); // Agrega o quita los botones del paginador
    paginaSiguiente(); 
    paginaAnterior();

    consultarAPI(); // Consulta la API en el backend de PHP

    idCliente();
    nombreCliente(); // Añade el nombre del cliente al objeto de cita 
    selecionarFecha(); // Añade la fecha al objeto de la cita
    selecionarHora(); // Añade la hora al objeto de la cita

    mostrarResumen(); // Muestra el resumen de la cita
}

function mostrarSeccion() {
    // Ocultar todas las secciones que tengan la clase de mostrar
    const seccionAnterior = document.querySelector('.mostrar');
    if(seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }    

    //Seleccionar la seccion con el paso
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');

    // Quita la clase de actual al anterior
    const tabAnterior = document.querySelector('.actual');
    if(tabAnterior) {
        tabAnterior.classList.remove('actual');
    }

    // Resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
}

function tabs() {
    // Seleccionar elementos
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach( boton => {
        boton.addEventListener('click', function(e) {
            paso = parseInt(e.target.dataset.paso);
            mostrarSeccion();

            botonesPaginador(); 
        })
    });
}

function botonesPaginador() {
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if(paso === 1) {
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    } else if (paso === 3) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');

        mostrarResumen();
    }else {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }

    mostrarSeccion();
}

function paginaAnterior() {
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function() {

        if (paso <= pasoInicial) return;
        paso--;

        botonesPaginador();
    });
}

function paginaSiguiente() {
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function() {

        if (paso >= pasoFinal) return;
        paso++;

        botonesPaginador();
    });
}

async function consultarAPI (){
    try {
        //const url = `${location.origin}/api/servicios`;
        const url = '/api/servicios'; // --> URL 
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);

    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios (servicios) {
    servicios.forEach( servicio => {
        const {id, name, cost} = servicio;

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('name-services');
        nombreServicio.textContent = name;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('cost-services');
        precioServicio.textContent = `${cost}€`;

        const servicioDIV = document.createElement('DIV');
        servicioDIV.classList.add('service');
        servicioDIV.dataset.idServicio = id;
        servicioDIV.onclick = function() { // --> seleccionarServicio(servicio); Nota: esto podría funcionar si es un solo resultado
            seleccionarServicio(servicio);
        }
        servicioDIV.appendChild(nombreServicio);
        servicioDIV.appendChild(precioServicio);

        document.querySelector('#servicios').appendChild(servicioDIV);

    });
}

function seleccionarServicio(servicio) {
    const { id } = servicio
    const { services } = cita;

    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

    // Comprobar si un servicio ya fue agregado o quitarlo
    if ( services.some( agregado => agregado.id === id ) ) {
        // Esto comprueba que esta agregado
        // Entonces si ya esta agregado, y le vuelven a clicar, entonces quitamos la marca de selected
        cita.services = services.filter( agregado => agregado.id !== id )
        divServicio.classList.remove('selected');
    } else {
        // Este comprueba que no esta agregado.
        // Por lo que le ponemos la marca de selected
        cita.services = [...services, servicio];
        divServicio.classList.add('selected');
    }

    // console.log(cita);

}

function idCliente () {
    cita.id = document.querySelector('#id').value;
}

function nombreCliente () {
    cita.name = document.querySelector('#name').value;
}

function selecionarFecha() {
    const inputDate = document.querySelector('#datecita');
    inputDate.addEventListener('input', function(e) {        

        //Vamos a validar para que no pidan cita los fines de semana.
        const dia = new Date(e.target.value).getUTCDay();

        if([6, 0].includes(dia)) {
            //console.log('Sábados y Domingos no abrimos');
            e.target.value = '';
            mostarAlerta('Fines de semana no permitidos', 'error', '.formulario');
        } else {
            //console.log ('correcto...');
            cita.date = e.target.value;
        }
        //cita.date = inputDate.value;
    });
}

function selecionarHora() {
    const inputHours = document.querySelector('#hours');
    inputHours.addEventListener('input', function(e) {
        //console.log(e.target.value);

        const horaCita = e.target.value;
        const hora = horaCita.split(":")[0]; // Le pasamos de una vez la posición de la hora

        //console.log(hora[0]); Dentro de los corchetes solo seleccionamos la posición de la hora
        if(hora < 8 || hora > 20) { 
            e.target.value = '';
            //console.log('Fuera de horario de atención');
            mostarAlerta('Fuera de horario de atención', 'error', '.formulario');
        } else {
            cita.hour = e.target.value;

            // console.log(cita);
        }
    });
}

function mostarAlerta(mensaje, tipo, elemento, desaparece = true) {

    //Previene que se genere más de una Alerta
    const alertaPrevia = document.querySelector('.alerta');
    if (alertaPrevia) {
        alertaPrevia.remove();
    };

    // Scripting para crear la alerta
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    if(desaparece) {
        // Eliminar la alerta
        setTimeout(() => {
            alerta.remove();
        }, 2000);
    }

}

function mostrarResumen() {
    const resumen = document.querySelector('.contenido-resumen');

    // Limpiamos el contenido del resumen
    while(resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }

    //console.log(Object.values(cita)); --> Comprobamos los valores del objeto cita
    //console.log(cita.services.length);
    if(Object.values(cita).includes('') || cita.services.length === 0 ) {
        mostarAlerta('Faltan datos de servicios, fechas u Hora', 'error', '.contenido-resumen', false)
        return;
    } 

    // formatear el div del resume
    const {name, date, hour, services} = cita;

    //console.log(horaCita);

    // Headding para Servicios en resumen
    const headdingServicios = document.createElement('H3');
    headdingServicios.textContent = 'Resumen de Servicios';
    resumen.appendChild(headdingServicios);

    // En esto siguiente vamos iterar y mostrar por cada servicio, así sea un solo servicio seleccionado
    services.forEach( service => {
        const {id, cost, name} = service;
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenido-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = name;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span> ${cost}€`

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);

    });

    // Headding para Cita Resumen
    const headdingCita = document.createElement('H3');
    headdingCita.textContent = 'Resumen de Cita';
    resumen.appendChild(headdingCita);

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${name}`;

    // Formateamos la fecha en español
    const fechaObj = new Date(date); //--> este objeto de date, antes iba donde esta fechaFormateada
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate();
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date( Date.UTC(year, mes, dia));
    //console.log(fechaUTC); Comprobamos que nos devuelve correctamente la fecha

    const opciones = {weekday: 'long', year: 'numeric', month:'long', day: 'numeric' } 
    const fechaFormateado = fechaUTC.toLocaleDateString('es-es', opciones);

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateado}`; // --> donde esta fechaFormateada estaba antes date

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora:</span> ${hour} hrs`;

    // Boton para crear una cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = reservarCita;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);

    resumen.appendChild(botonReservar);
}

async function reservarCita() {

    const { name, date, hour, services, id } = cita;

    const idServicios = services.map( servicio => servicio.id );
    // console.log(idServicios); --> Devolvemos el resultado de los id de los servicios que debemos guardar en la bbdd
    // return;

    const datos = new FormData();
    datos.append('userId', id);
    datos.append('datecita', date);
    datos.append('hours', hour);
    datos.append('services', idServicios);

    // console.log([...datos]); // Comprobamos que estamos enviando los datos a $_POST de APIController
    // return; --> hacemos un return para no enviar la petición a la url

    try {
        // Petición hacia la API
        //const url = `${location.origin}/api/citas`;
        //const url = 'http://localhost:3000/api/citas'; --> Con esto verificamos el mensaje de error, lo forzamos mandando mal la url.
        const url = '/api/citas'; // --> URL 
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });
        
        const resultado = await respuesta.json();
        console.log(resultado.resultado); //--> Estamos probando lo que estamos enviando desde APIController
        //Este resultado se puede consultar desde la consola del navegador
    
        if (resultado.resultado) {
            Swal.fire({
                icon: 'success',
                title: 'Cita creada con éxito',
                text: 'La cita ha sido creada con éxito',
                button: 'OK'
            }).then( () => {
                setTimeout( () => {
                    window.location.reload();
                }, 2000);
            })
        }        
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un error al guardar la cita'
        })
    }



    //console.log([...datos]); --> Comprobar los datos para ver lo que le pasamos al FormData



}