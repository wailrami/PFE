<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\Infrastructure;
use App\Models\Notification;
use App\Models\Pool;
use App\Models\Reservation;
use App\Models\ReservationPeriodique;
use App\Models\Stadium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    //

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $reservations = Reservation::where('client_id', Auth::user()->client->id)
        // ->whereNull('periodic_reservation_id')
        //order by the enumeartion of etat like this (enattente, accepte, refuse)
        ->orderByRaw("FIELD(etat, 'enattente', 'accepte', 'refuse')")
        ->get();
        $periodicReservations = ReservationPeriodique::where('client_id', Auth::user()->client->id)
        //order by the enumeartion of etat like this (pending, accepted, rejected)
        ->orderByRaw("FIELD(etat, 'pending', 'accepted', 'rejected')")
        ->get();
        
        return view('reservation.my_reservations', compact('reservations', 'periodicReservations'));
    }

    public function indexApi(Request $request)
    {
        $request->user()->load('client');
        $reservations = Reservation::where('client_id', $request->user()->client->id)
        ->orderByRaw("FIELD(etat, 'enattente', 'accepte', 'refuse')")
        ->get();
        $periodicReservations = ReservationPeriodique::where('client_id', $request->user()->client->id)
        ->orderByRaw("FIELD(etat, 'pending', 'accepted', 'rejected')")
        ->get();
        
        return response()->json(['reservations' => $reservations, 'periodic_reservations' => $periodicReservations]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        if($request->query('id') == null){
            if($request->query('type') != null){
                if($request->query('type') == 'stadium'){
                    $infrastructures = Infrastructure::getAllStadiums();
                    
                } else if($request->query('type') == 'pool'){
                    $infrastructures = Infrastructure::getAllPools();
                    
                } else if($request->query('type') == 'hall'){
                    $infrastructures = Infrastructure::getAllHalls();
                }
                if($request->query('infrastructure_id') != null){
                    $id = $request->query('infrastructure_id');
                    $infrastructure = Infrastructure::find($id);
                    $reservations = Reservation::where('infrastructure_id', $id)->where('etat', 'accepte')->get();
                    return view('reservation.create', compact('id'))->with('infrastructure', $infrastructure)
                    ->with('reservations', $reservations);
                }
                return view('reservation.create')->with('infrastructures', $infrastructures);
            }
            $infrastructures = Infrastructure::all();
            return view('reservation.create')->with('infrastructures', $infrastructures);
        } else {
            $id = $request->query('id');
            $infrastructure = Infrastructure::find($id);
            $reservations = Reservation::where('infrastructure_id', $id)->where('etat', 'accepte')->get();
            return view('reservation.create', compact('id'))->with('infrastructure', $infrastructure)
            ->with('reservations', $reservations);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'res_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'infrastructure_id' => 'required'
        ],[
            'res_date.required' => 'Date is required',
            'start_time.required' => 'Start Time is required',
            'end_time.required' => 'End Time is required',
            'end_time.after' => 'End Time must be after Start Time',
            'infrastructure_id.required' => 'Infrastructure is required'
        ]);

        if($request->periodicReservation){
            $request->validate([
                'period' => 'required|in:daily,weekly,monthly',
                'end_date' => 'required|date|after:res_date'
            ],[
                'period.required' => 'Period is required',
                'period.in' => 'Invalid Period',
                'end_date.required' => 'End Date is required',
                'end_date.after' => 'End Date must be after Start Date'
            ]);

            $periodicReservation = new ReservationPeriodique();
            $periodicReservation->start_date = $request->res_date;
            $periodicReservation->start_time = $request->start_time;
            $periodicReservation->end_time = $request->end_time;
            $periodicReservation->type_period = $request->period;
            $periodicReservation->end_date = $request->end_date;
            $periodicReservation->etat = 'pending';
            $periodicReservation->infrastructure_id = $request->infrastructure_id;
            $periodicReservation->client_id = Auth::user()->client->id;

            $availabilityCheck = $this->checkAvailabilityForPeriod($periodicReservation, $request->period, $request->end_date);

            if ($availabilityCheck['status']) {
                // Wrap the following operations in a database transaction
                DB::transaction(function () use ($periodicReservation, $availabilityCheck) {
                    // Save the periodic reservation to the database
                    $periodicReservation->save();

                    // Create individual reservations based on the periodic reservation details
                    $this->createReservations($availabilityCheck['dates'], $periodicReservation);
                });

                // Return a success response
                return response()->with('success', 'Periodic reservation created successfully');
            } else {
                // Return an error response if any date is unavailable
                return response()->with('error', 'One or more dates are unavailable');
            }

        }
        else
        {

            
            if(!Reservation::validateReservation($request->infrastructure_id, $request->res_date, $request->start_time, $request->end_time)){
                return redirect()->back()
                ->with('error', 'Date and Time are not available! Please choose another date and time. Look at the Calendar');
            }
            $reservation = new Reservation();
            $reservation->periodic_reservation_id = null;
            $reservation->res_date = $request->res_date;
            //convert time to 24H format
            $reservation->start_time = date("H:i", strtotime($request->start_time));
            $reservation->end_time = date("H:i", strtotime($request->end_time));
            
            $reservation->infrastructure_id = $request->infrastructure_id;
            $reservation->client_id = Auth::user()->client->id;
            
            
            $reservation->etat = 'enattente';
            $reservation->save();
            
            //Notification informing the manager of the reservation request specifying the infrastructure
            $notification = new Notification();
            $notification->title = 'New Reservation Request';
            $notification->content = 'A new reservation request has been made for '.$reservation->infrastructure->name.' on '.$reservation->res_date.'.';
            $notification->type = 'reservation_gestionnaire';
            $notification->user_id = Infrastructure::find($reservation->infrastructure_id)->gestionnaire->user->id;
            $notification->save();
            
            return redirect()->back()
            ->with('success', 'Reservation request sent successfully. Please wait for the confirmation from the Manager. ');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show( Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( Reservation $reservation)
    {
        //
        $reservations = Reservation::where('infrastructure_id', $reservation->infrastructure_id)->where('etat', 'accepte')->get();
        return view('reservation.edit', compact('reservation', 'reservations'));
    }

    public function editPeriodic( ReservationPeriodique $periodicReservation)
    {
        //
        $reservations = Reservation::where('infrastructure_id', $periodicReservation->infrastructure_id)->where('etat', 'accepte')->get();
        return view('reservation.editPeriodic', compact('periodicReservation', 'reservations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
        $request->validate([
            'res_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ],[
            'res_date.required' => 'Date is required',
            'start_time.required' => 'Start Time is required',
            'end_time.required' => 'End Time is required',
            'end_time.after' => 'End Time must be after Start Time',
        ]);


        if(!Reservation::validateReservation($reservation->infrastructure->infrastructure_id, $request->res_date, $request->start_time, $request->end_time)){
            return redirect()->back()
            ->with('error', 'Date and Time are not available! Please choose another date and time. Look at the Calendar');
        }
        $reservation->res_date = $request->res_date;
        //convert time to 24H format
        $reservation->start_time = date("H:i", strtotime($request->start_time));
        $reservation->end_time = date("H:i", strtotime($request->end_time));


        $reservation->save();

        return redirect()->route('reservations.index')->with('success', 'Reservation modifiée avec succès!');
    }

    public function updatePeriodic(Request $request, ReservationPeriodique $periodicReservation)
    {
        //
        // dd($periodicReservation->id);
        $request->validate([
            'res_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'period' => 'required|in:daily,weekly,monthly',
            'end_date' => 'required|date|after:start_date'
        ],[
            'res_date.required' => 'Start Date is required',
            'start_time.required' => 'Start Time is required',
            'end_time.required' => 'End Time is required',
            'end_time.after' => 'End Time must be after Start Time',
            'period.required' => 'Period is required',
            'period.in' => 'Invalid Period',
            'end_date.required' => 'End Date is required',
            'end_date.after' => 'End Date must be after Start Date'
        ]);
        $periodicReservation->start_date = $request->res_date;
        $periodicReservation->start_time = $request->start_time;
        $periodicReservation->end_time = $request->end_time;
        $periodicReservation->type_period = $request->period;
        $periodicReservation->end_date = $request->end_date;
        $periodicReservation->etat = 'pending';

        $availabilityCheck = $this->checkAvailabilityForPeriod($periodicReservation, $request->period, $request->end_date);

        if ($availabilityCheck['status']) {
            // Wrap the following operations in a database transaction
            DB::transaction(function () use ($periodicReservation, $availabilityCheck) {
                // Save the periodic reservation to the database
                $periodicReservation->save();

                // Delete all existing reservations for this periodic reservation
                Reservation::where('periodic_reservation_id', $periodicReservation->id)
                ->where('etat', 'enattente')
                // ->where('res_date', '=', $periodicReservation->start_date)
                ->where('start_time', '=', $periodicReservation->start_time)
                ->where('end_time', '=', $periodicReservation->end_time)
                ->delete();

                // Create individual reservatio  ns based on the periodic reservation details
                $this->createReservations($availabilityCheck['dates'], $periodicReservation);
            });

            // Return a success response
            return redirect()->back()->with('success', 'Periodic reservation updated successfully');
        } else {
            // Return an error response if any date is unavailable
            return redirect()->back()->with('error', 'One or more dates are unavailable');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Reservation $reservation)
    {
        //
        $reservation->delete();
        //Notification for the manager with specifying which reservation has been cancelled
        $notification = new Notification();
        $notification->title = 'Reservation Cancelled';
        $notification->content = 'The reservation for '.$reservation->infrastructure->name.' on '.$reservation->res_date.' has been cancelled.';
        $notification->type = 'reservation_gestionnaire';
        $notification->user_id = $reservation->infrastructure->gestionnaire->user->id;
        $notification->save();
        return redirect()->back()
        ->with('success', 'Reservation cancelled seccessfully!');
    }

    public function requests()
    {
        $reservations = auth()->user()->gestionnaire->reservations()->where('etat', 'enattente')
        // ->get();
        // ->where('res_date', '>=', date('Y-m-d'))
        // ->where('start_time', '>=', date('H:i:s'))
        ->orderBy('res_date', 'asc')->orderBy('start_time', 'asc')
        // ->get();
        ->whereNull('periodic_reservation_id')
        ->get();
        
        $periodicReservations = auth()->user()->gestionnaire->periodicReservations()->where('etat', 'pending')
        // ->where('start_date', '>=', date('Y-m-d'))
        // ->where('start_time', '>=', date('H:i:s'))
        ->orderBy('start_date', 'asc')->orderBy('start_time', 'asc')
        ->get();
        return view('reservation.requests', compact('reservations', 'periodicReservations'));
    }

    public function accept($id)
    {
        $reservation = Reservation::find($id);
        $reservation->etat = 'accepte';
        $reservation->save();
        //Notification
        $notification = new Notification();
        $notification->title = 'Reservation Accepted';
        //specify the name and date
        $notification->content = 'Your reservation for '.$reservation->infrastructure->name.' on '.$reservation->res_date.' has been accepted.';
        $notification->type = 'reservation_client';
        $notification->user_id = $reservation->client->user->id;
        $notification->save();
        return redirect()->route('gestionnaire.reservations.requests')
        ->with('success', 'Reservation accepted successfully!');
    }

    public function reject($id)
    {
        $reservation = Reservation::find($id);
        $reservation->etat = 'refuse';
        $reservation->save();
        //Notification
        $notification = new Notification();
        $notification->title = 'Reservation Rejected';
        //specify the name and date
        $notification->content = 'Your reservation for '.$reservation->infrastructure->name.' on '.$reservation->res_date.' has been rejected.';
        //TODO
        $notification->type = 'reservation_client';
        $notification->user_id = $reservation->client->user->id;
        $notification->save();

        return redirect()->route('gestionnaire.reservations.requests')
        ->with('success', 'Reservation rejected successfully!');
    }




    public function acceptPeriodic($id)
    {
        $periodicReservation = ReservationPeriodique::find($id);
        $periodicReservation->etat = 'accepted';
        $periodicReservation->save();
        $notification = new Notification();
        $notification->title = 'Reservation Accepted';
        //specify the name and date
        $notification->content = 'Your periodic reservation for '.$periodicReservation->infrastructure->name.' has been accepted.';
        $notification->type = 'periodic_reservation_client';
        $notification->user_id = $periodicReservation->client->user->id;
        $notification->save();
        //get all reservations for this periodic reservation checking if has the same start date and time and end time
        $reservations = Reservation::where('periodic_reservation_id', $id)->where('etat', 'enattente')
        // ->where('res_date', '=', $periodicReservation->start_date)
        ->where('start_time', '=', $periodicReservation->start_time)
        ->where('end_time', '=', $periodicReservation->end_time)
        ->get();
        foreach ($reservations as $reservation) {
            $reservation->etat = 'accepte';
            $reservation->save();
        }

        return redirect()->route('gestionnaire.reservations.requests')
        ->with('success', 'Periodic reservation accepted successfully!');
    }


    public function rejectPeriodic($id)
    {
        $periodicReservation = ReservationPeriodique::find($id);
        $periodicReservation->etat = 'rejected';
        $periodicReservation->save();
        $notification = new Notification();
        $notification->title = 'Reservation Rejected';
        //specify the name and date
        $notification->content = 'Your periodic reservation for '.$periodicReservation->infrastructure->name.' has been rejected.';
        $notification->type = 'periodic_reservation_client';
        $notification->user_id = $periodicReservation->client->user->id;
        $notification->save();
        //get all reservations for this periodic reservation checking if has the same start date and time and end time
        $reservations = Reservation::where('periodic_reservation_id', $id)->where('etat', 'enattente')
        ->where('start_time', '=', $periodicReservation->start_time)
        ->where('end_time', '=', $periodicReservation->end_time)
        ->get();
        foreach ($reservations as $reservation) {
            $reservation->etat = 'refuse';
            $reservation->save();
        }

        return redirect()->route('gestionnaire.reservations.requests')
        ->with('success', 'Periodic reservation rejected successfully!');
    }






    protected function createReservations($dates, $periodicReservation)
    {
        $start_time = $periodicReservation->start_time;
        $end_time = $periodicReservation->end_time;
        $infrastructure_id = $periodicReservation->infrastructure_id;
        $client_id = $periodicReservation->client_id;

        // Loop through the dates and create individual reservations
        foreach ($dates as $date) {
            Reservation::create([
                'res_date' => $date,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'etat' => 'enattente',
                'infrastructure_id' => $infrastructure_id,
                'client_id' => $client_id,
                'periodic_reservation_id' => $periodicReservation->id,
            ]);
        }
    }

    protected function checkAvailability($date, $start_time, $end_time, $infrastructure_id)
    {
        // Check if there are any existing reservations that conflict with the given date and time
        $conflict = Reservation::where('infrastructure_id', $infrastructure_id)
            ->where('res_date', $date)
            ->where('etat', 'accepte')
            ->where(function ($query) use ($start_time, $end_time) {
                $query->whereBetween('start_time', [$start_time, $end_time])
                      ->orWhereBetween('end_time', [$start_time, $end_time])
                      ->orWhere(function ($query) use ($start_time, $end_time) {
                          $query->where('start_time', '<', $start_time)
                                ->where('end_time', '>', $end_time);
                      });
            })
            ->exists();

        return !$conflict;
    }



    protected function getNextDate($current_date, $type_period)
    {
        // Calculate the next date based on the type of period
        switch ($type_period) {
            case 'daily':
                return date('Y-m-d', strtotime($current_date . ' +1 day'));
            case 'weekly':
                return date('Y-m-d', strtotime($current_date . ' +1 week'));
            case 'monthly':
                return date('Y-m-d', strtotime($current_date . ' +1 month'));
            default:
                throw new \Exception('Invalid period type');
        }
    }




    protected function checkAvailabilityForPeriod($periodicReservation, $type_period, $end_date)
    {
        $start_date = $periodicReservation->start_date;
        $start_time = $periodicReservation->start_time;
        $end_time = $periodicReservation->end_time;
        $infrastructure_id = $periodicReservation->infrastructure_id;

        $current_date = $start_date;
        $dates = [];

        // Loop through the dates and check availability
        while ($current_date <= $end_date) {
            $isAvailable = $this->checkAvailability($current_date, $start_time, $end_time, $infrastructure_id);

            if (!$isAvailable) {
                return ['status' => false, 'dates' => []];
            }

            $dates[] = $current_date;
            $current_date = $this->getNextDate($current_date, $type_period);
        }

        return ['status' => true, 'dates' => $dates];
    }

    public function cancelPeriodic($id)
    {
        $periodicReservation = ReservationPeriodique::find($id);
        $periodicReservation->delete();

        //Notification
        $notification = new Notification();
        $notification->title = 'Periodic Reservation Cancelled';
        //specify the name and date
        $notification->content = 'Your periodic reservation for '.$periodicReservation->infrastructure->name.' has been cancelled.';
        $notification->type = 'periodic_reservation_client';
        $notification->user_id = $periodicReservation->client->user->id;
        $notification->save();

        return redirect()->route('reservations.index')
        ->with('success', 'Periodic reservation cancelled successfully!');
    }


    
}
