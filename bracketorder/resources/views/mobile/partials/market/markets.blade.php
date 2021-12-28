<ul class="tabs tabs-fixed-width" id="markets-tabs">
    <li class="tab"><a class="active" href="#{{ $markets[1]["code"] }}" id="gspc" value="gspc.indx">S&P 500</a></li>
    <li class="tab"><a href="#{{ $markets[2]["code"] }}" id="ixic">Nasdaq</a></li>
    <li class="tab"><a href="#{{ $markets[0]["code"] }}" id="dji">DJIA</a></li>
    <li class="tab"><a href="#{{ $markets[3]["code"] }}" id="rut">Russell 2000</a></li>
</ul>
@if(!empty($markets))
    @foreach($markets as $market)
    <div id="{{ $market["code"] }}" class="col s12 markets-tab">
        <table id="markets-tables">
            <thead>
            <tr class="no-border">
                <th class="uppercase table-heading">Index</th>
                <th class="right-align uppercase">Last</th>
                <th class="right-align uppercase">Change</th>
                <th class="right-align uppercase hide-on-small-and-down">% Change</th>
                {{--<th class="right-align uppercase right-margin-padding hide-on-small-and-down">Date</th>--}}
            </tr>
            </thead>

            <tbody>
            <tr class="no-border">
                <td class="uppercase"><b>{{ $market["name"] }} </b></td>
                <td class="right-align">{{ $market["close"] == "NA" ? "-" : number_format(($market["previousClose"] + $market["change"]), 2) }}</td>
                <td class="right-align">
                    @if($market["change"] == 0 || $market["change"] == "NA")
                        <span>-</span>
                    @else
                        <span class="{{ $market["change"] > 0 ? 'green-number' : 'red-number' }}">
                            {{ $market["change"] > 0 ? "+" . number_format($market["change"], 2) : number_format($market["change"], 2) }}
                        </span>
                    @endif
                </td>
                <td class="right-align hide-on-small-and-down">
                    @if($market["change"] == "NA")
                        <span>-</span>
                    @else
                        @if(round((($market["change"]/$market["previousClose"]) * 100), 2) == 0)
                            <span>-</span>
                        @else
                            <span class="{{ round((($market["change"]/$market["previousClose"]) * 100), 2) > 0 ? 'green-number' : 'red-number' }}">
                                {{ round((($market["change"]/$market["previousClose"]) * 100), 2) > 0 ? "+" . number_format((($market["change"]/$market["previousClose"]) * 100), 2) . "%" : number_format((($market["change"]/$market["previousClose"]) * 100), 2) . "%" }}
                            </span>
                        @endif
                    @endif
                </td>
                {{--<td class="right-align right-margin-padding trade-date hide-on-small-and-down">{{ $market["timestamp"] == "NA" ? "-" : date("F d, Y", $market["timestamp"]) }}</td>--}}
            </tr>
            <tr>
                <td class="index-code">{{ $market["code"] }}</td>
                {{--<td class="right-align"></td>--}}
                {{--<td class="right-align"></td>--}}
                <td class="right-align right-margin-padding-20" colspan="3">{{ $market["timestamp"] == "NA" ? "-" : date("F d, Y", $market["timestamp"]) . " - " . date("g:i A T", $market["timestamp"]) }}</td>
            </tr>
            </tbody>
        </table>

        <div class="markets-technical-tables" id="{{ substr($market["code"], 0, -5) }}-technical-tables"></div>
    </div>
    @endforeach
@endif