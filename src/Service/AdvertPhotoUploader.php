<?php
namespace App\Service;


use App\Form\PhotoGalleryType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AdvertPhotoUploader
{

    private $advertImagesPath;

    /**
     * AdvertPhotoUploader constructor.
     * @param $advertImagesPath
     */
    public function __construct($advertImagesPath)
    {
        $this->advertImagesPath = $advertImagesPath;
    }


    public function uploadFilesFromForm(Form $galleryForm) {
        $photosForm = $galleryForm->get('photos');
        foreach ($photosForm as $photoForm) {
            /**
             * @var UploadedFile
             */
            $imageFile = $photoForm->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->advertImagesPath,
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $photoForm->getData()->setUrl($newFilename);
                $photoForm->getData()->setGallery($galleryForm->getData());
            }
        }
    }

}
