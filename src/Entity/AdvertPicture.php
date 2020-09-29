<?php


namespace App\Entity;


class AdvertPicture
{
    private string $fileLink;

    /**
     * AdvertPicture constructor.
     * @param string $fileLink
     */
    public function __construct(string $fileLink)
    {
        $this->fileLink = $fileLink;
    }

    /**
     * @return string
     */
    public function getFileLink(): string
    {
        return $this->fileLink;
    }

    /**
     * @param string $fileLink
     */
    public function setFileLink(string $fileLink): void
    {
        $this->fileLink = $fileLink;
    }




}