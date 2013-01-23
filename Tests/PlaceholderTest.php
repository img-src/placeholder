<?php
class PlaceholderTest extends PHPUnit_Framework_TestCase
{
    protected $placeholder;

    public function setUp() {
        if ( ! class_exists('Placeholder')) {
            require dirname(__FILE__) . '/../i/placeholder.class.php';
        }
        $this->placeholder = new Placeholder();
    }

    public function tearDown() {
        unset($this->placeholder);
    }

    // Test if valid background color (full) is assigned
    public function testBackgroundColorValidSixHex()
    {
        $backgroundColor = '123456';
        $this->placeholder->setBackgroundColor($backgroundColor);
        $this->assertEquals($backgroundColor, $this->placeholder->getBackgroundColor());
    }

    // Test if valid background color (abbrev) is assigned
    public function testBackgroundColorValidThreeHex()
    {
        $backgroundColor = '325';
        $this->placeholder->setBackgroundColor($backgroundColor);
        $this->assertEquals($backgroundColor, $this->placeholder->getBackgroundColor());
    }

    // Test if invalid background hex color throws correct exception
    public function testBackgroundColorInvalidHex()
    {
        $this->setExpectedException('InvalidArgumentException', 'Background color must be a valid RGB hex code.');
        $backgroundColor = 'xxx343';
        $this->placeholder->setBackgroundColor($backgroundColor);
    }

    // Test if invalid background hex color throws correct exception
    public function testBackgroundColorInvalidFormat()
    {
        $this->setExpectedException('InvalidArgumentException', 'Background color must be 3 or 6 character hex code.');
        $backgroundColor = 'xxx34';
        $this->placeholder->setBackgroundColor($backgroundColor);
    }

    // Test if valid text color (full) is assigned
    public function testTextColorValidSixHex()
    {
        $textColor = '123456';
        $this->placeholder->setTextColor($textColor);
        $this->assertEquals($textColor, $this->placeholder->getTextColor());
    }

    // Test if valid text color (abbrev) is assigned
    public function testTextColorValidThreeHex()
    {
        $textColor = '325';
        $this->placeholder->setTextColor($textColor);
        $this->assertEquals($textColor, $this->placeholder->getTextColor());
    }

    // Test if invalid text hex color throws correct exception
    public function testTextColorInvalidHex()
    {
        $this->setExpectedException('InvalidArgumentException', 'Text color must be a valid RGB hex code.');
        $textColor = 'xxx343';
        $this->placeholder->setTextColor($textColor);
    }

    // Test if invalid text hex color throws correct exception
    public function testTextColorInvalidFormat()
    {
        $this->setExpectedException('InvalidArgumentException', 'Text color must be 3 or 6 character hex code.');
        $textColor = 'xxx34';
        $this->placeholder->setTextColor($textColor);
    }

    // Test if setting font with valid path will assign
    public function testValidFont()
    {
        $fontPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'i' . DIRECTORY_SEPARATOR . 'Oswald-Regular.ttf';
        $this->placeholder->setFont($fontPath);
        $this->assertEquals($fontPath, $this->placeholder->getFont());
    }

    // Test if setting font with valid path will assign
    public function testInvalidFont()
    {
        $this->setExpectedException('InvalidArgumentException', 'Font file must exist and be readable by web server.');
        $fontPath = './i-dont-exist.ttf';
        $this->placeholder->setFont($fontPath);
    }

    // Test if valid expires header is assigned
    public function testValidExpires()
    {
        $expires = 50000;
        $this->placeholder->setExpires($expires);
        $this->assertEquals($expires, $this->placeholder->getExpires());
    }

    // Test if invalid expires header throws correct exception
    public function testInvalidExpires()
    {
        $this->setExpectedException('InvalidArgumentException', 'Expires must be an integer.');
        $expires = '10 days';
        $this->placeholder->setExpires($expires);
    }

    // Test if valid max width is assigned
    public function testValidMaxWidth()
    {
        $maxWidth = 50000;
        $this->placeholder->setMaxWidth($maxWidth);
        $this->assertEquals($maxWidth, $this->placeholder->getMaxWidth());
    }

    // Test if invalid max width throws correct exception
    public function testInvalidMaxWidth()
    {
        $this->setExpectedException('InvalidArgumentException', 'Maximum width must be an integer.');
        $maxWidth = 'One million';
        $this->placeholder->setMaxWidth($maxWidth);
    }

    // Test if valid max height is assigned
    public function testValidMaxHeight()
    {
        $maxHeight = 50000;
        $this->placeholder->setMaxHeight($maxHeight);
        $this->assertEquals($maxHeight, $this->placeholder->getMaxHeight());
    }

    // Test if invalid max height throws correct exception
    public function testInvalidMaxHeight()
    {
        $this->setExpectedException('InvalidArgumentException', 'Maximum height must be an integer.');
        $maxHeight = 'One million';
        $this->placeholder->setMaxHeight($maxHeight);
    }

    // Test if valid cache bool is assigned
    public function testValidCache()
    {
        $cache = true;
        $this->placeholder->setCache($cache);
        $this->assertEquals($cache, $this->placeholder->getCache());
    }

    // Test if invalid cache bool throws correct exception
    public function testInvalidCache()
    {
        $this->setExpectedException('InvalidArgumentException', 'setCache expects a boolean value.');
        $cache = 1;
        $this->placeholder->setCache($cache);
    }

    // Test if valid cache directory is assigned
    public function testValidCacheDir()
    {
        $cacheDir = dirname(__FILE__);
        $this->placeholder->setCacheDir($cacheDir);
        $this->assertEquals($cacheDir, $this->placeholder->getCacheDir());
    }

    // Test if invalid cache directory throws correct exception
    public function testInvalidCacheDir()
    {
        $this->setExpectedException('InvalidArgumentException', 'setCacheDir expects a directory.');
        $cacheDir = __FILE__;
        $this->placeholder->setCacheDir($cacheDir);
    }

    // Test if valid width is assigned
    public function testValidWidth()
    {
        $width = 50000;
        $this->placeholder->setWidth($width);
        $this->assertEquals($width, $this->placeholder->getWidth());
    }

    // Test if invalid width throws correct exception
    public function testInvalidWidthFormat()
    {
        $this->setExpectedException('InvalidArgumentException', 'Width must be an integer.');
        $width = 'One million';
        $this->placeholder->setWidth($width);
    }

    // Test if invalid width throws correct exception
    public function testInvalidWidthZero()
    {
        $this->setExpectedException('InvalidArgumentException', 'Width must be greater than zero.');
        $width = 0;
        $this->placeholder->setWidth($width);
    }

    // Test if valid height is assigned
    public function testValidHeight()
    {
        $height = 50000;
        $this->placeholder->setHeight($height);
        $this->assertEquals($height, $this->placeholder->getHeight());
    }

    // Test if invalid height throws correct exception
    public function testInvalidHeightFormat()
    {
        $this->setExpectedException('InvalidArgumentException', 'Height must be an integer.');
        $height = 'One million';
        $this->placeholder->setHeight($height);
    }

    // Test if invalid height throws correct exception
    public function testInvalidHeightZero()
    {
        $this->setExpectedException('InvalidArgumentException', 'Height must be greater than zero.');
        $height = 0;
        $this->placeholder->setHeight($height);
    }

    // Test if image requested larger than max size throws correct error
    public function testRenderTooLarge()
    {
        $maxWidth = 400;
        $maxHeight = 600;
        $width = 500;
        $height = 900;
        $this->setExpectedException('RuntimeException', 'Placeholder size may not exceed ' . $maxWidth . 'x' . $maxHeight . ' pixels.');
        $this->placeholder->setMaxWidth($maxWidth);
        $this->placeholder->setMaxHeight($maxHeight);
        $this->placeholder->setWidth($width);
        $this->placeholder->setHeight($height);
        $this->placeholder->render();
    }

    // Test if valid image size returns correctly
    /**
     * @runInSeparateProcess
     */
    public function testRenderValid()
    {
        $maxWidth = 1000;
        $maxHeight = 1000;
        $width = 500;
        $height = 900;
        $this->placeholder->setMaxWidth($maxWidth);
        $this->placeholder->setMaxHeight($maxHeight);
        $this->placeholder->setWidth($width);
        $this->placeholder->setHeight($height);
        ob_start();
        $this->placeholder->render();
        $output = ob_get_contents();
        ob_clean();
        $tempFilename = '/tmp/phpunit.testImage.testRenderValid';
        file_put_contents($tempFilename, $output);
        $type = exif_imagetype($tempFilename);
        $this->assertEquals(IMAGETYPE_PNG, $type);
        $size = getimagesize($tempFilename);
        $this->assertEquals($size[0], $width);
        $this->assertEquals($size[1], $height);
        unlink($tempFilename);
    }
}
?>