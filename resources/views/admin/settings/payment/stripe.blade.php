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
                    <label class="form-label">{{trans('system.payment_setting.select_app_currency')}}</label>
                    <select name="stripe_currency_code" id="stripe_currency_code" required="required"
                        class="form-control form-select">
                        <option value="">{{trans('system.payment_setting.select_app_currency')}}</option>
                        <option {{ config('stripe.currency') == 'INR' ? 'selected' : '' }} value="INR"> Indian rupee </option>
                        <option {{ config('stripe.currency') == 'USD' ? 'selected' : '' }} value="USD"> United States dollar </option>
                        <option {{ config('stripe.currency') == 'AED' ? 'selected' : '' }} value="AED"> United Arab Emirates Dirham </option>
                        <option {{ config('stripe.currency') == 'AFN' ? 'selected' : '' }} value="AFN"> Afghan Afghani </option>
                        <option {{ config('stripe.currency') == 'ALL' ? 'selected' : '' }} value="ALL"> Albanian Lek </option>
                        <option {{ config('stripe.currency') == 'AMD' ? 'selected' : '' }} value="AMD"> Armenian Dram </option>
                        <option {{ config('stripe.currency') == 'ANG' ? 'selected' : '' }} value="ANG"> Netherlands Antillean Guilder </option>
                        <option {{ config('stripe.currency') == 'AOA' ? 'selected' : '' }} value="AOA"> Angolan Kwanza </option>
                        <option {{ config('stripe.currency') == 'ARS' ? 'selected' : '' }} value="ARS"> Argentine Peso</option>
                        <option {{ config('stripe.currency') == 'AUD' ? 'selected' : '' }} value="AUD"> Australian Dollar</option>
                        <option {{ config('stripe.currency') == 'AWG' ? 'selected' : '' }} value="AWG"> Aruban Florin</option>
                        <option {{ config('stripe.currency') == 'AZN' ? 'selected' : '' }} value="AZN"> Azerbaijani Manat </option>
                        <option {{ config('stripe.currency') == 'BAM' ? 'selected' : '' }} value="BAM"> Bosnia-Herzegovina Convertible Mark </option>
                        <option {{ config('stripe.currency') == 'BBD' ? 'selected' : '' }} value="BBD"> Bajan dollar </option>
                        <option {{ config('stripe.currency') == 'BDT' ? 'selected' : '' }} value="BDT"> Bangladeshi Taka</option>
                        <option {{ config('stripe.currency') == 'BGN' ? 'selected' : '' }} value="BGN"> Bulgarian Lev </option>
                        <option {{ config('stripe.currency') == 'BIF' ? 'selected' : '' }} value="BIF"> Burundian Franc</option>
                        <option {{ config('stripe.currency') == 'BMD' ? 'selected' : '' }} value="BMD"> Bermudan Dollar</option>
                        <option {{ config('stripe.currency') == 'BND' ? 'selected' : '' }} value="BND"> Brunei Dollar </option>
                        <option {{ config('stripe.currency') == 'BOB' ? 'selected' : '' }} value="BOB"> Bolivian Boliviano </option>
                        <option {{ config('stripe.currency') == 'BRL' ? 'selected' : '' }} value="BRL"> Brazilian Real </option>
                        <option {{ config('stripe.currency') == 'BSD' ? 'selected' : '' }} value="BSD"> Bahamian Dollar </option>
                        <option {{ config('stripe.currency') == 'BWP' ? 'selected' : '' }} value="BWP"> Botswanan Pula </option>
                        <option {{ config('stripe.currency') == 'BZD' ? 'selected' : '' }} value="BZD"> Belize Dollar </option>
                        <option {{ config('stripe.currency') == 'CAD' ? 'selected' : '' }} value="CAD"> Canadian Dollar </option>
                        <option {{ config('stripe.currency') == 'CDF' ? 'selected' : '' }} value="CDF"> Congolese Franc </option>
                        <option {{ config('stripe.currency') == 'CHF' ? 'selected' : '' }} value="CHF"> Swiss Franc </option>
                        <option {{ config('stripe.currency') == 'CLP' ? 'selected' : '' }} value="CLP"> Chilean Peso </option>
                        <option {{ config('stripe.currency') == 'CNY' ? 'selected' : '' }} value="CNY"> Chinese Yuan </option>
                        <option {{ config('stripe.currency') == 'COP' ? 'selected' : '' }} value="COP"> Colombian Peso </option>
                        <option {{ config('stripe.currency') == 'CRC' ? 'selected' : '' }} value="CRC"> Costa Rican Colón </option>
                        <option {{ config('stripe.currency') == 'CVE' ? 'selected' : '' }} value="CVE"> Cape Verdean Escudo </option>
                        <option {{ config('stripe.currency') == 'CZK' ? 'selected' : '' }} value="CZK"> Czech Koruna </option>
                        <option {{ config('stripe.currency') == 'DJF' ? 'selected' : '' }} value="DJF"> Djiboutian Franc </option>
                        <option {{ config('stripe.currency') == 'DKK' ? 'selected' : '' }} value="DKK"> Danish Krone </option>
                        <option {{ config('stripe.currency') == 'DOP' ? 'selected' : '' }} value="DOP"> Dominican Peso </option>
                        <option {{ config('stripe.currency') == 'DZD' ? 'selected' : '' }} value="DZD"> Algerian Dinar </option>
                        <option {{ config('stripe.currency') == 'EGP' ? 'selected' : '' }} value="EGP"> Egyptian Pound </option>
                        <option {{ config('stripe.currency') == 'ETB' ? 'selected' : '' }} value="ETB"> Ethiopian Birr </option>
                        <option {{ config('stripe.currency') == 'EUR' ? 'selected' : '' }} value="EUR"> Euro </option>
                        <option {{ config('stripe.currency') == 'FJD' ? 'selected' : '' }} value="FJD"> Fijian Dollar </option>
                        <option {{ config('stripe.currency') == 'FKP' ? 'selected' : '' }} value="FKP"> Falkland Island Pound </option>
                        <option {{ config('stripe.currency') == 'GBP' ? 'selected' : '' }} value="GBP"> Pound sterling </option>
                        <option {{ config('stripe.currency') == 'GEL' ? 'selected' : '' }} value="GEL"> Georgian Lari </option>
                        <option {{ config('stripe.currency') == 'GIP' ? 'selected' : '' }} value="GIP"> Gibraltar Pound </option>
                        <option {{ config('stripe.currency') == 'GMD' ? 'selected' : '' }} value="GMD"> Gambian dalasi </option>
                        <option {{ config('stripe.currency') == 'GNF' ? 'selected' : '' }} value="GNF"> Guinean Franc </option>
                        <option {{ config('stripe.currency') == 'GTQ' ? 'selected' : '' }} value="GTQ"> Guatemalan Quetzal </option>
                        <option {{ config('stripe.currency') == 'GYD' ? 'selected' : '' }} value="GYD"> Guyanaese Dollar </option>
                        <option {{ config('stripe.currency') == 'HKD' ? 'selected' : '' }} value="HKD"> Hong Kong Dollar </option>
                        <option {{ config('stripe.currency') == 'HNL' ? 'selected' : '' }} value="HNL"> Honduran Lempira </option>
                        <option {{ config('stripe.currency') == 'HRK' ? 'selected' : '' }} value="HRK"> Croatian Kuna </option>
                        <option {{ config('stripe.currency') == 'HTG' ? 'selected' : '' }} value="HTG"> Haitian Gourde </option>
                        <option {{ config('stripe.currency') == 'HUF' ? 'selected' : '' }} value="HUF"> Hungarian Forint </option>
                        <option {{ config('stripe.currency') == 'IDR' ? 'selected' : '' }} value="IDR"> Indonesian Rupiah </option>
                        <option {{ config('stripe.currency') == 'ILS' ? 'selected' : '' }} value="ILS"> Israeli New Shekel </option>
                        <option {{ config('stripe.currency') == 'ISK' ? 'selected' : '' }} value="ISK"> Icelandic Króna </option>
                        <option {{ config('stripe.currency') == 'JMD' ? 'selected' : '' }} value="JMD"> Jamaican Dollar </option>
                        <option {{ config('stripe.currency') == 'JPY' ? 'selected' : '' }} value="JPY"> Japanese Yen </option>
                        <option {{ config('stripe.currency') == 'KES' ? 'selected' : '' }} value="KES"> Kenyan Shilling </option>
                        <option {{ config('stripe.currency') == 'KGS' ? 'selected' : '' }} value="KGS"> Kyrgystani Som </option>
                        <option {{ config('stripe.currency') == 'KHR' ? 'selected' : '' }} value="KHR"> Cambodian riel </option>
                        <option {{ config('stripe.currency') == 'KMF' ? 'selected' : '' }} value="KMF"> Comorian franc </option>
                        <option {{ config('stripe.currency') == 'KRW' ? 'selected' : '' }} value="KRW"> South Korean won </option>
                        <option {{ config('stripe.currency') == 'KYD' ? 'selected' : '' }} value="KYD"> Cayman Islands Dollar </option>
                        <option {{ config('stripe.currency') == 'KZT' ? 'selected' : '' }} value="KZT"> Kazakhstani Tenge </option>
                        <option {{ config('stripe.currency') == 'LAK' ? 'selected' : '' }} value="LAK"> Laotian Kip </option>
                        <option {{ config('stripe.currency') == 'LBP' ? 'selected' : '' }} value="LBP"> Lebanese pound </option>
                        <option {{ config('stripe.currency') == 'LKR' ? 'selected' : '' }} value="LKR"> Sri Lankan Rupee </option>
                        <option {{ config('stripe.currency') == 'LRD' ? 'selected' : '' }} value="LRD"> Liberian Dollar </option>
                        <option {{ config('stripe.currency') == 'LSL' ? 'selected' : '' }} value="LSL"> Lesotho loti </option>
                        <option {{ config('stripe.currency') == 'MAD' ? 'selected' : '' }} value="MAD"> Moroccan Dirham </option>
                        <option {{ config('stripe.currency') == 'MDL' ? 'selected' : '' }} value="MDL"> Moldovan Leu </option>
                        <option {{ config('stripe.currency') == 'MGA' ? 'selected' : '' }} value="MGA"> Malagasy Ariary </option>
                        <option {{ config('stripe.currency') == 'MKD' ? 'selected' : '' }} value="MKD"> Macedonian Denar </option>
                        <option {{ config('stripe.currency') == 'MMK' ? 'selected' : '' }} value="MMK"> Myanmar Kyat </option>
                        <option {{ config('stripe.currency') == 'MNT' ? 'selected' : '' }} value="MNT"> Mongolian Tugrik </option>
                        <option {{ config('stripe.currency') == 'MOP' ? 'selected' : '' }} value="MOP"> Macanese Pataca </option>
                        <option {{ config('stripe.currency') == 'MRO' ? 'selected' : '' }} value="MRO"> Mauritanian Ouguiya </option>
                        <option {{ config('stripe.currency') == 'MUR' ? 'selected' : '' }} value="MUR"> Mauritian Rupee</option>
                        <option {{ config('stripe.currency') == 'MVR' ? 'selected' : '' }} value="MVR"> Maldivian Rufiyaa </option>
                        <option {{ config('stripe.currency') == 'MWK' ? 'selected' : '' }} value="MWK"> Malawian Kwacha </option>
                        <option {{ config('stripe.currency') == 'MXN' ? 'selected' : '' }} value="MXN"> Mexican Peso </option>
                        <option {{ config('stripe.currency') == 'MYR' ? 'selected' : '' }} value="MYR"> Malaysian Ringgit </option>
                        <option {{ config('stripe.currency') == 'MZN' ? 'selected' : '' }} value="MZN"> Mozambican metical </option>
                        <option {{ config('stripe.currency') == 'NAD' ? 'selected' : '' }} value="NAD"> Namibian dollar </option>
                        <option {{ config('stripe.currency') == 'NGN' ? 'selected' : '' }} value="NGN"> Nigerian Naira </option>
                        <option {{ config('stripe.currency') == 'NIO' ? 'selected' : '' }} value="NIO"> Nicaraguan Córdoba </option>
                        <option {{ config('stripe.currency') == 'NOK' ? 'selected' : '' }} value="NOK"> Norwegian Krone </option>
                        <option {{ config('stripe.currency') == 'NPR' ? 'selected' : '' }} value="NPR"> Nepalese Rupee </option>
                        <option {{ config('stripe.currency') == 'NZD' ? 'selected' : '' }} value="NZD"> New Zealand Dollar </option>
                        <option {{ config('stripe.currency') == 'PAB' ? 'selected' : '' }} value="PAB"> Panamanian Balboa </option>
                        <option {{ config('stripe.currency') == 'PEN' ? 'selected' : '' }} value="PEN"> Sol </option>
                        <option {{ config('stripe.currency') == 'PGK' ? 'selected' : '' }} value="PGK"> Papua New Guinean Kina </option>
                        <option {{ config('stripe.currency') == 'PHP' ? 'selected' : '' }} value="PHP"> Philippine peso </option>
                        <option {{ config('stripe.currency') == 'PKR' ? 'selected' : '' }} value="PKR"> Pakistani Rupee </option>
                        <option {{ config('stripe.currency') == 'PLN' ? 'selected' : '' }} value="PLN"> Poland złoty </option>
                        <option {{ config('stripe.currency') == 'PYG' ? 'selected' : '' }} value="PYG"> Paraguayan Guarani </option>
                        <option {{ config('stripe.currency') == 'QAR' ? 'selected' : '' }} value="QAR"> Qatari Rial </option>
                        <option {{ config('stripe.currency') == 'RON' ? 'selected' : '' }} value="RON"> Romanian Leu </option>
                        <option {{ config('stripe.currency') == 'RSD' ? 'selected' : '' }} value="RSD"> Serbian Dinar </option>
                        <option {{ config('stripe.currency') == 'RUB' ? 'selected' : '' }} value="RUB"> Russian Ruble </option>
                        <option {{ config('stripe.currency') == 'RWF' ? 'selected' : '' }} value="RWF"> Rwandan franc </option>
                        <option {{ config('stripe.currency') == 'SAR' ? 'selected' : '' }} value="SAR"> Saudi Riyal </option>
                        <option {{ config('stripe.currency') == 'SBD' ? 'selected' : '' }} value="SBD"> Solomon Islands Dollar </option>
                        <option {{ config('stripe.currency') == 'SCR' ? 'selected' : '' }} value="SCR"> Seychellois Rupee </option>
                        <option {{ config('stripe.currency') == 'SEK' ? 'selected' : '' }} value="SEK"> Swedish Krona </option>
                        <option {{ config('stripe.currency') == 'SGD' ? 'selected' : '' }} value="SGD"> Singapore Dollar </option>
                        <option {{ config('stripe.currency') == 'SHP' ? 'selected' : '' }} value="SHP"> Saint Helenian Pound </option>
                        <option {{ config('stripe.currency') == 'SLL' ? 'selected' : '' }} value="SLL"> Sierra Leonean Leone </option>
                        <option {{ config('stripe.currency') == 'SOS' ? 'selected' : '' }} value="SOS"> Somali Shilling </option>
                        <option {{ config('stripe.currency') == 'SRD' ? 'selected' : '' }} value="SRD"> Surinamese Dollar </option>
                        <option {{ config('stripe.currency') == 'STD' ? 'selected' : '' }} value="STD"> Sao Tome Dobra </option>
                        <option {{ config('stripe.currency') == 'SZL' ? 'selected' : '' }} value="SZL"> Swazi Lilangeni </option>
                        <option {{ config('stripe.currency') == 'THB' ? 'selected' : '' }} value="THB"> Thai Baht </option>
                        <option {{ config('stripe.currency') == 'TJS' ? 'selected' : '' }} value="TJS"> Tajikistani Somoni </option>
                        <option {{ config('stripe.currency') == 'TOP' ? 'selected' : '' }} value="TOP"> Tongan Paʻanga </option>
                        <option {{ config('stripe.currency') == 'TRY' ? 'selected' : '' }} value="TRY"> Turkish lira </option>
                        <option {{ config('stripe.currency') == 'TTD' ? 'selected' : '' }} value="TTD"> Trinidad &amp; Tobago Dollar </option>
                        <option {{ config('stripe.currency') == 'TWD' ? 'selected' : '' }} value="TWD"> New Taiwan dollar </option>
                        <option {{ config('stripe.currency') == 'TZS' ? 'selected' : '' }} value="TZS"> Tanzanian Shilling </option>
                        <option {{ config('stripe.currency') == 'UAH' ? 'selected' : '' }} value="UAH"> Ukrainian hryvnia </option>
                        <option {{ config('stripe.currency') == 'UGX' ? 'selected' : '' }} value="UGX"> Ugandan Shilling </option>
                        <option {{ config('stripe.currency') == 'UYU' ? 'selected' : '' }} value="UYU"> Uruguayan Peso </option>
                        <option {{ config('stripe.currency') == 'UZS' ? 'selected' : '' }} value="UZS"> Uzbekistani Som </option>
                        <option {{ config('stripe.currency') == 'VND' ? 'selected' : '' }} value="VND"> Vietnamese dong </option>
                        <option {{ config('stripe.currency') == 'VUV' ? 'selected' : '' }} value="VUV"> Vanuatu Vatu </option>
                        <option {{ config('stripe.currency') == 'WST' ? 'selected' : '' }} value="WST"> Samoa Tala</option>
                        <option {{ config('stripe.currency') == 'XAF' ? 'selected' : '' }} value="XAF"> Central African CFA franc </option>
                        <option {{ config('stripe.currency') == 'XCD' ? 'selected' : '' }} value="XCD"> East Caribbean Dollar </option>
                        <option {{ config('stripe.currency') == 'XOF' ? 'selected' : '' }} value="XOF"> West African CFA franc </option>
                        <option {{ config('stripe.currency') == 'XPF' ? 'selected' : '' }} value="XPF"> CFP Franc </option>
                        <option {{ config('stripe.currency') == 'YER' ? 'selected' : '' }} value="YER"> Yemeni Rial </option>
                        <option {{ config('stripe.currency') == 'ZAR' ? 'selected' : '' }} value="ZAR"> South African Rand </option>
                        <option {{ config('stripe.currency') == 'ZMW' ? 'selected' : '' }} value="ZMW"> Zambian Kwacha </option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label">{{ __('system.payment_setting.publish_key') }}</label>
                    <input value="{{ config('stripe.stripe_publish_key') }}" type="text" name="stripe_publish_key" required class="form-control"
                        type="text" name="stripe_publish_key" required class="form-control"
                        placeholder="{{ trans('system.payment_setting.publish_key') }}">
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label">{{ trans('system.payment_setting.secret_key') }}</label>
                    <input value="{{ config('stripe.stripe_secret_key') }}" type="text"
                        name="stripe_secret_key" required class="form-control"
                        placeholder="{{ trans('system.payment_setting.secret_key') }}">
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label"
                        for="stripe_mode">{{ trans('system.payment_setting.gateway_mode') }}</label>
                    <select id="stripe_mode" name="stripe_mode" required class="form-control">
                        <option {{ config('stripe.mode') == 'test' ? 'selected' : '' }} value="test">
                            {{ trans('system.payment_setting.test') }}
                        </option>
                        <option {{ config('stripe.mode') == 'live' ? 'selected' : '' }} value="live">
                            {{ trans('system.payment_setting.production') }}
                        </option>
                    </select>
                </div>
            </div>
            <input type="hidden" name="hidden_stripe_mode" value="{{config('stripe.mode')}}" />
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label" for="stripe_status">{{ trans('system.payment_setting.status') }}</label>
                    <select id="stripe_status" name="stripe_status" required class="form-control">
                        <option {{ config('stripe.stripe_status') == 'enable' ? 'selected' : '' }} value="enable">
                            {{ trans('system.payment_setting.enable') }}
                        </option>
                        <option {{ config('stripe.stripe_status') == 'disable' ? 'selected' : '' }} value="disable">
                            {{ trans('system.payment_setting.disable') }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
