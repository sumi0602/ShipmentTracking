@extends('layouts.app')

@section('title', 'Shipments')

@section('content')
<div class="container">

    {{-- Page Header --}}
    <div class="page-header">
        <p class="page-header__eyebrow">Dashboard</p>
        <h1 class="page-header__title">Shipments</h1>
        <p class="page-header__sub">Track and manage all your active shipments in one place.</p>
    </div>

    {{-- Stats Row --}}
    @php
        $total     = $shipments->total();
        $pending   = \App\Models\Shipment::where('status', 'Pending')->count();
        $inTransit = \App\Models\Shipment::where('status', 'In Transit')->count();
        $delivered = \App\Models\Shipment::where('status', 'Delivered')->count();
    @endphp

    <div class="stats">
        <div class="stat">
            <p class="stat__label">Total</p>
            <p class="stat__value">{{ \App\Models\Shipment::count() }}</p>
        </div>
        <div class="stat">
            <p class="stat__label">Pending</p>
            <p class="stat__value" style="color:var(--amber)">{{ $pending }}</p>
        </div>
        <div class="stat">
            <p class="stat__label">In Transit</p>
            <p class="stat__value" style="color:var(--blue)">{{ $inTransit }}</p>
        </div>
        <div class="stat">
            <p class="stat__label">Delivered</p>
            <p class="stat__value" style="color:var(--green)">{{ $delivered }}</p>
        </div>
    </div>

    {{-- Search --}}
    <form action="{{ route('shipments.index') }}" method="GET" class="search-form" role="search">
        <input
            type="search"
            name="search"
            class="search-input"
            placeholder="Search by tracking number…"
            value="{{ $search }}"
            aria-label="Search shipments by tracking number"
            autocomplete="off"
        />
        <button type="submit" class="btn btn--primary">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            Search
        </button>
        @if($search)
            <a href="{{ route('shipments.index') }}" class="btn btn--ghost">Clear</a>
        @endif
    </form>

    {{-- Table Card --}}
    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th scope="col">Tracking #</th>
                        <th scope="col">Receiver</th>
                        <th scope="col">Destination</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date</th>
                        <th scope="col" style="width:60px"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($shipments as $shipment)
                        <tr>
                            <td class="td-track">{{ $shipment->tracking_number }}</td>
                            <td class="td-name">{{ $shipment->receiver_name }}</td>
                            <td class="td-city">{{ $shipment->destination_city }}</td>
                            <td>
                                <span class="badge badge--{{ Str::slug($shipment->status === 'In Transit' ? 'transit' : $shipment->status) }}">
                                    {{ $shipment->status }}
                                </span>
                            </td>
                            <td class="td-date">
                                {{ $shipment->created_at->format('d M Y') }}
                            </td>
                            <td>
                                <a href="{{ route('shipments.show', $shipment) }}" class="btn btn--ghost" style="padding:6px 12px; font-size:.8125rem;">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty">
                                    <p class="empty__icon">📦</p>
                                    <p class="empty__title">No shipments found</p>
                                    <p class="empty__text">
                                        @if($search)
                                            No results for "<strong>{{ $search }}</strong>". Try a different tracking number.
                                        @else
                                            No shipments have been created yet.
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($shipments->hasPages())
            <div class="pagination">
                <span>
                    Showing {{ $shipments->firstItem() }}–{{ $shipments->lastItem() }}
                    of {{ $shipments->total() }} shipments
                </span>
                <div class="pagination__links">
                    {{ $shipments->links() }}
                </div>
            </div>
        @endif
    </div>

</div>
@endsection
