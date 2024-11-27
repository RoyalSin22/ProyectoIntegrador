const express = require('express');
const mysql = require('mysql2');
const app = express();

// Conexión a la base de datos
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '', // tu contraseña
    database: 'salon_belleza'
});

// Conexión a la base de datos
db.connect((err) => {
    if (err) {
        console.error('Error al conectar con la base de datos: ', err);
        return;
    }
    console.log('Conectado a la base de datos');
});

// Endpoint para obtener los datos del reporte (ventas en este caso)
app.get('/api/reportes/ventas', (req, res) => {
    const query = 'SELECT mes, ventas FROM reportes_ventas'; // Cambiar la tabla y columna según tu estructura
    db.query(query, (err, results) => {
        if (err) {
            console.error('Error al obtener datos: ', err);
            res.status(500).send('Error al obtener datos');
            return;
        }
        res.json(results);
    });
});

// Levantar el servidor
app.listen(3000, () => {
    console.log('Servidor en el puerto 3000');
});
