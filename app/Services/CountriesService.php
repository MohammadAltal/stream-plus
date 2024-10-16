<?php
namespace App\Services;

use App\Repositories\CountriesRepository;

class CountriesService {

	protected $repository;

    public function __construct(CountriesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(){

      return $this->repository->index();
    }

}
