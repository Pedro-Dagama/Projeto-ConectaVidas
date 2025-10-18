const { jsPDF } = window.jspdf;

// --- Definição da Cor da Plataforma ---
const COR_PRINCIPAL_HEX = '#FF6C02';
const COR_PRINCIPAL_RGB = [255, 108, 2];
const NOME_PLATAFORMA = "ConectaVidas+";

document.getElementById('btnBaixarPDF').addEventListener('click', () => {
    try {
        // --- Configuração Inicial ---
        const doc = new jsPDF('p', 'mm', 'a4');
        const pageWidth = doc.internal.pageSize.getWidth();
        const pageHeight = doc.internal.pageSize.getHeight();
        const margin = 15;
        const linhaAltura = 6;
        let y = margin + 10;

        const nomeOngElement = document.querySelector('.dropdown.menu-user span');
        const nomeOng = nomeOngElement ? nomeOngElement.textContent : "ONG - ConectaVidas+";

        // --- Função Cabeçalho e Rodapé ---
        const addHeaderAndFooter = (docInstance = doc) => {
            docInstance.setFontSize(10);
            docInstance.setFont("helvetica", "normal");

            // Cabeçalho (Nome da ONG e Data de Geração)
            docInstance.setFont("helvetica", "bold");
            docInstance.text(nomeOng, margin, margin - 5);
            docInstance.setFont("helvetica", "normal");
            docInstance.text(`Gerado em: ${new Date().toLocaleDateString('pt-BR')}`, pageWidth - margin, margin - 5, { align: "right" });

            // Linha Divisória (Cabeçalho)
            docInstance.setDrawColor(200, 200, 200);
            docInstance.line(margin, margin - 2, pageWidth - margin, margin - 2);

            // Rodapé (Copyright da Plataforma)
            docInstance.setFontSize(8);
            docInstance.setFont("helvetica", "normal");
            // Adicionando o símbolo de copyright (\u00A9)
            docInstance.text(`\u00A9 ${new Date().getFullYear()} ${NOME_PLATAFORMA}`, pageWidth / 2, pageHeight - 5, { align: "center" });
        };
        
        // Adiciona a paginação e a linha divisória do rodapé em todas as páginas.
        doc.putTotalPages = function() {
            for (let i = 1; i <= this.internal.getNumberOfPages(); i++) {
                this.setPage(i);
                
                // Símbolo de copyright em todas as páginas
                this.setFontSize(8);
                this.setFont("helvetica", "normal");
                this.text(`\u00A9 ${new Date().getFullYear()} ${NOME_PLATAFORMA}`, pageWidth / 2, pageHeight - 5, { align: "center" });
                
                // Número da Página
                this.setFontSize(10);
                this.text(`Página ${i} de ${this.internal.getNumberOfPages()}`, pageWidth - margin, pageHeight - 10, { align: "right" });

                // Linha Divisória (Rodapé)
                this.setDrawColor(200, 200, 200);
                this.line(margin, pageHeight - 13, pageWidth - margin, pageHeight - 13);
            }
            this.setPage(1); // Volta para a primeira página
        };

        // --- Função para checar quebra de página e adicionar nova página ---
        const checkPageBreak = (requiredSpace) => {
            // Garante que haja espaço suficiente para o conteúdo + espaço do rodapé
            if (y + requiredSpace > pageHeight - margin - 13) { 
                doc.addPage();
                y = margin + 10;
                addHeaderAndFooter();
            }
        };

        // --- Início: Cabeçalho da primeira página ---
        addHeaderAndFooter();
        
        // --- 1. Título Principal (APLICANDO COR) ---
        doc.setFontSize(18);
        doc.setFont("helvetica", "bold");
        doc.setTextColor(COR_PRINCIPAL_RGB[0], COR_PRINCIPAL_RGB[1], COR_PRINCIPAL_RGB[2]); // Laranja (#FF6C02)
        doc.text("Relatório de Desempenho da Campanha", pageWidth / 2, y, { align: "center" });
        y += linhaAltura + 5;
        
        doc.setLineWidth(0.5);
        doc.setDrawColor(COR_PRINCIPAL_RGB[0], COR_PRINCIPAL_RGB[1], COR_PRINCIPAL_RGB[2]); // Laranja (#FF6C02)
        doc.line(margin, y - 2, pageWidth - margin, y - 2);
        doc.setTextColor(30, 30, 30); // Volta ao preto para o texto normal
        y += 5;

        // --- 2. Detalhes da Campanha ---
        doc.setFontSize(14);
        doc.setFont("helvetica", "bold");
        doc.text("1. Detalhes da Campanha", margin, y);
        y += linhaAltura;

        doc.setFontSize(11);
        doc.setFont("helvetica", "normal");
        
        // Extração de Dados 
        const campanhaElement = document.querySelector('.card-body h4');
        const campanha = campanhaElement ? campanhaElement.textContent.replace("Campanha: ", "").trim() : "Não Informado";
        
        const allPtags = document.querySelectorAll('.card-body p');
        const periodo = allPtags[0] ? allPtags[0].querySelector('strong')?.nextSibling?.textContent.trim() : "Não Informado";
        const objetivo = allPtags[1] ? allPtags[1].textContent.replace('Objetivo:', '').trim() : "Não Informado";
        const descricao = document.querySelector('.card-body p.mb-0')?.textContent.replace('Descrição: ', '').trim() || "Não Informada";


        const valorStartDetails = margin + 40; 

        const addCampo = (label, valor) => {
            doc.setFont("helvetica", "bold");
            doc.text(`${label}:`, margin, y);
            
            doc.setFont("helvetica", "normal");
            if (label === "Descrição") {
                const availableWidth = pageWidth - (valorStartDetails + 5);
                const descricaoLines = doc.splitTextToSize(valor, availableWidth); 
                doc.text(descricaoLines, valorStartDetails, y);
                y += descricaoLines.length * linhaAltura;
            } else {
                doc.text(valor, valorStartDetails, y);
                y += linhaAltura;
            }
        };

        addCampo("Título", campanha);
        addCampo("Período", periodo);
        addCampo("Objetivo", objetivo);
        addCampo("Descrição", descricao);
        y += 5;

        // --- 3. Indicadores de Desempenho (Estatísticas) ---
        checkPageBreak(50);
        doc.setFontSize(14);
        doc.setFont("helvetica", "bold");
        doc.text("2. Indicadores de Desempenho", margin, y);
        y += linhaAltura;

        const estatisticas = document.querySelectorAll('.row.g-4.mb-5 .card-body h3');
        const titulosEst = document.querySelectorAll('.row.g-4.mb-5 .card-body h6');
        
        doc.setFontSize(11); 

        const col1X = margin;
        const col2X = pageWidth / 2;
        const valorStartCol1 = col1X + 40; 
        const valorStartCol2 = col2X + 60; 
        
        estatisticas.forEach((estat, i) => {
            const index = i % 2;
            
            const currentX = (index === 0) ? col1X : col2X;
            const valorStartX = (index === 0) ? valorStartCol1 : valorStartCol2;

            if (index === 0) {
                if (i !== 0) y += linhaAltura; 
            } else {
                checkPageBreak(linhaAltura); 
            }
            
            const label = titulosEst[i].textContent;
            doc.setFont("helvetica", "bold");
            doc.text(`${label}:`, currentX, y);
            
            doc.setFont("helvetica", "normal");
            doc.text(estat.textContent, valorStartX, y);
        });
        
        y += linhaAltura + 5; 

        // --- 4. Tabela de Top() Doadores ---
        checkPageBreak(100);
        doc.setFontSize(14);
        doc.setFont("helvetica", "bold");
        doc.text("3. Principais Contribuições", margin, y);
        y += linhaAltura + 2;

        const linhas = Array.from(document.querySelectorAll('#corpoTabela tr'));
        const doadores = linhas.map(tr => ({
            nome: tr.children[0].textContent,
            valor: parseFloat(tr.children[1].textContent.replace('R$', '').replace(/\./g, '').replace(',', '.').trim()) || 0,
            data: tr.children[2].textContent,
            metodo: tr.children[3].textContent
        }));
        
        const topDoadores = doadores.sort((a,b) => b.valor - a.valor).slice(0, Math.min(doadores.length, 5));

        const bodyData = topDoadores.map(d => [
            d.nome,
            `R$ ${d.valor.toLocaleString('pt-BR', {minimumFractionDigits: 2})}`,
            d.data,
            d.metodo
        ]);

        doc.autoTable({
            startY: y,
            head: [['Doador', 'Valor (R$)', 'Data', 'Método']],
            body: bodyData,
            styles: { fontSize: 10, cellPadding: 3 },
            headStyles: { fillColor: COR_PRINCIPAL_RGB, textColor: [255,255,255], fontStyle: 'bold' },
            margin: { left: margin, right: margin },
            didDrawPage: (data) => {
                 // A linha do rodapé será adicionada pelo addHeaderAndFooter
                 addHeaderAndFooter(data.doc); 
            }
        });

        y = doc.autoTable.previous.finalY + 10;

        // --- 5. Gráficos ---
        const espacoGraficos = 10 + 60 + 20; 
        checkPageBreak(espacoGraficos); 

        doc.setFontSize(14);
        doc.setFont("helvetica", "bold");
        doc.text("4. Análise Gráfica", margin, y);
        y += linhaAltura + 5;

        const graficoArrecadacao = document.getElementById('graficoArrecadacao');
        const graficoDistribuicao = document.getElementById('graficoDistribuicao');

        const canvasWidth = (pageWidth - 3 * margin) / 2;
        const canvasHeight = 60;
        const xStart = margin;
        let chartY = y; 

        // Gráfico 1 - Lado esquerdo
        if (graficoArrecadacao) {
            const imgData = graficoArrecadacao.toDataURL('image/png');
            doc.setFontSize(10);
            doc.text("Distribuição de Doações por Método", xStart + canvasWidth/2, chartY, { align: 'center' });
            chartY += linhaAltura + 2;
            doc.addImage(imgData, 'PNG', xStart, chartY, canvasWidth, canvasHeight);
        }

        // Gráfico 2 - Lado direito
        if (graficoDistribuicao) {
            const imgData = graficoDistribuicao.toDataURL('image/png');
            doc.setFontSize(10);
            chartY = y; 
            doc.text("Evolução da Arrecadação por Período", xStart + canvasWidth + margin + canvasWidth/2, chartY, { align: 'center' });
            chartY += linhaAltura + 2;
            doc.addImage(imgData, 'PNG', xStart + canvasWidth + margin, chartY, canvasWidth, canvasHeight);
        }
        y += canvasHeight + linhaAltura + 10; 

        // --- 6. Salvar PDF ---
        doc.putTotalPages(); 
        doc.save(`relatorio_campanha_${campanha.replace(/\s+/g,'_').toLowerCase()}.pdf`);

    } catch (error) {
        console.error("Erro ao gerar PDF:", error);
        alert("Ocorreu um erro ao gerar o relatório. Verifique se os gráficos estão carregados corretamente ");
    }
});