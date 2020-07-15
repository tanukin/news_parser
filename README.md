News parser
=====================================
Starting the environment
---
~~~
docker-compose up -d
~~~
Actions
---
Composer init
~~~
docker-compose run --rm cli composer install
~~~
Rename .env.example to .env
~~~
docker-compose run --rm cli cp .env.example .env
~~~
Generate application key
~~~
docker-compose run --rm cli php artisan key:generate
~~~
Create tables in the database
~~~
docker-compose run --rm cli php artisan migrate
~~~
Run news parser
~~~
docker-compose run --rm cli php artisan parser:rbc_news
~~~
Check the news on the site
~~~
http://localhost:8080/news
~~~
