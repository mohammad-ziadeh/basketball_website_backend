<?php

namespace App\Http\Controllers\shared;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return response()->json($events);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'venue' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:event-primary,event-secondary,event-success,event-danger,event-warning,event-info',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $event = Event::create($validated);

        return response()->json($event);
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'venue' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:event-primary,event-secondary,event-success,event-danger,event-warning,event-info',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $event->update($validated);

        return response()->json($event);
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['success' => true]);
    }
}
