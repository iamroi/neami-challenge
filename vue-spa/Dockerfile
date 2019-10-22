#
# Frontend
#
FROM node:8.12

WORKDIR /var/www/

COPY . /var/www/

RUN yarn install

EXPOSE 8080
CMD ["yarn", "serve"]
