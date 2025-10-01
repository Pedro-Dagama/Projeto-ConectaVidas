// doadorController.js

const db = require('./db'); // Seu pool de conexões mysql2/promise

/**
 * [C] CREATE: Cria um novo registro em Doador, 
 * ligando um idUsuario existente ao papel de Doador.
 * * @param {number} idUsuario - O ID do usuário que será o doador.
 * @returns {number} O ID do Doador recém-criado.
 */
async function criarDoador(idUsuario) {
    // Nota: O idDoador é auto-incrementado, por isso passamos NULL ou omitimos.
    const sql = `
        INSERT INTO Doador (idUsuario)
        VALUES (?)
    `;
    const values = [idUsuario];

    try {
        const [result] = await db.query(sql, values);
        console.log(`Doador criado com sucesso para o Usuário ID: ${idUsuario}. Doador ID: ${result.insertId}`);
        return result.insertId;
    } catch (error) {
        // Erro comum: O idUsuario já está ligado a outro Doador (UNIQUE constraint)
        console.error("Erro ao criar Doador:", error);
        throw error;
    }
}

/**
 * [R] READ: Busca o ID do Doador e dados básicos do usuário
 * dado o ID do Usuário.
 * * @param {number} idUsuario - O ID do usuário.
 * @returns {object | undefined} Dados do doador, ou undefined.
 */
async function buscarDoadorPorUsuarioId(idUsuario) {
    const sql = `
        SELECT 
            D.idDoador, 
            U.nome,
            U.email
        FROM Doador D
        JOIN Usuario U ON D.idUsuario = U.idUsuario
        WHERE D.idUsuario = ?
    `;
    
    try {
        const [rows] = await db.query(sql, [idUsuario]);
        return rows[0]; // Retorna o primeiro (e único) resultado
    } catch (error) {
        console.error(`Erro ao buscar Doador para o usuário ${idUsuario}:`, error);
        throw error;
    }
}

/**
 * [R] READ: Busca todas as doações feitas por um doador específico.
 * Usa um JOIN com a tabela Doacao.
 * * @param {number} idDoador - O ID do Doador na tabela Doador.
 * @returns {Array} Lista de doações.
 */
async function buscarHistoricoDoacoes(idDoador) {
    // Nota: Descobrindo qual o idUsuario ligado ao idDoador primeiro.
    const sql = `
        SELECT 
            DO.*,
            C.titulo AS tituloCampanha
        FROM Doacao DO
        JOIN Campanha C ON DO.idCampanha = C.idCampanha
        JOIN Usuario U ON DO.idUsuario = U.idUsuario
        JOIN Doador D ON U.idUsuario = D.idUsuario
        WHERE D.idDoador = ?
        ORDER BY DO.data DESC
    `;
    
    try {
        const [rows] = await db.query(sql, [idDoador]);
        return rows;
    } catch (error) {
        console.error(`Erro ao buscar histórico de doações para o Doador ${idDoador}:`, error);
        throw error;
    }
}

module.exports = {
    criarDoador,
    buscarDoadorPorUsuarioId,
    buscarHistoricoDoacoes,
};