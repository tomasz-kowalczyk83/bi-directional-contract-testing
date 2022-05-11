const { Publisher } = require("@pact-foundation/pact")
const path = require("path")
const childProcess = require("child_process")
require('dotenv').config()

const exec = command =>
  childProcess
    .execSync(command)
    .toString()
    .trim()

// Usually, you would just use the CI env vars, but to allow these examples to run from
// local development machines, we'll fall back to the git command when the env vars aren't set.
// TODO: Update these for your particular CI server
// const gitSha = process.env.TRAVIS_COMMIT || exec("git rev-parse HEAD || echo LOCAL_DEV")
// const branch = process.env.TRAVIS_BRANCH || exec("git rev-parse --abbrev-ref HEAD || echo LOCAL_DEV")
//generate fake gitsha as the consumer is not a standalone git repo so we 
const gitSha = Math.random().toString(27).replace(/^0./g, '').substr(0, 7);
const branch = 'main';
const opts = {
  pactFilesOrDirs: [path.resolve(process.cwd(), "pactss")],
  pactBroker: "https://tom-demo.pactflow.io",
  pactBrokerToken: process.env.PACTFLOW_TOKEN,
  consumerVersion: gitSha,
  tags: [branch],
}
console.log(process.env.PACTFLOW_TOKEN)
new Publisher(opts)
  .publishPacts()
  .then(() => {
    console.log("Pact contract publishing complete!")
    console.log("")
    console.log("Head over to https://tom-demo.pactflow.io to see your published contracts.")
  })
  .catch(e => {
    console.log("Pact contract publishing failed: ", e)
  })
