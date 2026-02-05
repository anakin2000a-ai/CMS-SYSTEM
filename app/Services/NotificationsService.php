<?php
namespace App\Services;

use App\Models\Notification_campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;


class NotificationsService
{
public function CreateNewCampaign(Request $request)
{
    // Validate the incoming request data
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'body' => 'required|string',
        'link' => 'nullable|url',
        'image_url' => 'nullable|url',
        'type' => 'nullable|in:general,article,promotion,update',
        'status' => 'nullable|in:draft,scheduled,sending,sent,failed',
        'target_categories' => 'required|array',  // Change to array for easier validation
        'target_categories.*' => 'string',         // Ensure each category is a string
        'recipients_count' => 'required|integer|min:0',
        'delivered_count' => 'required|integer|min:0',
        'opened_count' => 'required|integer|min:0',
        'clicked_count' => 'required|integer|min:0',
        'scheduled_at' => 'nullable|date',
        'sent_at' => 'nullable|date',
    ]);

    // Convert target_categories array to JSON string
    $validated['target_categories'] = json_encode($validated['target_categories']);

    // Create the new notification campaign with the validated data
    $notification = Notification_campaign::create($validated);

    return response()->json([
        'message' => 'Notification campaign created successfully',
        'notification' => $notification,
    ], 201); // 201 Created status code
}



}