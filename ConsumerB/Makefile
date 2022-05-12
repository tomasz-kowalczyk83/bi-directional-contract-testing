PACTICIPANT := "tom-demo-bi-directional-provider"
CONSUMER := "tom-demo-bi-directional-consumer-b"
GITHUB_REPO := "tomskii26/bi-directional-contract-testing/"
PACT_BROKER_BASE_URL := "https://tom-demo.pactflow.io"
PACT_BROKER_TOKEN := "4CRX44uUpSWn7jOhynx-nw"

## ====================
## CI tasks
## ====================

ci:
	@if make test; then \
		make publish_contract; \
	else \
		make publish_failure; \
	fi;

publish_contract: 
	PACTICIPANT=${PACTICIPANT} CONSUMER=${CONSUMER} PACT_BROKER_BASE_URL=${PACT_BROKER_BASE_URL} PACT_BROKER_TOKEN=${PACT_BROKER_TOKEN} ./scripts/publish.sh true

fake_ci:
	GIT_COMMIT=`foo` \
	GIT_BRANCH=`main` \
	make ci; 

test:
	./vendor/bin/phpunit --debug -c phpunit.xml	