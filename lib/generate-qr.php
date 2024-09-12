<?php
/**
 * Generate QR
 *
 * Class to generate Zatca QR data
 *
 * @package EDD Zatca QR Fatora
 * @since 1.0
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


class GenerateQrCode
{

    public function encoding($tag1, $tag2, $tag3, $tag4, $tag5)
    {
        $dataToEncode = [
            [1, $tag1], // البائع
            [2, $tag2], // الرقم الضريبي
            [3, $tag3], // الوقت والتاريخ
            [4, $tag4], // اجمالي الفاتورة بدون الضريبة
            [5, $tag5] // الضريبة
        ];

        $__TLV = $this->__getTLV($dataToEncode);
        return  base64_encode($__TLV);
    }

    function __getLength($value)
    {
        return strlen($value);
    }

    function __toHex($value)
    {
        return pack("H*", sprintf("%02X", $value));
    }

    function __dToString($__tag, $__value, $__length)
    {
        $value = (string) $__value;
        return $this->__toHex($__tag) . $this->__toHex($__length) . $value;
    }

    function __getTLV($dataToEncode)
    {
        $__TLVS = '';
        for ($i = 0; $i < count($dataToEncode); $i++) {
            $__tag = $dataToEncode[$i][0];
            $__value = $dataToEncode[$i][1];
            $__length = $this->__getLength($__value);
            $__TLVS .= $this->__dToString($__tag, $__value, $__length);
        }

        return $__TLVS;
    }
}