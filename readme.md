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
- A base de dados foi originalmente criada no **phpMyAdmin**. Para facilitar a importação e evitar possíveis incompatibilidades, também disponibilizei o **dump2.sql**, refatorado para seguir os padrões convencionais do **MySQL**.

### 3. Configurar conexão com o banco
- Copie o arquivo:
  ```bash
  ./config/database_example.php
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

## 🧪 Testes Unitários

Este projeto inclui **testes unitários** para a camada de serviços (ex: `StudentsService`).

Para rodar os testes:

1. Certifique-se de preencher corretamente as **constantes de configuração** no arquivo:

   ```
   test/StudentsServiceTest.php
   ```

   * `BASE_URL`
   * `DB_HOST`
   * `DB_USER`
   * `DB_PASS`
   * `DB_NAME`

2. Execute os testes com o PHPUnit:

```bash
./vendor/bin/phpunit ./test/
```

3. Você deverá ver algo como:

```
OK (6 tests, 6 assertions)
```

> ⚠️ É importante preencher as constantes corretamente para que os testes de conexão e criação de registros funcionem.

---

## 📂 Estrutura do Projeto
```
fiap-php/
│── config/            # Arquivos de configuração (ex: database.php)
│── database/          # Dump da base de dados
│── public/            # Pasta pública do servidor (js, css, imagens)
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
