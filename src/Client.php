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

    public function __construct(ConfigInterface $config, GuzzleHttp\ClientInterface $client)
    {
        $this->config = $config;
        $this->client = $client;
    }

    /**
     * @param string $response
     * @param string|null $remoteIp
     * @return Response
     * @throws Exception with Response
     * @throws GuzzleHttp\Exception\GuzzleException
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
     */
    protected function createResponse(array $jsonResponse): Response
    {
        $dateTime = array_key_exists('challenge_ts', $jsonResponse)
            ? \DateTime::createFromFormat(\DateTime::ATOM, $jsonResponse['challenge_ts'])
            : null;

        $response = new Response(
            $jsonResponse['score'],
            $jsonResponse['action'],
            $dateTime,
            $jsonResponse['hostname']
        );

        return $response;
    }

    /**
     * @param string $responseBody
     * @return array
     */
    protected function parseJson(string $responseBody): array
    {
        $jsonResponse = json_decode($responseBody, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException(
                'Error decoding Google response: ' . json_last_error_msg(),
                json_last_error()
            );
        }

        if (!array_key_exists('success', $jsonResponse)) {
            throw new \RuntimeException('Missing required response attribute: success');
        }

        if ($jsonResponse['success'] === false) {
            throw new Exception($jsonResponse['error-codes'] ?? []);
        }

        $requiredAttributes = [
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
