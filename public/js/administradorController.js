// administradorController.js

const db = require('./db'); // Seu pool de conexões mysql2/promise

/**
 * [C] CREATE: Cria um novo registro em Administrador, 
 * ligando um idUsuario existente ao papel de Administrador.
 * * @param {number} idUsuario - O ID do usuário que será o administrador.
 * @returns {number} O ID do Administrador recém-criado.
 */
async function criarAdministrador(idUsuario) {
    // Nota: O idAdm é auto-incrementado, por isso passamos NULL ou omitimos.
    const sql = `
        INSERT INTO Administrador (idUsuario)
        VALUES (?)
    `;
    const values = [idUsuario];

    try {
        const [result] = await db.query(sql, values);
        console.log(`Administrador criado com sucesso para o Usuário ID: ${idUsuario}. Adm. ID: ${result.insertId}`);
        return result.insertId;
    } catch (error) {
        // Erro comum aqui: O idUsuario já está ligado a outro Administrador (UNIQUE constraint)
        console.error("Erro ao criar Administrador:", error);
        throw error;
    }
}

/**
 * [R] READ: Busca o ID do Administrador e dados básicos do usuário
 * dado o ID do Usuário.
 * * @param {number} idUsuario - O ID do usuário.
 * @returns {object | undefined} Dados do administrador, ou undefined.
 */
async function buscarAdministradorPorUsuarioId(idUsuario) {
    const sql = `
        SELECT 
            A.idAdm, 
            U.nome,
            U.email
        FROM Administrador A
        JOIN Usuario U ON A.idUsuario = U.idUsuario
        WHERE A.idUsuario = ?
    `;
    
    try {
        const [rows] = await db.query(sql, [idUsuario]);
        return rows[0]; // Retorna o primeiro (e único) resultado
    } catch (error) {
        console.error(`Erro ao buscar Administrador para o usuário ${idUsuario}:`, error);
        throw error;
    }
}

/**
 * [D] DELETE: Remove um registro da tabela Administrador.
 
 * * @param {number} idAdm - O ID do administrador na tabela Administrador.
 * @returns {number} Número de linhas afetadas (1 se excluído, 0 se não encontrado).
 */
async function deletarAdministrador(idAdm) {
    const sql = "DELETE FROM Administrador WHERE idAdm = ?";
    
    try {
        const [result] = await db.query(sql, [idAdm]);
        return result.affectedRows; 
    } catch (error) {
        console.error(`Erro ao deletar Administrador ${idAdm}:`, error);
        throw error;
    }
}


module.exports = {
    criarAdministrador,
    buscarAdministradorPorUsuarioId,
    deletarAdministrador,
};