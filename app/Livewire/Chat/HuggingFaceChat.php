<?php

namespace App\Livewire\Chat;
use Illuminate\Support\Facades\Http;

use Livewire\Component;

class HuggingFaceChat extends Component
{
    public $message = ''; // Pesan yang dikirim oleh user
    public $response = ''; // Menyimpan respons dari API
    public $loading = false; // Menandakan status loading

    // Method untuk mengirim pesan dan mendapatkan respon dari API
    public function getChatCompletion()
    {
        $this->loading = true;

        // API URL dan API Key
        $apiUrl = env('HUGGINGFACE_API_URL');
        $apiKey = env('HUGGINGFACE_API_KEY');

        // Payload data yang akan dikirim ke API
        $payload = [
            'model' => 'mistralai/Mixtral-8x7B-Instruct-v0.1',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $this->message,
                ],
            ],
            'max_tokens' => 500,
            'stream' => false,
        ];

        // Mengirim request API menggunakan HTTP Client
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])->post($apiUrl, $payload);

        // Periksa apakah respons berhasil
        if ($response->successful()) {
            $this->response = $response->json()['choices'][0]['message']['content'];
        } else {
            $this->response = 'Error: ' . $response->status();
        }

        $this->loading = false;
        $this->dispatch('ask-reload');
    }

    public function render()
    {
        return view('livewire.chat.hugging-face-chat');
    }
}
