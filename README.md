The Developer Specification: <br />
PHP v.8.3.19 <br />
Laragon v5.0.0 <br />
Composer v.2.8.1 <br />
Node v.20.12.2 <br />
NPM v.10.8.2 <br />
Laravel v.11.38.2 <br />
Make sure you php.ini has enable curl, gd, intl, and zip extension <br />
<br />
Setup Development : <br />
clone <br />
setup .env (/storage/env-editor/file) <br />
import database (.sql) <br />
composer install <br />
npm install <br />
php artisan key:generate <br />
php artisan storage:link || ln -s [target_path] [link_name] (e.g. ln -s .../project/storage/app/public .../project/public/storage)<br />
php artisan optimize <br />
npm run build <br />
php artisan serve <br />
<br />
Setup Deployment : <br />
Setup your ssh in hosting and github
clone <br />
setup .env (/storage/env-editor/file) <br />
import database (.sql) <br />
composer install <br />
php artisan key:generate <br />
php artisan storage:link || ln -s [target_path] [link_name] (e.g. ln -s .../project/storage/app/public .../project/public/storage) [help: use pwd command in terminal to get relative path]<br />
php artisan optimize <br />
<br />
Notes : <br />
After setting the roles, generate the policies by running this command (php artisan shield:generate --all)
