panel.plugin("tfk/block-gallery", {
  blocks: {
    gallery: {
      computed: {
        media() {
          if (this.content.media[0]) {
            return this.content.media[0].url;
          }
          return false;
        }
      },
      template: `
        <template>
          <div>
            <ul @dblclick="open" v-if="media">
              <li v-for="media in content.media">
                <img
                  :src="media.url"
                >
              </li>
            </ul>
            <figure @dblclick="open" v-else class="k-block-figure">
              <button class="k-block-figure-empty k-button" type="button">
                <span aria-hidden="true" class="k-button-icon k-icon k-icon-image">
                  <svg viewBox="0 0 16 16"><use xlink:href="#icon-image"></use></svg>
                </span>
                <span class="k-button-text">Select media...</span>
              </button>
            </figure>
          </div>
        </template>
      `
    }
  }
});