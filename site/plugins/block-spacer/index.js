panel.plugin("tfk/block-spacer", {
  blocks: {
    spacer: {
      template: `
        <template>
          <div>
            <figure class="k-block-figure">
              <button class="k-block-figure-empty k-block-figure-source k-button" type="button">
                <span aria-hidden="true" class="k-button-icon k-icon k-icon-expand">
                  <svg viewBox="0 0 16 16"><use xlink:href="#icon-expand"></use></svg>
                </span>
              </button>
            </figure>
          </div>
        </template>
      `
    }
  }
});