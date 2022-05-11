"use strict"

const axios = require("axios")

// This is an example consumer that accesses the tom-demo-bi-directional-provider via HTTP
// TODO: replace these functions with your actual ones
 
// Gets multiple entries from the tom-demo-bi-directional-provider
exports.getMeDogs = endpoint => {
  const url = endpoint.url
  const port = endpoint.port

  return axios.request({
    method: "GET",
    baseURL: `${url}:${port}`,
    url: "/api/products",
    headers: { Accept: "application/json" },
  })
}

// Gets a single entry by ID from the tom-demo-bi-directional-provider
exports.getMeDog = endpoint => {
  const url = endpoint.url
  const port = endpoint.port

  return axios.request({
    method: "GET",
    baseURL: `${url}:${port}`,
    url: "/api/products/1",
    headers: { Accept: "application/json" },
  })
}
