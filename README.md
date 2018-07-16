# laravel-sso

## install

`composer require cblink/laravel-sso:dev-master -vvv`

## configure

### publish config.php and migration

`php artisan vendor:publish --provider="Cblink\Sso\SsoServiceProvider"`

### migrate:

`php artisan migrate`

this command will create a table name sso to authorize.

### create sso route:

`php artisan sso:route`

### also you can create sso through command

`php artisan sso:create`

### add to your auth.php:
```php
'guards' => [
    'sso' => [
        'driver' => 'session',
        'provider' => 'sso',
    ],
],
'providers' => [
    'sso' => [
        'driver' => 'sso',
        'table' => 'sso',
    ],
],
```

## usage

```php
// sso client system
Route::get('sso', function () {
    $client = new \GuzzleHttp\Client();
    
    $response = $client->get('http://yourdomain/sso/getTicket?'.http_build_query([
        'app_id' => 'your_app_id',
        'secret' => 'your_secret',
    ]));

    $result = json_decode((string)$response->getBody(), true);

    if ($ticket = $result['ticket'] ?? null) {
        return redirect('http://yourdomain/sso/login?ticket='.$ticket);
    }
});
``` 
