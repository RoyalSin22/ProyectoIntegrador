// Crear gráfico con Chart.js
const ctx = document.getElementById('salesChart').getContext('2d');
let chart;

function createSalesChart(data) {
    if (chart) chart.destroy();  // Destruir el gráfico anterior si existe
    
    chart = new Chart(ctx, {
        type: 'bar',  // Tipo de gráfico (Barra)
        data: {
            labels: data.labels,  // Etiquetas para el eje X
            datasets: [{
                label: 'Ventas del Mes',  // Etiqueta del gráfico
                data: data.values,  // Datos para el gráfico
                backgroundColor: '#2980b9',  // Color de fondo de las barras
                borderColor: '#1abc9c',  // Color del borde de las barras
                borderWidth: 1  // Grosor del borde
            }]
        },
        options: {
            responsive: true,  // El gráfico será responsivo
            scales: {
                y: {
                    beginAtZero: true  // Asegurar que el eje Y comience en 0
                }
            }
        }
    });
}

// Datos de ventas ejemplo
const salesData = {
    labels: ['Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'],  // Meses
    values: [2000, 1500, 3000, 2500, 4000]  // Valores de ventas
};

// Cargar el gráfico de ventas por defecto
createSalesChart(salesData);

// Evento para generar el reporte PDF
document.getElementById('generatePDF').addEventListener('click', () => {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    doc.text('Reporte de Ventas', 10, 10);  // Título en el PDF
    doc.autoTable({
        head: [['Mes', 'Ventas']],  // Encabezado de la tabla
        body: salesData.labels.map((label, index) => [label, salesData.values[index]])  // Crear filas con los datos de ventas
    });
    doc.save('reporte-ventas.pdf');  // Guardar el PDF con el nombre 'reporte-ventas.pdf'
});

// Evento para retroceder
document.getElementById('volver').addEventListener('click', () => {
    window.location.href = "../html/index.html";  // Cambiar la URL de la página
});
