<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Ticket;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class SummaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /* MENGAMBIL WAKTU HARI INI DAN KEMARIN */
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        /* PENDAPATAN */
        // Hitung Pendapatan dan persentase kenaikan
        $todayRevenue = (float) Order::whereDate('created_at', $today)->sum('total_price') ?? 0; // Pendapatan hari ini
        $yesterdayRevenue = (float) Order::whereDate('created_at', $yesterday)->sum('total_price') ?? 0; // Pendapatan kemarin
        $diffRevenue = $todayRevenue - $yesterdayRevenue; // Selisih pendapatan hari ini - kemarin

        $percentageChange = 0;

        if ($yesterdayRevenue == 0) {
            if ($diffRevenue > 0) {
                $percentageChange = 100; // Jika pendapatan hari ini lebih dari 0 dan pendapatan kemarin 0, maka persentase 100%
            } else {
                $percentageChange = 0; // Jika pendapatan hari ini dan kemarin sama-sama 0, maka persentase 0%
            }
        } else {
            $percentageChange = round(($diffRevenue / $yesterdayRevenue) * 100, 0); // Hitung persentase perubahan normal
        }

        $isIncreaseRevenue = $diffRevenue >= 0 ? true : false; // apakah pendapatan hari ini minus

        /* TIKET TERJUAL*/
        // Hitung jumlah tiket terjual dan persentase kenaikan
        $todayTicketSold = (float) Order::whereDate('created_at', $today)->sum('total_item');
        $yesterdayTicketSold = (float) Order::whereDate('created_at', $yesterday)->sum('total_item');

        $diffTicketSold = $todayTicketSold - $yesterdayTicketSold;
        $percentageChangeTicketSold = 0;

        if ($yesterdayTicketSold == 0) {
            if ($diffTicketSold > 0) {
                $percentageChangeTicketSold = 100;
            } else {
                $percentageChangeTicketSold = 0;
            }
        } else {
            $percentageChangeTicketSold = round(($diffTicketSold / $yesterdayTicketSold) * 100, 0);
        }
        
        $isIncreaseTicketSold = $diffTicketSold >= 0 ? true : false;

        /* TIKET KUOTA*/
        $tickets = Ticket::all()->map(function ($ticket) {
            $today = Carbon::today();
            $sold = (float) OrderItem::where('ticket_id', $ticket->id)
                ->whereDate('created_at', $today)
                ->sum('qty');

            return [
                'id' => $ticket->id,
                'type' => $ticket->type,
                'name' => $ticket->name,
                'sold' => $sold,
                'quota' => $ticket->quota,
            ];
        });

        return response()->json(
            [
                'status' => true,
                'message' => 'Berhasil mendapatkan summary',
                'data' => [
                    'revenue' => [
                        'value' => $todayRevenue,
                        'percentage' => $percentageChange,
                        'is_increase' => $isIncreaseRevenue,
                    ],
                    'ticket_sold' => [
                        'value' => $todayTicketSold,
                        'percentage' => $percentageChangeTicketSold,
                        'is_increase' => $isIncreaseTicketSold,
                    ],
                    'ticket_quota' => $tickets,
                ],
            ],
            200,
        );
    }
}
