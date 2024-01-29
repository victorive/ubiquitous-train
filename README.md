## Ubiquitous Train

## Setup Instructions

### Without Docker:

> Requirements
> - PHP >= 8.1
> - Composer >= 2.4.3
> - MySQL >= 8.0
> - Node >= 19.0

**Step 1:** Clone the repository in your terminal using `https://github.com/victorive/ubiquitous-train.git`

**Step 2:** Navigate to the project’s directory using `cd ubiquitous-train`

**Step 3:** Run `composer install` to install the project’s backend dependencies.

**Step 4:** Run `npm install` to install the project’s frontend dependencies.

**Step 5:** Run `cp .env.example .env` to create the .env file for the project’s configuration.

**Step 6:** Run `php artisan key:generate` to set the application key.

**Step 7:** Create a database with the name **ubiquitous-train** or any name of your choice in your current database
server and configure the DB_DATABASE, DB_USERNAME and DB_PASSWORD credentials respectively, in the .env files located in
the project’s root folder. eg.

> DB_DATABASE={{your database name}}
>
> DB_USERNAME= {{your database username}}
>
> DB_PASSWORD= {{your database password}}
>
> 
Also, you can set your `CACHE_DRIVER` to `database` or `file` depending on your preference.

**Step 8:** Configure the JSON_FEED_URL variable in the .env file to https://www.pornhub.com/files/json_feed_pornstars.json.

**Step 9:** Run `php artisan migrate` to create your database tables.

**Step 10:** Run `php artisan fetch:json-feed` to fetch and populated the database from the json feed.

**Step 11:** Run `php artisan queue:work` to run the jobs for caching the images contained in each item in the feed. To assign 
multiple workers to the queue and process jobs concurrently, you can start multiple `queue:work` processes by opening up 
multiple tabs in your terminal and running the command.

**Step 12:** Run `npm run build` to compile your frontend assets.

**Step 13:** Run `php artisan serve` to serve your application, then use the link generated to access the app via any
browser of your choice.

### With Docker:

> Requirements
> - Install [Docker Desktop](https://www.docker.com/products/docker-desktop/) which (includes both Docker Engine and Docker Compose)

OR

> - Install [Docker Engine](https://docs.docker.com/engine/install/) and [Docker Compose](https://docs.docker.com/compose/install/) separately.

**Step 1:** Clone the repository in your terminal using `https://github.com/victorive/ubiquitous-train.git`

**Step 2:** Navigate to the project’s directory using `cd ubiquitous-train`

**Step 3:** Run `cp .env.example .env` to create the .env file for the project’s configuration.

**Step 4:** Docker uses the values provided via environment variables to build and create the database. 
Configure the `DB_DATABASE`, `DB_USERNAME` and `DB_PASSWORD` credentials in the `.env` files located in the 
project’s root folder For example:

> DB_HOST=db
> 
> DB_DATABASE=laravel
>
> DB_USERNAME=root
>
> DB_PASSWORD=password

Please ensure that the `DB_HOST` is set to `db`, which is the name of the container running the MySQL service.

Also, you can set your `CACHE_DRIVER` to `database` or `file` depending on your preference.

**Step 5:** Run `docker-compose up -d` to build and start your containers.

**Step 6:** Run `docker exec app php artisan key:generate` to set the application key.

**Step 7:** Configure the JSON_FEED_URL variable in the `.env` file to https://www.pornhub.com/files/json_feed_pornstars.json.

**Step 8:** Run `docker exec app php composer install` to install the project’s backend dependencies.

**Step 9:** Run `docker exec app npm install` to install the project’s frontend dependencies.

**Step 10:** Run `docker exec app php artisan migrate` to create your database tables.

**Step 11:** Run `docker exec app php artisan fetch:json-feed` to fetch and populated the database from the json feed.

**Step 12:** Run `docker exec app php artisan queue:work` to run the jobs for caching the images contained in each item in the feed. To assign
multiple workers to the queue and process jobs concurrently, you can start multiple `queue:work` processes by opening up
multiple tabs in your terminal and running the command.

**Step 13:** While waiting for the jobs to complete, you can run `docker exec app npm run build` to compile your frontend assets.

**Step 14:** Then visit `localhost:8888` to access the app via any browser of your choice.

NB: Since the JSON feed URL needs to be called once daily, scheduled commands are in place to handle this and can be 
setup by adding this entry to your server `* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1`
`
