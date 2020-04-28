# Register architektúry

### Development
**Set up** with
1. `composer install`
1. `npm install`
1. `php artisan backpack:install`
1. `php artisan storage:link`

**Set up** scout with
1. `php artisan elastic:create-index "App\Elasticsearch\BuildingsIndexConfigurator"`
1. `php artisan elastic:update-mapping "App\Models\Building"`
1. `php artisan scout:import "\App\Models\Building"`
1. `php artisan elastic:create-index "App\Elasticsearch\ArchitectsIndexConfigurator"`
1. `php artisan elastic:update-mapping "App\Models\Architect"`
1. `php artisan scout:import "\App\Models\Architect"`

**Start** with
1. `npm run dev`
1. `php artisan serve`

