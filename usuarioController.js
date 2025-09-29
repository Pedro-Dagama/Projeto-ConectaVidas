// usuarioController.js

const db = require('./db'); // Importa o módulo de conexão

// 1. CREATE: Cadastrar um novo usuário
async function criarUsuario(nome, email, senha, tipoUsuario) {
    // Usar bcrypt para hashear a senha antes de salvar é CRUCIAL!
    // Aqui estamos apenas inserindo diretamente para fins de exemplo.
    const sql = `
        INSERT INTO Usuario (nome, email, senha, tipoUsuario)
        VALUES (?, ?, ?, ?)
    `;
    const values = [nome, email, senha, tipoUsuario];

    try {
        const [result] = await db.query(sql, values);
        console.log(`Usuário ${nome} criado com sucesso! ID: ${result.insertId}`);
        return result.insertId;
    } catch (error) {
        console.error("Erro ao criar usuário:", error);
        throw error;
    }
}

// 2. READ: Buscar todos os usuários
async function buscarTodosUsuarios() {
    const sql = "SELECT idUsuario, nome, email, tipoUsuario FROM Usuario"; // Não inclua a senha!
    try {
        const [rows] = await db.query(sql);
        return rows; // Retorna a lista de usuários
    } catch (error) {
        console.error("Erro ao buscar usuários:", error);
        throw error;
    }
}

// 3. READ: Buscar usuário por ID
async function buscarUsuarioPorId(idUsuario) {
    const sql = "SELECT idUsuario, nome, email, tipoUsuario FROM Usuario WHERE idUsuario = ?";
    try {
        const [rows] = await db.query(sql, [idUsuario]);
        return rows[0]; // Retorna o primeiro (e único) resultado
    } catch (error) {
        console.error(`Erro ao buscar usuário ${idUsuario}:`, error);
        throw error;
    }
}

// 4. DELETE: Excluir um usuário
async function excluirUsuario(idUsuario) {
    // Atenção: Excluir o usuário também exigirá que você exclua 
    // ou atualize as entradas nas tabelas de Admin, Repr. ONG e Doador!
    const sql = "DELETE FROM Usuario WHERE idUsuario = ?";
    try {
        const [result] = await db.query(sql, [idUsuario]);
        return result.affectedRows; // Retorna 1 se excluiu, 0 se não encontrou
    } catch (error) {
        console.error(`Erro ao excluir usuário ${idUsuario}:`, error);
        throw error;
    }
}

module.exports = {
    criarUsuario,
    buscarTodosUsuarios,
    buscarUsuarioPorId,
    excluirUsuario
};