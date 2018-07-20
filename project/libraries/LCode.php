<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class LCode {
    private $_codeConfig = [
        'with' => 150,//宽
        'hight'=> 43,//高
        'code' => '23456789qwertyuopasdfghjkzxcvbnmQWERTYUOPASDFGHJKZXCVBNM',//验证码值
        'number' => 4,//码值长度
        'x_float' => 15,//文字x轴浮动值
        'y_float' => 17,//文字y轴浮动值
        'font_size' => 20,//文字大小
        'font_path' => __DIR__.'/../../public/fonts/font.ttf',//字体文件路径
        'line_number' => 2,//干扰线数量
        'ellipse_number' => 2,//干扰弧线数量
    ];
    //验证码类
    public function getCode(){
        //1.发送头部
        header('Content-type:image/png');
        //2.创建画布
        $w = $this->_codeConfig['with'];
        $h = $this->_codeConfig['hight'];
        $img = imagecreatetruecolor($w,$h);
        //3.填充画布
        $white = hexdec('#FFFFFF');
        imagefill($img,0, 0, $white);

        //4.写验证码
        $seed = $this->_codeConfig['code'];
        $code = '';
        for ($i=0; $i < $this->_codeConfig['number']; $i++) {
            //验证码x坐标
            $x = $w / $this->_codeConfig['number'] * $i + $this->_codeConfig['x_float'];
            //验证码y坐标
            $y = ($h + $this->_codeConfig['y_float']) / 2;
            $color = imagecolorallocate($img, mt_rand(0,200), mt_rand(0,200), mt_rand(0,200));
            //获得随机文字
            $text = $seed[mt_rand(0,strlen($seed)-1)];
            $code .= $text;
            imagettftext($img,$this->_codeConfig['font_size'] , mt_rand(-45,45), $x, $y, $color, $this->_codeConfig['font_path'], $text);
        }

        //5.干扰*********
        //线
        for ($i=0; $i < $this->_codeConfig['line_number']; $i++) {
            $color = imagecolorallocate($img, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
            imageline($img, mt_rand(0,$w), mt_rand(0,$h), mt_rand(0,$w), mt_rand(0,$h), $color);
        }
        //圆
        for ($i=0; $i < $this->_codeConfig['ellipse_number']; $i++) {
            $wh = mt_rand(0,100);//随机弧度
            $color = imagecolorallocate($img, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
            imageellipse($img, mt_rand(0,$w), mt_rand(0,$h), $wh, $wh, $color);
        }
        //6.存入session
        $_SESSION['code'] = strtoupper($code);
        //7.输出销毁
        imagepng($img);
        imagedestroy($img);
    }
}