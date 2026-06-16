<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    protected string $token;
    protected string $adminNumber;
    protected string $apiUrl = 'https://api.fonnte.com/send';

    public function __construct()
    {
        $this->token       = config('services.fonnte.token');
        $this->adminNumber = config('services.fonnte.admin_number');
    }

    /**
     * Kirim pesan WA ke nomor tertentu
     */
    public function send(string $target, string $message): bool
    {
        // Format nomor: hapus karakter non-digit, ubah 08xx → 628xx
        $target = preg_replace('/[^0-9]/', '', $target);
        if (str_starts_with($target, '0')) {
            $target = '62' . substr($target, 1);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post($this->apiUrl, [
                'target'  => $target,
                'message' => $message,
            ]);

            if (!$response->successful()) {
                Log::warning('Fonnte send failed', [
                    'target'   => $target,
                    'status'   => $response->status(),
                    'response' => $response->body(),
                ]);
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Fonnte exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Notifikasi ke admin: ada pesanan baru
     */
    public function notifyAdmin(\App\Models\Pesanan $pesanan): void
    {
        $items = $pesanan->items->map(function ($item) {
            return "- {$item->varian->produk->nama} {$item->varian->ukuran} ×{$item->qty} = Rp " .
                   number_format($item->subtotal, 0, ',', '.');
        })->join("\n");

        $total = number_format($pesanan->items->sum('subtotal'), 0, ',', '.');
        $orderId = '#MW-' . str_pad($pesanan->id, 4, '0', STR_PAD_LEFT);

        $message = "🔔 *PESANAN BARU MASUK*\n\n"
                 . "Order ID : {$orderId}\n"
                 . "Nama     : {$pesanan->nama_pemesan}\n"
                 . "No HP    : {$pesanan->nomor_hp}\n"
                 . "Alamat   : {$pesanan->alamat}\n\n"
                 . "*Detail Pesanan:*\n{$items}\n\n"
                 . "*Total: Rp {$total}*\n\n"
                 . "Silakan cek dashboard untuk konfirmasi:\n"
                 . config('app.url') . "/dashboard";

        $this->send($this->adminNumber, $message);
    }

    /**
     * Konfirmasi ke customer: pesanan diterima
     */
    public function confirmToCustomer(\App\Models\Pesanan $pesanan): void
    {
        $items = $pesanan->items->map(function ($item) {
            return "- {$item->varian->produk->nama} {$item->varian->ukuran} ×{$item->qty} = Rp " .
                   number_format($item->subtotal, 0, ',', '.');
        })->join("\n");

        $total   = number_format($pesanan->items->sum('subtotal'), 0, ',', '.');
        $orderId = '#MW-' . str_pad($pesanan->id, 4, '0', STR_PAD_LEFT);

        $message = "Halo *{$pesanan->nama_pemesan}* 👋\n\n"
                 . "Terima kasih telah memesan di *Milkyway Susu Kambing*\n\n"
                 . "Pesanan Anda telah kami terima:\n\n"
                 . "Order ID : {$orderId}\n"
                 . "Alamat   : {$pesanan->alamat}\n\n"
                 . "*Detail Pesanan:*\n{$items}\n\n"
                 . "*Total: Rp {$total}*\n\n"
                 . "Kami akan segera memproses pesanan Anda. "
                 . "Harap tunggu konfirmasi selanjutnya dari kami ya 😊";

        $this->send($pesanan->nomor_hp, $message);
    }
}
