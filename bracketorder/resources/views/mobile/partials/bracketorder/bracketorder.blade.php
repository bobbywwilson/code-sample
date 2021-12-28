@if(strtoupper(substr($quote["code"], -5, 5)) == ".INDX")
    <p class="uppercase table-heading">Support & Resistance</p>
    <p class="uppercase"><b>{!! str_replace("Â", "&reg;", str_replace("TM", "&#8482;", str_replace("â€”", " - ", str_replace("â€™", "'", $bracket["name"])))) !!}</b></p>
@else
    <p class="uppercase table-heading">Bracket Order (Good Until Canceled)</p>
    <p class="uppercase"><b>{!! str_replace("Â", "&reg;", str_replace("TM", "&#8482;", str_replace("â€”", " - ", str_replace("â€™", "'", $bracket["name"])))) !!}</b></p>
@endif

<table class="table-adjust-margin-bottom">
    <thead>
    <tr class="no-border height-adjustment">
        @if(strtoupper(substr($quote["code"], -5, 5)) == ".INDX")
            {{--<th class="uppercase table-heading" colspan="3">Support & Resistance</th>--}}
            @if($bracket["buy_limit"] > ($quote["previousClose"] + $quote["change"]))
                <th class="right-align uppercase">Resistance</th>
            @else
                <th class="right-align uppercase">Support</th>
            @endif
            <th class="right-align uppercase">Resistance</th>
            <th class="right-align right-margin-padding uppercase hide-small">Losing Support</th>
        @else
            {{--<th class="uppercase table-heading" colspan="3">Bracket Order (Good Until Canceled)</th>--}}
            @if($bracket["buy_limit"] > ($quote["previousClose"] + $quote["change"]))
                <th class="right-align uppercase">Buy Stop Limit</th>
            @else
                <th class="right-align uppercase">Buy Limit</th>
            @endif
            <th class="right-align uppercase">Sell Limit</th>
            <th class="right-align right-margin-padding uppercase hide-small">Stop Limit</th>
        @endif
    </tr>
    </thead>

    <tbody>
    <tr class="no-border">
        @if(strtoupper(substr($quote["code"], -5, 5)) == ".INDX")
            <td class="right-align strong-text">{{ number_format($bracket["buy_limit"], 2) }}</td>
            <td class="right-align strong-text">{{ number_format($bracket["sell_limit"], 2) }}</td>
            <td class="right-align right-margin-padding strong-text">{{ number_format($bracket["stop_limit"], 2) }}</td>
        @else
            <td class="right-align strong-text">{{ $currencyFormat->formatCurrency($bracket["buy_limit"], "USD") }}</td>
            <td class="right-align strong-text">{{ $currencyFormat->formatCurrency($bracket["sell_limit"], "USD") }}</td>
            <td class="right-align right-margin-padding strong-text">{{ $currencyFormat->formatCurrency($bracket["stop_limit"], "USD") }}</td>
        @endif
    </tr>
    {{--<tr>--}}
    {{--<td class="index-code uppercase">{{ $bracket["symbol"] }}</td>--}}
    {{--<td class="right-align"></td>--}}
    {{--<td class="right-align"></td>--}}
    {{--<td class="right-align"></td>--}}
    {{--<td class="right-align"></td>--}}
    {{--<td class="index-code right-align right-margin-padding trade-date hide-on-small-and-down">{{ date("F d, Y") }}</td>--}}
    {{--</tr>--}}
    </tbody>
</table>
