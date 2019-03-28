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
        $events = (new ApiService('permissions', 'GET'))->find()->collect();

        $events_active = collect($events)->filter(function ($item, $key) {
            return in_array($item->relationships->event->attributes->status, ['draft', 'completed', 'published']);
        })->all();

        $events_past = collect($events)->filter(function ($item, $key) {
            return in_array($item->relationships->event->attributes->status, ['finalized', 'canceled']);
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function administration(string $id): View
    {
        $this->authorize('admin', $id);

        $event = (new ApiService('events', 'GET'))->find($id)->collect();

        \Meta::set('title', $event->attributes->name);
        \Meta::set('description', $event->attributes->description);

        return View('event.administration')
            ->with('event', $event);
    }

    /**
     * @param string $id
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function orderManual(string $id): View
    {
        $this->authorize('pdv', $id);

        $event = (new ApiService('events', 'GET'))->find($id)->collect();

        \Meta::set('title', $event->attributes->name);
        \Meta::set('description', $event->attributes->description);

        return View('event.order-manual')
            ->with('event', $event);
    }
}
