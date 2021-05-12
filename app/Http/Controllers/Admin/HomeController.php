<?php

namespace App\Http\Controllers\Admin;

use Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Ticket;

class HomeController
{
    public function index()
    {
        abort_if(Gate::denies('dashboard_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $totalTickets = Ticket::count();
        $openTickets = Ticket::whereHas('status', function($query) {
            $query->whereName('Aberto');
        })->count();
        $closedTickets = Ticket::whereHas('status', function($query) {
            $query->whereName('Solucionado');
        })->count();
        $progressTickets = Ticket::whereHas('status', function($query) {
            $query->whereName('Em progresso');
        })->count();
        $cancelledTickets = Ticket::whereHas('status', function($query) {
            $query->whereName('Cancelado');
        })->count();

        return view('home', compact('totalTickets', 'openTickets', 'closedTickets', 'progressTickets', 'cancelledTickets'));
    }
}
