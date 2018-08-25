# E-Voucher Project

## Requirement for Local Development

- Docker Engine Service. If you are using download and install it [here](https://store.docker.com/editions/community/docker-ce-desktop-windows)
- MS SQL Server 2017 or above

## Quick Setup

- Clone this repository
- Execute: `docker-compose up -d`
- Install php composer dependencies: `docker-compose exec app composer install`
- Duplicate `.env.example` file as `.env`. And change the based on your local enviroment:
  - `DB_HOST=host.docker.internal` <-- leave it as `host.docker.internal` if your MS SQLServer is installed in your local machine. Give the IP if it's on another machine.
  - `DB_PORT=1433`
  - `DB_DATABASE=YourDatabaseName`
  - `DB_USERNAME=YourDatabaseUser`
  - `DB_PASSWORD=YourDatabasepassword`
- Generate artisan key: `docker-compose exec app php artisan key:generate`
- Setups is done and open your app at `http://localhost:8000`

## General Command

- Basic artisan command: `docker-compose exec app php artisan YourCommandHere`
- Migration: `docker-compose exec app php artisan migrate`
- Queue Listener: `docker-compose exec app php artisan queue:work`
- Run docker-compose exec app php artisan queue:listen --timeout=60

## Cron configuration

- Just edit the `crontab` file on the root of the project.
- If you change it while container already running, don't forget to restart the container: `docker-compose up -d`
- 1. Buka file crontab di project, pastikan End of Line Sequence nya LF bukan CRLF. Di vscode settingnya di status bar kanan bawah samping tulisan "UTF-8", rubah ke "LF". Terus save.
- 2. docker-compose build, tunggu sampe kelar.
- 3. Setelah kelar build, masuk ke bash docker: docker-compose exec app bash
- 4. Buka crontab file: crontab -e, save tanpa edit,
- 5. Restart cron dalam container: service cron restart
- 6. Pantau file storage/logs/laravel.log, untuk memastikan cronnya jalan. Akan ada log tiap menit.

## Job command

- docker-compose exec app php artisan queue:listen --timeout=60 `//voucher generate`
- docker-compose exec app php artisan queue:listen --queue=SendSMSJob --timeout=60 `//send sms for voucher generate`
  ## if you set env GENERATE_VOUCHERJOB_IS_SPLIT=false
        - you need only docker-compose exec app php artisan queue:listen --timeout=60
  ## else if you set env GENERATE_VOUCHERJOB_IS_SPLIT=true
        - you need run 2 terminal
        - docker-compose exec app php artisan queue:listen --timeout=60
        - docker-compose exec app php artisan queue:listen --queue=SendSMSJob --timeout=60

## Contributors

- Mahendra R Sonday
- Awan Sefrianang
- Benny Sudaryono
- Desmon Latandos
