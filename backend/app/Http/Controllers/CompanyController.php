<?php

namespace App\Http\Controllers;

use App\DomainServices\ClientContainer;
use App\Interfaces\Services\CompanyInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Services\Database\CompanyService;
use Exception;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use DateTime;
use App\Services\Models\CompanyService as ModelsCompanyService;

/**
 * Class CompanyController
 * @package App\Http\Controllers
 */
class CompanyController extends Controller
{
    /**
     * @param Request $request
     * @param ClientContainer $client
     * @return JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBySymbol(Request $request, ClientContainer $client) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'symbol' => 'required|regex:/^[a-zA-Z0-9_-]+$/'
        ]);
        if ($validator->fails()) {
            $this->response->error = 'Invalid symbol';
            return new JsonResponse($this->response);
        }

        try {
            $symbol = $request->get('symbol');
            $company = $client->get(
                config('iextrading.IEX_BASEPATH').'/stock/'.$symbol.'/company'
            );
            $id = Company::where('symbol', $symbol)->first()->id;
            $company['id'] = $id;
            $this->response->data = $company;
            return new JsonResponse($this->response);
        } catch (Exception $e) {
            $statusCode = $e->getCode();
            if ($statusCode === JsonResponse::HTTP_NOT_FOUND) {
                $this->response->error = 'Data not found';
                return new JsonResponse($this->response);
            }
            $this->response->error = 'Unknown error';
            return new JsonResponse($this->response);
        }
    }

    /**
     * @param Request $request
     * @param CompanyInterface $companyService
     * @param string $date
     * @return JsonResponse
     */
    public function getTop(Request $request, CompanyInterface $companyService, string $date) : JsonResponse
    {
        $parameters = json_decode($request->get('parameters'), true);
        if ($request->has('parameters') && is_null($parameters)) {
            $this->response->error['json'] = 'Invalid json!';
            return new JsonResponse($this->response, JsonResponse::HTTP_BAD_REQUEST);
        }
        if (!DateTime::createFromFormat(config('dataFormats.date'), $date)) {
            $this->response->error['date'] = 'Invalid date format!';
            return new JsonResponse($this->response, JsonResponse::HTTP_BAD_REQUEST);
        }
        if (!date_create($date)) {
            $this->response->error['date'] = 'Date is not exists!';
            return new JsonResponse($this->response, JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->response->data['companies'] = $companyService->getTopCompanies($date, $parameters);
        if (!is_null($parameters)) {
            if (array_key_exists('search', $parameters)) {
                $this->response->search['companies'] = $parameters['search'];
            }
            if (array_key_exists('sorting', $parameters)) {
                $this->response->sorting['companies'] = $parameters['sorting'];
            }
        }

        return new JsonResponse($this->response);
    }

    /**
     * @param CompanyInterface $companyService
     * @return JsonResponse
     */
    public function getTopNow(CompanyInterface $companyService) : JsonResponse
    {
        $this->response->data['companies'] = $companyService->getTopCompanies();

        return new JsonResponse($this->response);
    }

    /**
     * @param string $symbolsString
     * @param ModelsCompanyService $companyService
     * @return JsonResponse
     */
    public function getNews(string $symbolsString, ModelsCompanyService $companyService)
    {
        $symbols = explode(',', $symbolsString);

        $this->response->data['news'] = $companyService->getNews($symbols);

        return new JsonResponse($this->response);
    }

    /**
     * @param Request $request
     * @param CompanyInterface $companyService
     * @return JsonResponse
     */
    public function search(Request $request, CompanyInterface $companyService) : JsonResponse
    {
        $parametersString = $request->get('parameters');
        $pagination = [
            'itemsCount' => $request->get('itemsCount', config('pagination.companies.itemsCount')),
            'pageNumber' => $request->get('pageNumber', 1),
        ];

        $parameters = is_null($parametersString) ? [] : json_decode($parametersString, true);

        $this->response->data['companies'] = $companyService->search(
            $parameters,
            $pagination['itemsCount'],
            $pagination['pageNumber']
        );

        if (array_key_exists('search', $parameters)) {
            $this->response->search['companies'] = $parameters['search'];
        }
        if (array_key_exists('sorting', $parameters)) {
            $this->response->sorting['companies'] = $parameters['sorting'];
        }
        $this->response->pagination['companies'] = $pagination;

        return new JsonResponse($this->response);
    }

    /**
     * @param CompanyRequest $request
     * @param CompanyService $service
     * @throws Exception;
     * @return JsonResponse
     */
    public function create(CompanyRequest $request, CompanyService $service) : JsonResponse
    {
        $validated = $request->validated();

        $company = $service->add($validated);

        $this->response->data['company'] = $company;

        return new JsonResponse($this->response, JsonResponse::HTTP_CREATED);
    }

    /**
     * @param int $id
     * @param CompanyService $service
     * @throws Exception;
     * @return JsonResponse
     */
    public function delete(int $id, CompanyService $service) : JsonResponse
    {
        Company::findOrFail($id);

        $service->delete($id);

        $this->response->data[$id] = 'Company was deleted.';
        return new JsonResponse($this->response);
    }

    /**
     * @param ModelsCompanyService $service
     * @return JsonResponse
     */
    public function getTotalNumberOfCompanies(ModelsCompanyService $service) : JsonResponse
    {
        $total = $service->countAllCompanies();
        $this->response->data['companiesTotal'] = $total;
        return new JsonResponse($this->response, JsonResponse::HTTP_OK);
    }
}
