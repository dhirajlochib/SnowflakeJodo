<?php

namespace Rdr\SnowflakeJodo;

use GuzzleHttp\Client;
use Rdr\SnowflakeJodo\Exceptions\SnowflakeConnectionException;

class SnowflakeJodo 
{
    protected $client;
    protected $apiUrl;

    private function __construct() {} // Private constructor - no direct instantiation

    public static function connect()
    {
        $instance = new self();
        $instance->apiUrl = config('snowflakejodo.api_url');
        $instance->client = new Client(['base_uri' => $instance->apiUrl]);
        return $instance;
    }

    public function query(string $sql, array $bindings = [])
    {
        try {
            $response = $this->client->post('/api/snowflake/query', [
                'json' => [
                    'sql' => $sql,
                    'bindings' => $bindings 
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data['error'])) {
                throw new SnowflakeConnectionException($data['error']);
            }

            return new SnowflakeStatement($data);

        } catch (SnowflakeConnectionException $e) {
            throw $e; 

        } catch (\Exception $e) { 
            throw new SnowflakeConnectionException("Error: " . $e->getMessage());
        }
    }
}
