<?php

namespace App\Http\Controllers;

use App\Models\Notification_campaign;
use App\Services\NotificationsService;
use Illuminate\Http\Request;

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



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification_campaign $notification_campaign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notification_campaign $notification_campaign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification_campaign $notification_campaign)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification_campaign $notification_campaign)
    {
        //
    }
}
