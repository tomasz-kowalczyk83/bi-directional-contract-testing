PACTICIPANT := "tom-demo-bi-directional-provider"
GITHUB_REPO := "tomskii26/bi-directional-contract-testing/"
PACT_BROKER_BASE_URL := "https://tom-demo.pactflow.io"
PACT_BROKER_TOKEN := "4CRX44uUpSWn7jOhynx-nw"
PACT_CLI="docker run --rm -v ${PWD}:${PWD} -e PACT_BROKER_BASE_URL=${PACT_BROKER_BASE_URL} -e PACT_BROKER_TOKEN=${PACT_BROKER_TOKEN} pactfoundation/pact-cli:latest"

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
	
	PACTICIPANT=${PACTICIPANT} PACT_BROKER_BASE_URL=${PACT_BROKER_BASE_URL} PACT_BROKER_TOKEN=${PACT_BROKER_TOKEN} ./scripts/publish.sh true

publish_failure: create_branch_version create_version_tag
	@echo "\n========== STAGE: publish contract + results (failure) ==========\n"
	PACTICIPANT=${PACTICIPANT} PACT_BROKER_BASE_URL=${PACT_BROKER_BASE_URL} PACT_BROKER_TOKEN=${PACT_BROKER_TOKEN} ./scripts/publish.sh false

fake_ci:
	# GIT_COMMIT=`git rev-parse --short HEAD` \
	# GIT_BRANCH=`git rev-parse --abbrev-ref HEAD` \
	# make ci; 
	GIT_COMMIT=`git rev-parse --short HEAD` \
	GIT_BRANCH=`git rev-parse --abbrev-ref HEAD` \
	make deploy_target

deploy_target: can_i_deploy deploy	

test:
	php artisan test

## ===================
## Deploy tasks	
## ===================

deploy: can_i_deploy deploy_app

can_i_deploy:
	@docker run --rm \
	 -e PACT_BROKER_BASE_URL=${PACT_BROKER_BASE_URL} \
	 -e PACT_BROKER_TOKEN=${PACT_BROKER_TOKEN} \
	 pactfoundation/pact-cli:latest \
	 broker can-i-deploy \
	 --pacticipant ${PACTICIPANT} \
	 --version=${GIT_COMMIT} \
	 --to-environment production

deploy_app: record_deployment
	@echo "Deploying to prod"

record_deployment:
	@"${PACT_CLI}" broker record_deployment --pacticipant ${PACTICIPANT} --version ${GIT_COMMIT} --environment production