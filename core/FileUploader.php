<?php
namespace core;

use Ramsey\Uuid\Uuid;

class FileUploader {
    private $file;
    private $file_data;
    private $file_destination;
    private $new_files = [];

    public function __construct($file) {
        $this->file = $file;
        $this->file_data = $file['tmp_name'];
    }

    public function save_in($folder) {
        $this->file_destination = rtrim($folder, '/') . '/';
    }

    private function generateUniqueFilename($originalFilename) {
        $originalExtension = pathinfo($originalFilename, PATHINFO_EXTENSION);
        $uniqueFilename = Uuid::uuid4()->toString() . '.' . $originalExtension;

        return $uniqueFilename;
    }

    public function save() {
        $uniqueFilename = $this->generateUniqueFilename($this->file['name']);
        $name = $this->file_destination . $uniqueFilename;
        $success = move_uploaded_file($this->file_data, $name);

        if ($success) {
            $currentDateTime = new \DateTime("now", new \DateTimeZone('Africa/Nairobi')); // Set your timezone
            $fileInfo = [
                'id' => Uuid::uuid4()->toString(),
                'original_name' => $this->file['name'],
                'unique_name' => $uniqueFilename,
                'size' => $this->file['size'],
                'type' => $this->file['type'],
                'url' => $name, // This should be a relative path
                'date_added' => $currentDateTime->format('Y-m-d'),
                'time_added' => $currentDateTime->format('H:i:s')
            ];
            $this->new_files[] = $fileInfo;
            return $fileInfo;
        } else {
            return false;
        }
    }

    public function get_file_info() {
        return $this->new_files;
    }
}
