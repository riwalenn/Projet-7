# Projet-7 (BileMo)

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/a9796cbb1b5045a2a71674dcf3f2edc2)](https://app.codacy.com/gh/riwalenn/Projet-7?utm_source=github.com&utm_medium=referral&utm_content=riwalenn/Projet-7&utm_campaign=Badge_Grade_Settings)

EN - Projet n°7 created for OpenClassrooms and Back-end Developpeur Path

## Built With
*   [PHP 7.4.9]
*   [Symfony 5.2.3]

## Download and Installation
You need a web development environment like Wampserver (for windows), MAMP (for Mac) or LAMP (for linux).

*   Clone the project code : "https://github.com/riwalenn/Projet-7.git"
*   Go to the console and write "composer install" where you want to have the project
*   Open the .env file and change the database connection values on line 32 like "DATABASE_URL=mysql://root:@127.0.0.1:3306/oc_projets_n7?serverVersion=5.7.19" for me.
*   Return to the console and write "php bin/console doctrine:database:create"
*   "php bin/console doctrine:migrations:migrate"
*   To have some initial dataset : "php bin/console doctrine:fixtures:load"
*   Run the application with "php -S localhost:8000 -t public"

## Documentation

## Author
*   **Riwalenn Bas** - *Blog* - [Riwalenn Bas](https://www.riwalennbas.com)
*   **Riwalenn Bas** - *Repositories* - [Github](https://github.com/riwalenn?tab=repositories)