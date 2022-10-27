<?php namespace professionalweb\sendbox\Interfaces\Services;

interface Protocol
{
    public const METHOD_TOKEN_UPDATE = '/oauth/access_token';

    /**
     * Call API method
     *
     * @param string $method
     * @param array  $params
     * @param string $httpMethod
     *
     * @return Response
     */
    public function call(string $method, array $params = [], string $httpMethod = 'post'): Response;
}