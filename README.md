# COINPEL — Sistema de Gerenciamento de Viagens de Turismo

## 1. Objetivo do Sistema
O **COINPEL** é uma plataforma administrativa web desenvolvida para a gestão e controle de operações de viagens de turismo. O sistema centraliza o gerenciamento de:
- **Viagens:** Cadastro de rotas, datas, horários, tarifas, controle de passageiros e status.
- **Veículos:** Gestão de frota, capacidades, ano, tipos de poltronas e comodidades (Wi-Fi, WC, tomadas, ar condicionado).
- **Motoristas:** Cadastro completo de informações, matrícula, contato e fotos.
- **Usuários Administradores:** Controle de acessos de administradores com bloqueio rápido e segurança.
- **API REST:** Listagem de viagens com dados estruturados para integração externa.

---

## 2. Stack Utilizada
- **Backend:** PHP / Laravel 12 (Modo Monolítico)
- **Banco de Dados:** PostgreSQL
- **Frontend & Templating:** Blade (Laravel) + Tailwind CSS v4 + Vanilla JS (Fetch API)
- **Compilação de Assets:** Vite

---

## 3. Requisitos de Ambiente
Antes de rodar o projeto, certifique-se de possuir instalado em sua máquina:
- **PHP:** >= 8.3
- **Composer** (Gerenciador de dependências PHP)
- **Node.js** & **npm** (Gerenciador de dependências Frontend)
- **PostgreSQL** (Banco de dados relacional)

---

## 4. Passo a Passo para Rodar Localmente

1. **Clone o repositório:**
   ```bash
   git clone <URL_DO_REPOSITORIO>
   cd coinpel-viagem-turismo
   ```

2. **Configure o arquivo de variáveis de ambiente:**
   Copie o arquivo `.env.example` para `.env`:
   ```bash
   cp .env.example .env
   ```

3. **Instale as dependências do PHP (Composer):**
   ```bash
   composer install
   ```

4. **Instale as dependências do Frontend (npm):**
   ```bash
   npm install
   ```

5. **Gere a chave criptográfica da aplicação:**
   ```bash
   php artisan key:generate
   ```

6. **Configure as credenciais do banco no seu `.env`:**
   Abra o arquivo `.env` e configure a conexão com o PostgreSQL:
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=coinpel
   DB_USERNAME=seu_usuario
   DB_PASSWORD=sua_senha
   ```

7. **Execute as migrações e popule o banco de dados (Seeds):**
   ```bash
   php artisan migrate:fresh --seed
   ```

8. **Compile os assets do frontend:**
   - Para ambiente de desenvolvimento (com Hot Reloading):
     ```bash
     npm run dev
     ```
   - Para ambiente de produção (compilado final):
     ```bash
     npm run build
     ```

9. **Inicie o servidor local do Laravel:**
   ```bash
   php artisan serve
   ```
   A aplicação estará rodando em: `http://127.0.0.1:8000`.

---

## 5. Credenciais de Teste (Usuário Administrador)
O seeder padrão (`AdminUserSeeder`) cria o seguinte usuário para acesso inicial:
- **E-mail:** `admin@coinpel.com`
- **Senha Inicial:** `Admin@123`

---

## 6. Fluxo de Primeiro Acesso e Autenticação

### Primeiro Acesso (Troca Obrigatória de Senha)
Para segurança de novas contas cadastradas com uma senha provisória, o sistema implementa um fluxo de troca de senha no primeiro acesso:
- O novo usuário é cadastrado com o campo `must_change_password` setado como `true`.
- Ao logar, o middleware `MustChangePassword` intercepta o acesso e redireciona o usuário para a tela `/change-password`.
- O usuário é impedido de navegar em outros módulos administrativos até que defina sua nova senha definitiva.

### Controle de Acesso e Segurança
- **Bloqueio de Usuários:** Usuários marcados como bloqueados (`is_blocked = true`) são impedidos de realizar a autenticação e não conseguem logar no painel.
- **Proteção contra Auto-Ações:** A interface do módulo de usuários impede que o administrador logado execute ações de autoexclusão ou autobloqueio, prevenindo bloqueios acidentais do próprio login de acesso.

---

## 7. Arquitetura do Sistema
O projeto utiliza a arquitetura monolítica clássica do Laravel (MVC):
- **Controllers & Requests:** Controlam os fluxos de dados e validações estruturadas das requisições (ex: `StoreTripRequest`, `VehicleController`).
- **Blade & Vanilla JS:** Os formulários de cadastro e edição de *Veículos*, *Motoristas* e *Usuários* são gerenciados em painéis deslizantes (Drawers) laterais interativos. O envio de dados e deleções é feito assincronamente via Fetch API com o token CSRF obrigatório injetado nas requisições.
- **API REST (Sprint 6):**
  - Rotas expostas em `routes/api.php` (mapeada no bootstrap de inicialização do Laravel).
  - Endpoint `GET /api/trips` retorna a lista de viagens com carregamento adiantado (*eager loading*) de `vehicle` e `driver` para evitar o problema de consulta N+1.
  - Uso de **Eloquent Resources** (`TripResource`, `VehicleResource`, `DriverResource`) para estruturar a resposta da API, ocultando e omitindo atributos confidenciais dos motoristas (CPF, RG, endereço) e dos veículos (chassi).

---

## 8. Execução de Testes Automatizados
O projeto possui cobertura de testes de feature para todos os módulos (Motoristas, Veículos, Usuários e APIs). Para rodá-los:
```bash
php artisan test
```
