<?php

namespace App\Domain\Service;

use \Exception;
use App\Domain\AbstractDomain;
use GuzzleHttp\Client as Guzzle;

/**
 * Class CompanyService
 * @package App\Domain\Model
 */
class CompanyService extends AbstractDomain
{
    /**
     * @param array $params
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getNasdaqListing(): ?array
    {
        try{
            $url = "https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json";
            $client = new Guzzle();
            $response = $client->request('GET', $url);
            return json_decode($response->getBody());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    /**
     * @param array $params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCompanyGraphData(array $params): array {
        try{
            $headers = [
              'headers' => [
                'x-rapidapi-host' => 'apidojo-yahoo-finance-v1.p.rapidapi.com',
                'x-rapidapi-key' => 'lI76HRru66mshyJQ9Ru4kiRToK04p1z9nfTjsnIoc2uomeJy6R'
              ]
            ];
            $newParams = [
              'frequency' => '1d',
              'filter' => 'history',
              'period1' => strtotime($params['dateStart']),
              'period2' => strtotime($params['dateEnd']),
              'symbol' => $params['symbol']
            ];
            $url = "https://apidojo-yahoo-finance-v1.p.rapidapi.com/stock/v2/get-historical-data";
            $client = new Guzzle($headers);
            $response = $client->request('GET', $url, [
              'query' => $newParams
            ]);
            
            $i=0;
            $prices = [];
            $apiData = json_decode($response->getBody()->getContents(), true);
            foreach($apiData['prices'] as $item) {
                if (!empty($item['open'])) {
                    $prices[$i]['x'] = $item['date'] * 1000;
                    $prices[$i]['y'][] = $item['open'];
                    $prices[$i]['y'][] = $item['high'];
                    $prices[$i]['y'][] = $item['low'];
                    $prices[$i]['y'][] = $item['close'];
                    $i++;
                }
            }
            return $prices;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    /**
     * @param array $params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCompanyStock(array $params): array {
        try{
            $headers = [
              'headers' => [
                'x-rapidapi-host' => 'apidojo-yahoo-finance-v1.p.rapidapi.com',
                'x-rapidapi-key' => 'lI76HRru66mshyJQ9Ru4kiRToK04p1z9nfTjsnIoc2uomeJy6R'
              ]
            ];
            $newParams = [
              'frequency' => '1d',
              'filter' => 'history',
              'period1' => strtotime($params['dateStart']),
              'period2' => strtotime($params['dateEnd']),
              'symbol' => $params['symbol']
            ];
            $url = "https://apidojo-yahoo-finance-v1.p.rapidapi.com/stock/v2/get-historical-data";
            $client = new Guzzle($headers);
            $response = $client->request('GET', $url, [
              'query' => $newParams
            ]);
            
            $i=0;
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
}
