<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShipmentController extends Controller
{
    /**
     * Display a paginated list of shipments with optional search.
     */
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->value();

        $shipments = Shipment::query()
            ->search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('shipments.index', compact('shipments', 'search'));
    }

    /**
     * Display detailed view of a single shipment with its status timeline.
     */
    public function show(Shipment $shipment): View
    {
        $shipment->load(['statusLogs']);

        return view('shipments.show', compact('shipment'));
    }
}
