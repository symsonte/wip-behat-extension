#!/bin/bash

# Get the directory where the script is located
SCRIPT_DIR=$(dirname "$0")

# Export UID and GID of the current user
export UID=$(id -u)
export GID=$(id -g)

# Docker start
source "${SCRIPT_DIR}"/docker-start.sh

# Run tests
docker exec -it symsonte_wip_behat_extension_php bash -c "php vendor/bin/grumphp run"

# Docker stop
source "${SCRIPT_DIR}"/docker-stop.sh

