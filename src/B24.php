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

    /**
     * @param string $id
     * @param string $host
     * @param string $token
     */
    public function __construct(string $id, string $host, string $token)
    {
        $this->config = ['id' => $id, 'host' => $host, 'token' => $token];
    }

    /**
     * @param $id
     * @param string $host
     * @param string $token
     * @return B24
     */
    public static function init($id, string $host, string $token): B24
    {
        return new self($id, $host, $token);
    }

    /**
     * Метод для обмена данными с CRM Bitrix24
     * @param string $method
     * @param array $values
     * @return array
     */
    public function request(string $method, array $values): array
    {
        try {
            $response = (new Client())->post($this->getUrl($method), [
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
