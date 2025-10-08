 // small helper: preencher ano
    document.getElementById('year').textContent = new Date().getFullYear();

    // mobile menu toggle (simples)
    const menuBtn = document.getElementById('menuBtn');
    let menuOpen = false;
    menuBtn?.addEventListener('click', ()=>{
      const nav = document.querySelector('nav ul');
      if(!nav) return;
      menuOpen = !menuOpen;
      if(menuOpen){
        nav.style.display = 'flex';
        nav.style.position = 'absolute';
        nav.style.right = '1rem';
        nav.style.top = '64px';
        nav.style.background = 'white';
        nav.style.padding = '0.6rem';
        nav.style.flexDirection = 'column';
        nav.style.boxShadow = '0 8px 30px rgba(16,24,40,0.08)';
        nav.style.borderRadius = '10px';
      } else {
        nav.style.display = '';
        nav.style.position = '';
        nav.style.boxShadow = '';
      }
    });

    // mock data de ONGs (substitua por dados reais via PHP/SQL depois)
    const ngos = [
      {id:1, name:'Centro de Apoio Dra. Izumi', summary:'Apoio a crianças e famílias em situação de vulnerabilidade.', city:'São Paulo', img:'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=800&q=60'},
      {id:2, name:'Projeto Esperança', summary:'Reforço escolar e alimentação para crianças.', city:'Rio de Janeiro', img:'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=800&q=60'},
      {id:3, name:'Amigos do Abrigo', summary:'Acolhimento e cuidados para idosos.', city:'Belo Horizonte', img:'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=800&q=60'},
      {id:4, name:'Coração Verde', summary:'Apoio ambiental e educação comunitária.', city:'Curitiba', img:'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?w=800&q=60'},
      {id:5, name:'Mãos Solidárias', summary:'Campanhas de doação e voluntariado.', city:'Salvador', img:'https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?w=800&q=60'},
      {id:6, name:'Luz da Rua', summary:'Atuação em situação de rua e reinserção social.', city:'Fortaleza', img:'https://www.teresopolis.rj.gov.br/wp-content/uploads/2023/08/2-3.jpg'}
    ];

    function renderNGOs(list){
      const root = document.getElementById('ngosGrid');
      root.innerHTML = '';
      list.forEach(n=>{
        const card = document.createElement('div');
        card.className = 'card';
        card.innerHTML = `
          <img class="thumb" src="${n.img}" alt="${n.name}" />
          <div style="flex:1">
            <h3>${n.name}</h3>
            <p>${n.summary}</p>
            <div class="meta">
              <div style="font-size:0.92rem;color:var(--muted)">${n.city}</div>
            </div>
          </div>
          <button class="donate" onclick="alert('Simular doação para: ${n.name}')">Doar</button>
        `;
        root.appendChild(card);
      });
    }

    renderNGOs(ngos);

    function doSearch(){
      const q = document.getElementById('searchInput').value.trim().toLowerCase();
      if(!q){ renderNGOs(ngos); return; }
      const filtered = ngos.filter(n=> (n.name+n.summary+n.city).toLowerCase().includes(q) );
      renderNGOs(filtered);
    }