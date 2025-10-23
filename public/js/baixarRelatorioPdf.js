
document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById('btnBaixarPDF');
    if (btn) {
        btn.addEventListener("click", () => {
            gerarRelatorioPDF(btn);
        });
    }
});


async function gerarRelatorioPDF(botao = null) {
    const PRIMARY_COLOR = [255, 108, 2]; // Laranja/Destaque
    const TEXT_COLOR = [33, 37, 41];     // Preto escuro
    const MARGIN = 15;
    
    // Ativa loading no botão
    const originalText = botao ? botao.innerHTML : '';
    if (botao) {
        botao.innerHTML = `
            <span class="d-flex align-items-center justify-content-center">
                <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="height: 1.25rem; width: 1.25rem; margin-right: 0.5rem; animation: spin 1s linear infinite;">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Gerando PDF...
            </span>`;
        botao.disabled = true;
    }

    await new Promise(resolve => setTimeout(resolve, 150));

    try {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('p', 'mm', 'a4');
        const pageWidth = doc.internal.pageSize.width;
        const pageHeight = doc.internal.pageSize.height;
        let y = 25;

        // Função auxiliar para pegar texto simples
        const getElementText = (selector, fallback = 'N/A') => {
            const el = document.querySelector(selector);
            let text = el ? el.innerText.trim() : fallback;
            text = text.replace(/<i\b[^>]*>.*?<\/i>/g, '').trim();
            text = text.replace(/[\u2665\u2764]/g, '').trim();
            if (text.includes(':') && text.length > 5 && text.indexOf(':') < 30) {
                text = text.substring(text.indexOf(':') + 1).trim();
            }
            return text;
        };

        const getMetricValue = (cardIndex, fallback = 'R$ 0,00') => {
            const selector = `.row.g-4 .col-md-4:nth-child(${cardIndex}) h3.fw-bolder`;
            return getElementText(selector, fallback);
        };
        
        const getStatValue = (cardIndex, fallback = 'N/A') => {
            const selector = `.row.g-4 .col-md-3:nth-child(${cardIndex}) h3.fw-bolder`;
            return getElementText(selector, fallback);
        };

        // Dados principais
        const titulo = getElementText('.card-body h4.fw-bold', 'Relatório da Campanha');
        const descricao = getElementText('.card-body .border-start.border-primary.ps-3');
        const objetivo = getElementText('.card-body .text-info.fw-semibold');

        // --- DETALHES E IMPACTO ---
        const getDetailByLabel = (label) => {
            const el = Array.from(document.querySelectorAll('.card-body .row.g-3 .col-md-6')).find(col => {
                const strong = col.querySelector('strong');
                return strong && strong.innerText.trim().replace(':','') === label;
            });
            if (!el) return 'N/A';
            const p = el.querySelector('p.text-muted, p.text-info, p.fw-semibold');
            return p ? p.innerText.trim() : 'N/A';
        };

        const status = getDetailByLabel('Status da Campanha');
        const localizacao = getDetailByLabel('Localização');
        const periodo = getDetailByLabel('Período');
        const impactoEsperado = getDetailByLabel('Impacto Esperado');
        const impactoAlcancado = getDetailByLabel('Impacto Alcançado');

        // Métricas
        const totalArrecadado = getMetricValue(1);
        const totalDoacoes = getMetricValue(2, '0');
        const mediaDoacao = getMetricValue(3);
        const meta = getStatValue(1);
        const curtidas = getStatValue(3, '0');
        const areaAtuacao = getStatValue(4);

        // --- Cabeçalho ---
        doc.setFillColor(...PRIMARY_COLOR);
        doc.rect(0, 0, pageWidth, 25, 'F');
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(20);
        doc.setTextColor(255, 255, 255);
        doc.text(`Relatório da Campanha`, pageWidth / 2, 17, { align: 'center' });
        y = 35;

        doc.setFontSize(14);
        doc.setTextColor(...TEXT_COLOR);
        doc.text(`Título: ${titulo}`, MARGIN, y);
        y += 8;

        // --- Tabela de Métricas ---
        doc.setFontSize(12);
        doc.setFont("helvetica", "bold");
        doc.text(' Resumo de Desempenho', MARGIN, y);
        y += 2;

        const metricHeaders = ['Meta', 'Arrecadado', 'Total Doações', 'Média Doação', 'Curtidas', 'Área'];
        const metricValues = [meta, totalArrecadado, totalDoacoes, mediaDoacao, curtidas, areaAtuacao];
        
        doc.autoTable({
            startY: y + 4,
            head: [metricHeaders],
            body: [metricValues],
            theme: 'grid',
            headStyles: { fillColor: PRIMARY_COLOR, textColor: 255, fontStyle: 'bold', fontSize: 9 },
            styles: { fontSize: 9, cellPadding: 2, textColor: TEXT_COLOR, cellWidth: 'wrap', minCellHeight: 6 },
            margin: { top: y, left: MARGIN, right: MARGIN },
        });

        y = doc.autoTable.previous.finalY + 8;

        // --- Detalhes e Impacto ---
        doc.setFontSize(12);
        doc.setFont("helvetica", "bold");
        doc.text(' Detalhes e Impacto', MARGIN, y);
        y += 7;

        doc.setFont("helvetica", "normal");
        doc.setFontSize(10);
        
        const detailLines = [
            { label: 'Status', value: status, bold: true },
            { label: 'Localização', value: localizacao },
            { label: 'Período', value: periodo },
            { label: 'Objetivo', value: objetivo },
            { label: 'Impacto Esperado', value: impactoEsperado },
            { label: 'Impacto Alcançado', value: impactoAlcancado },
        ];
        
        detailLines.forEach(item => {
            doc.setFont("helvetica", item.bold ? "bold" : "normal");
            const text = `${item.label}: ${item.value}`;
            const splitText = doc.splitTextToSize(text, pageWidth - 2 * MARGIN);
            doc.text(splitText, MARGIN, y);
            y += (splitText.length * 4) + 2;
            if (y > pageHeight - 30) {
                doc.addPage();
                y = 20;
            }
        });

        // Descrição detalhada
        doc.setFont("helvetica", "bold");
        doc.text('Descrição Detalhada:', MARGIN, y);
        y += 5;
        doc.setFont("helvetica", "normal");
        const splitDescricao = doc.splitTextToSize(descricao, pageWidth - 2 * MARGIN);
        doc.text(splitDescricao, MARGIN, y);
        y += (splitDescricao.length * 4) + 5;

        // --- Tabela de Doadores ---
        if (y > pageHeight - 50) {
            doc.addPage();
            y = 20;
        }

        doc.setFont("helvetica", "bold");
        doc.setFontSize(12);
        doc.text(' Doadores Confirmados', MARGIN, y);
        y += 4;

        const rows = Array.from(document.querySelectorAll("#corpoTabela tr")).map(tr => {
            const tds = tr.querySelectorAll("td");
            const metodoEl = tds[3]?.querySelector('.badge');
            const metodoText = metodoEl ? metodoEl.innerText.trim() : (tds[3] ? tds[3].innerText.trim() : '');
            return [
                tds[0]?.innerText.trim() || '',
                tds[1]?.innerText.trim() || '',
                tds[2]?.innerText.trim() || '',
                metodoText
            ];
        }).filter(row => row[0]);

        if (rows.length === 0) {
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(10);
            doc.setTextColor(150);
            doc.text('Nenhum doador confirmado encontrado.', MARGIN, y + 5);
        } else {
            doc.autoTable({
                startY: y + 4,
                head: [["Nome", "Valor Doado", "Data", "Método"]],
                body: rows,
                theme: "striped",
                headStyles: { fillColor: PRIMARY_COLOR, textColor: 255, fontStyle: "bold" },
                styles: { fontSize: 9, cellPadding: 2, textColor: TEXT_COLOR },
                margin: { left: MARGIN, right: MARGIN },
                didDrawPage: function (data) {
                    const pageCount = doc.internal.getNumberOfPages();
                    doc.setFontSize(8);
                    doc.setTextColor(150);
                    doc.text(
                        `Página ${data.pageNumber} de ${pageCount}`,
                        pageWidth - MARGIN,
                        pageHeight - 5,
                        { align: 'right' }
                    );
                }
            });
        }

        // Salvar PDF
        const nomeArquivo = `relatorio_${titulo.replace(/[^a-z0-9]/gi, '_').toLowerCase()}.pdf`;
        doc.save(nomeArquivo);

    } catch (err) {
        console.error('Erro ao gerar PDF:', err);
        alert('Ocorreu um erro ao gerar o PDF. Verifique o console.');
    } finally {
        if (botao) {
            botao.innerHTML = originalText;
            botao.disabled = false;
        }
    }
}
