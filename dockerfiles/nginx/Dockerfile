FROM nginx:alpine

ARG EXPOSE_PORT_ARG
ENV EXPOSE_PORT_ENV=$EXPOSE_PORT_ARG
ARG WORKDIR

RUN mkdir -p /srv/www
RUN mkdir -p /srv/www/public

RUN rm -rf /etc/nginx/conf.d/default.conf

#COPY ./map/                 /etc/nginx/ext/map/
#COPY ./conf.d/              /etc/nginx/conf.d/
COPY ./sites-enabled/       /etc/nginx/ext/sites-enabled/
COPY ./nginx.conf           /etc/nginx/


WORKDIR $WORKDIR

EXPOSE $EXPOSE_PORT_ENV
