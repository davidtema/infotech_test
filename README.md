Исполнитель: [Давыдов Артём](https://hh.ru/resume/1f3a6edbff03b7e1ac0039ed1f676c66373078)

Telegram: [@wolfandman](https://t.me/wolfandman)

Время выполнения ~8 часов.

## Инструкция по запуску в Docker

1. Build: `docker compose build --no-cache`
2. Run: `docker compose up --pull always -d --wait`
3. Determine the php container: `docker ps --format "{{.Names}}"`
4. Connect to php container: `docker exec -ti infotech-php-1 bash`
5. Install dependencies via composer: `composer install`
6. Open `http://localhost:8040`
7. Stop: `docker compose down --remove-orphans`

# Соответствие с заданием

1. [CRUD книг](http://localhost:8040/index.php?r=book-crud%2Findex). Права: пользователь.
2. [ТОП-10 авторов с наибольшим числом книг за год](http://localhost:8040/index.php?r=report%2Findex). Права: все.
3. Предусмотрена отправка SMS через систему Event > EventHandler > Queue::push. Код на данный момент ещё не реализован.

## Пользователь

[Вход](http://localhost:8040/index.php?r=site%2Flogin)

Логин: demo \
Пароль: demo

## Топ-10

Отображение и валидация по годам использует реальные данные по годам из книг.