<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

public function store(Request $request)
{
    $request->validate([
        'nama_categories' => 'required',
        'price' => 'required|numeric',
        'description' => 'required',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $photoName = null;

    if ($request->hasFile('photo')) {
        // Simpan ke storage/app/public/categories
        $photoName = $request->file('photo')->store('categories', 'public');
    }

    Category::create([
        'nama_categories' => $request->nama_categories,
        'price' => $request->price,
        'description' => $request->description,
        'photo' => $photoName, // simpan path-nya langsung
    ]);

    return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan!');
}
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
{
    $request->validate([
        'nama_categories' => 'required',
        'price' => 'required|numeric',
        'description' => 'required',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $data = $request->only(['nama_categories', 'price', 'description']);

    if ($request->hasFile('foto')) {
        if ($category->foto) Storage::disk('public')->delete($category->foto);
        $data['foto'] = $request->file('foto')->store('categories', 'public');
    }

    $category->update($data);

    return redirect()->route('categories.index')->with('success', 'Kategori berhasil diupdate!');
}

public function destroy(Category $category)
{
    // HAPUS DULU SEMUA TRANSAKSI YANG PAKAI KATEGORI INI
    \DB::table('tb_transaction')->where('id_kategori', $category->id_categories)->delete();

    // HAPUS FOTO KALAU ADA
    if ($category->photo) {
        \Storage::disk('public')->delete($category->photo);
    }

    // HAPUS KATEGORI
    $category->delete();

    return redirect()->route('categories.index')->with('success', 'Kategori dan semua transaksi terkait berhasil dihapus!');
}
    public function show(Category $category)
{
    return view('categories.show', compact('category'));
}
public function generatePDF()
{
    $categories = Category::all();

    $pdf = Pdf::loadView('categories.pdf', compact('categories'))
              ->setPaper('a4', 'landscape');

    return $pdf->stream('Laporan_Kategori_'.date('d-m-Y').'.pdf');
}
}