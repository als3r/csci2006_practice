<?php

/**
 * Class Log
 *
 * Simple log class
 */
class Log
{
    /**
     * Path to default log file
     */
    public const DEFAULT_FILENAME_PATH = 'logs/log.txt';

    /**
     * Path to log file
     *
     * @var sting
     */
    public $filename_path = null;

    public function __construct($filename_path = ''){
        if(!empty($filename_path)){
            $this->setFilenamePath($filename_path);
        }
        $this->setFilenamePath(self::DEFAULT_FILENAME_PATH);
    }

    /**
     * Log constructor.
     * @param string $message
     */
    public function write($message = '')
    {
        $logFile = fopen($this->getFilenamePath(), "a") or die('Unable to open log file!');
        fwrite($logFile, $message . PHP_EOL);
        fclose($logFile);
    }

    /**
     * Get log's filename path
     *
     * @return mixed
     */
    public function getFilenamePath()
    {
        return $this->filename_path;
    }

    /**
     * Set log's filename path
     *
     * @param mixed $filename_path
     */
    public function setFilenamePath($filename_path)
    {
        $this->filename_path = $filename_path;
    }


}
