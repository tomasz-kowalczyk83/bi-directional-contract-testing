# Default to the read only token - the read/write token will be present on GitHub Actions.
# It's set as a secure environment variable in the .travis.yml file
PACTICIPANT := "tom-demo-bi-directional-consumer"
PACT_BROKER_BASE_URL := "https://tom-demo.pactflow.io/"
PACT_BROKER_TOKEN := "4CRX44uUpSWn7jOhynx-nw"
PACT_CLI="docker run --rm -v ${PWD}:${PWD} -e PACT_BROKER_BASE_URL=${PACT_BROKER_BASE_URL} -e PACT_BROKER_TOKEN=${PACT_BROKER_TOKEN} pactfoundation/pact-cli:latest"

# Only deploy from master
ifeq ($(GIT_BRANCH),main)
	DEPLOY_TARGET=deploy
else
	DEPLOY_TARGET=no_deploy
endif

## ====================
## CI tasks
## ====================

ci: test publish_pacts can_i_deploy $(DEPLOY_TARGET)

# Run the ci target from a developer machine with the environment variables
# set as if it was on GitHub Actions.
# Use this for quick feedback when playing around with your workflows.
fake_ci: .env
	CI=true \
	GIT_COMMIT=`git rev-parse --short HEAD`+`date +%s` \
	GIT_BRANCH=`git rev-parse --abbrev-ref HEAD` \
	make ci

publish_pacts: .env
	echo "publishing pacts"
	@"${PACT_CLI}" publish ${PWD}/pactss --consumer-app-version ${GIT_COMMIT} --tag ${GIT_BRANCH}

## =====================
## Build/test tasks
## =====================

test: .env
	npm run test

## =====================
## Deploy tasks
## =====================

deploy: deploy_app tag_as_prod record_deployment

no_deploy:
	@echo "Not deploying as not on master branch"

can_i_deploy: .env
	echo "can_i_deploy"
	@"${PACT_CLI}" broker can-i-deploy \
	  --pacticipant ${PACTICIPANT} \
	  --version ${GIT_COMMIT} \
	  --to-environment production \
	  --retry-while-unknown 0 \
	  --retry-interval 10

deploy_app:
	@echo "Deploying to prod"

tag_as_prod: .env
	@"${PACT_CLI}" broker create-version-tag --pacticipant ${PACTICIPANT} --version ${GIT_COMMIT} --tag prod

record_deployment: .env
	@"${PACT_CLI}" broker record-deployment --pacticipant ${PACTICIPANT} --version ${GIT_COMMIT} --environment production	