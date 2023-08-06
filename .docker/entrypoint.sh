#!/bin/bash

# Set permissions for storage and bootstrap/cache directories
chmod -R 775 storage/ bootstrap/cache/

# Execute php-fpm as the entrypoint
php-fpm