
const dataClientes = [
// Función para mostrar los datos de los clientes
];

const dataEmpleados = [
// Función para mostrar los datos de los Especialistas
];

const dataServicios = [
// Función para mostrar los servicios
];

const dataCancelaciones = [
// Función para mostrar los datos de las cancelaciones
];

const dataRespuesta = [
// Función para mostrar los datos del Tiempo Promedio de las respuesta
];

const dataSatisfaccion = [
// Función para mostrar los datos de la satisfaccion de los clientes
];

const dataVentas = [
// Función para mostrar los servicios
];

const reportes = {
    'Clientes': dataClientes,
    'Empleados': dataEmpleados,
    'Servicios': dataServicios,
    'Cancelaciones': dataCancelaciones,
    'RespuestaPromedio': dataRespuesta,
    'Satisfaccion': dataSatisfaccion,
    'Ventas': dataVentas
};

// Función para mostrar los datos
function showData(title, data) {
    let content = `<h3>${title}</h3>`;
    if (Array.isArray(data)) {
        content += `<table class="table"><thead><tr>`;
        Object.keys(data[0]).forEach(key => {
            content += `<th>${key}</th>`;
        });
        content += `</tr></thead><tbody>`;
        data.forEach(item => {
            content += `<tr>`;
            Object.values(item).forEach(value => {
                content += `<td>${value}</td>`;
            });
            content += `</tr>`;
        });
        content += `</tbody></table>`;
    } else {
        content += `<p>${data}</p>`;
    }
    document.getElementById('reportContent').innerHTML = content;
    document.getElementById('reportTitle').textContent = title;
}

// Función para descargar reporte
function downloadReport() {
    const content = document.getElementById('reportContent').innerHTML;
    const blob = new Blob([content], { type: 'text/html' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'reporte_salon_belleza.html';
    link.click();
}

// Asignar eventos a los botones del sidebar
document.getElementById('btnClientes').addEventListener('click', () => showData('Clientes', dataClientes));
document.getElementById('btnEmpleados').addEventListener('click', () => showData('Empleados', dataEmpleados));
document.getElementById('btnServicios').addEventListener('click', () => showData('Servicios', dataServicios));
document.getElementById('btnClientesReporte').addEventListener('click', () => showData('Reporte de Clientes', reportes['Clientes']));
document.getElementById('btnCancelaciones').addEventListener('click', () => showData('Cancelaciones Totales', reportes['Cancelaciones']));
document.getElementById('btnEmpleadosReporte').addEventListener('click', () => showData('Reporte de Empleados', reportes['Empleados']));
document.getElementById('btnSatisfaccion').addEventListener('click', () => showData('Reporte de Satisfacción', reportes['Satisfaccion']));
document.getElementById('btnVentas').addEventListener('click', () => showData('Reporte de Ventas', reportes['Ventas']));
document.getElementById('btnDescargar').addEventListener('click', downloadReport);
