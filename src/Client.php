<?php

namespace Wearesho\ReCaptcha\V3;

use GuzzleHttp;

/**
 * Class Client
 * @package Wearesho\ReCaptcha\V3
 */
class Client
{
    const REQUEST_URL = 'https://www.google.com/recaptcha/api/siteverify';

    /** @var ConfigInterface */
    protected $config;

    /** @var GuzzleHttp\ClientInterface */
    protected $client;

    public function __construct(ConfigInterface $config = null, GuzzleHttp\ClientInterface $client = null)
    {
        $this->config = $config ?? new EnvironmentConfig();
        $this->client = $client ?? new GuzzleHttp\Client();
    }

    /**
     * @param string $response
     * @param string|null $remoteIp
     * @return Response
     * @throws \Exception
     * @throws Exception with Response
     */
    public function verify(string $response, string $remoteIp = null): Response
    {
        $plainResponse = $this->client->request('post', static::REQUEST_URL, [
            GuzzleHttp\RequestOptions::FORM_PARAMS => [
                'secret' => $this->config->getSecret(),
                'response' => $response,
                'remoteip' => $remoteIp,
            ],
        ]);

        $jsonResponse = $this->parseJson((string)$plainResponse->getBody());

        return $this->createResponse($jsonResponse);
    }

    /**
     * @param array $jsonResponse
     * @return Response
     * @throws Exception
     */
    protected function createResponse(array $jsonResponse): Response
    {
        $dateTime = \DateTime::createFromFormat(\DateTime::ATOM, $jsonResponse['challenge_ts']);

        $response = new Response(
            $jsonResponse['success'],
            $jsonResponse['score'],
            $jsonResponse['action'],
            $dateTime,
            $jsonResponse['hostname'],
            $jsonResponse['error_codes'] ?? []
        );

        if (!$response->isSuccess()) {
            throw new Exception($response);
        }

        return $response;
    }

    /**
     * @param string $responseBody
     * @return array
     * @throws \Exception
     */
    protected function parseJson(string $responseBody): array
    {
        $jsonResponse = json_decode($responseBody, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception(
                'Error decoding Google response: ' . json_last_error_msg(),
                json_last_error()
            );
        }

        $requiredAttributes = [
            'success',
            'score',
            'action',
            'challenge_ts',
            'hostname',
        ];

        foreach ($requiredAttributes as $requiredAttribute) {
            if (!array_key_exists($requiredAttribute, $jsonResponse)) {
                throw new \Exception('Missing required response attribute: ' . $requiredAttribute);
            }
        }

        return $jsonResponse;
    }
}
