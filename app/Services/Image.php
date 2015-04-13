<?php namespace App\Services;

use Illuminate\Filesystem\Filesystem;
use Config, File, Log;

class Image {

	/**
	 * Instance of the Imagine package
	 * @var Image\Gd\Imagine
	 */
	protected $imagine;

	/**
	 * Type of library used by the service
	 * @var string
	 */
	protected $library;


	/**
	 * Initialize the image service
	 * @return void
	 */
	public function __construct()
	{
		if (!$this->imagine)
		{
			$this->library = Config::get('image.library', 'gd');

			if ( ! $this->library and class_exists('Imagick')) $this->library = 'imagick';
			else $this->library = 'gd';

			if ($this->library == 'imagick') $this->imagine = new \Imagine\Imagick\Imagine();
			elseif ($this->library == 'gmagick') $this->imagine = new \Imagine\Gmagick\Imagine();
			elseif ($this->library == 'gd')      $this->imagine = new \Imagine\Gd\Imagine();
			else   															 $this->imagine = new \Imagine\Gd\Imagine();
		}
	}

	/**
	 * Resize an image
	 * @param string $url
	 * @param integer $width
	 * @param integer $height
	 * @param boolean $crop
	 * @return string
	 */
    public function resize($url, $width = 100, $height = null, $crop = false, $quality = null, $targetDir = null)
		{
      if ($url)
      {
				// URL info
        $info = pathinfo($url);

				// The size
        if ( ! $height) $height = $width;

				// Quality e overwrite
        $quality   = Config::get('image.quality',   90);
				$overwrite = Config::get('image.overwrite', false);

				// Directories and file names
        $fileName       = $info['basename'];
        $sourceDirPath  = public_path() . $info['dirname'];
        $sourceFilePath = $sourceDirPath . '/' . $fileName;
        $targetDirName  = ($crop ? $targetDir . '_crop' : $targetDir);
        $targetDirPath  = $sourceDirPath . '/' . $targetDirName . '/';
        $targetFilePath = $targetDirPath . $fileName;
        $targetUrl      = asset($info['dirname'] . '/' . $targetDirName . '/' . $fileName);

        try
        {
          if ( ! File::isDirectory($targetDirPath) and $targetDirPath) @File::makeDirectory($targetDirPath);

          $size = new \Imagine\Image\Box($width, $height);

          $mode = $crop ? \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND : \Imagine\Image\ImageInterface::THUMBNAIL_INSET;

          if ($overwrite or ! File::exists($targetFilePath) or (File::lastModified($targetFilePath) < File::lastModified($sourceFilePath)))
          {
              $this->imagine->open($sourceFilePath)
                            ->thumbnail($size, $mode)
                            ->save($targetFilePath, array('quality' => $quality));
          }
        }
        catch (\Exception $e)
        {
          Log::error('[IMAGE SERVICE] Failed to resize image &quot;' . $url . '&quot; [' . $e->getMessage() . ']');
        }

        return $targetUrl;
      }
    }

	/**
	 * Helper for creating thumbs
	 * @param string $url
	 * @param integer @width
	 * @param integer @height
	 * @return string
	 */
    public function thumb($url, $width, $height = null)
    {
    	return $this->resize($url, $width, $height, true);
    }

	/**
	 * Upload an image to the public storage
	 * @param File $file
	 * @return string
	 */
    public function upload($file, $dir = null, $createDimensions = false, $dimensions = [])
    {
      if ($file)
      {
        // Generate random dir
        if ( ! $dir) $dir = str_random(8);

        // Get file info and try to move
        $destination = Config::get('image.upload_path') . $dir;
        $filename 	 = hash('sha256', uniqid()) . $file->getClientOriginalName();
        $path        = Config::get('image.upload_dir') . '/' . $dir . '/' . $filename;
        $uploaded    = $file->move($destination, $filename);

        if ($uploaded)
				{
					if ($createDimensions) $this->createDimensions($path, $dimensions);

					return $filename;
				}

				return false;
      }
    }

    public function download($url, $dir = null, $createDimensions = false, $dimensions = [])
    {
    	if(!$url) return false;

    	$file = file_get_contents($url);
    	$ext = pathinfo($url, PATHINFO_EXTENSION);
    	$tmp_file = storage_path() . '/download-' . str_random(8) . '.' . $ext;

    	$fp = fopen($tmp_file, 'w');
    	fwrite($fp, $file);
    	fclose($fp);

    	$fs = new Filesystem;

      $filename 	 = hash('sha256', uniqid()).'.png';
    	$destination = Config::get('image.upload_path') . $dir . '/' . $filename;
     	$path        = Config::get('image.upload_dir') . '/' . $dir . '/' . $filename;
      $uploaded    = $fs->move($tmp_file, $destination);

      if ($uploaded)
			{
				if ($createDimensions) $this->createDimensions($path, $dimensions);

				return $filename;
			}

			return false;
    }

	/**
	 * Creates image dimensions
	 * @param string $url
	 * @param array $dimensions
	 * @return void
	 */
	public function createDimensions($url, $dimensions = [])
	{
		// Use the dimensions or get the default dimensions
		$dimensions = empty($dimensions) ? Config::get('image.dimensions') : $dimensions;

		foreach ($dimensions as $key => $dimension)
		{
			// Get dimensions and quality
			$width    = (int) $dimension[0];
			$height   = isset($dimension[1]) ? (int)  $dimension[1] : $width;
			$crop     = isset($dimension[2]) ? (bool) $dimension[2] : false;
			$quality  = isset($dimension[3]) ? (int)  $dimension[3] : Config::get('image.quality');

			// Run resizer
			$img = $this->resize($url, $width, $height, $crop, $quality, $key);
		}
	}
}
