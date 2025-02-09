panel.plugin("tfk/block-timeline", {
  blocks: {
    timeline: {
      template: `
        <template>
          <div class="k-block-full-width">
            <figure @dblclick="open" class="k-block-figure">
              <button class="k-block-figure-empty k-button" type="button">
                <span aria-hidden="true" class="k-button-icon k-icon k-icon-flag">
                  <svg viewBox="0 0 16 16"><use xlink:href="#icon-flag"></use></svg>
                </span>
                <span class="k-button-text">Timeline</span>
              </button>
            </figure>
          </div>
        </template>
      `
    }
  }
});