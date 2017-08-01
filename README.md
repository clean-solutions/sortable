# Package for handling column sorting

## Install

To install through Composer, by run the following command:

```
composer require clean-solutions/sortable
```

## Add Service Provider

Next add the following service provider in config/app.php.

```
'providers' => [
    CleanSolutions\Sortable\ServiceProvider::class,
],
```

Next publish the package's configuration file by running:

```
php artisan vendor:publish --provider="CleanSolutions\Sortable\ServiceProvider" --tag="sortable"
```

# Example

```
use CleanSolutions\Sortable\Traits\Sortable;

class CustomModule extends Model
{
	use Sortable;


	public $filable = [
	    'name'
    ];
	...
}
```

Controller is the same $data = CustomModule::sortable('name', 'asc')->paginate(15);

In view use {{ sortable('name', 'Name') }}