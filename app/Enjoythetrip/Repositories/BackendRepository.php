<?php

namespace App\Enjoythetrip\Repositories;

use App\Enjoythetrip\Interfaces\BackendRepositoryInterface;
use App\{TouristObject,Reservation};

class BackendRepository implements BackendRepositoryInterface  {   

    public function getOwnerReservations($request)
    {
        return TouristObject::with([

                  'rooms' => function($q) {
                        $q->has('reservations'); 
                    },

                    'rooms.reservations.user'

                  ])
                    ->has('rooms.reservations') 
                    ->where('user_id', $request->user()->id)
                    ->get();
    }

    public function getTouristReservations($request)
    {

       return TouristObject::with([

                    'rooms.reservations' => function($q) use($request) { 
                        $q->where('user_id',$request->user()->id);

                    },

                    'rooms'=>function($q) use($request){
                        $q->whereHas('reservations',function($query) use($request){
                            $query->where('user_id',$request->user()->id);
                        });
                    },
                    
                    'rooms.reservations.user'

                  ])

                    ->whereHas('rooms.reservations',function($q) use($request){

                        $q->where('user_id',$request->user()->id);

                    })
                    ->get();
    }

    public function getReservationData($request)
    {
        return  Reservation::with('user', 'room')
                ->where('room_id', $request->input('room_id'))
                ->where('day_in', '<=', date('Y-m-d', strtotime($request->input('date'))))
                ->where('day_out', '>=', date('Y-m-d', strtotime($request->input('date'))))
                ->first();
    }
 
    public function getReservation($id)
    {
        return Reservation::find($id);
    }

    public function deleteReservation(Reservation $reservation)
    {
        return $reservation->delete();
    }

    public function confirmReservation(Reservation $reservation)
    {
        return $reservation->update(['status' => true]);
    }
    
}


