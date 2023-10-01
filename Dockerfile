# Copyright 2016 The Kubernetes Authors.
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#     http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.

FROM php:8.0-apache-buster

#RUN apt update && apt install -y gip zip unzip
#COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
#RUN composer require predis/predis

RUN pear channel-discover pear.nrk.io
RUN pear install nrk/Predis

RUN sed -i 's#ErrorLog /proc/self/fd/2#ErrorLog "|$/bin/cat 1>\&2"#' /etc/apache2/apache2.conf
RUN sed -i 's#CustomLog /proc/self/fd/1 combined#CustomLog "|/bin/cat" combined#' /etc/apache2/apache2.conf

ADD Code/guestbook.php /var/www/html/guestbook.php
ADD Code/controllers.js /var/www/html/controllers.js
ADD Code/index.html /var/www/html/index.html