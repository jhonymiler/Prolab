<?php

// Code within app\Helpers\Helper.php

namespace App\Helpers;

use Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use NumberFormatter;

class Helper
{
    public static function applClasses()
    {
        if (Auth::check()) {
            $userId = Auth::user()->id;
            $data = config($userId . '.custom');
        } else {
            $data = [];
        }

        // default data array
        $DefaultData = [
            'mainLayoutType' => 'vertical',
            'theme' => 'semi-dark',
            'sidebarCollapsed' => true,
            'navbarColor' => '',
            'horizontalMenuType' => 'floating',
            'verticalMenuNavbarType' => 'floating',
            'footerType' => 'static', //footer
            'layoutWidth' => 'full',
            'showMenu' => true,
            'bodyClass' => '',
            'pageClass' => '',
            'pageHeader' => true,
            'contentLayout' => 'default',
            'blankPage' => false,
            'defaultLanguage' => 'pt-BR',
            'direction' => env('MIX_CONTENT_DIRECTION', 'ltr'),
        ];

        // se alguma chave estiver faltando na matriz do arquivo custom.php, ela será mesclada e definirá um valor padrão da matriz dataDefault e armazenará na variável de dados
        if (is_array($DefaultData) && is_array($data)) {
            $data = array_merge($DefaultData, $data);
        } else {
            $data = $DefaultData;
        }

        // Todas as opções disponíveis no modelo
        $allOptions = [
            'mainLayoutType' => ['vertical', 'horizontal'],
            'theme' => ['light' => 'light', 'dark' => 'dark-layout', 'bordered' => 'bordered-layout', 'semi-dark' => 'semi-dark-layout'],
            'sidebarCollapsed' => [true, false],
            'showMenu' => [true, false],
            'layoutWidth' => ['full', 'boxed'],
            'navbarColor' => ['bg-primary', 'bg-info', 'bg-warning', 'bg-success', 'bg-danger', 'bg-dark'],
            'horizontalMenuType' => ['floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky'],
            'horizontalMenuClass' => ['static' => '', 'sticky' => 'fixed-top', 'floating' => 'floating-nav'],
            'verticalMenuNavbarType' => ['floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky', 'hidden' => 'navbar-hidden'],
            'navbarClass' => ['floating' => 'floating-nav', 'static' => 'navbar-static-top', 'sticky' => 'fixed-top', 'hidden' => 'd-none'],
            'footerType' => ['static' => 'footer-static', 'sticky' => 'footer-fixed', 'hidden' => 'footer-hidden'],
            'pageHeader' => [true, false],
            'contentLayout' => ['default', 'content-left-sidebar', 'content-right-sidebar', 'content-detached-left-sidebar', 'content-detached-right-sidebar'],
            'blankPage' => [false, true],
            'sidebarPositionClass' => ['content-left-sidebar' => 'sidebar-left', 'content-right-sidebar' => 'sidebar-right', 'content-detached-left-sidebar' => 'sidebar-detached sidebar-left', 'content-detached-right-sidebar' => 'sidebar-detached sidebar-right', 'default' => 'default-sidebar-position'],
            'contentsidebarClass' => ['content-left-sidebar' => 'content-right', 'content-right-sidebar' => 'content-left', 'content-detached-left-sidebar' => 'content-detached content-right', 'content-detached-right-sidebar' => 'content-detached content-left', 'default' => 'default-sidebar'],
            'defaultLanguage' => ['en' => 'en', 'fr' => 'fr', 'de' => 'de', 'pt' => 'pt', 'pt-BR' => 'pt-BR'],
            'direction' => ['ltr', 'rtl'],
        ];

        //se o valor mainLayoutType estiver vazio ou não corresponder às opções padrão no arquivo de configuração custom.php, defina um valor padrão
        foreach ($allOptions as $key => $value) {
            if (array_key_exists($key, $DefaultData)) {
                if (gettype($DefaultData[$key]) === gettype($data[$key])) {
                    // chave de dados deve ser string
                    if (is_string($data[$key])) {
                        // chave de dados deve ser vazia
                        if (isset($data[$key]) && $data[$key] !== null) {
                            // a chave de dados não deve existir dentro da submatriz da matriz allOptions
                            if (!array_key_exists($data[$key], $value)) {
                                // certifique-se de que o valor passado deve corresponder a qualquer um dos valores da matriz allOptions
                                $result = array_search($data[$key], $value, 'strict');
                                if (empty($result) && $result !== 0) {
                                    $data[$key] = $DefaultData[$key];
                                }
                            }
                        } else {
                            // se a chave de dados não estiver definida ou
                            $data[$key] = $DefaultData[$key];
                        }
                    }
                } else {
                    $data[$key] = $DefaultData[$key];
                }
            }
        }

        //layout classes
        $layoutClasses = [
            'theme' => $data['theme'],
            'layoutTheme' => $allOptions['theme'][$data['theme']],
            'sidebarCollapsed' => $data['sidebarCollapsed'],
            'showMenu' => $data['showMenu'],
            'layoutWidth' => $data['layoutWidth'],
            'verticalMenuNavbarType' => $allOptions['verticalMenuNavbarType'][$data['verticalMenuNavbarType']],
            'navbarClass' => $allOptions['navbarClass'][$data['verticalMenuNavbarType']],
            'navbarColor' => $data['navbarColor'],
            'horizontalMenuType' => $allOptions['horizontalMenuType'][$data['horizontalMenuType']],
            'horizontalMenuClass' => $allOptions['horizontalMenuClass'][$data['horizontalMenuType']],
            'footerType' => $allOptions['footerType'][$data['footerType']],
            'sidebarClass' => '',
            'bodyClass' => $data['bodyClass'],
            'pageClass' => $data['pageClass'],
            'pageHeader' => $data['pageHeader'],
            'blankPage' => $data['blankPage'],
            'blankPageClass' => '',
            'contentLayout' => $data['contentLayout'],
            'sidebarPositionClass' => $allOptions['sidebarPositionClass'][$data['contentLayout']],
            'contentsidebarClass' => $allOptions['contentsidebarClass'][$data['contentLayout']],
            'mainLayoutType' => $data['mainLayoutType'],
            'defaultLanguage' => $allOptions['defaultLanguage'][$data['defaultLanguage']],
            'direction' => $data['direction'],
        ];
        // set default language if session hasn't locale value the set default language
        if (!session()->has('locale')) {
            app()->setLocale($layoutClasses['defaultLanguage']);
        }

        // sidebar Collapsed
        if ($layoutClasses['sidebarCollapsed'] == 'true') {
            $layoutClasses['sidebarClass'] = 'menu-collapsed';
        }

        // blank page class
        if ($layoutClasses['blankPage'] == 'true') {
            $layoutClasses['blankPageClass'] = 'blank-page';
        }

        return $layoutClasses;
    }

    public static function updatePageConfig($pageConfigs = [])
    {
        $data = [];

        if (Auth::check()) {
            $userId = Auth::user()->id;
        } else {
            $userId = 0;
        }


        if (count($pageConfigs) > 0) {
            foreach ($pageConfigs as $config => $val) {
                $data[$config] = $val;
            }
        }
        if (Cache::has($userId . '.custom')) {
            foreach (Cache::get($userId . '.custom') as $config => $val) {
                $data[$config] = $val;
            }
        }
        Config::set($userId . '.custom', $data);
    }

    public static function Money($valor, $formato = 'BRL')
    {
        $valor = round($valor, 2);
        $money = new Money($valor * 100, new Currency($formato));
        $currencies = new ISOCurrencies();

        switch ($formato) {
            case 'EUR':
                $numberFormatter = new \NumberFormatter('nl_NL', \NumberFormatter::CURRENCY);
                break;

            case 'USD':
                $numberFormatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
                break;

            default:
                $numberFormatter = new \NumberFormatter('pt_BR', \NumberFormatter::CURRENCY);
                break;
        }

        //
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);
        return  $moneyFormatter->format($money);
    }

    public static function Medida($unidade)
    {
        $medidas = [
            'Un' => 'Unidade',
            'pç' => 'Peça',
            'Kit' => 'Kit',
            //Volume
            'ml' => 'Mililitro',
            'L' => 'Litro',
            'Gl' => 'Galão',
            'Ds' => 'Dose',
            'm³'  => 'Metro Cúbico',
            // Peso
            'g' => 'Grama',
            'Kg' => 'Quilo',
            'Ton' => 'Tonelada',
            // Comprimento
            'mm' => 'Milímetro',
            'cm' => 'Centímetro',
            'm' => 'Metro',
            'Km' => 'Quilômetro',
            // Energia
            'w' => 'Watts',
            'Kw' => 'Quilowatts',
            // Tempo
            'Hr' => 'Hora'
        ];
        return $medidas[strtolower($unidade)] ? $medidas[strtolower($unidade)] : false;
    }

    public static function convertDecimal($valor)
    {
        $num = preg_replace('/[^0-9\.\,]/', '', $valor);
        $fmt = new NumberFormatter('de_DE', NumberFormatter::DECIMAL);
        return $fmt->parse($num);
    }
}
