<?php

namespace Lozemc;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use RuntimeException;

class B24
{
    use Lead, Deal, Contact, User, Im, Timeline, Status;

    private $config;

    /** @var Client */
    private $client;

    /** @var float[] */
    private $requestTimestamps = [];

    /** @var int */
    private $rateLimit;

    /**
     * @param string $id
     * @param string $host
     * @param string $token
     * @param int $timeout
     * @param int $rateLimit максимальное количество запросов в секунду
     */
    public function __construct(string $id, string $host, string $token, int $timeout = 30, int $rateLimit = 2)
    {
        $this->config = ['id' => $id, 'host' => $host, 'token' => $token];
        $this->client = new Client(['timeout' => $timeout]);
        $this->rateLimit = $rateLimit;
    }

    /**
     * @param $id
     * @param string $host
     * @param string $token
     * @param int $timeout
     * @param int $rateLimit
     * @return B24
     */
    public static function init($id, string $host, string $token, int $timeout = 30, int $rateLimit = 2): B24
    {
        return new self($id, $host, $token, $timeout, $rateLimit);
    }

    private function throttle(): void
    {
        $now = microtime(true);

        $this->requestTimestamps = array_values(array_filter(
            $this->requestTimestamps,
            static function ($t) use ($now) { return $now - $t < 1.0; }
        ));

        if (count($this->requestTimestamps) >= $this->rateLimit) {
            $oldest = min($this->requestTimestamps);
            $sleepUs = (int) ((1.0 - ($now - $oldest)) * 1000000);
            if ($sleepUs > 0) {
                usleep($sleepUs);
            }
        }

        $this->requestTimestamps[] = microtime(true);
    }

    /**
     * Метод для обмена данными с CRM Bitrix24
     * @param string $method
     * @param array $values
     * @return array
     */
    public function request(string $method, array $values): array
    {
        $this->throttle();
        try {
            $response = $this->client->post($this->getUrl($method), [
                'json' => $values,
            ]);

            $statusCode = $response->getStatusCode();

            $content = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            if ($statusCode !== 200 || !isset($content['result'])) {
                throw new RuntimeException("Error: " . json_encode($content, JSON_THROW_ON_ERROR | 256));
            }

            return $this->makeResponse($content);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            if(!empty($content = $response->getBody()->getContents())){
                try {
                    return $this->makeResponse(json_decode($content, true, 512, JSON_THROW_ON_ERROR));
                } catch (JsonException $e) {
                    return $this->makeResponse(['error' => 'Ошибка ответа', 'error_description' => $content]);
                }
            }
        } catch (JsonException|GuzzleException $e){
            return $this->makeResponse($e->getMessage());
        }

        return $this->makeResponse('Непредвиденная ошибка');
    }

    private function makeResponse($data): array
    {
        if(is_array($data) && isset($data['result'])){
            return $data;
        }

        return ['error' => $data];
    }

    private function getUrl(string $method): string
    {
        return sprintf(
            'https://%s/rest/%s/%s/%s.json',
            $this->config['host'],
            $this->config['id'],
            $this->config['token'],
            $method
        );
    }

    private function setDefaultParams(array $data, $event = true): array
    {
        return ['fields' => $data, 'params' => ['REGISTER_SONET_EVENT' => $event ? 'Y' : 'N']];
    }
}
