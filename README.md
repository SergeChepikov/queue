# Запуск

Для запуска необходимо вызвать

```bash
composer install
docker-compose up 
```

Дождаться полного запуска `rabbitmq`

Далее зайти в docker контейнер `queue_php_1`

```bash
docker exec -it queue_php_1 /bin/bash
```

Далее в нём запустить consumer-сы и запустить эмулятор WebAPI
```bash
php start.php
php emulator.php
```

Для остановки consumer-сов
```bash
bash stop.sh
```

Результат работы в ***logs/result.log***

Кол-во параллельных процессов в зависимости от возможностей машины устанавливается в `.env` параметр `PARALLEL_PROCESSES_COUNT`
 
