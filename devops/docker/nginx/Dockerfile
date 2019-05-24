FROM nginx:stable as base

WORKDIR /var/www

FROM base as devel

COPY nginx.conf /etc/nginx/nginx.conf
COPY conf.d /etc/nginx/conf.d