@extends('layouts.main')


@section('container')
{{-- penulisan seperti ini artinya, akan mencetak string dan melakukan escaping dari karakter apapun didalamnya --}}
<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <h2 class="mb-2">{{ $post->title }}</h2>

            <p><strong>By. <a href="/posts?author={{ $post->author->username }}" class="text-decoration-none">{{ $post->author->name}}</a> in <a href="/posts?categories={{ $post->category->slug }}" class="text-decoration-none">{{ $post->category->name }}</a>
            </strong></p>

            @if ($post->image)
            <div style="max-height:350px; overflow:hidden;">
    {{-- pengecekan image, jika user upload gambar maka pakai gambar dari path storage --}}
            <img src="{{ asset('storage/' . $post->image) }}" 
            alt="{{ $post->category->name }}" class="img-fluid">
            </div>
            @else
    {{-- jika tidak, maka pakai gambar dari sumber API --}}
                <img src="https://source.unsplash.com/1200x400?{{ $post->category->name }}" 
                alt="{{ $post->category->name }}" class="img-fluid">
            @endif
        
        {{-- Tanda seru artinya kita tidak melakukan escaping char, dan akan menjalankan karakter seperti html --}}
        <article class="my-3 fs-5">
            {!! $post->body !!}
            <div class="col-md-2">
                <a href="/posts" class="text-decoration-none d-block  btn btn-primary mt-4">Kembali</a>
            </div>
        </article>
        
        
    </div>
</div>
</div>
   
    
  

@endsection