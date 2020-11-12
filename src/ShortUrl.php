<?php

namespace ShortUrl;

class ShortUrl
{
    protected $salt = '1nd910kds';
    protected $shortUrlHost;
    
    /**
     * 生成
     * @param $insertId
     * @return string
     */
    public function shortUrlGenerate($insertId)
    {
        return $this->urlEncrypt($this->from10To62($insertId));
    }
    
    
    /**
     * 解析
     * @param $url
     * @return string
     * @throws Exception
     */
    public function shortUrlParse($url)
    {
        $shoturl = $this->urlDecrypt($url);
        if (false == $shoturl) {
            throw new Exception('解析失败!', 401);
        }
        
        
        $id = $this->from62To10($shoturl);
        if (!is_numeric($id)) {
            throw new Exception('解析失败', 401);
        }
        
        return $id;
    }
    
    
    /**
     * 任意进制转换
     * @param $number
     * @param $in
     * @param $out
     * @return string
     */
    public function baseConvertBc($number, $in, $out)
    {
        
        $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = "$number";
        $len = strlen($num);
        $n = 0;
        for ($i = 0; $i < $len; $i++) {
            $sc = bcmul(strpos($str, $num[$i]), bcpow($in, $len - $i - 1));
            $n = bcadd($n, $sc, 0);
        }
        $e = '';
        while ($n > 0) {
            $i = bcmod($n, $out);
            $e = $str[$i] . $e;
            $n = bcdiv($n, $out, 0);
        }
        return $e;
    }
    
    
    /**
     * 10进制转换62进制
     * @param $number
     * @return string
     */
    public function from10To62($number)
    {
        return $this->baseConvertBc($number, 10, 62);
    }
    
    /**
     * 62进制转换10进制
     * @param $string
     * @return string
     */
    public function from62To10($string)
    {
        return $this->baseConvertBc($string, 62, 10);
    }
    
    /**
     * 短网址加密
     */
    private function urlEncrypt($url)
    {
        
        $checkCode = $this->baseConvertBc(substr(md5($url . $this->salt), 0, 4), 16, 62);
        return $url . substr($checkCode, 0, 2);
    }
    
    
    /**
     * 短网址解密
     */
    private function urlDecrypt($url)
    {
        $urlLength = strlen($url);
        
        $trueUrl = substr($url, 0, $urlLength - 2);
        $checkCode = substr($url, -2, 2);
        
        $rawCheckCode = $this->baseConvertBc(substr(md5($trueUrl . $this->salt), 0, 4), 16, 62);
        $code = substr($rawCheckCode, 0, 2);
        
        if ($checkCode != $code) {
            return false;
        }
        
        return $trueUrl;
    }
}