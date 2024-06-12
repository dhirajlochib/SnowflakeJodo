
# SnowflakeJodo - A Laravel Bridge to Snowflake 

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rdr/snowflakejodo.svg?style=flat-square)](https://packagist.org/packages/rdr/snowflakejodo)
[![Total Downloads](https://img.shields.io/packagist/dt/rdr/snowflakejodo.svg?style=flat-square)](https://packagist.org/packages/rdr/snowflakejodo)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

SnowflakeJodo provides a convenient way to integrate your Laravel application with a Snowflake data warehouse via a dedicated Node.js API. It simplifies data retrieval and reduces connection overhead common in direct Snowflake interactions.

## Installation

1. **Require the Package:** Use Composer to install the package in your Laravel project:
   ```bash
   composer require rdr/snowflakejodo
   ```
   This will install the package and its dependencies.

2. **Publish Configuration:** Publish the package configuration file:
   ```bash
   php artisan vendor:publish --tag=snowflakejodo-config
   ```
   This will create a `config/snowflakejodo.php` file in your project.

3. **Configure API URL:** Update the `api_url` value in your `.env` file to point to your running Node.js API endpoint:
   ```dotenv
   SNOWFLAKE_JODO_API_URL=http://localhost:3001
   ```
   Replace `http://localhost:3001` with the actual URL of your API.

4. **Create and Run Node.js API:** Set up and run a separate Node.js API that handles the direct communication with Snowflake. Make sure the API is running and accessible at the URL you configured in `.env`.

## Usage

### Establish a Connection
Create an instance of SnowflakeJodo using the `connect()` method:
```php
use Rdr\SnowflakeJodo\SnowflakeJodo;

// In a controller:
class MyController extends Controller
{
    protected $snowflake;

    public function __construct()
    {
        $this->snowflake = SnowflakeJodo::connect(); 
    }

    // ... your controller methods ... 
}
```

### Execute Queries
Use the `query()` method on the connection object to run Snowflake SQL queries:
```php
$results = $this->snowflake->query("SELECT * FROM users WHERE id = ?", [1]);
```

### Error Handling
SnowflakeJodo throws a `Rdr\SnowflakeJodo\Exceptions\SnowflakeConnectionException` if there are errors connecting to your API or if the API returns an error from Snowflake. Handle this exception gracefully in your application.

### Security
- Securely Configure Node.js API: Follow security best practices when configuring and deploying the API, such as using environment variables to store credentials.
- API Authentication (Optional): Enhance security by implementing an authentication mechanism between your Laravel application and the Node.js API (e.g., API keys, JWTs).

## Contributing

Thank you for considering contributing to SnowflakeJodo! Please read the [Contribution Guide](CONTRIBUTING.md) before submitting a pull request.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

---

**Dhiraj Lochib**
- GitHub: [@dhirajlochib](https://github.com/dhirajlochib)
