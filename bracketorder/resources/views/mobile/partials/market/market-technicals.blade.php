
<div class="row content-sections" id="content-sections-technicals">
    <table class="" id="markets-technicals-table">
        <thead>
            <tr class="no-border">
                <th colspan="3"></th>
                <th colspan="2"></th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="uppercase" colspan="2"><b>SMA</b> <span class="index-code-bottom-0">(21, 63, 200)</span></td>
                @if ($technicals["sma"]["sma_signal"] == "uptrend")
                    <td class="badge-align-right" colspan="3"><span class="new badge technical red lighten-4 uppercase" data-badge-caption>{{ $technicals["sma"]["sma_signal"] }}</span></td>
                @elseif ($technicals["sma"]["sma_signal"] == "caution")
                    <td class="badge-align-right" colspan="3"><span class="new badge technical grey lighten-2 uppercase" data-badge-caption>{{ $technicals["sma"]["sma_signal"] }}</span></td>
                @elseif ($technicals["sma"]["sma_signal"] == "downtrend")
                    <td class="badge-align-right" colspan="3"><span class="new badge technical green lighten-4 uppercase" data-badge-caption>{{ $technicals["sma"]["sma_signal"] }}</span></td>
                @elseif ($technicals["sma"]["sma_signal"] == "down reversal")
                    <td class="badge-align-right" colspan="3"><span class="new badge technical green lighten-4 uppercase" data-badge-caption>{{ $technicals["sma"]["sma_signal"] }}</span></td>
                @elseif ($technicals["sma"]["sma_signal"] == "up reversal")
                    <td class="badge-align-right" colspan="3"><span class="new badge technical red lighten-4 uppercase" data-badge-caption>{{ $technicals["sma"]["sma_signal"] }}</span></td>
                @endif
            </tr>
        </tbody>

        <thead>
            <tr class="no-border">
                <th class="uppercase">21 Day SMA</th>
                <th class="uppercase" id="index-sell-limit-label">63 Day SMA</th>
                <th class="uppercase" id="index-stop-limit-label">200 Day SMA</th>
                {{--<th colspan="2"></th>--}}
            </tr>
        </thead>

        <tbody>
        <tr class="striped">
            <td class="technicals-border">{{ number_format($technicals["sma"]["sma_21"], 2) }}</td>
            <td class="technicals-border" id="index-sell-limit">{{ number_format($technicals["sma"]["sma_63"], 2) }}</td>
            <td class="technicals-border" id="index-stop-limit">{{ number_format($technicals["sma"]["sma_200"], 2) }}</td>
        </tr>
        </tbody>

        <thead>
            <tr class="no-border">
                <th colspan="2"></th>
                <th colspan="3"></th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="uppercase" colspan="2"><b>Bollinger Bands</b> <span class="index-code-bottom-0">(20, 2)</span></td>
                @if ($technicals["bollinger_bands"]["bb_signal"] == "oversold")
                    <td class="badge-align-right" colspan="3"><span class="new badge technical red lighten-4 uppercase" data-badge-caption>{{ $technicals["bollinger_bands"]["bb_signal"] }}></span></td>
                @elseif ($technicals["bollinger_bands"]["bb_signal"] == "caution")
                    <td class="badge-align-right" colspan="3"><span class="new badge technical grey lighten-2 uppercase" data-badge-caption>{{ $technicals["bollinger_bands"]["bb_signal"] }}</span></td>
                @elseif ($technicals["bollinger_bands"]["bb_signal"] == "overbought")
                    <td class="badge-align-right" colspan="3"><span class="new badge technical green lighten-4 uppercase" data-badge-caption>{{ $technicals["bollinger_bands"]["bb_signal"] }}</span></td>
                @endif
            </tr>
        </tbody>

        <thead>
            <tr class="no-border">
                <th class="uppercase">BB Upper</th>
                <th class="uppercase" id="index-sell-limit-label">BB Middle</th>
                <th class="uppercase" id="index-stop-limit-label">BB Lower</th>
            </tr>
        </thead>

        <tbody>
            <tr class="striped">
                <td class="technicals-border">{{ number_format($technicals["bollinger_bands"]["upper"], 2) }}</td>
                <td class="technicals-border" id="index-sell-limit">{{ number_format($technicals["bollinger_bands"]["middle"], 2) }}</td>
                <td class="technicals-border" id="index-stop-limit">{{ number_format($technicals["bollinger_bands"]["lower"], 2) }}</td>
            </tr>
        </tbody>

        <thead>
            <tr class="no-border">
                <th colspan="2"></th>
                <th colspan="3"></th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="uppercase" colspan="2"><b>MACD</b> <span class="index-code-bottom-0">(12, 26, 9)</span></td>
                @if ($technicals["macd"]["macd_signal"] == "oversold")
                    <td class="badge-align-right center-align" colspan="3"><span class="new badge technical red lighten-4 uppercase" data-badge-caption>{{ $technicals["macd"]["macd_signal"] }}</span></td>
                @elseif ($technicals["macd"]["macd_signal"] == "caution")
                    <td class="badge-align-right center-align" colspan="3"><span class="new badge technical grey lighten-2 uppercase" data-badge-caption>{{ $technicals["macd"]["macd_signal"] }}</span></td>
                @elseif ($technicals["macd"]["macd_signal"] == "overbought")
                    <td class="badge-align-right center-align" colspan="3"><span class="new badge technical green lighten-4 uppercase" data-badge-caption>{{ $technicals["macd"]["macd_signal"] }}</span></td>
                @endif
            </tr>
        </tbody>

        <thead>
            <tr class="no-border">
                <th class="uppercase">MACD</th>
                <th class="uppercase hide-small" id="index-sell-limit-label">Signal Line</th>
                <th class="uppercase hide-small" id="index-stop-limit-label">Divergence</th>
            </tr>
        </thead>

        <tbody>
            <tr class="striped">
                <td class="technicals-border">{{ $technicals["macd"]["macd"] }}</td>
                <td class="technicals-border" id="index-sell-limit">{{ $technicals["macd"]["signal"] }}</td>
                <td class="technicals-border" id="index-stop-limit">{{ $technicals["macd"]["divergence"] }}</td>
            </tr>
        </tbody>

        <thead>
            <tr class="no-border">
                <th colspan="2"></th>
                <th colspan="3"></th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="uppercase" colspan="2"><b>RSI</b> <span class="index-code-bottom-0">(14, 28, 42)</span></td>
                @if ($technicals["rsi"]["rsi_signal"] == "oversold")
                    <td class="badge-align-right center-align" colspan="3"><span class="new badge technical red lighten-4 uppercase" data-badge-caption>{{ $technicals["rsi"]["rsi_signal"] }}</span></td>
                @elseif ($technicals["rsi"]["rsi_signal"] == "caution")
                    <td class="badge-align-right center-align" colspan="3"><span class="new badge technical grey lighten-2 uppercase" data-badge-caption>{{ $technicals["rsi"]["rsi_signal"] }}</span></td>
                @elseif ($technicals["rsi"]["rsi_signal"] == "overbought")
                    <td class="badge-align-right center-align" colspan="3"><span class="new badge technical green lighten-4 uppercase" data-badge-caption>{{ $technicals["rsi"]["rsi_signal"] }}</span></td>
                @endif
            </tr>
        </tbody>

        <thead>
            <tr class="no-border">
                <th class="uppercase">14 Days</th>
                <th class="uppercase hide-small" id="index-sell-limit-label">28 Days</th>
                <th class="uppercase hide-small" id="index-stop-limit-label">42 Days</th>
            </tr>
        </thead>

        <tbody>
            <tr class="striped">
                <td class="technicals-border">{{ $technicals["rsi"]["rsi_14"] }}</td>
                <td class="technicals-border" id="index-sell-limit">{{ $technicals["rsi"]["rsi_28"] }}</td>
                <td class="technicals-border" id="index-stop-limit">{{ $technicals["rsi"]["rsi_42"] }}</td>
            </tr>
        </tbody>

        <thead>
            <tr class="no-border">
                <th colspan="2"></th>
                <th colspan="3"></th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="uppercase" colspan="2"><b>Stochastic Fast</b> <span class="index-code-bottom-0">(14, 3)</span></td>
                @if ($technicals["stochastic_fast"]["stochastic_fast_signal"] == "oversold")
                    <td class="badge-align-right center-align" colspan="3"><span class="new badge technical red lighten-4 uppercase" data-badge-caption>{{ $technicals["stochastic_fast"]["stochastic_fast_signal"] }}</span></td>
                @elseif ($technicals["stochastic_fast"]["stochastic_fast_signal"] == "caution")
                    <td class="badge-align-right center-align" colspan="3"><span class="new badge technical grey lighten-2 uppercase" data-badge-caption>{{ $technicals["stochastic_fast"]["stochastic_fast_signal"] }}</span></td>
                @elseif ($technicals["stochastic_fast"]["stochastic_fast_signal"] == "overbought")
                    <td class="badge-align-right center-align" colspan="3"><span class="new badge technical green lighten-4 uppercase" data-badge-caption>{{ $technicals["stochastic_fast"]["stochastic_fast_signal"] }}</span></td>
                @endif
            </tr>
        </tbody>

        <thead>
            <tr class="no-border">
                <th class="uppercase">%D 14 Days</th>
                <th class="uppercase hide-small" id="index-sell-limit-label">%K 3 Days</th>
                <th class="center-align uppercase" id="index-stop-limit-label"></th>
            </tr>
        </thead>

        <tbody>
            <tr class="striped">
                <td class="technicals-border">{{ $technicals["stochastic_fast"]["stochastic_d"] }}</td>
                <td class="technicals-border" id="index-sell-limit">{{ $technicals["stochastic_fast"]["stochastic_k"] }}</td>
                <td class="technicals-border"></td>
            </tr>
        </tbody>

        <thead>
        <tr class="no-border">
            <th colspan="5"></th>
        </tr>
        </thead>
    </table>
</div>