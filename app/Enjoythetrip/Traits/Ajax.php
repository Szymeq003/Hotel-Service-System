<?php

namespace App\Enjoythetrip\Traits;

use Illuminate\Http\Request;

trait Ajax {
    

    public function ajaxGetReservationData(Request $request)
    {
        $reservation = $this->bR->getReservationData($request);

        return response()->json([
                    'room_number' => $reservation->room->room_number,
                    'day_in' => $reservation->day_in,
                    'day_out' => $reservation->day_out,
                    'FullName' => $reservation->user->FullName,
                    'userLink' => route('person', ['id' => $reservation->user->id]),
                    'confirmResLink' => route('confirmReservation', ['id' => $reservation->id]),
                    'deleteResLink' => route('deleteReservation', ['id' => $reservation->id]),
                    'status' => $reservation->status
        ]);
    }

}

