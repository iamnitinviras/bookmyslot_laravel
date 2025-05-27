<div class="card">
    <input name="gateway_type" type="hidden" value="razorpay" />
    <div class="card-header">{{ __('system.payment_setting.razorpay_payments') }}</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <label class="form-label">{{trans('system.payment_setting.select_app_currency')}}</label>
                    <select name="razorpay_currency_code" id="razorpay_currency_code" required="required"
                        class="form-control form-select">
                        <option value="">{{trans('system.payment_setting.select_app_currency')}}</option>
                        <option {{ config('razorpay.currency') == 'INR' ? 'selected' : '' }} value="INR"> Indian rupee
                        </option>
                        <option {{ config('razorpay.currency') == 'USD' ? 'selected' : '' }} value="USD"> United States
                            dollar </option>
                        <option {{ config('razorpay.currency') == 'AED' ? 'selected' : '' }} value="AED"> United Arab
                            Emirates Dirham </option>
                        <option {{ config('razorpay.currency') == 'ALL' ? 'selected' : '' }} value="ALL"> Albanian Lek
                        </option>
                        <option {{ config('razorpay.currency') == 'AMD' ? 'selected' : '' }} value="AMD"> Armenian Dram
                        </option>
                        <option {{ config('razorpay.currency') == 'ARS' ? 'selected' : '' }} value="ARS"> Argentine Peso
                        </option>
                        <option {{ config('razorpay.currency') == 'AUD' ? 'selected' : '' }} value="AUD"> Australian
                            Dollar
                        </option>
                        <option {{ config('razorpay.currency') == 'AWG' ? 'selected' : '' }} value="AWG"> Aruban Florin
                        </option>
                        <option {{ config('razorpay.currency') == 'AZN' ? 'selected' : '' }} value="AZN"> Azerbaijani
                            Manat
                        </option>
                        <option {{ config('razorpay.currency') == 'BAM' ? 'selected' : '' }} value="BAM">
                            Bosnia-Herzegovina
                            Convertible Mark </option>
                        <option {{ config('razorpay.currency') == 'BBD' ? 'selected' : '' }} value="BBD"> Bajan dollar
                        </option>
                        <option {{ config('razorpay.currency') == 'BDT' ? 'selected' : '' }} value="BDT"> Bangladeshi Taka
                        </option>
                        <option {{ config('razorpay.currency') == 'BGN' ? 'selected' : '' }} value="BGN"> Bulgarian Lev
                        </option>
                        <option {{ config('razorpay.currency') == 'BIF' ? 'selected' : '' }} value="BIF"> Burundian Franc
                        </option>
                        <option {{ config('razorpay.currency') == 'BMD' ? 'selected' : '' }} value="BMD"> Bermudan Dollar
                        </option>
                        <option {{ config('razorpay.currency') == 'BND' ? 'selected' : '' }} value="BND"> Brunei Dollar
                        </option>
                        <option {{ config('razorpay.currency') == 'BOB' ? 'selected' : '' }} value="BOB"> Bolivian
                            Boliviano
                        </option>
                        <option {{ config('razorpay.currency') == 'BRL' ? 'selected' : '' }} value="BRL"> Brazilian Real
                        </option>
                        <option {{ config('razorpay.currency') == 'BSD' ? 'selected' : '' }} value="BSD"> Bahamian Dollar
                        </option>
                        <option {{ config('razorpay.currency') == 'BWP' ? 'selected' : '' }} value="BWP"> Botswanan Pula
                        </option>
                        <option {{ config('razorpay.currency') == 'BZD' ? 'selected' : '' }} value="BZD"> Belize Dollar
                        </option>
                        <option {{ config('razorpay.currency') == 'CAD' ? 'selected' : '' }} value="CAD"> Canadian Dollar
                        </option>

                        <option {{ config('razorpay.currency') == 'CHF' ? 'selected' : '' }} value="CHF"> Swiss Franc
                        </option>
                        <option {{ config('razorpay.currency') == 'CLP' ? 'selected' : '' }} value="CLP"> Chilean Peso
                        </option>
                        <option {{ config('razorpay.currency') == 'CNY' ? 'selected' : '' }} value="CNY"> Chinese Yuan
                        </option>
                        <option {{ config('razorpay.currency') == 'COP' ? 'selected' : '' }} value="COP"> Colombian Peso
                        </option>
                        <option {{ config('razorpay.currency') == 'CRC' ? 'selected' : '' }} value="CRC"> Costa Rican
                            Colón
                        </option>
                        <option {{ config('razorpay.currency') == 'CVE' ? 'selected' : '' }} value="CVE"> Cape Verdean
                            Escudo </option>
                        <option {{ config('razorpay.currency') == 'CZK' ? 'selected' : '' }} value="CZK"> Czech Koruna
                        </option>
                        <option {{ config('razorpay.currency') == 'DJF' ? 'selected' : '' }} value="DJF"> Djiboutian Franc
                        </option>
                        <option {{ config('razorpay.currency') == 'DKK' ? 'selected' : '' }} value="DKK"> Danish Krone
                        </option>
                        <option {{ config('razorpay.currency') == 'DOP' ? 'selected' : '' }} value="DOP"> Dominican Peso
                        </option>
                        <option {{ config('razorpay.currency') == 'DZD' ? 'selected' : '' }} value="DZD"> Algerian Dinar
                        </option>
                        <option {{ config('razorpay.currency') == 'EGP' ? 'selected' : '' }} value="EGP"> Egyptian Pound
                        </option>
                        <option {{ config('razorpay.currency') == 'ETB' ? 'selected' : '' }} value="ETB"> Ethiopian Birr
                        </option>
                        <option {{ config('razorpay.currency') == 'EUR' ? 'selected' : '' }} value="EUR"> Euro </option>
                        <option {{ config('razorpay.currency') == 'FJD' ? 'selected' : '' }} value="FJD"> Fijian Dollar
                        </option>

                        <option {{ config('razorpay.currency') == 'GBP' ? 'selected' : '' }} value="GBP"> Pound sterling
                        </option>

                        <option {{ config('razorpay.currency') == 'GIP' ? 'selected' : '' }} value="GIP"> Gibraltar Pound
                        </option>
                        <option {{ config('razorpay.currency') == 'GMD' ? 'selected' : '' }} value="GMD"> Gambian dalasi
                        </option>
                        <option {{ config('razorpay.currency') == 'GNF' ? 'selected' : '' }} value="GNF"> Guinean Franc
                        </option>
                        <option {{ config('razorpay.currency') == 'GTQ' ? 'selected' : '' }} value="GTQ"> Guatemalan
                            Quetzal
                        </option>
                        <option {{ config('razorpay.currency') == 'GYD' ? 'selected' : '' }} value="GYD"> Guyanaese Dollar
                        </option>
                        <option {{ config('razorpay.currency') == 'HKD' ? 'selected' : '' }} value="HKD"> Hong Kong Dollar
                        </option>
                        <option {{ config('razorpay.currency') == 'HNL' ? 'selected' : '' }} value="HNL"> Honduran Lempira
                        </option>
                        <option {{ config('razorpay.currency') == 'HRK' ? 'selected' : '' }} value="HRK"> Croatian Kuna
                        </option>
                        <option {{ config('razorpay.currency') == 'HTG' ? 'selected' : '' }} value="HTG"> Haitian Gourde
                        </option>
                        <option {{ config('razorpay.currency') == 'HUF' ? 'selected' : '' }} value="HUF"> Hungarian Forint
                        </option>
                        <option {{ config('razorpay.currency') == 'IDR' ? 'selected' : '' }} value="IDR"> Indonesian
                            Rupiah
                        </option>
                        <option {{ config('razorpay.currency') == 'ILS' ? 'selected' : '' }} value="ILS"> Israeli New
                            Shekel
                        </option>
                        <option {{ config('razorpay.currency') == 'ISK' ? 'selected' : '' }} value="ISK"> Icelandic Króna
                        </option>
                        <option {{ config('razorpay.currency') == 'JMD' ? 'selected' : '' }} value="JMD"> Jamaican Dollar
                        </option>
                        <option {{ config('razorpay.currency') == 'JPY' ? 'selected' : '' }} value="JPY"> Japanese Yen
                        </option>
                        <option {{ config('razorpay.currency') == 'KES' ? 'selected' : '' }} value="KES"> Kenyan Shilling
                        </option>
                        <option {{ config('razorpay.currency') == 'KGS' ? 'selected' : '' }} value="KGS"> Kyrgystani Som
                        </option>
                        <option {{ config('razorpay.currency') == 'KHR' ? 'selected' : '' }} value="KHR"> Cambodian riel
                        </option>
                        <option {{ config('razorpay.currency') == 'KMF' ? 'selected' : '' }} value="KMF"> Comorian franc
                        </option>
                        <option {{ config('razorpay.currency') == 'KRW' ? 'selected' : '' }} value="KRW"> South Korean won
                        </option>
                        <option {{ config('razorpay.currency') == 'KYD' ? 'selected' : '' }} value="KYD"> Cayman Islands
                            Dollar </option>
                        <option {{ config('razorpay.currency') == 'KZT' ? 'selected' : '' }} value="KZT"> Kazakhstani
                            Tenge
                        </option>
                        <option {{ config('razorpay.currency') == 'LAK' ? 'selected' : '' }} value="LAK"> Laotian Kip
                        </option>

                        <option {{ config('razorpay.currency') == 'LKR' ? 'selected' : '' }} value="LKR"> Sri Lankan Rupee
                        </option>
                        <option {{ config('razorpay.currency') == 'LRD' ? 'selected' : '' }} value="LRD"> Liberian Dollar
                        </option>
                        <option {{ config('razorpay.currency') == 'LSL' ? 'selected' : '' }} value="LSL"> Lesotho loti
                        </option>
                        <option {{ config('razorpay.currency') == 'MAD' ? 'selected' : '' }} value="MAD"> Moroccan Dirham
                        </option>
                        <option {{ config('razorpay.currency') == 'MDL' ? 'selected' : '' }} value="MDL"> Moldovan Leu
                        </option>
                        <option {{ config('razorpay.currency') == 'MGA' ? 'selected' : '' }} value="MGA"> Malagasy Ariary
                        </option>
                        <option {{ config('razorpay.currency') == 'MKD' ? 'selected' : '' }} value="MKD"> Macedonian Denar
                        </option>
                        <option {{ config('razorpay.currency') == 'MMK' ? 'selected' : '' }} value="MMK"> Myanmar Kyat
                        </option>
                        <option {{ config('razorpay.currency') == 'MNT' ? 'selected' : '' }} value="MNT"> Mongolian Tugrik
                        </option>
                        <option {{ config('razorpay.currency') == 'MOP' ? 'selected' : '' }} value="MOP"> Macanese Pataca
                        </option>

                        <option {{ config('razorpay.currency') == 'MUR' ? 'selected' : '' }} value="MUR"> Mauritian Rupee
                        </option>
                        <option {{ config('razorpay.currency') == 'MVR' ? 'selected' : '' }} value="MVR"> Maldivian
                            Rufiyaa
                        </option>
                        <option {{ config('razorpay.currency') == 'MWK' ? 'selected' : '' }} value="MWK"> Malawian Kwacha
                        </option>
                        <option {{ config('razorpay.currency') == 'MXN' ? 'selected' : '' }} value="MXN"> Mexican Peso
                        </option>
                        <option {{ config('razorpay.currency') == 'MYR' ? 'selected' : '' }} value="MYR"> Malaysian
                            Ringgit
                        </option>
                        <option {{ config('razorpay.currency') == 'MZN' ? 'selected' : '' }} value="MZN"> Mozambican
                            metical
                        </option>
                        <option {{ config('razorpay.currency') == 'NAD' ? 'selected' : '' }} value="NAD"> Namibian dollar
                        </option>
                        <option {{ config('razorpay.currency') == 'NGN' ? 'selected' : '' }} value="NGN"> Nigerian Naira
                        </option>
                        <option {{ config('razorpay.currency') == 'NIO' ? 'selected' : '' }} value="NIO"> Nicaraguan
                            Córdoba
                        </option>
                        <option {{ config('razorpay.currency') == 'NOK' ? 'selected' : '' }} value="NOK"> Norwegian Krone
                        </option>
                        <option {{ config('razorpay.currency') == 'NPR' ? 'selected' : '' }} value="NPR"> Nepalese Rupee
                        </option>
                        <option {{ config('razorpay.currency') == 'NZD' ? 'selected' : '' }} value="NZD"> New Zealand
                            Dollar
                        </option>

                        <option {{ config('razorpay.currency') == 'PEN' ? 'selected' : '' }} value="PEN"> Peruvian sol
                        </option>
                        <option {{ config('razorpay.currency') == 'PGK' ? 'selected' : '' }} value="PGK"> Papua New
                            Guinean
                            Kina </option>
                        <option {{ config('razorpay.currency') == 'PHP' ? 'selected' : '' }} value="PHP"> Philippine peso
                        </option>
                        <option {{ config('razorpay.currency') == 'PKR' ? 'selected' : '' }} value="PKR"> Pakistani Rupee
                        </option>
                        <option {{ config('razorpay.currency') == 'PLN' ? 'selected' : '' }} value="PLN"> Poland złoty
                        </option>
                        <option {{ config('razorpay.currency') == 'PYG' ? 'selected' : '' }} value="PYG"> Paraguayan
                            Guarani
                        </option>
                        <option {{ config('razorpay.currency') == 'QAR' ? 'selected' : '' }} value="QAR"> Qatari Rial
                        </option>
                        <option {{ config('razorpay.currency') == 'RON' ? 'selected' : '' }} value="RON"> Romanian Leu
                        </option>
                        <option {{ config('razorpay.currency') == 'RSD' ? 'selected' : '' }} value="RSD"> Serbian Dinar
                        </option>
                        <option {{ config('razorpay.currency') == 'RUB' ? 'selected' : '' }} value="RUB"> Russian Ruble
                        </option>
                        <option {{ config('razorpay.currency') == 'RWF' ? 'selected' : '' }} value="RWF"> Rwandan franc
                        </option>
                        <option {{ config('razorpay.currency') == 'SAR' ? 'selected' : '' }} value="SAR"> Saudi Riyal
                        </option>

                        <option {{ config('razorpay.currency') == 'SCR' ? 'selected' : '' }} value="SCR"> Seychellois
                            Rupee
                        </option>
                        <option {{ config('razorpay.currency') == 'SEK' ? 'selected' : '' }} value="SEK"> Swedish Krona
                        </option>
                        <option {{ config('razorpay.currency') == 'SGD' ? 'selected' : '' }} value="SGD"> Singapore Dollar
                        </option>

                        <option {{ config('razorpay.currency') == 'SLL' ? 'selected' : '' }} value="SLL"> Sierra Leonean
                            Leone </option>
                        <option {{ config('razorpay.currency') == 'SOS' ? 'selected' : '' }} value="SOS"> Somali Shilling
                        </option>


                        <option {{ config('razorpay.currency') == 'SZL' ? 'selected' : '' }} value="SZL"> Swazi Lilangeni
                        </option>
                        <option {{ config('razorpay.currency') == 'THB' ? 'selected' : '' }} value="THB"> Thai Baht
                        </option>


                        <option {{ config('razorpay.currency') == 'TRY' ? 'selected' : '' }} value="TRY"> Turkish lira
                        </option>
                        <option {{ config('razorpay.currency') == 'TTD' ? 'selected' : '' }} value="TTD"> Trinidad &amp;
                            Tobago Dollar </option>
                        <option {{ config('razorpay.currency') == 'TWD' ? 'selected' : '' }} value="TWD"> New Taiwan
                            dollar
                        </option>
                        <option {{ config('razorpay.currency') == 'TZS' ? 'selected' : '' }} value="TZS"> Tanzanian
                            Shilling
                        </option>
                        <option {{ config('razorpay.currency') == 'UAH' ? 'selected' : '' }} value="UAH"> Ukrainian
                            hryvnia
                        </option>
                        <option {{ config('razorpay.currency') == 'UGX' ? 'selected' : '' }} value="UGX"> Ugandan Shilling
                        </option>
                        <option {{ config('razorpay.currency') == 'UYU' ? 'selected' : '' }} value="UYU"> Uruguayan Peso
                        </option>
                        <option {{ config('razorpay.currency') == 'UZS' ? 'selected' : '' }} value="UZS"> Uzbekistani Som
                        </option>
                        <option {{ config('razorpay.currency') == 'VND' ? 'selected' : '' }} value="VND"> Vietnamese dong
                        </option>
                        <option {{ config('razorpay.currency') == 'VUV' ? 'selected' : '' }} value="VUV"> Vanuatu Vatu
                        </option>

                        <option {{ config('razorpay.currency') == 'XAF' ? 'selected' : '' }} value="XAF"> Central African
                            CFA franc </option>
                        <option {{ config('razorpay.currency') == 'XCD' ? 'selected' : '' }} value="XCD"> East Caribbean
                            Dollar </option>
                        <option {{ config('razorpay.currency') == 'XOF' ? 'selected' : '' }} value="XOF"> West African CFA
                            franc </option>
                        <option {{ config('razorpay.currency') == 'XPF' ? 'selected' : '' }} value="XPF"> CFP Franc
                        </option>
                        <option {{ config('razorpay.currency') == 'YER' ? 'selected' : '' }} value="YER"> Yemeni Rial
                        </option>
                        <option {{ config('razorpay.currency') == 'ZAR' ? 'selected' : '' }} value="ZAR"> South African
                            Rand
                        </option>
                        <option {{ config('razorpay.currency') == 'ZMW' ? 'selected' : '' }} value="ZMW"> Zambian Kwacha
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <label class="form-label"
                        for="razorpay_mode">{{ trans('system.payment_setting.gateway_mode') }}</label>
                    <select id="razorpay_mode" name="razorpay_mode" required class="form-control">
                        <option {{ config('razorpay.mode') == 'test' ? 'selected' : '' }} value="test">
                            {{ trans('system.payment_setting.test') }}
                        </option>
                        <option {{ config('razorpay.mode') == 'live' ? 'selected' : '' }} value="live">
                            {{ trans('system.payment_setting.production') }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <label class="form-label" for="razorpay_status">{{ trans('system.payment_setting.status') }}</label>
                    <select id="razorpay_status" name="razorpay_status" required class="form-control">
                        <option {{ config('razorpay.status') == 'enable' ? 'selected' : '' }} value="enable">
                            {{ trans('system.payment_setting.enable') }}
                        </option>
                        <option {{ config('razorpay.status') == 'disable' ? 'selected' : '' }} value="disable">
                            {{ trans('system.payment_setting.disable') }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label">{{ __('system.payment_setting.razorpay_key_id') }}</label>
                    <input value="{{ config('razorpay.key_id') }}" type="text" name="razorpay_key_id" required
                        class="form-control" type="text" name="razorpay_key_id" required class="form-control"
                        placeholder="{{ trans('system.payment_setting.razorpay_key_id') }}">
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label">{{ trans('system.payment_setting.secret_key') }}</label>
                    <input value="{{ config('razorpay.secret') }}" type="text" name="razorpay_secret_key" required
                        class="form-control" placeholder="{{ trans('system.payment_setting.secret_key') }}">
                </div>
            </div>
        </div>
    </div>
</div>
