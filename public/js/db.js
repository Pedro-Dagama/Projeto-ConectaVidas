// db. para módulo de conexão .env para credenciais seguras

require('dotenv').config(); // Carrega as variáveis do .env
const mysql = require('mysql2');

// Cria o pool de conexões (melhor para aplicações web)
const pool = mysql.createPool({
    host: process.env.DB_HOST,
    user: process.env.DB_USER,
    password: process.env.DB_PASSWORD,
    database: process.env.DB_NAME,
    waitForConnections: true,
    connectionLimit: 10,
    queueLimit: 0
});

// Exporta o pool para que outros arquivos possam executar consultas
module.exports = pool.promise();
