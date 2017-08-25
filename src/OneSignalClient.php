<?php

namespace Berkayk\OneSignal;

use GuzzleHttp\Client;

class OneSignalClient
{
    const API_URL = "https://onesignal.com/api/v1";
    const ENDPOINT_NOTIFICATIONS = "/notifications";
    const ENDPOINT_PLAYERS = "/players";

    /** @var bool */
    public $requestAsync = false;

    /** @var \GuzzleHttp\Client */
    private $client;

    /** @var string */
    private $appId;

    /** @var string */
    private $restApiKey;

    /** @var array */
    private $additionalParams;

    /** @var callable */
    private $requestCallback;

    /**
     * OneSignalClient constructor
     *
     * @param string $appId
     * @param string $restApiKey
     */
    public function __construct(string $appId, string $restApiKey)
    {
        $this->appId = $appId;
        $this->restApiKey = $restApiKey;

        $this->client = new Client();
        $this->additionalParams = [];
    }

    /**
     * Turn on, turn off async requests
     *
     * @param bool $on
     * @return OneSignalClient
     */
    public function async(bool $on = true): OneSignalClient
    {
        $this->requestAsync = $on;

        return $this;
    }

    /**
     * Callback to execute after OneSignal returns the response
     *
     * @param callable $requestCallback
     * @return OneSignalClient
     */
    public function callback(callable $requestCallback): OneSignalClient
    {
        $this->requestCallback = $requestCallback;

        return $this;
    }

    /**
     * @return string
     */
    public function testCredentials(): string
    {
        return "APP ID: " . $this->appId . " REST: " . $this->restApiKey;
    }

    /**
     * @param array $params
     * @return OneSignalClient
     */
    public function addParams($params = []): OneSignalClient
    {
        $this->additionalParams = $params;

        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return OneSignalClient
     */
    public function setParam($key, $value): OneSignalClient
    {
        $this->additionalParams[$key] = $value;

        return $this;
    }

    /**
     * @param string $message
     * @param string|null $url
     * @param array|null $data
     * @param array|null $buttons
     * @param string|\DateTimeInterface|null $schedule
     * @return \GuzzleHttp\Promise\PromiseInterface|\Psr\Http\Message\ResponseInterface
     */
    public function sendNotificationToAll(string $message, string $url = null, array $data = null, array $buttons = null, $schedule = null)
    {
        $contents = [
            "en" => $message
        ];

        $params = [
            'app_id' => $this->appId,
            'contents' => $contents,
            'included_segments' => ['All']
        ];

        if (!is_null($url)) {
            $params['url'] = $url;
        }

        if (!is_null($data)) {
            $params['data'] = $data;
        }

        if (!is_null($buttons)) {
            $params['buttons'] = $buttons;
        }

        if (!is_null($schedule)) {
            $params['send_after'] = $schedule;
        }

        return $this->sendNotificationCustom($params);
    }

    /**
     * @param string $message
     * @param string $segment
     * @param string|null $url
     * @param array|null $data
     * @param array|null $buttons
     * @param string|\DateTimeInterface|null $schedule
     * @return \GuzzleHttp\Promise\PromiseInterface|\Psr\Http\Message\ResponseInterface
     */
    public function sendNotificationToSegment(string $message, string $segment, string $url = null, array $data = null, array $buttons = null, $schedule = null)
    {
        $contents = [
            "en" => $message
        ];

        $params = [
            'app_id' => $this->appId,
            'contents' => $contents,
            'included_segments' => [$segment]
        ];

        if (!is_null($url)) {
            $params['url'] = $url;
        }

        if (!is_null($data)) {
            $params['data'] = $data;
        }

        if (!is_null($buttons)) {
            $params['buttons'] = $buttons;
        }

        if (!is_null($schedule)) {
            $params['send_after'] = $schedule;
        }

        return $this->sendNotificationCustom($params);
    }

    /**
     * @param string $message
     * @param string $userId
     * @param string|null $url
     * @param array|null $data
     * @param array|null $buttons
     * @param string|\DateTimeInterface|null $schedule
     * @return \GuzzleHttp\Promise\PromiseInterface|\Psr\Http\Message\ResponseInterface
     */
    public function sendNotificationToUser(string $message, string $userId, string $url = null, array $data = null, array $buttons = null, $schedule = null)
    {
        $contents = [
            "en" => $message
        ];

        $params = [
            'app_id' => $this->appId,
            'contents' => $contents,
            'include_player_ids' => [$userId]
        ];

        if (!is_null($url)) {
            $params['url'] = $url;
        }

        if (!is_null($data)) {
            $params['data'] = $data;
        }

        if (!is_null($buttons)) {
            $params['buttons'] = $buttons;
        }

        if (!is_null($schedule)) {
            $params['send_after'] = $schedule;
        }

        return $this->sendNotificationCustom($params);
    }

    /**
     * @param string $message
     * @param array $filters
     * @param string|null $url
     * @param array|null $data
     * @param array|null $buttons
     * @param string|\DateTimeInterface|null $schedule
     * @return \GuzzleHttp\Promise\PromiseInterface|\Psr\Http\Message\ResponseInterface
     */
    public function sendNotificationUsingFilters(string $message, array $filters, string $url = null, array $data = null, array $buttons = null, $schedule = null)
    {
        $contents = [
            "en" => $message
        ];

        $params = [
            'app_id' => $this->appId,
            'contents' => $contents,
            'filters' => $filters,
        ];

        if (!is_null($url)) {
            $params['url'] = $url;
        }

        if (!is_null($data)) {
            $params['data'] = $data;
        }

        if (!is_null($buttons)) {
            $params['buttons'] = $buttons;
        }

        if (!is_null($schedule)) {
            $params['send_after'] = $schedule;
        }

        return $this->sendNotificationCustom($params);
    }

    /**
     * @param string $message
     * @param array $tags
     * @param string|null $url
     * @param array|null $data
     * @param array|null $buttons
     * @param string|\DateTimeInterface|null $schedule
     * @return \GuzzleHttp\Promise\PromiseInterface|\Psr\Http\Message\ResponseInterface
     */
    public function sendNotificationUsingTags(string $message, array $tags, string $url = null, array $data = null, array $buttons = null, $schedule = null)
    {
        $contents = [
            "en" => $message
        ];

        $params = [
            'app_id' => $this->appId,
            'contents' => $contents,
            'tags' => $tags,
        ];

        if (!is_null($url)) {
            $params['url'] = $url;
        }

        if (!is_null($data)) {
            $params['data'] = $data;
        }

        if (!is_null($buttons)) {
            $params['buttons'] = $buttons;
        }

        if (!is_null($schedule)) {
            $params['send_after'] = $schedule;
        }

        return $this->sendNotificationCustom($params);
    }

    /**
     * Send a notification with custom parameters defined in
     * @see https://documentation.onesignal.com/reference#section-example-code-create-notification
     *
     * @param array $parameters
     * @return \GuzzleHttp\Promise\PromiseInterface|\Psr\Http\Message\ResponseInterface
     */
    public function sendNotificationCustom($parameters = [])
    {
        // Make sure to use app_id
        $parameters['app_id'] = $this->appId;

        // Make sure to use included_segments
        if (
            empty($parameters['included_segments']) &&
            empty($parameters['include_player_ids'])
        ) {
            $parameters['included_segments'] = ['all'];
        }

        // Make sure send_after is formatted properly when an instance of \DateTimeInterface is used
        if (
            !empty($parameters['send_after']) &&
            ($send_after = $parameters['send_after']) &&
            $send_after instanceof \DateTimeInterface
        ) {
            $parameters['send_after'] = $send_after->format('Y-m-d H:i:sO');
        }

        $parameters = array_merge($parameters, $this->additionalParams);

        $data = [
            'headers' => [
                'Authorization' => "Basic {$this->restApiKey}"
            ],
            'json' => $parameters,
            'verify' => false
        ];

        return $this->post(self::ENDPOINT_NOTIFICATIONS, $data);
    }

    /**
     * Creates a user/player
     *
     * @param array $parameters
     * @return \GuzzleHttp\Promise\PromiseInterface|\Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function createPlayer(array $parameters = [])
    {
        if (!isset($parameters['device_type']) or !is_numeric($parameters['device_type'])) {
            throw new \Exception('The `device_type` param is required as integer to create a player(device)');
        }

        return $this->sendPlayer($parameters, false, self::ENDPOINT_PLAYERS);
    }

    /**
     * Edit a user/player
     *
     * @param array $parameters
     * @return \GuzzleHttp\Promise\PromiseInterface|\Psr\Http\Message\ResponseInterface
     */
    public function editPlayer(array $parameters = [])
    {
        return $this->sendPlayer($parameters, true, self::ENDPOINT_PLAYERS . '/' . $parameters['id']);
    }

    /**
     * Create or update a by $method value
     *
     * @param array $parameters
     * @param bool $put
     * @param string $endpoint
     * @return \GuzzleHttp\Promise\PromiseInterface|\Psr\Http\Message\ResponseInterface
     */
    private function sendPlayer(array $parameters, bool $put = false, string $endpoint = self::ENDPOINT_PLAYERS)
    {
        $parameters['app_id'] = $this->appId;

        $data = [
            'json' => $parameters
        ];

        if ($put) {
            return $this->put($endpoint, $data);
        }

        return $this->post($endpoint, $data);
    }

    /**
     * @param string $endPoint
     * @param array $data
     * @return \GuzzleHttp\Promise\PromiseInterface|\Psr\Http\Message\ResponseInterface
     */
    private function post(string $endPoint, array $data)
    {
        if ($this->requestAsync === true) {
            $promise = $this->client->postAsync(self::API_URL . $endPoint, $data);

            if (is_callable($this->requestCallback)) {
                $promise = $promise->then($this->requestCallback);
            }

            return $promise;
        }

        return $this->client->post(self::API_URL . $endPoint, $data);
    }

    /**
     * @param string $endPoint
     * @param array $data
     * @return \GuzzleHttp\Promise\PromiseInterface|\Psr\Http\Message\ResponseInterface
     */
    private function put(string $endPoint, array $data)
    {
        if ($this->requestAsync === true) {
            $promise = $this->client->putAsync(self::API_URL . $endPoint, $data);

            if (is_callable($this->requestCallback)) {
                $promise = $promise->then($this->requestCallback);
            }

            return $promise;
        }

        return $this->client->put(self::API_URL . $endPoint, $data);
    }
}
