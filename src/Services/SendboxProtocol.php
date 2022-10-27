<?php namespace professionalweb\sendbox\Services;

use Illuminate\Support\Facades\Cache;
use professionalweb\sendbox\Models\Response;
use professionalweb\sendbox\Interfaces\Services\Protocol;
use professionalweb\sendbox\interfaces\Services\Response as IResponse;

/**
 * Class-wrapper for Sendbox protocol
 * @package professionalweb\sendbox\Services
 */
class SendboxProtocol implements Protocol
{

    private string $url;

    private string $clientId;

    private string $clientSecret;

    private ?string $accessToken = null;

    public function __construct(string $clientId = '', string $clientSecret = '', string $url = 'https://mailer-api.i.bizml.ru/')
    {
        $this->setUrl($url)->setClientId($clientId)->setClientSecret($clientSecret);
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function updateToken(): string
    {
        $response = $this->call(self::METHOD_TOKEN_UPDATE, [
            'grant_type'    => 'client_credentials',
            'client_id'     => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
        ]);

        $data = $response->getData();
        if (isset($data['access_token'])) {
            $this->setAccessToken($data['access_token']);
            Cache::put('sendbox-protocol-accessToken', $data['access_token'], $data['expires_in']);

            return $data['access_token'];
        }

        throw new \Exception();
    }

    /**
     * Call API method
     *
     * @param string $method
     * @param array  $params
     * @param string $httpMethod
     *
     * @return IResponse
     * @throws \Exception
     */
    public function call(string $method, array $params = [], string $httpMethod = 'post'): IResponse
    {
        $url = rtrim($this->getUrl(), '/') . '/' . ltrim($method, '/');

        $accessToken = $this->getAccessToken();
        if ($method !== self::METHOD_TOKEN_UPDATE && empty($accessToken)) {
            $this->setAccessToken($accessToken = $this->updateToken());
        }

        $headers = [];
        if (!empty($accessToken)) {
            $headers = ['Authorization: Bearer ' . $accessToken];
        }
        $response = $this->sendRequest($url, $params, $headers);
        if ($response->needRedirect()) {
            return $this->sendRequest(
                rtrim($this->getUrl(), '/') . '/' . ltrim($response->getRedirectUrl(), '/'),
                $params,
                $headers,
                $httpMethod
            );
        }

        return $response;
    }

    /**
     * Send request
     *
     * @param string $url
     * @param array  $params
     * @param array  $headers
     * @param string $method
     *
     * @return IResponse
     */
    protected function sendRequest(string $url, array $params = [], array $headers = [], string $method = 'post'): IResponse
    {
        foreach ($params as $key => $val) {
            if (!is_array($val) && !is_array($val)) {
                $url = str_replace('{' . $key . '}', $val, $url);
            }
        }
        if ($method === 'get') {
            $url .= strpos($url, '?') ? '&' : '?';
            $url .= http_build_query($params);
        }
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'GetLMS.SendBox.Lib/PHP');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array_merge($headers, ['Content-Type:application/json']));
        if ($method === 'post') {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
        } elseif ($method !== 'get') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($method));
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $body = curl_exec($curl);

        return new Response($body, curl_getinfo($curl, CURLINFO_HTTP_CODE) >= 400);
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return SendboxProtocol
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @param string $clientId
     *
     * @return SendboxProtocol
     */
    public function setClientId(string $clientId): self
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * @param string $clientSecret
     *
     * @return SendboxProtocol
     */
    public function setClientSecret(string $clientSecret): self
    {
        $this->clientSecret = $clientSecret;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     *
     * @return SendboxProtocol
     */
    public function setAccessToken(string $accessToken): self
    {
        $this->accessToken = $accessToken;

        return $this;
    }
}
