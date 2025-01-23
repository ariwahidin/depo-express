<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use function Illuminate\Log\log;

class GenerateOrderCsvFile
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $order = $event->order;
        $filePath = "orders/order_email.csv";
        $fileContent = "Name,Email\n";
        $fileContent .= "{$order['name']},{$order['email']}\n";
        Storage::disk('local')->put($filePath, $fileContent);

        $this->uploadToSftp($filePath);
    }

    private function uploadToSftp($filePath)
    {

        Storage::put('tesst.txt', 'Hello, World!');

        die;
        // dd(Storage::disk('sftp')->list('sftp://root@localhost:22/data1'));

        if (Storage::disk('sftp')->exists('/')) {
            // echo "Connected to SFTP server successfully.";
            dd("Connected to SFTP server successfully.");
        } else {
            // echo "Failed to connect to SFTP server.";
            dd("Failed to connect to SFTP server.");
        }

        return;

        // Konfigurasi SFTP
        $sftpDisk = Storage::disk('sftp');
        $localFilePath = storage_path("app/private/{$filePath}");

        // dd($filePath);

        // Upload file ke SFTP


        try {
            $sftpDisk->put('data1/'.$filePath, file_get_contents($localFilePath));
            Log::alert('File uploaded to SFTP successfully');
        } catch (\Exception $e) {
            echo "Gagal mengupload file ke SFTP: " . $e->getMessage() . "\n";
            Log::error('Error uploading file to SFTP: ' . $e->getMessage());
        }
        // if (file_exists($localFilePath)) {
        //     $sftpDisk->put($filePath, file_get_contents($localFilePath));
        // }
    }
}
