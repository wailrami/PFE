<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\Infrastructure;
use App\Models\Notification;
use App\Models\Pool;
use App\Models\Reservation;
use App\Models\Stadium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    //

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $reservations = Reservation::where('client_id', Auth::user()->client->id)->orderBy('etat', 'asc')->get();
        
        return view('reservation.my_reservations', compact('reservations'));
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

        if(!Reservation::validateReservation($request->infrastructure_id, $request->res_date, $request->start_time, $request->end_time)){
            return redirect()->back()
            ->with('error', 'Date and Time are not available! Please choose another date and time. Look at the Calendar');
        }
        $reservation = new Reservation();
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
        $notification->type = 'reservation';
        $notification->user_id = Infrastructure::find($reservation->infrastructure_id)->gestionnaire->user->id;
        $notification->save();

        return redirect()->back()
        ->with('success', 'Reservation request sent successfully. Please wait for the confirmation from the Manager. ');
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
        return view('reservation.edit', compact('reservation'));
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
        $notification->type = 'reservation';
        $notification->user_id = $reservation->infrastructure->gestionnaire->user->id;
        $notification->save();
        return redirect()->back()
        ->with('success', 'Reservation cancelled seccessfully!');
    }

    public function requests()
    {
        $reservations = auth()->user()->gestionnaire->reservations()->where('etat', 'enattente')->get();
        return view('reservation.requests', compact('reservations'));
    }

    public function accept($id)
    {
        $reservation = Reservation::find($id);
        $reservation->etat = 'accepte';
        $reservation->save();
        //Notification
        $notification = new Notification();
        $notification->title = 'Reservation Accepted';
        $notification->content = 'Your reservation has been accepted. You can now view it in your reservations list.';
        $notification->type = 'reservation';
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
        $notification->content = 'Your reservation has been rejected. Please contact the manager for more information.';
        $notification->type = 'reservation';
        $notification->user_id = $reservation->client->user->id;
        $notification->save();

        return redirect()->route('gestionnaire.reservations.requests')
        ->with('success', 'Reservation rejected successfully!');
    }
}
