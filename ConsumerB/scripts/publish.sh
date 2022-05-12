#!/bin/bash
SUCCESS=true
if [ "${1}" != "true" ]; then
  SUCCESS=false
fi

# Avoid breaking for users who don't have GNU base64 command
# https://github.com/pactflow/example-bi-directional-provider-restassured/pull/1
# keep base64 encoded content in one line 
# if echo foo | base64 -w 0; then
#     echo "encoding with base64 -w 0"echo "${GIT_COMMIT}"
#     PACT=$(cat ./output/${CONSUMER}-${PACTICIPANT}.json | base64 -w 0)
# else
#     echo "encoding with base64"
#     PACT=$(cat ./output/${CONSUMER}-${PACTICIPANT}.json | base64)
# fi
PACT=$(cat ./output/${CONSUMER}-${PACTICIPANT}.json)
echo "${GIT_COMMIT}"
REPORT=$(echo 'tested via PhpUnit' | base64)

echo "==> Uploading Consumer Pact to Pactflow"
curl \
  -v \
  -X PUT \
  -H "Authorization: Bearer ${PACT_BROKER_TOKEN}" \
  -H "Content-Type: application/json" \
  "${PACT_BROKER_BASE_URL}/pacts/provider/${PACTICIPANT}/consumer/${CONSUMER}/version/sddgdsd" \
  -d  @./output/${CONSUMER}-${PACTICIPANT}.json