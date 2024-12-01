const express = require('express');
const mysql = require('mysql2');
const path = require('path');
const exceljs = require('exceljs');
const PDFDocument = require('pdfkit');

const app = express();

// Configurar EJS como motor de plantillas
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

// Conectar con la base de datos (modifica con tus credenciales)
const db = mysql.createConnection({
  host: 'mysql.railway.internal',    // Cambiar si usas otro host
  user: 'root',         // Cambiar por tu usuario de DB
  password: 'ULEVtQsbOHzMDqdPrwRRYopOXUudfNwy',         // Cambiar por tu contraseña
  database: 'railway' // Cambiar por el nombre de tu base de datos
});

db.connect((err) => {
  if (err) throw err;
  console.log('Conexión a la base de datos establecida');
});

// Middleware para servir archivos estáticos
app.use(express.static(path.join(__dirname, 'public')));

// Ruta para mostrar los reportes
app.get('/reportes', (req, res) => {
  // Aquí puedes realizar la consulta a la base de datos
  db.query('SELECT * FROM tabla_reportes', (err, results) => {
    if (err) throw err;
    res.render('reportes', { data: results });  // "reportes" es el archivo EJS
  });
});

// Ruta para generar un reporte en Excel
app.get('/reporte/excel', (req, res) => {
  db.query('SELECT * FROM tabla_reportes', (err, results) => {
    if (err) throw err;

    const workbook = new exceljs.Workbook();
    const worksheet = workbook.addWorksheet('Reporte');

    worksheet.columns = [
      { header: 'ID', key: 'id' },
      { header: 'Nombre', key: 'nombre' },
      { header: 'Fecha', key: 'fecha' },
      // Agrega más columnas según tu base de datos
    ];

    worksheet.addRows(results);

    res.setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    res.setHeader('Content-Disposition', 'attachment; filename=Reporte.xlsx');
    
    workbook.xlsx.write(res).then(() => {
      res.end();
    });
  });
});

// Ruta para generar un reporte en PDF
app.get('/reporte/pdf', (req, res) => {
  db.query('SELECT * FROM tabla_reportes', (err, results) => {
    if (err) throw err;

    const doc = new PDFDocument();

    res.setHeader('Content-Type', 'application/pdf');
    res.setHeader('Content-Disposition', 'attachment; filename=Reporte.pdf');

    doc.pipe(res);

    doc.fontSize(20).text('Reporte de Datos', { align: 'center' });

    doc.moveDown();
    results.forEach((row) => {
      doc.fontSize(12).text(`ID: ${row.id} - Nombre: ${row.nombre} - Fecha: ${row.fecha}`);
    });

    doc.end();
  });
});

// Iniciar el servidor
app.listen(3000, () => {
  console.log('Servidor corriendo en http://localhost:3000');
});
