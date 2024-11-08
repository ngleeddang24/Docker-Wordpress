FROM wordpress:latest

# Cài đặt Apache và các gói cần thiết
RUN apt-get update && apt-get install -y apache2

# Sao chép file cấu hình Apache vào container
COPY docker/config/apache2/000-default.conf /etc/apache2/sites-available/000-default.conf

# Sao chép file php.ini vào container
COPY docker/config/php/php.ini /usr/local/etc/php/php.ini

# Bật mod_rewrite của Apache
RUN a2enmod rewrite

# Cài đặt các phần mềm cần thiết (nếu có)
RUN apt-get install -y vim less

# Khởi động Apache
CMD ["apachectl", "-D", "FOREGROUND"]
