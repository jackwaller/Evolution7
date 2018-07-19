<?php
/**
 * Zomato plugin for Craft CMS 3.x
 *
 * A craft plugin to make requests to the Zomato API
 *
 * @link      https://github.com/jackwaller
 * @copyright Copyright (c) 2018 Jack Waller
 */

namespace jackwaller\zomato\twigextensions;

use Craft;
use jackwaller\zomato\Zomato;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Twig can be extended in many ways; you can add extra tags, filters, tests, operators,
 * global variables, and functions. You can even extend the parser itself with
 * node visitors.
 *
 * http://twig.sensiolabs.org/doc/advanced.html
 *
 * @author    Jack Waller
 * @package   Zomato
 * @since     1.0.0
 */
class ZomatoTwigExtension extends \Twig_Extension
{

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'Zomato';
    }

    /**
     * Returns an array of Twig filters, used in Twig templates via:
     *
     *      {{ 'something' | someFilter }}
     *
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('someFilter', [$this, 'requestZomatoApi']),
        ];
    }

    /**
     * Returns an array of Twig functions, used in Twig templates via:
     *
     *      {% set this = someFunction('something') %}
     *
    * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('searchZomato', [$this, 'requestZomatoApi']),
        ];
    }

    /**
     * Contact the Zomato API and make a request to fetch restaurants 
     *     *
     * @return array
     */
    public function requestZomatoApi($location = 259)
    {
        // Use guzzle to make a request to the Zomato API
        $client = new Client();
        $response = $client->get(
            'https://developers.zomato.com/api/v2.1/search?entity_id='.$location.'&entity_type=city&count=20', [
            'headers' => [
                'Accept' => 'application/json',
                'user-key' => 'a92d3dc1e771de07f4ca19fa8c8cbd8f',
            ],
        ]);

        // Return the contents of the response 
        $result = json_decode($response->getBody()->getContents(),true);
        return $result['restaurants'];
    }
}
