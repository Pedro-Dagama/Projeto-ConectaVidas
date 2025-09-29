// empresaController.js

const db = require('./db'); // Seu pool de conexões mysql2/promise

/**
 * [C] CREATE: Cadastra uma nova Empresa no banco de dados.
 * @returns {number} O ID da Empresa recém-criada.
 */
async function criarEmpresa(cnpj, razaoSocial, dadosBancarios, areaAtuacao) {
    const sql = `
        INSERT INTO Empresa (cnpj, razaoSocial, dadosBancarios, areaAtuacao)
        VALUES (?, ?, ?, ?)
    `;
    const values = [cnpj, razaoSocial, dadosBancarios, areaAtuacao];

    try {
        const [result] = await db.query(sql, values);
        console.log(`Empresa criada com sucesso! ID: ${result.insertId}`);
        return result.insertId;
    } catch (error) {
        // Erro comum aqui: O CNPJ já existe 
        console.error("Erro ao criar Empresa:", error);
        throw error;
    }
}

/**
 * [R] READ: Busca uma Empresa pelo seu ID.
 * @returns {object | undefined} Os dados da empresa, ou undefined se não encontrar.
 */
async function buscarEmpresaPorId(idEmpresa) {
    const sql = "SELECT * FROM Empresa WHERE idEmpresa = ?";
    
    try {
        const [rows] = await db.query(sql, [idEmpresa]);
        return rows[0];
    } catch (error) {
        console.error(`Erro ao buscar Empresa ${idEmpresa}:`, error);
        throw error;
    }
}

/**
 * [R] READ: Busca todas as Empresas.
 * @returns {Array} Lista de todas as empresas.
 */
async function buscarTodasEmpresas() {
    const sql = "SELECT * FROM Empresa ORDER BY razaoSocial ASC";
    
    try {
        const [rows] = await db.query(sql);
        return rows;
    } catch (error) {
        console.error("Erro ao buscar todas as Empresas:", error);
        throw error;
    }
}

/**
 * [U] UPDATE: Atualiza os dados de uma Empresa existente.
 * @returns {number} Número de linhas afetadas (1 se atualizou, 0 se não encontrou o ID).
 */
async function atualizarEmpresa(idEmpresa, cnpj, razaoSocial, dadosBancarios, areaAtuacao) {
    const sql = `
        UPDATE Empresa 
        SET cnpj = ?, razaoSocial = ?, dadosBancarios = ?, areaAtuacao = ?
        WHERE idEmpresa = ?
    `;
    const values = [cnpj, razaoSocial, dadosBancarios, areaAtuacao, idEmpresa];

    try {
        const [result] = await db.query(sql, values);
        return result.affectedRows; 
    } catch (error) {
        console.error(`Erro ao atualizar Empresa ${idEmpresa}:`, error);
        throw error;
    }
}

/**
 * [D] DELETE: Remove uma Empresa pelo seu ID.
 * @returns {number} Número de linhas afetadas (1 se excluído, 0 se não encontrado).
 */
async function deletarEmpresa(idEmpresa) {
    const sql = "DELETE FROM Empresa WHERE idEmpresa = ?";
    
    try {
        const [result] = await db.query(sql, [idEmpresa]);
        return result.affectedRows; 
    } catch (error) {
        // Atenção: Se essa empresa tiver doações ou outros registros ligados a ela, 
        // o MySQL pode gerar um erro de FOREIGN KEY aqui, a menos que você configure CASCADE.
        console.error(`Erro ao deletar Empresa ${idEmpresa}:`, error);
        throw error;
    }
}

module.exports = {
    criarEmpresa,
    buscarEmpresaPorId,
    buscarTodasEmpresas,
    atualizarEmpresa,
    deletarEmpresa,
};