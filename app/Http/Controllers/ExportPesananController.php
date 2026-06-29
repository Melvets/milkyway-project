<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;

class ExportPesananController extends Controller
{
    public function export(Request $request)
    {
        $query = Pesanan::with('items.varian.produk')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pesanans = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Pesanan');

        // ── Judul laporan ────────────────────────────
        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue('A1', 'LAPORAN DATA PESANAN — MILKYWAY');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FF030460']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(28);

        $sheet->mergeCells('A2:H2');
        $filterLabel = $request->filled('status') ? 'Status: ' . $request->status : 'Semua Pesanan';
        $sheet->setCellValue('A2', 'Dicetak: ' . now()->format('d/m/Y H:i') . '   |   ' . $filterLabel);
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['size' => 10, 'color' => ['argb' => 'FF4a5e7a']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(18);

        // Baris kosong
        $sheet->getRowDimension(3)->setRowHeight(8);

        // ── Header kolom ────────────────────────────
        $headers = ['Order ID', 'Nama Pemesan', 'Nomor HP', 'Alamat', 'Detail Pesanan', 'Total (Rp)', 'Status', 'Tanggal Pesan'];
        $cols    = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];

        foreach ($headers as $i => $header) {
            $cell = $cols[$i] . '4';
            $sheet->setCellValue($cell, $header);
        }

        $sheet->getStyle('A4:H4')->applyFromArray([
            'font' => ['bold' => true, 'size' => 11, 'color' => ['argb' => 'FFFFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF0096C8']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFC8F3FA']],
            ],
        ]);
        $sheet->getRowDimension(4)->setRowHeight(22);

        // ── Data rows ────────────────────────────────
        $row = 5;
        foreach ($pesanans as $p) {
            $detail = $p->items->map(function ($item) {
                $nama   = $item->varian?->produk?->nama ?? '[Produk dihapus]';
                $ukuran = $item->varian?->ukuran ?? '';
                return trim("{$nama} {$ukuran}") . " x{$item->qty}";
            })->join("\n");

            $total = $p->items->sum('subtotal');

            $sheet->setCellValue("A{$row}", '#MW-' . str_pad($p->id, 4, '0', STR_PAD_LEFT));
            $sheet->setCellValue("B{$row}", $p->nama_pemesan);
            $sheet->setCellValue("C{$row}", $p->nomor_hp);
            $sheet->setCellValue("D{$row}", $p->alamat);
            $sheet->setCellValue("E{$row}", $detail);
            $sheet->setCellValue("F{$row}", $total);
            $sheet->setCellValue("G{$row}", $p->status);
            $sheet->setCellValue("H{$row}", $p->created_at->format('d/m/Y H:i'));

            // Warna baris alternating
            $bgColor = ($row % 2 === 0) ? 'FFf8fdfe' : 'FFFFFFFF';
            $sheet->getStyle("A{$row}:H{$row}")->applyFromArray([
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $bgColor]],
                'font' => ['size' => 10],
                'alignment' => ['vertical' => Alignment::VERTICAL_TOP, 'wrapText' => true],
                'borders' => [
                    'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFe0f7fb']],
                ],
            ]);

            // Kolom Total — format angka + rata kanan
            $sheet->getStyle("F{$row}")->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle("F{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

            // Warna badge status
            $statusColor = match ($p->status) {
                'Pending'  => 'FFb37a00',
                'Diproses' => 'FF0096C8',
                'Selesai'  => 'FF2e9c4e',
                default    => 'FF4a5e7a',
            };
            $sheet->getStyle("G{$row}")->applyFromArray([
                'font' => ['bold' => true, 'color' => ['argb' => $statusColor]],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);

            // Rata tengah kolom tertentu
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("H{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->getRowDimension($row)->setRowHeight(-1); // auto height

            $row++;
        }

        // ── Border keseluruhan tabel ─────────────────
        $lastRow = $row - 1;
        if ($lastRow >= 5) {
            $sheet->getStyle("A4:H{$lastRow}")->applyFromArray([
                'borders' => [
                    'outline' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['argb' => 'FF0096C8']],
                ],
            ]);
        }

        // ── Lebar kolom ─────────────────────────────
        $colWidths = ['A' => 14, 'B' => 22, 'C' => 18, 'D' => 30, 'E' => 36, 'F' => 16, 'G' => 12, 'H' => 18];
        foreach ($colWidths as $col => $width) {
            $sheet->getColumnDimension($col)->setWidth($width);
        }

        // ── Freeze panes ────────────────────────────
        $sheet->freezePane('A5');

        // ── Output ──────────────────────────────────
        $filename = 'pesanan_milkyway_' . now()->format('Ymd_His') . '.xlsx';

        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Cache-Control'       => 'max-age=0',
        ]);
    }
}
