#!/bin/bash

# Get the directory where the script is located
SCRIPT_DIR=$(dirname "$0")

# Export UID and GID of the current user
export UID=$(id -u)
export GID=$(id -g)

# Create the network if it does not exist
docker network inspect development >/dev/null 2>&1 || \
  docker network create development

# Start all services
docker compose \
  -f "${SCRIPT_DIR}"/../docker/all.yml \
  -p symsonte_wip_behat_extension \
  up -d \
  --remove-orphans \
  --force-recreate