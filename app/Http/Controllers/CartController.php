<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Lang;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    protected $data = [];

    private $merchant_id 	= '128883';
	private $merchant_key 	= '1yonBuzJQ3wkMtra';
    private $merchant_salt	= '1tbxU28PRthzEJ2J';
    
    public function index(Request $request)
    {
        if(
            empty(Auth::user()->detail->phone_mobile) OR 
            empty(Auth::user()->detail->address) OR 
            empty(Auth::user()->detail->city_id) OR 
            empty(Auth::user()->detail->town_id)
        )
        {
            return redirect('users/personal')->withErrors(['errors' => [Lang::get('cart.missing_information')]]);                
        }

        $this->data['items'] = Cart::where('status', 'W')->where('user_id', Auth::user()->id)->get();
        if($this->data['items']->count() > 0)
        $this->data['token'] = $this->get_paytr_token($this->data['items'], $request);

        return view('cart/index', $this->data);
    } 

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
        ]); 
        
        //Geribildirim karsilastirmasi icin benzersiz merchant ID olusturalim
        $hash = Auth::user()->id .'000'. time();

        //Merchant ID daha once olusuturulmussa onu kullan
        $check = Cart::where('user_id', Auth::user()->id)->where('status', 'W')->whereNotNull('merchant_oid')->first();

        //Merchant ID set et
        $merchant_oid = !empty($check) && !empty($check->merchant_oid) ? $check->merchant_oid : $hash;

        //Boyle bir urun yoksa throw firlat
        $product = Product::findOrFail($request->get('product_id'));
        
        //Membership ise diger membershipleri sil
        if(in_array($request->get('product_id'), [1,2,3,4,5,6,7,8]))
        {
            Cart::where('status', 'W')->where('user_id', Auth::user()->id)->whereIn('product_id', [1,2,3,4,5,6,7,8])->delete();
        }

        $cart = Cart::updateOrCreate(
            [
                'user_id' => Auth::user()->id,
                'product_id' => $request->get('product_id'),
                'related_id' => $request->get('related_id'),
                'status' => 'W',
            ],
            [
                'price' => $request->get('price') > 0 ? $request->get('price') : $product->price,
                'merchant_oid' => $merchant_oid,
                'related_id' => $request->get('related_id'),
            ]
        ); 
        
        return $request->wantsJson()
                    ? response()->json(['success' => [Lang::get('cart.added')]])
                    : redirect()->back()->with(['messages' => [Lang::get('cart.added')]]);  
    }

    public function remove($id)
    {
        
        $cart = Cart::FindOrFail($id);
        if($cart->product_id == 14)
        {
            $lesson = \App\Models\Calendar_lesson::findOrFail($cart->related_id);
            if($lesson->status == 'W')
            {
                $lesson->delete();
                $cart->delete();
            }
        }
        else
        {
            $cart->delete();
        }

        return redirect()->back()->with(['messages' => [Lang::get('cart.removed')]]);        
    }    

    public function payment_notify(Request $request)
    {
        $hash = base64_encode( hash_hmac('sha256', $request->get('merchant_oid') . $this->merchant_salt . $request->get('status') . $request->get('total_amount'), $this->merchant_key, true) );
        
        if($hash != $request->get('hash'))
        {
            Log::error('Payment notify HASH match error.', ['our_hash' => $hash, 'remote_hash' => $request->get('hash')]);
        }

        ## BURADA YAPILMASI GEREKENLER
        ## 1) Siparişin durumunu $post['merchant_oid'] değerini kullanarak veri tabanınızdan sorgulayın.
        ## 2) Eğer sipariş zaten daha önceden onaylandıysa veya iptal edildiyse  echo "OK"; exit; yaparak sonlandırın.

        $cart = Cart::where('merchant_oid', $request->get('merchant_oid'))->count();
        if(empty($cart))
        {
            Log::info('Payment notify already completed.', ['merchant_oid' => $request->get('merchant_oid')]);
            echo "OK";
            exit;            
        }

        if( $request->get('status') == 'success' ) { ## Ödeme Onaylandı

            ## BURADA YAPILMASI GEREKENLER
            ## 1) Siparişi onaylayın.
            ## 2) Eğer müşterinize mesaj / SMS / e-posta gibi bilgilendirme yapacaksanız bu aşamada yapmalısınız.
            ## 3) 1. ADIM'da gönderilen payment_amount sipariş tutarı taksitli alışveriş yapılması durumunda
            ## değişebilir. Güncel tutarı $post['total_amount'] değerinden alarak muhasebe işlemlerinizde kullanabilirsiniz.

            $carts = Cart::where('merchant_oid', $request->get('merchant_oid'))->get();
            if(!empty($carts))
            {
                foreach($carts as $cart)
                {
                    $order = new Order;

                    $product = Product::findOrFail($cart->product_id);

                    if($product->product_category_id == 3)
                    {
                        $order->start_at = $cart->lesson->start_at;
                        $order->end_at = $cart->lesson->end_at;
                    }
                    else
                    {
                        //Eger daha once almis oldugu urun var ise ve suresi bitmediyse bunu onun arkasina ekle
                        $check = Order::where('user_id', $cart->user_id)->where('product_id', $cart->product_id)->where('expired', 'f')->orderBy('end_at', 'desc')->first();

                        if(!empty($check))
                        {
                            $order->start_at = $check->end_at;
                            $order->end_at = \Carbon\Carbon::parse($check->end_at)->add($product->expire_count, $product->expire_type);                        
                        }
                        else
                        {
                            $order->start_at = \Carbon\Carbon::now();
                            $order->end_at = \Carbon\Carbon::now()->add($product->expire_count, $product->expire_type);                        
                        }
                    }
                    
                    //Uzman egitmen rozeti, profesyonel alan adi, profil reklami
                    if(in_array($cart->product_id, [10,11,13]))
                    {
                        $order->status = 'W';   
                    }

                    $order->user_id = $cart->user_id;
                    $order->product_id = $cart->product_id;
                    $order->product_price = $cart->price;
                    $order->payed_price = number_format($request->get('total_amount') / 100, 2, '.', '');
                    $order->merchant_oid = $request->get('merchant_oid');
                    $order->save();
                    $order_id = $order->id;

                    if(!empty($order_id))
                    {
                        if($product->product_category_id == 1)
                        {
                            $user = User::findOrFail($cart->user_id);
                            $user->group_id = $product->new_group_id;
                            $user->save();
                        }

                        if($product->product_category_id == 3)
                        {
                            $lesson = \App\Models\Calendar_lesson::findOrFail($cart->related_id);
                            $lesson->status = 'A';
                            $lesson->save();
                        }                        

                        $cart->delete();
                    }
                }

                $user = \App\Models\User::findOrFail($order->user_id);
                $mailClass = new \App\Mail\OrderComplete($user);
                $message = $mailClass->onConnection('database')->onQueue('high');
                Mail::to($user->email)->queue($message);

                User::calculate_search_point($order->user_id);
            }

        } else { 
            
            ## Ödemeye Onay Verilmedi

            ## BURADA YAPILMASI GEREKENLER
            ## 1) Siparişi iptal edin.
            ## 2) Eğer ödemenin onaylanmama sebebini kayıt edecekseniz aşağıdaki değerleri kullanabilirsiniz.
            ## $post['failed_reason_code'] - başarısız hata kodu
            ## $post['failed_reason_msg'] - başarısız hata mesajı

            $cart = Cart::where('merchant_oid', $request->get('merchant_oid'))->first();

            Cart::where('merchant_oid', $request->get('merchant_oid'))->delete();

            $user = \App\Models\User::findOrFail($cart->user_id);
            $mailClass = new \App\Mail\OrderError($user);
            $message = $mailClass->onConnection('database')->onQueue('high');
            Mail::to($user->email)->queue($message);

        }

        echo "OK";
        exit;            
    }

    public function payment_success()
    {
        Cart::where('status', 'W')->where('user_id', Auth::user()->id)->update(['status' => 'P']);
        \App\Models\Calendar_lesson::where('status', 'W')->where('student_id', Auth::user()->id)->update(['status' => 'P']);
        
        return view('cart/payment_success', $this->data);
    }    

    public function payment_error()
    {
        return view('cart/payment_error', $this->data);
    }

    private function get_paytr_token($items, $request)
    {
        $user_basket = [];
        foreach($items as $item)
        {
            $user_basket[] = [$item->product->title, $item->price, 1];
        }
        $user_basket = base64_encode(json_encode($user_basket));

        $user_ip = request()->ip();

        ## Müşterinizin sitenizde kayıtlı veya form vasıtasıyla aldığınız eposta adresi
        $email = Auth::user()->email;
        #
        ## Tahsil edilecek tutar.
        $payment_amount	= $items->pluck('price')->sum() * 100; //9.99 için 9.99 * 100 = 999 gönderilmelidir.
        #
        ## Sipariş numarası: Her işlemde benzersiz olmalıdır!! Bu bilgi bildirim sayfanıza yapılacak bildirimde geri gönderilir.
        $merchant_oid = $items[0]->merchant_oid;
        #
        ## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız ad ve soyad bilgisi
        $user_name = Auth::user()->first_name . ' ' . Auth::user()->last_name;
        #
        ## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız adres bilgisi
        $user_address = Auth::user()->detail->address . ' ' . Auth::user()->detail->town->title . ' ' . Auth::user()->detail->city->title;
        #
        ## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız telefon bilgisi
        $user_phone = Auth::user()->detail->phone_mobile;
        #
        ## Başarılı ödeme sonrası müşterinizin yönlendirileceği sayfa
        ## !!! Bu sayfa siparişi onaylayacağınız sayfa değildir! Yalnızca müşterinizi bilgilendireceğiniz sayfadır!
        ## !!! Siparişi onaylayacağız sayfa "Bildirim URL" sayfasıdır (Bakınız: 2.ADIM Klasörü).
        $merchant_ok_url = url('payment/success');
        #
        ## Ödeme sürecinde beklenmedik bir hata oluşması durumunda müşterinizin yönlendirileceği sayfa
        ## !!! Bu sayfa siparişi iptal edeceğiniz sayfa değildir! Yalnızca müşterinizi bilgilendireceğiniz sayfadır!
        ## !!! Siparişi iptal edeceğiniz sayfa "Bildirim URL" sayfasıdır (Bakınız: 2.ADIM Klasörü).
        $merchant_fail_url = url('payment/error');
        
        ## İşlem zaman aşımı süresi - dakika cinsinden
        $timeout_limit = "30";

        ## Hata mesajlarının ekrana basılması için entegrasyon ve test sürecinde 1 olarak bırakın. Daha sonra 0 yapabilirsiniz.
        $debug_on = 1;

        ## Mağaza canlı modda iken test işlem yapmak için 1 olarak gönderilebilir.
        $test_mode = 0;

        $no_installment	= 0; // Taksit yapılmasını istemiyorsanız, sadece tek çekim sunacaksanız 1 yapın

        ## Sayfada görüntülenecek taksit adedini sınırlamak istiyorsanız uygun şekilde değiştirin.
        ## Sıfır (0) gönderilmesi durumunda yürürlükteki en fazla izin verilen taksit geçerli olur.
        $max_installment = 0;

        $currency = "TL";
        
        $hash_str = $this->merchant_id . $user_ip . $merchant_oid . $email . $payment_amount . $user_basket . $no_installment . $max_installment . $currency . $test_mode;
        $paytr_token=base64_encode(hash_hmac('sha256',$hash_str.$this->merchant_salt,$this->merchant_key,true));
        $post_vals=array(
            'merchant_id'=>$this->merchant_id,
            'user_ip'=>$user_ip,
            'merchant_oid'=>$merchant_oid,
            'email'=>$email,
            'payment_amount'=>$payment_amount,
            'paytr_token'=>$paytr_token,
            'user_basket'=>$user_basket,
            'debug_on'=>$debug_on,
            'no_installment'=>$no_installment,
            'max_installment'=>$max_installment,
            'user_name'=>$user_name,
            'user_address'=>$user_address,
            'user_phone'=>$user_phone,
            'merchant_ok_url'=>$merchant_ok_url,
            'merchant_fail_url'=>$merchant_fail_url,
            'timeout_limit'=>$timeout_limit,
            'currency'=>$currency,
            'test_mode'=>$test_mode
        );

        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1) ;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        
        // XXX: DİKKAT: lokal makinanızda "SSL certificate problem: unable to get local issuer certificate" uyarısı alırsanız eğer
        // aşağıdaki kodu açıp deneyebilirsiniz. ANCAK, güvenlik nedeniyle sunucunuzda (gerçek ortamınızda) bu kodun kapalı kalması çok önemlidir!
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        
        $result = @curl_exec($ch);

        if(curl_errno($ch))
        {
            $reason = curl_error($ch);
            Log::error('Payment iframe connection failed.', ['reason' => $reason]);
            die("Ödeme sağlayıcısı bağlantı hatası! Mühendislerimiz haberdar edildi. Lütfen daha sonra tekrar dene. Hata mesajı: " . $reason);
        }
            
    
        curl_close($ch);
        
        $result=json_decode($result,1);
            
        if($result['status']=='success')
            return $result['token'];
        else
        {
            Log::error('Payment iframe failed.', ['reason' => $result['reason']]);
            die("Ödeme istemcisi hatası! Mühendislerimiz konudan haberdar edildi. Lütfen daha sonra tekrar dene. Hata mesajı: " . $result['reason']);        
        }
            
    }
}
