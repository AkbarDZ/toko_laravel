<?php
namespace App\Helpers;

class ImageHelper
{
    public static function uploadAndResize(
        $file,
        $directory,
        $fileName,
        $width = null,
        $height = null
    ) {
        $destinationPath = public_path($directory);
        
        // Pastikan direktori tujuan ada, jika belum buat foldernedy
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $extension = strtolower($file->getClientOriginalExtension());
        $image = null;

        // Tentukan metode pembuatan gambar berdasarkan ekstensi file
        switch ($extension) {
            case 'jpeg':
            case 'jpg':
                $image = imagecreatefromjpeg($file->getRealPath());
                break;
            case 'png':
                $image = imagecreatefrompng($file->getRealPath());
                break;
            case 'gif':
                $image = imagecreatefromgif($file->getRealPath());
                break;
            default:
                throw new \Exception('Unsupported image type');
        }

        // Resize gambar jika lebar diset
        if ($width) {
            $oldWidth = imagesx($image);
            $oldHeight = imagesy($image);
            $aspectRatio = $oldWidth / $oldHeight;

            if (!$height) {
                $height = $width / $aspectRatio; // Hitung tinggi dengan mempertahankan aspek rasio
            }

            // Pastikan nilai width dan height adalah integer
            $width = (int) $width;
            $height = (int) $height;

            $newImage = imagecreatetruecolor($width, $height);

            // FIX 1: Pertahankan transparansi untuk PNG dan GIF
            if ($extension === 'png' || $extension === 'gif') {
                // Matikan alpha blending agar pixel transparan disalin apa adanya
                imagealphablending($newImage, false);
                // Simpan informasi alpha channel
                imagesavealpha($newImage, true);
                // Buat warna transparan dan isi kanvas baru dengan warna tersebut
                $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
                imagefilledrectangle($newImage, 0, 0, $width, $height, $transparent);
            }

            imagecopyresampled(
                $newImage,
                $image,
                0,
                0,
                0,
                0,
                $width,
                $height,
                $oldWidth,
                $oldHeight
            );

            imagedestroy($image);
            $image = $newImage;
        } else {
            // FIX 2: Jika gambar tidak di-resize, tetap pastikan transparansi PNG terjaga sebelum di-save
            if ($extension === 'png') {
                imagealphablending($image, false);
                imagesavealpha($image, true);
            }
        }

        // Simpan gambar
        $fullPath = $destinationPath . '/' . $fileName;
        switch ($extension) {
            case 'jpeg':
            case 'jpg':
                // FIX 3: Tambahkan parameter kualitas 100 (0-100) untuk mencegah artefak kompresi JPEG
                imagejpeg($image, $fullPath, 100);
                break;
            case 'png':
                // Untuk PNG, parameter ke-3 adalah tingkat kompresi file (0-9). 
                // Karena PNG bersifat lossless, ini tidak akan menimbulkan artefak visual, hanya ukuran file.
                imagepng($image, $fullPath);
                break;
            case 'gif':
                imagegif($image, $fullPath);
                break;
        }

        imagedestroy($image);

        return $fileName;
    }
}