{{-- syntax: blade --}}
@extends('layouts.app')

@section('title', 'Categories | Pertanian Admin')

@section('content')
<div class="container-fluid py-4">
    <h3 class="mb-4 fw-bold">Daftar Kategori Produk</h3>

    <a href="{{ route('categories.create') }}" class="btn btn-success mb-4 fw-bold">
        + Tambah Data
    </a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle shadow-sm">
            <thead class="table-success text-dark fw-bold">
                <tr>
                    <th style="width: 30%">Photo</th>
                    <th style="width: 20%">Categories</th>
                    <th style="width: 15%">Price</th>
                    <th style="width: 20%">Description</th>
                    <th style="width: 15%">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                   <td>
                       <img src="{{ asset($category->photo) }}"
                            style="width:350px;height:220px;object-fit:cover;border-radius:20px;">
                   </td>

                    <td class="fw-bold fs-5">{{ $category->nama_categories }}</td>
                    <td class="fw-bold text-success">Rp {{ number_format($category->price) }}</td>
                    <td>{{ $category->description ?? '-' }}</td>

                    <td class="text-center">
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm fw-bold">Edit</a>

                        <form action="{{ route('categories.destroy', $category) }}" 
                              method="POST" 
                              style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-danger btn-sm fw-bold"
                                    onclick="return confirm('Yakin hapus kategori ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted fs-4">
                        Tidak ada data kategori
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
