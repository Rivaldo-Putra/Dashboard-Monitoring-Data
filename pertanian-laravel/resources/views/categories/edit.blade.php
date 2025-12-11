<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Kategori</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {font-family:Inter,system-ui;background:#f9fafb;color:#1f2937;margin:0;}
    .container {
      max-width:600px;
      margin:40px auto;
      padding:30px;
      background:#fff;
      border-radius:12px;
      box-shadow:0 4px 20px rgba(0,0,0,.1);
    }
    h2 {color:#07c539;margin-bottom:20px;text-align:center;font-size:28px;}
    label {display:block;margin:15px 0 8px;font-weight:600;color:#1f2937;}
    input, textarea, button {
      width:100%;
      padding:12px;
      border-radius:8px;
      border:1px solid #ddd;
      margin-bottom:15px;
      font-size:16px;
    }
    input:focus, textarea:focus {outline:none;border-color:#07c539;}
    button {
      background:#07c539;
      color:#fff;
      border:none;
      cursor:pointer;
      font-weight:600;
      font-size:1rem;
      transition:0.3s;
    }
    button:hover {background:#059669;}
    .current-img {
      text-align:center;
      margin:15px 0;
    }
    .current-img img {
      width:150px;
      height:150px;
      object-fit:cover;
      border-radius:10px;
      border:3px solid #ddd;
      box-shadow:0 4px 10px rgba(0,0,0,0.1);
    }
    .back {
      display:inline-block;
      margin-top:20px;
      color:#07c539;
      text-decoration:none;
      font-weight:600;
      font-size:16px;
    }
    .back:hover {text-decoration:underline;}
  </style>
</head>
<body>

<div class="container">
  <h2>Edit Kategori</h2>

  <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Gambar Saat Ini -->
    @if($category->foto)
      <label>Gambar Saat Ini</label>
      <div class="current-img">
        <img src="{{ asset('storage/' . $category->foto) }}" alt="Current">
      </div>
    @endif

    <label>Ganti Gambar (kosongkan jika tidak ingin ganti)</label>
    <input type="file" name="foto" accept="image/*">

    <label>Nama Kategori</label>
    <input type="text" name="nama_categories" value="{{ old('nama_categories', $category->nama_categories) }}" required>

    <label>Harga (Rp)</label>
    <input type="number" name="price" value="{{ old('price', $category->price) }}" required>

    <label>Deskripsi</label>
    <textarea name="description" rows="5" required>{{ old('description', $category->description ?? '') }}</textarea>

    @error('foto')
      <p style="color:#ef4444;margin-top:-10px;margin-bottom:10px;">{{ $message }}</p>
    @enderror
    @error('nama_categories')
      <p style="color:#ef4444;margin-top:-10px;margin-bottom:10px;">{{ $message }}</p>
    @enderror

    <button type="submit">Update Kategori</button>
  </form>

  <a href="{{ route('categories.index') }}" class="back">← Kembali ke Daftar Kategori</a>
</div>

</body>
</html>