@extends('layouts.app')

@section('title', 'Shipment ' . $shipment->tracking_number)

@section('content')
<div class="container">

    {{-- Back --}}
    <a href="{{ route('shipments.index') }}" class="back-link">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m15 18-6-6 6-6"/></svg>
        All Shipments
    </a>

    {{-- Page Header --}}
    <div class="page-header">
        <p class="page-header__eyebrow">Shipment Details</p>
        <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap">
            <h1 class="page-header__title" style="font-size:clamp(1.5rem,3vw,2rem)">
                {{ $shipment->tracking_number }}
            </h1>
            <span class="badge badge--{{ $shipment->status === 'In Transit' ? 'transit' : Str::slug($shipment->status) }}"
                  style="font-size:.8125rem; padding:5px 14px">
                {{ $shipment->status }}
            </span>
        </div>
        <p class="page-header__sub">Shipped on {{ $shipment->created_at->format('l, d F Y') }}</p>
    </div>

    {{-- Sender / Receiver Cards --}}
    <div class="detail-grid">

        {{-- Sender --}}
        <div class="detail-section">
            <h2 class="detail-section__title">Sender Information</h2>
            <div class="detail-row">
                <span class="detail-row__label">Name</span>
                <span class="detail-row__value">{{ $shipment->sender_name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-row__label">Address</span>
                <span class="detail-row__value" style="white-space:pre-line">{{ $shipment->sender_address }}</span>
            </div>
        </div>

        {{-- Receiver --}}
        <div class="detail-section">
            <h2 class="detail-section__title">Receiver Information</h2>
            <div class="detail-row">
                <span class="detail-row__label">Name</span>
                <span class="detail-row__value">{{ $shipment->receiver_name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-row__label">Address</span>
                <span class="detail-row__value" style="white-space:pre-line">{{ $shipment->receiver_address }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-row__label">Destination City</span>
                <span class="detail-row__value">{{ $shipment->destination_city }}</span>
            </div>
        </div>

    </div>

    {{-- Status Timeline --}}
    <div class="card">
        <div style="padding:20px 28px 0; border-bottom:1px solid var(--line)">
            <h2 style="font-family:var(--font-mono); font-size:.7rem; text-transform:uppercase; letter-spacing:.1em; color:var(--muted); margin-bottom:16px">
                Status Timeline
            </h2>
        </div>

        @if($shipment->statusLogs->isEmpty())
            <div class="empty">
                <p class="empty__icon">🕓</p>
                <p class="empty__title">No status updates yet</p>
                <p class="empty__text">Status updates will appear here as the shipment progresses.</p>
            </div>
        @else
            <div class="timeline">
                <div class="timeline__track"></div>

                @foreach($shipment->statusLogs as $log)
                    @php
                        $dotClass = match($log->status) {
                            'Delivered'  => 'timeline__dot--delivered',
                            'In Transit' => 'timeline__dot--transit',
                            default      => 'timeline__dot--pending',
                        };

                        $icon = match($log->status) {
                            'Delivered'  => '✓',
                            'In Transit' => '↻',
                            default      => '○',
                        };
                    @endphp

                    <div class="timeline__item">
                        <div class="timeline__dot {{ $dotClass }}">{{ $icon }}</div>
                        <div class="timeline__content">
                            <div class="timeline__header">
                                <span class="timeline__status">{{ $log->status }}</span>
                                <span class="badge badge--{{ $log->status === 'In Transit' ? 'transit' : Str::slug($log->status) }}"
                                      style="font-size:.7rem; padding:2px 8px">
                                    {{ $log->location }}
                                </span>
                            </div>
                            @if($log->note)
                                <p class="timeline__note">{{ $log->note }}</p>
                            @endif
                            <p class="timeline__time">
                                {{ $log->created_at->format('d M Y, g:i A') }}
                                &nbsp;·&nbsp;
                                {{ $log->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection
