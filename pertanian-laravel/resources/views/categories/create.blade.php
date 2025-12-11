<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-50 to-emerald-100 min-h-screen flex items-center justify-center p-6">
<div class="bg-white rounded-3xl shadow-2xl p-10 w-full max-w-2xl">
    <h1 class="text-4xl font-bold text-green-800 text-center mb-8">+ Tambah Kategori Baru</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Nama Produk</label>
            <input type="text" name="nama_categories" value="{{ old('nama_categories') }}" 
                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-green-500" required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Harga per Kg (Rp)</label>
            <input type="number" name="price" value="{{ old('price') }}" 
                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl" required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Deskripsi</label>
            <textarea name="description" rows="4" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-8">
            <label class="block text-gray-700 font-bold mb-2">Foto Produk (Opsional)</label>
            <input type="file" name="photo" accept="image/*"
                   class="w-full px-4 py-3 border-2 border-dashed border-gray-400 rounded-xl">
        </div>

        <div class="text-center">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-12 rounded-full text-xl shadow-lg">
                Simpan Kategori
            </button>
            <a href="{{ route('categories.index') }}" class="ml-4 text-gray-600 hover:text-gray-800 font-bold">
                Batal
            </a>
        </div>
    </form>
</div>
</body>
</html>