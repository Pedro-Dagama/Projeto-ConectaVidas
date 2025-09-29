// ongController.js

const db = require('./db'); // Seu pool de conexões mysql2/promise

/**
 * [C] CREATE: Cria uma nova ONG e garante que o representante exista.
 * Essa função assume que o Repr. ONG (idRepresentante) já foi criado 
 * (o que implica que o Usuario dele também já foi criado).
 */
async function criarONG(nome, descricao, contato, dadosBancarios, idRepresentante) {
    let conn;
    
    // 1. Definição do SQL para INSERIR a ONG
    const sqlInsertONG = `
        INSERT INTO ONG (nome, descricao, contato, dadosBancarios, idRepresentante)
        VALUES (?, ?, ?, ?, ?)
    `;
    const valuesInsertONG = [nome, descricao, contato, dadosBancarios, idRepresentante];

    try {
        conn = await db.getConnection(); 
        await conn.beginTransaction(); // Inicia a transação

        // 1.1. Insere a nova ONG
        const [resultONG] = await conn.query(sqlInsertONG, valuesInsertONG);
        const idOng = resultONG.insertId;
    
        await conn.commit(); // Confirma a inserção

        console.log(`ONG ${nome} criada com sucesso! ID: ${idOng}`);
        return idOng;

    } catch (error) {
        if (conn) {
            await conn.rollback(); // Desfaz se falhar (ex: idRepresentante inválido)
        }
        console.error("Erro CRÍTICO ao registrar ONG:", error.message);
        throw error;
    } finally {
        if (conn) {
            conn.release(); 
        }
    }
}

/**
 * [R] READ: Busca uma ONG específica e mostra dados do seu representante
 */
async function buscarONGPorId(idOng) {
    const sql = `
        SELECT 
            O.*, 
            U.nome AS nomeRepresentante, 
            U.email AS emailRepresentante
        FROM ONG O
        JOIN RepresentanteONG R ON O.idRepresentante = R.idRepresentante
        JOIN Usuario U ON R.idUsuario = U.idUsuario
        WHERE O.idOng = ?
    `;
    try {
        const [rows] = await db.query(sql, [idOng]);
        return rows[0]; // Retorna a ONG encontrada
    } catch (error) {
        console.error(`Erro ao buscar ONG ${idOng}:`, error);
        throw error;
    }
}

module.exports = {
    criarONG,
    buscarONGPorId,
    // ... incluir outras funções CRUD
};