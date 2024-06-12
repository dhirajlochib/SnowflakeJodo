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

    public function prepare(string $sql, array $bindings = [])
    {
        return new SnowflakeStatement($this->client, $this->apiUrl, $sql, $bindings);
    }
}

class SnowflakeStatement
{
    protected $client;
    protected $apiUrl;
    protected $sql;
    protected $bindings;
    protected $results;
    protected $currentIndex;

    public function __construct($client, $apiUrl, $sql, $bindings)
    {
        $this->client = $client;
        $this->apiUrl = $apiUrl;
        $this->sql = $sql;
        $this->bindings = $bindings;
        $this->results = null;
        $this->currentIndex = 0;
    }

    protected function execute()
    {
        try {
            $response = $this->client->post('/api/snowflake/query', [
                'json' => [
                    'sql' => $this->sql,
                    'bindings' => $this->bindings 
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data['error'])) {
                throw new SnowflakeConnectionException($data['error']);
            }

            $this->results = $data;
            $this->currentIndex = 0;

        } catch (SnowflakeConnectionException $e) {
            throw $e; 

        } catch (\Exception $e) { 
            throw new SnowflakeConnectionException("Error: " . $e->getMessage());
        }
    }

    public function fetch()
    {
        if ($this->results === null) {
            $this->execute();
        }

        if ($this->currentIndex < count($this->results)) {
            return $this->results[$this->currentIndex++];
        }
        return false; // No more rows
    }

    public function fetchAll()
    {
        if ($this->results === null) {
            $this->execute();
        }

        return $this->results;
    }
}
