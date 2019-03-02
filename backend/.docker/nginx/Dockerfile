FROM nginx:1.13.5

ARG PHP_SERVICE=laravel-php

COPY .docker/nginx/server.conf /etc/nginx/conf.d/default.conf

RUN sed -i 's/$PHP_SERVICE/'"${PHP_SERVICE}"'/g' /etc/nginx/conf.d/default.conf

EXPOSE 80 443

ENTRYPOINT ["nginx"]

CMD ["-g", "daemon off;"]