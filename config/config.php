use Kirby\Filesystem\F;

return [
  'url' => getenv('KIRBY_URL'),
  'ready' => function($kirbyLicense) {
    $license_file = $kirbyLicense->root('license');
    $license = getenv('KIRBY_LICENSE');

    if ($license && !F::exists($license_file)) {
      F::write($license_file, $license);
    }
  }
];