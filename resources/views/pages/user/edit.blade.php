@extends('layouts.app')

@section('title', 'Edit User')

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit User</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href=" {{ route('users.index') }} ">User</a></div>
                    <div class="breadcrumb-item">Edit User</div>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">Edit User</h2>
                <p class="section-lead">Lengkapi formulir dibawah untuk mengedit user.</p>
                <form action="{{ route('users.update', $user->slug) }}" method="POST" class="needs-validation">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Formulir Edit User</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" name="name" value="{{ $user->name }}"
                                            class="form-control @error('name') is-invalid @enderror">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" name="email" value="{{ $user->email }}"
                                            class="form-control @error('email') is-invalid @enderror">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" name="phone" value="{{ $user->phone }}"
                                            class="form-control @error('phone') is-invalid @enderror">
                                        @error('phone')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Roles</label>
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="role" value="Admin"
                                                    class="selectgroup-input"
                                                    @if ($user->role == 'Admin') checked @endif>
                                                <span class="selectgroup-button">Admin</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="role" value="Manager"
                                                    class="selectgroup-input"
                                                    @if ($user->role == 'Manager') checked @endif>
                                                <span class="selectgroup-button">Manager</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="role" value="Staff"
                                                    class="selectgroup-input"
                                                    @if ($user->role == 'Staff') checked @endif>
                                                <span class="selectgroup-button">Staff</span>
                                            </label>
                                        </div>
                                        @error('role')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="buttons float-right">
                                            <button type="submit" class="btn btn-lg btn-primary">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
@endpush
