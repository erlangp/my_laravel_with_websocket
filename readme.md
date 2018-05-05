### How to run

1. Open new terminal then execute command below to create sqlite database file

    ```bash
    touch database/database.sqlite
    ```
2. Change value of `DB_DATABASE` in `.env` file with absolute path of sqlite database file. Then execute command below to generate Product table (as sample)

    ```bash
    php artisan migrate
    ```
3. Execute command below to start Web server

    ```bash
    php artisan serve
    ```
4. Open new terminal and execute command below to start WebSocket server

    ```bash
    php artisan websocket:start
    ```
5. Open `http://127.0.0.1:8000/ws-client` in browser
6. Minimize the browser
6. Send request to `http://127.0.0.1:8000/api/products` via GET method in postman
7. Send request to `http://127.0.0.1:8000/api/products?name=One&price=1000` via POST method in postman
8. Open/restore browser to see product info that just created

EOF
