<?php
// src/Service/FileUploader.php
namespace App\Classes;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileLoader
{
    private $targetDirectory;
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->targetDirectory =  'images_directory';
        $this->slugger = $slugger;
    }

        public function uploadLogo(UploadedFile $file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = 'logo'.$safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            // dd($this->getTargetDirectory());
            $file->move($this->getTargetDirectory(), $fileName);

        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
            echo "souci d importation";
        }

        return $fileName;
    }

    public function upload(UploadedFile $file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = 'photo'.$safeFilename.'-'.uniqid().'.'.$file->guessExtension();


        try {
            // dd($this->getTargetDirectory());
            $file->move($this->getTargetDirectory(), $fileName);

        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
            echo "souci d importation";
        }

        return $fileName;
    }

    public function uploadPdf(UploadedFile $file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = 'pdf'.$safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            // dd($this->getTargetDirectory());
            $file->move($this->getTargetDirectory(), $fileName);

        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
            echo "souci d importation";
        }

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}
?>