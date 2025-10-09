const metodoSelect = document.getElementById("metodoPagamento");
      const camposPagamento = document.getElementById("camposPagamento");

      metodoSelect.addEventListener("change", () => {
        const metodo = metodoSelect.value;
        camposPagamento.innerHTML = ""; // limpa campos anteriores

        if (metodo === "cartao") {
          camposPagamento.innerHTML = `
            <div class="mb-3">
              <label class="form-label fw-semibold">Número do Cartão</label>
              <input type="text" class="form-control" placeholder="0000 0000 0000 0000" maxlength="19" required />
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Validade</label>
                <input type="text" class="form-control" placeholder="MM/AA" maxlength="5" required />
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">CVV</label>
                <input type="text" class="form-control" placeholder="123" maxlength="3" required />
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">Nome no Cartão</label>
              <input type="text" class="form-control" placeholder="Como está no cartão" required />
            </div>
          `;
        } else if (metodo === "pix") {
          camposPagamento.innerHTML = `
            <div class="alert alert-success fw-semibold text-center">
              Escaneie o QR Code abaixo para concluir sua doação via PIX.
            </div>
            <div class="text-center">
              <img src="https://api.qrserver.com/v1/create-qr-code/?data=ChavePixExemplo@conectavidas.com&size=200x200" 
                   alt="QR Code PIX" class="img-fluid rounded shadow-sm" />
              <p class="mt-2 small text-muted">Chave PIX: <strong>doacoes@conectavidas.com</strong></p>
            </div>
          `;
        } else if (metodo === "boleto") {
          camposPagamento.innerHTML = `
            <div class="alert alert-info fw-semibold text-center">
              Um boleto será gerado após a confirmação da doação.
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">Nome Completo</label>
              <input type="text" class="form-control" placeholder="Seu nome" required />
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">CPF</label>
              <input type="text" class="form-control" placeholder="000.000.000-00" maxlength="14" required />
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">E-mail para envio do boleto</label>
              <input type="email" class="form-control" placeholder="seuemail@exemplo.com" required />
            </div>
          `;
        }
      });