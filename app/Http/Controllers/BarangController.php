<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::latest()->get();
        return view('barangs.index', compact('barangs'));
    }

    public function create()
    {
        return view('barangs.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'alat' => 'required|string|max:155',
            'merk' => 'required',
            'harga' => 'required',
            'stok' => 'required'
        ]);

        $barang = Barang::create([
            'alat' => $request->alat,
            'merk' => $request->merk,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'slug' => Str::slug($request->alat)
        ]);

        if ($barang) {
            return redirect()
                ->route('barang.index')
                ->with([
                    'success' => 'barang baru berhasil di create'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Terjadi Kesalahan, Coba lagi'
                ]);
        }
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barangs.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'alat' => 'required|string|max:155',
            'merk' => 'required',
            'harga' => 'required',
            'stok' => 'required'
        ]);

        $barang = Barang::findOrFail($id);

        $barang->update([
            'alat' => $request->alat,
            'merk' => $request->merk,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'slug' => Str::slug($request->alat)
        ]);

        if ($barang) {
            return redirect()
                ->route('barang.index')
                ->with([
                    'success' => 'barang baru berhasil di update'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Terjadi Kesalahan, Coba lagi'
                ]);
        }
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        if ($barang) {
            return redirect()
                ->route('barang.index')
                ->with([
                    'success' => 'Barang telah dihapus'
                ]);
        } else {
            return redirect()
                ->route('barang.index')
                ->with([
                    'error' => 'Terjadi kesalahan, coba lagi'
                ]);
        }
    }

}
