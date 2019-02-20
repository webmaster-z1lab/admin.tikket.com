<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * @return View
     */
    public function myEvents(): View
    {
        $events = (new ApiService('events/my_events', 'GET'))->find()->collect();

        $events_active = collect($events)->filter(function ($item, $key) {
            return in_array($item->attributes->status, ['draft', 'completed', 'published']);
        })->all();

        $events_past = collect($events)->filter(function ($item, $key) {
            return in_array($item->attributes->status, ['finalized', 'canceled']);
        })->all();

        \Meta::set('title', 'Eventos');

        return View('event.my-events', compact('events', 'events_active', 'events_past'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        \Meta::set('title', 'Criar evento');

        return View('event.create');
    }

    /**
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $event = (new ApiService('events', 'GET'))->find($id)->collect();

        \Meta::set('title', $event->attributes->name);
        \Meta::set('description', $event->attributes->description);

        return View('event.edit')
            ->with('event', $event);
    }


}
