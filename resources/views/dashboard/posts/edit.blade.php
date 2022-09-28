@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Post</h1>
  </div>

  <div class="col-lg-6">
    {{-- akan mengarah ke resource controller, dan ditangani oleh Update(method put) --}}
      <form action="/dashboard/posts/{{ $post->slug }}" method="post" class="mb-5" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="mb-3">
          <label for="title" class="form-label">Title</label>
          <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
           {{-- nilai disebelah kanan old, akan dipakai ketika didalam form tidak terdapat old('value') --}}
          required autofocus value="{{ old('title', $post->title)  }}">
          @error('title')
          <div class="invalid-feedback">
              {{ $message }}
          </div>
          @enderror
        </div>

          <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" readonly value="{{ old('slug', $post->slug) }}">
            @error('slug')
          <div class="invalid-feedback">
              {{ $message }}
          </div>
          @enderror
          </div>

          <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" name="category_id" aria-label="Default select example">
              @foreach ($categories as $category)
              @if(old('category_id', $post->category_id) == $category->id)
              <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
              @else
              <option value="{{ $category->id }}">{{ $category->name }}</option>
              @endif
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label for="image" class="form-label ">Post Image</label>
            {{-- form hidden yg akan menyimpan nilai URL nama gambar lama  --}}
            <input type="hidden" name="oldImage" value="{{ $post->image }}">
            @if($post->image)
            {{-- kondisi jika ada gambar yg sebelumnya sudah di upload --}}
            <img src="{{ asset('storage/' . $post->image) }}" class="img-preview img-fluid mb-2 col-sm-5 d-block">
            @else
            {{-- kondisi jika belum pernah upload gambar --}}
            @endif
            <img class="img-preview img-fluid mb-3 col-sm-5">
            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image"
             name="image" onchange="previewImage()">
            @error('image')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
            </div>

          <div class="mb-3">
            <label for="body" class="form-label">Body</label>
            @error('body')
          <p class="text-danger">
              {{ $message }}
          </p>
          @enderror
            <input id="body" type="hidden" name="body" value="{{ old('body', $post->body) }}">
            <trix-editor input="body"></trix-editor>
          </div>
       
        <button type="submit" class="btn btn-primary">Save Update</button>
        <a href="/dashboard/posts" class="btn btn-danger">Cancel</a>
      </form>
  </div>

  <script>

      // nilai inputan title diambil untuk nilai judul-nya
      const title = document.querySelector('#title');

      // nilai inputan slug diambil untuk mengisikan slug-nya 
      const slug = document.querySelector('#slug');

      //event untuk menangani ketika apa yg dituliskan didalam titlenya itu berubah
      title.addEventListener('change', function() {
        
        //fetch sendiri (harus) memiliki parameter URL, sebagai acuan atau sumber fetch data
        //jadi, kita mengirim data yang akan di tangani oleh model resourch, method checkSlug
        fetch('/dashboard/post/checkSlug?title=' + title.value)
        .then(response => response.json())
        .then(data => slug.value = data.slug)
      });

      //mematikan fitur upload file trix-editor
      document.addEventListener('trix-file-accept', function(e){
        e.prevent.Default();
      });

      // function untuk prview gambar yg dipilih sebelum di upload
      function previewImage() {
      //pertama ambil id input image
      const image = document.querySelector('#image');
      //lalu ambil nama class dalam tag img
      const imgPreview = document.querySelector('.img-preview');

      //ubah display style menjadi block
      imgPreview.style.display = 'block';

      //ambil data gambar
      const oFReader = new FileReader();
      oFReader.readAsDataURL(image.files[0]);

      //lalu ketika di load
      oFReader.onload = function(oFREvent) {

        imgPreview.src = oFREvent.target.result;

      }

    }

  </script>

@endsection
