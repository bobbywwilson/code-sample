<h6 class="divider-heading heading-adjust-mobile uppercase">Custom <span class="extra-bold">Chart</span></h6>
<div class="divider divider-adjust heading-adjust-mobile" id="chart-indicators-divider"></div>

<form class="col s12" id="chart-indicators-form" onsubmit="event.preventDefault();">
    @csrf
    <div class="row">
        <div class="col s8 col m8 col l8">
            <p><b>Indicators</b></p>
            <label for="indicators"></label>
            <select id="indicators" multiple>
                <option value="" disabled selected>Indicators</option>
                <option id="default_chart" value="default_chart">Default Chart</option>
                <option id="bollinger_bands" value="bollinger_bands">Bollinger Bands <i class="far fa-registered"></i></option>
                <option id="macd" value="macd">MACD</option>
                <option id="rsi" value="rsi">RSI</option>
                <option id="stochastic_fast" value="stochastic_fast">Stochastic Fast</option>
            </select>
            <i class="fa fa-chevron-down indicators"></i>
        </div>
    </div>

    <div class="row" id="sma-row-1">
        <div class="input-field col s4 col m4 col l4">
            <p>
                <label>
                    <input type="checkbox" class="filled-in" name="sma-1" id="sma-1" value="sma-1"/>
                    <span>SMA (line 1)</span>
                </label>
            </p>
        </div>

        <div class="input-field col s4 col m4 col l4">
            <input autocomplete="off" autocorrect="off" autocapitalize="off"  id="periods-sma-1" type="text" class="validate">
            <label for="periods-sma-1" id="periods-sma-1-label">Periods</label>
        </div>

        <div class="input-field col s4 col m4 col l4">
            <label for="sma-color-1"></label>
            <select id="sma-color-1">
                <option value="" disabled selected>Color</option>
                <option value="black" data-icon="images/colors/000000-black.png">White</option>
                <option value="yellow" data-icon="images/colors/ffeb3b-yellow.png">Blue</option>
                <option value="red" data-icon="images/colors/b71c1c-red-darken-4.png">Green</option>
                <option value="green" data-icon="images/colors/1b5e20-green-darken-4.png">Red</option>
                <option value="blue" data-icon="images/colors/0d47a1-blue-darken-4.png">Yellow</option>
            </select>
            <i class="fa fa-chevron-down colors"></i>
        </div>
    </div>

    <div class="row" id="sma-row-2">
        <div class="input-field col s4 col m4 col l4">
            <p>
                <label>
                    <input type="checkbox" class="filled-in" name="sma-2" id="sma-2" value="sma-2"/>
                    <span>SMA (line 2)</span>
                </label>
            </p>
        </div>

        <div class="input-field col s4 col m4 col l4">
            <input autocomplete="off" autocorrect="off" autocapitalize="off"  id="periods-sma-2" type="text" class="validate">
            <label for="periods-sma-2" id="periods-sma-2-label">Periods</label>
        </div>

        <div class="input-field col s4 col m4 col l4">
            <label for="sma-color-2"></label>
            <select id="sma-color-2">
                <option value="" disabled selected>Color</option>
                <option value="black" data-icon="images/colors/000000-black.png">White</option>
                <option value="yellow" data-icon="images/colors/ffeb3b-yellow.png">Blue</option>
                <option value="red" data-icon="images/colors/b71c1c-red-darken-4.png">Green</option>
                <option value="green" data-icon="images/colors/1b5e20-green-darken-4.png">Red</option>
                <option value="blue" data-icon="images/colors/0d47a1-blue-darken-4.png">Yellow</option>
            </select>
            <i class="fa fa-chevron-down colors"></i>
        </div>
    </div>

    <div class="row" id="sma-row-3">
        <div class="input-field col s4 col m4 col l4">
            <p>
                <label>
                    <input type="checkbox" class="filled-in" name="sma-3" id="sma-3" value="sma-3"/>
                    <span>SMA (line 3)</span>
                </label>
            </p>
        </div>

        <div class="input-field col s4 col m4 col l4">
            <input autocomplete="off" autocorrect="off" autocapitalize="off"  id="periods-sma-3" type="text" class="validate">
            <label for="periods-sma-3" id="periods-sma-3-label">Periods</label>
        </div>

        <div class="input-field col s4 col m4 col l4">
            <label for="sma-color-3"></label>
            <select id="sma-color-3">
                <option value="" disabled selected>Color</option>
                <option value="black" data-icon="images/colors/000000-black.png">White</option>
                <option value="yellow" data-icon="images/colors/ffeb3b-yellow.png">Blue</option>
                <option value="red" data-icon="images/colors/b71c1c-red-darken-4.png">Green</option>
                <option value="green" data-icon="images/colors/1b5e20-green-darken-4.png">Red</option>
                <option value="blue" data-icon="images/colors/0d47a1-blue-darken-4.png">Yellow</option>
            </select>
            <i class="fa fa-chevron-down colors"></i>
        </div>
    </div>

    <div class="row" id="sma-row-3">
        <div class="input-field col s4 col m4 col l4">
            <div>
                <div class="col s1 no-padding">
                    <button class="waves-effect waves-light btn-small grey darken-4" type="submit" name="save-chart" id="save-chart">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>