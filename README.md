## Crossover - Application Proccess

### Project Evaluation Challenge

So, I was applying for a job offer for PHP Software Engineer on http://www.crossover.com/. The application process is very well made and the last step is to make a viable Project.


### Objective

Create a public news publishing portal where news can be published and disseminated.

### Tecnologies

* PHP 5.5
* MySQL 5.7.16
* Apache 2.4
* Yii 2.0.5
* Docker

I decided to make a viable Docker to contain the project and run freely on any computer. And is more fast to develop in this way ;)

### Deploying Process

* Checkout
* Make sure the port 80 is free, because the Docker Container run using the default Apache configuration.
* In a Terminal Window (Console, MS Prompt, etc), go to the root dir of the application
* Build Docker container: ```docker-compuse build```
* Run the project to see if everything is ok: ```docker-compose run```
* Open a new Terminal Window and build the project's dependencies: ```docker-compose run web bash -c 'php /app/composer.phar install'```
* In the same window, run the database migration task: ```docker-compose run web bash -c '/app/yii migrate/up --interactive=0'```
* If every step above is ok, access the site in a browser window: ```http://localhost```

### Disclaimer

I made this project to apply for a job vacancy. I published it in github in order to only be able to demonstrate my work as developer. I **do not** recommend anyone to do anything based on this work. The purpose here is learning.

I do not take responsibility for this type of action.

[![License: CC BY-NC-SA 4.0](https://img.shields.io/badge/License-CC%20BY--NC--SA%204.0-lightgrey.svg)](http://creativecommons.org/licenses/by-nc-sa/4.0/)
