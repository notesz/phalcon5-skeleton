<?php

namespace Skeleton\Library;

use Phalcon\Di\Di;
use Phalcon\Http\Request;
use Stevenmaguire\OAuth2\Client\Provider\Keycloak as KeycloakClient;

/**
 * Keycloak class.
 */
class Keycloak
{
    const SESSION_KEY_KC_OAUTH2STATE = 'kc_oauth2state';
    const SESSION_KEY_KC_TOKEN = 'kc_token';

    protected $provider;
    protected $authServerUrl;
    protected $realm;
    protected $clientId;
    protected $clientSecret;
    protected $redirectUrl;
    protected $version;

    /**
     * Keycloak constructor.
     */
    public function __construct()
    {
        $config = Di::getDefault()->get('config')->keycloak;

        $this->setAuthServerUrl($config['authServerUrl']);
        $this->setRealm($config['realm']);
        $this->setClientId($config['clientId']);
        $this->setClientSecret($config['clientSecret']);
        $this->setRedirectUri($config['redirectUri']);
        $this->setVersion($config['version']);

        $this->provider = new KeycloakClient([
            'authServerUrl' => $this->getAuthServerUrl(),
            'realm'         => $this->getRealm(),
            'clientId'      => $this->getClientId(),
            'clientSecret'  => $this->getClientSecret(),
            'redirectUri'   => $this->getRedirectUri(),
            'version'       => $this->getVersion(),
        ]);
    }

    /**
     * @return mixed
     */
    public function getAuthServerUrl()
    {
        return $this->authServerUrl;
    }

    /**
     * @param mixed $authServerUrl
     */
    public function setAuthServerUrl($authServerUrl)
    {
        $this->authServerUrl = $authServerUrl;
    }

    /**
     * @return mixed
     */
    public function getRealm()
    {
        return $this->realm;
    }

    /**
     * @param mixed $realm
     */
    public function setRealm($realm)
    {
        $this->realm = $realm;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @return mixed
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * @param mixed $clientSecret
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    /**
     * @return mixed
     */
    public function getRedirectUri()
    {
        return $this->redirectUrl;
    }

    /**
     * @param mixed $redirectUrl
     */
    public function setRedirectUri($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param mixed $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return void
     */
    public function login()
    {
        $authUrl = $this->provider->getAuthorizationUrl();

        Di::getDefault()->get('session')->set(
            self::SESSION_KEY_KC_OAUTH2STATE,
            $this->provider->getState()
        );

        header("Location: " . $authUrl);
    }

    /**
     * @return void
     */
    public function logout()
    {
        $logoutUrl = $this->provider->getLogoutUrl([
            'postLogoutRedirectUri' => (new Request())->getHTTPReferer(),
        ]);

        header("Location: " . $logoutUrl);
    }

    /**
     * @return bool
     */
    public function loginCallback()
    {
        try {
            if (
                empty($_GET['state']) ||
                ($_GET['state'] != Di::getDefault()->get('session')->get(self::SESSION_KEY_KC_OAUTH2STATE))
            ) {
                throw new \Exception('Invalid state.');
            }

            $token = $this->provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);

            Di::getDefault()->get('session')->set(self::SESSION_KEY_KC_TOKEN, $token);

        } catch (\Exception $e) {
            Di::getDefault()->get('session')->remove(self::SESSION_KEY_KC_OAUTH2STATE);
            Di::getDefault()->get('session')->remove(self::SESSION_KEY_KC_TOKEN);

            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public function getUserDetails()
    {
        if (!empty(Di::getDefault()->get('session')->get(self::SESSION_KEY_KC_TOKEN))) {
            try {
                return $this->provider->getResourceOwner(
                    Di::getDefault()->get('session')->get(self::SESSION_KEY_KC_TOKEN)
                )->toArray();
            } catch (\Exception $e) {
                Di::getDefault()->get('session')->remove(self::SESSION_KEY_KC_OAUTH2STATE);
                Di::getDefault()->get('session')->remove(self::SESSION_KEY_KC_TOKEN);
            }
        }

        return [];
    }
}
