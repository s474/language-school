To install - clone this repo or download zip, then from project root folder...
```
docker-compose up -d
```

Then (replace 'language_school_webserver_1' with name of webserver container if different)...
```
docker exec language_school_webserver_1 chmod a+w /var/www/html/logs
docker exec language_school_webserver_1 composer install
```

Then visit http://localhost:8080 and you should see 'Language School API' OpenAPI document.

To run tests...
```
docker exec language_school_webserver_1 composer test
```

To list logs...
```
docker exec language_school_webserver_1 ls -l logs
```

To view log e.g...
```
docker exec language_school_webserver_1 cat logs/error-2022-06-27.log
```

To use example API requests import Language_School.postman_collection into Postman.


Notes

This is an example application and is not intended for use in production. 

The API uses basic HTTP authentication, username: api-user, password: secret.
