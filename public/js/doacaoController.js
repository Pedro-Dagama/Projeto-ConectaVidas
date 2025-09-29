// doacaoController.js

const db = require('./db'); 

/**
 * CREATE e UPDATE: Registrar uma nova doação E atualiza o valor arrecadado da campanha
 * de forma atômica (usando transação).
 */
 
async function registrarDoacao(valor, data, formaPagamento, comprovante, idCampanha, idUsuario) {
    // 1. Definição do SQL para INSERIR  a Doação

    const sql =`
        INSERT INTO Doacao (valor, data, formaPagamento, comprovante, idCampanha, idUsuario)
        VALUES (?, ?, ?, ?, ?, ?)
    `;
    const values = [valor, data, formaPagamento, comprovante, idCampanha, idUsuario];

    // 2. Definição do SQL para ATUALIZAR a Campanha
    // Isso soma o novo 'valor' ao 'valorArrecadado' existente
    
    const sqlUpdateCampanha = `
        UPDATE Campanha 
        SET valorArrecadado = valorArrecadado + ? 
        WHERE idCampanha = ?
    `;
    const valuesUpdateCampanha = [valor, idCampanha];

    let conn; // Variável para a conexão

    try {
        // --- INÍCIO DA TRANSAÇÃO ---
        conn = await db.getConnection(); // Obtém uma conexão do pool
        await conn.beginTransaction();  // Inicia a transação
        
        // A. Insere a Doação
        const [resultDoacao] = await conn.query(sqlInsertDoacao, valuesInsertDoacao);
        const idDoacao = resultDoacao.insertId;
        
        console.log(`Doação registrada com sucesso! ID: ${idDoacao}`);

        // B. Atualiza o Valor da Campanha
        const [resultCampanha] = await conn.query(sqlUpdateCampanha, valuesUpdateCampanha);
        
        if (resultCampanha.affectedRows === 0) {
            // Se nenhuma linha foi afetada, a campanha não existe ou ID está errado
            throw new Error(`Campanha ${idCampanha} não encontrada para atualização.`);
        }
        
        // C. Confirma ambas as operações
        await conn.commit();
        
        return idDoacao;

    } catch (error) {
        // --- ERRO: DESFAZ A TRANSAÇÃO ---
        if (conn) {
            await conn.rollback(); // Se algo falhou, cancela a inserção e a atualização
        }
        
        console.error("Erro CRÍTICO ao registrar transação de doação:", error.message);
        // Relança o erro para quem chamou a função
        throw error; 
        
    } finally {
        // D. Libera a conexão
        if (conn) {
            conn.release(); 
        }    
    }
}

// READ: Buscar doações por Campanha (exemplo de JOIN)
async function buscarDoacoesPorCampanha(idCampanha) {
    const sql = `
        SELECT 
            D.valor, D.data, D.formaPagamento,
            U.nome AS nomeDoador, U.email
        FROM Doacao D
        JOIN Usuario U ON D.idUsuario = U.idUsuario
        WHERE D.idCampanha = ?
        ORDER BY D.data DESC
    `;
    try {
        const [rows] = await db.query(sql, [idCampanha]);
        return rows;
    } catch (error) {
        console.error(`Erro ao buscar doações da campanha ${idCampanha}:`, error);
        throw error;
    }
}

module.exports = {
    registrarDoacao,
    buscarDoacoesPorCampanha
};