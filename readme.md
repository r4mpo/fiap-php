# 📌 FIAP PHP Project

Projeto desenvolvido em **PHP 7.4.33**, utilizando boas práticas e estrutura organizada para facilitar manutenção e estudos. 🚀  

---

## ⚙️ Tecnologias
- **PHP 7.4.33**
- **MySQL**
- **Composer**

---

## 🛠️ Passo a passo para rodar o projeto

### 1. Clonar o repositório
```bash
git clone https://github.com/r4mpo/fiap-php.git
```

### 2. Configurar banco de dados
- Estrutura da base de dados disponível em:
  ```
  ./database/dump.sql
  ```
- Importe o arquivo `dump.sql` para sua base de dados (ex: **phpMyAdmin**).

### 3. Configurar conexão com o banco
- Copie o arquivo:
  ```bash
  ./config/database_exemple.php
  ```
- Renomeie para:
  ```bash
  database.php
  ```
- Edite com suas credenciais de banco de dados.

### 4. Instalar dependências
Execute no terminal dentro da pasta do projeto:
```bash
composer install
composer update
composer dump-autoload -o
```

### 5. Acessar o projeto
Suba o projeto em seu servidor local (ex: **XAMPP, Laragon ou similar**) e acesse pelo navegador.  

---

## 🔑 Credenciais de Admin
```
Email: admin@php.com
Senha: Teste#123
```

---

## 📂 Estrutura do Projeto
```
fiap-php/
│── config/            # Arquivos de configuração (ex: database.php)
│── database/          # Dump da base de dados
│── public/            # Pasta pública do servidor (index.php)
│── src/               # Código fonte (controllers, models, services)
│── vendor/            # Dependências do Composer
│── README.md          # Este arquivo
```

---

## 🤝 Contribuição
Contribuições são bem-vindas! Sinta-se à vontade para abrir uma **issue** ou enviar um **pull request**.  

---

## 📜 Licença
Este projeto está sob a licença **MIT**.