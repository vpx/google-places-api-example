FROM nginx

RUN rm /etc/nginx/conf.d/default.conf

COPY nginx.conf /etc/nginx/
COPY vhost.conf /etc/nginx/sites-available/
COPY upstream.conf /etc/nginx/conf.d/

RUN ln -fs /etc/nginx/sites-available/vhost.conf /etc/nginx/conf.d/default.conf

CMD ["nginx", "-g",  "daemon off;"]
