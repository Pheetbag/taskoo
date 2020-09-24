# taskoo

The backend and frontend are different apps, (for ease of development, a full integration would require more work). So startup are handle independently

## Backend startup

1. Get into the backend-src folder of the project

2. Use composer to run a `composer install` and get all the dependencies from the project. The system is running in php 7.4 so thats a requirement. 

3. After installation is done, run `php bin/console doctrine:migrations:migrate` to run all database migrations an populate the database. (the system expect the credentials
to be user=root and no password, if your actual database credentials are different please update them in the `DATABASE_URL` field of the .env file with the actual ones for your
database. 

4. Run `php symfony.phar serve` to startup the local server and leave it running. 

## Frontend startup

1. Get into the frontend-src folder of the project

2. Use `npm i` to install all the dependencies

3. Use angular CLI command `ng serve` to srtatup the local serve

## Final note

If the symfony server didnt start using `https://127.0.0.1:8000` (including https) then you will have to change the base url of the querys in the frontend-src, go to `main.ts:8`
and change the base url of axios to the actual url in where the backend server started. 
