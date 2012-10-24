<?php

namespace EdpGithub\HttpClient;

interface HttpClientInterface
{
    /**
     * Send a GET request
     *
     * @param  string $path       Request path
     * @param  array  $parameters GET Parameters
     * @param  array  $headers    Reconfigure the request headers for this call only
     *
     * @return array              Data
     */
    public function get($path, array $parameters = array(), array $headers = array());

    /**
     * Send a POST request
     *
     * @param  string $path       Request path
     * @param  array  $parameters POST Parameters
     * @param  array  $headers    Reconfigure the request headers for this call only
     *
     * @return array              Data
     */
    public function post($path, array $parameters = array(), array $headers = array());

    /**
     * Send a PUT request
     *
     * @param  string $path       Request path
     * @param  array  $headers    Reconfigure the request headers for this call only
     *
     * @return array              Data
     */
    public function put($path, array $headers = array());

    /**
     * Send a DELETE request
     *
     * @param  string $path       Request path
     * @param  array  $parameters DELETE Parameters
     * @param  array  $headers    Reconfigure the request headers for this call only
     *
     * @return array              Data
     */
    public function delete($path, array $parameters = array(), array $headers = array());

    /**
     * Send a request to the server, receive a response,
     * decode the response and returns an associative array
     *
     * @param  string $path       Request API path
     * @param  array  $parameters Parameters
     * @param  string $httpMethod HTTP method to use
     * @param  array  $headers    Request headers
     *
     * @return array              Data
     */
    public function request($path, array $parameters = array(), $httpMethod = 'GET', array $headers = array());
}