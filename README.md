<h2>
    Простой API для работы с пользователями
</h2>

<h3>Бэкенд:</h3>
<ul>
    <li><bold>PHP 8.0+ и Laravel 11</bold></li>
    <li><bold>Sanctum </bold> - для аутентификации через токены</li>
    <li><bold>TinyPNG</bold>   - для оптимизации изображений</li>
    <li><bold>Storage </bold> — для хранения загруженных файлов</li>
</ul>

<h3>Фронтенд :</h3>
<ul>
    <li><bold>jQuery</bold> — для работы с AJAX запросами и манипуляциями DOM</li>
    <li><bold>Tailwind CSS </bold> - стили</li>
</ul>

<h3>Слой сервисов:</h3>
<ul>
    <li><bold>UserService</bold>  - для обработки логики, связанной с пользователями</li>
    <li><bold>UserResource </bold>  - для форматированного вывода данных о пользователе</li>
    <li><bold>TinyPngService </bold> -  для централизованного доступа к API TinyPNG</li>
</ul>

<h3>API:</h3>
<h4>1. Получение токена (логин)</h4>
    <p>Метод: POST</p>
    <p>URL: /api/login</p>
    <p>Тело запроса:</p>

        {
            "email": "user@example.com",
            "password": "user123"
        }


<h4>2. Доступ к защищенному маршруту</h4>
    <p><bold>Метод:</bold> GET</p>
    <p><bold>URL:</bold> /api/protected</p>
    <p><bold>Заголовок:</bold></p>

        {
            Authorization: Bearer your_generated_token_here
        }

<h4>3. Получение списка пользователей</h4>
    <p>Метод: GET</p>
    <p>URL: /api/users</p>

<h4>4. Получение пользователя по ID</h4>
    <p>Метод: GET</p>
    <p>URL: /api/users/{id}</p>
    <p>Тело запроса:</p>

        {
            "email": "user@example.com",
            "password": "user123"
        }

        
<h4>5. Добавление нового пользователя</h4>
    <p>Метод: POST</p>
    <p>URL: /api/users</p>
    <p>Тело запроса:</p>

        {
            "email": "user@example.com",
            "password": "user123"
        }
    