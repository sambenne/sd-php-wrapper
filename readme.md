To get this up and running you need to to use composer. 

Download composer

    curl -s http ://getcomposer.org/installer | php

Then install the dependencies
    
    php composer.phar install

To run the tests run the following command in the terminal
    
    vendor/phpunit/phpunit/phpunit test

To run functional tests you need to type in the following. This will only run the functional tests. You need to submit your own token for this to work though. Which you can do in the following path: `test/serverdensity/Tests/functional/TestCase`.

       vendor/phpunit/phpunit/phpunit --group functional test
