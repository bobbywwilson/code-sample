
<div class="col s12 no-padding-left no-padding-right">
    
</div>
<table>
    <tr>
        <th>
            <h5><span class="smaller-text white-indicator no-left">SMA</span> <span class="smaller-text silver-indicator"> (21, 63, 200)</span></h5>
        </th>
        <th>
            <h6 class="silver-indicator no-margin right-align adjust-table-heading" id="sma-21-day">21 Day</h6>
        </th>
        <th>
            <h6 class="silver-indicator no-margin right-align adjust-table-heading" id="sma-63-day">63 Day</h6>
        </th>
        <th>
            <h6 class="silver-indicator no-margin right-align adjust-table-heading" id="sma-200-day">200 Day</h6>
        </th>
    </tr>
    <tr>
        <td class="first-cell-width row-shading">
            @if ($technicals["sma"]["sma_signal"] == "uptrend")
                <span class="new badge technical green-indicator-pill uppercase" data-badge-caption>{{ $technicals["sma"]["sma_signal"] }}</span>
            @elseif ($technicals["sma"]["sma_signal"] == "caution")
                <span class="new badge technical grey-indicator-pill uppercase" data-badge-caption>{{ $technicals["sma"]["sma_signal"] }}</span>
            @elseif ($technicals["sma"]["sma_signal"] == "downtrend")
                <span class="new badge technical red-indicator-pill uppercase" data-badge-caption>{{ $technicals["sma"]["sma_signal"] }}</span>
            @elseif ($technicals["sma"]["sma_signal"] == "down reversal")
                <span class="new badge technical red-indicator-pill uppercase" data-badge-caption>{{ $technicals["sma"]["sma_signal"] }}</span>
            @elseif ($technicals["sma"]["sma_signal"] == "up reversal")
                <span class="new badge technical green-indicator-pill uppercase" data-badge-caption>{{ $technicals["sma"]["sma_signal"] }}</span>
            @endif    
        </td>
        <td class="remaining-cell-width row-shading"><h5 class="white-indicator no-margin right-align">{{ number_format($technicals["sma"]["sma_21"], 2) }}</h5></td>
        <td class="remaining-cell-width row-shading"><h5 class="white-indicator no-margin right-align">{{ number_format($technicals["sma"]["sma_63"], 2) }}</h5></td>
        <td class="remaining-cell-width row-shading"><h5 class="white-indicator no-margin right-align">{{ number_format($technicals["sma"]["sma_200"], 2) }}</h5></td>
    </tr>
</table>

<div class="col s12 no-padding-left no-padding-right">
    
</div>
<table>
    <tr>
        <th>
            <h5><span class="smaller-text white-indicator no-left">Bollinger Bands</span> <span class="smaller-text silver-indicator"> (20, 2)</span></h5>
        </th>
        <th>
            <h6 class="silver-indicator no-margin right-align adjust-table-heading" id="upper-bb">Upper</h6>
        </th>
        <th>
            <h6 class="silver-indicator no-margin right-align adjust-table-heading" id="middle-bb">Middle</h6>
        </th>
        <th>
            <h6 class="silver-indicator no-margin right-align adjust-table-heading" id="lower-bb">Lower</h6>
        </th>
    </tr>
    <tr>
        <td class="first-cell-width row-shading">
            @if ($technicals["bollinger_bands"]["bb_signal"] == "oversold")
                <span class="new badge technical green-indicator-pill uppercase" data-badge-caption>{{ $technicals["bollinger_bands"]["bb_signal"] }}</span>
            @elseif ($technicals["bollinger_bands"]["bb_signal"] == "caution")
                <span class="new badge technical grey-indicator-pill uppercase" data-badge-caption>{{ $technicals["bollinger_bands"]["bb_signal"] }}</span>
            @elseif ($technicals["bollinger_bands"]["bb_signal"] == "overbought")
                <span class="new badge technical red-indicator-pill uppercase" data-badge-caption>{{ $technicals["bollinger_bands"]["bb_signal"] }}</span>
            @endif   
        </td>
        <td class="remaining-cell-width row-shading"><h5 class="white-indicator no-margin right-align">{{ number_format($technicals["bollinger_bands"]["upper"], 2) }}</h5></td>
        <td class="remaining-cell-width row-shading"><h5 class="white-indicator no-margin right-align">{{ number_format($technicals["bollinger_bands"]["middle"], 2) }}</h5></td>
        <td class="remaining-cell-width row-shading"><h5 class="white-indicator no-margin right-align">{{ number_format($technicals["bollinger_bands"]["lower"], 2) }}</h5></td>
    </tr>
</table>


<div class="col s12 no-padding-left no-padding-right">
    
</div>
<table>
    <tr>
        <th>
            <h5><span class="smaller-text white-indicator no-left">MACD</span> <span class="smaller-text silver-indicator"> (12, 26, 9)</span></h5>
        </th>
        <th>
            <h6 class="silver-indicator no-margin right-align adjust-table-heading" id="upper-bb">MACD</h6>
        </th>
        <th>
            <h6 class="silver-indicator no-margin right-align adjust-table-heading" id="middle-bb">Signal</h6>
        </th>
        <th>
            <h6 class="silver-indicator no-margin right-align adjust-table-heading" id="lower-bb">Diverge</h6>
        </th>
    </tr>
    <tr>
        <td class="first-cell-width row-shading">
            @if ($technicals["macd"]["macd_signal"] == "oversold")
                <span class="new badge technical green-indicator-pill uppercase" data-badge-caption>{{ $technicals["macd"]["macd_signal"] }}</span>
            @elseif ($technicals["macd"]["macd_signal"] == "caution")
                <span class="new badge technical grey-indicator-pill uppercase" data-badge-caption>{{ $technicals["macd"]["macd_signal"] }}</span>
            @elseif ($technicals["macd"]["macd_signal"] == "overbought")
                <span class="new badge technical red-indicator-pill uppercase" data-badge-caption>{{ $technicals["macd"]["macd_signal"] }}</span>
            @endif
        </td>
        <td class="remaining-cell-width row-shading"><h5 class="white-indicator no-margin right-align">{{ number_format($technicals["macd"]["macd"], 2) }}</h5></td>
        <td class="remaining-cell-width row-shading"><h5 class="white-indicator no-margin right-align">{{ number_format($technicals["macd"]["signal"], 2) }}</h5></td>
        <td class="remaining-cell-width row-shading"><h5 class="white-indicator no-margin right-align">{{ number_format($technicals["macd"]["divergence"], 2) }}</h5></td>
    </tr>
</table>

<div class="col s12 no-padding-left no-padding-right">
    
</div>
<table>
    <tr>
        <th>
            <h5><span class="smaller-text white-indicator no-left">RSI</span> <span class="smaller-text silver-indicator"> (14, 28, 42)</span></h5>
        </th>
        <th>
            <h6 class="silver-indicator no-margin right-align adjust-table-heading" id="14-day">14 Day</h6>
        </th>
        <th>
            <h6 class="silver-indicator no-margin right-align adjust-table-heading" id="28-day">28 Day</h6>
        </th>
        <th>
            <h6 class="silver-indicator no-margin right-align adjust-table-heading" id="42-day">42 Day</h6>
        </th>
    </tr>
    <tr>
        <td class="first-cell-width row-shading">
            @if ($technicals["rsi"]["rsi_signal"] == "oversold")
                <span class="new badge technical green-indicator-pill uppercase" data-badge-caption>{{ $technicals["rsi"]["rsi_signal"] }}</td></span>
            @elseif ($technicals["rsi"]["rsi_signal"] == "caution")
                <span class="new badge technical grey-indicator-pill uppercase" data-badge-caption>{{ $technicals["rsi"]["rsi_signal"] }}</td></span>
            @elseif ($technicals["rsi"]["rsi_signal"] == "overbought")
                <span class="new badge technical red-indicator-pill uppercase" data-badge-caption>{{ $technicals["rsi"]["rsi_signal"] }}</td></span>
            @endif
        </td>
        <td class="remaining-cell-width row-shading"><h5 class="white-indicator no-margin right-align">{{ number_format($technicals["rsi"]["rsi_28"], 2) }}</h5></td>
        <td class="remaining-cell-width row-shading"><h5 class="white-indicator no-margin right-align">{{ number_format($technicals["rsi"]["rsi_28"], 2) }}</h5></td>
        <td class="remaining-cell-width row-shading"><h5 class="white-indicator no-margin right-align">{{ number_format($technicals["rsi"]["rsi_42"], 2) }}</h5></td>
    </tr>
</table>

<div class="col s12 no-padding-left no-padding-right">
    
</div>
<table>
    <tr>
        <th>
            <h5><span class="smaller-text white-indicator no-left">Stochastic Fast</span> <span class="smaller-text silver-indicator"> (14, 3)</span></h5>
        </th>
        <th></th>
        <th>
            <h6 class="silver-indicator no-margin right-align adjust-table-heading" id="14-day">%D 14</h6>
        </th>
        <th>
            <h6 class="silver-indicator no-margin right-align adjust-table-heading" id="28-day">%K 3</h6>
        </th>
    </tr>
    <tr>
        <td class="first-cell-width row-shading">
            @if ($technicals["stochastic_fast"]["stochastic_fast_signal"] == "oversold")
                <span class="new badge technical green-indicator-pill uppercase" data-badge-caption>{{ $technicals["stochastic_fast"]["stochastic_fast_signal"] }}</td></span>
            @elseif ($technicals["stochastic_fast"]["stochastic_fast_signal"] == "caution")
                <span class="new badge technical grey-indicator-pill uppercase" data-badge-caption>{{ $technicals["stochastic_fast"]["stochastic_fast_signal"] }}</td></span>
            @elseif ($technicals["stochastic_fast"]["stochastic_fast_signal"] == "overbought")
                <span class="new badge technical red-indicator-pill uppercase" data-badge-caption>{{ $technicals["stochastic_fast"]["stochastic_fast_signal"] }}</td></span>
            @endif
        </td>
        <td class="remaining-cell-width row-shading"></td>
        <td class="remaining-cell-width row-shading"><h5 class="white-indicator no-margin right-align">{{ number_format($technicals["rsi"]["rsi_14"], 2) }}</h5></td>
        <td class="remaining-cell-width row-shading"><h5 class="white-indicator no-margin right-align">{{ number_format($technicals["rsi"]["rsi_28"], 2) }}</h5></td>
    </tr>
</table>


                