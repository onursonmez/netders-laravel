<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Content;
use \App\Models\Content_category;
use Lang;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Auth;

class ContentController extends Controller
{
    public function index()
    {
        if(!Auth::check() || Auth::user()->group_id != 1) return abort(404);

        $this->data['items'] = Content::orderBy('id', 'desc')->get();
                
        return view('contents.index', $this->data);        
    }

    public function add()
    {
        if(!Auth::check() || Auth::user()->group_id != 1) return abort(404);

        $this->data['categories'] = Content_category::get();
                
        return view('contents.add', $this->data);        
    }

    public function edit($id)
    {
        if(!Auth::check() || Auth::user()->group_id != 1) return abort(404);

        $this->data['content'] = Content::findOrFail($id);
        $this->data['categories'] = Content_category::get();
                
        return view('contents.add', $this->data);        
    }    

    public function delete($id)
    {
        if(!Auth::check() || Auth::user()->group_id != 1) return abort(404);

        Content::find($id)->delete();

        return redirect()->back()->with(['messages' => [Lang::get('auth.completed')]]);        
    }        

    public function save(Request $request)
    {
        if(!Auth::check() || Auth::user()->group_id != 1) return abort(404);

        if($request->get('id') > 0)
        {
            $content = Content::findOrFail($request->get('id'));
            $content->content_category_id = $request->get('category_id');
            $content->title = $request->get('title');
            $content->description = $request->get('description');
            $content->slug = $request->get('seo_link');
            $content->seo_title = $request->get('seo_title');        
            $content->seo_description = $request->get('seo_description');        
            $content->slug = $request->get('slug');        
            $content->save();            
        }
        else
        {
            $category = Content_category::findOrFail($request->get('category_id'));
            $content = new Content;
            $content->content_category_id = $request->get('category_id');
            $content->title = $request->get('title');
            $content->description = $request->get('description');
            $content->slug = $category->slug . '/' . SlugService::createSlug(Content::class, 'slug', $request->get('title')) . '.html';
            $content->status = 'A';
            $content->save();
        }
                
        return $request->wantsJson()
                    ? response()->json(['success' => [Lang::get('auth.completed')]])
                    : redirect()->back()->with(['messages' => [Lang::get('auth.completed')]]);  
    }        

    public function detail($slug)
    {
        $content = Content::where('slug', $slug)->first();
        
        if(empty($content)) return abort(404);

        $this->data['content'] = $content;

        $this->data['seo_title'] = $content->title;
        $this->data['seo_description'] = $content->description;
        
        return view('contents.detail', $this->data);        
    }

    public function contact(Request $request)
    {
        if(!empty($request->all()))
        {
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|max:255|email',
                'phone_mobile' => 'required',
                'message' => 'required',
                'captcha'  => 'required|captcha',
            ]);      
            
            $form = new \App\Models\Contact_form;
            $form->first_name = $request->get('first_name');
            $form->last_name = $request->get('last_name');
            $form->email = $request->get('email');
            $form->phone_mobile = $request->get('phone_mobile');
            $form->message = $request->get('message');
            $form->agent = $request->server('HTTP_USER_AGENT');
            $form->ip = request()->ip();
            $form->save();
            
            return $request->wantsJson()
                        ? response()->json(['success' => [Lang::get('general.send_success')]])
                        : redirect()->back()->with(['messages' => [Lang::get('general.send_success')]]);              
        }
        
        
        $this->data['seo_title'] = Lang::get('general.contact');

        return view('contents.contact', $this->data);    
    }    

    public function load($id)
    {
        $content = Content::findOrFail($id);
        $returnHTML = view('contents.load')->with('content', $content)->render();
        return response()->json(['success' => true, 'html'=> $returnHTML]);          
    }    

    public function category($slug, $request)
    {   
        $this->data['category'] = Content_category::where('slug', $slug)->first();
        
        if(!empty($this->data['category']))
        {
            $contents = Content::where('content_category_id', $this->data['category']->id)->orderBy('created_at', 'desc');
            
            if(!empty($request->get('q')))
            $contents->where('title', 'ilike', '%'.$request->get('q').'%');

            $this->data['contents'] = $contents->paginate(10);
            $this->data['seo_title'] = $this->data['category']->title;
        }

        return view('contents.category', $this->data);
    }
}
