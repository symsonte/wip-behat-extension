help:
	@echo "start - Start docker"
	@echo "stop - Stop docker"
	@echo "enter - Enter the docker container"
	@echo "tests - Run the tests"
	@echo "coverage - Run the tests with coverage"

start:
	./arch/scripts/docker-start.sh

enter:
	./arch/scripts/docker-enter.sh

stop:
	./arch/scripts/docker-stop.sh

.PHONY: tests # This is needed because the folder `tests` exists
tests:
	./arch/scripts/run-tests.sh

coverage:
	./arch/scripts/run-coverage.sh

fix:
	./arch/scripts/run-fix.sh
