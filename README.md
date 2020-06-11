# Register architektúry

## Development

**Set up** with
1. `composer install`
1. `npm install`
1. `php artisan storage:link`

**Migrate or create** Elastic indexes with
1. `php artisan regarch:elastic:migrate`

**Start** with
1. `npm run dev`
1. `php artisan serve`

**Test** with
1. `php artisan test --env=testing`

### Developing on Windows
If you're developing on **Windows**, you will get an error at `composer install` stage about **pcntl** extension missing (required by Horizon). As of today, this extension is not available for Windows, so you'll have to do

```
composer install --ignore-platform-reqs
```
