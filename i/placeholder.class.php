<?php
if (strpos(__FILE__, $_SERVER['PHP_SELF'])) { header('HTTP/1.0 403 Forbidden'); exit; }
/**
 * Creates temporary placeholder images
 *
 * @package Placeholder
 * @version 1.1.0
 * @link http://github.com/img-src/placeholder
 */
class Placeholder {
    private $backgroundColor, $cache, $cacheDir, $expires, $font, $height, $maxHeight, $maxWidth, $textColor, $width;

    function __construct() {
        $this->backgroundColor = 'dddddd';
        $this->cache           = false;
        $this->cacheDir        = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'cache';
        $this->expires         = 604800;
        $this->font            = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Oswald-Regular.ttf';
        $this->maxHeight       = 2000;
        $this->maxWidth        = 2000;
        $this->textColor       = '000000';
    }

    /**
     * Sets background color
     * 
     * @param string $hex - hex code value
     */
    function setBackgroundColor($hex) {
        if (strlen($hex) === 3 || strlen($hex) === 6) {
            if (preg_match('/^[a-f0-9]{3}$|^[a-f0-9]{6}$/i', $hex)) {
                $this->backgroundColor = $hex;
            } else {
                throw new InvalidArgumentException('Background color must be a valid RGB hex code.');
            }
        } else {
            throw new InvalidArgumentException('Background color must be 3 or 6 character hex code.');
        }
    }

    /**
     * Sets text color
     * 
     * @param string $hex - hex code value
     */
    function setTextColor($hex) {
        if (strlen($hex) === 3 || strlen($hex) === 6) {
            if (preg_match('/^[a-f0-9]{3}$|^[a-f0-9]{6}$/i', $hex)) {
                $this->textColor = $hex;
            } else {
                throw new InvalidArgumentException('Text color must be a valid RGB hex code.');
            }
        } else {
            throw new InvalidArgumentException('Text color must be 3 or 6 character hex code.');
        }
    }

    /**
     * Sets location of TTF font
     * 
     * @param string $fontPath - location of TTF font
     */
    function setFont($fontPath) {
        if (is_readable($fontPath)) {
            $this->font = $fontPath;
        } else {
            throw new Exception('Font file must exist and be readable by web server.');
        }
    }

    /**
     * Set expires header value
     * 
     * @param int $expires - seconds used in expires HTTP header 
     */
    function setExpires($expires) {
        if (preg_match('/^\d+$/', $expires)) {
            $this->expires = $expires;
        } else {
            throw new InvalidArgumentException('Expires must be an integer.');
        }
    }

    /**
     * Set maximum width allowed for placeholder image
     * 
     * @param int $maxWidth - maximum width 
     */
    function setMaxWidth($maxWidth) {
        if (preg_match('/^\d+$/', $maxWidth)) {
            $this->maxWidth = $maxWidth;
        } else {
            throw new InvalidArgumentException('Maximum width must be an integer.');
        }
    }

    /**
     * Set maximum height allowed for placeholder image
     * 
     * @param int $maxHeight - maximum height 
     */
    function setMaxHeight($maxHeight) {
        if (preg_match('/^\d+$/', $maxHeight)) {
            $this->maxHeight = $maxHeight;
        } else {
            throw new InvalidArgumentException('Maximum height must be an integer.');
        }
    }

    /**
     * Enable or disable cache
     * 
     * @param bool $cache - whether or not to use cache
     */
    function setCache($cache) {
        if (is_bool($cache)) {
            $this->cache = $cache;
        } else {
            throw new InvalidArgumentException('setCache expects a boolean value.');
        }
    }

    /**
     * Sets caching path
     * 
     * @param string $cacheDir - path to cache folder, must be writable by web server
     */
    function setCacheDir($cacheDir) {
        if (is_dir($cacheDir)) {
            $this->cacheDir = $cacheDir;
        } else {
            throw new InvalidArgumentException('setCacheDir expects a directory.');
        }
    }

    /**
     * Set width of image to render
     * 
     * @param int $width - width of image
     */
    function setWidth($width) {
        if (preg_match('/^\d+$/', $width)) {
            if ($width > 0) {
                $this->width = $width;
            } else {
                throw new InvalidArgumentException('Width must be greater than zero.');
            }
        } else {
            throw new InvalidArgumentException('Width must be an integer.');
        }
    }

    /**
     * Set height of image to render
     * 
     * @param int $height - height of image
     */
    function setHeight($height) {
        if (preg_match('/^\d+$/', $height)) {
            if ($height > 0) {
                $this->height = $height;
            } else {
                throw new InvalidArgumentException('Height must be greater than zero.');
            }
        } else {
            throw new InvalidArgumentException('Height must be an integer.');
        }
    }

    /**
     * Display image and cache (if enabled)
     */
    function render() {
        if ($this->width <= $this->maxWidth && $this->height <= $this->maxHeight) {
            $cachePath = $this->cacheDir . '/' . $this->width . '_' . $this->height . '_' . (strlen($this->backgroundColor) === 3 ? $this->backgroundColor[0] . $this->backgroundColor[0] . $this->backgroundColor[1] . $this->backgroundColor[1] . $this->backgroundColor[2] . $this->backgroundColor[2] : $this->backgroundColor) . '_' . (strlen($this->textColor) === 3 ? $this->textColor[0] . $this->textColor[0] . $this->textColor[1] . $this->textColor[1] . $this->textColor[2] . $this->textColor[2] : $this->textColor) . '.png';
            header('Content-type: image/png');
            header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + $this->expires));
            header('Cache-Control: public');
            if ($this->cache === true && is_readable($cachePath)) {
                // send header identifying cache hit & send cached image
                header('img-src-cache: hit');
                print file_get_contents($cachePath);
            } else {
                // cache disabled or no cached copy exists
                // send header identifying cache miss if cache enabled
                if ($this->cache === true) header('img-src-cache: miss');
                $image = imagecreate($this->width, $this->height);
                // convert backgroundColor hex to RGB values
                list($bgR, $bgG, $bgB) = $this->hexToDec($this->backgroundColor);
                $backgroundColor = imagecolorallocate($image, $bgR, $bgG, $bgB);
                // convert textColor hex to RGB values
                list($textR, $textG, $textB) = $this->hexToDec($this->textColor);
                $textColor = imagecolorallocate($image, $textR, $textG, $textB);
                $text = $this->width . 'x' . $this->height;
                imagefilledrectangle($image, 0, 0, $this->width, $this->height, $backgroundColor);
                $fontSize = 26;
                $textBoundingBox = imagettfbbox($fontSize, 0, $this->font, $text);
                // decrease the default font size until it fits nicely within the image
                while (((($this->width - ($textBoundingBox[2] - $textBoundingBox[0])) < 10) || (($this->height - ($textBoundingBox[1] - $textBoundingBox[7])) < 10)) && ($fontSize > 1)) {
                    $fontSize--;
                    $textBoundingBox = imagettfbbox($fontSize, 0, $this->font, $text);
                }
                imagettftext($image, $fontSize, 0, ($this->width / 2) - (($textBoundingBox[2] - $textBoundingBox[0]) / 2), ($this->height / 2) + (($textBoundingBox[1] - $textBoundingBox[7]) / 2), $textColor, $this->font, $text);
                imagepng($image);
                // write cache
                if ($this->cache === true && is_writable($this->cacheDir)) {
                    imagepng($image, $cachePath);
                }
                imagedestroy($image);
            }
        } else {
            throw new Exception('Placeholder size may not exceed ' . $this->maxWidth . 'x' . $this->maxHeight . ' pixels.');
        }
    }

    /**
     * Convert hex code to array of RGB decimal values
     * 
     * @param string $hex - hex code to convert to dec
     */
     private function hexToDec($hex) {
        if (strlen($hex) === 3) {
            $rgbArray = array(hexdec($hex[0] . $hex[0]), hexdec($hex[1] . $hex[1]), hexdec($hex[2] . $hex[2]));
        } else if (strlen($hex) === 6) {
            $rgbArray = array(hexdec($hex[0] . $hex[1]), hexdec($hex[2] . $hex[3]), hexdec($hex[4] . $hex[5]));
        } else {
            throw new Exception('Could not convert hex value to decimal.');
        }
        return $rgbArray;
     }
}
