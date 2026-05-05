<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // 1. Menampilkan halaman daftar pelanggan
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('customers.index', compact('customers'));
    }

    // 2. Menampilkan halaman formulir tambah pelanggan
    public function create()
    {
        return view('customers.create');
    }

    // 3. Menyimpan data dari formulir ke database
    public function store(Request $request)
    {
        // Validasi data yang masuk
        $request->validate([
            'company_name' => 'required|string|max:255',
            'pic_name'     => 'required|string|max:255',
            'phone'        => 'required|string|max:20',
            'email'        => 'nullable|email|max:255',
            'address'      => 'nullable|string',
        ], [
            'company_name.required' => 'Nama Perusahaan wajib diisi.',
            'pic_name.required'     => 'Nama PIC wajib diisi.',
            'phone.required'        => 'Nomor Telepon wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
        ]);

        // Simpan ke database
        Customer::create($request->all());

        // Kembalikan ke halaman index dengan pesan sukses
        return redirect()->route('customers.index')
            ->with('success', 'Data pelanggan berhasil ditambahkan!');
    }

    // 4. Menampilkan halaman Edit pelanggan
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customer.edit', compact('customer'));
    }

    // 5. Menyimpan perubahan data ke database
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'company_name' => 'required|string|max:255',
            'pic_name'     => 'required|string|max:255',
            'phone'        => 'required|string|max:20',
            'email'        => 'nullable|email|max:255',
            'address'      => 'nullable|string',
        ], [
            'company_name.required' => 'Nama Perusahaan wajib diisi.',
            'pic_name.required'     => 'Nama PIC wajib diisi.',
            'phone.required'        => 'Nomor Telepon wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')
            ->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    // 6. Menghapus data pelanggan dari Database
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Data pelanggan berhasil dihapus!');
    }
}
