# Travel agency: SymfTravel

## How to install

Follow these steps:

1. Open a terminal

2. Install the project
~~~
cd place_to_install_the_project
git clone https://github.com/SmileyProd/travel-agency.git
composer install
~~~
If you receive any error when pressing the last command, just follow the instructions given by composer.

3. Configure and fill the database

* Configure the .env file to configure the connection to your database. If you don't know how to do that, follow this documentation:
https://symfony.com/doc/current/doctrine.html
* Type these lines of codes to configure your database and load the fixtures (which loads pre-set data in your database)
~~~
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load
~~~

## Context

This is a school project coded with Symfony 4. It aims to make Télécom SudParis's students learn the basics of a MVC framework by creating a draft of a real-looking travel agency website.

## Front office

The website has a landing page introducing the fake company SymfTravel. The navigation bar gives you acces to several tabs:
* **Accueil**: the homepage
* **Nos circuits**: the list of the circuits offered by the company
* **Nos programmes**: the list of the circuits's programs
* **Actualités**: the news filled by lorem paragraphs
* **Nous contacter**: a form to contact the firm with its coordonates
* **Shoppingcart icon**: the list of the circuits you liked
* **Se connecter**: the link to login for the administrators

A basic user can see all the circuits that have at least one valid program (the date of the travel is after the current date). He can "like" the circuits and retrieve the ones he liked in his shopping cart.

A circuit contains several steps which define the duration, the departure and arrival cities. A program has a price, a number of people, and a departure date.

Each circuit can have several programs but one program has only one circuit.

Each circuit can have several steps but one step has only one circuit.

## Back office

In the back office, the administrator has access to the crud of the circuits, steps, and programs which means he can add, edit, see and delete them.

Changing the steps of a circuit also updates the circuit (the duration of the circuit, the departure and arrival city).

The superadmin can also see and delete the collaborators's accounts. The different roles are defined just below.

## Roles
There are 3 user roles. It is not allowed to register on the website, even for the superadmin. Think of it to be a functionnality done by the database administrators

To understand the roles you can check the `/config/packages/security.yaml` file.

### IS_AUTHENTICATED_ANONYMOUSLY
The visitors of the website are not logged in. So they have access to the Front office described in a previous section.

### User
The user role doesn't give more permission than the previous one. 

### Admin
The administrators have access to the back office after they are logged in. So they can interact with the crud of the circuits, steps and programs.
He can also see all the circuits in the Front office, even those without programs.

### Superadmin
It is the most powerful role.
He has the same permissions as the administrators and access to the list of collaborators and the power to delete their accounts (but not create new ones).

## Fixtures
The fixtures are available in this folder: `/src/DataFixtures/`.

They contain several fake circuits and programs in order to test the different functionnalities described above. So for example, some circuits don't have valid programs.

Also they add different user roles (login | pwd):
* **Superadmin:** superadmin |superadmin
* **Admin:** admin | admin
* **User:** lambda | lambda 
