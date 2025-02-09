  <?php

    $backgroundFooter = $site->footerBackground()->toStructure()->first();
    $footerMenus = $site->footerMenus()->toStructure();
    $socialProfiles = $site->social()->toStructure();

    // Classes

    if ($backgroundFooter && background($backgroundFooter)) {
      $class = background($backgroundFooter) . ' footer padding';
    } else {
      $class = 'footer padding';
    }

    if ($site->footerPaddingTop()->bool() === false) {
      $class = $class . ' padding-top-none';
    }

    if ($backgroundFooter && $backgroundFooter->brightness()->bool()) {
      $class = $class . ' dark';
    }

  ?>
  <footer class="<?= $class ?>">

    <?php if ($footerMenus->isNotEmpty() || $site->footerText()->isNotEmpty() || ($site->footerNewsletter()->bool() && $site->newsletterCode()->isNotEmpty())): ?>

      <?php

        // Menu columns, text and newsletter

        $class = 'row row-one-column--lg max-width-lg';

        if (
          !$footerMenus->isNotEmpty()
          && (
            $site->footerText()->isNotEmpty() && ($site->footerNewsletter()->bool() === false || $site->newsletterCode()->isEmpty())
            || (
              $site->footerText()->isEmpty() && $site->footerNewsletter()->bool() && $site->newsletterCode()->isNotEmpty()
            )
          )
        ) {
          $class = $class . ' align-center';
        } else {
          $class = $class . ' align-center--lg';
        }

        if (
          $footerMenus->isNotEmpty() && $footerMenus->count() < 3 && $site->footerText()->isEmpty() && ($site->footerNewsletter()->bool() === false || $site->newsletterCode()->isEmpty())
          || (
            !$footerMenus->isNotEmpty()
            && (
              $site->footerText()->isNotEmpty() && ($site->footerNewsletter()->bool() === false || $site->newsletterCode()->isEmpty())
              || (
                $site->footerText()->isEmpty() && $site->footerNewsletter()->bool() && $site->newsletterCode()->isNotEmpty()
              )
            )
          )
        ) {
          $class = $class . ' row-fill-empty-columns';
        }

      ?>
      <div class="<?= $class ?>">

        <?php if ($footerMenus->isNotEmpty() && ($site->footerText()->isNotEmpty() || ($site->footerNewsletter()->bool() && $site->newsletterCode()->isNotEmpty()))): ?>
          <div class="col-2-3">
        <?php endif ?>

            <?php if ($footerMenus->isNotEmpty()): ?>
              <div class="row row-one-column--lg">

                <?php foreach ($footerMenus as $footerMenu):

                  $footerMenuLinks = $footerMenu->links()->toStructure();

                ?>

                  <?php if ($footerMenuLinks->isNotEmpty()): ?>

                    <?php

                      // Menu columns

                      if ($footerMenus->count() < 4) {
                        $class = 'col-1-3';
                      } elseif ($footerMenus->count() === 4 && ($site->footerText()->isNotEmpty() || ($site->footerNewsletter()->bool() && $site->newsletterCode()->isNotEmpty()))) {
                        $class = 'col-1-2';
                      } elseif ($footerMenus->count() === 4) {
                        $class = 'col-1-4';
                      }

                    ?>
                    <div class="<?= $class ?>">

                      <?php if ($footerMenu->title()->isNotEmpty()): ?>
                        <h4 class="space-bottom-075x title-h5"><?= $footerMenu->title() ?></h4>
                      <?php endif ?>

                      <ul class="list list-style-none space-none">

                        <?php foreach ($footerMenuLinks as $footerMenuLink): ?>

                          <?php if ($footerMenuLink->link()->value() === 'page' && $footerMenuLink->page()->isNotEmpty() && $footerMenuLink->page()->toPage()): ?>
                            <li><a href="<?= $footerMenuLink->page()->toPage()->url() ?>"><?php if ($footerMenuLink->label()->isNotEmpty()): ?><?= $footerMenuLink->label() ?><?php else: ?><?= $footerMenuLink->page()->toPage()->title() ?><?php endif ?></a></li>
                          <?php elseif ($footerMenuLink->link()->value() === 'url' && $footerMenuLink->label()->isNotEmpty() && $footerMenuLink->url()->isNotEmpty()): ?>
                            <li><a href="<?= $footerMenuLink->url() ?>"<?php if ($footerMenuLink->target()->bool()): ?> target="_blank" rel="noopener noreferrer"<?php endif ?>><?= $footerMenuLink->label() ?><span class="icon-external-link"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="12" height="28" viewBox="0 0 12 12"><path d="M10 10H2V2h1V0H2a2 2 0 00-2 2v8a2 2 0 002 2h8c1.1 0 2-.9 2-2V9h-2v1zM5 0v2h3.59L3.76 6.83l1.41 1.41L10 3.41V7h2V0H5z" fill="currentColor"></path></svg></span></a></li>
                          <?php endif ?>

                        <?php endforeach ?>

                      </ul>
                    </div>
                  <?php endif ?>

                <?php endforeach ?>

              </div>
            <?php endif ?>

        <?php if ($footerMenus->isNotEmpty() && ($site->footerText()->isNotEmpty() || ($site->footerNewsletter()->bool() && $site->newsletterCode()->isNotEmpty()))): ?>
          </div>
        <?php endif ?>

        <?php if ($site->footerText()->isNotEmpty() || ($site->footerNewsletter()->bool() && $site->newsletterCode()->isNotEmpty())): ?>

          <?php if ($footerMenus->isNotEmpty()): ?>
            <div class="col-1-3">

              <?php if ($site->footerHeading()->isNotEmpty()): ?>
                <h4 class="space-bottom-05x title-h4"><?= $site->footerHeading() ?></h4>
              <?php endif ?>


              <?php if ($site->footerText()->isNotEmpty()): ?>
                <p class="paragraph space-top-none"><?= $site->footerText() ?></p>
              <?php endif ?>

              <?php if ($site->footerNewsletter()->bool()): ?>
                <?= $site->newsletterCode() ?>
              <?php endif ?>

            </div>
          <?php else: ?>

            <?php if ($site->footerText()->isNotEmpty()): ?>
              <div class="col-2-3">

                <?php if ($site->footerNewsletter()->bool() === false || $site->newsletterCode()->isEmpty()): ?>
                  <div class="max-width-md">
                <?php endif ?>

                    <?php if ($site->footerHeading()->isNotEmpty()): ?>
                      <h4 class="space-bottom-05x title-h4"><?= $site->footerHeading() ?></h4>
                    <?php endif ?>

                    <?php if ($site->footerText()->isNotEmpty()): ?>
                      <p class="paragraph space-top-none"><?= $site->footerText() ?></p>
                    <?php endif ?>

                <?php if ($site->footerNewsletter()->bool() === false || $site->newsletterCode()->isEmpty()): ?>
                  </div>
                <?php endif ?>

              </div>
            <?php endif ?>

            <?php if ($site->footerNewsletter()->bool() && $site->newsletterCode()->isNotEmpty()): ?>
              <div class="col-1-3">

                <?php if ($site->footerText()->isEmpty()): ?>
                  <div class="max-width-sm">
                <?php endif ?>

                    <?= $site->newsletterCode() ?>

                <?php if ($site->footerText()->isEmpty()): ?>
                  </div>
                <?php endif ?>

              </div>
            <?php endif ?>

          <?php endif ?>
        <?php endif ?>

      </div>
    <?php endif ?>

    <?php

      // Social icons and copyright

      $class = 'row row-one-column--lg footer-bottom max-width-lg';

      if (socialFooter($socialProfiles)
        || (
          $site->footerLanguages()->bool() && $kirby->languages()->count() > 1
        ) || (
          $footerMenus->isNotEmpty() || ($site->footerText()->isNotEmpty() && ($site->footerNewsletter()->bool() && $site->newsletterCode()->isNotEmpty()))
        )
      ) {
        $class = $class . ' align-center--lg';
      } else {
        $class = $class . ' align-center row-fill-empty-columns';
      }

      if ($footerMenus->isNotEmpty() || $site->footerText()->isNotEmpty() || ($site->footerNewsletter()->bool() && $site->newsletterCode()->isNotEmpty())) {
        $class = $class . ' space-top';
      }

    ?>
    <div class="<?= $class ?>">

      <?php if (socialFooter($socialProfiles) || ($site->footerLanguages()->bool() && $kirby->languages()->count() > 1)): ?>
        <div class="col-1-3 align-middle">

          <?php if (socialFooter($socialProfiles)): ?>
            <ul class="footer-social">

              <?php foreach ($socialProfiles as $socialProfile): ?>

                <?php if ($socialProfile->footer()->bool() && $socialProfile->account()->value() === 'dribbble' && $socialProfile->username()->isNotEmpty()): ?>
                  <li class="icon-dribbble"><a href="https://dribbble.com/<?= $socialProfile->username() ?>" target="_blank" rel="noopener noreferrer"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="24" viewBox="0 0 16 16"><path d="M3 0h10a3 3 0 013 3v10a3 3 0 01-3 3H3a3 3 0 01-3-3V3a3 3 0 013-3zm-.018 6.957a5.141 5.141 0 012.84-3.588 33.08 33.08 0 011.9 2.962c-2.4.638-4.51.63-4.74.626zm8.416-2.782A5.107 5.107 0 006.8 3.028a27.584 27.584 0 011.913 3c1.822-.687 2.59-1.722 2.685-1.853zM4.854 12.05a5.115 5.115 0 005.148.675A21.157 21.157 0 008.907 8.84c-2.066.705-3.517 2.115-4.053 3.21zm3.705-4.058c-.128-.292-.27-.58-.416-.87-2.558.766-5.04.736-5.266.728 0 .053-.003.105-.003.158 0 1.316.498 2.516 1.316 3.427.832-1.421 2.516-2.921 4.369-3.443zm1.309.612c.67 1.841.94 3.341.993 3.652a5.13 5.13 0 002.198-3.435 7.478 7.478 0 00-3.191-.217zm-.762-1.815c.18.367.312.667.45 1.005 1.707-.214 3.402.127 3.57.165a5.076 5.076 0 00-1.159-3.191c-.108.146-.967 1.245-2.86 2.02zM14 8c0-3.308-2.693-6-6-6-3.308 0-6 2.692-6 6 0 3.307 2.692 6 6 6 3.307 0 6-2.693 6-6z" fill="currentColor"></path></svg><span class="name-hidden">Dribbble</span></a></li>
                <?php elseif ($socialProfile->footer()->bool() && $socialProfile->account()->value() === 'facebook' && $socialProfile->username()->isNotEmpty()): ?>
                  <li class="icon-facebook"><a href="https://www.facebook.com/<?= $socialProfile->username() ?>" target="_blank" rel="noopener noreferrer"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="24" viewBox="0 0 16 16"><path d="M13 15.996h-2V10h2l.5-2.5H11V5.846c0-.7.229-1.175 1.232-1.175H13.5v-2.16a16.925 16.925 0 0 0-1.854-.097c-1.842 0-3.107 1.125-3.107 3.193V7.5H6.5V10h2.04v6H3a3 3 0 0 1-3-3V3a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v9.996a3 3 0 0 1-3 3z" fill="currentColor"></path></svg><span class="name-hidden">Facebook</span></a></li>
                <?php elseif ($socialProfile->footer()->bool() && $socialProfile->account()->value() === 'github' && $socialProfile->username()->isNotEmpty()): ?>
                  <li class="icon-github"><a href="https://github.com/<?= $socialProfile->username() ?>" target="_blank" rel="noopener noreferrer"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="24" viewBox="0 0 16 16"><path d="M7.949 0c1.053.006 2.058.2 2.98.553A8.003 8.003 0 0116 8v-.088a8.31 8.31 0 01-1.305 4.469 8.024 8.024 0 01-4.15 3.206c-.378.05-.516-.195-.516-.397 0-.233.008-1.308.01-2.304v-.393c0-.758-.252-1.241-.549-1.496 1.803-.204 3.704-.452 3.704-3.565 0-.884-.317-1.329-.833-1.9.084-.21.358-1.07-.084-2.19-.674-.213-2.225.87-2.225.87a7.576 7.576 0 00-2.026-.273c-.687 0-1.38.093-2.026.274 0 0-1.552-1.08-2.226-.871-.442 1.116-.167 1.98-.084 2.19-.516.568-.761 1.013-.761 1.9 0 3.103 1.82 3.365 3.623 3.565-.233.213-.442.57-.516 1.087-.462.213-1.646.57-2.352-.674a1.707 1.707 0 00-1.214-.829l-.031-.004c-.79-.01-.052.497-.052.497.53.242.897 1.18.897 1.18.474 1.446 2.732.962 2.732.962 0 .58.007 1.474.01 1.844v.137c0 .21-.145.464-.558.39C2.252 14.51 0 11.448 0 7.871v.04A8 8 0 018 0h-.051zM5.774 12.361c-.093.023-.158.084-.148.158.01.065.093.107.19.084.094-.022.158-.084.149-.148-.01-.062-.097-.103-.19-.094zm-.422.2c0 .065-.075.116-.168.116-.107.01-.18-.042-.18-.116 0-.064.073-.116.167-.116.097-.01.18.042.18.116zm-1.004-.145c-.022.065.042.139.14.158.083.032.18 0 .2-.064.019-.065-.043-.14-.14-.168-.083-.023-.177.01-.2.074zm-.516-.403c-.051.042-.032.139.042.2.074.074.168.084.21.032.042-.042.022-.139-.042-.2-.071-.074-.168-.084-.21-.032zm-.367-.474c-.052.032-.052.116 0 .19.051.074.138.106.18.074.052-.042.052-.126 0-.2-.045-.074-.129-.106-.18-.064zm-.33-.413c-.041.032-.032.106.023.168.052.051.126.074.168.032.042-.033.032-.107-.023-.168-.051-.052-.126-.074-.167-.032zm-.348-.261c-.022.041.01.093.074.125.052.033.116.023.139-.022.023-.042-.01-.094-.074-.126-.065-.02-.116-.01-.139.022z" fill="currentColor"></path></svg><span class="name-hidden">GitHub</span></a></li>
                <?php elseif ($socialProfile->footer()->bool() && $socialProfile->account()->value() === 'instagram' && $socialProfile->username()->isNotEmpty()): ?>
                  <li class="icon-instagram"><a href="https://www.instagram.com/<?= $socialProfile->username() ?>" target="_blank" rel="noopener noreferrer"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="24" viewBox="0 0 16 16"><path d="M8 3.5c2.49 0 4.5 2.01 4.5 4.5s-2.01 4.5-4.5 4.5S3.5 10.49 3.5 8 5.51 3.5 8 3.5zM8 5C6.345 5 5 6.345 5 8s1.35 3 3 3 3-1.345 3-3-1.345-3-3-3zm6-2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm1.944 1.701c-.06-1.282-.354-2.417-1.292-3.352C13.716.413 12.582.12 11.3.056c-1.32-.075-5.28-.075-6.6 0-1.278.06-2.413.354-3.352 1.29C.41 2.28.12 3.415.056 4.697c-.075 1.32-.075 5.28 0 6.6.06 1.283.354 2.418 1.292 3.353.94.936 2.07 1.229 3.352 1.293 1.32.075 5.28.075 6.6 0 1.281-.06 2.416-.354 3.352-1.293.935-.935 1.228-2.07 1.292-3.352.075-1.321.075-5.277 0-6.598z" fill="currentColor"></path></svg><span class="name-hidden">Instagram</span></a></li>
                <?php elseif ($socialProfile->footer()->bool() && $socialProfile->account()->value() === 'linkedin' && $socialProfile->username()->isNotEmpty()): ?>
                  <li class="icon-linkedin"><a href="<?php if ($socialProfile->company()->bool()): ?>https://www.linkedin.com/company/<?php else: ?>https://www.linkedin.com/in/<?php endif ?><?= $socialProfile->username() ?>" target="_blank" rel="noopener noreferrer"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="24" viewBox="0 0 16 16"><path d="M13 0a3 3 0 013 3v10a3 3 0 01-3 3H3a3 3 0 01-3-3V3a3 3 0 013-3h10zM4.84 6.079H2.463v7.635H4.84V6.08zm6.039-.19c-1.154 0-1.929.632-2.247 1.232H8.6V6.08H6.325v7.635h2.371V9.936c0-.997.19-1.961 1.425-1.961 1.215 0 1.233 1.14 1.233 2.025v3.714h2.371V9.53c0-2.058-.446-3.64-2.846-3.64zM3.65 2.286a1.376 1.376 0 10.001 2.75 1.376 1.376 0 00-.001-2.75z" fill="currentColor"></path></svg><span class="name-hidden">LinkedIn</span></a></li>
                <?php elseif ($socialProfile->footer()->bool() && $socialProfile->account()->value() === 'twitter' && $socialProfile->username()->isNotEmpty()): ?>
                  <li class="icon-twitter"><a href="https://twitter.com/<?= $socialProfile->username() ?>" target="_blank" rel="noopener noreferrer"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18" height="24" viewBox="0 0 18 15"><path d="M16.15 3.738c.011.164.011.329.011.492C16.161 9.234 12.449 15 5.665 15c-2.09 0-4.032-.621-5.665-1.699.297.035.583.047.89.047a7.27 7.27 0 004.58-1.618c-1.577-.03-2.963-1.084-3.448-2.625.23.037.463.057.696.059.331 0 .663-.047.97-.13C1.968 8.678.73 7.125.732 5.32v-.047a3.644 3.644 0 001.668.48A3.81 3.81 0 01.754 2.602c0-.703.183-1.347.502-1.91C3.13 3.058 5.895 4.497 8.863 4.652a4.388 4.388 0 01-.092-.867C8.771 1.7 10.416 0 12.461 0c1.062 0 2.021.457 2.695 1.195a7.152 7.152 0 002.342-.914 3.759 3.759 0 01-1.622 2.086A7.257 7.257 0 0018 1.781a8.046 8.046 0 01-1.85 1.957z" fill="currentColor"></path></svg><span class="name-hidden">Twitter</span></a></li>
                <?php elseif ($socialProfile->footer()->bool() && $socialProfile->account()->value() === 'youtube' && ($socialProfile->username()->isNotEmpty() || $socialProfile->url()->isNotEmpty())): ?>
                  <li class="icon-youtube"><a href="<?php if ($socialProfile->username()->isNotEmpty()): ?>https://www.youtube.com/<?= $socialProfile->username() ?><?php else: ?><?= $socialProfile->url() ?><?php endif ?>" target="_blank" rel="noopener noreferrer"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="24" viewBox="0 0 20 16"><path d="M19.582 2.503c-.23-.985-.908-1.761-1.768-2.024C16.254 0 10 0 10 0S3.746 0 2.186.479C1.326.742.648 1.518.418 2.503 0 4.29 0 8.016 0 8.016s0 3.727.418 5.513c.23.985.908 1.729 1.768 1.992C3.746 16 10 16 10 16s6.254 0 7.814-.479c.86-.263 1.538-1.007 1.768-1.992C20 11.743 20 8.016 20 8.016s0-3.726-.418-5.513zM7.5 11.382V4.615l6 3.384-6 3.383z" fill="currentColor"></path></svg><span class="name-hidden">YouTube</span></a></li>
                <?php endif ?>

              <?php endforeach ?>

            </ul>
          <?php endif ?>

          <?php if ($site->footerLanguages()->bool() && $kirby->languages()->count() > 1): ?>
            <ul class="footer-languages">

              <?php $num = 0; foreach($kirby->languages() as $language): ?>

                <?php if ($num == count($kirby->languages()) - 1): ?>
                  <li<?php e($kirby->language() == $language, ' class="active"') ?>><a href="<?= $page->url($language->code()) ?>" hreflang="<?= $language->code() ?>"><?= str::ucfirst($language->code()) ?></a></li>
                <?php else: ?>
                  <li<?php e($kirby->language() == $language, ' class="active"') ?>><a href="<?= $page->url($language->code()) ?>" hreflang="<?= $language->code() ?>"><?= str::ucfirst($language->code()) ?></a></li>
                  <li class="muted"><span>/</span></li>
                <?php endif ?>

              <?php $num++; endforeach ?>

            </ul>
          <?php endif ?>

        </div>
      <?php endif ?>

      <?php

        // Classes

        $class = 'col-2-3 muted';

        if (socialFooter($socialProfiles) || ($site->footerLanguages()->bool() && $kirby->languages()->count() > 1)) {
          $class = $class . ' align-middle align-center--lg align-right';
        }

      ?>
      <div class="<?= $class ?>">

        <?php if ($site->footerCopyright()->value() === 'custom' && $site->footerCopyrightCustom()->isNotEmpty()): ?>
          <p class="footer-copyright"><?= $site->footerCopyrightCustom() ?><?php if ($site->footerPoweredBy()->bool()): ?> Powered by <a href="https://themesforkirby.com/" target="_blank" rel="noopener noreferrer">Themes for Kirby</a>.<?php endif ?></p>
        <?php else: ?>
          <p class="footer-copyright">&copy; <?= date('Y') ?> <a href="<?= $site->url() ?>"><?= $site->title() ?></a>.<?php if ($site->footerPoweredBy()->bool()): ?> Powered by <a href="https://themesforkirby.com/" target="_blank" rel="noopener noreferrer">Themes for Kirby</a>.<?php endif ?></p>
        <?php endif ?>

      </div>
    </div>
  </footer>

<?php $ver = filemtime('assets/build/js/main.min.js'); echo js(['assets/build/js/main.min.js?ver=' . $ver . '', '@auto']); ?>

<script>
  // Make sure to close the mobile menu if the menu is open and you resize the window
  var elem = document.querySelector('.header-main');
  if (elem) {
    window.addEventListener('resize', function() {
      if (window.innerWidth > <?= $site->headerBreakpoint() ?>) {
        document.querySelector('.page').classList.remove('no-scroll');
        document.querySelector('.header-main').classList.remove('active');
      }
    });
  }
</script>

<?php if ($site->codeFooter()->isNotEmpty()): ?>
<?= $site->codeFooter() ?>
<?php endif ?>
<?php if ($page->codeFooter()->isNotEmpty()): ?>
<?= $page->codeFooter() ?>
<?php endif ?>
<?php if ($page->parents()->count() && $page->parent()->codeFooter()->isNotEmpty()): ?>
<?= $page->parent()->codeFooter() ?>
<?php endif ?>

</body>
</html>