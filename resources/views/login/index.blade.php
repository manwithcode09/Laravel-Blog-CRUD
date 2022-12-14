@extends('layouts.main')

@section('container')


<div class="row justify-content-center mt-5">
    <div class="col-md-4">

      {{-- flash alert success --}}
      @if(session()->has('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        Your account created <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      {{-- flash alert success --}}
      @if(session()->has('loginError'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('loginError') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif

        <main class="form-signin">
            <h1 class="h3 mb-3 fw-normal text-center"><i class="bi bi-cup-hot-fill"></i> Please Login</h1>
            <form action="/login" method="post">
              {{-- pengamanan token --}}
              @csrf
              <div class="form-floating">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" autofocus required value="{{ old('email') }}">
                <label for="email">Email address</label>
                @error('email')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>

              <div class="form-floating">
                <input type="password"  name="password" class="form-control" id="password" placeholder="Password" required>
                <label for="password">Password</label>
              </div>
          
              <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
            </form>
            <small class="d-block text-center mt-3">Don't have an account? <a href="/register">Create Account!</a></small>
          </main>
    </div>
</div>

@endsection