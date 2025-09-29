// campanhaController.js

const db = require('./db'); // Seu pool de conexões mysql2/promise

/**
 * [C] CREATE: Cria uma nova campanha
 * O valorArrecadado é definido automaticamente como 0.00 (DEFAULT).
 */
async function criarCampanha(titulo, metaFinanceira, descricao, dataInicial, dataFinal, status, idOng) {
    const sql = `
        INSERT INTO Campanha (titulo, metaFinanceira, descricao, dataInicial, dataFinal, status, idOng)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    `;
    const values = [titulo, metaFinanceira, descricao, dataInicial, dataFinal, status, idOng];

    try {
        const [result] = await db.query(sql, values);
        console.log(`Campanha criada com sucesso! ID: ${result.insertId}`);
        return result.insertId;
    } catch (error) {
        console.error("Erro ao criar campanha:", error);
        throw error;
    }
}

/**
 * [R] READ: Busca todas as campanhas, mostrando o nome da ONG
 */
async function buscarTodasCampanhas() {
    const sql = `
        SELECT 
            C.*, 
            O.nome AS nomeOng
        FROM Campanha C
        JOIN ONG O ON C.idOng = O.idOng
        ORDER BY C.dataInicial DESC
    `;
    try {
        const [rows] = await db.query(sql);
        return rows;
    } catch (error) {
        console.error("Erro ao buscar campanhas:", error);
        throw error;
    }
}

/**
 * [U] UPDATE: Atualiza os dados de uma campanha existente
 */
async function atualizarCampanha(idCampanha, titulo, metaFinanceira, descricao, dataFinal, status) {
    const sql = `
        UPDATE Campanha 
        SET titulo = ?, metaFinanceira = ?, descricao = ?, dataFinal = ?, status = ?
        WHERE idCampanha = ?
    `;
    const values = [titulo, metaFinanceira, descricao, dataFinal, status, idCampanha];

    try {
        const [result] = await db.query(sql, values);
        return result.affectedRows; // 1 se atualizou, 0 se não encontrou o ID
    } catch (error) {
        console.error(`Erro ao atualizar campanha ${idCampanha}:`, error);
        throw error;
    }
}


// Exporta as funções
module.exports = {
    criarCampanha,
    buscarTodasCampanhas,
    atualizarCampanha,
    // ... incluir outras funções CRUD (como buscarCampanhaPorId e deletarCampanha)
};