
@extends('layouts.main')
@section('section')

<div class="container py-5">

    <h2 class="mb-4">Edit Profile</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control"
                   value="{{ old('name', auth()->user()->name) }}">
            @error('name')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Bio -->
        <div class="mb-3">
            <label for="bio" class="form-label">Bio</label>
            <textarea name="bio" id="bio" class="form-control" rows="4">{{ old('bio', $profile->bio ?? '') }}</textarea>
            @error('bio')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Profile Picture -->
        <div class="mb-3">
            <label for="profile_picture" class="form-label">Profile Picture</label>
            <input type="file" name="profile_picture" id="profile_picture" class="form-control">
            @error('profile_picture')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror

            @if($profile && $profile->profile_picture)
                <div class="mt-3">
                    <img src="{{ asset('storage/'.$profile->profile_picture) }}"
                         alt="Profile Picture" class="rounded" width="120">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>

@endsection
