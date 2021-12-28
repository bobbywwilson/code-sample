
<div class="col s12" id="card-col-quote">
    <table class="quote-table">
        <thead>
        <tr class="no-border">
            <th class="uppercase table-heading">Index</th>
            <th class="right-align uppercase hide-on-small-and-down">Open</th>
            <th class="right-align uppercase hide-on-small-and-down">High</th>
            <th class="right-align uppercase hide-on-small-and-down">Low</th>
            @if($session == "open")
                <th class="right-align uppercase">Last</th>
            @else
                <th class="right-align uppercase">Close</th>
            @endif
            <th class="right-align uppercase">Change</th>
            {{--<th class="right-align uppercase right-margin-padding hide-on-small-and-down">Date</th>--}}
        </tr>
        </thead>

        <tbody>
        <tr class="no-border">
            <td class="uppercase"><b>{{ $markets[1]["name"] }}</b></td>
            <td class="right-align hide-on-small-and-down"><b>{{ $markets[1]["open"] == "NA" ? "-" : number_format($markets[1]["open"], 2) }}</b></td>
            <td class="right-align hide-on-small-and-down"><b>{{ $markets[1]["high"] == "NA" ? "-" : number_format($markets[1]["high"], 2) }}</b></td>
            <td class="right-align hide-on-small-and-down"><b>{{ $markets[1]["low"] == "NA" ? "-" : number_format($markets[1]["low"], 2) }}</b></td>
            @if($session == "open")
                <td class="right-align"><b>{{ $markets[1]["change"] == "NA" ? "-" : number_format(($markets[1]["previousClose"] + $markets[1]["change"]), 2) }}</b></td>
            @elseif($session == "closed")
                <td class="right-align"><b>{{ $markets[1]["close"] == "NA" ? "-" : number_format(($markets[1]["close"]), 2) }}</b></td>
            @endif

            @if($markets[1]["change"] == 0)
                <td class="right-align"><span>-</span></td>
            @else
                <td class="right-align">
                    @if($markets[1]["change"] == "NA")
                        <span>-</span>
                    @else
                        <span class="{{ $markets[1]["change"] > 0 ? 'green-number' : 'red-number' }}">
                            <b>{{ $markets[1]["change"] > 0 ? "+" . round($markets[1]["change"], 2) : round($markets[1]["change"], 2) }}</b>
                        </span>
                    @endif
                </td>
            @endif
            {{--<b class="index-ohlc"> {{ date("g:i:s A T", $markets[1]["timestamp"]) }} </b>--}}
            {{--<td class="index-code-bottom-0 right-align right-margin-padding trade-date hide-on-small-and-down">{{ $markets[1]["open"] == "NA" ? "-" : date("F d, Y", $markets[1]["timestamp"]) }}</td>--}}
        </tr>
        <tr>
            <td class="index-code">{{ $markets[1]["open"] == "NA" ? "-" : $markets[1]["code"] }}</td>
            <td class="right-align hide-on-small-and-down"></td>
            <td class="right-align hide-on-small-and-down"></td>
            {{--<td class="right-align"></td>--}}
            {{--<td class="right-align"></td>--}}
            <td class="index-code right-align right-margin-padding trade-date" colspan="3">{{ $markets[1]["open"] == "NA" ? "-" : date("F d, Y", $markets[1]["timestamp"]) . " " . date("g:i A", $markets[1]["timestamp"]) }}</td>
        </tr>
        </tbody>
    </table>
</div>