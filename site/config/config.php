<?php

function commaToDot($num) {
  $num = str_replace(",", ".", $num);
  return $num;
}

return [
    'url' => getenv('KIRBY_URL'),
  'languages' => true,

  'panel' => true,
  'panel' => [
      'install' => true,
    'css' => 'assets/build/css/panel.min.css'
  ],

  'updates' => [
    'plugins' => [
        'tfk/*'  => false
    ]
  ],

  'routes' => [
    [
      'pattern' => 'sitemap.xml',
      'action'  => function() {
        $pages = site()->pages()->index();

        // Fetch the pages to ignore
        $ignore = kirby()->option('sitemap.ignore', ['error', 's']);

        $content = snippet('sitemap', compact('pages', 'ignore'), true);

        // Return response with correct header type
        return new Kirby\Cms\Response($content, 'application/xml');
      }
    ],
    [
      'pattern' => 'sitemap',
      'action'  => function() {
        return go('sitemap.xml', 301);
      }
    ]
  ],

  'thumbs' => [
    'srcsets' => [
      'default' => [960, 1440, 2880],
      'half'    => [960, 1440],
      'thumb'   => [960]
    ]
  ],

  'hooks' => [
    'site.update:after' => function($newSite) {
      $css = '';

      if ($newSite->fontBody()->value() === 'custom' && $newSite->fontBodySelfHosted()->isNotEmpty()) {
        $css = $css . $newSite->fontBodySelfHosted();
      }

      if ($newSite->fontHeader()->value() === 'custom' && $newSite->fontHeaderSelfHosted()->isNotEmpty()) {
        $css = $css . $newSite->fontHeaderSelfHosted();
      }

      if ($newSite->kirby()->language() === $newSite->kirby()->defaultLanguage()) {
        if ($newSite->colorBackground()->isNotEmpty()) {
          $css = $css . 'body{background:#' . $newSite->colorBackground() . '}';
        } else {
          $css = $css . 'body{background:#fff}';
        }

        if ($newSite->colorBackgroundDark()->isNotEmpty()) {
          $css = $css . 'body.dark{background:#' . $newSite->colorBackgroundDark() . '}';
        }

        if ($newSite->fontBody()->value() === 'custom' && $newSite->fontBodyFamily()->isNotEmpty()) {
          $css = $css . 'body{font-family:' . $newSite->fontBodyFamily() . '}';
        } else {
          $css = $css . 'body{font-family:Helvetica, sans-serif}';
        }

        if ($newSite->fontHeader()->value() === 'custom' && $newSite->fontHeaderFamily()->isNotEmpty()) {
          $css = $css . 'main h1,main h2,main h3,main h4,main h5,main h6,.title-h1,.title-h2,.title-h3,.title-h4,.title-h5,.title-h6,.title-hero,.logo{font-family:' . $newSite->fontHeaderFamily() . '}';
        } elseif ($newSite->fontHeader()->value() === 'same' && $newSite->fontBodyFamily()->isNotEmpty()) {
          $css = $css . 'main h1,main h2,main h3,main h4,main h5,main h6,.title-h1,.title-h2,.title-h3,.title-h4,.title-h5,.title-h6,.title-hero,.logo{font-family:' . $newSite->fontBodyFamily() . '}';
        } else {
          $css = $css . 'main h1,main h2,main h3,main h4,main h5,main h6,.title-h1,.title-h2,.title-h3,.title-h4,.title-h5,.title-h6,.title-hero,.logo{font-family:Helvetica, sans-serif}';
        }

        $css = $css . 'main h1,.title-h1,.title-hero{font-size:' . $newSite->fontSizeH1()->value() . 'px;font-weight:' . $newSite->fontWeightH1()->value() . ';line-height:' . $newSite->lineHeightH1()->value() . 'px}';

        $css = $css . 'main h2,.title-h2{font-size:' . $newSite->fontSizeH2()->value() . 'px;font-weight:' . $newSite->fontWeightH2()->value() . ';line-height:' . $newSite->lineHeightH2()->value() . 'px}';

        $css = $css . 'main h3,.title-h3{font-size:' . $newSite->fontSizeH3()->value() . 'px;font-weight:' . $newSite->fontWeightH3()->value() . ';line-height:' . $newSite->lineHeightH3()->value() . 'px}';

        $css = $css . 'main h4,.title-h4{font-size:' . $newSite->fontSizeH4()->value() . 'px;font-weight:' . $newSite->fontWeightH4()->value() . ';line-height:' . $newSite->lineHeightH4()->value() . 'px}';

        $css = $css . 'main h5,.title-h5{font-size:' . $newSite->fontSizeH5()->value() . 'px;font-weight:' . $newSite->fontWeightH5()->value() . ';line-height:' . $newSite->lineHeightH5()->value() . 'px}';

        $css = $css . 'main h6,.title-h6{font-size:' . $newSite->fontSizeH6()->value() . 'px;font-weight:' . $newSite->fontWeightH6()->value() . ';line-height:' . $newSite->lineHeightH6()->value() . 'px}';

        $css = $css . '@media only screen and (min-width:768px){.title-hero{font-size:' . $newSite->fontSizeHero()->value() . 'px;font-weight:' . $newSite->fontWeightHero()->value() . ';line-height:' . $newSite->lineHeightHero()->value() . 'px}}';

        $css = $css . '@media only screen and (max-width:767px){main h1,.title-h1{font-size:' . $newSite->fontSizeH3()->value() . 'px;font-weight:' . $newSite->fontWeightH3()->value() . ';line-height:' . $newSite->lineHeightH3()->value() . 'px}}';

        $css = $css . '@media only screen and (max-width:767px){main h2,.title-h2{font-size:' . $newSite->fontSizeH4()->value() . 'px;font-weight:' . $newSite->fontWeightH4()->value() . ';line-height:' . $newSite->lineHeightH4()->value() . 'px}}';

        $css = $css . '@media only screen and (max-width:767px){main h3,.title-h3{font-size:' . $newSite->fontSizeH5()->value() . 'px;font-weight:' . $newSite->fontWeightH5()->value() . ';line-height:' . $newSite->lineHeightH5()->value() . 'px}}';

        $css = $css . '@media only screen and (max-width:767px){main h4,.title-h4,main h5,.title-h5,main h6,.title-h6{font-size:' . $newSite->fontSizeH6()->value() . 'px;font-weight:' . $newSite->fontWeightH6()->value() . ';line-height:' . $newSite->lineHeightH6()->value() . 'px}}';

        $css = $css . '@media only screen and (max-width:1200px) and (min-width:768px){.row .title-h1,.row .title-hero{font-size:' . $newSite->fontSizeH2()->value() . 'px;font-weight:' . $newSite->fontWeightH2()->value() . ';line-height:' . $newSite->lineHeightH2()->value() . 'px}}';

        $css = $css . '.bg-color-primary,.button.button-style-primary,.card .button.button-style-primary,.timeline [class^="col-"]:before{background:#' . $newSite->colorPrimary() . '}';
        $css = $css . 'body.dark .button.button-style-primary{background:#' . $newSite->colorPrimary() . ' !important}';
        $css = $css . '.form input[type="checkbox"]:checked+label.checkbox:before,.form input[type="radio"]:checked+label.radio:before,.form input.switch:checked+label.switch:before{background:#' . $newSite->colorPrimary() . '}';

        // Change the brightness of the primary color
        function colorBrightness($hex, $steps) {
          $steps = max(-255, min(255, $steps));

          if (strlen($hex) == 3) {
            $hex = str_repeat(substr($hex, 0, 1), 2).str_repeat(substr($hex, 1, 1), 2).str_repeat(substr($hex, 2, 1), 2);
          }

          $hexSplits = str_split($hex, 2);
          $hexNew = '';

          foreach ($hexSplits as $split) {
              $split = hexdec($split);
              $split = max(0, min(255, $split + $steps));
              $hexNew .= str_pad(dechex($split), 2, '0', STR_PAD_LEFT);
          }

          return $hexNew;
        }
        $css = $css . '.button.button-style-primary:hover{background:#' . colorBrightness($newSite->colorPrimary(), 25) . '}';
        $css = $css . 'body.dark .button.button-style-primary:hover{background:#' . colorBrightness($newSite->colorPrimary(), 25) . ' !important}';
        $css = $css . 'body.primary-white:not(.dark) [class*="bg-"].dark [class*="bg-"]:not(.dark) .button.button-style-primary{background:#' . $newSite->colorPrimary() . ' !important;color:#fff !important}';
        $css = $css . 'body.primary-white:not(.dark) [class*="bg-"].dark [class*="bg-"]:not(.dark) .button.button-style-primary:hover{background:#' . colorBrightness($newSite->colorPrimary(), 25) . ' !important}';

        if ($newSite->logoType()->value() === 'svg' && $newSite->logoSvgWidth()->isNotEmpty()) {
          $css = $css . '.logo{width:' . $newSite->logoSvgWidth() . 'px}';
        }

        $css = $css . '.max-width-lg{max-width:' . $newSite->width() . 'px}';

        if ($newSite->width()->value() < 960) {
          $css = $css . '.max-width-md{max-width:' . $newSite->width() . 'px}';
        }

        if ($newSite->roundedButtons()->value() != 0) {
          $css = $css . '.button,.flickity-prev-next-button,.tag{-webkit-border-radius:' . $newSite->roundedButtons()->value() . 'px;-moz-border-radius:' . $newSite->roundedButtons()->value() . 'px;border-radius:' . $newSite->roundedButtons()->value() . 'px}';
        }

        if ($newSite->roundedButtons()->value() < 12) {
          $css = $css . '.form input:not(.button),.form select,.form textarea,.form label.checkbox:before{-webkit-border-radius:' . $newSite->roundedButtons()->value() . 'px;-moz-border-radius:' . $newSite->roundedButtons()->value() . 'px;border-radius:' . $newSite->roundedButtons()->value() . 'px}';
        }

        if ($newSite->rounded()->value() < 2) {
          $css = $css . 'main code,.alert,.highlight{-webkit-border-radius:' . $newSite->rounded()->value() . 'px;-moz-border-radius:' . $newSite->rounded()->value() . 'px;border-radius:' . $newSite->rounded()->value() . 'px}';
        }

        if ($newSite->rounded()->value() < 16) {
          $css = $css . 'main pre,main table{-webkit-border-radius:' . $newSite->rounded()->value() . 'px;-moz-border-radius:' . $newSite->rounded()->value() . 'px;border-radius:' . $newSite->rounded()->value() . 'px}';
          $css = $css . 'main table tr th:first-child{-webkit-border-top-left-radius:' . $newSite->rounded()->value() - 2 . 'px;-moz-border-radius-topleft:' . $newSite->rounded()->value() - 2 . 'px;border-top-left-radius:' . $newSite->rounded()->value() - 2 . 'px}';
          $css = $css . 'main table tr th:last-child{-webkit-border-top-right-radius:' . $newSite->rounded()->value() - 2 . 'px;-moz-border-radius-topright:' . $newSite->rounded()->value() - 2 . 'px;border-top-right-radius:' . $newSite->rounded()->value() - 2 . 'px}';
        }

        if ($newSite->rounded()->value() != 0) {
          $css = $css . '.border.rounded>figure>video{-webkit-border-radius:' . $newSite->rounded()->value() - 2 . 'px;-moz-border-radius:' . $newSite->rounded()->value() - 2 . 'px;border-radius:' . $newSite->rounded()->value() - 2 . 'px}';
          $css = $css . 'article figure img,article iframe,#features .blocks[class*="bg-"],.card,.rounded,.rounded>figure>video,.sidebar-nav,.header-main ul li.submenu>ul{-webkit-border-radius:' . $newSite->rounded()->value() . 'px;-moz-border-radius:' . $newSite->rounded()->value() . 'px;border-radius:' . $newSite->rounded()->value() . 'px}.rounded-bottom{-webkit-border-bottom-left-radius:' . $newSite->rounded()->value() . 'px;-moz-border-radius-bottomleft:' . $newSite->rounded()->value() . 'px;border-bottom-left-radius:' . $newSite->rounded()->value() . 'px;-webkit-border-bottom-right-radius:' . $newSite->rounded()->value() . 'px;-moz-border-radius-bottomright:' . $newSite->rounded()->value() . 'px;border-bottom-right-radius:' . $newSite->rounded()->value() . 'px}.rounded-left{-webkit-border-bottom-left-radius:' . $newSite->rounded()->value() . 'px;-moz-border-radius-bottomleft:' . $newSite->rounded()->value() . 'px;border-bottom-left-radius:' . $newSite->rounded()->value() . 'px;-webkit-border-top-left-radius:' . $newSite->rounded()->value() . 'px;-moz-border-radius-topleft:' . $newSite->rounded()->value() . 'px;border-top-left-radius:' . $newSite->rounded()->value() . 'px}.rounded-right{-webkit-border-bottom-right-radius:' . $newSite->rounded()->value() . 'px;-moz-border-radius-bottomright:' . $newSite->rounded()->value() . 'px;border-bottom-right-radius:' . $newSite->rounded()->value() . 'px;-webkit-border-top-right-radius:' . $newSite->rounded()->value() . 'px;-moz-border-radius-topright:' . $newSite->rounded()->value() . 'px;border-top-right-radius:' . $newSite->rounded()->value() . 'px}.rounded-top{-webkit-border-top-left-radius:' . $newSite->rounded()->value() . 'px;-moz-border-radius-topleft:' . $newSite->rounded()->value() . 'px;border-top-left-radius:' . $newSite->rounded()->value() . 'px;-webkit-border-top-right-radius:' . $newSite->rounded()->value() . 'px;-moz-border-radius-topright:' . $newSite->rounded()->value() . 'px;border-top-right-radius:' . $newSite->rounded()->value() . 'px}.rounded-bottom-left{-webkit-border-bottom-left-radius:' . $newSite->rounded()->value() . 'px;-moz-border-radius-bottomleft:' . $newSite->rounded()->value() . 'px;border-bottom-left-radius:' . $newSite->rounded()->value() . 'px}.rounded-bottom-right{-webkit-border-bottom-right-radius:' . $newSite->rounded()->value() . 'px;-moz-border-radius-bottomright:' . $newSite->rounded()->value() . 'px;border-bottom-right-radius:' . $newSite->rounded()->value() . 'px}.rounded-top-left{-webkit-border-top-left-radius:' . $newSite->rounded()->value() . 'px;-moz-border-radius-topleft:' . $newSite->rounded()->value() . 'px;border-top-left-radius:' . $newSite->rounded()->value() . 'px}.rounded-top-right{-webkit-border-top-right-radius:' . $newSite->rounded()->value() . 'px;-moz-border-radius-topright:' . $newSite->rounded()->value() . 'px;border-top-right-radius:' . $newSite->rounded()->value() . 'px}';
        }

        // Custom border color
        if ($newSite->colorBorderDark()->isNotEmpty()) {
          $css = $css . 'main .dark table,.dark .button.button-style-tertiary,.dark .border,.dark .border .tag,.dark .share [class*="button-"]{border:2px solid #' . $newSite->colorBorderDark() . '}';
          $css = $css . 'body.dark main table,body.dark .button.button-style-tertiary,body.dark .border,body.dark .border .tag,body.dark .share [class*="button-"]{border:2px solid #' . $newSite->colorBorderDark() . ' !important}';
          $css = $css . 'main .dark table tr td,main .dark table tr th,.border-bottom.dark,.dark .border-bottom{border-bottom:2px solid #' . $newSite->colorBorderDark() . '}';
          $css = $css . 'body.dark main table tr td,body.dark main table tr th,body.dark .border-bottom{border-bottom:2px solid #' . $newSite->colorBorderDark() . ' !important}';
          $css = $css . '.dark .border-top{border-top:2px solid #' . $newSite->colorBorderDark() . '}';
          $css = $css . 'body.dark .border-top{border-top:2px solid #' . $newSite->colorBorderDark() . ' !important}';
          // Header borders
          $css = $css . 'body.dark .header-main[class*="shadow-"]{border-bottom:1px solid #' . $newSite->colorBorderDark() . '}';
          $css = $css . '@media only screen and (min-width:' . $newSite->headerBreakpoint()->value() + 1 . 'px){.header-main ul li.submenu>ul{border:1px solid #' . $newSite->colorBorderDark() . '}}';
        } else {
          $css = $css . 'main .dark table,.dark .button.button-style-tertiary,.dark .border,.dark .border .tag,.dark .share [class*="button-"]{border:2px solid #333333}';
          $css = $css . 'body.dark main table,body.dark .button.button-style-tertiary,body.dark .border,body.dark .border .tag,body.dark .share [class*="button-"]{border:2px solid #333333 !important}';
          $css = $css . 'main .dark table tr td,main .dark table tr th,.border-bottom.dark,.dark .border-bottom{border-bottom:2px solid #333333}';
          $css = $css . 'body.dark main table tr td,body.dark main table tr th,body.dark .border-bottom{border-bottom:2px solid #333333 !important}';
          $css = $css . '.dark .border-top{border-top:2px solid #333333}';
          $css = $css . 'body.dark .border-top{border-top:2px solid #333333 !important}';
          // Header borders
          $css = $css . 'body.dark .header-main[class*="shadow-"]{border-bottom:1px solid #333333}';
          $css = $css . '@media only screen and (min-width:' . $newSite->headerBreakpoint()->value() + 1 . 'px){.header-main ul li.submenu>ul{border:1px solid #333333}}';
        }

        if ($newSite->colorBorder()->isNotEmpty()) {
          $css = $css . 'main table,.button.button-style-tertiary,.border,.border .tag,.share [class*="button-"]{border:2px solid #' . $newSite->colorBorder() . '}';
          $css = $css . 'main [class*="bg-"].dark [class*="bg-"]:not(.dark) table,[class*="bg-"].dark [class*="bg-"]:not(.dark) .button.button-style-tertiary,[class*="bg-"].dark [class*="bg-"]:not(.dark) .border,[class*="bg-"].dark [class*="bg-"]:not(.dark) .border .tag,[class*="bg-"].dark [class*="bg-"]:not(.dark) .share [class*="button-"]{border:2px solid #' . $newSite->colorBorder() . '}';
          $css = $css . 'main table tr td,main table tr th,.border-bottom{border-bottom:2px solid #' . $newSite->colorBorder() . '}';
          $css = $css . 'main [class*="bg-"].dark [class*="bg-"]:not(.dark) table tr td,main [class*="bg-"].dark [class*="bg-"]:not(.dark) table tr th,[class*="bg-"].dark [class*="bg-"]:not(.dark) .border-bottom{border-bottom:2px solid #' . $newSite->colorBorder() . '}';
          $css = $css . '.border-top{border-top:2px solid #' . $newSite->colorBorder() . '}';
          $css = $css . '[class*="bg-"].dark [class*="bg-"]:not(.dark) .border-top{border-top:2px solid #' . $newSite->colorBorder() . '}';
        } else {
          $css = $css . 'main table,.button.button-style-tertiary,.border,.border .tag,.share [class*="button-"]{border:2px solid #ececee}';
          $css = $css . 'main [class*="bg-"].dark [class*="bg-"]:not(.dark) table,[class*="bg-"].dark [class*="bg-"]:not(.dark) .button.button-style-tertiary,[class*="bg-"].dark [class*="bg-"]:not(.dark) .border,[class*="bg-"].dark [class*="bg-"]:not(.dark) .border .tag,[class*="bg-"].dark [class*="bg-"]:not(.dark) .share [class*="button-"]{border:2px solid #ececee}';
          $css = $css . 'main table tr td,main table tr th,.border-bottom{border-bottom:2px solid #ececee}';
          $css = $css . 'main [class*="bg-"].dark [class*="bg-"]:not(.dark) table tr td,main [class*="bg-"].dark [class*="bg-"]:not(.dark) table tr th,[class*="bg-"].dark [class*="bg-"]:not(.dark) .border-bottom{border-bottom:2px solid #ececee}';
          $css = $css . '.border-top{border-top:2px solid #ececee}';
          $css = $css . '[class*="bg-"].dark [class*="bg-"]:not(.dark) .border-top{border-top:2px solid #ececee}';
        }

        // Custom header background
        $backgroundHeader = $newSite->headerBackground()->toStructure()->first();
        if ($backgroundHeader) {
          $backgroundHeaderColor = $backgroundHeader->color()->toStructure()->first();
          $backgroundHeaderGradient = $backgroundHeader->gradient()->toStructure()->first();
        }

        if ($backgroundHeader && $backgroundHeader->type()->value() === 'color' && $backgroundHeaderColor && $backgroundHeaderColor->fill()->value() === 'custom') {
          if ($backgroundHeaderColor->custom()->isNotEmpty()) {
            $css = $css . 'header.bg-color-custom{background:#' . $backgroundHeaderColor->custom() . ' !important}';
          }
          if ($backgroundHeaderColor->customDark()->isNotEmpty()) {
            $css = $css . 'body.dark header.bg-color-custom{background:#' . $backgroundHeaderColor->customDark() . ' !important}';
            $css = $css . '@media only screen and (min-width:' . $newSite->headerBreakpoint()->value() + 1 . 'px){.header-main ul li.submenu>ul{background:#' . $backgroundHeaderColor->customDark() . ' !important}}';
          }
        }

        if ($backgroundHeader && $backgroundHeader->type()->value() === 'gradient' && $backgroundHeaderGradient && $backgroundHeaderGradient->fill()->value() === 'custom') {
          if ($backgroundHeaderGradient->custom()->isNotEmpty()) {
            if ($backgroundHeader->brightness()->bool()) {
              $css = $css . 'header.bg-gradient-custom{background:#000}';
            } else {
              $css = $css . 'header.bg-gradient-custom{background:#fff}';
            }
            $css = $css . 'header.bg-gradient-custom{background:-webkit-' . $backgroundHeaderGradient->custom() . ';background:-moz-' . $backgroundHeaderGradient->custom() . ';background:-ms-' . $backgroundHeaderGradient->custom() . ';background:-o-' . $backgroundHeaderGradient->custom() . ';background:' . $backgroundHeaderGradient->custom() . '}';
          }
          if ($backgroundHeaderGradient->customDark()->isNotEmpty()) {
            $css = $css . 'body.dark header.bg-gradient-custom{background:#000 !important;background:-webkit-' . $backgroundHeaderGradient->customDark() . ' !important;background:-moz-' . $backgroundHeaderGradient->customDark() . ' !important;background:-ms-' . $backgroundHeaderGradient->customDark() . ' !important;background:-o-' . $backgroundHeaderGradient->customDark() . ' !important;background:' . $backgroundHeaderGradient->customDark() . ' !important}';
          }
        }

        // Custom footer background
        $backgroundFooter = $newSite->footerBackground()->toStructure()->first();
        if ($backgroundFooter) {
          $backgroundFooterColor = $backgroundFooter->color()->toStructure()->first();
          $backgroundFooterGradient = $backgroundFooter->gradient()->toStructure()->first();
        }

        if ($backgroundFooter && $backgroundFooter->type()->value() === 'color' && $backgroundFooterColor && $backgroundFooterColor->fill()->value() === 'custom') {
          if ($backgroundFooterColor->custom()->isNotEmpty()) {
            $css = $css . '.footer.bg-color-custom{background:#' . $backgroundFooterColor->custom() . '}';
          }
          if ($backgroundFooterColor->customDark()->isNotEmpty()) {
            $css = $css . 'body.dark .footer.bg-color-custom{background:#' . $backgroundFooterColor->customDark() . ' !important}';
          }
        }

        if ($backgroundFooter && $backgroundFooter->type()->value() === 'gradient' && $backgroundFooterGradient && $backgroundFooterGradient->fill()->value() === 'custom') {
          if ($backgroundFooterGradient->custom()->isNotEmpty()) {
            if ($backgroundFooter->brightness()->bool()) {
              $css = $css . '.footer.bg-gradient-custom{background:#000}';
            } else {
              $css = $css . '.footer.bg-gradient-custom{background:#fff}';
            }
            $css = $css . '.footer.bg-gradient-custom{background:-webkit-' . $backgroundFooterGradient->custom() . ';background:-moz-' . $backgroundFooterGradient->custom() . ';background:-ms-' . $backgroundFooterGradient->custom() . ';background:-o-' . $backgroundFooterGradient->custom() . ';background:' . $backgroundFooterGradient->custom() . '}';
          }
          if ($backgroundFooterGradient->customDark()->isNotEmpty()) {
            $css = $css . 'body.dark .footer.bg-gradient-custom{background:#000 !important;background:-webkit-' . $backgroundFooterGradient->customDark() . ' !important;background:-moz-' . $backgroundFooterGradient->customDark() . ' !important;background:-ms-' . $backgroundFooterGradient->customDark() . ' !important;background:-o-' . $backgroundFooterGradient->customDark() . ' !important;background:' . $backgroundFooterGradient->customDark() . ' !important}';
          }
        }

        // Custom newsletter background
        $backgroundNewsletter = $newSite->newsletterBackground()->toStructure()->first();
        if ($backgroundNewsletter) {
          $backgroundNewsletterColor = $backgroundNewsletter->color()->toStructure()->first();
          $backgroundNewsletterGradient = $backgroundNewsletter->gradient()->toStructure()->first();
        }

        if ($backgroundNewsletter && $backgroundNewsletter->type()->value() === 'color' && $backgroundNewsletterColor && $backgroundNewsletterColor->fill()->value() === 'custom') {
          if ($backgroundNewsletterColor->custom()->isNotEmpty()) {
            $css = $css . '.newsletter .bg-color-custom{background:#' . $backgroundNewsletterColor->custom() . '}';
          }
          if ($backgroundNewsletterColor->customDark()->isNotEmpty()) {
            $css = $css . 'body.dark .newsletter .bg-color-custom{background:#' . $backgroundNewsletterColor->customDark() . ' !important}';
          }
        }

        if ($backgroundNewsletter && $backgroundNewsletter->type()->value() === 'gradient' && $backgroundNewsletterGradient && $backgroundNewsletterGradient->fill()->value() === 'custom') {
          if ($backgroundNewsletterGradient->custom()->isNotEmpty()) {
            if ($backgroundNewsletter->brightness()->bool()) {
              $css = $css . '.newsletter .bg-gradient-custom{background:#000}';
            } else {
              $css = $css . '.newsletter .bg-gradient-custom{background:#fff}';
            }
            $css = $css . '.newsletter .bg-gradient-custom{background:-webkit-' . $backgroundNewsletterGradient->custom() . ';background:-moz-' . $backgroundNewsletterGradient->custom() . ';background:-ms-' . $backgroundNewsletterGradient->custom() . ';background:-o-' . $backgroundNewsletterGradient->custom() . ';background:' . $backgroundNewsletterGradient->custom() . '}';
          }
          if ($backgroundNewsletterGradient->customDark()->isNotEmpty()) {
            $css = $css . 'body.dark .newsletter .bg-gradient-custom{background:#000 !important;background:-webkit-' . $backgroundNewsletterGradient->customDark() . ' !important;background:-moz-' . $backgroundNewsletterGradient->customDark() . ' !important;background:-ms-' . $backgroundNewsletterGradient->customDark() . ' !important;background:-o-' . $backgroundNewsletterGradient->customDark() . ' !important;background:' . $backgroundNewsletterGradient->customDark() . ' !important}';
          }
        }

        // Header breakpoints
        $css = $css . '@media only screen and (min-width:' . $newSite->headerBreakpoint()->value() + 1 . 'px){.header-main ul li.submenu{height:40px;overflow:hidden;position:relative}.header-main ul li.submenu>ul{-webkit-transition:all .2s;-moz-transition:all .2s;-ms-transition:all .2s;-o-transition:all .2s;transition:all .2s;background:#1a1a1a;opacity:0;padding:7px 15px;position:absolute;right:20px}.header-main ul li.submenu>ul li{display:block;padding-right:0}.header-main ul li.submenu>ul li a{color:#fff;height:32px;line-height:32px;opacity:.8}.header-main ul li.submenu>ul li a:hover{opacity:1}.header-main ul li.submenu>ul li a .icon-external-link{margin-bottom:2px;margin-top:2px}.header-main ul li.submenu:hover{overflow:visible}.header-main ul li.submenu:hover>a,.header-main ul li.submenu:hover>ul{opacity:1}.header-main ul li:last-child.submenu>ul{right:0}}';

        if ($newSite->headerBreakpoint()->value() < 767) {
          $css = $css . '@media only screen and (max-width: 767px) and (min-width:' . $newSite->headerBreakpoint()->value() . 'px){main.header-bg .hero:not(.hero-lg),main.header-bg .hero-lg:not(.hero),main.header-bg .hero-none,main.header-bg.post article{padding-top:48px}main.header-bg .hero:not(.hero-lg).hero-columns.hero-blocks [class*="space-hero"]{margin-top:0}main:not(.header-bg) .hero.hero-padding-top:not(.hero-lg){padding-top:80px}}';
        }

        $css = $css . '@media only screen and (max-width:' . $newSite->headerBreakpoint()->value() . 'px){main.header-bg:before,main.header-fixed:before{height:64px}main .hero:not(.hero-lg),main .hero-lg:not(.hero),main .hero-none,main.post article{padding-top:64px}main.header-bg .hero:not(.hero-lg),main.header-fixed .hero:not(.hero-lg),main.header-bg .hero-lg:not(.hero),main.header-fixed .hero-lg:not(.hero),main.header-bg .hero-none,main.header-fixed .hero-none,main.header-bg.post article,main.header-fixed.post article{padding-top:48px}main.header-bg .hero:not(.hero-lg):not(.hero-columns).hero-blocks [class*="space-hero"],main.header-bg .hero:not(.hero-lg):not(.hero-columns).padding-bottom-none:not(.hero-blocks) [class*="space-hero"],main.header-fixed .hero:not(.hero-lg):not(.hero-columns).hero-blocks [class*="space-hero"],main.header-fixed .hero:not(.hero-lg):not(.hero-columns).padding-bottom-none:not(.hero-blocks) [class*="space-hero"]{margin-top:0}main.header-bg .hero:not(.hero-lg).hero-columns.hero-blocks [class*="space-hero"],main.header-fixed .hero:not(.hero-lg).hero-columns.hero-blocks [class*="space-hero"]{margin-top:0}main.header-bg .hero:not(.hero-lg).hero-columns.padding-bottom-none:not(.hero-blocks) [class*="space-hero"],main.header-fixed .hero:not(.hero-lg).hero-columns.padding-bottom-none:not(.hero-blocks) [class*="space-hero"]{margin-top:0}main.header-fixed .hero-none>[class*="space-hero"],main.header-fixed.post article [class*="space-hero"]{margin-top:0}main.header-fixed.header-fixed--sm .anchor{scroll-margin-top:96px}main.header-fixed.header-fixed--sm .position-sticky{top:88px}.header-main{height:64px}.header-main nav{padding-bottom:12px;padding-top:12px}.header-main nav.full-width{padding:12px 24px}.header-main a{-webkit-transition:none !important;-moz-transition:none !important;-ms-transition:none !important;-o-transition:none !important;transition:none !important}.header-main ul{display:none;margin:0}.header-main ul.header-space-reduced{margin-right:0}.header-main ul.header-controls{display:block;position:absolute;right:40px;top:0}.header-main ul.header-controls.header-toggle-none{right:0}.header-main ul.header-controls a.icon-search:hover{opacity:.6}.header-main .header-toggle{-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;display:block;height:40px;opacity:1;padding:10px;position:absolute;right:-10px;top:0;width:40px}.header-main .header-toggle svg{position:absolute}.header-main .header-toggle svg:last-child{opacity:0}.header-main.active{border-bottom:none !important;height:100%;position:fixed;z-index:999}body.dark .header-main.active{background:#000;color:#fff}.header-main.active nav{height:100%;overflow-y:scroll;padding-bottom:0;padding-top:12px;-webkit-overflow-scrolling:touch}.header-main.active nav>div{height:auto;margin-bottom:64px}.header-main.active ul{text-align:left}.header-main.active ul.header-listed{display:block;float:none}.header-main.active ul.header-listed li{font-size:20px;padding:8px 0 0 0;width:100%}.header-main.active ul.header-listed li a{opacity:1}.header-main.active ul.header-listed li.submenu>ul{display:block;padding-left:24px}.header-main.active ul.header-languages{display:block;padding:28px 0 0 0}.header-main.active ul.header-languages li{font-size:18px;padding:0 8px}.header-main.active ul.header-languages li a,.header-main.active ul.header-languages li a:hover{opacity:.6}.header-main.active ul.header-languages li.active a{opacity:1}.header-main.active ul.header-social{display:block;padding:28px 0 0 0}.header-main.active ul.header-social li{padding:0 20px 0 0}.header-main.active ul.header-social li a,.header-main.active ul.header-social li a:hover{opacity:1}.header-main.active ul.header-buttons{display:block}.header-main.active ul.header-buttons li{padding:16px 0 0 0;width:100%}.header-main.active ul.header-buttons li:first-child{padding:40px 0 0 0}.header-main.active ul.header-buttons li .button{font-size:16px;line-height:24px;opacity:1}.header-main.active .header-space{display:block;padding-top:40px;width:100%}.header-main.active .header-toggle svg{opacity:0}.header-main.active .header-toggle svg:last-child{opacity:1}.header-main.active:not([class*="bg-"]){background:#fff;color:#000}.header-main.header-fixed{position:fixed}body.dark .header-main.header-fixed{background:#000}body.dark .header-main.header-fixed.active{background:#000}.header-main.header-fixed:not([class*="bg-"]){background:#fff}.header-main.header-fixed:not([class*="bg-"]).dark a:not(.button){color:#000}body.dark .header-main.header-fixed:not([class*="bg-"]).dark a:not(.button){color:#eee}.header-main.header-fixed:not([class*="bg-"]).active{background:#fff}.header-main.header-fixed:not([class*="bg-"]).dark .form input.switch+label.switch:before{background:rgba(0,0,0,0.2)}.header-main.header-fixed:not([class*="bg-"]).dark .logo-light{display:block}.dark .header-main.header-fixed:not([class*="bg-"]).dark .logo-light{display:none}.header-main.header-fixed:not([class*="bg-"]).dark .logo-dark{display:none}.dark .header-main.header-fixed:not([class*="bg-"]).dark .logo-dark{display:block}}';

        if ($newSite->headerBreakpoint()->value() > 767) {
          $css = $css . '@media only screen and (max-width:' . $newSite->headerBreakpoint()->value() . 'px) and (min-width: 768px){main .hero:not(.hero-lg),main .hero-lg:not(.hero),main .hero-none,main.post article{padding-top:80px}main.header-bg .hero:not(.hero-lg),main.header-fixed .hero:not(.hero-lg),main.header-bg .hero-lg:not(.hero),main.header-fixed .hero-lg:not(.hero),main.header-bg .hero-none,main.header-fixed .hero-none,main.header-bg.post article,main.header-fixed.post article{padding-top:80px}main.header-default .hero-lg:not(.hero){padding-top:64px}main.header-bg .hero:not(.hero-lg):not(.hero-columns).hero-blocks [class*="space-hero"],main.header-bg .hero:not(.hero-lg):not(.hero-columns).padding-bottom-none:not(.hero-blocks) [class*="space-hero"],main.header-fixed .hero:not(.hero-lg):not(.hero-columns).hero-blocks [class*="space-hero"],main.header-fixed .hero:not(.hero-lg):not(.hero-columns).padding-bottom-none:not(.hero-blocks) [class*="space-hero"]{margin-top:0}main.header-bg .hero:not(.hero-lg).hero-columns.hero-blocks [class*="space-hero"],main.header-fixed .hero:not(.hero-lg).hero-columns.hero-blocks [class*="space-hero"]{margin-top:0}main.header-bg .hero:not(.hero-lg).hero-columns.padding-bottom-none:not(.hero-blocks) [class*="space-hero"],main.header-fixed .hero:not(.hero-lg).hero-columns.padding-bottom-none:not(.hero-blocks) [class*="space-hero"]{margin-top:0}}';
        }

        if ($newSite->customCss()->isNotEmpty()) {
          $css = $css . $newSite->customCss();
        }

        F::write(kirby()->root('assets') . '/css/custom.min.css', $css);
      }
    },

    'page.create:before' => function($page) {
      if ($page->kirby()->language() !== $page->kirby()->defaultLanguage()) {
        throw new Exception('Please switch to the default language.');
      }
    },

    'file.create:after' => function($file) {

      // Image optimization
      if (site()->mediaResize()->bool() && site()->mediaResizeHeight()->isNotEmpty() && site()->mediaResizeWidth()->isNotEmpty() && site()->mediaResizeThreshold()->isNotEmpty() && $file->isResizable()) {
        if (in_array($file->extension(), ['jpg', 'jpeg']) && $file->size() > site()->mediaResizeThreshold()->value()*1000 && ($file->height() > site()->mediaResizeHeight()->value() || $file->width() > site()->mediaResizeWidth()->value())) {
          try {
            kirby()->thumb($file->root(), $file->root(), [
              'height'  => site()->mediaResizeHeight()->value(),
              'width'   => site()->mediaResizeWidth()->value(),
              'quality' => site()->mediaResizeQuality()->value()
            ]);
          } catch (Exception $e) {
            throw new Exception($e->getMessage());
          }
        } elseif (in_array($file->extension(), ['jpg', 'jpeg']) && $file->size() > site()->mediaResizeThreshold()->value()*1000) {
          try {
            kirby()->thumb($file->root(), $file->root(), [
              'quality' => site()->mediaResizeQuality()->value()
            ]);
          } catch (Exception $e) {
            throw new Exception($e->getMessage());
          }
        }
      }

      if ($file->type() === 'image' && $file->template() !== 'avatar') {
        $file->update([
          'Alt'      => '',
          'Caption'  => '',
          'date'     => date('Y-m-d H:i'),
          'Template' => 'image'
        ]);
      } elseif ($file->type() === 'video') {
        $file->update([
          'Caption'     => '',
          'date'        => date('Y-m-d H:i'),
          'Autoplay'    => 'true',
          'Controls'    => 'true',
          'Loop'        => 'true',
          'Muted'       => 'true',
          'Playsinline' => 'false',
          'Template'    => 'video'
        ]);
      }
    },

    'file.replace:after' => function($newFile) {
      if (site()->mediaResize()->bool() && site()->mediaResizeHeight()->isNotEmpty() && site()->mediaResizeWidth()->isNotEmpty() && site()->mediaResizeThreshold()->isNotEmpty() && $newFile->isResizable()) {
        if (in_array($newFile->extension(), ['jpg', 'jpeg']) && $newFile->size() > site()->mediaResizeThreshold()->value()*1000 && ($newFile->height() > site()->mediaResizeHeight()->value() || $newFile->width() > site()->mediaResizeWidth()->value())) {
          try {
            kirby()->thumb($newFile->root(), $newFile->root(), [
              'height'  => site()->mediaResizeHeight()->value(),
              'width'   => site()->mediaResizeWidth()->value(),
              'quality' => site()->mediaResizeQuality()->value()
            ]);
          } catch (Exception $e) {
            throw new Exception($e->getMessage());
          }
        } elseif (in_array($newFile->extension(), ['jpg', 'jpeg']) && $newFile->size() > site()->mediaResizeThreshold()->value()*1000) {
          try {
            kirby()->thumb($newFile->root(), $newFile->root(), [
              'quality' => site()->mediaResizeQuality()->value()
            ]);
          } catch (Exception $e) {
            throw new Exception($e->getMessage());
          }
        }
      }
    }
  ]
];