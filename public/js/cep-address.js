(function () {
    const cepInput = document.getElementById('cep');
    const enderecoInput = document.getElementById('endereco');
    const cidadeInput = document.getElementById('cidade');
    const estadoInput = document.getElementById('estado');

    // aria-live para feedback
    let liveRegion = document.getElementById('cepLiveRegion');
    if (!liveRegion) {
        liveRegion = document.createElement('div');
        liveRegion.id = 'cepLiveRegion';
        liveRegion.setAttribute('aria-live', 'polite');
        liveRegion.style.position = 'absolute';
        liveRegion.style.left = '-9999px';
        document.body.appendChild(liveRegion);
    }

    const onlyDigits = s => (s || '').replace(/\D/g, '');
    const formatCepMask = v => {
        const d = onlyDigits(v).slice(0, 8);
        return d.length > 5 ? d.slice(0, 5) + '-' + d.slice(5) : d;
    };

    function clearAddressFields() {
        if (enderecoInput) enderecoInput.value = '';
        if (cidadeInput) cidadeInput.value = '';
        if (estadoInput) estadoInput.value = '';
    }

    function debounce(fn, wait = 400) {
        let t;
        return function (...args) { clearTimeout(t); t = setTimeout(() => fn.apply(this, args), wait); };
    }

    async function fetchViaCep(cepDigits) {
        try {
            const res = await fetch(`https://viacep.com.br/ws/${cepDigits}/json/`, { cache: 'no-store' });
            if (!res.ok) return null;
            const data = await res.json();
            if (data.erro) return null;
            return data;
        } catch (e) {
            return null;
        }
    }

    const onCepDone = debounce(async function () {
        if (!cepInput) return;
        const digits = onlyDigits(cepInput.value);
        if (digits.length !== 8) {
            if (digits.length === 0) {
                clearAddressFields();
                liveRegion.textContent = '';
            }
            return;
        }

        if (enderecoInput) enderecoInput.value = 'Buscando...';
        if (cidadeInput) cidadeInput.value = '';
        if (estadoInput) estadoInput.value = '';
        liveRegion.textContent = 'Consultando CEP...';

        const data = await fetchViaCep(digits);
        if (!data) {
            clearAddressFields();
            liveRegion.textContent = 'CEP não encontrado. Preencha manualmente.';
            return;
        }

        const logradouro = data.logradouro || '';
        const bairro = data.bairro || '';
        const local = data.localidade || '';
        const uf = data.uf || '';

        let enderecoText = logradouro;
        if (!enderecoText && bairro) enderecoText = bairro;
        else if (logradouro && bairro) enderecoText = `${logradouro} - ${bairro}`;

        if (enderecoInput) enderecoInput.value = enderecoText;
        if (cidadeInput) cidadeInput.value = local;
        if (estadoInput) estadoInput.value = uf;

        liveRegion.textContent = 'Endereço preenchido. Verifique e adicione o número.';
    }, 450);

    if (cepInput) {
        cepInput.addEventListener('input', function () {
            const pos = cepInput.selectionStart;
            cepInput.value = formatCepMask(cepInput.value);
            try { cepInput.selectionStart = cepInput.selectionEnd = pos; } catch { }
        });
        cepInput.addEventListener('blur', onCepDone);
        cepInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') { e.preventDefault(); onCepDone(); }
        });
    }
})();
