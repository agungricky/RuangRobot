<form action="" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="nama_kategori">Nama Kategori</label>
        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="{{ $kategoriKelas->nama_kategori }}" required>
    </div>
    
    <div class="form-group">
        <label for="deskripsi">Deskripsi</label>
        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required>{{ $kategoriKelas->deskripsi }}</textarea>
    </div>
    
    <button type="submit" class="btn btn-primary">Update</button>
</form>