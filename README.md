<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

### Inicio
configurar el utf8mb4_general_ci en config/database.php
```sql
php artisan make:model Categoria --migration --controller
php artisan migrate
php artisan make:seeder CategoriasSeeder
```
se agrega en dbseeder
$this->call(CategoriasSeeder::class);
```sql
php artisan db:seed
```
en larevel 11 ya no esta el fichero api.php en routes, es necesario instalarlo manualmente.
```
php artisan install:api
```
Cuando ejecutes este comando artisan, se creará el archivo routes/api.php y se registrará en el bootstrap/app.php, y se instalará Laravel Sanctum. Solo necesitas agregar el trait Laravel\Sanctum\HasApiTokens al Modelo de Usuario.
```sql
<?php
 
namespace App\Models;
 
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
```
Configurar bootstrap/app.php y agreger si no lo esta.
```sql
api: __DIR__.'/../routes/api.php',
```
de esta forma
```sql
<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
    //
    })
    ->withExceptions(function (Exceptions $exceptions) {
    $exceptions->render(function (AuthenticationException $e, Request $request) {
    if ($request->is('api/*')) {
    return response()->json([
    'message' => $e->getMessage(),
    ], 401);
    }
    });
    })->create();
```
Esta es una forma de consultar los endpoints
```sql
Route::get('/categorias', [CategoriaController::class, 'index']);
```
La otra forma es esta, sin tener que utilizar verbos http ya que laravel lo hace
```sql
Route::apiResource('/categorias', CategoriaController::class);
```
Otra forma de entregar la informacin con laravel es
Crear Resource
```sql
public function index()
{
    return response()->json(['categorias' => Categoria::all()]); // primera forma
}
public function index()
{
    return new CategoriaCollection(Categoria::all()); // segunda forma
}   
php artisan make:resource CategoriaCollection
php artisan make:resource CategoriaResource
```
Categoria collection usualmente no se modifica

En resource se decide que columnas de van a retornar y que llaves se tienen

### Producto
```sql
php artisan make:model Producto --resource --api --migration
php artisan migrate
php artisan make:seeder ProductoSeeder
php artisan migrate:refresh --seed
php artisan make:resource ProductoCollection
php artisan make:resource ProductoResource
```

### Auth
```sql
php artisan make:controller AuthController
php artisan make:request RegistroRequest
php artisan make:request LoginRequest
```

### Problemas de cors
```sql
php artisan config:publish cors
'supports_credentials' => false, cambiar a true
composer require laravel/sanctum
    
Verifica que Sanctum esté instalado: Asegúrate de que hayas instalado Sanctum con Composer:

composer require laravel/sanctum
Usa el trait HasApiTokens: Asegúrate de que tu modelo User esté utilizando el trait HasApiTokens de Sanctum:

PHP

use Laravel\Sanctum\HasApiTokens;
 
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
// ...
}
En tu carpeta bootstrap/providers.php
Debes agregar el SanctumServiceProvider a la matriz de proveedores en tu archivo providers.php. Aquí te muestro cómo hacerlo:

PHP

<?php
 
return [
    App\Providers\AppServiceProvider::class,
    Laravel\Sanctum\SanctumServiceProvider::class, // Añade esta línea
];
        
        Con esto, el SanctumServiceProvider quedará registrado en tu aplicación Laravel 11.


Para configurar el guardia API para usar Sanctum, debes editar tu archivo config/auth.php. Dentro de este archivo, encontrarás una sección llamada guards. Debes asegurarte de que el guardia api esté configurado para usar el driver sanctum de la siguiente manera:

PHP

'guards' => [
    'api' => [
        'driver' => 'sanctum',
        'provider' => 'users',
        // ...
    ],
    // ...
],
```

### Pedidos
```sql
php artisan make:model Pedido --migration --api --resource
php artisan migrate
php artisan make:model PedidoProducto --migration
php artisan migrate
```

php artisan make:migration add_admin_column_to_users_table
php artisan make:resource PedidoCollection
