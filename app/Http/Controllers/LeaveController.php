<?php

namespace App\Http\Controllers;

use App\WorkingDays;
use DateTime;
use Illuminate\Http\Request;
use App\Leave;
use App\Http\Resources\LeaveResource;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return LeaveResource::collection(Leave::where("user_id", $request->user()->id)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return LeaveResource
     */
    public function store(Request $request)
    {
        $from = DateTime::createFromFormat('Y-m-d', $request->from);
        $until = DateTime::createFromFormat('Y-m-d', $request->until);

        if ($from && $until) {
            $from->setTime(0, 0, 0);
            $until->setTime(0, 0, 0);
            if ($from > $until) {
                return response()->json(['error' => 'From can not be greater than Until date'], 422);
            } else {
                $days = WorkingDays::calculateWorkingDays($from, $until);
                $leave = Leave::create([
                    'user_id' => $request->user()->id,
                    'from' => $request->from,
                    'until' => $request->until,
                    'days' => $days,
                ]);

                return new LeaveResource($leave);
            }
        } else {
            return response()->json(['error' => 'From and Until dates must be in Y-m-d format'], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Leave $leaf
     * @return LeaveResource
     */
    public function show(Request $request, Leave $leaf)
    {
        // check if currently authenticated user is the owner of the leave
        if ($request->user()->id !== $leaf->user_id) {
            return response()->json(['error' => 'You can only view your own leaves.'], 403);
        }

        return new LeaveResource($leaf);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Leave $leaf
     * @return LeaveResource
     */
    public function update(Request $request, Leave $leaf)
    {
        // check if currently authenticated user is the owner of the leave
        if ($request->user()->id !== $leaf->user_id) {
            return response()->json(['error' => 'You can only edit your own leaves.'], 403);
        }

        if (isset($request->from)) {
            $from = DateTime::createFromFormat('Y-m-d', $request->from);
            if ($from) {
                $from->setTime(0, 0, 0);
                $leaf->from = $request->from;
            } else {
                return response()->json(['error' => 'From and Until dates must be in Y-m-d format'], 422);
            }
        } else {
            $from = DateTime::createFromFormat('Y-m-d', $leaf->from);
        }

        if (isset($request->until)) {
            $until = DateTime::createFromFormat('Y-m-d', $request->until);
            if ($until) {
                $until->setTime(0, 0, 0);
                $leaf->until = $request->until;
            } else {
                return response()->json(['error' => 'From and Until dates must be in Y-m-d format'], 422);
            }
        } else {
            $until = DateTime::createFromFormat('Y-m-d', $leaf->until);
        }

        if ($from > $until) {
            return response()->json(['error' => 'From can not be greater than Until date'], 422);
        }

        if (isset($request->from) || isset($request->until)) {
            $leaf->days = WorkingDays::calculateWorkingDays($from, $until);
        }

        $leaf->save();

        return new LeaveResource($leaf);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Leave $leaf
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, Leave $leaf)
    {
        // check if currently authenticated user is the owner of the leave
        if ($request->user()->id !== $leaf->user_id) {
            return response()->json(['error' => 'You can only delete your own leaves.'], 403);
        }

        $leaf->delete();

        return response()->json(null, 204);
    }

    public function __construct()
    {
        $this->middleware('auth:api');
    }
}
