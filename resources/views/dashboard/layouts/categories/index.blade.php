@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Post Categories</h1>
  </div>

  @if(session()->has('success'))
  <div class="alert alert-success alert-dismissible fade show col-lg-4" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <div class="table-responsive">
    <a href="/dashboard/categories/create" class="btn btn-primary mb-3">Create new category</a>
    @if ($categories->count() > 0)
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">No.</th>
          <th scope="col">Category Name</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($categories as $category)
        <tr>
            {{-- varibale loop digunakan ketika kita ingin looping angka menggunkan foreach (khusus laravel) --}}
            <td>{{ $loop->iteration }}</td>
            <td>{{ $category->name }}</td>

            <td>
            {{-- URL ini akan otomatis ditangani oleh method show didalam resource controller --}}
            <a href="/dashboard/categories/{{ $category->slug }}" class="badge view"><span data-feather="eye"></span></a>
            {{-- URL ini akan otomatis ditangani oleh method edit didalam resource controller --}}
            <a href="/dashboard/categories/{{ $category->slug }}/edit" class="badge edit"><span data-feather="edit"></span></a>
            {{-- URL ini akan otomatis ditangani oleh method destroy didalam resource controller --}}
            <form action="/dashboard/categories/{{ $category->slug}}" method="post" class="d-inline">
              {{-- karna didalam form itu tidak ada method delete, maka harus di timpa/dibajak --}}
              @method('delete')
              @csrf
              <button class="badge delete border-0" onclick="return confirm('Are you sure?')"><span data-feather="x-circle"></span></button>
            </form>
            </td>
        </tr>
        @endforeach
        
      </tbody>
    </table>

    @else
    {{-- kalau tidak ada postingan, maka.. --}}
    <p class="text-center fs-4 mt-4">No post found.</p>
  @endif
  </div>
@endsection
