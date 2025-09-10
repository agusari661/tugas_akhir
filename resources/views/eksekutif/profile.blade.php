@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <!-- Card Profile Picture -->
            <div class="mb-3 col-md-4">
                <div class="text-center card">
                    <div class="card-body">
                        <img src="{{ $eksekutif->profile_picture ? asset('storage/' . $eksekutif->profile_picture) : asset('images/default-profile.png') }}"
                            class="mb-3 rounded-circle img-fluid" alt="Profile Picture" style="width: 150px; height: 150px;">

                        <!-- Form Upload -->
                        <form action="{{ route('profile.update-picture') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="profile_picture" class="mb-2 form-control">
                            <button type="submit" class="btn btn-primary btn-sm">Update Foto</button>
                        </form>

                        <h5 class="mt-3 card-title">{{ $eksekutif->name }}</h5>
                        <p>{{ $eksekutif->role }}</p>
                    </div>
                </div>
            </div>

            <!-- Card Informasi Pengguna -->
            <div class="mb-3 col-md-8">
                <div class="card">
                    <div class="card-header">
                        Informasi Pengguna
                    </div>
                    <div class="card-body">
                        <p><strong>Nama Lengkap:</strong> {{ $eksekutif->name }}</p>
                        <p><strong>Email:</strong> {{ $eksekutif->email }}</p>
                        <p><strong>Nomor HP:</strong> {{ $eksekutif->phone ?? '-' }}</p>
                        <p><strong>Alamat:</strong> {{ $eksekutif->address ?? '-' }}</p>
                    </div>
                </div>

                <!-- Card Ganti Password -->
                <div class="mt-3 card">
                    <div class="card-header">
                        Ganti Password
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <form action="{{ route('profile.change-password') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Password Saat Ini</label>
                                <input type="password" name="current_password" id="current_password" class="form-control" required>
                                @error('current_password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Password Baru</label>
                                <input type="password" name="new_password" id="new_password" class="form-control" required>
                                @error('new_password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
