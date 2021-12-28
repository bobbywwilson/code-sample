<div class="col s12 no-padding-left no-padding-right">
    <h5 class="no-margin-left"><span class="smaller-text white-indicator no-left">{{ date("F j, Y", strtotime($bracket["date"])) }}</span> <span class="smaller-text silver-indicator"> (Good Til Canceled)</span></h5>
</div>

@if(strtoupper(substr($quote["code"], -5, 5)) == ".INDX")
    <div class="col s4 no-padding-left">
        <h6 class="silver-indicator" id="technicals">Support</h6>
        <h5 class="white-indicator no-left">{{ number_format($bracket["buy_limit"], 2) }}</h5>
    </div>
    <div class="col s4 no-padding-left">
        <h6 class="silver-indicator center-align" id="technicals">Resistance</h6>
        <h5 class="white-indicator center-align adjust-center-align">{{ number_format($bracket["sell_limit"], 2) }}</h5>
    </div>
    <div class="col s4 no-padding-left">
        <h6 class="silver-indicator right-align" id="technicals">Loosing Support</h6>
        <h5 class="white-indicator right-align adjust-right-align">{{ number_format($bracket["stop_limit"], 2) }}</h5>
    </div>
@else
    <table>
        <tr>
            <th>
                @if($bracket["buy_limit"] > ($quote["previousClose"] + $quote["change"]))
                    <h6 class="silver-indicator no-margin-left" id="risk-ratio">Ratio <span class="float-right float-right-padding">Buy</span></h6>
                @else
                    <h6 class="silver-indicator no-margin-left" id="risk-ratio">Ratio</h6>
                @endif
            </th>
            <th>
                @if($bracket["buy_limit"] > ($quote["previousClose"] + $quote["change"]))
                    <h6 class="silver-indicator no-margin right-align" id="buy-stop-limit">Stop Limit</h6>
                @else
                    <h6 class="silver-indicator no-margin right-align" id="buy-stop-limit">Buy Limit</h6>
                @endif
            </th>
            <th>
                <h6 class="silver-indicator no-margin right-align" id="sell-limit">Sell Limit</h6>
            </th>
            <th>
                <h6 class="silver-indicator no-margin right-align" id="sell-stop">Sell Stop</h6>
            </th>
        </tr>
        <tr>
            <td class="first-cell-width"><span class="grey-indicator" id="risk-reward">Risk-Reward: 1:3</span></td>
            <td class="remaining-cell-width"><h5 class="white-indicator no-margin right-align">{{ number_format($bracket["buy_limit"], 2) }}</h5></td>
            <td class="remaining-cell-width"><h5 class="white-indicator no-margin right-align">{{ number_format($bracket["sell_limit"], 2) }}</h5></td>
            <td class="remaining-cell-width"><h5 class="white-indicator no-margin right-align">{{ number_format($bracket["stop_limit"], 2) }}</h5></td>
        </tr>
    </table>
@endif