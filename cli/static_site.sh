#!/bin/bash

# Requires HTTrack to scrape the site and generate html files and assets.
# sudo apt install httrack

# Run ./static_site.sh from the command line.

# Define source and destination paths and domain name
httrackpath=/usr/bin/httrack
domain=lynkspace.local
proddomain=teklynk.com
temppath=/var/www/html/LynkSpace/cli/tmp
staticsitepath=/var/www/html/LynkSpace/htdocs/static

# Purge the temp/source directory
rm -r $temppath/*

sleep 3

# Run HTTrack
$httrackpath http://$domain -O $temppath -v -a -w --footer ""

sleep 3

# Find and remove HTTrack comment lines
find $temppath -type f -name '*.html' -exec sed -i 's#<!-- Added by HTTrack --><meta http-equiv=\"content-type\" content=\"text\/html;charset=UTF-8\" \/><!-- \/Added by HTTrack -->#''#g' {} +

sleep 3

# Find and replace local domain with production domain
find $temppath -type f -name "*.html" -exec sed -i 's#'"$domain"'#'"$proddomain"'#g' {} +

sleep 3

# Remove white space and line breaks - Minify
find $temppath -type f -name "*.html" -exec sed -i ':a;N;$!ba;s/>\s*</></g' {} +

sleep 3

# Purge the destination/static site directory
rm -r $staticsitepath/*

sleep 3

# Copy source/temp path to destination/static path
cp -r $temppath/$domain/* $staticsitepath/

# Simply ftp/copy the static files to your hosted server.
# This script can be useful for staging to production deployments.
# Staging environment could have DocumentRoot set to htdocs/ (with access to the admin panel for editing), while the Production environment only uses htdocs/static.
# This could also be used for production environments that do not have/allow PHP and MySQL, possibly for security concerns or cost.