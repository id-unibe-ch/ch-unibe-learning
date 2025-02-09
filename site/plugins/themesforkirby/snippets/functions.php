<?php


/*

Add the right background class

*/
function background($background) {
  $class = '';
  $backgroundColor = $background->color()->toStructure()->first();
  $backgroundGradient = $background->gradient()->toStructure()->first();
  $backgroundImage = $background->image()->toStructure()->first();

  // Color
  if (!$backgroundColor || !$backgroundGradient || !$backgroundImage) {
    $class = 'bg-none';
  }

  // Color
  if ($background->type()->value() === 'color' && $backgroundColor) {
    $class = 'bg-color-' . $backgroundColor->fill();
  }

  // Gradient
  elseif ($background->type()->value() === 'gradient' && $backgroundGradient) {
    $class = 'bg-gradient-' . $backgroundGradient->fill();
  }

  // Image with a color overlay
  elseif ($background->type()->value() === 'image' && $backgroundImage && $backgroundImage->overlay()->value() === 'color') {
    $class = 'bg-cover bg-overlay-color-' . $backgroundImage->overlayColorFill();
  }

  // Image with a gradient overlay
  elseif ($background->type()->value() === 'image' && $backgroundImage && $backgroundImage->overlay()->value() === 'gradient') {
    $class = 'bg-cover bg-overlay-gradient-' . $backgroundImage->overlayGradientFill();
  }

  // Border
  if ($background->border()->bool()) {
    $class = $class . ' border';
  } elseif ($background->borderBottom()->bool()) {
    $class = $class . ' border-bottom';
  } elseif ($background->borderTop()->bool()) {
    $class = $class . ' border-top';
  }

  // Shadow
  if ($background->shadow()->isNotEmpty() && $background->shadow()->value() !== 'none') {
    $class = $class . ' shadow-' . $background->shadow();
  }

  return $class;
}


/*

Check if there are social icons in the header or footer

*/
function socialHeader($socialProfiles) {
  foreach ($socialProfiles as $socialProfile) {
    if ($socialProfile->header()->bool()) {
      return true;
    }
  }
}

function socialFooter($socialProfiles) {
  foreach ($socialProfiles as $socialProfile) {
    if ($socialProfile->footer()->bool()) {
      return true;
    }
  }
}


/*

Return twitter username if there is one

*/
function socialTwitter($socialProfiles) {
  foreach ($socialProfiles as $socialProfile) {
    if ($socialProfile->account()->value() === 'twitter' && $socialProfile->username()->isNotEmpty()) {
      return $socialProfile->username();
    }
  }
}


/*

Return date format

*/
function dateFormat($site) {
  if ($site->dateFormat()->isNotEmpty()) {
    return $site->dateFormat();
  } else {
    return 'M d, Y';
  }
}


/*

Return number of posts per page

*/
function postsPerPage($site) {
  if ($site->postsPerPage()->isNotEmpty()) {
    return $site->postsPerPage()->toInt();
  } else {
    return 10;
  }
} ?>