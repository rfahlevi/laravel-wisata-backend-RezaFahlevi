@extends('layouts.app')

@section('title', 'Tiket')

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tiket</h1>
            </div>
            <div class="section-body">
                <h2 class="section-title">Tiket</h2>
                <p class="section-lead">Anda bisa mengelola semua Tiket, seperti mengubah, menghapus dan yang
                    lainnya.</p>
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header">
                                <h4>Data Tiket</h4>
                                <div class="card-header-form">
                                    <form>
                                        {{-- Search Tiket --}}
                                        <div class="input-group d-flex align-items-center">
                                            <input type="text" name="ticket_search" class="form-control"
                                                placeholder="Cari Tiket" value="{{ Request::get('ticket_search') }}">
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
                                <div class="d-flex justify-content-between">
                                    <div class="d-block">
                                        <p class="mb-0">Catatan :</p>
                                        <span class="badge badge-secondary mr-2 mb-4">
                                            <i class="fa-solid fa-thumbs-up"></i>
                                            : Tiket Terlaris
                                        </span>
                                    </div>
                                    <div class="section-header-button pl-4 pt-4">
                                        <a href="{{ route('tickets.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i>
                                            Tambah Tiket
                                        </a>
                                    </div>
                                </div>
                                {{-- Tiket Table --}}
                                <div class="table-responsive">
                                    <table class="table-bordered table-sm table-hover table-striped table">
                                        <thead>
                                            <tr class="text-center">
                                                <th>#</th>
                                                <th>Foto</th>
                                                <th>Tiket</th>
                                                <th>Harga</th>
                                                <th>Kuota</th>
                                                <th>Kategori</th>
                                                <th>Tipe</th>
                                                <th>Status</th>
                                                <th>Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tickets as $ticket)
                                                <tr>
                                                    <td class="align-middle text-center">
                                                        {{ $tickets->firstItem() + $loop->index }}</td>
                                                    <td class="d-flex justify-content-center align-items-center">
                                                        <figure class="avatar avatar-lg bg-white">
                                                            <img src="{{ str_contains($ticket->image, 'http') === true ? $ticket->image : 'https://laravel11-ticketing.test/storage/tickets/' . $ticket->image }}"
                                                                class="img-fluid" width="70" height="70"
                                                                alt="{{ $ticket->name }}">
                                                        </figure>
                                                    </td>
                                                    <td class="align-middle">{{ $ticket->name }}
                                                        @if ($ticket->is_featured)
                                                            <span class="badge badge-secondary ml-2">
                                                                <i class="fa-solid fa-thumbs-up"></i>
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        {{ $ticket->price }}</td>
                                                    <td class="align-middle text-center">{{ $ticket->quota }}</td>
                                                    <td class="align-middle text-center">{{ $ticket->ticketCategory->name }}
                                                    <td class="align-middle text-center">{{ $ticket->type }}
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span
                                                            class="badge @if ($ticket->status === 'Tersedia') badge-success @else badge-light @endif">
                                                            {{ $ticket->status }}
                                                        </span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <a href="{{ route('tickets.show', $ticket->slug) }}"
                                                            class="btn btn-light btn-icon">
                                                            <i class="far fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-right float-right">
                                {{ $tickets->withQueryString()->links() }}
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
