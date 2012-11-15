<?php

/**
 * 描述 Util
 *
 * @author 张迪
 */
class Util {

    public static function substring($string, $length, $etc = "...") {
        $result = '';
        $string = html_entity_decode(trim(strip_tags($string)), ENT_QUOTES, 'UTF-8');
        $strlen = strlen($string);
        for ($i = 0; (($i < $strlen) && ($length > 0)); $i++) {
            if ($number = strpos(str_pad(decbin(ord(substr($string, $i, 1))), 8, '0', STR_PAD_LEFT), '0')) {
                if ($length < 1.0) {
                    break;
                }
                $result .= substr($string, $i, $number);
                $length -= 1.0;
                $i += $number - 1;
            } else {
                $result .= substr($string, $i, 1);
                $length -= 0.5;
            }
        }
        $result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
        if ($i < $strlen) {
            $result .= $etc;
        }
        return $result;
    }

    /**
     * 发送邮件
     * @param string $receiver 收件人
     * @param string $subject 主题
     * @param string $body 邮件内容
     * @return bool 是否发送成功
     */
    public static function sendMail($receiver, $subject, $body) {
        $mailer = Yii::createComponent('ext.mailer.EMailer');
        $mailer->Host = Yii::app()->params['serviceEmail']['host'];
        $mailer->IsHTML(true);
        $mailer->IsSMTP();
        $mailer->Port = '25';
        $mailer->SMTPAuth = true;
        $mailer->Username = Yii::app()->params['serviceEmail']['username'];
        $mailer->Password = Yii::app()->params['serviceEmail']['password'];
        $mailer->From = Yii::app()->params['serviceEmail']['address'];
        $mailer->FromName = Yii::app()->params['serviceEmail']['name'];
        $mailer->CharSet = 'utf-8';
        $mailer->AddReplyTo($receiver);
        $mailer->AddAddress($receiver);
        $mailer->Subject = $subject;
        $mailer->Body = $body;
        return $mailer->Send();
    }

    /**
     *
     * @param int $timestamp Unix 时间戳
     * @param int $type 显示的时间类型
     *
     * 可选值 0：默认类型 2011年1月1日 1时1分
     * 1：2011/10/10 10:10
     * 2: 2011-10-10 10:10
     * @return 指定格式的时间
     */
    public static function date($timestamp,$type = 0){
        $types = array(
            'Y年m月d日',
            'Y/m/d H:i',
            'Y-m-d H:i'
        );

        return date($types[$type],$timestamp);
    }

}

?>
