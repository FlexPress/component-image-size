<?php

namespace FlexPress\Components\ImageSize;

abstract class AbstractImageSize
{

    /**
     *
     * Returns if the image should crop to the specified size
     *
     * @return mixed
     * @author Tim Perry
     *
     */
    public function getCrop()
    {
        return true;
    }

    /**
     *
     * Returns if the image should be shown in the cms for
     * users to select
     *
     * @return mixed
     * @author Tim Perry
     *
     */
    public function shouldShowInCMS()
    {
        return true;
    }

    /**
     *
     * Returns the name for the image size
     *
     * @return mixed
     * @author Tim Perry
     *
     */
    abstract public function getName();

    /**
     *
     * Returns the height of the image size
     *
     * @return mixed
     * @author Tim Perry
     *
     */
    abstract public function getHeight();

    /**
     *
     * Returns the width of the image size
     *
     * @return mixed
     * @author Tim Perry
     *
     */
    abstract public function getWidth();
}
