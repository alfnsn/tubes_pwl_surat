@extends('layouts.indexMahasiswa')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Profile</h2>

        <!-- Display General Error Message -->
        @if ($errors->has('error'))
            <div class="alert alert-danger">
                {{ $errors->first('error') }}
            </div>
        @endif

        <!-- Display Validation Errors -->
        @if ($errors->any() && !$errors->has('error'))
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="form-group mb-3">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="{{ old('name', Auth::user()->name) }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone"
                    value="{{ old('phone', Auth::user()->phone) }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="{{ old('email', Auth::user()->email) }}" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password"
                    placeholder="Leave blank to keep current password">
            </div>
            <div class="form-group mb-3">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                    placeholder="Re-enter your password">
            </div>
            <button type="submit" class="btn-sm btn-primary" style="margin-bottom: 20px">Update Profile</button>
        </form>
    </div>
@endsection
