ATM Machine

The following task was completed using the symfony framework to host the backend API and
VueJS to control the frontend application. 

To get started, follow these steps
1. Clone the project and `npm install` & `composer install`
2. Copy the environment configuration file `cp .env_example .env` and adjust the settings to match 
your system configuration (i.e define your database connection parameters)
3. Once completed,  create the schema name on your database server and run the migration file using Symfony (`php bin/console doctrine:migrations:migrate`)
4. This would create three tables on your schema namely `user`, `transaction` and `denomination`
5. Run the sql query below to insert a dummy user and required denomination
6. ```
   INSERT INTO denomination (denomination, value) VALUES ('1000', 1000), ('500', 500), ('100', 100), ('50', 50), ('20', 20), ('10', 10);
   INSERT INTO user (name, email, balance, timestamp) VALUES ('John Doe', 'johndoe@example.com',  100, now()), ('Jane Doe', 'janedoe@example.com', 200, now());

7. Start up your symfony server, depending on your preferred method i.e `symfony server:start` and `npm run dev` to generate the asset files
8. Once running, you can open the `homepage` or `http://localhost:8000/app/login`
9. You can add a new user and set up their startup balance by visiting the registration page
10. Enjoy!!!    
