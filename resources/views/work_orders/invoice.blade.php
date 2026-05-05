<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $workOrder->wo_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body class="bg-slate-100 p-8 font-sans" onload="window.print()">

    <div class="max-w-4xl mx-auto bg-white p-10 shadow-sm border border-slate-200">

        {{-- Header Invoice --}}
        <div class="flex justify-between items-start border-b-2 border-slate-800 pb-6 mb-8">
            <div>
                <h1 class="text-4xl font-extrabold text-slate-900 tracking-tighter">INVOICE</h1>
                <p class="text-slate-500 mt-1 font-medium">#{{ $workOrder->wo_number }}</p>
            </div>
            <div class="text-right">
                <h2 class="text-xl font-bold text-slate-800">PT. Briliant Teknik Mandiri</h2>
                <p class="text-sm text-slate-500 mt-1">Jl. Operasional Bengkel No. 123<br>Kota Jakarta, Indonesia</p>
            </div>
        </div>

        {{-- Info Pelanggan & Tanggal --}}
        <div class="flex justify-between mb-8">
            <div>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-1">Ditagihkan Kepada:</p>
                <h3 class="text-lg font-bold text-slate-800">{{ $workOrder->customer->company_name }}</h3>
                <p class="text-sm text-slate-600">{{ $workOrder->customer->pic_name ?? '-' }}<br>{{ $workOrder->customer->phone ?? '-' }}</p>
            </div>
            <div class="text-right text-sm">
                <p><span class="font-bold text-slate-800">Tanggal Terbit:</span> {{ $workOrder->created_at->format('d M Y') }}</p>
                <p class="mt-1"><span class="font-bold text-slate-800">Status Pekerjaan:</span> <span class="uppercase">{{ $workOrder->status }}</span></p>
            </div>
        </div>

        {{-- Tabel Item Pekerjaan --}}
        <table class="w-full text-left mb-8 border-collapse">
            <thead>
                <tr class="bg-slate-800 text-white">
                    <th class="py-3 px-4 font-semibold text-sm uppercase tracking-wider">Deskripsi Pekerjaan</th>
                    <th class="py-3 px-4 font-semibold text-sm uppercase tracking-wider text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b border-slate-200">
                    <td class="py-4 px-4">
                        <p class="font-bold text-slate-800">{{ $workOrder->job_name }}</p>
                        <p class="text-sm text-slate-500 mt-1">{{ $workOrder->description ?? 'Tidak ada rincian.' }}</p>
                    </td>
                    <td class="py-4 px-4 text-right font-medium text-slate-800">
                        Rp {{ number_format($workOrder->total_cost, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Rincian Biaya --}}
        <div class="flex justify-end mb-12">
            <div class="w-1/2">
                <div class="flex justify-between py-2 text-sm text-slate-600">
                    <span>Subtotal Pekerjaan:</span>
                    <span>Rp {{ number_format($workOrder->total_cost, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-2 text-sm text-slate-600 border-b border-slate-200">
                    <span>Sudah Dibayar (DP):</span>
                    <span class="text-emerald-600">- Rp {{ number_format($workOrder->paid_amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-3 text-lg font-bold text-slate-800">
                    <span>Sisa Tagihan:</span>
                    <span>Rp {{ number_format($workOrder->total_cost - $workOrder->paid_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        {{-- Footer / Tanda Tangan --}}
        <div class="flex justify-between items-end mt-16 pt-8 border-t border-slate-200">
            <div class="text-sm text-slate-500">
                <p class="font-bold text-slate-800 mb-1">Catatan Pembayaran:</p>
                <p>Mohon lakukan transfer ke Rekening BCA: 1234567890<br>a.n PT Briliant Teknik Mandiri.</p>
            </div>
            <div class="text-center w-48">
                <p class="text-sm font-bold text-slate-800 mb-16">Hormat Kami,</p>
                <div class="border-b border-slate-800"></div>
                <p class="text-xs text-slate-500 mt-2">Admin Operasional</p>
            </div>
        </div>

        {{-- Tombol Kembali (Tidak akan tercetak di kertas) --}}
        <div class="mt-8 text-center no-print">
            <button onclick="window.close()" class="bg-slate-200 hover:bg-slate-300 text-slate-800 px-6 py-2 rounded-lg text-sm font-bold transition-colors">Tutup Halaman</button>
        </div>
    </div>

</body>

</html>