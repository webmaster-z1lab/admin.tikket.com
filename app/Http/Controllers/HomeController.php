<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $events = (new ApiService('permissions', 'GET'))->find()->collect();

        $events_active = collect($events)->filter(function ($item, $key) {
            return in_array($item->relationships->event->attributes->status, ['draft', 'completed', 'published']);
        })->all();

        $events_past = collect($events)->filter(function ($item, $key) {
            return in_array($item->relationships->event->attributes->status, ['finalized', 'canceled']);
        })->all();

        \Meta::set('title', 'Administração de Eventos');

        return View('home.index')
            ->with('events', $events)
            ->with('events_active', $events_active)
            ->with('events_past', $events_past);
    }
}
