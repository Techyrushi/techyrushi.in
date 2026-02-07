<?php
/**
 * Image Resize Helper Function
 * Resizes and crops an image to fit exact dimensions while maintaining aspect ratio (center crop).
 * 
 * @param string $source_path Path to the uploaded file
 * @param string $target_path Path to save the resized image
 * @param int $width Target width
 * @param int $height Target height
 * @param int $quality JPEG quality (0-100)
 * @param string $mode 'crop' (fill dimensions) or 'fit' (resize within dimensions)
 * @return bool True on success, False on failure
 */
function resizeImage($source_path, $target_path, $width, $height, $quality = 90, $mode = 'crop') {
    list($src_width, $src_height, $type) = getimagesize($source_path);

    switch ($type) {
        case IMAGETYPE_JPEG:
            $image = imagecreatefromjpeg($source_path);
            break;
        case IMAGETYPE_PNG:
            $image = imagecreatefrompng($source_path);
            break;
        case IMAGETYPE_GIF:
            $image = imagecreatefromgif($source_path);
            break;
        case IMAGETYPE_WEBP:
            $image = imagecreatefromwebp($source_path);
            break;
        default:
            return false;
    }

    // Calculate aspect ratios
    $src_ratio = $src_width / $src_height;
    $target_ratio = $width / $height;

    if ($mode == 'crop') {
        // ... (Existing Crop Logic) ...
        if ($src_ratio > $target_ratio) {
            $crop_height = $src_height;
            $crop_width = $src_height * $target_ratio;
            $x_offset = ($src_width - $crop_width) / 2;
            $y_offset = 0;
        } else {
            $crop_width = $src_width;
            $crop_height = $src_width / $target_ratio;
            $x_offset = 0;
            $y_offset = ($src_height - $crop_height) / 2;
        }
        $new_width = $width;
        $new_height = $height;
    } else {
        // Fit Logic
        if ($src_width <= $width && $src_height <= $height) {
            // Image is smaller than target, just keep original
            $new_width = $src_width;
            $new_height = $src_height;
        } else {
            if ($src_ratio > $target_ratio) {
                // Width is limiting factor
                $new_width = $width;
                $new_height = $width / $src_ratio;
            } else {
                // Height is limiting factor
                $new_height = $height;
                $new_width = $height * $src_ratio;
            }
        }
        $x_offset = 0;
        $y_offset = 0;
        $crop_width = $src_width;
        $crop_height = $src_height;
    }

    // Create target image
    $new_image = imagecreatetruecolor($new_width, $new_height);

    // Preserve transparency for PNG/WEBP/GIF
    if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_WEBP || $type == IMAGETYPE_GIF) {
        imagecolortransparent($new_image, imagecolorallocatealpha($new_image, 0, 0, 0, 127));
        imagealphablending($new_image, false);
        imagesavealpha($new_image, true);
    }

    // Resample
    imagecopyresampled(
        $new_image, 
        $image, 
        0, 0, 
        $x_offset, $y_offset, 
        $new_width, $new_height, 
        $crop_width, $crop_height
    );

    // Save
    $result = false;
    $ext = strtolower(pathinfo($target_path, PATHINFO_EXTENSION));
    
    switch ($ext) {
        case 'jpg':
        case 'jpeg':
            $result = imagejpeg($new_image, $target_path, $quality);
            break;
        case 'png':
            $result = imagepng($new_image, $target_path, 9);
            break;
        case 'gif':
            $result = imagegif($new_image, $target_path);
            break;
        case 'webp':
            $result = imagewebp($new_image, $target_path, $quality);
            break;
        default:
            $result = imagejpeg($new_image, $target_path, $quality);
    }

    imagedestroy($image);
    imagedestroy($new_image);

    return $result;
}
?>