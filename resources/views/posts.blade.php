@extends('layouts.main')


@section('container')

<h2 class="mb-3 text-center">{{ $title }}</h2>

{{-- searching form --}}
<div class="row justify-content-center mb-3">
  <div class="col-md-6">
    <form action="/posts">

      {{-- jika didalam request(URL) ada category, maka pakai nilainya --}}
      @if(request('category'))
        <input type="hidden" name="category" value="{{ request('category') }}">
      @endif

      {{--jika didalam request(URL) ada author, maka pakai nilainya --}}
      @if(request('author'))
        <input type="hidden" name="author" value="{{ request('author') }}">
      @endif

      <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Cari.." name="search" value="{{ request('search') }}">
        <button class="btn btn-primary" type="submit">Cari</button>
      </div>
    </form>
  </div>
</div>



{{-- menghitung jumlah dari postingan, jika lebih besar dari 0, maka tampilkan --}}
@if ($posts->count() > 0)
<div class="card mb-3">

  @if ($posts[0]->image)
    <div style="max-height:400px; ; text-align: center; overflow:hidden;  margin:1px;">
  {{-- pengecekan image, jika user upload gambar maka pakai gambar dari path storage --}}
    <img src="{{ asset('storage/' . $posts[0]->image) }}" 
    alt="{{ $posts[0]->category->name }}" class="img-fluid">
    </div>
    @else
{{-- jika tidak, maka pakai gambar dari sumber API --}}
    <img src="https://source.unsplash.com/1200x400?{{ $posts[0]->category->name }}" 
    class="card-img-top" alt="{{ $posts[0]->category->name }}">
  @endif

  {{-- $posts[0]->category->name : ambil post pertama(terbaru), lalu ambil atribut nama kategori --}}
    <div class="card-body text-center">
      <h3 class="card-title"><a href="/posts/{{ $posts[0]->slug }}"class="text-decoration-none text-dark"> {{ $posts[0]->title }}</a></h3>
      <p>
        <small class="text-muted">
        <strong>
            By. <a href="/posts?author={{ $posts[0]->author->username }}" class="text-decoration-none">{{ $posts[0]->author->name}}</a> in <a href="/posts?category={{ $posts[0]->category->slug }}"
            class="text-decoration-none">{{ $posts[0]->category->name }}</a>
        </strong> {{ $posts[0]->created_at->diffForhumans() }}
        </small>
    </p>
      <p class="card-text">{{ $posts[0]->excerpt }}</p>
      <a href="/posts/{{ $posts[0]->slug }}" class="text-decoration-none btn btn-primary">Read more</a>
    </div>
</div>


    <div class="contaier">
        <div class="row">
    {{-- foreach ini akan mengulang semua post, kecuali yang pertama, karna kita menggunakan method skip(1) --}}
            @foreach ($posts->skip(1) as $post)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="position-absolute px-3 py-2"
                    style="background-color:rgba(0, 0, 0, 0.582)"> 
                    <a href="/posts?category={{ $post->category->slug }}" 
                    class="text-decoration-none text-white">{{ $post->category->name }}</a></div>

                    @if ($post->image)
            {{-- pengecekan image, jika user upload gambar maka pakai gambar dari path storage --}}
                    <img src="{{ asset('storage/' . $post->image) }}" 
                    alt="{{ $post->category->name }}" class="img-fluid">
                    @else
            {{-- jika tidak, maka pakai gambar dari sumber API --}}
            <img src="https://source.unsplash.com/500x400?{{ $post->category->name }}" 
            class="card-img-top" alt="{{ $post->category->name }}">
                    @endif
                    <div class="card-body">
                      <h5 class="card-title text-decoration-none">{{ $post->title }}</h5>
                      <p>
                        <small class="text-muted">
                        <strong>
                        By. <a href="/posts?author={{ $post->author->username }}" class="text-decoration-none">
                            {{ $post->author->name}}</a>
                        </strong> {{ $post->created_at->diffForhumans() }}
                        </small>
                     </p>
                      <p class="card-text">{{ $post->excerpt }}</p>
                      <a href="/posts/{{ $post->slug }}" class="btn btn-primary">Read more</a>
                    </div>
                  </div>
            </div>
            @endforeach
        </div>
    </div>

    @else
    {{-- kalau tidak ada postingan, maka.. --}}
    <p class="text-center fs-4">No post found.</p>
  @endif

  <div class="d-flex justify-content-center">

    {{ $posts->links() }}

  </div>


@endsection

