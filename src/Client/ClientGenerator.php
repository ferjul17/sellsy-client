<?php

/**
 * Sellsy Client.
 *
 * LICENSE
 *
 * This source file is subject to the MIT license and the version 3 of the GPL3
 * license that are bundled with this package in the folder licences
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@uni-alteri.com so we can send you a copy immediately.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/sellsy-client Project website
 *
 * @license     http://teknoo.software/sellsy-client/license/mit         MIT License
 * @license     http://teknoo.software/sellsy-client/license/gpl-3.0     GPL v3 License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 *
 * @version     0.8.0
 */

namespace Teknoo\Sellsy\Client;

use Teknoo\Curl\RequestGenerator;
use Teknoo\Sellsy\Client\Collection\CollectionGenerator;
use Teknoo\Sellsy\Client\Collection\CollectionGeneratorInterface;

/**
 * Class ClientGenerator
 * Class to use ase service to generate new Sellsy client to use the Sellsy API.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/sellsy-client Project website
 *
 * @license     http://teknoo.software/sellsy-client/license/mit         MIT License
 * @license     http://teknoo.software/sellsy-client/license/gpl-3.0     GPL v3 License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class ClientGenerator
{
    /**
     * @var ClientInterface
     */
    protected $originalClient;

    /**
     * Contructor to initialize the generator.
     *
     * @param RequestGenerator|ClientInterface $requestGenerator
     * @param CollectionGeneratorInterface     $collectionGenerator
     * @param string                           $apiUrl
     * @param string                           $oauthAccessToken
     * @param string                           $oauthAccessTokenSecret
     * @param string                           $oauthConsumerKey
     * @param string                           $oauthConsumerSecret
     */
    public function __construct(
        $requestGenerator = null,
        $collectionGenerator = null,
        $apiUrl = '',
        $oauthAccessToken = '',
        $oauthAccessTokenSecret = '',
        $oauthConsumerKey = '',
        $oauthConsumerSecret = ''
    ) {
        if ($requestGenerator instanceof ClientInterface) {
            //Clone next clients from an existant model
            return $this->originalClient = $requestGenerator;
        } elseif ($requestGenerator instanceof RequestGenerator
            && $collectionGenerator instanceof CollectionGeneratorInterface) {

            //Clone nexts client from the Client with arguments defined
            $this->originalClient = new Client(
                $requestGenerator,
                $collectionGenerator,
                $apiUrl,
                $oauthAccessToken,
                $oauthAccessTokenSecret,
                $oauthConsumerKey,
                $oauthConsumerSecret
            );
        } elseif (empty($requestGenerator)) {
            //Clone next clients with default request generator and collection generator
            $this->originalClient = new Client(
                new RequestGenerator(),
                new CollectionGenerator(),
                $apiUrl,
                $oauthAccessToken,
                $oauthAccessTokenSecret,
                $oauthConsumerKey,
                $oauthConsumerSecret
            );
        } else {
            throw new \InvalidArgumentException('Error, invalid arguments passed to the Sellsy client generator');
        }
    }

    /**
     * Return a new instance of the client.
     *
     * @return ClientInterface
     */
    public function getClient()
    {
        return clone $this->originalClient;
    }
}
