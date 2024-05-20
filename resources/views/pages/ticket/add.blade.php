@extends('layouts.app')

@section('title', 'Tambah Tiket')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Tiket</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href=" {{ route('tickets.index') }} ">Tiket</a></div>
                    <div class="breadcrumb-item">Tambah Tiket</div>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">Tambah Tiket</h2>
                <p class="section-lead">Lengkapi formulir dibawah untuk menambahkan tiket baru.</p>
                <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Formulir Tiket Baru</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Foto Tiket</label>
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <label class="custom-file-label" for="image">Pilih file</label>
                                                <input type="file" name="image"
                                                    class="custom-file-input @error('image') is-invalid @enderror"
                                                    id="image" aria-describedby="image">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label>Nama Tiket</label>
                                                <input type="text" name="name" value="{{ old('name') }}"
                                                    class="form-control @error('name') is-invalid @enderror">
                                                @error('name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label>Kategori Tiket</label>
                                                <select name="ticket_category_id" id="ticket_category_id"
                                                    class="form-control select2 @error('ticket_category_id') is-invalid @enderror"
                                                    data-placeholder="Pilih Kategori">
                                                    <option value=""></option>
                                                    @foreach ($ticketCategories as $ticketCategory)
                                                        <option value="{{ $ticketCategory->id }}"
                                                            @if (old('ticket_category_id') == $ticketCategory->id) selected @endIf>
                                                            {{ $ticketCategory->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('ticket_category_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label>Harga Tiket (Rupiah)</label>
                                                <input type="text" name="price" value="{{ old('price') }}"
                                                    class="form-control @error('price') is-invalid @enderror">
                                                @error('price')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label>Kuota</label>
                                                <input type="text" name="quota" value="{{ old('quota') }}"
                                                    class="form-control @error('quota') is-invalid @enderror">
                                                @error('quota')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Status</label>
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="status" value="Tersedia"
                                                    class="selectgroup-input" checked>
                                                <span class="selectgroup-button">Tersedia</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="status" value="Tidak Tersedia"
                                                    class="selectgroup-input">
                                                <span class="selectgroup-button">Tidak Tersedia</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Tipe Tiket</label>
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="type" value="Individu"
                                                    class="selectgroup-input" checked>
                                                <span class="selectgroup-button">Individu</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="type" value="Grup"
                                                    class="selectgroup-input">
                                                <span class="selectgroup-button">Grup</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Tiket Unggulan</label>
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="is_featured" value="0"
                                                    class="selectgroup-input">
                                                <span class="selectgroup-button">Tidak</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="is_featured" value="1"
                                                    class="selectgroup-input" checked>
                                                <span class="selectgroup-button">Ya</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi (Opsional)</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" data-height="100" name="description">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="buttons float-right">
                                            <button type="submit" class="btn btn-lg btn-primary">Simpan</button>
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
    <script>
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>

    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
@endpush
