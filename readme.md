To get this up and running you need to to use composer. 

Download composer

    curl -s http ://getcomposer.org/installer | php

Then install the dependencies
    
    php composer.phar install

To run the tests run the following command in the terminal
    
    vendor/phpunit/phpunit/phpunit test
