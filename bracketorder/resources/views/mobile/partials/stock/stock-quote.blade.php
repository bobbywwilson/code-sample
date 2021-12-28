
<div class="col s12" id="card-col-quote">
    <table class="quote-table">
        <thead>
        <tr class="no-border">
            <th class="uppercase table-heading">Company</th>
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
            @if(strtoupper(substr($quote["code"], -5, 5)) == ".INDX")
                <td class="uppercase"><b>{!! substr($quote["code"], 0, -5) !!}</b></td>
            @else
                <td class="uppercase"><b>{!! substr($quote["code"], 0, -3) !!}</b></td>
            @endif
            @if(strtoupper(substr($quote["code"], -5, 5)) == ".INDX")
                <td class="right-align hide-on-small-and-down"><b>{{ $quote["open"] == "NA" ? "-" : number_format($quote["open"], 2) }}</b></td>
                <td class="right-align hide-on-small-and-down"><b>{{ $quote["high"] == "NA" ? "-" : number_format($quote["high"], 2) }}</b></td>
                <td class="right-align hide-on-small-and-down"><b>{{ $quote["low"] == "NA" ? "-" :  number_format($quote["low"], 2) }}</b></td>
                @if($session == "open")
                    <td class="right-align"><b>{{ $quote["previousClose"] == "NA" ? "-" : number_format(($quote["previousClose"] + $quote["change"]), 2) }}</b></td>
                @elseif($session == "closed")
                    <td class="right-align"><b>{{ $quote["close"] == "NA" ? "-" : number_format(($quote["close"]), 2) }}</b></td>
                @endif

                @if($quote["change"] == 0)
                    <td class="right-align"><span>-</span></td>
                @else
                    <td class="right-align">
                <span class="{{ $quote["change"] > 0 ? 'green-number' : 'red-number' }}">
                    <b>{{ $quote["change"] > 0 ? "+" . number_format($quote["change"], 2) : number_format($quote["change"], 2) }}</b>
                </span>
                    </td>
                @endif
            @else
                <td class="right-align hide-on-small-and-down"><b>{{ $quote["open"] == "NA" ? "-" :  $currencyFormat->formatCurrency($quote["open"], "USD") }}</b></td>
                <td class="right-align hide-on-small-and-down"><b>{{ $quote["high"] == "NA" ? "-" : $currencyFormat->formatCurrency($quote["high"], "USD") }}</b></td>
                <td class="right-align hide-on-small-and-down"><b>{{ $quote["low"] == "NA" ? "-" : $currencyFormat->formatCurrency($quote["low"], "USD") }}</b></td>
                @if($session == "open")
                    <td class="right-align"><b>{{ $quote["previousClose"] == "NA" ? "-" : $currencyFormat->formatCurrency(($quote["previousClose"] + $quote["change"]), "USD") }}</b></td>
                @elseif($session == "closed")
                    <td class="right-align"><b>{{ $quote["close"] == "NA" ? "-" : $currencyFormat->formatCurrency(($quote["close"]), "USD") }}</b></td>
                @endif

                @if($quote["change"] == 0)
                    <td class="right-align"><span>-</span></td>
                @else
                    <td class="right-align">
                <span class="{{ $quote["change"] > 0 ? 'green-number' : 'red-number' }}">
                    <b>{{ $quote["change"] > 0 ? "+" . $currencyFormat->formatCurrency($quote["change"], "USD") : $currencyFormat->formatCurrency($quote["change"], "USD") }}</b>
                </span>
                    </td>
                @endif
            @endif
            {{--<b class="index-ohlc"> {{ date("g:i:s A T", $markets[0]["timestamp"]) }} </b>--}}
            {{--<td class="index-code-bottom-0 right-align right-margin-padding trade-date hide-on-small-and-down">{{ date("F d, Y", $quote["timestamp"]) }}</td>--}}
        </tr>
        <tr>
            <td class="index-code">{{ $quote["code"] }}</td>
            <td class="index-code right-align hide-on-small-and-down"></td>
            <td class="index-code right-align hide-on-small-and-down"></td>
            <td class="index-code right-align hide-on-small-and-down"></td>
            <td class="index-code right-align right-margin-padding" colspan="3">{{ $quote["timestamp"] == "NA" ? "-" : date("F d, Y", $quote["timestamp"]) . " " . date("g:i A", $quote["timestamp"]) }}</td>
        </tr>
        </tbody>
    </table>
</div>