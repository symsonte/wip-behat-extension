#!/bin/bash

# Get the directory where the script is located
SCRIPT_DIR=$(dirname "$0")

# Export UID and GID of the current user
export UID=$(id -u)
export GID=$(id -g)

# Stop all services
docker compose \
  -f "${SCRIPT_DIR}"/../docker/all.yml \
  -p symsonte_wip_behat_extension \
  stop