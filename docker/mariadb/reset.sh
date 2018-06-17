#!/bin/bash

me=$0
mydir=`dirname $me`
host=$1
user=$2
passwd=$3

set -e

cd $mydir

p="-p$passwd"

if [ -z "$passwd" ]
then
  p=""
fi

mysql -h $host -u$user $p -e "CREATE SCHEMA IF NOT EXISTS gallery"
mysql -h $host -u$user $p gallery < ./schema.sql
mysql -h $host -u$user $p gallery < ./data.sql