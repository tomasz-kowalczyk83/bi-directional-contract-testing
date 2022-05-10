PACTICIPANT := "tom-demo-bi-directional-provider"
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
		make publish_contract; \
	fi;

create_branch_version:
	PACTICIPANT=${PACTICIPANT} PACT_BROKER_BASE_URL=${PACT_BROKER_BASE_URL} PACT_BROKER_TOKEN=${PACT_BROKER_TOKEN} ./scripts/create_branch_version.sh

create_version_tag:	
	PACTICIPANT=${PACTICIPANT} PACT_BROKER_BASE_URL=${PACT_BROKER_BASE_URL} PACT_BROKER_TOKEN=${PACT_BROKER_TOKEN} ./scripts/create_version_tag.sh

publish_contract: create_branch_version create_version_tag
	
	PACTICIPANT=${PACTICIPANT} PACT_BROKER_BASE_URL=${PACT_BROKER_BASE_URL} PACT_BROKER_TOKEN=${PACT_BROKER_TOKEN} ./scripts/publish.sh true -x

publish_failure: create_branch_version create_version_tag
	@echo "\n========== STAGE: publish contract + results (failure) ==========\n"
	PACTICIPANT=${PACTICIPANT} PACT_BROKER_BASE_URL=${PACT_BROKER_BASE_URL} PACT_BROKER_TOKEN=${PACT_BROKER_TOKEN} ./scripts/publish.sh false

fake_ci:
	GIT_COMMIT=`git rev-parse --short HEAD` \
	GIT_BRANCH=`git rev-parse --abbrev-ref HEAD` \
	make ci; 

test:
	php artisan test