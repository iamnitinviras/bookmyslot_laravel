
@php
$stripe_payment_status = isset($stripe->stripe_status) ? $stripe->stripe_status : 'disable';
$stripe_payment_mode = isset($stripe->stripe_mode) ? $stripe->stripe_mode : 'test';
@endphp

<div class="card">
    <input name="gateway_type" type="hidden" value="stripe" />
    <div class="card-header">{{ __('system.payment_setting.stripe_payments') }}</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <select name="stripe_currency_code" id="stripe_currency_code" required="required"
                        class="form-control form-select">
                        <option value="">Select Currency Code </option>
                        <option value="INR"> Indian rupee </option>
                        <option value="USD"> United States dollar </option>
                        <option value="AED"> United Arab Emirates Dirham </option>
                        <option value="AFN"> Afghan Afghani </option>
                        <option value="ALL"> Albanian Lek </option>
                        <option value="AMD"> Armenian Dram </option>
                        <option value="ANG"> Netherlands Antillean Guilder </option>
                        <option value="AOA"> Angolan Kwanza </option>
                        <option value="ARS"> Argentine Peso</option>
                        <option value="AUD"> Australian Dollar</option>
                        <option value="AWG"> Aruban Florin</option>
                        <option value="AZN"> Azerbaijani Manat </option>
                        <option value="BAM"> Bosnia-Herzegovina Convertible Mark </option>
                        <option value="BBD"> Bajan dollar </option>
                        <option value="BDT"> Bangladeshi Taka</option>
                        <option value="BGN"> Bulgarian Lev </option>
                        <option value="BIF"> Burundian Franc</option>
                        <option value="BMD"> Bermudan Dollar</option>
                        <option value="BND"> Brunei Dollar </option>
                        <option value="BOB"> Bolivian Boliviano </option>
                        <option value="BRL"> Brazilian Real </option>
                        <option value="BSD"> Bahamian Dollar </option>
                        <option value="BWP"> Botswanan Pula </option>
                        <option value="BZD"> Belize Dollar </option>
                        <option value="CAD"> Canadian Dollar </option>
                        <option value="CDF"> Congolese Franc </option>
                        <option value="CHF"> Swiss Franc </option>
                        <option value="CLP"> Chilean Peso </option>
                        <option value="CNY"> Chinese Yuan </option>
                        <option value="COP"> Colombian Peso </option>
                        <option value="CRC"> Costa Rican Colón </option>
                        <option value="CVE"> Cape Verdean Escudo </option>
                        <option value="CZK"> Czech Koruna </option>
                        <option value="DJF"> Djiboutian Franc </option>
                        <option value="DKK"> Danish Krone </option>
                        <option value="DOP"> Dominican Peso </option>
                        <option value="DZD"> Algerian Dinar </option>
                        <option value="EGP"> Egyptian Pound </option>
                        <option value="ETB"> Ethiopian Birr </option>
                        <option value="EUR"> Euro </option>
                        <option value="FJD"> Fijian Dollar </option>
                        <option value="FKP"> Falkland Island Pound </option>
                        <option value="GBP"> Pound sterling </option>
                        <option value="GEL"> Georgian Lari </option>
                        <option value="GIP"> Gibraltar Pound </option>
                        <option value="GMD"> Gambian dalasi </option>
                        <option value="GNF"> Guinean Franc </option>
                        <option value="GTQ"> Guatemalan Quetzal </option>
                        <option value="GYD"> Guyanaese Dollar </option>
                        <option value="HKD"> Hong Kong Dollar </option>
                        <option value="HNL"> Honduran Lempira </option>
                        <option value="HRK"> Croatian Kuna </option>
                        <option value="HTG"> Haitian Gourde </option>
                        <option value="HUF"> Hungarian Forint </option>
                        <option value="IDR"> Indonesian Rupiah </option>
                        <option value="ILS"> Israeli New Shekel </option>
                        <option value="ISK"> Icelandic Króna </option>
                        <option value="JMD"> Jamaican Dollar </option>
                        <option value="JPY"> Japanese Yen </option>
                        <option value="KES"> Kenyan Shilling </option>
                        <option value="KGS"> Kyrgystani Som </option>
                        <option value="KHR"> Cambodian riel </option>
                        <option value="KMF"> Comorian franc </option>
                        <option value="KRW"> South Korean won </option>
                        <option value="KYD"> Cayman Islands Dollar </option>
                        <option value="KZT"> Kazakhstani Tenge </option>
                        <option value="LAK"> Laotian Kip </option>
                        <option value="LBP"> Lebanese pound </option>
                        <option value="LKR"> Sri Lankan Rupee </option>
                        <option value="LRD"> Liberian Dollar </option>
                        <option value="LSL"> Lesotho loti </option>
                        <option value="MAD"> Moroccan Dirham </option>
                        <option value="MDL"> Moldovan Leu </option>
                        <option value="MGA"> Malagasy Ariary </option>
                        <option value="MKD"> Macedonian Denar </option>
                        <option value="MMK"> Myanmar Kyat </option>
                        <option value="MNT"> Mongolian Tugrik </option>
                        <option value="MOP"> Macanese Pataca </option>
                        <option value="MRO"> Mauritanian Ouguiya </option>
                        <option value="MUR"> Mauritian Rupee</option>
                        <option value="MVR"> Maldivian Rufiyaa </option>
                        <option value="MWK"> Malawian Kwacha </option>
                        <option value="MXN"> Mexican Peso </option>
                        <option value="MYR"> Malaysian Ringgit </option>
                        <option value="MZN"> Mozambican metical </option>
                        <option value="NAD"> Namibian dollar </option>
                        <option value="NGN"> Nigerian Naira </option>
                        <option value="NIO"> Nicaraguan Córdoba </option>
                        <option value="NOK"> Norwegian Krone </option>
                        <option value="NPR"> Nepalese Rupee </option>
                        <option value="NZD"> New Zealand Dollar </option>
                        <option value="PAB"> Panamanian Balboa </option>
                        <option value="PEN"> Sol </option>
                        <option value="PGK"> Papua New Guinean Kina </option>
                        <option value="PHP"> Philippine peso </option>
                        <option value="PKR"> Pakistani Rupee </option>
                        <option value="PLN"> Poland złoty </option>
                        <option value="PYG"> Paraguayan Guarani </option>
                        <option value="QAR"> Qatari Rial </option>
                        <option value="RON"> Romanian Leu </option>
                        <option value="RSD"> Serbian Dinar </option>
                        <option value="RUB"> Russian Ruble </option>
                        <option value="RWF"> Rwandan franc </option>
                        <option value="SAR"> Saudi Riyal </option>
                        <option value="SBD"> Solomon Islands Dollar </option>
                        <option value="SCR"> Seychellois Rupee </option>
                        <option value="SEK"> Swedish Krona </option>
                        <option value="SGD"> Singapore Dollar </option>
                        <option value="SHP"> Saint Helenian Pound </option>
                        <option value="SLL"> Sierra Leonean Leone </option>
                        <option value="SOS"> Somali Shilling </option>
                        <option value="SRD"> Surinamese Dollar </option>
                        <option value="STD"> Sao Tome Dobra </option>
                        <option value="SZL"> Swazi Lilangeni </option>
                        <option value="THB"> Thai Baht </option>
                        <option value="TJS"> Tajikistani Somoni </option>
                        <option value="TOP"> Tongan Paʻanga </option>
                        <option value="TRY"> Turkish lira </option>
                        <option value="TTD"> Trinidad &amp; Tobago Dollar </option>
                        <option value="TWD"> New Taiwan dollar </option>
                        <option value="TZS"> Tanzanian Shilling </option>
                        <option value="UAH"> Ukrainian hryvnia </option>
                        <option value="UGX"> Ugandan Shilling </option>
                        <option value="UYU"> Uruguayan Peso </option>
                        <option value="UZS"> Uzbekistani Som </option>
                        <option value="VND"> Vietnamese dong </option>
                        <option value="VUV"> Vanuatu Vatu </option>
                        <option value="WST"> Samoa Tala</option>
                        <option value="XAF"> Central African CFA franc </option>
                        <option value="XCD"> East Caribbean Dollar </option>
                        <option value="XOF"> West African CFA franc </option>
                        <option value="XPF"> CFP Franc </option>
                        <option value="YER"> Yemeni Rial </option>
                        <option value="ZAR"> South African Rand </option>
                        <option value="ZMW"> Zambian Kwacha </option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label">{{ __('system.payment_setting.publish_key') }}</label>
                    <input value="{{ isset($stripe->stripe_publish_key) ? $stripe->stripe_publish_key : '' }}"
                        type="text" name="stripe_publish_key" required class="form-control"
                        placeholder="{{ trans('system.payment_setting.publish_key') }}">
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label">{{ trans('system.payment_setting.secret_key') }}</label>
                    <input value="{{ isset($stripe->stripe_secret_key) ? $stripe->stripe_secret_key : '' }}" type="text"
                        name="stripe_secret_key" required class="form-control"
                        placeholder="{{ trans('system.payment_setting.secret_key') }}">
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label"
                        for="stripe_mode">{{ trans('system.payment_setting.gateway_mode') }}</label>
                    <select id="stripe_mode" name="stripe_mode" required class="form-control">
                        <option {{ $stripe_payment_mode == 'test' ? 'selected' : '' }} value="test">
                            {{ trans('system.payment_setting.test') }}
                        </option>
                        <option {{ $stripe_payment_mode == 'live' ? 'selected' : '' }} value="live">
                            {{ trans('system.payment_setting.production') }}
                        </option>
                    </select>
                </div>
            </div>
            <input type="hidden" name="hidden_stripe_mode" value="{{$stripe_payment_mode}}" />
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label" for="stripe_status">{{ trans('system.payment_setting.status') }}</label>
                    <select id="stripe_status" name="stripe_status" required class="form-control">
                        <option {{ $stripe_payment_status == 'enable' ? 'selected' : '' }} value="enable">
                            {{ trans('system.payment_setting.enable') }}
                        </option>
                        <option {{ $stripe_payment_status == 'disable' ? 'selected' : '' }} value="disable">
                            {{ trans('system.payment_setting.disable') }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
