# 📘 Tutorial Git para o Grupo

Este guia explica, de forma simples e didática, como cada integrante deve clonar o repositório, criar sua própria branch, enviar alterações e evitar conflitos no **GitHub**.  

---

## 🚀 1. Clonando o repositório
Esse comando baixa o projeto do GitHub para o seu computador.

```bash
git clone https://github.com/usuario/repositorio.git
cd repositorio
```

---

## 👤 2. Configurando usuário (se ainda não estiver configurado)
Essas configurações servem para identificar quem está fazendo as alterações no projeto. Faça isso apenas uma vez por computador.

```bash
git config --global user.name "Seu Nome"
git config --global user.email "seuemail@exemplo.com"
```

---

## 🌱 3. Criando uma branch para trabalhar
**Nunca trabalhe direto na `main`!**  
Cada integrante deve criar sua própria branch, assim evitamos conflitos.

```bash
git checkout -b minha-branch
# Exemplo
git checkout -b pedro-home-page
```

> Dica: use um nome descritivo para a branch (ex: `login-page`, `ajuste-header`, `feature-contato`).  

---

## 🔄 4. Atualizando o projeto antes de trabalhar
Antes de começar a programar, atualize seu repositório local para garantir que você está com a versão mais recente:

```bash
git checkout main
git pull origin main
git checkout minha-branch
```

---

## 💾 5. Fazendo alterações e salvando (commit)
Depois de editar arquivos, siga esses passos:  

1. Adicione as alterações:  
```bash
git add .
```

2. Salve as alterações com uma mensagem clara:  
```bash
git commit -m "Descrição do que foi feito"
# Exemplo
git commit -m "Adicionei a página de login"
```

> Boas mensagens de commit ajudam a equipe a entender rapidamente o que foi alterado.

---

## ☁️ 6. Enviando para o GitHub
Agora envie sua branch para o repositório remoto:

```bash
git push origin minha-branch
```

---

## 🔀 7. Criando um Pull Request (PR)
O Pull Request é a forma de pedir para que suas alterações sejam juntadas à `main`.  

No GitHub:  
1. Vá até o repositório.  
2. Clique em **"Compare & pull request"**.  
3. Escreva o que foi feito (explique brevemente a alteração).  
4. Envie o PR.  

Depois disso, outro integrante (ou o responsável) vai revisar e aprovar.  

---

## ⚔️ 8. Evitando conflitos
- Sempre atualize a `main` antes de começar (`git pull origin main`).  
- Nunca altere diretamente a `main`.  
- Trabalhe apenas na sua branch.  
- Se houver conflito, o Git vai mostrar linhas com marcações (`<<<<<<<`, `=======`, `>>>>>>>`).  
  - Edite manualmente os arquivos.  
  - Depois confirme as alterações:  

```bash
git add .
git commit -m "Resolvido conflito"
git push origin minha-branch
```

---

## ⚡ Dica extra
- Faça **commits pequenos e frequentes**. É melhor salvar várias pequenas mudanças do que uma gigante.  
- Sempre escreva **mensagens claras** nos commits.  
- Leia o que os outros integrantes alteraram antes de começar algo novo.  

---

✅ Seguindo este guia, a equipe conseguirá trabalhar de forma organizada, colaborativa e sem dores de cabeça com conflitos no Git!
