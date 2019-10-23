<?php

namespace App\Http\Controllers;

use App\Model\Area;
use App\Model\Location;
use App\Model\UsersArea;
use App\Model\User;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userAreas = UsersArea::where('user_id', \Auth::user()->id)->get(['area_id']);

        return $userAreas;
    }

    public function getAreas($childId){
        //$child = User::findOrFail($childId);

        $areasIds = UsersArea::where('user_id',$childId)->get(['area_id']);

        $areas = [];

        foreach ($areasIds as $areaId){
            $area = Area::with('location')->find($areaId);
            $areas []= $area[0]->toArray();
        }

        //$areas = UsersArea::with('area')->where('user_id',$childId)->get();

        return ["data" => $areas];//['data' => $areas];
    }

    public function addArea(Request $request)
    {
        $this->validate($request, [
            'label' => 'required',
            'adresse' => 'required',
            'category' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
            'child_id' => 'required|integer',
            'from' => 'required|date_format:H:i',
            'to' => 'required|date_format:H:i|after:from',
        ]);
        //Creation des coordonnées géographiques
        $location = Location::create([
            'longitude' => $request->input('longitude'),
            'latitude' => $request->input('latitude')
        ]);

        //Création du lieu de l'enfant
        $area = Area::create([
            'label' => $request->input('label'),
            'adresse' => $request->input('adresse'),
            'category' => $request->input('category'),
            'location_id' => $location->id,
            'from' => $request->input('from'),
            'to' => $request->input('to'),
        ]);

        // Lier l'enfant et le lieu
        UsersArea::create([
            'user_id' => $request->input('child_id'),
            'area_id' => $area->id
        ]);

        return [
            'id' => $area->id,
            'location_id' => $location->id,
            'label' => $area->label,
            'category' => $area->category,
            'longitude' => $location->longitude,
            'latitude' => $location->latitude,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show(Area $area)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Area $area)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Area $area)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        //
    }
}
