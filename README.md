# 🌟 Painel de Controle Yggdrasil

Um painel de controle moderno para servidores Ragnarok Online, desenvolvido em Laravel.

## 🚀 Instalação Rápida

### Pré-requisitos
- PHP 8.1 ou superior
- MySQL 5.7 ou superior
- Composer
- Node.js (opcional, para compilar assets)

### Configuração Automática

1. **Clone o repositório:**
   ```bash
   git clone <url-do-repositorio> painel-yggdrasil
   cd painel-yggdrasil
   ```

2. **Execute o script de configuração:**
   ```bash
   chmod +x setup.sh
   ./setup.sh
   ```

3. **Configure o banco de dados no arquivo `.env`:**
   ```env
   DB_HOST=127.0.0.1
   DB_DATABASE=ragnarok
   DB_USERNAME=seu_usuario
   DB_PASSWORD=sua_senha
   ```

4. **Execute as migrações do Laravel:**
   ```bash
   php artisan migrate
   ```

5. **Configure o banco de dados Ragnarok (IMPORTANTE):**
   ```bash
   mysql -u root -p < database/ragnarok_setup.sql
   ```
   > ⚠️ **Este passo é obrigatório!** Remove a constraint UNIQUE do `web_auth_token` para permitir o sistema de múltiplas contas por usuário.

6. **Inicie o servidor:**
   ```bash
   chmod +x start.sh
   ./start.sh
   ```

## 🔧 Configuração Manual

Se preferir configurar manualmente:

```bash
# Instalar dependências
composer install

# Copiar arquivo de ambiente
cp .env.example .env

# Gerar chave da aplicação
php artisan key:generate

# Configurar permissões
chmod -R 775 storage bootstrap/cache

# Compilar assets (opcional)
npm install && npm run build

# Executar migrações
php artisan migrate

# Configurar banco Ragnarok (OBRIGATÓRIO para multi-contas)
mysql -u root -p < database/ragnarok_setup.sql

# Iniciar servidor
php artisan serve --host=0.0.0.0 --port=8000
```

## 🎮 Sistema de Multi-Contas

Este painel suporta **múltiplas contas de jogo por usuário web**:

- Um usuário web pode criar várias contas de jogo (personagens)
- Cada conta tem seus próprios Cash Points e inventário
- Sistema de roleta permite selecionar qual conta usar
- Transferências de pontos são vinculadas ao usuário web

**Banco de Dados:**
- `mysql.users` → Usuários do painel web
- `ragnarok.login` → Contas de jogo (linkadas via `web_auth_token`)
- Relação: 1 usuário web : N contas de jogo

## 🌐 Acesso

- **Local:** http://localhost:8000
- **WSL2:** O script detecta automaticamente o IP do WSL2
- **Rede:** http://[seu-ip]:8000

## 📱 Ambientes Suportados

- ✅ Linux nativo
- ✅ WSL2 (Windows)
- ✅ macOS
- ✅ Docker
- ✅ Servidores VPS/Cloud

## 🔒 Produção

Para usar em produção:

1. Configure um servidor web (Apache/Nginx)
2. Use um banco de dados dedicado
3. Configure cache e sessões
4. Ative HTTPS
5. Configure backups

## 🐛 Solução de Problemas

### Erro de Permissões
```bash
chmod -R 775 storage bootstrap/cache
```

### Erro de Chave da Aplicação
```bash
php artisan key:generate
```

### Erro de Banco de Dados
Verifique as configurações no arquivo `.env`

## 📞 Suporte

- 📧 Email: [seu-email]
- 🐛 Issues: [link-para-issues]
- 📖 Wiki: [link-para-wiki]

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
