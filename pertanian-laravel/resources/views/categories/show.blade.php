<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail: {{ $category->nama_categories }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-50 to-emerald-100 min-h-screen flex items-center justify-center p-8">
<div class="bg-white rounded-3xl shadow-2xl p-12 max-w-4xl w-full">
    <div class="text-center mb-10">
        <h1 class="text-5xl font-bold text-green-800">Detail Kategori</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <div>
            @if($category->foto)
                <img src="{{ asset('storage/'.$category->foto) }}" class="w-full rounded-2xl shadow-xl">
            @else
                <div class="bg-gray-200 border-2 border-dashed rounded-2xl w-full h-96 flex items-center justify-center">
                    <span class="text-4xl text-gray-500">Tanpa Foto</span>
                </div>
            @endif
        </div>

        <div>
            <h2 class="text-4xl font-bold text-gray-800 mb-6">{{ $category->nama_categories }}</h2>
            <p class="text-6xl font-extrabold text-green-600 mb-8">
                Rp {{ number_format($category->price) }} <span class="text-2xl text-gray-600">/kg</span>
            </p>
            <div class="flex gap-4">
                <a href="{{ route('categories.edit', $category) }}" 
                   class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-4 px-8 rounded-xl text-xl">Edit</a>
                <a href="{{ route('categories.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-4 px-8 rounded-xl text-xl">Kembali</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>