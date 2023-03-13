# WAHelp-test



## Сборка

Собираем docker контейнеры\
`docker-compose build`

Создаем volume\
`docker volume create  wahelp-postgres-data`

Запускаем сервис
`docker-compose up`

Создаем БД\
`CREATE DATABASE wahelp`

Выполняем миграцию в файле `backend/migrations/1678685328.sql`

## Методы API:
**POST**: `localhost/userlist/upload`\
**Параметры:**
- file - загружаемый файл\

**Пример запроса на JS:**

~~~javascript
var axios = require('axios');
var FormData = require('form-data');
var fs = require('fs');
var data = new FormData();
data.append('file', fs.createReadStream('/Users/nikolajlapshin/Projects/WAHelp-test/doc/upload.csv'));
data.append('test', 'test');

var config = {
method: 'post',
maxBodyLength: Infinity,
url: 'localhost/userlist/upload',
headers: {
...data.getHeaders()
},
data : data
};

axios(config)
.then(function (response) {
console.log(JSON.stringify(response.data));
})
.catch(function (error) {
console.log(error);
});
~~~


## Запуск демо-воркеров

### Импортер csv-файлов, загруженных через API
`docker exec wahelp-backend php /var/www/public/usersImport.php`

### Создаватель очереди на отправку
`docker exec wahelp-backend php /var/www/public/createSendQueue.php`

### Отправитель рассылки
`docker exec wahelp-backend php /var/www/public/sendMessages.php`
