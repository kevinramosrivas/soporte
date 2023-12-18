<?php
namespace App\Helpers;


class Encryptor
{

    /**
     * Holds the Encryptor instance
     * @var Encryptor
     */
    private static $instance;

    /**
     * @var string
     */
    private $method = 'AES-256-CBC';

    /**
     * @var string
     */
    private $key = 'l+x>)k0d9N7e:W-(1QV3';

    /**
     * @var string
     */
    private $separator = ':';




    /**
     * Returns an instance of the Encryptor class or creates the new instance if the instance is not created yet.
     * @return Encryptor
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Encryptor();
        }
        return self::$instance;
    }

    /**
     * Generates the initialization vector
     * @return string
     */
    private function getIv()
    {
        return openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->method));
    }

    /**
     * @param string $data
     * @return string
     */
    public function encrypt($data)
    {
        $iv = $this->getIv();
        return base64_encode(openssl_encrypt($data, $this->method, $this->key, 0, $iv) . $this->separator . base64_encode($iv));
    }

    /**
     * @param string $dataAndVector
     * @return string
     */
    public function decrypt($dataAndVector)
    {
        $parts = explode($this->separator, base64_decode($dataAndVector));
        // $parts[0] = encrypted data
        // $parts[1] = initialization vector
  
        return openssl_decrypt($parts[0], $this->method, $this->key, 0, base64_decode($parts[1]));
    }

}