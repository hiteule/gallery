# Build : docker build -t dfs_nginx .

FROM nginx:1.31.2
LABEL org.opencontainers.image.authors="Claude claude@heaux-isp.com"

COPY custom /
RUN rm -rf /etc/nginx/conf.d/default.conf