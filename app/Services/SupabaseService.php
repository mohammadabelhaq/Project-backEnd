<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SupabaseService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = rtrim(env('SUPABASE_URL'), '/') . '/rest/v1';
        $this->apiKey = env('SUPABASE_KEY');
    }

    protected function headers()
    {
        return [
            'apikey' => $this->apiKey,
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ];
    }

    public function getAll($table)
    {
        return Http::withHeaders($this->headers())->get("{$this->baseUrl}/{$table}?select=*")->json();
    }

    public function getById($table, $id)
    {
        return Http::withHeaders($this->headers())->get("{$this->baseUrl}/{$table}?id=eq.{$id}")->json();
    }

    public function create($table, $data)
    {
        return Http::withHeaders($this->headers())->post("{$this->baseUrl}/{$table}", $data)->json();
    }

    public function update($table, $id, $data)
    {
        return Http::withHeaders($this->headers())
            ->patch("{$this->baseUrl}/{$table}?id=eq.{$id}", $data)
            ->json();
    }

    public function delete($table, $id)
    {
        return Http::withHeaders($this->headers())->delete("{$this->baseUrl}/{$table}?id=eq.{$id}")->json();
    }
}
