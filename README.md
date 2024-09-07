<h1>RESTful API для управления исполнителями и заказами</h1>

<h2>Инструкция к запуску</h2>

>Проект запускается на Linux или через WSL

<h3>Если вы запускаетесь в первый раз</h3>
<ol>
<li>

Переименовать `.env.example` в `.env` <b>(обязательно восстановить после этого файл example.env)</b> </li>
<li>

Сгенерировать папку vendor `composer install` </li>

<li> 

`sail up -d` - запуск сервера</li>

>Для того, чтобы выполнять запуск с помощью sail, необходимо в файл <b>.bashrc</b> (Находится в корневой дериктории пользователя) добавить `alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'`. Либо запускать через `./vendor/bin/sail`<br>

<li>

`sail npm install` установка npm пакетов для vite</li>

<li>

`sail npm run dev` - запуск vite</li>

<li>

Для того, чтобы выполнить миграции таблиц, необходимо запустить `sail artisan migrate` </li>

<li>

Для того, чтобы посеять данные в базу, необходимо запустить `sail artisan db:seed`</li>

<li>

Для того, чтобы сгенерировать клиент персонального доступа, необходимо запустить `sail artisan passport:client --personal` и ввести `Personal Access Token`</li>
<li>

сгенерировать новый ключ в файле .env (должна быть переменная `APP_KEY`)`sail artisan key:generate`
</li>

</ol>


<h3>Если вы запускаетесь НЕ в первый раз:</h3>

>`sail composer update` - если были установлены новые пакеты или плагины<br>

`sail up -d` - запуск сервера<br>
`sail npm run dev` - запуск vite<br>