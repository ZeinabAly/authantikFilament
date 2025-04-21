<?php
namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageStockageService {
    protected $tableName; 
   
    private function ensureDirectoryExist($tableName){
        $paths = [
            public_path('uploads/'.$tableName),
            public_path('uploads/'.$tableName. '/thumbnails'),
        ];

        foreach($paths as $path){
            if(!File::exists($path)){
                File::makeDirectory($path, 0755, true);
            }
        }

    }

    public function handleImage($tableName, $image){
        
        try {
            $this->ensureDirectoryExist($tableName);

            $timestamp = Carbon::now()->timestamp;
       
            $imageName = "{$timestamp}.{$image->getClientOriginalExtension()}";

            // $this->generateImages($tableName, $image, $imageName, $dimensions);

            return $imageName;

        } catch (\Exception $e) {
            \Log::error('Erreur lors du traiment de l\'image : '. $e->getMessage());
            throw $e;
        }

    }

    public function generateImages($tableName, $image, $dimensions = [124, 124]){

        $manager = new ImageManager(new Driver());

        $timestamp = Carbon::now()->timestamp;
        $imageName = "{$timestamp}.{$image->getClientOriginalExtension()}";


        $destinationPath = public_path("uploads/{$tableName}");
        $img = $manager->read($image->getRealPath());
        $img->cover($dimensions[0], $dimensions[1])
            ->toWebp()
            ->save($destinationPath.'/'.$imageName);

            
        return $imageName;
    }

    public function generateThumbnailsImages($tableName, $image){

        $manager = new ImageManager(new Driver());

        $imageName = $this->handleImage($tableName, $image);

        $destinationPathThumbnail = public_path("uploads/{$tableName}/thumbnails");
        $img = $manager->read($image->getRealPath());
        $img->cover(600, 600)
            ->toWebp()
            ->save($destinationPathThumbnail.'/'.$imageName);
    }

    public function galleryImages($tableName, $images){

        $gallery_arr = [];
        // $gallery_images = "";
        $allowFileExtension = ['jpg', 'png', 'jpeg', 'webp'];
         
        foreach($images as $image){
            $extension = $image->getClientOriginalExtension();
             
            if (in_array($extension, $allowFileExtension)) {
                $timestamp = Carbon::now()->timestamp;
                $fileName = "{$timestamp}.{$extension}";

                $this->generateImages($tableName, $image); 
                $galleryArr[] = $fileName;
            }
        }

        return implode(',', $galleryArr);

    }
    


    // private function generateImages($tableName, $image, $imageName, $dimensions)
    // {
        // $basePath = public_path("uploads/{$tableName}");
        // $thumbnails = "{$basePath}/thumbnails";
    
        // $img = Image::make($image->path());

        // // IMAGE PRINCIPALE
        // // $mainDimensions = $dimensions['main'] ?? [700, 700];
        // $mainDimensions = [600, 600];
        // $img->fit($mainDimensions[0], $mainDimensions[1])
        //     ->save("{$basePath}/{$imageName}");


        // //MINIATURE
        // // $thumbnailDimensions = $dimensions['thumbnail'] ?? [104, 104];
        // $thumbnailDimensions = [104, 104];
        // $img->fit($thumbnailDimensions[0], $thumbnailDimensions[1])
        //     ->save("{$thumbnailPath}/{$imageName}");
    // }
}