# auth-service
Repository for register &amp; auth users.
Also track events to external analytic service.
# how to start
- install 
[docker](https://docs.docker.com/install/)( 
[mac](https://docs.docker.com/docker-for-mac/),
[windows](https://docs.docker.com/docker-for-windows/)
) with 
[docker-compose](https://docs.docker.com/compose/install/)
- make sure that **80** port in **127.0.0.1** interface is free
- in the project dir run the next commands:
```bash
docker-compose up -d
open http://localhost
```

### Install vendors
```bash
composer install
```


### Rebuild images & recreate containers
```bash
docker-compose build --no-cache
docker-compose up -d --force-recreate
```

### To enable hot code refreshing in container follow instructions in ./docker-compose.yml


### Run test
```bash
./test
```

### RabbitMQ management
[http://localhost:15672/](http://localhost:15672/) **[guest:guest]**

### Run migration and fixtures
```bash
#You have to find ID_CONTAINER run command docker ps -a
docker-compose exec -it ID_CONTAINER_auth-service_auth-backend bin/console doctrine:migrations:migrate 
docker-compose exec -it ID_CONTAINER_auth-service_auth-backend bin/console doctrine:fixtures:load
```

### Run messenger consumer
```bash
#You have to find ID_CONTAINER run command docker ps -a
docker-compose exec -it ID_CONTAINER_auth-service_auth-backend bin/console messenger:consume-messages 
```

# how to work

### login
http://localhost/api/login

### track user activity
http://localhost/api/track/{slug}

Example: {slug} - click-red-button

### Find log
/public/tracker/tracker.json
