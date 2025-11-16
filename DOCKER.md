# Docker Setup Guide

This guide will help you set up and run the Heart Care application using Docker.

## Prerequisites

- Docker Desktop installed and running
- Docker Compose installed

## Quick Start

1. **Copy environment file (if needed):**
   ```bash
   cp .env.example .env
   ```

2. **Make sure .env file has SQLite settings:**
   ```env
   DB_CONNECTION=sqlite
   DB_DATABASE=/var/www/html/database/database.sqlite
   ```

3. **Create SQLite database file:**
   ```bash
   touch database/database.sqlite
   ```

4. **Build and start containers:**
   ```bash
   docker-compose up -d --build
   ```

5. **Install dependencies:**
   ```bash
   docker-compose exec app composer install
   ```

6. **Generate application key:**
   ```bash
   docker-compose exec app php artisan key:generate
   ```

7. **Set proper permissions:**
   ```bash
   docker-compose exec app chown -R www-data:www-data /var/www/html/storage
   docker-compose exec app chown -R www-data:www-data /var/www/html/bootstrap/cache
   docker-compose exec app chmod -R 775 /var/www/html/storage
   docker-compose exec app chmod -R 775 /var/www/html/bootstrap/cache
   ```

8. **Run migrations:**
   ```bash
   docker-compose exec app php artisan migrate
   ```

9. **Seed database (optional):**
   ```bash
   docker-compose exec app php artisan db:seed
   ```

## Accessing the Application

- **Web Application:** http://localhost:8000

## Useful Commands

### Start containers:
```bash
docker-compose up -d
```

### Stop containers:
```bash
docker-compose down
```

### View logs:
```bash
docker-compose logs -f
```

### View app logs only:
```bash
docker-compose logs -f app
```

### View nginx logs only:
```bash
docker-compose logs -f nginx
```

### Execute commands in app container:
```bash
docker-compose exec app php artisan [command]
```

### Access container shell:
```bash
docker-compose exec app bash
```

### Rebuild containers:
```bash
docker-compose up -d --build
```

### Clear cache:
```bash
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan view:clear
```

## Troubleshooting

### Permission Issues
If you encounter permission issues:
```bash
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chown -R www-data:www-data /var/www/html/bootstrap/cache
docker-compose exec app chmod -R 775 /var/www/html/storage
docker-compose exec app chmod -R 775 /var/www/html/bootstrap/cache
```

### Database File Issues
Make sure the SQLite database file exists and has proper permissions:
```bash
touch database/database.sqlite
docker-compose exec app chown www-data:www-data /var/www/html/database/database.sqlite
docker-compose exec app chmod 664 /var/www/html/database/database.sqlite
```

### Clear Everything and Start Fresh
```bash
docker-compose down
rm -f database/database.sqlite
touch database/database.sqlite
docker-compose up -d --build
docker-compose exec app php artisan migrate
```

