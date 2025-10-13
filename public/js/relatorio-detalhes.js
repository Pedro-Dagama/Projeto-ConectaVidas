
      // Arrecadação
      new Chart(document.getElementById("graficoArrecadacao"), {
        type: "line",
        data: {
          labels: ["Maio 01", "Maio 10", "Maio 20", "Maio 30", "Junho 10", "Junho 20"],
          datasets: [
            {
              label: "Arrecadação (R$)",
              data: [200, 950, 2100, 3400, 4300, 4750],
              borderColor: "#0d6efd",
              backgroundColor: "rgba(13,110,253,0.1)",
              fill: true,
              tension: 0.4,
            },
          ],
        },
        options: { responsive: true, plugins: { legend: { display: false } } },
      });

      // Distribuição
      new Chart(document.getElementById("graficoDistribuicao"), {
        type: "doughnut",
        data: {
          labels: ["Cestas básicas", "Transporte", "Administração", "Outros"],
          datasets: [
            {
              data: [60, 20, 10, 10],
              backgroundColor: ["#198754", "#0d6efd", "#ffc107", "#6c757d"],
            },
          ],
        },
        options: { responsive: true, plugins: { legend: { position: "bottom" } } },
      });



      //filtro tabela Lista de doadores
      const corpoTabela = document.getElementById("corpoTabela");
        const filtroNome = document.getElementById("filtroNome");
        const filtroMetodo = document.getElementById("filtroMetodo");
        const paginacaoDoadores = document.getElementById("paginacaoDoadores");
        const linhasOriginais = Array.from(corpoTabela.querySelectorAll("tr"));
        const itensPorPagina = 3;
        let paginaAtual = 1;

        function atualizarTabela() {
          // Filtrar
          let filtroNomeValor = filtroNome.value.toLowerCase();
          let filtroMetodoValor = filtroMetodo.value;
          let linhasFiltradas = linhasOriginais.filter((tr) => {
            const nome = tr.children[0].textContent.toLowerCase();
            const metodo = tr.children[3].textContent;
            return (
              nome.includes(filtroNomeValor) &&
              (filtroMetodoValor === "" || metodo === filtroMetodoValor)
            );
          });

          // Paginação
          const totalPaginas = Math.ceil(
            linhasFiltradas.length / itensPorPagina
          );
          if (paginaAtual > totalPaginas) paginaAtual = 1;
          const inicio = (paginaAtual - 1) * itensPorPagina;
          const fim = inicio + itensPorPagina;
          const linhasPagina = linhasFiltradas.slice(inicio, fim);

          // Atualizar tabela
          corpoTabela.innerHTML = "";
          linhasPagina.forEach((tr) => corpoTabela.appendChild(tr));

          // Atualizar paginação
          paginacaoDoadores.innerHTML = "";
          for (let i = 1; i <= totalPaginas; i++) {
            const li = document.createElement("li");
            li.className = "page-item" + (i === paginaAtual ? " active" : "");
            const a = document.createElement("a");
            a.className = "page-link";
            a.href = "#";
            a.textContent = i;
            a.addEventListener("click", (e) => {
              e.preventDefault();
              paginaAtual = i;
              atualizarTabela();
            });
            li.appendChild(a);
            paginacaoDoadores.appendChild(li);
          }
        }

        filtroNome.addEventListener("input", () => {
          paginaAtual = 1;
          atualizarTabela();
        });
        filtroMetodo.addEventListener("change", () => {
          paginaAtual = 1;
          atualizarTabela();
        });

        atualizarTabela();