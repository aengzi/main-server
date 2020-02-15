<?php

namespace App\Services;

use App\Service;
use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Core\JWK;
use Jose\Component\Encryption\Algorithm\KeyEncryption\A128GCMKW;
use Jose\Component\Encryption\Algorithm\ContentEncryption\A128CBCHS256;
use Jose\Component\Encryption\Compression\CompressionMethodManager;
use Jose\Component\Encryption\Compression\Deflate;
use Jose\Component\Encryption\Serializer\CompactSerializer;
use Jose\Component\Encryption\JWEBuilder;

class TokenEncryptingService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbackLists()
    {
        return [];
    }

    public static function getArrLoaders()
    {
        return [
            'jwk' => [function () {

                return new JWK([
                    'alg'
                        => 'A128GCMKW',
                    'use'
                        => 'enc',
                    'kty'
                        => 'oct',
                    'k'
                        => 'I2FeeR3Th6FmhgHN-cxd-9GRRiwcNB2OQzW6vouGFd5hcAwNAu1377hvDmGLKttBitlHiFzk643FyHw4XFM9tdJ90s2zmkX3SsE2KX5B1Qe_sEhqYmWZsJyjeyx-Q0w4B2jX7b39GUybimHUoVHDPTUrgPUKeBf-xVIGJCvHyiE'
                ]);
            }],

            'encrypter' => [function () {

                $keyEncryptionAlgorithmManager = new AlgorithmManager([
                    new A128GCMKW,
                ]);
                $contentEncryptionAlgorithmManager = new AlgorithmManager([
                    new A128CBCHS256,
                ]);
                $compressionMethodManager = new CompressionMethodManager([
                    new Deflate,
                ]);

                return new JWEBuilder(
                    $keyEncryptionAlgorithmManager,
                    $contentEncryptionAlgorithmManager,
                    $compressionMethodManager
                );
            }],

            'payload' => [function () {

                throw new \Exception;
            }],

            'token' => ['payload', 'jwk', 'encrypter', function ($payload, $jwk, $encrypter) {

                $jwe = $encrypter
                    ->create()
                    ->withPayload(json_encode($payload))
                    ->withSharedProtectedHeader([
                        'alg' => 'A128GCMKW',
                        'enc' => 'A128CBC-HS256',
                        'zip' => 'DEF'
                    ])
                    ->addRecipient($jwk)
                    ->build();

                return (new CompactSerializer)->serialize($jwe, 0);
            }],

            'result' => ['token', function ($token) {

                return $token;
            }]
        ];
    }

    public static function getArrPromiseLists()
    {
        return [];
    }

    public static function getArrRuleLists()
    {
        return [];
    }

    public static function getArrTraits()
    {
        return [];
    }
}
