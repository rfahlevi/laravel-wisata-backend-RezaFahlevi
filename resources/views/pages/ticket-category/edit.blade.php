@extends('layouts.app')

@section('title', 'Edit Kategori Tiket')

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Kategori Tiket</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href=" {{ route('ticketCategories.index') }} ">Kategori Tiket</a>
                    </div>
                    <div class="breadcrumb-item">Edit Kategori Tiket</div>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">Edit Kategori Tiket</h2>
                <p class="section-lead">Lengkapi formulir dibawah untuk mengedit kategori Tiket.</p>
                <form action="{{ route('ticketCategories.update', $ticketCategory->slug) }}" method="POST"
                    class="needs-validation">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Formulir Edit Kategori Tiket</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Nama Kategori</label>
                                        <input type="text" name="name" value="{{ $ticketCategory->name }}"
                                            class="form-control @error('name') is-invalid @enderror">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" data-height="100" name="description">{{ $ticketCategory->description }}</textarea>
                                        @error('description')
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
