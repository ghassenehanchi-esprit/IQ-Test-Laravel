@php
    $content = getContent('game.content', true);

    $response = Http::get('https://api.coincap.io/v2/assets');
    $cryptoData = $response->json()['data'];

    $guesses = \App\Models\Guess::latest()->with('user')->paginate(getPaginate());

    $winnerList = DB::table('users')
    ->leftJoin('guesses', 'users.id', '=', 'guesses.user_id')
    ->select('users.id', 'users.username', DB::raw('COUNT(guesses.id) as wins'))
    ->where('guesses.is_winner', true)
    ->groupBy('users.id', 'users.username')
    ->get();
@endphp

<div class="padding-top padding-bottom " style="color:black">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @php echo @$content->data_values->description; @endphp
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p class="mt-3 mb-3">Bitcoin Running Price</p>
                @php
                    $response = Http::get('https://api.coincap.io/v2/assets/bitcoin');
                    $bitcoinData = $response->json()['data'];
                    $previousPrice = 50000; // Static previous price for demonstration purposes

                    $currentPrice = $bitcoinData['priceUsd'];
                    $priceChange = $currentPrice - $previousPrice;

                    if ($priceChange > 0) {
                        $arrow = '▲'; // Up arrow
                    } elseif ($priceChange < 0) {
                        $arrow = '▼'; // Down arrow
                    } else {
                        $arrow = ''; // No arrow (unchanged)
                    }
                @endphp



                <div>
                    <p>Bitcoin Price (USD): {{ number_format($bitcoinData['priceUsd'],2) }}</p>
                    <p>Price Change Indicator: {{ $arrow }}</p>
                </div>


            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6 m-auto">
                <table class="table">
                    <thead>
                        <th>@lang('Username')</th>
                        <th>@lang('Total Win')</th>
                    </thead>
                    <tbody>
                        @foreach($winnerList as $winner)
                            <tr>
                                <td>{{$winner->username}}</td>
                                <td>{{$winner->wins.' Times'}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <form action="{{route('user.guess.store')}}" method="post">
            @csrf
            <div class="row mt-5">
                <div class="col-md-8 mx-auto">
                    <label for="guess">Your Guess (USD):</label>
                <input type="number" id="guess" class="form-control" name="guess" step="0.01"><br><br>
                <button type="submit" class="btn btn-sm btn-success">Submit Guess</button>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-md-6 m-auto card p-3">
                <ul>
                    @foreach($guesses as $guess)
                        <li>
                            {{$guess->user->fullname}}
                            <span>{{$guess->guess}}<span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>



