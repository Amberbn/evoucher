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


## Contributors
- Mahendra R Sonday
- Awan Sefrianang
- Benny Sudaryono
- Desmon Latandos
