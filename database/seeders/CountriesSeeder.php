<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use GuzzleHttp\Client;

class CountriesSeeder extends Seeder
{

    public function getCountriesFromApi(){
        $client = new Client();
        $result = $client->request('GET', 'https://restcountries.com/v3.1/all');
        $res = $result->getBody();
        $res = json_decode($res);
        foreach ($res as $one) {

            $data = [];

            if (isset($one->name->common)) {
                $data['english_short_name']   = $one->name->common;
            }

            if (isset($one->name->official)) {
                $data['english_long_name']    = $one->name->official;
            }

            if (isset($one->tld[0])) {
                $data['cctld']        = $one->tld[0];
            }

            if (isset($one->cca2)) {
                $data['iso2']   = $one->cca2;
            }

            if (isset($one->cca3)) {
                $data['iso3']   = $one->cca3;
            }

            if (isset($one->idd->root) && isset($one->idd->suffixes[0])) {
                $data['calling_code'] = $one->idd->root . $one->idd->suffixes[0];
            }

            if (isset($one->flags->png)) {
                $data['flag']         = $one->flags->png;
            }


            $country = \DB::table('countries')->insert($data);
        }

        return response()->json(['message' => 'All Countries Loaded Successfully']);
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->getCountriesFromApi();
    }
}
