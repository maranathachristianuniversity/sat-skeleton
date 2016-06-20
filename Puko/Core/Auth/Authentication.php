<?php
/**
 * Authentication class for Puko Framework
 *
 * @author Didit Velliz <diditvelliz@gmail.com>
 * @link http://github.com/Velliz/puko
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since version 0.92
 * @package Puko Core
 */
namespace Puko\Core\Auth;

use Puko\Modules\AuthenticationModules;

class Authentication extends AuthenticationModules
{

    private static $method;
    private static $key;
    private static $identifier;

    /**
     * @var object
     */
    public static $Instance = null;

    static function GetInstance()
    {
        if (!isset(self::$Instance) && !is_object(self::$Instance)) {
            self::$Instance = new Authentication();
            $encript = include(FILE . '/Config/encription_config.php');
            self::$method = $encript['method'];
            self::$key = $encript['key'];
            self::$identifier = $encript['identifier'];
        }

        return self::$Instance;
    }

    public function IsAuthenticated()
    {
        if (!isset($_SESSION['PukoAuth'])) {
            return false;
        }

        return true;
    }

    function Authenticate($username, $password)
    {
        $secure = $this->encrypt($this->CustomAuthentication($username, $password));
        setcookie('puko', $secure, time() + (86400 * 30), "/", $_SERVER['SERVER_NAME']);
    }

    public function GetUserData()
    {
        $secure = $this->decrypt($_COOKIE['puko']);
        return $this->FetchUserData($secure);
    }

    public function RemoveAuthentication()
    {
        setcookie('puko', '', time() - (86400 * 30), '/', $_SERVER['SERVER_NAME']);
    }

    public function setSessionData($key, $val)
    {
        $secure = $this->encrypt($val);
        setcookie($key, $secure, time() + (86400 * 30), "/", $_SERVER['SERVER_NAME']);
    }

    public function getSessionData($val)
    {
        return $this->decrypt($_COOKIE[$val]);
    }

    public function removeSessionData($key)
    {
        setcookie($key, '', time() - (86400 * 30), '/', $_SERVER['SERVER_NAME']);
    }

    private function encrypt($string)
    {
        $key = hash('sha256', self::$key);
        $iv = substr(hash('sha256', self::$identifier), 0, 16);

        $output = openssl_encrypt($string, self::$method, $key, 0, $iv);
        return base64_encode($output);
    }

    private function decrypt($string)
    {
        $key = hash('sha256', self::$key);

        $iv = substr(hash('sha256', self::$identifier), 0, 16);
        return openssl_decrypt(base64_decode($string), self::$method, $key, 0, $iv);
    }
}

