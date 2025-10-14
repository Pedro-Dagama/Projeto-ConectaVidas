
      // Filtrar e Paginar Tabela
      const corpoTabela = document.getElementById("corpoTabelaCampanhas");
      const filtroTitulo = document.getElementById("filtroTitulo");
      const filtroStatus = document.getElementById("filtroStatus");
      const paginacao = document.getElementById("paginacaoCampanhas");
      const linhasOriginais = Array.from(corpoTabela.querySelectorAll("tr"));
      const itensPorPagina = 2;
      let paginaAtual = 1;

      function atualizarTabela() {
        let titulo = filtroTitulo.value.toLowerCase();
        let status = filtroStatus.value;

        let linhasFiltradas = linhasOriginais.filter((tr) => {
          const t = tr.children[0].textContent.toLowerCase();
          const s = tr.children[4].textContent;
          return t.includes(titulo) && (status === "" || s.includes(status));
        });

        const totalPaginas = Math.ceil(linhasFiltradas.length / itensPorPagina);
        if (paginaAtual > totalPaginas) paginaAtual = 1;
        const inicio = (paginaAtual - 1) * itensPorPagina;
        const fim = inicio + itensPorPagina;
        const linhasPagina = linhasFiltradas.slice(inicio, fim);

        corpoTabela.innerHTML = "";
        linhasPagina.forEach((tr) => corpoTabela.appendChild(tr));

        paginacao.innerHTML = "";
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
          paginacao.appendChild(li);
        }
      }

      filtroTitulo.addEventListener("input", () => {
        paginaAtual = 1;
        atualizarTabela();
      });
      filtroStatus.addEventListener("change", () => {
        paginaAtual = 1;
        atualizarTabela();
      });
      atualizarTabela();
  