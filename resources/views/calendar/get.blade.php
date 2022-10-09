@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @include('utilities.my_sidebar') 
        <div class="col-lg-9">
            @include('utilities.alerts') 
            <div class="card box-shadow mb-4">
                <div class="card-header">
                    <h4 class="pt-2">Canlı Ders Randevu Takvimi Oluşturma</h4>
                </div>
                <div class="card-body">
                    <p>Aşağıdaki sihirbazdan canlı ders randevu takvimini oluşturabilirsin. İşlemin tamamlanması ardından bazı günlerin bazı saatlerinde müsait değilsen bunları belirleyebileceksin.</p>
                    <p>Canlı derslerin, Ders Ücretleri sayfasında tanımladığın canlı ders ücretleri ile satışa sunulacaktır.</p>
                    <p>Canlı derslerini <strong>{{ Auth::user()->timezone->title }}</strong> saat diliminde belirliyorsun. Ülke değiştirirsen saat dilimini güncellemeyi unutma.</p>
                    <form action="{{ url('calendar/set') }}" method="post" class="ajax-form js-dont-reset">
                        @csrf                    
                        <div class="row">

                            <div class="col-12"><hr /></div>

                            <div class="col-12">

                                <div class="form-inline">
                                    @for($i=0; $i < 7; $i++)
                                    <div class="form-group mb-2" style="min-width:180px">
                                        @if($i == 0)
                                        {{ 'Pazartesi' }}
                                        @elseif($i == 1)
                                        {{ 'Salı' }}
                                        @elseif($i == 2)
                                        {{ 'Çarşamba' }}
                                        @elseif($i == 3)
                                        {{ 'Perşembe' }}
                                        @elseif($i == 4)
                                        {{ 'Cuma' }}
                                        @elseif($i == 5)
                                        {{ 'Cumartesi' }}
                                        @else
                                        {{ 'Pazar' }} 
                                        @endif                                                                                                                                                                                                       
                                    </div>

                                    <div class="form-group mb-2">
                                        <? 
                                            $ii = $i+1;
                                            $d_from = 'd' . $ii . '_from';
                                            $d_to = 'd' . $ii . '_to';
                                        ?>
                                        <select name="d{{ $i+1 }}_from" class="form-control select2 mb-2">
                                            <option value="">-- Vermiyorum --</option>
                                            @foreach($times as $time)
                                                <option value="{{ $time->format('H:i') }}" @if($time->format('H:i') == (isset($definition->{$d_from}) ? \Carbon\Carbon::parse($definition->{$d_from}, 'UTC')->setTimezone(Auth::user()->timezone->code)->format('H:i') : '')){{'selected'}}@endif>{{ $time->format('H:i') }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-2 ml-2 mr-2">ile</div>
                                    <div class="form-group mb-2">
                                        <select name="d{{ $i+1 }}_to" class="form-control select2 mb-2">
                                            <option value="">-- Vermiyorum --</option>
                                            @foreach($times as $time)
                                                <option value="{{ $time->format('H:i') }}" @if($time->format('H:i') == (isset($definition->{$d_to}) ? \Carbon\Carbon::parse($definition->{$d_to}, 'UTC')->setTimezone(Auth::user()->timezone->code)->format('H:i') : '')){{'selected'}}@endif>{{ $time->format('H:i') }}</option>
                                            @endforeach
                                        </select>        
                                    </div> 
                                    <div class="form-group mb-2 ml-2">arası</div>

                                    <div class="col-12"><hr /></div>                        
                                    @endfor     

                                    <div class="form-group mb-2" style="min-width:180px">Minimum tek ders</div>
                                    <div class="form-group mb-2">
                                        <select name="lesson_min_minute" class="form-control">
                                        <option value="">-- Seçiniz --</option>
                                        @for($i=30; $i <= 60; $i+=15)
                                        <option value="{{ $i }}" @if(($definition->lesson_min_minute ?? '') == $i){{'selected'}}@endif>{{ $i }} dakika</option>
                                        @endfor
                                        </select>                        
                                    </div>
                                    
                                    <div class="col-12"><hr /></div>
                                    
                                    <div class="form-group mb-2" style="min-width:180px">Maksimum tek ders</div>
                                    <div class="form-group mb-2">
                                        <select name="lesson_max_minute" class="form-control">
                                        <option value="">-- Seçiniz --</option>
                                        @for($i=30; $i <= 180; $i+=15)
                                        <option value="{{ $i }}" @if(($definition->lesson_max_minute ?? '') == $i){{'selected'}}@endif>{{ $i }} dakika</option>
                                        @endfor
                                        </select>                        
                                    </div>     

                                    <div class="col-12"><hr /></div>
                            
                                    <div class="form-group mb-2">
                                        <input type="checkbox" name="aggrement" id="aggrement" class="mr-2" value="1" /> <a href="" class="loadModal" data-url="{{ url('contents/load/91') }}" data-title="Canlı Ders Verme Şartları">Canlı Ders Verme Şartları</a>nı okudum, kabul ediyorum.
                                    </div>

                                </div>
                            </div>

                            
                            
                            <div class="col-12 mt-2">
                                <button type="submit" class="btn btn-primary js-submit-btn">Kaydet</button>
                                <button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>
                            </div>                        
                        </div> 
                    </form> 

                </div>
            </div>

            <div class="card box-shadow mb-4">
                <div class="card-header">
                    <h4 class="pt-2">Hariç Tutulan Tarih Belirle</h4>
                </div>
                <div class="card-body">
                    <p>Örneğin her hafta çarşamba 10:00 - 18:00 arası ders veriyorsun ama önümüzdeki hafta çarşamba 12:00 - 14:00 arası özel bir işin olduğu için bu saatlerde canlı ders veremiyorsun veya tatile gideceğin için belirli tarih aralığında yoksun. İşte bu tür zamanı belli olan, müsait olmadığın tarihleri aşağıya belirleyebilirsin. Böylece, belirledğin tarihler için öğrencilerin canlı ders almalarını engelleyebilirsin.</p>
                    <p>Müsait olmadığın zamanı belirlediğin anda o tarih ve saat aralığında canlı ders alınması engellenecektir ancak sen belirlemeden önce alınmış bir canlı ders var ise bu dersi yapmak zorundasın.</p>
                    <form action="{{ url('calendar/exception_save') }}" method="post">
                        @csrf                    
                        <div class="row">

                            <div class="col-12"><hr /></div>

                            <div class="col-12">

                                <div class="form-inline">
                                    <div class="form-group mb-2" style="min-width:180px">
                                        Tarih                                                                                                                                                                                                    
                                    </div>

                                    <div class="form-group mb-2 mr-2">
										<input type="text" name="from_date" class="form-control date" />
									</div>

                                    <div class="form-group mb-2">
                                        <select name="from_time" class="form-control select2 mb-2">
                                            @foreach($times as $time)
                                                <option value="{{ $time->format('H:i') }}">{{ $time->format('H:i') }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mb-2 ml-2 mr-2">ile</div>

                                    <div class="form-group mb-2 mr-2">
                                        <input type="text" name="to_date" class="form-control date" />
									</div>
                                    
                                    <div class="form-group mb-2">
                                        <select name="to_time" class="form-control select2 mb-2">
                                            @foreach($times as $time)
                                                <option value="{{ $time->format('H:i') }}">{{ $time->format('H:i') }}</option>
                                            @endforeach
                                        </select>        
                                    </div> 

                                    <div class="form-group mb-2 ml-2">arası</div>

                                                                   

                                </div>
                            </div>
                            
                            <div class="col-12 mt-2">
                                <button type="submit" class="btn btn-primary js-submit-btn">Kaydet</button>
                                <button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>
                            </div>                        
                        </div> 
                    </form> 

                </div>
            </div>            

            @if($exceptions->count() > 0)
            <div class="card box-shadow mb-4">
                <div class="card-header">
                    <h4 class="pt-2">Hariç Tutulan Tarihler</h4>
                </div>
                <div class="card-body">
                        
                    <table class="table">
                        <tr>
                            <td>Tarih</td>
                            <td width="80">Kaldır</td>
                        </tr>
                        @foreach($exceptions as $exception)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($exception-> from_date, 'UTC')->setTimezone(Auth::user()->timezone->code)->format('d.m.Y H:i') }} - {{ \Carbon\Carbon::parse($exception->to_date, 'UTC')->setTimezone(Auth::user()->timezone->code)->format('d.m.Y H:i') }}</td>
                            <td><a href="{{ url('calendar/exception_delete/'.$exception->id) }}"><img class="align-middle" src="{{ asset('img/navigation-close-small.svg') }}" width="14" height="14"></a></td>
                        </tr>                        
                        @endforeach
                    </table>
                </div>
            </div>   
            @endif                     


        </div>
	</div>
</div>
@endsection