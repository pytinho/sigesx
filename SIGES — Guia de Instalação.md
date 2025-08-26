\# SIGES — Guia de Instalação, Execução e Git



Este README foi feito para o ambiente Windows (PowerShell/Git Bash)



✅ Pré‑requisitos



Git: \[https://git-scm.com/download/win](https://git-scm.com/download/win)

PHP 8.2+ (no `PATH`)

Composer: \[https://getcomposer.org/download/](https://getcomposer.org/download/)

Node.js LTS (18+) + npm: \[https://nodejs.org/en](https://nodejs.org/en)

MySQL 8.x (servidor rodando)

-------------------------------------------------------------------------------------------------------------------------------------------------------

> Dicas rápidas

> \* Verifique versões: `php -v`, `composer -V`, `node -v`, `npm -v`, `mysql --version`.

> \* Para Laravel: `php -m | findstr /I "bcmath ctype curl fileinfo mbstring openssl pdo\_mysql xml zip"` (as extensões devem aparecer sem WARNs).

-------------------------------------------------------------------------------------------------------------------------------------------------------



##### 📦 Clonar o projeto



**bash**

via HTTPS

git clone https://github.com/pytinho/sigesx.git

cd siges



OU via SSH

git clone git@github.com:pytinho/sigesx.git

cd siges

-------------------------------------------------------------------------------------------------------------------------------------------------------



##### 🔧 Configuração do ambiente



###### 1\. Instalar dependências PHP



**bash**

composer install



###### 2\. Instalar dependências JS

Se existir `package-lock.json`:



**bash**

npm ci



Senão:



**bash**

npm install



###### 3\. Arquivo `.env`



**bash**

cp .env.example .env



**PowerShell**

Copy-Item .env.example .env



------------------------------------------------------------------------------------------------------------

###### Ajuste as chaves principais:



env

APP\_NAME=siges

APP\_ENV=local

APP\_DEBUG=true

APP\_URL=http://localhost



\# Banco MySQL local

DB\_CONNECTION=mysql

DB\_HOST=127.0.0.1

DB\_PORT=3306

DB\_DATABASE=siges

DB\_USERNAME=root

DB\_PASSWORD=P4ntera2024!



\# Sessões/Cache/Queue (simples para dev)

SESSION\_DRIVER=database

CACHE\_STORE=database

QUEUE\_CONNECTION=database



\# Redis (opcional; se não usar, deixe como está)

REDIS\_CLIENT=phpredis

REDIS\_HOST=127.0.0.1

REDIS\_PASSWORD=null

REDIS\_PORT=6379



\# Mail (log em dev)

MAIL\_MAILER=log

MAIL\_FROM\_ADDRESS="hello@example.com"

MAIL\_FROM\_NAME="${APP\_NAME}"



\# Vite

VITE\_APP\_NAME="${APP\_NAME}"

------------------------------------------------------------------------------------------------------------



###### 4\. Gerar chave da aplicação



**bash**

php artisan key:generate





###### 5\. Criar base de dados (se ainda não existe)

###### 

No MySQL Workbench/client:



**sql**

CREATE DATABASE siges CHARACTER SET utf8mb4 COLLATE utf8mb4\_unicode\_ci;





###### 6\. Migrar (e criar tabelas de sessão/cache/queue se necessário)



**bash**

php artisan migrate

\# opcional: php artisan session:table \&\& php artisan migrate

\# opcional: php artisan queue:table   \&\& php artisan migrate

\# opcional: php artisan cache:table   \&\& php artisan migrate





###### 7\. Build de assets (produção)



**bash**

npm run build



Saída ficará em `public/build`.



###### 8\. Rodar em desenvolvimento

Em dois terminais:



**bash**

\# terminal 1

php artisan serve  # http://127.0.0.1:8000



\# terminal 2

npm run dev        # Vite com hot reload





###### 🧹 .gitignore sugerido (Laravel)



Crie/ajuste o `.gitignore` na raiz:



/vendor/

/node\_modules/

/public/build/

/storage/\*.key

/storage/app/\*

/storage/framework/cache/\*

/storage/framework/sessions/\*

/storage/framework/testing/\*

/storage/framework/views/\*

/storage/logs/\*

!.gitignore



.env

.env.\*.local

.phpunit.result.cache

Homestead.yaml

/.idea/

/.vscode/





###### > Nunca faça commit do `.env`. Use o `.env.example` para compartilhar configurações padrão.



###### -----------------------------------------------------------------------------------------------

##### **🌱 Roteiro diário de Git**



Sempre na pasta do projeto.



*~Antes de começar~*



**bash**

git pull origin main



*~Após codar~*



**bash**

git status

git add .

git commit -m "feat: descreve aqui a alteração"



*~Enviar pro remoto~*



**bash**

git push origin main





###### *Branches de feature (bom para organizar PRs)*



**bash**

git checkout -b feat/minha-feature

\# codar -> add/commit

git push -u origin feat/minha-feature





Mensagens úteis:



*`feat:` nova funcionalidade*

*`fix:` correção*

*`chore:` tarefas técnicas (config/build)*

*`docs:` documentação*



--------------------------------------------------------------------------------------------------------------------------

##### 🛠️ Comandos Laravel úteis



**bash**

*cache/config*

php artisan config:clear

php artisan cache:clear

php artisan route:clear

php artisan view:clear



*migrations/seeds*

php artisan migrate

php artisan migrate:fresh --seed



*storage links (se usar uploads públicos)*

php artisan storage:link

---------------------------------------------------------------------------------------------------------------------------

##### 🧩 Troubleshooting (Windows)



*npm bloqueado por Execution Policy*



**powershell**

Set-ExecutionPolicy -Scope CurrentUser -ExecutionPolicy RemoteSigned -Force



*Se necessário na sessão atual:*

Set-ExecutionPolicy -Scope Process -ExecutionPolicy Bypass





*`vite` não reconhecido*



1\. Rode `npm install` (ou `npm ci`).

2\. Tente `npx vite build`.

3\. Verifique se existe `vite.config.js` e se `vite` está em `devDependencies` do `package.json`.



*Erro de conexão MySQL (ECONNREFUSED/2002)*



1. Confirme host/porta/usuário/senha no `.env`.

2\. Verifique se o serviço MySQL está iniciado.

3\. Confirme se o DB `siges` existe.



*Extensões PHP faltando*

Edite `php.ini` e habilite: `bcmath`, `ctype`, `curl`, `fileinfo`, `mbstring`, `openssl`, `pdo\_mysql`, `xml`, `zip`.

Confirme com `php -m` se carregaram sem warnings.



\### Anotações do projeto



\* Ajuste este README conforme as necessidades do SIGES (módulos, seeds, usuários padrão, etc.).





