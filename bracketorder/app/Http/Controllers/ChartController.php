<?php

namespace App\Http\Controllers;

use App\ChartStudy;
use App\SimpleMovingAverage;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function saveChart(Request $request) {

        $user = DB::table('chart_studies')
            ->where('user_id', '=', Auth::user()->id)
            ->get()->toArray();

        if(!empty($user)) {
            $studies = ChartStudy::find($user[0]->id);
        }

        if(!empty($studies)) {

            $studies->indicator = $request->input('indicator');
            try {
                $studies->save();
            } catch (Exception $e) {
                echo 'Message: ' .$e->getMessage();
            }
        } else {
            $study = new ChartStudy();

            $study->user_id = Auth::user()->id;
            $study->indicator = $request->input('indicator');

            try {
                $study->save();
            } catch (Exception $e) {
                echo 'Message: ' . $e->getMessage();
            }
        }

        $user = DB::table('simple_moving_averages')
            ->where('user_id', '=', Auth::user()->id)
            ->get()->toArray();

        if(!empty($user)) {
            $smas = SimpleMovingAverage::find($user[0]->id);
        }

        if(!empty($smas)) {

            $smas->sma_number_1 = $request->input('sma_1');
            $smas->sma_number_2 = $request->input('sma_2');
            $smas->sma_number_3 = $request->input('sma_3');

            $smas->periods_1 = $request->input('sma_periods_1');
            $smas->periods_2 = $request->input('sma_periods_2');
            $smas->periods_3 = $request->input('sma_periods_3');

            $smas->color_1 = $request->input('sma_color_1');
            $smas->color_2 = $request->input('sma_color_2');
            $smas->color_3 = $request->input('sma_color_3');

            try {
                $smas->save();
            } catch (Exception $e) {
                echo 'Message: ' .$e->getMessage();
            }
        } else {
            $smas = new SimpleMovingAverage();

            $smas->user_id = Auth::user()->id;
            $smas->sma_number_1 = $request->input('sma_1');
            $smas->sma_number_2 = $request->input('sma_2');
            $smas->sma_number_3 = $request->input('sma_3');

            $smas->periods_1 = $request->input('sma_periods_1');
            $smas->periods_2 = $request->input('sma_periods_2');
            $smas->periods_3 = $request->input('sma_periods_3');

            $smas->color_1 = $request->input('sma_color_1');
            $smas->color_2 = $request->input('sma_color_2');
            $smas->color_3 = $request->input('sma_color_3');

            try {
                $smas->save();
            } catch (Exception $e) {
                echo 'Message: ' .$e->getMessage();
            }
        }
    }

    public function getIndicator(Request $request) {

        $user = DB::table('chart_studies')
            ->where('user_id', '=', Auth::user()->id)
            ->get()->toArray();

        if(!empty($user)) {
            $studies = ChartStudy::find($user[0]->id);

            $smas = SimpleMovingAverage::find($user[0]->id);

            $smas = json_decode($smas, true);

            return response()->json(['study' => $studies->indicator, 'smas' => $smas], 200);
        } else {
            return response()->json(['study' => "default_chart", 'smas' => "default_chart"], 200);
        }
    }

    public function getSMA(Request $request) {

        $user = DB::table('simple_moving_averages')
            ->where('user_id', '=', Auth::user()->id)
            ->get()->toArray();

        if(!empty($user)) {
            $smas = SimpleMovingAverage::find($user[0]->id);

            $smas = json_decode($smas, true);

            return response()->json($smas, 200);
        } else {
            return null;
        }
    }

    public function getChart() {
        return view('mobile/partials/chart/chart');
    }
}
