panel.plugin("tfk/block-posts", {
  blocks: {
    posts: {
      computed: {
        empty() {
          if (!this.content.source) {
            return true;
          }
          return false;
        }
      },
      template: `
        <template>
          <div class="k-block-full-width">
            <figure @dblclick="open" v-if="empty" class="k-block-figure">
              <button class="k-block-figure-empty k-block-figure-source k-button" type="button">
                <span aria-hidden="true" class="k-button-icon k-icon k-icon-page">
                  <svg viewBox="0 0 16 16"><use xlink:href="#icon-page"></use></svg>
                </span>
                <span class="k-button-text">Select posts...</span>
              </button>
            </figure>
            <figure @dblclick="open" v-else class="k-block-figure">
              <button class="k-block-figure-empty k-block-figure-source k-button" type="button">
                <span aria-hidden="true" class="k-button-icon k-icon k-icon-page">
                  <svg viewBox="0 0 16 16"><use xlink:href="#icon-page"></use></svg>
                </span>
                <span class="k-button-text">Source: {{ content.source }}</span>
              </button>
            </figure>
          </div>
        </template>
      `
    }
  }
});