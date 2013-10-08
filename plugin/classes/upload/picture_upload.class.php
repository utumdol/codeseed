<?php
class PictureUpload extends ActiveUpload {

	//////////////////////////////////////////////////////////////////
	// init
	//////////////////////////////////////////////////////////////////

	/**
	 * @see ActiveUpload::$validate_types
	 */
	protected  $validate_types = array(
			'image/jpeg',
			'image/pjpeg',
			'image/png',
			'image/bmp',
			'image/gif'
	);

	protected $max_width = "800";	// max width pixel
	protected $max_height = "800";	// max height pixel
	protected $blur = 1;			// blur factor where > 1 is blurry, < 1 is sharp.

	//////////////////////////////////////////////////////////////////
	// public methods
	//////////////////////////////////////////////////////////////////

	/**
	 * @see ActiveUpload::save()
	 */
	public function save() {
		$this->make_upload_dir();
		$img = new Imagick();
		//$img->setFormat($this->get_extension()); // read image format
		$img->readImage($this->tmp_name);
		$img->setImageFormat($this->get_extension()); // output image format
		$img = self::upright($img);
		$img->stripImage(); // remove exif information
		if ($img->getimagewidth() > $this->max_width || $img->getimageheight() > $this->max_height) {
			$img->resizeImage($this->max_width, $this->max_height, Imagick::FILTER_LANCZOS, $this->blur, true);
		}
		$img->writeImage($this->get_path());
		$img->destroy();
	}

	//////////////////////////////////////////////////////////////////
	// private methods
	//////////////////////////////////////////////////////////////////

	/**
	 * upright picture if it has exif orientation data
	 */
	private function upright($img) {
		$exif = @exif_read_data($this->tmp_name);
		if ($exif === false || empty($exif)) {
			return $img;
		}
		$orientation = array_value($exif, array('Orientation'));
		switch($orientation) {
			case 3 :
			case 4 :
				$img->rotateImage(new ImagickPixel('none'), 180);
				break;
			case 5:
			case 6:
				$img->rotateImage(new ImagickPixel('none'), 90);
				break;
			case 7:
			case 8:
				$img->rotateImage(new ImagickPixel('none'), 270);
				break;
		}
		return $img;
	}
}

