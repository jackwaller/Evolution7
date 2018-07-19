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
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('retrieveRestaurants', [$this, 'retrieveRestaurants']),
        ];
    }

    /**
     *  Use server-side caching to store API request's as JSON at a set 
     *  interval, rather than each pageload. Set the interval to 2 hours
     *     
     * @return array
     */
    public function retrieveRestaurants()
    {
        $cacheFile = dirname(__FILE__) . '/zomato-cache.json';
        $expires = time() - 2*60*60;

        // Check if the file exists and if it has not expired 
        if(file_exists($cacheFile) && filectime($cacheFile) > $expires) {
            $jsonResults = file_get_contents($cacheFile);
        } else {
            $jsonResults = $this->zomatoApiRequest();
            // Check if there was an error with the zomato API 
            if ($jsonResults == "An unexpected error has occurred") {
                // If there is an existing file return regardless if it has expired or not
                if (file_exists($cacheFile)) {
                    $jsonResults = file_get_contents($cacheFile);
                } else {
                    return "An unexpected error has occurred";
                }
            }
            // Update the response
            file_put_contents($cacheFile, $jsonResults);
        }
        // Return JSON to the homepage
        $result = json_decode($jsonResults,true);
        return $result['restaurants'];
    }

    /**
     * Contact the Zomato API and save the response to cache
     *     
     * @return string
     */
    public function zomatoApiRequest($location = 259)
    {
          // Use guzzle to make a request to the Zomato API
          $client = new Client();
          try
          {
              $response = $client->get(
                  'https://developers.zomato.com/api/v2.1/search?entity_id='.$location.'&entity_type=city&count=20', [
                  'headers' => [
                      'Accept' => 'application/json',
                      'user-key' => 'a92d3dc1e771de07f4ca19fa8c8cbd8f',
                  ],
              ]);
              $content = $response->getBody()->getContents(); 
              return $content;     
          }
          catch (RequestException $e)
          {   
              return "An unexpected error has occurred"; 
          }
    }


}



