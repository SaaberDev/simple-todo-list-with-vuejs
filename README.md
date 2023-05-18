### Simple Todo List Application with Authentication

1. [Installation](https://github.com/SaaberDev/to-do-list-test#installation)
   1. [Clone the project](https://github.com/SaaberDev/to-do-list-test#clone-the-project)
   2. [Install Composer](https://github.com/SaaberDev/to-do-list-test#install-composer)
   3. [Install NPM](https://github.com/SaaberDev/to-do-list-test#install-npm)
   4. [Generate .env](https://github.com/SaaberDev/to-do-list-test#generate-env)
   5. [Generate Application Key](https://github.com/SaaberDev/to-do-list-test#generate-application-key)
   6. [Run migration](https://github.com/SaaberDev/to-do-list-test#run-migration)
   7. [Email Configuration](https://github.com/SaaberDev/to-do-list-test#email-configuration)
   8. [Serve the project](https://github.com/SaaberDev/to-do-list-test#serve-the-project)
   9. [Validation Instruction](https://github.com/SaaberDev/to-do-list-test#validation-instruction)
2. [Dummy Data - Optional](https://github.com/SaaberDev/to-do-list-test#dummy-data)
   1. [Seeder](https://github.com/SaaberDev/to-do-list-test#seeder-optional)
   2. [Default User](https://github.com/SaaberDev/to-do-list-test#default-user)

---

### Installation guide

---

#### Minimum Requirements

* PHP v8.1 / 8.2
* Node JS v18.16.0
* NPM v8.19.2
* Composer v2.5.5
* Apache / Ngnix
* MySQL

---

#### Installation

> IMPORTANT

#### Clone the project

Clone the project to your local web directory

```
git clone https://github.com/SaaberDev/to-do-list-test.git
```

#### Install Composer

```
composer install
```

#### Install NPM

Install npm module and build asset

```
npm install && npm run build
```

#### Generate .env

Copy .env.example as .env to your project directory

```
cp .env.example .env
```

#### Generate Application Key
```
php artisan key:generate
```

#### Run migration

**Run initial migration to migrate tables on database**
```
php artisan migrate
```

#### Email Configuration

`User registration` and `forgot password` functionality uses mail service. New user must be `verified` to login to the system. To achieve this you need to configure `.env` with a test mail service. I personally use [Mailtrap](https://mailtrap.io/) which is free. You need to signup or login using a gmail account and start using.

After login to mailtrap navigate to `Email Testing > Imboxes > Inbox` find `Integrations` select Laravel 7.x you will find your username and password.

```
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="todoapp@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

#### Serve the project

You can simply serve the project using this command.

```
php artisan serve
```

#### Validation Instruction

There are two special validation used in title and password field.

`title`: title may only contain letters, numbers, space and hyphen.
`password`: The password must contain at least 8 characters, one uppercase and one lowercase letter, one symbol and one number.

> ⚠️ **NOTE: Make sure your `APP_URL` is set to the correct url, for example if project is running on localhost domain `http://localhost:8000` or `http://127.0.0.1:8000` put that value in `.env` including port number and if you are running on a custom localhost domain `http://todo.test` put the whole url as well. It is important to put the `APP_URL` to avoid any issue with API request authentication.**
> If you are already running another project in the system with same port use this command to serve laravel in different port.
> 
>  ```
> php artisan serve --port=8001
> ```

---

#### Dummy Data

> OPTIONAL

#### Seeder (Optional)
After migrating you can use my dummy data to test app by running seeder which is completely optional. There are two seeder `UserSeeder` and `ItemSeeder`.

**Run single seeder**
```
php artisan db:seed --class=UserSeeder
```

```
php artisan db:seed --class=ItemSeeder
```

**If you want to run fresh database with seeder**

```
php artisan migrate:fresh --seed
```

#### Default User

After running the `UserSeeder` you will by default get a demo user with same credentials.

```
Email: demo@demo.com
Password: demo@demo.com
```
