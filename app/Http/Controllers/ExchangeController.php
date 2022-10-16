<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use App\Models\Exchange_symbol;
use App\Models\Exchange_price;

class ExchangeController extends Controller
{
    public function importSymbols()
    {
        $response = Http::withBasicAuth(config('exchange.apiKey'), config('exchange.apiSecret'))->get('https://api.binance.com/api/v3/exchangeInfo');

        $symbols = json_decode($response->body(),false);

        foreach($symbols->symbols as $exchange)
        {
            $response = Exchange_symbol::updateOrCreate(
                ['symbol' => $exchange->symbol, 'baseAsset' => $exchange->baseAsset, 'quoteAsset' => $exchange->quoteAsset],
                ['symbol' => $exchange->symbol, 'baseAsset' => $exchange->baseAsset, 'quoteAsset' => $exchange->quoteAsset]
            );
        }
    }

    public function importPrices(Request $request)
    {
        Exchange_price::truncate();
            
        $symbols = Exchange_symbol::whereIn('quoteAsset', ['USDT'])->where('symbol', 'not like', "%UPUSDT")->where('symbol', 'not like', "%DOWNUSDT")->limit(500)->get();
        $start_date = \Carbon\Carbon::now();

        foreach($symbols as $symbol)
        {
            //insert 1h    
            $response = Http::withBasicAuth(config('exchange.apiKey'), config('exchange.apiSecret'))->get('https://api.binance.com/api/v3/klines', [
                'symbol' => $symbol->symbol,
                'interval' => '1h',
                'limit' => 12
            ]);

            $symbol_prices = json_decode($response->body(),false);

            if(!empty($symbol_prices))
            {
                foreach($symbol_prices as $symbol_price)
                {
                    $response = Exchange_price::updateOrCreate(
                        [
                            'symbol' => $symbol->symbol, 
                            'interval' => 60, 
                            'open_time' => \Carbon\Carbon::createFromTimestamp(substr($symbol_price[0],0,10))->toDateTimeString(),                            
                        ],
                        [
                            'symbol' => $symbol->symbol, 
                            'interval' => 60, 
                            'open_time' => \Carbon\Carbon::createFromTimestamp(substr($symbol_price[0],0,10))->toDateTimeString(),
                            'open' => $symbol_price[1],
                            'high' => $symbol_price[2],
                            'low' => $symbol_price[3],
                            'close' => $symbol_price[4],
                            'volume' => $symbol_price[5],
                            'close_time' => \Carbon\Carbon::createFromTimestamp(substr($symbol_price[6],0,10))->toDateTimeString(),
                            'quote_asset_volume' => $symbol_price[7],
                            'number_of_trades' => $symbol_price[8],
                            'taker_buy_base_asset_volume' => $symbol_price[9],
                            'taker_buy_qoute_asset_volume' => $symbol_price[10],
                            'ignore' => $symbol_price[11],                            
                            
                        ]
                    );                
                }
            }

            //Insert 4h
            $response = Http::withBasicAuth(config('exchange.apiKey'), config('exchange.apiSecret'))->get('https://api.binance.com/api/v3/klines', [
                'symbol' => $symbol->symbol,
                'interval' => '4h',
                'limit' => 12
            ]);

            $symbol_prices = json_decode($response->body(),false);

            if(!empty($symbol_prices))
            {
                foreach($symbol_prices as $symbol_price)
                {
                    $response = Exchange_price::updateOrCreate(
                        [
                            'symbol' => $symbol->symbol, 
                            'interval' => 240, 
                            'open_time' => \Carbon\Carbon::createFromTimestamp(substr($symbol_price[0],0,10))->toDateTimeString(),                            
                        ],
                        [
                            'symbol' => $symbol->symbol, 
                            'interval' => 240, 
                            'open_time' => \Carbon\Carbon::createFromTimestamp(substr($symbol_price[0],0,10))->toDateTimeString(),
                            'open' => $symbol_price[1],
                            'high' => $symbol_price[2],
                            'low' => $symbol_price[3],
                            'close' => $symbol_price[4],
                            'volume' => $symbol_price[5],
                            'close_time' => \Carbon\Carbon::createFromTimestamp(substr($symbol_price[6],0,10))->toDateTimeString(),
                            'quote_asset_volume' => $symbol_price[7],
                            'number_of_trades' => $symbol_price[8],
                            'taker_buy_base_asset_volume' => $symbol_price[9],
                            'taker_buy_qoute_asset_volume' => $symbol_price[10],
                            'ignore' => $symbol_price[11],                            
                            
                        ]
                    );                
                }
            }        
            
            $symbol->touch();
        }

        $end_date = \Carbon\Carbon::now();

        echo $start_date . ' - ' . $end_date;
    }    

    public function average(Request $request)
    {        
        $interval = (int) $request->get('interval');
        $response = [];
        $unsetList = [];

        $prices = Exchange_price::whereNotIn('symbol', ['SUSDUSDT', 'TUSDUSDT', 'USDCUSDT', 'AUDUSDT', 'GBPUSDT', 'EURUSDT', 'USTUSDT', 'BUSDUSDT', 'USDPUSDT'])->where('interval', $interval)->where('close_time', '>', '2022-04-01')->orderBy('close_time', 'desc')->get();
        
        $reversed = $prices->reverse();
                
        $i = 0;
        foreach($reversed as $price)
        {
            $i++;
            
            $calculation = (($price->close - $price->open) * 100) / $price->low;

            $response[$price->symbol]['average'][$i] = ['average' => $calculation, 'close_time' => $price->close_time];
        }
        
        return view('exchange/average', ['prices' => $response]);
    }

    public function drop()
    {
        $average5 = [];
        $symbols = Exchange_symbol::whereIn('quoteAsset', ['USDT', 'BUSD'])->get();

        foreach($symbols as $symbol)
        {
            $prices = Exchange_price::where('symbol', $symbol->symbol)->where('interval', 15)->orderBy('open_time', 'desc')->limit(5)->get();

            if(sizeof($prices) == 5 && ($prices[0]->close < $prices[1]->close && $prices[1]->close < $prices[2]->close))
            {
                $avg = collect();

                foreach($prices as $key => $price)
                {
                    if($key == 0)
                    $average5[$symbol->symbol]['last_price'] = number_format($price->close, 4, '.', '');

                    if($key != 0)
                    $avg->push(number_format($price->close, 4, '.', ''));

                }
                $average5[$symbol->symbol]['previous_average'] = number_format($avg->avg(), 4, '.', '');

                $average5[$symbol->symbol]['rate'] = $average5[$symbol->symbol]['last_price'] > 0 && $average5[$symbol->symbol]['previous_average'] ? number_format(($average5[$symbol->symbol]['last_price'] - $average5[$symbol->symbol]['previous_average']) / $average5[$symbol->symbol]['last_price'], 4, '.', '') * 100 : 0;

                $average5[$symbol->symbol]['last_prices'] = Exchange_price::where('symbol', $symbol->symbol)->where('interval', 5)->orderBy('open_time', 'desc')->limit(20)->get();
            }
        }

        $average5 = collect($average5)->sortBy('rate')->toArray();

        return view('exchange/average', ['average5' => $average5]);
    }    

    private static function sortByOrder($a, $b) {
        return $a['rate'] - $b['rate'];
    }    
}
