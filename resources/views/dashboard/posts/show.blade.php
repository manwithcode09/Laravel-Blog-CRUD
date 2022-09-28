@extends('dashboard.layouts.main')

@section('container')
 {{-- penulisan seperti ini artinya, akan mencetak string dan melakukan escaping dari karakter apapun didalamnya --}}
<div class="container">
    <div class="row my-4">
        <div class="col-lg-8">
            <h2 class="mb-2">{{ $post->title }}</h2>

            <a href="/dashboard/posts" class="btn btn-success"><span data-feather="arrow-left"></span> Back to all posts</a>
            <a href="/dashboard/posts/{{ $post->slug }}/edit" class="btn btn-warning"><span data-feather="edit"></span> Edit</a>
            <form action="/dashboard/posts/{{ $post->slug}}" method="post" class="d-inline">
                {{-- karna didalam form itu tidak ada method delete, maka harus di timpa/dibajak --}}
                @method('delete')
                @csrf
                <button class="btn btn-danger" onclick="return confirm('Are you sure?')"><span data-feather="x-circle"></span> Delete</button>
              </form>
            
                @if ($post->image)
                <div style="max-height:350px; overflow:hidden;">
        {{-- pengecekan image, jika user upload gambar maka pakai gambar dari path storage --}}
                <img src="{{ asset('storage/' . $post->image) }}" 
                alt="{{ $post->category->name }}" class="img-fluid mt-3">
                </div>
                @else
        {{-- jika tidak, maka pakai gambar dari sumber API --}}
                    <img src="https://source.unsplash.com/1200x400?{{ $post->category->name }}" 
                    alt="{{ $post->category->name }}" class="img-fluid mt-3">
                @endif

        {{-- Tanda seru artinya kita tidak melakukan escaping char, dan akan menjalankan karakter seperti html --}}
        <article class="my-3 fs-5">
            {!! $post->body !!}
        </article>
        
        
    </div>
</div>
@endsection
