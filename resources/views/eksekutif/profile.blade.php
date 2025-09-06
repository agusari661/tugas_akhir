@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <!-- Card Profile Picture -->
            <div class="col-md-4 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <img src="{{ $eksekutif->profile_picture ? asset('storage/' . $eksekutif->profile_picture) : asset('images/default-profile.png') }}"
                            class="rounded-circle img-fluid mb-3" alt="Profile Picture" style="width: 150px; height: 150px;">

                        <!-- Form Upload -->
                        <form action="{{ route('profile.update-picture') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="profile_picture" class="form-control mb-2">
                            <button type="submit" class="btn btn-primary btn-sm">Update Foto</button>
                        </form>

                        <h5 class="card-title mt-3">{{ $eksekutif->name }}</h5>
                        <p>{{ $eksekutif->role }}</p>
                    </div>
                </div>
            </div>

            <!-- Card Informasi Pengguna -->
            <div class="col-md-8 mb-3">
                <div class="card">
                    <div class="card-header">
                        Informasi Pengguna
                    </div>
                    <div class="card-body">
                        <p><strong>Nama Lengkap:</strong> {{ $eksekutif->name }}</p>
                        <p><strong>Email:</strong> {{ $eksekutif->email }}</p>
                        <p><strong>Nomor HP:</strong> {{ $eksekutif->phone ?? '-' }}</p>
                        <p><strong>Alamat:</strong> {{ $eksekutif->address ?? '-' }}</p>
                        {{-- <a href="{{ route('profile.edit') }}" class="btn btn-warning btn-sm">Edit Profil</a> --}}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
