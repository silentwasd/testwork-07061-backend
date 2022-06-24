# Bulletin Board (Back-end)

### Installation

Make environment file (.env) with required fields:
```dotenv
SCOUT_DRIVER=meilisearch
MEILISEARCH_HOST=http://localhost:7700
MEILISEARCH_KEY=MASTER_KEY
```

Also, you need set up mysql database and put credentials
in environment file.

Next you need to run migrations:
```bash
php artisan migrate
```

And run docker image of Meilisearch:
```bash
docker run -it --rm \    
    -p 7700:7700 \
    -e MEILI_MASTER_KEY='MASTER_KEY' \
    -v $(pwd)/meili_data:/meili_data \
    getmeili/meilisearch:v0.27.2 \
    meilisearch --env="development"
```

After run Meilisearch you need to load and update
indexes:
```bash
php artisan scout:import "App\Models\BoardItem"
php artisan search:update-attributes
```

Then you can run local web server:
```bash
php artisan serve
```

### Test data

If you need to fill project with test data do this
(it spawn 10.000 items, you can change it in
/database/seeders/BoardItemSeeder.php):
```bash
php artisan db:seed --class="BoardItemSeeder"
```

Then do again load and update indexes:
```bash
php artisan scout:import "App\Models\BoardItem"
php artisan search:update-attributes
```
