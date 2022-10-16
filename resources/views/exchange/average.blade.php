<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    </head>
    <body>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Market {{ Request::get('interval') }} minute averages</h5>
                        <table class="table">
                        <tbody>
                            <thead>
                            <tr>
                                <th>Symbol</th>
                                @for($i=1;$i<=count($prices['ATMUSDT']['average']);$i++)
                                <th>Last {{ $i }} average</th>
                                @endfor
                            </tr>
                            </thead>
                            @foreach($prices as $symbol => $price)
                            <tr>
                                <td>{{ $symbol }}</td>
                                @foreach($prices[$symbol]['average'] as $key => $average)
                                <td style="@if($average['average'] >= 2 && $average['average'] < 10) background-color:lightgreen; @elseif($average['average'] >= 10) background-color:green; @endif">{{ number_format($average['average'], 2) }}<br /><span style="font-size:7px;">{{ $average['close_time'] }}</span></td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>            
            </div>
            <div class="col-6"></div>
        </div>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
    </body>
</html>