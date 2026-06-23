<table>
    <thead>
        <tr>
            <th colspan="6" style="font-weight: bold; text-align: center; font-size: 14px;">
                LAPORAN REKAPITULASI PEMASUKAN OPERASIONAL
            </th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: center; font-size: 11px; color: #555555; font-weight: bold;">
                PT BRILIANT TEKNIK MANDIRI
            </th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: center; font-size: 11px;">
                Periode Bulan: {{ $bulan }} / Tahun: {{ $tahun }}
            </th>
        </tr>
        <tr></tr>
        <tr>
            <th style="font-weight: bold; background-color: #047857; color: #ffffff; text-align: center; border: 1px solid #000000;">No</th>
            <th style="font-weight: bold; background-color: #047857; color: #ffffff; text-align: center; border: 1px solid #000000;">No. WO</th>
            <th style="font-weight: bold; background-color: #047857; color: #ffffff; text-align: left; border: 1px solid #000000;">Nama Pekerjaan</th>
            <th style="font-weight: bold; background-color: #047857; color: #ffffff; text-align: left; border: 1px solid #000000;">Nama PT / Pelanggan</th>
            <th style="font-weight: bold; background-color: #047857; color: #ffffff; text-align: center; border: 1px solid #000000;">Tanggal Selesai</th>
            <th style="font-weight: bold; background-color: #047857; color: #ffffff; text-align: right; border: 1px solid #000000;">Total Biaya</th>
        </tr>
    </thead>
    <tbody>
        @php $totalKeseluruhan = 0; @endphp

        @forelse($transaksi as $index => $item)
        <tr>
            <td style="text-align: center; border: 1px solid #cbd5e1;">{{ $index + 1 }}</td>
            <td style="text-align: center; border: 1px solid #cbd5e1; font-weight: bold; color: #047857;">{{ $item->wo_number }}</td>
            <td style="text-align: left; border: 1px solid #cbd5e1;">{{ $item->job_name }}</td>

            {{-- Nama Pelanggan --}}
            <td style="text-align: left; border: 1px solid #cbd5e1;">
                {{ $item->customer->company_name ?? $item->nama_pt ?? '-' }}
            </td>

            <td style="text-align: center; border: 1px solid #cbd5e1;">{{ $item->updated_at->format('d/m/Y') }}</td>
            <td style="text-align: right; border: 1px solid #cbd5e1;">{{ $item->total_cost }}</td>
        </tr>
        @php $totalKeseluruhan += $item->total_cost; @endphp
        @empty
        <tr>
            <td colspan="6" style="text-align: center; border: 1px solid #cbd5e1; font-style: italic; color: #94a3b8;">
                Tidak ada data pengerjaan selesai pada periode ini.
            </td>
        </tr>
        @endforelse

        <tr>
            <td colspan="5" style="font-weight: bold; text-align: right; border: 1px solid #000000; background-color: #f8fafc;">
                Total Pendapatan:
            </td>
            <td style="font-weight: bold; text-align: right; border: 1px solid #000000; background-color: #f8fafc; color: #16803d;">
                {{ $totalKeseluruhan }}
            </td>
        </tr>
    </tbody>
</table>