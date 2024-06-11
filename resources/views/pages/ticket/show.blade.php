@extends('layouts.app')

@section('title', 'Tiket')

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Tiket</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href=" {{ route('tickets.index') }} ">Tiket</a></div>
                    <div class="breadcrumb-item">Detail Tiket</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex flex-column align-items-center">
                                <img src="{{ str_contains($ticket->image, 'http') === true ? $ticket->image : 'https://laravel11-ticketing.test/storage/tickets/' . $ticket->image }}"
                                    width="200" height="200" alt="{{ $ticket->name }}" class="img-thumbnail mb-3">
                                <h5 class="text-dark">
                                    {{ $ticket->name }}
                                    @if ($ticket->is_featured)
                                        <span class="badge badge-secondary ml-2">
                                            <i class="fa-solid fa-thumbs-up"></i>
                                        </span>
                                    @endif
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="col-12">
                                    <p class="mb-0">Deskripsi :</p>
                                    <p class="text-dark">{{ $ticket->description }}</p>
                                </div>
                                <div class="row px-3">
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <p class="mb-0">Kategori :</p>
                                        <p class="text-dark">{{ $ticket->ticketCategory->name }}</p>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <p class="mb-0">Harga :</p>
                                        <p class="text-dark">{{ $ticket->price }}</p>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <p class="mb-0">Kuota :</p>
                                        <p class="text-dark">{{ $ticket->quota }}</p>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <p class="mb-0">Status :</p>
                                        <span
                                            class="badge @if ($ticket->status === 'Tersedia') badge-success @else badge-light @endif">
                                            {{ $ticket->status }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card">
                            <div class="card-footer">
                                <div class="grid">
                                    <a href="{{ route('tickets.edit', $ticket->slug) }}"
                                        class="btn btn-outline-dark btn-icon">
                                        Edit
                                    </a>
                                    <form action="{{ route('tickets.destroy', $ticket->slug) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="btn btn-outline-danger btn-icon swal-confirm-delete"
                                            data-name="{{ $ticket->name }}">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
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
