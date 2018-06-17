# Build : docker build -t dfs_nginx .

FROM nginx:1.9.12
MAINTAINER Claude <claude@heaux-isp.com>

COPY custom /
RUN rm -rf /etc/nginx/conf.d/default.conf