#!/bin/bash

domain=lynkspace.local
temppath=/var/www/html/LynkSpace/cli/tmp
staticsitepath=/var/www/html/LynkSpace/htdocs/static

/usr/bin/httrack http://$domain -O $temppath -v -a -w --footer ""

find $temppath -type f -name '*.html' -exec sed -i 's#<!-- Added by HTTrack --><meta http-equiv=\"content-type\" content=\"text\/html;charset=UTF-8\" \/><!-- \/Added by HTTrack -->#''#g' {} +

cp -r $temppath/$domain/* $staticsitepath/