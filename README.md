# COINPEL — Sistema de Gerenciamento de Viagens de Turismo

O **COINPEL** é uma plataforma administrativa web desenvolvida para a gestão e controle de operações de viagens de turismo. O sistema centraliza o gerenciamento de frotas de veículos, escalas de motoristas, controle de viagens e clientes, além de fornecer uma API REST para integrações externas.

---

## 1. Objetivo do Sistema

O objetivo do COINPEL é otimizar a logística e os processos administrativos de operadoras de viagens de turismo por meio de:
- **Gestão de Viagens:** Agendamento de escalas, controle de tarifas, contagem de passageiros e gerenciamento de status (Agendada, Em andamento, Concluída, Cancelada).
- **Controle de Frota (Veículos):** Cadastro de prefixos, placas, modelos, ano de fabricação, capacidade e comodidades (como Wi-Fi, WC, tomadas, ar condicionado).
- **Gestão de Motoristas:** Banco de dados de motoristas com matrícula (registro), CNH/RG, CPF, foto de perfil e dados de contato.
- **Gestão de Clientes:** Módulo completo de cadastro de clientes com controle de dados pessoais, endereços e contato.
- **Painel de Estatísticas:** Indicadores de desempenho em tempo real, receita estimada e distribuição de viagens por status.
- **API de Integração:** Disponibilização dos dados de viagens estruturados para exibição em canais de vendas ou sistemas externos.

---

## 2. Stack Utilizada

| Tecnologia / Componente | Descrição / Especificação |
| :--- | :--- |
| **Linguagem Principal** | PHP 8.2+ |
| **Framework Web** | Laravel 12 (Estrutura Monolítica MVC) |
| **Banco de Dados** | PostgreSQL |
| **Estilização** | Tailwind CSS v4 |
| **Visual / Interface** | Blade Templates + Vanilla JS (com Fetch API para Drawers e fotos) |
| **Compilador de Assets** | Vite |
| **Suites de Teste** | PHPUnit (Laravel Test Suite) |

---

## 3. Pré-requisitos de Ambiente

Para executar e compilar a aplicação localmente, você precisa ter instalado:
- **PHP:** versão 8.2 ou superior.
- **Composer:** gerenciador de dependências PHP.
- **Node.js:** versão 18 ou superior.
- **npm:** gerenciador de pacotes do Node.js.
- **PostgreSQL:** servidor ativo com privilégios de criação de banco de dados.

---

## 4. Passo a Passo para Instalação e Execução Local

Siga as etapas abaixo para configurar o projeto em seu ambiente local:

### 1. Clonar o Repositório
```bash
git clone <URL_DO_REPOSITORIO>
cd coinpel-viagem-turismo
```

### 2. Instalar as Dependências do PHP
```bash
composer install
```

### 3. Instalar as Dependências do Frontend
```bash
npm install
```

### 4. Configurar as Variáveis de Ambiente
Copie o arquivo de exemplo para criar o seu `.env`:
```bash
cp .env.example .env
```

### 5. Gerar a Chave da Aplicação
```bash
php artisan key:generate
```

### 6. Configurar a Conexão com o Banco de Dados (PostgreSQL)
Abra o arquivo `.env` gerado e insira as suas credenciais locais do PostgreSQL:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=coinpel
DB_USERNAME=seu_usuario_postgres
DB_PASSWORD=sua_senha_postgres
```

### 7. Executar Migrations e Alimentar o Banco de Dados (Seeder)
Rode as migrações para criar as tabelas e popular o banco de dados com os dados iniciais de exemplo (veículos, motoristas, viagens e usuário administrador):
```bash
php artisan migrate:fresh --seed
```

### 8. Compilar os Assets do Frontend (Tailwind e Vite)
Para rodar em ambiente de desenvolvimento (com hot-reload de estilos):
```bash
npm run dev
```
Para gerar a build estática final de produção:
```bash
npm run build
```

### 9. Iniciar o Servidor do Laravel
```bash
php artisan serve
```
A aplicação estará acessível no endereço: **`http://127.0.0.1:8000`**.

---

## 5. Variáveis de Ambiente Importantes

As principais chaves de configuração no arquivo `.env` são:
- `APP_NAME`: Nome do sistema (padrão: `COINPEL`).
- `APP_ENV`: Define o ambiente de execução (`local` ou `production`).
- `APP_KEY`: Chave utilizada para criptografia e sessões (gerada no passo 5).
- `APP_URL`: URL base do sistema (ex: `http://127.0.0.1:8000`).
- `DB_CONNECTION`: Drive de conexão de banco (`pgsql`).
- `DB_DATABASE`: Nome da base de dados PostgreSQL.
- `DB_USERNAME` e `DB_PASSWORD`: Credenciais do banco.

---

## 6. Credenciais de Acesso (Administrador de Exemplo)

Após rodar o comando de seed, você poderá efetuar o login no painel administrativo com as seguintes credenciais:
- **E-mail:** `admin@coinpel.com`
- **Senha:** `NewPassword123`

---

## 7. Fluxo de Primeiro Acesso e Autenticação

Para garantir a política de segurança da plataforma:
1. **Redefinição Obrigatória de Senha:** Os novos usuários administradores cadastrados com senhas provisórias são marcados com `must_change_password = true`.
2. **Middleware Interceptador:** Ao realizar o primeiro login com sucesso, o usuário é bloqueado de navegar nos módulos e redirecionado para a tela `/change-password` para cadastrar sua nova senha definitiva.
3. **Bloqueio de Contas:** Administradores podem bloquear usuários (`is_blocked = true`) de forma rápida, impedindo que estes façam login no sistema. O painel previne que o usuário logado se autobloqueie ou se autoexclua acidentalmente.

---

## 8. Arquitetura do Sistema

O sistema é construído sobre a arquitetura tradicional **MVC (Model-View-Controller)** do Laravel:
- **Models:** Utilizam o ORM Eloquent com suporte a `SoftDeletes` em módulos cruciais (como Clientes, Motoristas, Viagens).
- **Controllers & Requests:** Encapsulam regras de negócio e validações robustas das requisições (ex: `StoreTripRequest`, `ClientController`).
- **Views & Vanilla JS (Drawers Laterais):** Os formulários de criação e edição do painel abrem de forma fluida em painéis deslizantes laterais (Drawers). A gravação de dados, fotos e exclusões é feita assincronamente via **Fetch API** enviando cabeçalhos CSRF e `X-HTTP-Method-Override: PATCH` onde necessário para atualizações dinâmicas na interface sem recarregar a página.

---

## 9. API REST de Integração

O COINPEL disponibiliza um endpoint público de integração de viagens protegido de dados confidenciais (por exemplo, RG/CPF dos motoristas e chassi dos veículos são omitidos).

### Endpoint: `GET /api/trips`
Retorna a lista estruturada das viagens agendadas com os respectivos veículos e motoristas vinculados.

#### Exemplo de Resposta JSON:
```json
{
  "data": [
    {
      "id": 1,
      "name": "Viagem de Estudos Pelotas - POA",
      "rule": "Faculdade",
      "date": "2026-07-20",
      "departure_time": "08:00:00",
      "origin": "Pelotas - RS",
      "destination": "Porto Alegre - RS",
      "ticket_price": 75.5,
      "passenger_count": 32,
      "status": "scheduled",
      "status_label": "Agendada",
      "vehicle": {
        "id": 2,
        "prefix": 4002,
        "plate": "ABC1234",
        "model": "Mercedes-Benz O500",
        "capacity": 44,
        "vehicle_type": "bus",
        "seat_type": "semi_bed",
        "year": 2022,
        "has_wifi": true,
        "has_wc": true,
        "has_outlet": true,
        "has_ac": true,
        "has_fridge": false,
        "has_heating": false,
        "has_video": true
      },
      "driver": {
        "id": 3,
        "name": "Adalberto Silva",
        "birth_date": "1985-05-15",
        "email": "adalberto@coinpel.com",
        "phone": "(53) 98765-4321",
        "registration": "DRV123",
        "profile_photo_path": "profiles/drv123.jpg",
        "profile_photo_url": "/storage/profiles/drv123.jpg"
      }
    }
  ]
}
```

---

## 10. Execução de Testes Automatizados

O projeto conta com cobertura de testes automatizados para validar a integridade de todas as rotas e regras de negócio:
```bash
php artisan test
```
