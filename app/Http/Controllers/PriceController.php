<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Lang;
use \App\Models\Subject;
use \App\Models\Level;
use \App\Models\Price;

class PriceController extends Controller
{
    public function index(Request $request)
    {
        $this->data['subjects'] = Subject::get();
        $this->data['prices'] = Price::where('user_id', Auth::user()->id)->with('subject')->with('level')->get();
        
        return view('prices.index', $this->data);
    }

    public function load_new(Request $request)
    {
        $items = Level::where('subject_id', $request->get('selected_id'))->get();
                
        $returnHTML = view('prices.load_new')->with('items', $items)->render();
        return response()->json(['success' => true, 'html'=> $returnHTML]);  
    }    

    public function load_exists($user_id)
    {
        $prices = Price::where('user_id', $user_id)->with('subject')->with('level')->get();
        
        $returnHTML = view('prices.load_exists')->with('prices', $prices)->render();
        return response()->json(['success' => true, 'html'=> $returnHTML]);  
    }    

    public function store(Request $request)
    {
        $request->validate([
            'subject_id'        => 'required',
            'levels'            => 'required',
            'price_private'     => 'required_if:price_live,""',
            'price_live'        => 'required_if:price_private,""',
        ]);

        foreach($request->get('levels') as $level_id)
        {
            Price::updateOrCreate(
                [
                    'user_id' => Auth::user()->id,
                    'subject_id' => $request->get('subject_id'),
                    'level_id' => $level_id
                ],
                [
                    'price_private' => $request->get('price_private'),
                    'price_live' => $request->get('price_live')          
                ]
            );            
        }

        return $request->wantsJson()
                    ? response()->json(['call' => $request->get('call'), 'success' => [Lang::get('auth.completed')]])
                    : redirect()->back()->with(['messages' => [Lang::get('auth.completed')]]);          
    }

    public function update(Request $request)
    {
        foreach($request->get('items') as $id => $value)
        {
            if(!empty($value['price_private']) || !empty($value['price_live']))
            {
                $price = Price::find($id);
                if($price->user_id == Auth::user()->id)
                {
                    $price->price_private = $value['price_private'];
                    $price->price_live = $value['price_live'];
                    $price->save();
                }
            }        
        }

        return $request->wantsJson()
                    ? response()->json(['call' => $request->get('call'), 'success' => [Lang::get('auth.completed')]])
                    : redirect()->back()->with(['messages' => [Lang::get('auth.completed')]]);          
    }  

    public function text($id)
    {
        $price = Price::with('level')->with('subject')->where('user_id', Auth::user()->id)->where('id', $id)->first();
        return response()->json($price);  
    }        

    public function text_store(Request $request)
    {
        $request->validate([
            'title'        => 'required',
            'description'  => 'required',
            'id'           => 'required',
        ]);

        if($request->get('id') && $request->get('title') && $request->get('description'))
        {
            $price = Price::where('user_id', Auth::user()->id)->where('id', $request->get('id'))->first();
            if(!empty($price))
            {
                $price->slug = null;
                $price->title = $request->get('title');
                $price->description = $request->get('description');
                $price->status = 'W';
                $price->save();
            }
        }

        return $request->wantsJson()
                    ? response()->json(['user_id' => Auth::user()->id, 'success' => [Lang::get('auth.completed')]])
                    : redirect()->back()->with(['messages' => [Lang::get('auth.completed')]]);                         
    }            

    public function delete(Request $request)
    {
        $price = Price::find($request->get('id'));

        if($price->user_id == Auth::user()->id)
        {
            $price->delete();
        }    

        return $request->wantsJson()
                    ? response()->json(['call' => $request->get('call'), 'success' => [Lang::get('auth.completed')]])
                    : redirect()->back()->with(['messages' => [Lang::get('auth.completed')]]);                  
    }        

    public function detail($slug)
    {
        $price = Price::where('slug', $slug)->first();
        
        if(empty($price)) return abort(404);

        $this->data['price'] = $price;

        $this->data['seo_title'] = $price->title . ' - ' . $price->id;
        $this->data['seo_description'] = $price->description;
        
        return view('prices.detail', $this->data);
    }    
}
