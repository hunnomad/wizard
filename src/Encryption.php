<?php

namespace Custom\Encryption;

/**
 * EncryptionException
 */
class EncryptionException extends \Exception
{
    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

/**
 * classWizard
 *
 * @package    Custom
 * @subpackage Identifier packages
 */

class classWizard
{
    private $key;
    private $ivSize;

    public function __construct($key)
    {
        // Checking key length
        if (strlen($key) !== 32) {
            throw new EncryptionException('The key must be exactly 32 characters long.');
        }

        $this->key = $key;
        $this->ivSize = 16; // IV size 16 bytes (128 bits)
    }

    public function decode($encryptedData)
    {
        $decodedData = base64_decode($encryptedData);
        if ($decodedData === false) {
            throw new EncryptionException('Base64 decoding failed.');
        }

        $iv = substr($decodedData, 0, $this->ivSize);
        $encryptedText = substr($decodedData, $this->ivSize);

        $decrypted = openssl_decrypt($encryptedText, 'AES-256-CBC', $this->key, OPENSSL_RAW_DATA, $iv);

        if ($decrypted === false) {
            throw new EncryptionException('Decoding failed: ' . openssl_error_string());
        }

        return $decrypted;
    }

    public function encode($data)
    {
        $iv = random_bytes($this->ivSize);
        $encryptedText = openssl_encrypt($data, 'AES-256-CBC', $this->key, OPENSSL_RAW_DATA, $iv);

        if ($encryptedText === false) {
            throw new EncryptionException('Encoding failed: ' . openssl_error_string());
        }

        $encryptedData = $iv . $encryptedText;

        return base64_encode($encryptedData);
    }
}
