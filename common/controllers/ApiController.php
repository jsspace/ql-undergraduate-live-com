<?php

namespace common\controllers;

use Yii;
use yii\web\Controller;


class ApiController extends Controller
{
    /**
     * post
     *
     * @param string $url url
     * @param string $data_string json string
     * @return json
     */
    public static function http_post_data($url, $data_string='', $header_arr = [])
    {
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        $header[] = 'Content-Type: application/json; charset=utf-8';
        $header[] = 'Content-Length: ' . strlen($data_string);
        if (!empty($header_arr)) {
            $header = array_merge($header,$header_arr);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    
        ob_start();
        curl_exec($ch);
        $return_content = ob_get_contents();
        ob_end_clean();
    
        if(curl_error($ch))
        {
            Yii::error('File: '. __FILE__ . ' line: ' . __LINE__ . ' Curl error: ' . curl_error($ch));
            $error_data = ["status"=>'error','message' => '服务不可用'];
            return json_encode($error_data);
        }
        curl_close($ch);
        return $return_content;
    }
    
    /**
     * get
     *
     * @param string $url url
     * @return json
     */
    public static function http_get_data($url, $header_arr = [])
    {
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
    
        // Setup headers - I used the same headers from Firefox version 2.0.0.6
        // below was split up because php.net said the line was too long. :/
        $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
        $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        $header[] = "Cache-Control: max-age=0";
        $header[] = "Connection: keep-alive";
        $header[] = "Keep-Alive: 300";
        $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
        $header[] = "Accept-Language: en-us,en;q=0.5";
        $header[] = "Pragma: "; // browsers keep this blank.
        if (!empty($header_arr)) {
            $header = array_merge($header,$header_arr);
        }
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    
        ob_start();
        curl_exec($ch);
        $return_content = ob_get_contents();
        ob_end_clean();
    
        if(curl_error($ch))
        {
            Yii::error('File: '. __FILE__ . ' line: ' . __LINE__ . ' Curl error: ' . curl_error($ch));
            $error_data = ["status"=>'error','message' => '服务不可用'];
            return json_encode($error_data);
        }
        curl_close($ch);
        return $return_content;
    }
    
    /**
     * @desc 发送文件流
     * @param string $url
     * @param binary $file
     * @return string
     *
     */
    public static function sendStreamFile($url, $file, $type)
    {
        if (empty($url) || empty($file))
        {
            return false;
        }
        $opts = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'content-type:'.$type,
                'content' => $file
            )
        );
        $context = stream_context_create($opts);
        $response = file_get_contents($url, false, $context);
        return $response;
    
    }
    
    // send email to some one
    public static function sendMail($to, $from, $subject, $body)
    {
        $post_body = json_encode(
            array(
                'from' => $from,
                'to' => $to,
                'subject' => $subject,
                'body' => $body
            )
            );
    
        $send_mail = "http://mobvoi-account/mail/mime?origin=developer.chumenwenwen.com";
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $send_mail);
    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($post_body))
            );
    
        ob_start();
        curl_exec($ch);
        $response_str = ob_get_contents();
        ob_end_clean();
    
        if(curl_error($ch))
        {
            Yii::error('File: '. __FILE__ . ' line: ' . __LINE__ . ' Curl error: ' . curl_error($ch));
            $error_data = ["status"=>'error','message' => '服务不可用'];
            return json_encode($error_data);
        }
    
        $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    
        $response = json_decode($response_str, true);
        return $response_str;
    }
    
    
}
