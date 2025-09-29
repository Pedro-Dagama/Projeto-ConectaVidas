// representanteOngController.js

const db = require('./db'); // Seu pool de conexões mysql2/promise

/**
 * [C] CREATE: Cria um novo registro em RepresentanteONG, 
 * ligando um idUsuario existente ao papel de Representante.
 * * @param {number} idUsuario - O ID do usuário que será o representante.
 * @returns {number} O ID do RepresentanteONG recém-criado.
 */
async function criarRepresentanteONG(idUsuario) {
    // Nota: O idRepresentante é auto-incrementado, por isso passamos NULL ou omitimos.
    const sql = `
        INSERT INTO RepresentanteONG (idUsuario)
        VALUES (?)
    `;
    const values = [idUsuario];

    try {
        const [result] = await db.query(sql, values);
        console.log(`RepresentanteONG criado com sucesso para o Usuário ID: ${idUsuario}. Repr. ID: ${result.insertId}`);
        return result.insertId;
    } catch (error) {
        // Erro comum aqui: O idUsuario já está ligado a outro RepresentanteONG (UNIQUE constraint)
        console.error("Erro ao criar RepresentanteONG:", error);
        throw error;
    }
}

/**
 * [R] READ: Busca o ID do RepresentanteONG e o nome da ONG (se houver) 
 * dado o ID do Usuário.
 * * @param {number} idUsuario - O ID do usuário.
 * @returns {object | undefined} Dados do representante e da ONG, ou undefined.
 */
async function buscarRepresentantePorUsuarioId(idUsuario) {
    const sql = `
        SELECT 
            R.idRepresentante, 
            O.idOng,
            O.nome AS nomeONG
        FROM RepresentanteONG R
        LEFT JOIN ONG O ON R.idRepresentante = O.idRepresentante
        WHERE R.idUsuario = ?
    `;
    
    try {
        const [rows] = await db.query(sql, [idUsuario]);
        return rows[0]; // Retorna o primeiro (e único) resultado
    } catch (error) {
        console.error(`Erro ao buscar RepresentanteONG para o usuário ${idUsuario}:`, error);
        throw error;
    }
}

module.exports = {
    criarRepresentanteONG,
    buscarRepresentantePorUsuarioId,
};