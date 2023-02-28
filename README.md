# spa-comments-system
 example
 
### Установка и запуск приложения:
 
 Выполните клонирование проекта в выбранную директорию:
 
```shell
 git clone https://github.com/vlad-planet/spa-comments-system
```
 
 Перейдите в корневой каталог приложения с помощью терминала и запустите команду:
 
 ```shell
 docker-compose up -d
 ```
 
 вкорневом каталоге переименуйте файл .env.example в .env
 
 Найдите файл 'hosts' в Вашей ОС, в Windows он обычно расположен в директории:
 
```shell
 C:\Windows\system32\drivers\etc\
```

 и отредактируйте его от имени администратора, 
 добавив следующую строку в ваш файл 'hosts' и сохраните его:
 
```shell
 127.0.0.1 comments.spa phpmyadmin.spa
```

 После чего перейдите в http://phpmyadmin.spa и зайдите под пользователем и паролем 
 
 user: root password: root

 Найдите БД demo и создайте в ней таблицу comments  с помощью SQL команды,
 которую нужно запустить в терминале ввода SQL в phpmyadmin
 
```shell
 CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `email` varchar(255) NOT NULL,
  `title`  varchar(255) NOT NULL,
  `text` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

 После чего перейдите на сайт  http://comments.spa
 и оставьте комментарий:
 
 Правила ограничений на ввод можно настоить по усмотрению в соотвествующей Модели таблицы БД,
 которые обычно располагаются в каталоге \src\models
	
 Пример:
 
```shell
 $fields = [
    'firstname' => 'required | max:255',
    'lastname' => 'required | max: 255',
    'address' => 'required | min: 10, max:255',
    'zipcode' => 'between: 5,6',
    'username' => 'required | alphanumeric | between: 3,255 | unique: users,username',
    'email' => 'required | email | unique: users,email',
    'password' => 'required | secure',
    'password2' => 'required | same:password'
 ];
```

 При необходимости, чтобы изменить настройки подключения к бд, перейдите в
 \src\config\db.php
