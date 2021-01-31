# tạo môi trường chạy php bằng docker
# 1 Môi trường chạy php bao gồm php, nginx, mysql, phpmyadmin(option).
# Cấu trúc thư mục:
 * docker 
    * mysql
        * mysql.conf
            * mysql.conf
    * nginx
        * conf.d
            * nginx.conf
    + php 
        * Dockerfile
    * src
        * index.php
    * .docker-compose.yml
# 2 trong file docker-compose.yml sẽ gõ
```
# phiên bản
 version: '3.8'
#các service
 services:  
  # Nginx 
  nginx:
    image: nginx:1.17  # sử dụng từ image nginx phiên bản 1.17
    ports: # cổng sử dụng
      - 80:80  # các cổng sẽ ánh xạ với nhau ở máy tính với server
    volumes:
      - ./src:/var/www/php:ro    #thư mục sẽ ánh xạ với nhau  :ro là tùy chọn chỉ đọc
      - ./nginx/conf.d:/etc/nginx/conf.d:ro
    depends_on:  # khai báo php phải chạy trước khi nginx được chạy
      - php

  # PHP Service
  php:
#   sử dụng image php 7.4
    image: php:7.4-fpm 
    working_dir: /var/www/php  # thư mục làm việc 
    volumes:
      - ./src:/var/www/php # thư mục ở trong máy tính sẽ ánh xạ với thư mục trong docker 

```
# 2.1 nội dung trong file nginx.conf

```
server {
    listen 80 default_server;
    listen [::]:80 default_server;
    root   /var/www/php;
    index  index.php;

    location ~* \.php$ {
        fastcgi_pass   php:9000;
        include        fastcgi_params;
        fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param  SCRIPT_NAME     $fastcgi_script_name;
    }
}


```

# 2.3 nội dung trong file index.php 

```
<?php
phpinfo();

```

# => chạy câu lệnh : docker-compose up -d . gõ trên trình duyệ localhost sẽ hiện ra nội dung trong php

# 3. tích hợp mysql  và phpmyadmin
trong file .docker-compose.yml thêm tiếp 

```
  # MySQL Service
  mysql:
    image: mysql:8  # sử dụng msql phiên bản 8
    environment:  # khai báo các biến mổi trường
      MYSQL_ROOT_PASSWORD: root 
      MYSQL_DATABASE: test
    volumes:
      - ./mysql/my.cnf:/etc/mysql/conf.d/my.cnf:ro # khai báo config mình định sẵn trong file mysql.conf 
      - mysqldata:/var/lib/mysql
  # PhpMyAdmin Service
  phpmyadmin:
    image: phpmyadmin/phpmyadmin:5 # sử dụng phpmysadmin phiên bản 5
    ports:  # sử dụng cổng 8080
      - 8080:80  
    environment:  # biến môi trường
      PMA_HOST: mysql
    depends_on:  # mysql phải chạy trước php được chạy 
      - mysql

# Volumes
volumes:  
  mysqldata: # tạo nởi lưu trữ sql khi docker down
```

Suýt quyên chúng ta cần phải thêm sửa lại chỗ php service  thành 

```
  php:
#    build: ./php
    image: php:7.4-fpm
    working_dir: /var/www/php
    volumes:
      - ./src:/var/www/php
    depends_on: # thêm phải chạy mysql trước
      - mysql
```
# 4 vậy là xong rồi đó . chúng ta chạy lệnh docker-compose up -d và vào xem kết quả.
# chạy localhost:8080 để vào phpmyadmin userName là root còn mật khẩu là biến đã config trong docker-compose.yml

# 5 Ủa như vậy là xong rồi hả? Nếu bạn dùng msqli để kêt nối thì có thể dừng lại tại đây.
# sử dụng PDO để connect đến db trong code .
# chúng ta sẽ thay đổi một tý ở service php thành 

```
  php:
    build: ./php  # đường đãn đến dockerfile
    working_dir: /var/www/php
    volumes:
      - ./src:/var/www/php
    depends_on:
      - mysql
```

# và trong docker filde chúng ta thêm 
```

```