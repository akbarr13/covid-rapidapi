<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\CovidData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class ProjectController extends Controller
{
    public function main(CovidData $covid)
    {
        // $request = new Request;
        if (request('continent')) {
            $datas = $covid->sortable(['total_case' => 'desc'])->where([
                ['continent', '=', request('continent')],
                ['population', '!=', null],
            ])->get();
        } else {
            $datas = $covid->sortable(['total_case' => 'desc'])->where([
                ['continent', '!=', 'All'],
                ['population', '!=', null],
            ])->get();
        }



        return view('welcome', compact('datas'));
    }

    public function refresh()
    {
        $client = new  Client();

        $url = 'https://covid-193.p.rapidapi.com/statistics';

        $headers = [
            'X-RapidAPI-Key' => 'e0e31fa95bmsh412dc9bbad1b40fp19b7edjsn4c577dfd66cb',
            'X-RapidAPI-Host' => 'covid-193.p.rapidapi.com'
        ];

        $response = $client->request('GET', $url, [
            'headers' => $headers
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        $responses = $data['response'];

        Schema::dropIfExists('covid_data');
        Schema::create('covid_data', function (Blueprint $table) {
            $table->id();
            $table->string('continent')->nullable();
            $table->string('country');
            $table->integer('population')->nullable();
            $table->integer('total_case');
            $table->timestamps();
        });

        foreach ($responses as $response) {
            $continent = $response['continent'];
            $country = $response['country'];
            $population = $response['population'];
            $total_case = $response['cases']['total'];

            $covid_data = new CovidData([
                'continent' => $continent,
                'country' => $country,
                'population' => $population,
                'total_case' => $total_case
            ]);

            $covid_data->save();
        }

        return redirect()->route('main');
    }
}
