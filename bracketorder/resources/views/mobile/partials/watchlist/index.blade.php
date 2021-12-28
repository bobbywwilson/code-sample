<div class="row content-sections">
    <table class="striped table-adjust-margin-bottom" id="watchlist-table-default">
        <thead>
            <tr class="height-adjustment">
                <th class="uppercase table-heading adjust-left-8">Symbol</th>
                {{--<th class="uppercase table-heading adjust-left-8">Sector</th>--}}
                @if($session == "open")
                    <th class="right-align uppercase adjust-left-10">Last</th>
                @else
                    <th class="right-align uppercase adjust-left-10">Close</th>
                @endif
                <th class="right-align uppercase adjust-left-10">Change</th>
                <th class="right-align uppercase adjust-left-10">%Change</th>
                <th class="right-align uppercase adjust-left-10">Date</th>
                <th class="right-align uppercase adjust-left-10 delete-action">Delete</th>
            </tr>
        </thead>
        <tbody>
        @if(!empty($quotes))
            @foreach($quotes as $quote)
                <tr>
                    @if(strtoupper(substr($quote["ticker_symbol"], -5, 5)) == ".INDX")
                        <td><b>{!! substr($quote["ticker_symbol"], 0, -5) !!}</b></td>
                    @else
                        <td><b>{!! substr($quote["ticker_symbol"], 0, -3) !!}</b></td>
                    @endif
                    {{--<td>{{ $quote['sector'] }}</td>--}}
                    @if(strtoupper(substr($quote["ticker_symbol"], -5, 5)) == ".INDX")
                        @if($session == "open")
                            <td class="right-align adjust-left"> {{ $quote["change"] == "NA" ? "&#8211;" : number_format(($quote["previousClose"] + $quote["change"]), 2) }} </td>
                        @elseif($session == "closed")
                            <td class="right-align"> {{ $quote["close"] == "NA" ? "&#8211;" : number_format($quote["close"], 2) }} </td>
                        @endif
                    @else
                        @if($session == "open")
                            <td class="right-align adjust-left"> {{ $quote["change"] == "NA" ? "&#8211;" : number_format(($quote["previousClose"] + $quote["change"]), 2) }} </td>
                        @elseif($session == "closed")
                            <td class="right-align"> {{ $quote["close"] == "NA" ? "&#8211;" : $currencyFormat->formatCurrency($quote["close"], "USD") }} </td>
                        @endif
                    @endif

                    @if($quote["change"] == 0)
                        <td class="right-align"><span>&#8211;</span></td>
                    @else
                        <td class="right-align">
                            @if($quote["change"] == "NA")
                                <span>-</span>
                            @else
                                <span class="{{ $quote["change"] > 0 ? 'green-number' : 'red-number' }}">
                                    {{ $quote["change"] > 0 ? "+" . round($quote["change"], 2) : round($quote["change"], 2) }}
                                </span>
                            @endif
                        </td>
                    @endif

                    <td class="right-align">
                        @if($quote["change"] == "NA")
                            <span>&#8211;</span>
                        @else
                            @if(round((($quote["change"]/$quote["previousClose"]) * 100), 2) == 0)
                                <span class="center-align">&#8211;</span>
                            @else
                                <span class="{{ round((($quote["change"]/$quote["previousClose"]) * 100), 2) > 0 ? 'green-number' : 'red-number' }}">
                                    {{ round((($quote["change"]/$quote["previousClose"]) * 100), 2) > 0 ? "+" . number_format((($quote["change"]/$quote["previousClose"]) * 100), 2) . "%" : number_format((($quote["change"]/$quote["previousClose"]) * 100), 2) . "%" }}
                                </span>
                            @endif
                        @endif
                    </td>
                    @if($session == "open")
                        <td class="index-code-bottom-0 right-align">{{ $quote["timestamp"] == "NA" ? "-" : date("g:i A", $quote["timestamp"]) }}</td>
                    @else
                        <td class="index-code-bottom-0 right-align">{{ $quote["timestamp"] == "NA" ? "-" : date("M d, Y", $quote["timestamp"]) }}</td>
                    @endif
                    <td class="index-code-bottom-0 right-align add-padding delete-action">
                        <a onclick="event.preventDefault(); deleteWatchlist({{ $watchlist[$i++]->id . ", " }} {{ Auth::user()->id }}); M.toast({html: 'Symbol deleted from watchlist'})">
                            <i class="far fa-minus-square"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function(){

        $('#watchlist-table-default').DataTable({
            "pageLength": 10,
            "searching": false,
            "aoColumnDefs": [
                {
                    "bSortable": false,
                    "aTargets": [ 0, 1, 2, 3, 4, 5 ]
                },
                {
                    "bSearchable": false,
                    "aTargets": [ 0, 1, 2, 3, 4, 5 ]
                }
            ],
            "order": [[ 1, 'asc' ]]
        });
    });
</script>