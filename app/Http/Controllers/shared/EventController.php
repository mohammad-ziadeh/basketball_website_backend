<?php

namespace App\Http\Controllers\shared;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\EventCreatedNotification;


class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();

        $users = User::whereNotNull('dob')->get();
        $birthdayEvents = [];

        foreach ($users as $user) {
            $dob = \Carbon\Carbon::parse($user->dob);

            // Generate for this year and next year
            for ($i = 0; $i < 2; $i++) {
                $year = now()->year + $i;
                $birthday = $dob->copy()->year($year); // keep same month/day, just change year

                $birthdayEvents[] = [
                    'id' => 'birthday-' . $user->id . '-' . $year,
                    'title' => $user->name . "'s Birthday 🎂 (Turns " . $birthday->diffInYears($dob) . ")",
                    'start_date' => $birthday->format('Y-m-d'),
                    'end_date' => $birthday->format('Y-m-d'),
                    'description' => $user->name . "'s Birthday",
                    'venue' => null,
                    'type' => 'event-info',
                ];
            }
        }

        $allEvents = array_merge($events->toArray(), $birthdayEvents);

        return response()->json($allEvents);
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

        $users = User::whereIn('role', ['parent', 'player', 'admin'])->get();

        foreach ($users as $user) {
            $user->notify(new EventCreatedNotification($event));
        }

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
