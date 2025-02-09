panel.plugin("tfk/block-newsletter", {
  blocks: {
    newsletter: {
      template: `
        <template>
          <div class="k-block-full-width">
            <figure @dblclick="open" class="k-block-figure">
              <button class="k-block-figure-empty k-block-figure-source k-button" type="button">
                <span aria-hidden="true" class="k-button-icon k-icon k-icon-email">
                  <svg viewBox="0 0 16 16"><use xlink:href="#icon-email"></use></svg>
                </span>
                <span class="k-button-text">Newsletter</span>
              </button>
            </figure>
          </div>
        </template>
      `
    }
  }
});