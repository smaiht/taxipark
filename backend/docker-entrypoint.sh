#!/bin/sh
set -e

if [ ! -d "vendor" ] || [ -z "$(ls -A vendor)" ]; then
    composer install --no-interaction --no-progress
fi

exec "$@"