<?php

namespace FlexPress\Components\ImageSize;

class Helper
{

    /**
     * Holds the image sizes
     *
     * @var \SplObjectStorage
     */
    protected $sizes;

    /**
     * @param \SplObjectStorage $sizes
     * @param array $sizesArray
     * @throws \RuntimeException
     */
    public function __construct(\SplObjectStorage $sizes, array $sizesArray)
    {

        $this->sizes = $sizes;

        if (!empty($sizesArray)) {

            foreach ($sizesArray as $size) {

                if (!$size instanceof AbstractImageSize) {

                    $message = "One or more of the image sizes you have passed to ";
                    $message .= get_class($this);
                    $message .= " does not implement the AbstractImageSize interface.";

                    throw new \RuntimeException($message);

                }

                if (!is_string($size->getName())
                    || !is_int($size->getHeight())
                    || !is_int($size->getWidth())
                ) {

                    $message = "One or more of the image sizes you have passed to ";
                    $message .= get_class($this);
                    $message .= " is not valid, please make sure that you have passed a string value for it's name ";
                    $message .= "and a integer for both it's height and width.";

                    throw new \RuntimeException($message);

                }

                $this->sizes->attach($size);

            }

        }

        add_filter('image_size_names_choose', array($this, 'imageSizeNamesChoose'));

    }

    /**
     *
     * Used to expose images to the cms area
     *
     * @author Tim Perry
     *
     */
    public function imageSizeNamesChoose($sizes)
    {
        $this->sizes->rewind();
        while ($this->sizes->valid()) {

            $imageSize = $this->sizes->current();

            if ($imageSize->shouldShowInCMS()) {
                $sizes[$imageSize->getName()] = __($imageSize->getName());
            }

            $this->sizes->next();

        }

        return $sizes;

    }

    /**
     *
     * Registers all the image sizes added
     *
     * @author Tim Perry
     *
     */
    public function registerImageSizes()
    {

        $this->sizes->rewind();
        while ($this->sizes->valid()) {

            $imageSize = $this->sizes->current();
            add_image_size(
                $imageSize->getName(),
                $imageSize->getWidth(),
                $imageSize->getHeight(),
                $imageSize->getCrop()
            );
            $this->sizes->next();

        }

    }
}
