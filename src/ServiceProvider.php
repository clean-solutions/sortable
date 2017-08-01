<?php
namespace CleanSolutions\Sortable;

use CleanSolutions\Sortable\Helpers\Sortable;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider AS MasterServiceProvider;

class ServiceProvider extends MasterServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/sortable.php' => config_path('sortable.php')
        ], 'sortable');

        $this->registerSortable();

        Blade::directive('sortable', function ($expression) {
            return "<?php echo sortable_link({$expression}); ?>";
        });
    }

    public function register()
    {
        include __DIR__ . '/helpers.php';

        $this->app->alias('sortable', Sortable::class);

        $this->mergeConfigFrom(__DIR__ . '/Config/sortable.php', 'sortable');
    }
    
    private function registerSortable()
    {
        $this->app->singleton('sortable', function ($app) {
            return new Sortable();
        });
    }
}
