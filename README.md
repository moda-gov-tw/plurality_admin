### 設置步驟

1. `npm install --global npm@latest`

2. `composer install`

3. `npm install`

4. `npm run dev`

5. `mv .env.example .env` 並設置DB 相關參數

6. `docker compose up`

7. `docker exec -it plurality_admin-admin.plurality.moda.gov.tw-1 /bin/bash` 或 `docker exec -it [CONTAINER ID] /bin/bash`

8. 重置、建立資料庫tables 及測試用登入資料: `php artisan migrate:reset --force && php artisan migrate --force && php artisan db:seed --force`

9. .env 內需加上azure ad 相關設定值 AZURE_CLIENT_ID / AZURE_CLIENT_SECRET / AZURE_TENANT_ID / AZURE_REDIRECT_URI
