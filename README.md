#### Features

-   🛡 [Filament Shield](#plugins-used) for managing role access
-   👨🏻‍🦱 customizable profile page from [Filament Breezy](#plugins-used)
-   🌌 Managable media with [Filament Spatie Media](#plugins-used)
-   🖼 Theme settings for changing panel color
-   💌 Setting mail on the fly in Mail settings
-   🅻 Lang Generator
-   Etc..


#### Latest update
###### Version: v1.14.xx
- New UserResource UI form
- Add avatar to user add & edit
- New Theme settings UI
- Bugs fix & Improvement
- Forgot Password
- User Verification
- Etc

#### Getting Started

git pull the repo.
setup your .env


Setup your env

```bash
cd superduper-filament-starter-kit
cp .env.example .env
```

Run migration & seeder:

```bash
php artisan migrate
php artisan db:seed
```

<p align="center">or</p>

```bash
php artisan migrate:fresh --seed
```

Generate key:

```bash
php artisan key:generate
```

Run :

```bash
npm run dev
OR
npm run build
```

```bash
php artisan serve
```

Now you can access with `/admin` path, using:

```bash
email: stephelmaca@gmail.com
password: superadmin
```

*It's recommend to run below command as suggested in [Filament Documentation](https://filamentphp.com/docs/3.x/panels/installation#improving-filament-panel-performance) for improving panel perfomance.*

```bash
php artisan icons:cache
```