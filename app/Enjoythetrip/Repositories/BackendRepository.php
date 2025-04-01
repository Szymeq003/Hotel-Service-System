<?php

namespace App\Enjoythetrip\Repositories;

use App\{TouristObject};
use App\Enjoythetrip\Interfaces\BackendRepositoryInterface;

class BackendRepository implements BackendRepositoryInterface
{
    public function getOwnerReservations($request)
    {
        return TouristObject::with([
            'rooms' => function ($q) {
                $q->has('reservations');
            },
            'rooms.reservations.user',
        ])
        ->has('rooms.reservations')
        ->where('user_id', $request->user()->id)
        ->get();
    }

    public function getTouristReservations($request)
    {
        return TouristObject::with([
            'rooms.reservations' => function ($q) use ($request) {
                $q->where('user_id', $request->user()->id);
            },
            'rooms' => function ($q) use ($request) {
                $q->whereHas('reservations', function ($query) use ($request) {
                    $query->where('user_id', $request->user()->id);
                });
            },
            'rooms.reservations.user',
        ])
        ->whereHas('rooms.reservations', function ($q) use ($request) {
            $q->where('user_id', $request->user()->id);
        })
        ->get();
    }
}
