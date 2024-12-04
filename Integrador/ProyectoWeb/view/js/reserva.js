const progreso = document.getElementById('progreso');
const anterior = document.getElementById('anterior');
const siguiente = document.getElementById('siguiente');
const circulos = document.querySelectorAll('.circulo');
const calendarioHorarios = document.getElementById('calendario-horarios');
const selectServicios = document.getElementById('servicios');
const inputFecha = document.getElementById('fecha');
const contenedorInformacion = document.getElementById('contenedor-informacion');
const selectHorarios = document.getElementById('horarios');
let servicioSeleccionado = null;
let horarioSeleccionado = null;
let currentActive = 1;

// Servicios con sus horarios y precios
const servicios = [
    { nombre: 'Corte de cabello', precio: 'S/30', horarios: ['08:00-09:00', '09:00-10:00', '10:00-11:00'] },
    { nombre: 'Manicure', precio: 'S/40', horarios: ['11:00-12:00', '14:00-15:00'] },
    { nombre: 'Pedicure', precio: 'S/50', horarios: ['15:00-16:00', '16:00-17:00'] }
];

// Función para cargar los servicios en el paso 1
function cargarServicios() {
    if (selectServicios) {
        selectServicios.innerHTML = '<option value="">Selecciona un servicio</option>';
        servicios.forEach(servicio => {
            const option = document.createElement('option');
            option.value = servicio.nombre;
            option.textContent = servicio.nombre;
            selectServicios.appendChild(option);
        });
    }
}

// Función para mostrar los horarios y precio en el paso 2
function mostrarHorarios() {
    servicioSeleccionado = selectServicios.value;
    const infoPrecio = document.getElementById('info-precio');

    if (servicioSeleccionado) {
        const servicio = servicios.find(s => s.nombre === servicioSeleccionado);

        // Mostrar el precio
        if (infoPrecio) {
            infoPrecio.textContent = servicio.precio;
        }

        // Limpiar y agregar los horarios disponibles
        if (selectHorarios) {
            selectHorarios.innerHTML = '<option value="">Selecciona un horario</option>';
            servicio.horarios.forEach(horario => {
                const option = document.createElement('option');
                option.value = horario;
                option.textContent = horario;
                selectHorarios.appendChild(option);
            });
        }

        // Mostrar el paso 2
        if (contenedorInformacion) {
            contenedorInformacion.style.display = 'none';
        }
    }
}

// Función para actualizar el horario seleccionado
function actualizarHorario() {
    horarioSeleccionado = selectHorarios.value;
    actualizarInfo();
}

// Función para actualizar la información de la reserva en el paso 2
function actualizarInfo() {
    const fechaSeleccionada = inputFecha.value;

    if (fechaSeleccionada && servicioSeleccionado && horarioSeleccionado) {
        const infoFecha = document.getElementById('info-fecha');
        const infoServicio = document.getElementById('info-servicio');
        const infoPrecio = document.getElementById('info-precio');

        if (infoFecha) {
            infoFecha.textContent = fechaSeleccionada;
        }
        if (infoServicio) {
            infoServicio.textContent = servicioSeleccionado;
        }
        if (infoPrecio) {
            infoPrecio.textContent = servicios.find(s => s.nombre === servicioSeleccionado).precio;
        }

        if (contenedorInformacion) {
            contenedorInformacion.style.display = 'block';
        }
    }
}

// Funciones para la barra de progreso
siguiente.addEventListener('click', () => {
    // Validar antes de avanzar al siguiente paso
    if (currentActive === 1) {
        const fechaSeleccionada = document.getElementById('info-fecha').textContent;
        const servicioSeleccionado = selectServicios.value;

        if (!fechaSeleccionada || !servicioSeleccionado) {
            alert("Por favor, selecciona una fecha y un servicio antes de continuar.");
            return;
        }
    } else if (currentActive === 2) {
        const horarioSeleccionado = selectHorarios.value;

        if (!horarioSeleccionado) {
            alert("Por favor, selecciona un horario antes de continuar.");
            return;
        }
    }

    currentActive++;

    if (currentActive > circulos.length) {
        currentActive = circulos.length;
    }

    update();

    if (currentActive === 3) {
        // Actualizar detalles
        if (contenedorInformacion) {
            contenedorInformacion.style.display = 'none';
        }
        if (calendarioHorarios) {
            calendarioHorarios.style.display = 'none';
        }

        // Actualizar resumen
        document.getElementById('resumen-fecha').textContent = document.getElementById('info-fecha').textContent || 'No seleccionada';
        document.getElementById('resumen-servicio').textContent = selectServicios.value || 'No seleccionado';
        document.getElementById('resumen-horario').textContent = selectHorarios.value || 'No seleccionado';
        document.getElementById('resumen-precio').textContent = servicios.find(s => s.nombre === selectServicios.value)?.precio || 'No disponible';
        document.getElementById('resumen').style.display = 'block';

        // Cambiar el texto del botón a "Finalizar"
        if (siguiente) {
            siguiente.textContent = 'Finalizar';
        }
    } else if (currentActive > 3) {
        window.location.href = "/html/index.html"; // Ruta absoluta
    }
});


anterior.addEventListener('click', () => {
    currentActive--;

    if (currentActive < 1) {
        currentActive = 1;
    }

    update();
});

function update() {
    circulos.forEach((circulo, index) => {
        if (index < currentActive) {
            circulo.classList.add('active');
        } else {
            circulo.classList.remove('active');
        }
    });

    const actives = document.querySelectorAll('.active');
    progreso.style.width = ((actives.length - 1) / (circulos.length - 1)) * 100 + '%';

    if (currentActive === 1) {
        anterior.disabled = true;
        calendarioHorarios.style.display = 'block';
        contenedorInformacion.style.display = 'none';
        document.getElementById('resumen').style.display = 'none';
    } else if (currentActive === 2) {
        anterior.disabled = false;
        calendarioHorarios.style.display = 'none';
        contenedorInformacion.style.display = 'block';
        document.getElementById('resumen').style.display = 'none';
    } else if (currentActive === 3) {
        siguiente.textContent = 'Finalizar';
        document.getElementById('resumen').style.display = 'block';
        contenedorInformacion.style.display = 'none';

        // Mostrar resumen en el paso 3
        document.getElementById('resumen-servicio').textContent = servicioSeleccionado || 'No seleccionado';
        document.getElementById('resumen-horario').textContent = horarioSeleccionado || 'No seleccionado';
        document.getElementById('resumen-precio').textContent = servicios.find(s => s.nombre === servicioSeleccionado)?.precio || 'No disponible';
    }
}

// Cargar los servicios al inicio
cargarServicios();

// Inicializar flatpickr para el calendario
flatpickr("#fecha", {
    dateFormat: "Y-m-d", // Formato de la fecha
    minDate: "today", // Solo se pueden seleccionar fechas a partir de hoy
    locale: "es", // Configuración en español
    allowInput: true, // Permitir que el usuario ingrese la fecha manualmente
});

document.addEventListener('DOMContentLoaded', () => {
    flatpickr("#flatpickr-calendario", {
        inline: true, // Hace que el calendario se muestre directamente
        dateFormat: "Y-m-d", // Formato de la fecha
        minDate: "today", // Restringe las fechas pasadas
        onChange: (selectedDates, dateStr) => {
            // Actualiza el resumen con la fecha seleccionada
            document.getElementById('info-fecha').textContent = dateStr;
            document.getElementById('resumen-fecha').textContent = dateStr;
        }
    });
});
