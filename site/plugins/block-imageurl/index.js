panel.plugin("tfk/block-imageurl", {
  blocks: {
    imageurl: {
      computed: {
        url() {
          if (this.content.url) {
            return this.content.url;
          }
          return false;
        }
      },
      template: `
        <template>
          <div>
            <div v-if="url" class="k-block-type-imageurl-wrapper">
              <img @dblclick="open"
                :src="url"
              >
            </div>
            <figure @dblclick="open" v-else class="k-block-figure">
              <button class="k-block-figure-empty k-button" type="button">
                <span aria-hidden="true" class="k-button-icon k-icon k-icon-image">
                  <svg viewBox="0 0 16 16"><use xlink:href="#icon-image"></use></svg>
                </span>
                <span class="k-button-text">Link...</span>
              </button>
            </figure>
          </div>
        </template>
      `
    }
  }
});