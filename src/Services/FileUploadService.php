<?php

namespace Services;

class FileUploadService
{
    public function upload(array $file, string $directory, array $allowedMimeTypes, int $maxSize): array
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => $this->uploadErrorMessage($file['error'])];
        }

        if ($file['size'] > $maxSize) {
            $maxMB = round($maxSize / 1024 / 1024, 1);
            return ['success' => false, 'error' => __('validation.file_too_large', [$maxMB . 'MB'])];
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);

        if (!in_array($mimeType, $allowedMimeTypes, true)) {
            return ['success' => false, 'error' => __('validation.invalid_type')];
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        $filename = uniqid() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;

        $targetDir = BASE_PATH . '/public/uploads/' . trim($directory, '/') . '/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $targetPath = $targetDir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            return ['success' => false, 'error' => 'Upload failed. Please try again.'];
        }

        $relativePath = trim($directory, '/') . '/' . $filename;

        return ['success' => true, 'path' => $relativePath, 'filename' => $filename];
    }

    public function deleteFile(string $relativePath): bool
    {
        $fullPath = BASE_PATH . '/public/uploads/' . ltrim($relativePath, '/');

        if (file_exists($fullPath) && is_file($fullPath)) {
            return unlink($fullPath);
        }

        return false;
    }

    private function uploadErrorMessage(int $error): string
    {
        $messages = [
            UPLOAD_ERR_INI_SIZE   => 'File exceeds server upload limit.',
            UPLOAD_ERR_FORM_SIZE  => 'File exceeds form upload limit.',
            UPLOAD_ERR_PARTIAL    => 'File was only partially uploaded.',
            UPLOAD_ERR_NO_FILE    => 'No file was uploaded.',
            UPLOAD_ERR_NO_TMP_DIR => 'Server missing temporary folder.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
            UPLOAD_ERR_EXTENSION  => 'Upload stopped by a PHP extension.',
        ];

        return $messages[$error] ?? 'Unknown upload error.';
    }
}
