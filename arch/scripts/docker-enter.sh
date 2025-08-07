#!/bin/bash

# Get the directory where the script is located
SCRIPT_DIR=$(dirname "$0")

# Export UID and GID of the current user
export UID=$(id -u)
export GID=$(id -g)

# Check if container is up
if [ ! "$(docker ps -q -f name=symsonte_wip_behat_extension_php)" ]; then
    # Start the container
    source "$SCRIPT_DIR"/docker-start.sh
fi

docker exec -it symsonte_wip_behat_extension_php bash