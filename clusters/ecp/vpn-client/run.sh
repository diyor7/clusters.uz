#!/bin/bash

while true
do

cd /var/www/html/clusters/ecp/vpn-client
java -jar vpn-client.jar client-eimzo.conf

exit 0
 sleep 10
done
