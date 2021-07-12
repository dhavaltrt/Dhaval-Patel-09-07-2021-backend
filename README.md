# Guide

1. Create copy of ".env.example" file into ".env"

2. Than generate the application key using following command

```
php artisan key:generate
```

3. Change the DB variables as below

```
DB_HOST={Your host}
DB_PORT=3306
DB_DATABASE={Your db name}
DB_USERNAME={Your db username}
DB_PASSWORD={Your db password}
```

4. Give read & write permission to "storage" folder

5. Install dependencies

```
composer install
```

6. Install passport for API authentication

```
php artisan passport:install
```

7. Create migration

```
php artisan migrate
```

8. Seed database

```
php artisan db:seed
```

9. Run application locally

```
php artisan serve
```

# Sample Users

1. After generating migration and "db:seed", it'll create 4 sample users for your frontend application.

```
email:user_one@mailinator.com
password:123456

email:user_two@mailinator.com
password:123456

email:user_three@mailinator.com
password:123456

email:user_four@mailinator.com
password:123456
```

