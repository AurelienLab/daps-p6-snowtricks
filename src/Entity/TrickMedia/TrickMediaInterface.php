<?php

namespace App\Entity\TrickMedia;

interface TrickMediaInterface
{


    /**
     * Get the display template path for the media type
     *
     * @return string
     */
    public function getTemplate(): string;


}
