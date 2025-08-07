#!/bin/bash

# Get the directory where the script is located
SCRIPT_DIR=$(dirname "$0")

# Export UID and GID of the current user
export UID=$(id -u)
export GID=$(id -g)

# Docker start
source "${SCRIPT_DIR}"/docker-start.sh

# Run tests
docker exec -t symsonte_wip_behat_extension_php \
    bash -c "php -dxdebug.mode=coverage vendor/bin/phpunit \
    --coverage-html tests/coverage tests"

# Open coverage report
google-chrome tests/coverage/index.html
