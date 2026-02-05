<?php

namespace App\Http\Controllers;

use App\Models\Notification_campaign;
use App\Services\NotificationsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationCampaignMail;
use App\Models\User;

class NotificationCampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function ListNotifications()
    {
        $notifications=Notification_campaign::all();
        return response()->json(['status'=>'success','All notifications'=>$notifications]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function CreateCampaign(Request $request,NotificationsService $NotificationsService) {
        $Notifications=$NotificationsService->CreateNewCampaign($request);
        return $Notifications;
    }
    public function GetCampaignById($id)
    {
        // Find the campaign using the provided ID
        $campaign = Notification_campaign::find($id);

        // Check if the campaign exists
        if (!$campaign) {
            return response()->json([
                'success' => false,
                'message' => 'Campaign not found'
            ], 404); // Return a 404 error if the campaign is not found
        }

        // Return the campaign data with a 200 OK status
        return response()->json([
            'success' => true,
            'data' => $campaign
        ], 200);
    }
    public function SendCampaign($id)
    {
        // 1. Retrieve the campaign using the ID
        $notification = Notification_campaign::find($id);

        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => 'Notification campaign not found'
            ], 404);
        }

        // 2. Retrieve the users to whom the notification should be sent
        // Customize this query based on the target categories or any other criteria
        $users = User::where('is_active', true)->get();

        // 3. Send the notification to the users
        foreach ($users as $user) {
            // Send an email (if you have email setup in Laravel)
            Mail::to($user->email)->send(new NotificationCampaignMail($notification));

        }

        // 4. Update the campaign status to "sent" after sending notifications
        $notification->update(['status' => 'sent']);

        // 5. Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Notification campaign sent successfully',
            'data' => $notification
        ], 200);
    }




  
}
