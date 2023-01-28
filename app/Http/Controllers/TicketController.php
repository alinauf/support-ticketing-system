<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{

    private $ticketService;


    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ];

        $response = $this->ticketService->store($data);

        if ($response['status']) {
            return redirect()->route('dashboard')->with('success', $response['payload']);
        } else {
            return redirect()->route('dashboard')->with('failure', $response['payload']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Ticket $ticket
     * @return Application|Factory|View
     */
    public function show(Ticket $ticket)
    {
        return view('tickets.show', ['ticket' => $ticket]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

}
