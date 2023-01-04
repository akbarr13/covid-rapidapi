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
        $number = 0;
        $datas = $covid->sortable(['total_case' => 'desc'])->where([
            ['continent', '!=', 'All'],
            ['population', '!=', null],
        ])->get();

        return view('welcome', compact('datas', 'number'));
    }

    public function refresh()
    {
        $client = new  Client();

        $url = 'https://covid-193.p.rapidapi.com/statistics';

        $headers = [
            'X-RapidAPI-Key' => 'YOUR API KEY',
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
