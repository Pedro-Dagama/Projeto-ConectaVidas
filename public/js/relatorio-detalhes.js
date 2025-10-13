
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
 