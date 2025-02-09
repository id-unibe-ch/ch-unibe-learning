<?php $numRow = 0; foreach ($page->toLayouts() as $row):

  $backgroundRow = $row->background()->toStructure()->first();

  if ($backgroundRow) {
    $backgroundRowClass = background($backgroundRow);
    $backgroundRowSvg = $backgroundRow->svg()->toStructure()->first();
  }

  $numRow = ++$numRow;

?>

  <?php if ($row->visibility()->bool()): ?>

    <?php if ($backgroundRow && in_array($backgroundRow->size()->value(), ['sm', 'md', 'lg'])): ?>

      <?php

        // Classes

        $class = 'display-inline-block full-width padding';

        if ($row->paddingBottom()->bool() === false) {
          $class = $class . ' padding-bottom-none';
        }

        if ($row->paddingTop()->bool() === false) {
          $class = $class . ' padding-top-none';
        }

      ?>
      <div class="<?= $class ?>">
    <?php endif ?>

        <?php

          // Classes

          if ($backgroundRow && $backgroundRowClass) {
            $class = $backgroundRowClass . ' blocks';
          } else {
            $class = 'blocks';
          }

          if (isset($heroBlocks)) {
            $class = $class . ' blocks-hero blocks-' . $numRow;
          } else {
            $class = $class . ' blocks-content blocks-' . $numRow;
          }

          if ($backgroundRow && $backgroundRow->size()->value() === 'full-screen') {
            $class = $class . ' full-screen';
          }

          if (isset($heroBlocks)) {
            $class = $class . ' padding-bottom padding-top';
          } elseif (isset($productBlocks)) {
            $class = $class . ' padding-bottom-15x padding-top-15x';
          } else {
            $class = $class . ' padding';
          }

          if (!isset($productBlocks) && $row->paddingBottom()->bool() === false && !($backgroundRow && in_array($backgroundRow->size()->value(), ['sm', 'md', 'lg']))) {
            $class = $class . ' padding-bottom-none';
          }

          if (!isset($productBlocks) && $row->paddingTop()->bool() === false && !($backgroundRow && in_array($backgroundRow->size()->value(), ['sm', 'md', 'lg']))) {
            $class = $class . ' padding-top-none';
          }

          if ($backgroundRow && in_array($backgroundRow->size()->value(), ['sm', 'md', 'lg'])) {
            $class = $class . ' max-width-' . $backgroundRow->size() . ' rounded';
          }

          if ($row->customClass()->isNotEmpty()) {
            $class = $class . ' ' . $row->customClass();
          }

          if ($backgroundRow && $backgroundRow->brightness()->bool()) {
            $class = $class . ' dark';
          }

        ?>
        <<?php if (isset($heroBlocks) || isset($productBlocks)): ?>div<?php else: ?>section<?php endif ?><?php if ($row->customId()->isNotEmpty()): ?> id="<?= $row->customId() ?>"<?php endif ?> class="<?= $class ?>">

          <?php if ($backgroundRow && $backgroundRowSvg && $backgroundRowSvg->code()->isNotEmpty()): ?>
            <div class="bg-svg bg-svg-position-<?= $backgroundRowSvg->positionHorizontal() ?> bg-svg-position-<?= $backgroundRowSvg->positionVertical() ?>"><?= $backgroundRowSvg->code() ?></div>
          <?php endif ?>

          <div class="row row-gutter-<?= $row->gutter()->or('lg') ?><?php if (in_array($row->oneColumn()->value(), ['sm', 'md'])): ?> row-keep-proportions<?php endif ?> row-one-column--<?= $row->oneColumn()->or('sm') ?><?php if ($row->columnReverse()->bool()): ?> row-reverse<?php endif ?> max-width-lg">

            <?php $numColumn = 0; foreach ($row->columns() as $column): $numColumn = ++$numColumn; ?>

              <?php if ($column->blocks()->isNotEmpty()): ?>

                <?php

                  // Classes

                  if ($column->span() === 12) {
                    $class = '1-1';
                  } elseif ($column->span() === 6) {
                    $class = '1-2';
                  } elseif ($column->span() === 4) {
                    $class = '1-3';
                  } elseif ($column->span() === 3) {
                    $class = '1-4';
                  } elseif ($column->span() === 8) {
                    $class = '2-3';
                  }

                ?>
                <div class="col-<?= $class ?> align-<?= $row->alignVertical() ?>">

                  <?php $numBlock = 0; foreach ($column->blocks() as $block): $numBlock = ++$numBlock; ?>

                    <?php

                      // Classes

                      if ($block->alignContent()->value() === 'center--md') {
                        $class = 'align-center--' . $row->oneColumn()->or('sm');
                      } else {
                        $class = 'align-' . $block->alignContent()->or('left');
                      }

                      $class = $class . ' block-' . $numRow . '-' . $numColumn . '-' . $numBlock . ' block-count-' . $column->blocks()->count() . ' block-type-' . $block->type();

                      if (!in_array($block->type(), ['posts', 'products', 'slider', 'spacer']) && $block->width()->value() !== 'lg') {
                        $class = $class . ' max-width-' . $block->width() . ' max-width-' . $block->alignBlock()->or('center');
                      }

                      if (($backgroundBlock = $block->background()->toStructure()->first()) && background($backgroundBlock)) {
                        $class = $class . ' ' . background($backgroundBlock) . ' card card-content';

                        if ($backgroundBlock->brightness()->bool()) {
                          $class = $class . ' dark';
                        }
                      }

                      if (!in_array($block->type(), ['gallery', 'image', 'imageurl', 'posts', 'slider']) && $animation = $block->animation()->toStructure()->first()) {
                        $class = $class . ' js-animation js-a-type-' . $animation->type() . ' js-scrolled';
                      }

                    ?>
                    <<?php if ($block->type() === 'spacer'): ?>span<?php else: ?>div<?php endif ?> class="<?= $class ?>">

                      <?php if (isset($heroBlocks)): ?>

                        <?php if (isset($srcsetHalf)): ?>
                          <?php snippet('blocks/' . $block->type(), ['block' => $block, 'heroBlocks' => $heroBlocks, 'srcsetHalf' => $srcsetHalf, 'numRow' => $numRow, 'numColumn' => $numColumn, 'numBlock' => $numBlock]) ?>
                        <?php else: ?>
                          <?php snippet('blocks/' . $block->type(), ['block' => $block, 'heroBlocks' => $heroBlocks, 'numRow' => $numRow, 'numColumn' => $numColumn, 'numBlock' => $numBlock]) ?>
                        <?php endif ?>

                      <?php else: ?>

                        <?php if ($column->span() !== 12 || isset($productBlocks)): $srcsetHalf = ''; ?>
                          <?php snippet('blocks/' . $block->type(), ['block' => $block, 'srcsetHalf' => $srcsetHalf, 'numRow' => $numRow, 'numColumn' => $numColumn, 'numBlock' => $numBlock]) ?>
                        <?php else: ?>
                          <?php snippet('blocks/' . $block->type(), ['block' => $block, 'numRow' => $numRow, 'numColumn' => $numColumn, 'numBlock' => $numBlock]) ?>
                        <?php endif ?>

                      <?php endif ?>

                    </<?php if ($block->type() === 'spacer'): ?>span<?php else: ?>div<?php endif ?>>

                  <?php endforeach ?>

                </div>

              <?php endif ?>

            <?php endforeach ?>

          </div>
        </<?php if (isset($heroBlocks) || isset($productBlocks)): ?>div<?php else: ?>section<?php endif ?>>

    <?php if ($backgroundRow && in_array($backgroundRow->size()->value(), ['sm', 'md', 'lg'])): ?>
      </div>
    <?php endif ?>

  <?php endif ?>

<?php endforeach ?>
