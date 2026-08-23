# Blog ABADÁ São Paulo

Este projeto foi criado originalmente para o site da **ABADÁ-Capoeira São Paulo**. Como a estrutura pode atender outros projetos, ele fica disponível como uma alternativa de blog simples de instalar, administrar e personalizar.

O objetivo é oferecer o essencial para publicação de conteúdo sem depender de um CMS complexo: postagens, páginas institucionais, categorias, pesquisa, painel administrativo e personalização visual em uma aplicação PHP pequena e direta.

## Principais recursos

- Criação, edição e exclusão de postagens, páginas e categorias;
- editor de conteúdo rico com tabelas, imagens, vídeos, listas e citações;
- imagem de capa para postagens;
- página inicial responsiva com conteúdo em destaque;
- pesquisa e navegação por categorias;
- páginas institucionais com nome de menu e título independentes;
- painel administrativo protegido por autenticação e CSRF;
- personalização de nome, textos, cores, logo e imagem de fundo;
- controle da transparência da imagem de fundo;
- layout responsivo para desktop, tablet e celular;
- camada de serviços para separar as regras de negócio dos controllers;
- migrações, seeds e testes automatizados.

## Stack

- **PHP 8** — linguagem do backend;
- **CodeIgniter 4.1.9** — framework MVC;
- **MySQL ou MariaDB** — banco de dados;
- **Bootstrap 5** — componentes e base responsiva;
- **CKEditor 5** — edição de conteúdo rico;
- **HTML5, CSS3 e JavaScript** — interface pública e administrativa;
- **Composer** — gerenciamento das dependências PHP;
- **PHPUnit 9** — testes automatizados.

## Requisitos

- PHP 8.0 ou superior;
- extensões PHP `curl`, `intl`, `json`, `mbstring`, `mysqli` e `fileinfo`;
- MySQL 5.7+, MariaDB 10.3+ ou equivalente;
- Composer 2.

## Instalação

Clone o repositório e instale as dependências:

```bash
git clone https://github.com/fabiorvs/blog.git
cd blog
composer install
```

Crie o arquivo de ambiente:

```bash
cp env .env
```

Configure a URL e o banco de dados no `.env`:

```dotenv
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = blog
database.default.username = seu_usuario
database.default.password = sua_senha
database.default.DBDriver = MySQLi
database.default.port = 3306

PAGINATION = 10
```

Crie o banco informado no `.env` e execute as migrações:

```bash
php spark migrate
```

Crie o administrador de desenvolvimento:

```bash
php spark db:seed UsuarioSeeder
```

Opcionalmente, carregue as dez postagens demonstrativas e a página biográfica:

```bash
php spark db:seed BlogDemoSeeder
php spark db:seed MestreCamisaPageSeeder
```

Inicie o servidor de desenvolvimento:

```bash
php spark serve
```

O blog estará disponível em `http://localhost:8080` e o painel em `http://localhost:8080/admin`.

## Acesso inicial ao painel

O `UsuarioSeeder` cria uma conta destinada somente ao ambiente de desenvolvimento:

- usuário: `admin` ou `admin@admin`;
- senha: `admin123`.

Altere essas credenciais antes de publicar a aplicação.

## Personalização

Depois de acessar o painel, abra **Aparência** para configurar:

- identidade e textos do blog;
- cores principais;
- logo do cabeçalho;
- imagem de fundo da página inicial e seu nível de clareamento;
- postagem em destaque;
- categorias e bloco de newsletter;
- textos do rodapé.

Imagens enviadas pelo painel são armazenadas em `public/uploads`. Em produção, garanta permissão de escrita nessa pasta e configure o servidor web para usar `public` como diretório raiz.

## Testes

Execute a suíte com:

```bash
composer test
```

## Estrutura principal

```text
app/
├── Controllers/       Controllers públicos e administrativos
├── Database/          Migrações e seeds
├── Models/            Acesso às tabelas
├── Services/          Regras de autenticação, conteúdo, blog e tema
└── Views/             Templates do blog e do painel
public/
├── assets/            CSS, JavaScript e bibliotecas do frontend
└── uploads/           Imagens enviadas e conteúdo demonstrativo
tests/                 Testes automatizados
```

## Contribuindo

Contribuições são bem-vindas. Você pode abrir uma issue para relatar problemas ou enviar um pull request com correções e melhorias.

## Licença

Distribuído sob a licença [MIT](https://opensource.org/licenses/MIT).
