@extends('layouts.app')

@section('title', 'User')

@push('style')
    <!-- CSS Libraries -->
    {{-- <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}"> --}}
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>User</h1>
            </div>
            <div class="section-body">
                <h2 class="section-title">User</h2>
                <p class="section-lead">Anda bisa mengelola semua user, seperti mengubah, menghapus dan yang lainnya.</p>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="section-header-button pl-4 pt-4">
                                <a href="{{ route('users.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i>
                                    Tambah User
                                </a>
                            </div>
                            <div class="card-header">
                                <h4>Data User</h4>
                                <div class="card-header-form">
                                    <form>
                                        {{-- Search User --}}
                                        <div class="input-group d-flex align-items-center">
                                            <input type="text" name="user_search" class="form-control"
                                                placeholder="Cari User" value="{{ Request::get('user_search') }}">
                                            <div class="input-group-btn">
                                                <button class="btn btn-icon btn-primary">
                                                    <i class="fas fa-magnifying-glass"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body">
                                {{-- User Table --}}
                                <div class="table-responsive">
                                    <table class="table-bordered table-sm table-hover table-striped table">
                                        <thead>
                                            <tr class="text-center">
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Role</th>
                                                <th>Dibuat Pada</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td class="align-middle text-center">
                                                        {{ $users->firstItem() + $loop->index }}</td>
                                                    <td class="align-middle">{{ $user->name }}</td>
                                                    <td class="align-middle">{{ $user->email }}</td>
                                                    <td class="align-middle">{{ $user->phone }}</td>
                                                    <td class="align-middle">{{ $user->role }}</td>
                                                    <td class="align-middle">{{ $user->created_at }}</td>
                                                    <td class="align-middle text-center">
                                                        <a href="{{ route('users.edit', $user->slug) }}"
                                                            class="btn btn-outline-dark btn-icon">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('users.destroy', $user->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <button
                                                                class="btn btn-outline-danger btn-icon swal-confirm-delete"
                                                                data-name="{{ $user->name }}">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-right float-right">
                                {{ $users->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
@endpush
