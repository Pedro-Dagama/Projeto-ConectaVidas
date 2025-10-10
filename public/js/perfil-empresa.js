
      document.addEventListener('DOMContentLoaded', function () {
        // Povoar modal com valores atuais
        function abrirModalComValores() {
          document.getElementById('formNomeFantasia').value = document.getElementById('inputNomeFantasia').value || '';
          document.getElementById('formRazao').value = document.getElementById('inputRazao').value || '';
          document.getElementById('formCNPJ').value = document.getElementById('inputCNPJ').value || '';
          document.getElementById('formEmail').value = document.getElementById('inputEmail').value || '';
          document.getElementById('formTelefone').value = document.getElementById('inputTelefone').value || '';
          document.getElementById('formEndereco').value = document.getElementById('inputEndereco').value || '';
          document.getElementById('formDescricao').value = document.getElementById('profileDesc').textContent || '';
          document.getElementById('formLogo').value = document.getElementById('profilePhoto').src || '';
        }

        // abrir modal e preencher quando for exibido
        const editarModalEl = document.getElementById('editarPerfilModal');
        editarModalEl.addEventListener('show.bs.modal', abrirModalComValores);

        const form = document.getElementById('editarPerfilForm');
        form.addEventListener('submit', function (evt) {
          evt.preventDefault();

          // pegar valores
          const nomeFantasia = document.getElementById('formNomeFantasia').value.trim();
          const razao = document.getElementById('formRazao').value.trim();
          const cnpj = document.getElementById('formCNPJ').value.trim();
          const email = document.getElementById('formEmail').value.trim();
          const telefone = document.getElementById('formTelefone').value.trim();
          const endereco = document.getElementById('formEndereco').value.trim();
          const descricao = document.getElementById('formDescricao').value.trim();
          const logo = document.getElementById('formLogo').value.trim();

          // atualizar elementos visíveis
          if (nomeFantasia) {
            document.getElementById('inputNomeFantasia').value = nomeFantasia;
            document.getElementById('profileName').textContent = razao || nomeFantasia;
            document.getElementById('navCompanyNameText').textContent = nomeFantasia;
            document.getElementById('profileHandle').textContent = '@' + (nomeFantasia.replace(/\s+/g, '').toLowerCase());
          }
          if (razao) document.getElementById('inputRazao').value = razao;
          if (cnpj) document.getElementById('inputCNPJ').value = cnpj;
          if (email) document.getElementById('inputEmail').value = email;
          if (telefone) document.getElementById('inputTelefone').value = telefone;
          if (endereco) document.getElementById('inputEndereco').value = endereco;
          if (descricao) document.getElementById('profileDesc').textContent = descricao;
          if (logo) document.getElementById('profilePhoto').src = logo;

          // fechar modal
          const modal = bootstrap.Modal.getInstance(editarModalEl);
          modal.hide();

          // opcional: mostrar feedback 
          const alert = document.createElement('div');
          alert.className = 'alert alert-success position-fixed bottom-0 end-0 m-3';
          alert.style.zIndex = 9999;
          alert.textContent = 'Perfil atualizado com sucesso.';
          document.body.appendChild(alert);
          setTimeout(() => alert.remove(), 3000);

          
        });
      });
