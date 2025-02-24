# Event Manager - Sistema de Gerenciamento de Eventos

## 📌 Sobre o Projeto
Este sistema permite o gerenciamento de eventos, incluindo a criação, edição, exclusão, inscrição de participantes e controle de capacidade. O projeto foi desenvolvido com **Laravel** e utiliza **Laravel Sanctum** para autenticação via API.

---

## 🚀 Tecnologias Utilizadas
- **PHP 8.2+**
- **Laravel**
- **MySQL**
- **Laravel Sanctum (Autenticação via Token)**
- **TailwindCSS (Frontend - opcional)**
- **PHPUnit (Testes)**

---

## ⚙️ Instalação
### 1️⃣ Clone o Repositório
```bash
git clone https://github.com/seu-usuario/event-manager.git
cd event-manager
```

### 2️⃣ Instale as Dependências
```bash
composer install
npm install
```

### 3️⃣ Configure o Arquivo `.env`
```bash
cp .env.example .env
```

### 4️⃣ Gere a Chave da Aplicação
```bash
php artisan key:generate
```

### 5️⃣ Configure o Banco de Dados
Crie um banco de dados no MySQL e edite o arquivo **.env** com as credenciais corretas:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_manager
DB_USERNAME=root
DB_PASSWORD=secret
```

### 6️⃣ Execute as Migrations e Seeders
```bash
php artisan migrate --seed
```
> 🔹 **Isso criará as tabelas e preencherá o banco com dados iniciais.**

### 7️⃣ Inicie o Servidor
```bash
php artisan serve
npm run dev
```
Acesse **http://localhost:8000** no navegador.

---

## 🔐 Autenticação via API (Sanctum)
O sistema utiliza **Laravel Sanctum** para autenticação via API.

### Obter Token de Autenticação
Faça uma requisição `POST /api/login` enviando **email** e **password**:
```json
{
    "email": "admin@example.com",
    "password": "password"
}
```
> 🔹 **A resposta será um token JWT para autenticação.**

Para acessar as rotas protegidas, adicione este token no header das requisições:
```bash
Authorization: Bearer SEU_TOKEN
```

---

## 🛠️ Testes
Para rodar os testes unitários e de feature com PHPUnit:
```bash
php artisan test
```
Para rodar testes específicos:
```bash
php artisan test --filter EventTest
```
> 🔹 **Os testes verificam CRUD de eventos, inscrições e validações.**

---

## 🔗 Rotas Disponíveis
### 📌 Rotas Web (Painel Administrativo)
| Método | Rota | Descrição |
|--------|------|-------------|
| GET | `/admin/dashboard` | Lista todos os eventos |
| GET | `/admin/events/create` | Formulário para criar evento |
| POST | `/admin/events` | Cria um novo evento |
| GET | `/admin/events/{id}` | Exibe detalhes de um evento |
| GET | `/admin/events/{id}/edit` | Formulário para editar evento |
| PUT | `/admin/events/{id}` | Atualiza um evento |
| DELETE | `/admin/events/{id}` | Exclui um evento |

### 📌 Rotas API
| Método | Rota | Descrição |
|--------|------|-------------|
| POST | `/api/login` | Autenticação e retorno do token |
| GET | `/api/events` | Lista todos os eventos |
| GET | `/api/events/{id}` | Exibe detalhes de um evento |
| POST | `/api/events` | Cria um evento (requer autenticação) |
| PUT | `/api/events/{id}` | Atualiza um evento (requer autenticação) |
| DELETE | `/api/events/{id}` | Exclui um evento (requer autenticação) |
| POST | `/api/events/{id}/participants` | Inscreve um usuário em um evento |
| DELETE | `/api/events/{id}/participants/{userId}` | Remove um participante de um evento |

---

## 📜 Licença
Este projeto está sob a licença MIT.

---

## 💡 Autor
**Desenvolvido por:** Joseph C. 🤓

Se precisar de mais informações, me avise! 🚀
