<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\CovidData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Response;
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

        return view('main', compact('datas'));
    }

    public function search(CovidData $covid)
    {
        $datas = $covid->sortable(['total_case' => 'desc'])->where([
            ['country', 'like', '%' . request('search') . '%'],
            ['population', '!=', null],
        ])->get();

        $output = "";




        foreach ($datas as $data) {
            $output = '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">' .
                '<th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">' .
                '<a href="/?continent={{ $data->continent }}">' . $data->continent . '</a>' .
                '</th>' .
                '<td class="px-6 py-4">' .
                $data->country .
                '</td>' .
                '<td class="px-6 py-4">' .
                number_format($data->population) .
                '</td>' .
                '<td class="px-6 py-4">' .
                number_format($data->total_case) .
                '</td>' .
                '</tr>';
        }
        if (!empty(request('search'))) {
            return Response($output);
        } else {
            // $datas = $covid->sortable(['total_case' => 'desc'])->where([
            //     ['continent', '!=', 'All'],
            //     ['population', '!=', null],
            // ])->get();

        }
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
